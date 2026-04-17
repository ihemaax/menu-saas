<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->tenant;

        if (!$tenant) {
            return redirect()->route('settings.index');
        }

        $categoriesCount = $tenant->categories()->count();
        $productsCount = $tenant->products()->count();

        return view('dashboard', compact('tenant', 'categoriesCount', 'productsCount'));
    }
}