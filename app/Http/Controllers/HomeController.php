<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Chart data for users
        $usersByDay = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')->orderBy('date')->get();
        $usersByMonth = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')->orderBy('month')->get();
        $usersByYear = User::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as count'))
            ->groupBy('year')->orderBy('year')->get();

        // Chart data for items (annonces)
        $itemsByDay = Item::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')->orderBy('date')->get();
        $itemsByMonth = Item::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')->orderBy('month')->get();
        $itemsByYear = Item::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as count'))
            ->groupBy('year')->orderBy('year')->get();

        // Chart data for orders (commandes)
        $ordersByDay = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')->orderBy('date')->get();
        $ordersByMonth = Order::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')->orderBy('month')->get();
        $ordersByYear = Order::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as count'))
            ->groupBy('year')->orderBy('year')->get();

        // Existing dashboard data
        $usersCount = User::count();
        $annoncesCount = Item::count();
        $ordersCount = Order::count();
        $recentActivities = [];

        return view('admin.dashboard', compact(
            'usersCount', 'annoncesCount', 'ordersCount', 'recentActivities',
            'usersByDay', 'usersByMonth', 'usersByYear',
            'itemsByDay', 'itemsByMonth', 'itemsByYear',
            'ordersByDay', 'ordersByMonth', 'ordersByYear'
        ));
    }

    public function users()
    {
        return view('admin.users');
    }
}
