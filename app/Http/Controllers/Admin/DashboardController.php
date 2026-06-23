<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\QrStat;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin overview metrics and statistics.
     */
    public function index()
    {
        // 1. Cards statistics
        $totalGenerations = QrStat::count();
        $generationsToday = QrStat::whereDate('created_at', today())->count();
        $totalPosts = Post::count();
        $unreadMessages = ContactMessage::where('is_read', false)->count();

        // 2. Recent contact messages
        $recentMessages = ContactMessage::latest()->take(5)->get();

        // 3. Recent QR generations
        $recentGenerations = QrStat::orderBy('created_at', 'desc')->take(5)->get();

        // 4. QR Types Breakdown (Pie Chart Data)
        $typeDistribution = QrStat::select('qr_type', DB::raw('count(*) as total'))
            ->groupBy('qr_type')
            ->orderBy('total', 'desc')
            ->get();

        // 5. Daily QR Generations (Last 10 Days Chart Data)
        // Adjust for SQLite vs MySQL depending on drivers, but standard whereDate works.
        // Grouping by Date
        $dailyStats = QrStat::select(DB::raw('DATE(created_at) as date_label'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(10))
            ->groupBy('date_label')
            ->orderBy('date_label', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalGenerations',
            'generationsToday',
            'totalPosts',
            'unreadMessages',
            'recentMessages',
            'recentGenerations',
            'typeDistribution',
            'dailyStats'
        ));
    }
}
