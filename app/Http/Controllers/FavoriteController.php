<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the user's favorites.
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('item')->get();
        return view('user.favorites', compact('favorites'));
    }

    /**
     * Toggle favorite status for an item.
     */
    public function toggle(Request $request, $itemId)
    {
        $user = Auth::user();
        $item = Item::findOrFail($itemId);
        
        $favorite = Favorite::where('user_id', $user->id)
                           ->where('item_id', $itemId)
                           ->first();
        
        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            $status = 'removed';
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => $user->id,
                'item_id' => $itemId
            ]);
            $status = 'added';
        }
        
        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'item_id' => $itemId
            ]);
        }
        
        return redirect()->back()->with('success', $status === 'added' ? 'Ajouté aux favoris' : 'Retiré des favoris');
    }
}