<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::query();

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by city
        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }

        // Filter by price
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(12); // 12 items per page
        $cities = Item::select('city')->distinct()->pluck('city');
        $popularCategories = Item::select('category')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(6)
            ->pluck('category');

        return view('welcome', compact('items', 'cities', 'popularCategories'));
    }

    public function category($category)
    {
        $items = Item::where('category', $category)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        $cities = Item::select('city')->distinct()->pluck('city');
        $popularCategories = Item::select('category')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(6)
            ->pluck('category');
        return view('welcome', [
            'items' => $items,
            'cities' => $cities,
            'popularCategories' => $popularCategories,
            'currentCategory' => $category
        ]);
    }
}