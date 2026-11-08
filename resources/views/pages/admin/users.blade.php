<x-daei-layout title="User Management — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-950 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Rua'at • Mentee Directory
                    </span>
                    <span class="text-xs text-slate-400">Accountability Roster</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    User & Mentee Management
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Review assigned mentees across all halaqahs, track their spiritual compliance, and inspect individual daily routines.
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center shrink-0">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Active Roster</div>
                <div class="text-2xl font-black text-amber-400 mt-0.5" x-text="`${adminUsers.length} Mentees`"></div>
            </div>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="bg-white rounded-3xl p-5 shadow-xs border border-slate-200/90 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider shrink-0 mr-1">Filter Circle:</span>
            <button
                type="button"
                class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-white shadow-xs"
            >
                All Circles
            </button>
            <template x-for="c in circles" :key="c.id">
                <button
                    type="button"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors shrink-0"
                    x-text="c.name"
                ></button>
            </template>
        </div>

        <div class="text-xs text-slate-500 font-medium shrink-0">
            Showing <strong class="text-slate-900" x-text="adminUsers.length"></strong> registered mentees
        </div>
    </div>

    {{-- Mentees Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="userItem in adminUsers" :key="userItem.id">
            <div class="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-all">
                <div>
                    {{-- User Header --}}
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-slate-900 text-amber-400 font-black text-sm flex items-center justify-center shrink-0 shadow-xs">
                                <span x-text="userItem.name.split(' ').map(n=>n[0]).join('')"></span>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900 tracking-tight" x-text="userItem.name"></h3>
                                <p class="text-xs text-slate-500 font-medium" x-text="userItem.circle"></p>
                            </div>
                        </div>

                        <span
                            class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider"
                            :class="userItem.submittedReport ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'"
                            x-text="userItem.submittedReport ? 'Report In ✓' : 'Due Today'"
                        ></span>
                    </div>

                    {{-- User Metrics --}}
                    <div class="grid grid-cols-2 gap-3 mt-5 pt-4 border-t border-slate-100">
                        <div class="p-3 rounded-2xl bg-slate-50 text-center">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Streak</div>
                            <div class="text-sm font-black text-amber-700 mt-0.5" x-text="`${userItem.streak} Days 🔥`"></div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 text-center">
                            <div class="text-[10px] font-bold text-slate-400 uppercase">Salah Rate</div>
                            <div class="text-sm font-black text-slate-900 mt-0.5" x-text="`${userItem.prayerCompliance}%`"></div>
                        </div>
                    </div>
                </div>

                {{-- Action Links --}}
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                    <a
                        href="{{ url('/admin/timetables') }}"
                        @click="selectAdminUser(userItem.id)"
                        class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs"
                    >
                        Inspect Timetable
                    </a>
                    <a
                        href="{{ url('/admin/feedback') }}"
                        @click="selectAdminUser(userItem.id)"
                        class="text-xs font-bold text-slate-700 hover:text-slate-900"
                    >
                        Send Guidance →
                    </a>
                </div>
            </div>
        </template>
    </div>
</x-daei-layout>
