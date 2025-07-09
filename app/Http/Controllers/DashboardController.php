<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $sidebarMenus = Category::where('type', 'menu')
                            ->whereNull('parent_id')
                            ->with('children')
                            ->orderBy('name')
                            ->get()
                            ->map($this->transformMenu());

        return Inertia::render('Dashboard', [
            'sidebarMenus' => $sidebarMenus,
        ]);
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