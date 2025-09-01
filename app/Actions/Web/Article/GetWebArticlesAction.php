<?php

namespace App\Actions\Web\Article;

use App\Abstractions\Actions\Action;
use App\Repositories\Web\WebArticleRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Web\WebArticle;

class GetWebArticlesAction extends Action
{
    public function __construct(protected WebArticleRepository $webArticleRepository) {}

    /**
     * @return Collection<WebArticle>
     */
    public function handler($payload = null, array $validatedPayload = []): Collection
    {
        return $this->webArticleRepository->all();
    }
}