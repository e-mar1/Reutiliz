<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Report;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Order;

class DatabaseSeeder extends Seeder{
    public function run(): void
    {
        // Créer 10 utilisateurs
        User::factory(10)->create();

        // Créer 20 items
        Item::factory(20)->create();

        // Créer 10 rapports
        Report::factory(10)->create();

        // Créer 20 favoris
        Favorite::factory(20)->create();

        // Créer 15 commentaires
        Comment::factory(15)->create();

        // Créer 10 ordres
        Order::factory(10)->create();
    }
}
