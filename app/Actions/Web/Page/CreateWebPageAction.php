<?php

namespace App\Actions\Web\Page;

use App\Abstractions\Actions\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Web\WebPage;
use App\Repositories\Web\WebPageRepository;

class CreateWebPageAction extends Action implements RuledActionContract
{
    public function __construct(protected WebPageRepository $webPageRepository) {}

    protected function handler($payload = null, array $validatedPayload = []): WebPage
    {
        return $this->webPageRepository->store([
            'title',
            'slug',
            'content',
        ]);
    }

    public function rules(array $payload): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:web_pages,slug',
            'content' => 'required|string',
        ];
    }
}
