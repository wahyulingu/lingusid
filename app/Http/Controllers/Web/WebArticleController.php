<?php

namespace App\Http\Controllers\Web;

use App\Actions\Web\Article\CreateWebArticleAction;
use App\Actions\Web\Article\DeleteWebArticleAction;
use App\Actions\Web\Article\GetWebArticlesAction;
use App\Actions\Web\Article\GetWebArticleAction;
use App\Actions\Web\Article\UpdateWebArticleAction;
use App\Actions\Group\EnsureSystemGroupExistsAction;
use App\Enums\System\GroupEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WebArticleController extends Controller
{
    public function index(Request $request, GetWebArticlesAction $getWebArticlesAction)
    {
        $articles = $getWebArticlesAction->handle($request->all());

        return Inertia::render('Web/Articles/Index', [
            'articles' => $articles,
        ]);
    }

    public function create(EnsureSystemGroupExistsAction $ensureSystemGroupExistsAction)
    {
        $categoryGroup = $ensureSystemGroupExistsAction->handle(GroupEnum::CONTENT_ARTICLE_CATEGORY->value);

        return Inertia::render('Web/Articles/Create', [
            'groups' => $categoryGroup->children,
        ]);
    }

    public function store(Request $request, CreateWebArticleAction $createWebArticleAction)
    {
        $createWebArticleAction->handle($request->all());

        return redirect()->route('dashboard.web.articles.index');
    }

    public function show($id, GetWebArticleAction $getWebArticleAction)
    {
        $article = $getWebArticleAction->handle($id);

        return Inertia::render('Web/Articles/Show', [
            'article' => $article,
        ]);
    }

    public function edit($id, GetWebArticleAction $getWebArticleAction, EnsureSystemGroupExistsAction $ensureSystemGroupExistsAction)
    {
        $article = $getWebArticleAction->handle($id);
        $categoryGroup = $ensureSystemGroupExistsAction->handle(GroupEnum::CONTENT_ARTICLE_CATEGORY->value);

        return Inertia::render('Web/Articles/Edit', [
            'article' => $article,
            'groups' => $categoryGroup->children,
        ]);
    }

    public function update(Request $request, $id, UpdateWebArticleAction $updateWebArticleAction)
    {
        $updateWebArticleAction->handle($id, $request->all());

        return redirect()->route('dashboard.web.articles.index');
    }

    public function destroy($id, DeleteWebArticleAction $deleteWebArticleAction)
    {
        $deleteWebArticleAction->handle($id);

        return redirect()->route('dashboard.web.articles.index');
    }
}