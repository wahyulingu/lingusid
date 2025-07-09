<?php

namespace App\Http\Controllers;

use App\Actions\MenuItem\CreateMenuItemAction;
use App\Actions\MenuItem\DeleteMenuItemAction;
use App\Actions\MenuItem\UpdateMenuItemAction;
use App\Models\Group;
use App\Models\MenuItem;
use App\Repositories\GroupRepository;
use App\Repositories\MenuItemRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    protected Group $mainNavigationGroup;

    public function __construct(
        protected GroupRepository $groupRepository,
        protected MenuItemRepository $menuItemRepository
    ) {
        $this->mainNavigationGroup = $this->groupRepository->index(
            filters: ['type' => 'menu_container', 'name' => 'Main Navigation']
        )->first();

        if (! $this->mainNavigationGroup) {
            // Handle case where main navigation group doesn't exist
            // For now, we'll just create it, or throw an error
            $this->mainNavigationGroup = $this->groupRepository->store([
                'name' => 'Main Navigation',
                'slug' => 'main-navigation',
                'type' => 'menu_container',
                'description' => 'This group holds the main navigation menu items.',
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = $this->menuItemRepository->index(
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
        $parentMenus = $this->menuItemRepository->index(
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
    public function store(Request $request, CreateMenuItemAction $createMenuItemAction)
    {
        $data = $request->all();
        $data['group_id'] = $this->mainNavigationGroup->id;
        $createMenuItemAction->handle($data);

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuItem $menu)
    {
        $this->ensureIsMainNavigationMenuItem($menu);
        $menu->load('children', 'parent');

        return Inertia::render('Menus/Show', [
            'menu' => $menu,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menu)
    {
        $this->ensureIsMainNavigationMenuItem($menu);
        $parentMenus = $this->menuItemRepository->index(
            filters: ['group_id' => $this->mainNavigationGroup->id, 'parent_id' => null, 'exclude' => ['id' => $menu->id]],
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
    public function update(Request $request, MenuItem $menu, UpdateMenuItemAction $updateMenuItemAction)
    {
        $this->ensureIsMainNavigationMenuItem($menu);
        $data = $request->all();
        $data['group_id'] = $this->mainNavigationGroup->id; // Ensure group_id is set
        $updateMenuItemAction->handle($menu, $data);

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menu, DeleteMenuItemAction $deleteMenuItemAction)
    {
        $this->ensureIsMainNavigationMenuItem($menu);
        $deleteMenuItemAction->handle($menu);

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil dihapus.');
    }

    /**
     * Abort if the menu item does not belong to the main navigation group.
     */
    private function ensureIsMainNavigationMenuItem(MenuItem $menuItem)
    {
        if ($menuItem->group_id !== $this->mainNavigationGroup->id) {
            abort(404);
        }
    }
}
