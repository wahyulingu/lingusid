<?php

namespace App\Actions\Web\Article;

use App\Abstractions\Actions\Action;
use App\Models\Web\WebArticle;
use App\Repositories\Web\WebArticleRepository;

class GetWebArticleAction extends Action
{
    public function __construct(protected WebArticleRepository $webArticleRepository) {}

    public function handler($payload = null, array $validatedPayload = []): ?WebArticle
    {
        return $this->webArticleRepository->find($payload['id']);
    }
}
