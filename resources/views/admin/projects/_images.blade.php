<section class="card" id="photos">
    <div class="card__head">
        <h2><x-icon name="image" :size="18" /> Project photos</h2>
        <span class="muted small">{{ $project->images->count() }} {{ \Illuminate\Support\Str::plural('photo', $project->images->count()) }}</span>
    </div>
    <p class="muted small">These appear as a gallery on the project page. Visitors can click to enlarge them.</p>

    <form action="{{ route('admin.projects.images.store', $project) }}" method="post" enctype="multipart/form-data" class="dropzone" data-dropzone>
        @csrf
        <x-icon name="image" :size="28" />
        <p><strong>Add photos</strong> — choose one or more images (JPG, PNG or WebP, up to 6 MB each).</p>
        <input type="file" name="photos[]" accept="image/*" multiple required data-dropzone-input>
        <button type="submit" class="btn btn--primary btn--sm"><x-icon name="plus" :size="15" /> Upload</button>
    </form>

    @if($project->images->count())
        <div class="photo-grid">
            @foreach($project->images as $img)
                <div class="photo">
                    <div class="photo__img">
                        @if($src = media_url($img->path))
                            <img src="{{ $src }}" alt="" loading="lazy">
                        @else
                            <span class="photo__missing"><x-icon name="image" :size="22" /> Not uploaded yet</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.projects.images.update', [$project, $img]) }}" method="post" class="photo__form">
                        @csrf @method('PATCH')
                        <input type="text" name="caption" value="{{ $img->caption }}" placeholder="Caption (optional)" aria-label="Caption">
                        <input type="number" name="sort_order" value="{{ $img->sort_order }}" aria-label="Order" title="Order" class="photo__order">
                        <button type="submit" class="icon-btn" title="Save" aria-label="Save caption"><x-icon name="check" :size="16" /></button>
                    </form>
                    <form action="{{ route('admin.projects.images.destroy', [$project, $img]) }}" method="post" data-confirm="Remove this photo?" class="photo__del">
                        @csrf @method('DELETE')
                        <button type="submit" class="icon-btn icon-btn--danger" title="Remove" aria-label="Remove photo"><x-icon name="trash" :size="15" /></button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</section>
