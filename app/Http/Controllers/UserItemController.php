<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class UserItemController extends Controller
{
    public function publier(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            return view('admin.annonces-create');
        }
        // POST: handle form submission
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'city' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'is_free' => 'required|in:0,1',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
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
        return redirect()->route('dashboard')->with('success', 'Annonce publiée avec succès.');
    }

    public function userAnnonces()
    {
        $items = Item::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('user.annonces', compact('items'));
    }
}
