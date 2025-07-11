<?php

namespace App\Http\Controllers\Dashboard\Web;

use App\Actions\Menu\CreateMenuAction;
use App\Actions\Menu\DeleteMenuAction;
use App\Actions\Menu\GetMainNavigationGroupAction;
use App\Actions\Menu\UpdateMenuAction;
use App\Actions\Menu\GetMenusAction;
use App\Actions\Menu\GetMenuByIdAction;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    protected $mainNavigationGroup;

    public function __construct(
        protected MenuRepository $menuRepository,
        protected GetMainNavigationGroupAction $getMainNavigationGroupAction
    ) {
        $this->mainNavigationGroup = $this->getMainNavigationGroupAction->handle();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = $this->menuRepository->index(
            filters: ['group_id' => $this->mainNavigationGroup->id, 'parent_id' => null],
            relations: ['children'],
            orderBy: 'order',
            orderDirection: 'asc'
        );

        return Inertia::render('Menus/Index', [
            'menus' => $menus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentMenus = $this->menuRepository->index(
            filters: ['group_id' => $this->mainNavigationGroup->id, 'parent_id' => null],
            orderBy: 'order',
            orderDirection: 'asc'
        );

        return Inertia::render('Menus/Create', [
            'parentMenus' => $parentMenus,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateMenuAction $createMenuAction)
    {
        $data = $request->all();
        $data['group_id'] = $this->mainNavigationGroup->id;
        $createMenuAction->handle($data);

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, GetMenuByIdAction $getMenuByIdAction)
    {
        $menu = $getMenuByIdAction->handler($id);
        $this->ensureIsMainNavigationMenu($menu);
        $menu->load('children', 'parent');

        return Inertia::render('Menus/Show', [
            'menu' => $menu,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $this->ensureIsMainNavigationMenu($menu);
        $parentMenus = $this->menuRepository->index(
            filters: ['group_id' => $this->mainNavigationGroup->id, 'parent_id' => null],
            orderBy: 'order',
            orderDirection: 'asc'
        );

        return Inertia::render('Menus/Edit', [
            'menu' => $menu,
            'parentMenus' => $parentMenus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu, UpdateMenuAction $updateMenuAction)
    {
        $this->ensureIsMainNavigationMenu($menu);
        $data = $request->all();
        $data['group_id'] = $this->mainNavigationGroup->id; // Ensure group_id is set
        $updateMenuAction->handle(['menu' => $menu] + $data);

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu, DeleteMenuAction $deleteMenuAction)
    {
        $this->ensureIsMainNavigationMenu($menu);
        $deleteMenuAction->handle(['menu' => $menu]);

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil dihapus.');
    }

    /**
     * Abort if the menu item does not belong to the main navigation group.
     */
    private function ensureIsMainNavigationMenu(Menu $menu)
    {
        if ($menu->group_id !== $this->mainNavigationGroup->id) {
            abort(404);
        }
    }
}
