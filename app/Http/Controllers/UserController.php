<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Order;

class UserController extends Controller
{
    /**
     * Get items (annonces) for a specific user.
     */
    public function getUserAnnonces(User $user)
    {
        // Assuming 'items' is the relationship defined in the User model
        // And selecting only title, price, and image
        return $user->items()->select('title', 'price', 'image')->get();
    }

    /**
     * Get favorite items for a specific user.
     */
    public function getUserFavorites(User $user)
    {
        // Assuming 'favorites' is the relationship defined in the User model
        // And this relationship returns a collection of Item models through the favorites table
        return $user->favorites()->with('item')->get()->pluck('item');
    }

    /**
     * Get orders for a specific user.
     */
    public function getUserOrders(User $user)
    {
        // Assuming 'orders' is the relationship defined in the User model
        return $user->orders()->get();
    }

    /**
     * Display a listing of the users for admin.
     */
    public function adminIndex(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }
        $users = $query->paginate(20)->appends($request->only('search'));
        return view('admin.users', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users-create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Add other fields as needed
        ]);
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users-edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
            // Add other fields as needed
        ]);
        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users-show', compact('user'));
    }
}
