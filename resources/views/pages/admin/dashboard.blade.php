<x-daei-layout title="Admin Dashboard — Daei Mini">
    {{-- Admin Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-950 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Murabbi • Mentor Supervisory Panel
                    </span>
                    <span class="text-xs text-slate-400" x-text="`${admin.title} • Circle Badr`"></span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Supervisory Dashboard
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Welcome, <span x-text="admin.name"></span>. Monitor mentee timetables, review daily accountability reports, and provide timely Islamic guidance.
                </p>
            </div>

            <div class="flex items-center gap-2.5 shrink-0">
                <a
                    href="{{ url('/admin/reports') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span>Review Reports</span>
                </a>
                <button
                    type="button"
                    @click="isAddGroupModalOpen = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-800 hover:bg-slate-700 transition-colors border border-slate-700"
                >
                    <span>+ New Circle</span>
                </button>
            </div>
        </div>

        {{-- Metrics Overview --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-5 border-t border-slate-800">
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Mentees</div>
                <div class="text-xl font-black text-white mt-0.5" x-text="adminUsers.length"></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Reports Due Today</div>
                <div class="text-xl font-black text-amber-400 mt-0.5" x-text="`${adminUsers.filter(u => u.submittedReport).length} / ${adminUsers.length}`"></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Active Circles</div>
                <div class="text-xl font-black text-white mt-0.5" x-text="circles.length"></div>
            </div>
            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Schedule Clashes</div>
                <div class="text-xl font-black text-rose-400 mt-0.5">1 Alert</div>
            </div>
        </div>
    </div>

    {{-- Main 2-Column Responsive Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Mentee Overview Table (2 cols) --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Mentees Under Supervision</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Real-time submission status, streaks, and timetable activity counts.</p>
                    </div>
                    <a href="{{ url('/admin/users') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900">View All →</a>
                </div>

                {{-- Table for desktop / card list for mobile --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 uppercase text-[10px] font-extrabold tracking-wider">
                                <th class="pb-3">Mentee</th>
                                <th class="pb-3">Circle</th>
                                <th class="pb-3 text-center">Streak</th>
                                <th class="pb-3 text-center">Salah Rate</th>
                                <th class="pb-3 text-center">Today's Report</th>
                                <th class="pb-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="userItem in adminUsers" :key="userItem.id">
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3 font-bold text-slate-900 flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-[10px]">
                                            <span x-text="userItem.name.split(' ').map(n=>n[0]).join('')"></span>
                                        </div>
                                        <span x-text="userItem.name"></span>
                                    </td>
                                    <td class="py-3 text-slate-600 font-medium" x-text="userItem.circle"></td>
                                    <td class="py-3 text-center font-bold text-amber-700" x-text="`${userItem.streak}d 🔥`"></td>
                                    <td class="py-3 text-center font-bold text-slate-700" x-text="`${userItem.prayerCompliance}%`"></td>
                                    <td class="py-3 text-center">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase"
                                            :class="userItem.submittedReport ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'"
                                            x-text="userItem.submittedReport ? 'Received' : 'Pending'"
                                        ></span>
                                    </td>
                                    <td class="py-3 text-right">
                                        <a
                                            href="{{ url('/admin/timetables') }}"
                                            @click="selectAdminUser(userItem.id)"
                                            class="text-xs font-bold text-slate-900 hover:text-amber-600"
                                        >
                                            Inspect →
                                        </a>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Circles & Action Alerts (1 col) --}}
        <div class="space-y-6">
            {{-- Circles Snapshot --}}
            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Active Circles</h3>
                    <a href="{{ url('/admin/groups') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">Manage →</a>
                </div>

                <div class="space-y-3">
                    <template x-for="circle in circles" :key="circle.id">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <div>
                                <h4 class="text-xs font-extrabold text-slate-900" x-text="circle.name"></h4>
                                <p class="text-[11px] text-slate-500 mt-0.5" x-text="circle.meetingDay"></p>
                            </div>
                            <span class="text-xs font-bold text-slate-700 bg-white px-2 py-1 rounded-lg border border-slate-200" x-text="`${circle.membersCount} mentees`"></span>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Quick Schedule Alert --}}
            <div class="rounded-3xl p-6 bg-amber-50 border border-amber-200 text-amber-950 space-y-2 shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="text-amber-600 font-bold">⚠️</span>
                    <h4 class="text-xs font-extrabold uppercase tracking-wider">Timetable Collision Alert</h4>
                </div>
                <p class="text-xs text-amber-900 leading-relaxed">
                    Mentee <strong class="text-amber-950">Zayd Khan</strong> has an active conflict in today's schedule between <em>Weekly Standup</em> and <em>Ollaa Standup</em>.
                </p>
                <a
                    href="{{ url('/admin/timetables') }}"
                    class="inline-block mt-2 text-xs font-bold text-slate-950 underline hover:text-slate-800"
                >
                    Review Zayd's Timetable →
                </a>
            </div>
        </div>
    </div>
</x-daei-layout>
