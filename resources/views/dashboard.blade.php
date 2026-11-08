<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8F9FA]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Daei Mini — Daily Timetable & Time Conflict Alert UI</title>

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
            {{-- 1. Dark Navy Sidebar Navigation (Section 2) --}}
            <x-timetable.sidebar />

            {{-- 2. Main Layout Area --}}
            <div class="flex-1 lg:pl-64 flex flex-col min-h-screen">
                {{-- Top Navigation Header --}}
                <x-timetable.header />

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
                            'bg-emerald-900 text-white border-emerald-700': toast.type === 'success',
                            'bg-amber-900 text-amber-100 border-amber-700': toast.type === 'warning',
                            'bg-rose-900 text-white border-rose-700': toast.type === 'error'
                        }"
                    >
                        <template x-if="toast.type === 'success'">
                            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </template>
                        <template x-if="toast.type === 'warning'">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        </template>
                        <span x-text="toast.message"></span>
                    </div>
                </div>

                {{-- Page Main Content Canvas --}}
                <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-6xl w-full mx-auto space-y-6">
                    {{-- User Dashboard Welcome Banner --}}
                    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
                        {{-- Subtle background geometric accent --}}
                        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                                        Assalamu Alaikum • داعي
                                    </span>
                                    <span class="text-xs text-slate-400">Sunday, 8 Nov 2026</span>
                                </div>
                                <h2 class="text-2xl font-black text-white tracking-tight mt-1">
                                    Welcome back, Zayd!
                                </h2>
                                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                                    Track your routines, manage daily study blocks, and ensure schedule integrity with automatic overlap collision prevention.
                                </p>
                            </div>

                            {{-- Summary Metrics --}}
                            <div class="flex items-center gap-3">
                                <div class="px-4 py-2.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Activities</div>
                                    <div class="text-lg font-black text-white" x-text="totalActivitiesCount"></div>
                                </div>
                                <div class="px-4 py-2.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Hours Today</div>
                                    <div class="text-lg font-black text-amber-400" x-text="scheduledHoursFormatted"></div>
                                </div>
                                <div
                                    class="px-4 py-2.5 rounded-2xl border text-center transition-colors"
                                    :class="activeConflictsCount > 0 ? 'bg-amber-400/20 border-amber-400/40 text-amber-300' : 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300'"
                                >
                                    <div class="text-[10px] font-bold uppercase tracking-wider">Conflicts</div>
                                    <div class="text-lg font-black" x-text="activeConflictsCount"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Daily Timetable Section --}}
                    <x-timetable.daily-timetable />
                </main>

                {{-- Modals --}}
                <x-timetable.conflict-warning-modal />
                <x-timetable.activity-form-modal />
                <x-timetable.delete-confirmation-modal />
            </div>
        </div>
    </body>
</html>
