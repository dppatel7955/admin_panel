<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\User;
use Carbon\Carbon;

#[Layout('livewire.layout.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();
        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisMonthEnd   = Carbon::now()->endOfMonth();

        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd   = Carbon::now()->subMonth()->endOfMonth();

        /* ================= USERS ================= */
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();

        /* ================= GROWTH ================= */
        $usersThisMonth = User::whereBetween('created_at', [
                $thisMonthStart,
                $thisMonthEnd
            ])->count();

        $usersLastMonth = User::whereBetween('created_at', [
                $lastMonthStart,
                $lastMonthEnd
            ])->count();
        
        $userGrowth = $usersLastMonth > 0
            ? round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100, 1)
            : 0;

        /* ================= SALES ================= */
        $totalSales = Order::sum('total_amount');

        $salesLastWeek = Order::whereBetween('created_at', [
            now()->subWeek(), now()->subDays(1)
        ])->sum('total_amount');

        $salesThisWeek = Order::where('created_at', '>=', now()->startOfWeek())
            ->sum('total_amount');

        $salesGrowth = $salesLastWeek > 0
            ? round((($salesThisWeek - $salesLastWeek) / $salesLastWeek) * 100, 1)
            : 0;

        /* ================= ORDERS ================= */
        $totalOrders = Order::count();

        $ordersYesterday = Order::whereDate('created_at', now()->subDay())->count();
        $ordersToday = Order::whereDate('created_at', $today)->count();

        $orderChange = $ordersYesterday > 0
            ? round((($ordersToday - $ordersYesterday) / $ordersYesterday) * 100, 1)
            : 0;

        /* ================= RECENT USERS ================= */
        $recentUsers = User::latest()
            ->select('id','name','email','status','created_at')
            ->limit(5)
            ->get();

        return view('livewire.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'userGrowth',
            'totalSales',
            'salesGrowth',
            'totalOrders',
            'orderChange',
            'recentUsers'
        ));
    }
}
