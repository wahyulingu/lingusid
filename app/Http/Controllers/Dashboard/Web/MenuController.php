<?php

namespace App\Http\Controllers\Dashboard\Web;

use App\Actions\Menu\CreateMenuAction;
use App\Actions\Menu\DeleteMenuAction;
use App\Actions\Menu\GetMenuByCategoryAction;
use App\Actions\Menu\UpdateMenuAction;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(GetMenuByCategoryAction $action)
    {
        return Inertia::render('Dashboard/Web/Menu/Index', [
            'menus' => $action->execute(),
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

    public function destroy(Menu $menu, DeleteMenuAction $action)
    {
        $action->execute(['menu' => $menu]);

        return redirect()->route('dashboard.web.menu.index');
    }
}
