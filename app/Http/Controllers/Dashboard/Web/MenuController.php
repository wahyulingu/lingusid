<?php

namespace App\Http\Controllers\Dashboard\Web;

use App\Actions\Menu\CreateMenuAction;
use App\Actions\Menu\DeleteMenuByIdAction;
use App\Actions\Menu\GetMainNavigationGroupAction;
use App\Actions\Menu\GetMenuByGroupAction;
use App\Actions\Menu\UpdateMenuAction;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(
        GetMainNavigationGroupAction $getMainNavigationGroupAction,
        GetMenuByGroupAction $getMenuByGroupAction)
    {
        return Inertia::render('Dashboard/Web/Menu/Index', [
            'menus' => $getMenuByGroupAction->execute([
                'id' => $getMainNavigationGroupAction->execute()->getKey(),
            ]),
        ]);
    }

    public function store(Request $request, CreateMenuAction $action)
    {
        $action->execute($request->all());

        return redirect()->route('dashboard.web.menu.index');
    }

    public function update(Request $request, Menu $menu, UpdateMenuAction $action)
    {
        $action->execute($request->all(), ['menu' => $menu]);

        return redirect()->route('dashboard.web.menu.index');
    }

    public function show(Menu $menu)
    {
        return Inertia::render('Dashboard/Web/Menu/Show', [
            'menu' => $menu,
        ]);
    }

    public function edit(Menu $menu)
    {
        return Inertia::render('Dashboard/Web/Menu/Edit', [
            'menu' => $menu,
        ]);
    }

    public function destroy(Menu $menu, DeleteMenuByIdAction $action)
    {
        $action->execute(['menu' => $menu]);

        return redirect()->route('dashboard.web.menu.index');
    }
}
