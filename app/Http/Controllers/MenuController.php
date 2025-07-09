<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $menus = Category::where('type', 'menu')
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get()
            ->map($this->transformMenu());

        return Inertia::render('Menus/Index', [
            'menus' => $menus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentMenus = Category::where('type', 'menu')->whereNull('parent_id')->orderBy('name')->get();

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
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create([
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
    public function show(Category $menu)
    {
        $this->ensureIsMenu($menu);
        $menu->load('children', 'parent');

        return Inertia::render('Menus/Show', [
            'menu' => $this->transformMenu()->__invoke($menu),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $menu)
    {
        $this->ensureIsMenu($menu);
        $parentMenus = Category::where('type', 'menu')
            ->whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('name')
            ->get();

        return Inertia::render('Menus/Edit', [
            'menu' => $this->transformMenu()->__invoke($menu),
            'parentMenus' => $parentMenus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $menu)
    {
        $this->ensureIsMenu($menu);
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
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
    public function destroy(Category $menu)
    {
        $this->ensureIsMenu($menu);
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil dihapus.');
    }

    /**
     * Abort if the category is not a menu.
     */
    private function ensureIsMenu(Category $category)
    {
        if ($category->type !== 'menu') {
            abort(404);
        }
    }

    /**
     * Get a closure to transform menu category.
     */
    private function transformMenu(): \Closure
    {
        return function (Category $category) {
            $data = json_decode($category->description, true);
            $category->url = $data['url'] ?? null;
            $category->icon = $data['icon'] ?? null;
            if ($category->relationLoaded('children')) {
                $category->children = $category->children->map($this->transformMenu());
            }

            return $category;
        };
    }
}