<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Shared create / list / edit / delete screens for the admin dashboard.
 * Each content type extends this and describes its fields and table columns.
 *
 * Field types: text, email, url, number, date, textarea, richtext, image, select,
 * checkbox, list (one item per line), facts (label/value rows), slug, icon.
 */
abstract class ResourceController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;
    protected string $route;            // e.g. "admin.services"
    protected string $title;            // plural, e.g. "Services"
    protected string $singular;         // e.g. "service"
    protected string $icon = 'file';
    protected array $searchable = ['title'];
    protected bool $canCreate = true;
    protected bool $canDelete = true;
    protected ?string $publicRoute = null;   // route name for "View on site"
    protected ?string $filterField = null;   // optional column to filter the list by
    protected array $filterOptions = [];
    protected int $perPage = 25;
    protected ?string $intro = null;         // short help text at the top of the list

    abstract protected function fields(): array;

    abstract protected function columns(): array;

    protected function rules(?Model $item): array
    {
        return [];
    }

    protected function query()
    {
        $q = $this->model::query();

        return method_exists($this->model, 'scopeOrdered') ? $q->ordered() : $q->latest();
    }

    protected function itemTitle(Model $item): string
    {
        return (string) ($item->title ?? $item->name ?? $item->question ?? $item->from_path ?? ('#'.$item->getKey()));
    }

    /** Route parameter value for the current request (works for any parameter name). */
    protected function currentItem(Request $request): Model
    {
        $id = collect($request->route()->parameters())->first();

        if ($id instanceof Model) {
            return $id;
        }
        $key = (new $this->model)->getRouteKeyName();

        return $this->model::where($key, $id)->firstOrFail();
    }

    protected function shared(): array
    {
        return [
            'route' => $this->route,
            'title' => $this->title,
            'singular' => $this->singular,
            'icon' => $this->icon,
            'canCreate' => $this->canCreate,
            'canDelete' => $this->canDelete,
            'publicRoute' => $this->publicRoute,
            'controller' => $this,
        ];
    }

    public function publicUrl(Model $item): ?string
    {
        if (! $this->publicRoute) {
            return null;
        }

        return method_exists($item, 'url') ? $item->url() : null;
    }

    public function index(Request $request)
    {
        $query = $this->query();

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                foreach ($this->searchable as $col) {
                    $q->orWhere($col, 'like', '%'.$search.'%');
                }
            });
        }

        $filter = $request->query('filter');
        if ($this->filterField && $filter !== null && $filter !== '') {
            $query->where($this->filterField, $filter);
        }

        return view('admin.resource.index', $this->shared() + [
            'items' => $query->paginate($this->perPage)->withQueryString(),
            'columns' => $this->columns(),
            'search' => $search,
            'filterField' => $this->filterField,
            'filterOptions' => $this->filterOptions,
            'filter' => $filter,
            'intro' => $this->intro,
        ]);
    }

    public function create()
    {
        abort_unless($this->canCreate, 404);

        return $this->form(new $this->model);
    }

    public function edit(Request $request)
    {
        return $this->form($this->currentItem($request));
    }

    protected function form(Model $item)
    {
        return view('admin.resource.form', $this->shared() + [
            'item' => $item,
            'fields' => $this->fields(),
            'heading' => $item->exists ? 'Edit '.$this->singular : 'Add '.$this->singular,
            'extra' => $this->extraPartial($item),
        ]);
    }

    /** Optional partial shown under the form (e.g. a project's photo gallery). */
    protected function extraPartial(Model $item): ?array
    {
        return null;
    }

    public function store(Request $request)
    {
        abort_unless($this->canCreate, 404);
        $item = new $this->model;
        $this->save($request, $item);

        return redirect()->route($this->route.'.edit', $item)
            ->with('success', ucfirst($this->singular).' created.');
    }

    public function update(Request $request)
    {
        $item = $this->currentItem($request);
        $this->save($request, $item);

        return redirect()->route($this->route.'.edit', $item)
            ->with('success', 'Changes saved.');
    }

    public function destroy(Request $request)
    {
        abort_unless($this->canDelete, 404);
        $item = $this->currentItem($request);

        foreach ($this->fields() as $f) {
            if (($f['type'] ?? '') === 'image') {
                $this->deleteUpload($item->{$f['name']});
            }
        }
        $this->beforeDelete($item);
        $item->delete();

        return redirect()->route($this->route.'.index')
            ->with('success', ucfirst($this->singular).' deleted.');
    }

    protected function beforeDelete(Model $item): void
    {
    }

    protected function save(Request $request, Model $item): void
    {
        $fields = $this->fields();
        $rules = $this->rules($item->exists ? $item : null);

        foreach ($fields as $f) {
            $name = $f['name'];
            if (isset($rules[$name])) {
                continue;
            }
            $r = [! empty($f['required']) ? 'required' : 'nullable'];
            switch ($f['type'] ?? 'text') {
                case 'image':
                    $rules[$name] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:6144'];
                    continue 2;
                case 'email': $r[] = 'email'; $r[] = 'max:190'; break;
                case 'url': $r[] = 'url'; $r[] = 'max:500'; break;
                case 'number': $r[] = 'numeric'; break;
                case 'date': $r[] = 'date'; break;
                case 'checkbox': $rules[$name] = ['nullable']; continue 2;
                case 'list': case 'facts': $rules[$name] = ['nullable']; continue 2;
                case 'select': $r[] = 'in:'.implode(',', array_keys($f['options'] ?? [])); break;
                case 'slug': $r = ['nullable', 'alpha_dash', 'max:190']; break;
                case 'text': case 'icon': $r[] = 'string'; $r[] = 'max:'.($f['max'] ?? 255); break;
                default: $r[] = 'string';
            }
            $rules[$name] = $r;
        }

        $request->validate($rules);

        foreach ($fields as $f) {
            $name = $f['name'];
            $type = $f['type'] ?? 'text';

            switch ($type) {
                case 'checkbox':
                    $item->{$name} = $request->boolean($name);
                    break;
                case 'image':
                    if ($request->boolean($name.'_remove')) {
                        $this->deleteUpload($item->{$name});
                        $item->{$name} = null;
                    }
                    if ($request->hasFile($name)) {
                        $this->deleteUpload($item->{$name});
                        $item->{$name} = $this->storeUpload($request->file($name), $f['folder'] ?? $this->singular);
                    }
                    break;
                case 'list':
                    $lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $request->input($name)))));
                    $item->{$name} = $lines ?: null;
                    break;
                case 'facts':
                    $labels = (array) $request->input($name.'_label', []);
                    $values = (array) $request->input($name.'_value', []);
                    $rows = [];
                    foreach ($labels as $i => $label) {
                        $label = trim((string) $label);
                        $value = trim((string) ($values[$i] ?? ''));
                        if ($label !== '' && $value !== '') {
                            $rows[] = ['label' => $label, 'value' => $value];
                        }
                    }
                    $item->{$name} = $rows ?: null;
                    break;
                case 'richtext':
                    $item->{$name} = clean_html($request->input($name));
                    break;
                case 'slug':
                    $source = $f['from'] ?? 'title';
                    $slug = Str::slug($request->input($name) ?: $request->input($source));
                    $item->{$name} = $this->uniqueSlug($slug ?: Str::random(6), $name, $item);
                    break;
                case 'number':
                    $item->{$name} = $request->filled($name) ? $request->input($name) : ($f['default'] ?? null);
                    break;
                default:
                    $item->{$name} = $request->input($name);
            }
        }

        $this->beforeSave($request, $item);
        $item->save();
        $this->afterSave($request, $item);
    }

    protected function beforeSave(Request $request, Model $item): void
    {
    }

    protected function afterSave(Request $request, Model $item): void
    {
    }

    protected function uniqueSlug(string $slug, string $column, Model $item): string
    {
        $base = $slug;
        $i = 2;
        while ($this->model::where($column, $slug)->when($item->exists, fn ($q) => $q->whereKeyNot($item->getKey()))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /** Saves an upload into /public/uploads/{folder} and returns the relative path. */
    protected function storeUpload($file, string $folder): string
    {
        $folder = 'uploads/'.trim(Str::slug($folder, '-'), '/');
        $dir = public_path($folder);
        File::ensureDirectoryExists($dir);

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image';
        $name = Str::limit($name, 60, '').'-'.Str::lower(Str::random(6)).'.'.strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $file->move($dir, $name);

        return $folder.'/'.$name;
    }

    protected function deleteUpload(?string $path): void
    {
        if ($path && Str::startsWith($path, 'uploads/') && ! Str::contains($path, '..')) {
            File::delete(public_path($path));
        }
    }
}
