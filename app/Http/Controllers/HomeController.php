<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\Report;
use App\Models\Comment;
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

        // Chart data for comments (now using Comment model)
        $commentsByDay = Comment::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')->orderBy('date')->get();
        $commentsByMonth = Comment::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')->orderBy('month')->get();
        $commentsByYear = Comment::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as count'))
            ->groupBy('year')->orderBy('year')->get();

        // Chart data for reports
        $reportsByDay = Report::select(DB::raw('DATE(date) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')->orderBy('date')->get();
        $reportsByMonth = Report::select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')->orderBy('month')->get();
        $reportsByYear = Report::select(DB::raw('YEAR(date) as year'), DB::raw('count(*) as count'))
            ->groupBy('year')->orderBy('year')->get();
        $reportsCount = Report::count();
        $newReportsCount = Report::whereDate('date', now()->toDateString())->count();

        // Existing dashboard data
        $usersCount = User::count();
        $annoncesCount = Item::count();
        $commentsCount = Comment::count();
        $recentActivities = [];
        $recentAnnonces = Item::orderBy('created_at', 'desc')->take(5)->get();
        $recentComments = Comment::with('user', 'item')->orderBy('created_at', 'desc')->take(5)->get();
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'usersCount', 'annoncesCount', 'commentsCount', 'recentActivities',
            'usersByDay', 'usersByMonth', 'usersByYear',
            'itemsByDay', 'itemsByMonth', 'itemsByYear',
            'commentsByDay', 'commentsByMonth', 'commentsByYear',
            'reportsByDay', 'reportsByMonth', 'reportsByYear', 'reportsCount', 'newReportsCount',
            'recentAnnonces', 'recentComments', 'recentUsers'
        ));
    }

    public function users()
    {
        return view('admin.users');
    }
}
