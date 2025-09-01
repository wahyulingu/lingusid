<?php

namespace App\Http\Controllers\Web;

use App\Actions\Web\Article\CreateWebArticleAction;
use App\Actions\Web\Article\DeleteWebArticleAction;
use App\Actions\Web\Article\GetWebArticlesAction;
use App\Actions\Web\Article\GetWebArticleAction;
use App\Actions\Web\Article\UpdateWebArticleAction;
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

    public function create()
    {
        return Inertia::render('Web/Articles/Create');
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
        $article = $updateWebArticleAction->handle($id, $request->except('group_id'));

        if ($request->has('group_id')) {
            $article->groups()->sync($request->input('group_id'));
        }

        return redirect()->route('dashboard.web.articles.index');
    }

    public function destroy($id, DeleteWebArticleAction $deleteWebArticleAction)
    {
        $deleteWebArticleAction->handle($id);

        return redirect()->route('dashboard.web.articles.index');
    }
}
');
    }
}
