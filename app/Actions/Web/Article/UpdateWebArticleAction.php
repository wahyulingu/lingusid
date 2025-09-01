<?php

namespace App\Actions\Web\Article;

use App\Abstractions\Actions\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Web\WebArticle;
use App\Repositories\Web\WebArticleRepository;
use App\Repositories\GroupRepository;

class UpdateWebArticleAction extends Action implements RuledActionContract
{
    public function __construct(protected WebArticleRepository $webArticleRepository, protected GroupRepository $groupRepository) {}

    protected function handler($payload = null, array $validatedPayload = []): WebArticle
    {
        $article = $this->webArticleRepository->update($validatedPayload['id'], [
            'title' => $validatedPayload['title'],
            'slug' => $validatedPayload['slug'],
            'content' => $validatedPayload['content'],
            'published_at' => $validatedPayload['published_at'] ?? null,
            'author_id' => $validatedPayload['author_id'],
        ]);

        if (isset($validatedPayload['group_id'])) {
            $article->groups()->sync($validatedPayload['group_id']);
        }

        return $article;
    }

    public function rules(array $payload): array
    {
        return [
            'id' => 'required|exists:web_articles,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:web_articles,slug,' . $payload['id'],
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'author_id' => 'required|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
        ];
    }
}
