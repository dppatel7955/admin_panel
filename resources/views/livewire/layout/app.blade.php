<!DOCTYPE html>
<html 
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="themeManager()"
    x-init="init()"
    :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <livewire:layout.sidebar />

        <div class="flex-1 flex flex-col">

            {{-- Navbar --}}
            <livewire:layout.navbar />

            {{-- Page Content --}}
            <main class="p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

    @livewireScripts
</body>
<script>
    function themeManager() {
        return {
            isDark: false,

            init() {
                const saved = localStorage.getItem('theme');

                if (saved) {
                    this.isDark = saved === 'dark';
                } else {
                    // Optional: system preference
                    this.isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                }
            },

            toggle() {
                this.isDark = !this.isDark;
                localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
            },

            set(mode) {
                this.isDark = mode === 'dark';
                localStorage.setItem('theme', mode);
            }
        }
    }
</script>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('notify', (data) => {
            Swal.fire({
                icon: data.type ?? 'success',
                title: data.title ?? 'Notification',
                text: data.message,
                timer: data.timer ?? 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
            })
        })

        Livewire.on('confirm-logout', () => {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out of your account.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('logout')
                }
            })
        })

        Livewire.on('confirm-delete', () => {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This user will be deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteUser');
                }
            });
        });
        
        Livewire.on('confirm-force-delete', () => {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This user will be deleted Permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('forceDeleteUser');
                }
            });
        });
    })
</script>
@if(session('sweet_alert'))
<script>
    Swal.fire({
        icon: "{{ session('sweet_alert.type') }}",
        title: "{{ session('sweet_alert.title') }}",
        text: "{{ session('sweet_alert.text') }}",
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        confirmButtonColor: '#3085d6'
    });
</script>
@endif
</html>
