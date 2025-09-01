<?php

namespace App\Actions\Web\Article;

use App\Abstractions\Actions\Action;
use App\Models\Web\WebArticle;
use App\Repositories\Web\WebArticleRepository;
use Illuminate\Database\Eloquent\Collection;

class GetWebArticlesAction extends Action
{
    public function __construct(protected WebArticleRepository $webArticleRepository) {}

    /**
     * @return Collection<WebArticle>
     */
    public function handler($payload = [], array $validatedPayload = []): Collection
    {
        return $this->webArticleRepository->with(['author', 'groups'])->get();
    }
}
