<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Show the form for creating a new report.
     */
    public function create(Request $request)
    {
        // تأكد أن المستخدم مسجل الدخول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour signaler un article.');
        }

        $item = null;
        if ($request->has('item_id')) {
            $item = Item::find($request->item_id);
        }

        return view('reports.create', compact('item'));
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request)
    {
        // تأكد أن المستخدم مسجل الدخول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour signaler un article.');
        }

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'reason' => 'required|string|max:1000',
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'reason' => $request->reason,
            'date' => $request->date
        ]);

        return redirect()->route('welcome', $request->item_id)->with('success', 'Article signalé avec succès.');
    }
}