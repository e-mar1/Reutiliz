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

    /**
     * Display a listing of the items for admin.
     */
    public function adminIndex(Request $request)
    {
        $query = Item::with('user')->orderBy('created_at', 'desc');
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%");
                  });
            });
        }
        $items = $query->paginate(20)->appends($request->only('search'));
        return view('admin.annonces', compact('items'));
    }

    /**
     * Show the form for creating a new item (annonce).
     */
    public function create()
    {
        return view('admin.annonces-create');
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'city' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            // Add other fields as needed
        ]);
        Item::create($validated);
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce créée avec succès.');
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Item $item)
    {
        return view('admin.annonces-edit', compact('item'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'city' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            // Add other fields as needed
        ]);
        $item->update($validated);
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce mise à jour avec succès.');
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce supprimée avec succès.');
    }

    /**
     * Display the specified item.
     */
    public function show(Item $item)
    {
        return view('admin.annonces-show', compact('item'));
    }
}