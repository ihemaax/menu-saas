<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function show($slug)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();

        $categories = $tenant->categories()->with(['products' => function ($query) {
            $query->where('is_available', true)->orderBy('order');
        }])->orderBy('order')->get();

        $featuredProducts = $tenant->products()->where('is_featured', true)->where('is_available', true)->orderBy('order')->get();

        return view('menu.show', compact('tenant', 'categories', 'featuredProducts'));
    }
}