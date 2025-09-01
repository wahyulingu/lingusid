<?php

namespace App\Actions\Web\Page;

use App\Abstractions\Actions\Action;
use App\Models\Web\WebPage;
use App\Repositories\Web\WebPageRepository;

class GetWebPageAction extends Action
{
    public function __construct(protected WebPageRepository $webPageRepository) {}

    public function handler($payload = null, array $validatedPayload = []): ?WebPage
    {
        return $this->webPageRepository->find($payload['id']);
    }
}
