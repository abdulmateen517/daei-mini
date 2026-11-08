<x-daei-layout title="Mentee Progress — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-950 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Najaah • Growth & Milestones
                    </span>
                    <span class="text-xs text-slate-400">Cohort Analytics</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    User Progress & Compliance Review
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Comparative progress tracking across streaks, prayer attendance rates, and memorization milestones for all mentees.
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center shrink-0">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Circle Avg Salah Rate</div>
                <div class="text-2xl font-black text-amber-400 mt-0.5">94%</div>
            </div>
        </div>
    </div>

    {{-- Progress Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="userItem in adminUsers" :key="userItem.id">
            <div class="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-all">
                <div>
                    {{-- User Header --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-slate-900 text-amber-400 font-black text-xs flex items-center justify-center shrink-0 shadow-xs">
                                <span x-text="userItem.name.split(' ').map(n=>n[0]).join('')"></span>
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900" x-text="userItem.name"></h3>
                                <p class="text-[11px] text-slate-500" x-text="userItem.circle"></p>
                            </div>
                        </div>

                        <span class="text-xs font-bold text-amber-700 bg-amber-100/70 px-2.5 py-1 rounded-xl">
                            🔥 <span x-text="`${userItem.streak}d`"></span>
                        </span>
                    </div>

                    {{-- Metrics Sliders --}}
                    <div class="space-y-4 pt-3 border-t border-slate-100">
                        {{-- Salah Rate --}}
                        <div>
                            <div class="flex items-center justify-between text-xs font-bold mb-1">
                                <span class="text-slate-600">Salah Compliance</span>
                                <span class="text-slate-900" x-text="`${userItem.prayerCompliance}%`"></span>
                            </div>
                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-slate-900 rounded-full" :style="`width: ${userItem.prayerCompliance}%`"></div>
                            </div>
                        </div>

                        {{-- Timetable Routine Adherence --}}
                        <div>
                            <div class="flex items-center justify-between text-xs font-bold mb-1">
                                <span class="text-slate-600">Timetable Adherence</span>
                                <span class="text-slate-900">88%</span>
                            </div>
                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full" style="width: 88%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action --}}
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-emerald-700">● Consistent</span>
                    <a
                        href="{{ url('/admin/feedback') }}"
                        @click="selectAdminUser(userItem.id)"
                        class="text-xs font-bold text-slate-900 hover:text-amber-600"
                    >
                        Send Naseehah →
                    </a>
                </div>
            </div>
        </template>
    </div>
</x-daei-layout>
