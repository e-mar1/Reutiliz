<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $itemId)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $item = Item::findOrFail($itemId);

        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'created_at' => now(),
        ]);

        return redirect()->route('items.show', $item->id)->with('success', 'Commentaire ajouté avec succès.');
    }
}
