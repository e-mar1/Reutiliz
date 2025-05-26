<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Str;
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

        $items = $query->orderBy('created_at', 'desc')->paginate(12);
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
        $query = Item::with(['user.reports'])->withCount('reports');
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%");
                  });
            });
        }
        $items = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->only('search'));
        return view('admin.annonces', compact('items'));
    }

    /**
     * Show the form for creating a new item (admin).
     */
    public function adminCreate()
    {
        return view('admin.annonces-create');
    }

    /**
     * Store a newly created item in storage (admin).
     */
    public function adminStore(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'is_free' => 'required|in:0,1',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        if ($request->is_free == '0') {
            $rules['price'] = 'required|numeric|min:0';
        }

        $validated = $request->validate($rules);

        if ($request->is_free == '1') {
            $validated['price'] = null;
        } else {
            $validated['price'] = $request->price;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('annonces', 'public');
        }

        Item::create($validated);
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce créée avec succès.');
    }

    /**
     * Show the form for editing the specified item (admin).
     */
    public function adminEdit(Item $item)
    {
        $users = \App\Models\User::all();
        return view('admin.annonces-edit', compact('item', 'users'));
    }

    /**
     * Update the specified item in storage (admin).
     */
    public function adminUpdate(Request $request, Item $item)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'is_free' => 'required|in:0,1',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        if ($request->is_free == '0') {
            $rules['price'] = 'required|numeric|min:0';
        }

        $validated = $request->validate($rules);

        if ($request->is_free == '1') {
            $validated['price'] = null;
        } else {
            $validated['price'] = $request->price;
        }

        if ($request->hasFile('image')) {
            if ($item->image && Storage::exists('public/' . $item->image)) {
                Storage::delete('public/' . $item->image);
            }
            $validated['image'] = $request->file('image')->store('annonces', 'public');
        }

        $item->update($validated);
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce mise à jour avec succès!');
    }

    /**
     * Remove the specified item from storage (admin).
     */
    public function adminDestroy(Item $item)
    {
        if ($item->image && Storage::exists('public/' . $item->image)) {
            Storage::delete('public/' . $item->image);
        }
        $item->delete();
        return redirect()->route('admin.annonces.index')->with('success', 'Annonce supprimée avec succès.');
    }

    /**
     * Display the specified item (admin).
     */
    public function adminShow(Item $item)
    {
        return view('admin.annonces-show', compact('item'));
    }

    /**
     * Show the form for creating a new item (user).
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created item in storage (user).
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_free' => $request->has('is_free') ? true : false
        ]);

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png|max:5120',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string',
            'category' => 'required|string',
            'price' => 'required_if:is_free,0|nullable|numeric|min:0',
            'is_free' => 'boolean'
        ]);

        try {
            if ($request->hasFile('image')) {
                $ext = $request->image->getClientOriginalExtension();
                $name = Str::random(30) . time() . "." . $ext;
                $request->image->move(public_path('storage/items'), basename($name));
                $validated['image'] = $name;
            }

            $validated['user_id'] = auth()->id();

            if ($validated['is_free']) {
                $validated['price'] = 0;
            }

            $item = Item::create($validated);

            return redirect()->route('welcome')
                ->with('success', 'Votre objet a été publié avec succès!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la publication de votre objet.']);
        }
    }

    /**
     * Display the specified item (user).
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified item (user).
     */
    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified item in storage (user).
     */
    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,png|max:5120',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string',
            'category' => 'required|string',
            'price' => 'required_if:is_free,0|nullable|numeric|min:0',
            'is_free' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
            $validated['image'] = $imagePath;
        }

        if ($request->boolean('is_free')) {
            $validated['price'] = 0;
        }

        $item->update($validated);

        return redirect()->route('items.show', $item)
            ->with('success', 'Objet mis à jour avec succès!');
    }

    /**
     * Remove the specified item from storage (user).
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        $item->delete();

        return redirect()->route('welcome')
            ->with('success', 'Objet supprimé avec succès!');
    }
}