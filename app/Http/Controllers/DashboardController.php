<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $sidebarMenus = Group::where('type', 'menu')
                            ->whereNull('parent_id')
                            ->with('children')
                            ->orderBy('name')
                            ->get()
                            ->map($this->transformGroup());

        return Inertia::render('Dashboard', [
            'sidebarMenus' => $sidebarMenus,
        ]);
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
