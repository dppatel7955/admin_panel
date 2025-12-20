<div class="max-w-7xl mx-auto space-y-8">

    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Welcome back 👋</h2>
            <p class="text-sm text-gray-500 mt-1">
                Here’s what’s happening in your application today
            </p>
        </div>

        <div class="mt-4 md:mt-0">
            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Users -->
        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</h3>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                    👥
                </div>
            </div>
            <p class="text-xs mt-3
                {{ $userGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $userGrowth >= 0 ? '↑' : '↓' }} {{ abs($userGrowth) }}% from last month
            </p>

        </div>

        <!-- Sales -->
        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Sales</p>
                    <h3 class="text-2xl font-bold text-gray-800">₹{{ number_format($totalSales) }}</h3>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-xl">
                    💰
                </div>
            </div>
            <p class="text-xs mt-3
                {{ $salesGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $salesGrowth >= 0 ? '↑' : '↓' }} {{ abs($salesGrowth) }}% this week
            </p>
        </div>

        <!-- Orders -->
        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Orders</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</h3>
                </div>
                <div class="bg-purple-100 text-purple-600 p-3 rounded-xl">
                    🧾
                </div>
            </div>
            <p class="text-xs mt-3
                {{ $orderChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $orderChange >= 0 ? '↑' : '↓' }} {{ abs($orderChange) }}% today
            </p>
        </div>

        <!-- Active Users -->
        <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Active Users</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $activeUsers }}</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-xl">
                    ⚡
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Users -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow border border-gray-100">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    Recent Users
                </h3>
            </div>

            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">User</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($recentUsers as $user)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-medium">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </td>

                            <td class="px-6 py-4">
                                <span class="text-xs px-2 py-1 rounded-full
                                    {{ $user->status === 'active'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right text-gray-500">
                                {{ $user->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow border border-gray-100 p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">
                Quick Actions
            </h3>

            <a wire:navigate href="{{ route('users.create') }}" class="block w-full text-center px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                ➕ Create User
            </a>

            <a wire:navigate href="{{ route('users.index') }}" class="block w-full text-center px-4 py-2 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200">
                👥 Manage Users
            </a>

            <a href="#" class="block w-full text-center px-4 py-2 rounded-xl bg-green-100 text-green-700 hover:bg-green-200">
                📊 View Reports
            </a>
        </div>
    </div>

</div>