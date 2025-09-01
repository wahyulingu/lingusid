<?php

namespace App\Http\Controllers\Web;

use App\Actions\Group\CreateGroupAction;
use App\Actions\Group\DeleteGroupAction;
use App\Actions\Group\EnsureSystemGroupExistsAction;
use App\Actions\Group\GetGroupAction;
use App\Actions\Group\GetGroupsAction;
use App\Actions\Group\UpdateGroupAction;
use App\Enums\System\GroupEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleCategoryController extends Controller
{
    public function index(Request $request, GetGroupsAction $getGroupsAction, EnsureSystemGroupExistsAction $ensureSystemGroupExistsAction)
    {
        $categoryGroup = $ensureSystemGroupExistsAction->handle(GroupEnum::CONTENT_ARTICLE_CATEGORY->value);
        $categories = $getGroupsAction->handle(['parent_id' => $categoryGroup->id]);

        return Inertia::render('Web/ArticleCategories/Index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return Inertia::render('Web/ArticleCategories/Create');
    }

    public function store(Request $request, CreateGroupAction $createGroupAction, EnsureSystemGroupExistsAction $ensureSystemGroupExistsAction)
    {
        $categoryGroup = $ensureSystemGroupExistsAction->handle(GroupEnum::CONTENT_ARTICLE_CATEGORY->value);
        $payload = $request->all();

        $group = $createGroupAction->handle($payload);
        $categoryGroup->groups()->attach($group->id);

        return redirect()->route('dashboard.web.article-categories.index');
    }

    public function show($id, GetGroupAction $getGroupAction)
    {
        $category = $getGroupAction->handle($id);

        return Inertia::render('Web/ArticleCategories/Show', [
            'category' => $category,
        ]);
    }

    public function edit($id, GetGroupAction $getGroupAction)
    {
        $category = $getGroupAction->handle($id);

        return Inertia::render('Web/ArticleCategories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id, UpdateGroupAction $updateGroupAction)
    {
        $updateGroupAction->handle($id, $request->all());

        return redirect()->route('dashboard.web.article-categories.index');
    }

    public function destroy($id, DeleteGroupAction $deleteGroupAction)
    {
        $deleteGroupAction->handle($id);

        return redirect()->route('dashboard.web.article-categories.index');
    }
}
