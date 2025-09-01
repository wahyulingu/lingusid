<?php

namespace App\Actions\Web\Article;

use App\Abstractions\Actions\Action;
use App\Contracts\Action\RuledActionContract;
use App\Repositories\Web\WebArticleRepository;
use Illuminate\Validation\Rule;

class DeleteWebArticleAction extends Action implements RuledActionContract
{
    public function rules($payload = []): array
    {
        return [
            'id' => ['required', 'integer', Rule::exists('web_articles', 'id')],
        ];
    }

    public function __construct(protected WebArticleRepository $webArticleRepository) {}

    protected function handler($payload = null, array $validatedPayload = []): bool
    {
        return $this->webArticleRepository->delete($validatedPayload['id']);
    }
}