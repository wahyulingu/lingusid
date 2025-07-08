<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $sidebarMenus = Menu::whereNull('parent_id')
                            ->with('children')
                            ->orderBy('order')
                            ->get();

        return Inertia::render('Dashboard', [
            'sidebarMenus' => $sidebarMenus,
        ]);
    }
}
