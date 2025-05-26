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

        $items = $query->orderBy('created_at', 'desc')->paginate(12);
        $cities = Item::select('city')->distinct()->pluck('city');

        return view('welcome', compact('items', 'cities'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        // Convert is_free checkbox value to boolean
        $request->merge([
            'is_free' => $request->has('is_free') ? true : false
        ]);

        // Validation des données avec messages personnalisés
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
            // Gestion de l'image
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('items', 'public');
                $validated['image'] = $imagePath;
            }
    
            // Ajout de l'ID utilisateur
            $validated['user_id'] = auth()->id();
            
            // Si gratuit, prix = 0
            if ($validated['is_free']) {
                $validated['price'] = 0;
            }
    
            // Création de l'item
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
     * Display the specified item.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified item in storage.
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
     * Remove the specified item from storage.
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        $item->delete();

        return redirect()->route('welcome')
            ->with('success', 'Objet supprimé avec succès!');
    }
}
