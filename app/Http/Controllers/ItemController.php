<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('welcome', compact('items', 'cities'));
    }

    public function show($id)
        {
             $item = Item::findOrFail($id);
             
             return view('components.show-details', compact('item'));
     } 

     public function toggleFavorite(Item $item)
    {
        // تأكد أن المستخدم مسجل الدخول
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Veuillez vous connecter pour ajouter aux favoris.');
        }

        $user = Auth::user();

        // Check if the item is already favorited by the user
        if ($user->favorites->contains($item->id)) {
            $user->favorites()->detach($item->id); // Remove from favorites
            return redirect()->back()->with('success', 'Article retiré de vos favoris.');
        } else {
            $user->favorites()->attach($item->id); // Add to favorites
            return redirect()->back()->with('success', 'Article ajouté à vos favoris.');
        }
    }
}