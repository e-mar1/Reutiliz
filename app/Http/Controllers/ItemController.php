<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // Base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'is_free' => 'required|in:0,1',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        // Add price validation only if not free
        if ($request->is_free == '0') {
            $rules['price'] = 'required|numeric|min:0';
        }

        $validated = $request->validate($rules);

        // Handle price based on is_free
        if ($request->is_free == '1') {
            $validated['price'] = null; // Set to null for free items
        } else {
            $validated['price'] = $request->price;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('annonces', 'public');
        }

        Item::create($validated);
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce créée avec succès.');
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Item $item)
    {
        $users = \App\Models\User::all();
        return view('admin.annonces-edit', compact('item', 'users'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, Item $item)
    {
        // Base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'is_free' => 'required|in:0,1',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        // Add price validation only if not free
        if ($request->is_free == '0') {
            $rules['price'] = 'required|numeric|min:0';
        }

        $validated = $request->validate($rules);

        // Handle price based on is_free
        if ($request->is_free == '1') {
            $validated['price'] = null; // Set to null for free items
        } else {
            $validated['price'] = $request->price;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image && Storage::exists('public/' . $item->image)) {
                Storage::delete('public/' . $item->image);
            }
            
            // Store new image
            $validated['image'] = $request->file('image')->store('annonces', 'public');
        }

        // Update the announcement
        $item->update($validated);

        return redirect()->route('admin.annonces.index')->with('success', 'Annonce mise à jour avec succès!');
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Item $item)
    {
        // Delete associated image if exists
        if ($item->image && Storage::exists('public/' . $item->image)) {
            Storage::delete('public/' . $item->image);
        }
        
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