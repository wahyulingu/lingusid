<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Menu;
=======
use App\Actions\Menu\CreateMenuAction;
use App\Actions\Menu\DeleteMenuAction;
use App\Actions\Menu\UpdateMenuAction;
use App\Models\Group;
use App\Models\Menu;
use App\Repositories\GroupRepository;
use App\Repositories\MenuRepository;
>>>>>>> feature/reusable-groups
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
<<<<<<< HEAD
=======
    protected Group $mainNavigationGroup;

    public function __construct(
        protected GroupRepository $groupRepository,
        protected MenuRepository $menuRepository
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

>>>>>>> feature/reusable-groups
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
<<<<<<< HEAD
        $menus = Menu::whereNull('parent_id')->with('children')->orderBy('order')->get();
=======
        $menus = $this->menuRepository->index(
            filters: ['group_id' => $this->mainNavigationGroup->id, 'parent_id' => null],
            relations: ['children'],
            orderBy: 'order',
            orderDirection: 'asc'
        );

>>>>>>> feature/reusable-groups
        return Inertia::render('Menus/Index', [
            'menus' => $menus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
<<<<<<< HEAD
        $parentMenus = Menu::whereNull('parent_id')->orderBy('name')->get();
=======
        $parentMenus = $this->menuRepository->index(
            filters: ['group_id' => $this->mainNavigationGroup->id, 'parent_id' => null],
            orderBy: 'order',
            orderDirection: 'asc'
        );

>>>>>>> feature/reusable-groups
        return Inertia::render('Menus/Create', [
            'parentMenus' => $parentMenus,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'required|integer',
            'parent_id' => 'nullable|exists:menus,id',
        ]);

        Menu::create($request->all());
=======
    public function store(Request $request, CreateMenuAction $createMenuAction)
    {
        $data = $request->all();
        $data['group_id'] = $this->mainNavigationGroup->id;
        $createMenuAction->handle($data);
>>>>>>> feature/reusable-groups

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
<<<<<<< HEAD
        $menu->load('children', 'parent');
=======
        $this->ensureIsMainNavigationMenu($menu);
        $menu->load('children', 'parent');

>>>>>>> feature/reusable-groups
        return Inertia::render('Menus/Show', [
            'menu' => $menu,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
<<<<<<< HEAD
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('name')->get();
=======
        $this->ensureIsMainNavigationMenu($menu);
        $parentMenus = $this->menuRepository->index(
            filters: ['group_id' => $this->mainNavigationGroup->id, 'parent_id' => null, 'exclude' => ['id' => $menu->id]],
            orderBy: 'order',
            orderDirection: 'asc'
        );

>>>>>>> feature/reusable-groups
        return Inertia::render('Menus/Edit', [
            'menu' => $menu,
            'parentMenus' => $parentMenus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'required|integer',
            'parent_id' => 'nullable|exists:menus,id',
        ]);

        $menu->update($request->all());
=======
    public function update(Request $request, Menu $menu, UpdateMenuAction $updateMenuAction)
    {
        $this->ensureIsMainNavigationMenu($menu);
        $data = $request->all();
        $data['group_id'] = $this->mainNavigationGroup->id; // Ensure group_id is set
        $updateMenuAction->handle($menu, $data);
>>>>>>> feature/reusable-groups

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
<<<<<<< HEAD
    public function destroy(Menu $menu)
    {
        $menu->delete();
=======
    public function destroy(Menu $menu, DeleteMenuAction $deleteMenuAction)
    {
        $this->ensureIsMainNavigationMenu($menu);
        $deleteMenuAction->handle($menu);
>>>>>>> feature/reusable-groups

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil dihapus.');
    }
<<<<<<< HEAD
}
=======

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
>>>>>>> feature/reusable-groups
