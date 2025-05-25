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
}
