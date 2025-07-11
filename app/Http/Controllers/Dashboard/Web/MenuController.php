<?php

namespace App\Http\Controllers\Dashboard\Web;

use App\Actions\Menu\GetMenuAction;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetMenuAction $getMenu): Response
    {
        return Inertia::render('Dashboard/Web/Menu/Index', [
            'menus' => $getMenu->handle(),
        ]);
    }
}
