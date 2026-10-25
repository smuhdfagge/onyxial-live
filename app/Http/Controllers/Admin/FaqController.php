<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;

class FaqController extends ResourceController
{
    protected string $model = Faq::class;
    protected string $route = 'admin.faqs';
    protected string $title = 'FAQs';
    protected string $singular = 'question';
    protected string $icon = 'help';
    protected array $searchable = ['question', 'answer'];

    protected function fields(): array
    {
        return [
            ['name' => 'question', 'label' => 'Question', 'type' => 'text', 'required' => true],
            ['name' => 'answer', 'label' => 'Answer', 'type' => 'richtext', 'required' => true],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'default' => 0, 'section' => 'side'],
            ['name' => 'is_published', 'label' => 'Show on website', 'type' => 'checkbox', 'section' => 'side', 'default' => true],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'sort_order', 'label' => '#'],
            ['key' => 'question', 'label' => 'Question', 'type' => 'title'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
