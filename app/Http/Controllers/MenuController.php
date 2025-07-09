<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Group::where('type', 'menu')
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get()
            ->map($this->transformGroup());

        return Inertia::render('Menus/Index', [
            'menus' => $menus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentMenus = Group::where('type', 'menu')->whereNull('parent_id')->orderBy('name')->get();

        return Inertia::render('Menus/Create', [
            'parentMenus' => $parentMenus,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:groups,id',
        ]);

        Group::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => 'menu',
            'description' => json_encode(['url' => $request->url, 'icon' => $request->icon]),
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $menu)
    {
        $this->ensureIsMenu($menu);
        $menu->load('children', 'parent');

        return Inertia::render('Menus/Show', [
            'menu' => $this->transformGroup()->__invoke($menu),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $menu)
    {
        $this->ensureIsMenu($menu);
        $parentMenus = Group::where('type', 'menu')
            ->whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('name')
            ->get();

        return Inertia::render('Menus/Edit', [
            'menu' => $this->transformGroup()->__invoke($menu),
            'parentMenus' => $parentMenus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $menu)
    {
        $this->ensureIsMenu($menu);
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:groups,id',
        ]);

        $menu->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => json_encode(['url' => $request->url, 'icon' => $request->icon]),
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $menu)
    {
        $this->ensureIsMenu($menu);
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil dihapus.');
    }

    /**
     * Abort if the group is not a menu.
     */
    private function ensureIsMenu(Group $group)
    {
        if ($group->type !== 'menu') {
            abort(404);
        }
    }

    /**
     * Get a closure to transform menu group.
     */
    private function transformGroup(): \Closure
    {
        return function (Group $group) {
            $data = json_decode($group->description, true);
            $group->url = $data['url'] ?? null;
            $group->icon = $data['icon'] ?? null;
            if ($group->relationLoaded('children')) {
                $group->children = $group->children->map($this->transformGroup());
            }

            return $group;
        };
    }
}
