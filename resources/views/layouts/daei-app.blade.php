<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8F9FA]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Daei Mini — Islamic Productivity & Mentorship Platform' }}</title>

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        {{-- Scripts & Styles --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            body { font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif; }
        </style>
    </head>
    <body class="h-full bg-[#F8F9FA] text-slate-800 antialiased selection:bg-amber-400 selection:text-slate-900">
        <div x-data="timetableManager()" x-cloak class="min-h-screen flex">
            {{-- User Sidebar (Active in User Mode) --}}
            <template x-if="currentRole === 'user'">
                <x-navigation.user-sidebar />
            </template>

            {{-- Admin Sidebar (Active in Admin Mode) --}}
            <template x-if="currentRole === 'admin'">
                <x-navigation.admin-sidebar />
            </template>

            {{-- Mobile Sidebar Backdrop --}}
            <div
                x-show="isSidebarOpen"
                x-cloak
                class="fixed inset-0 z-30 bg-slate-900/60 backdrop-blur-sm lg:hidden"
                @click="isSidebarOpen = false"
                style="display: none;"
            ></div>

            {{-- Main Layout Canvas --}}
            <div class="flex-1 lg:pl-64 flex flex-col min-h-screen w-full">
                {{-- Top Navigation Header --}}
                <x-navigation.top-header />

                {{-- Toast Notification Bar --}}
                <div
                    x-show="toast.show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="fixed top-4 right-4 z-50 max-w-md"
                    style="display: none;"
                >
                    <div
                        class="flex items-center gap-2.5 p-4 rounded-2xl shadow-xl text-xs font-bold border"
                        :class="{
                            'bg-slate-950 text-white border-slate-800': toast.type === 'success',
                            'bg-amber-900 text-amber-100 border-amber-700': toast.type === 'warning',
                            'bg-rose-900 text-white border-rose-700': toast.type === 'error'
                        }"
                    >
                        <template x-if="toast.type === 'success'">
                            <span class="text-amber-400 text-base">✓</span>
                        </template>
                        <template x-if="toast.type === 'warning'">
                            <span class="text-amber-400 text-base">⚠️</span>
                        </template>
                        <span x-text="toast.message"></span>
                    </div>
                </div>

                {{-- Main Page Content --}}
                <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-6xl w-full mx-auto space-y-6">
                    {{ $slot }}
                </main>

                {{-- Modals --}}
                <x-timetable.conflict-warning-modal />
                <x-timetable.activity-form-modal />
                <x-timetable.delete-confirmation-modal />
                <x-modals.all-feature-modals />
            </div>
        </div>
    </body>
</html>
