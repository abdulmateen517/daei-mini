<x-daei-layout title="User Timetable Review — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-950 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Tafteesh • Schedule Audit
                    </span>
                    <span class="text-xs text-slate-400">Mentee Timetable Inspection</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Mentee Timetable Review
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Inspect mentee schedules in real time. Verify that activities are balanced and detect any unresolved schedule collisions.
                </p>
            </div>

            {{-- Mentee Selector Dropdown --}}
            <div class="bg-white/10 p-2 rounded-2xl border border-white/20 shrink-0">
                <label class="block text-[10px] uppercase font-bold text-slate-300 mb-1 px-1">Selected Mentee:</label>
                <select
                    @change="selectAdminUser($event.target.value)"
                    class="rounded-xl bg-slate-900 border border-slate-700 px-3 py-1.5 text-xs font-bold text-white focus:outline-none"
                >
                    <template x-for="u in adminUsers" :key="u.id">
                        <option :value="u.id" :selected="selectedAdminUser && selectedAdminUser.id === u.id" x-text="`${u.name} (${u.circle})`"></option>
                    </template>
                </select>
            </div>
        </div>
    </div>

    {{-- Inspected Mentee Header Card --}}
    <template x-if="selectedAdminUser">
        <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 text-amber-400 font-black text-base flex items-center justify-center shrink-0 shadow-xs">
                        <span x-text="selectedAdminUser.name.split(' ').map(n=>n[0]).join('')"></span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg font-black text-slate-900" x-text="selectedAdminUser.name"></h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-200" x-text="selectedAdminUser.circle"></span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5" x-text="`Current Streak: ${selectedAdminUser.streak} Days 🔥 • Salah Compliance: ${selectedAdminUser.prayerCompliance}%`"></p>
                    </div>
                </div>

                <a
                    href="{{ url('/admin/feedback') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                    <span>Send Timetable Feedback</span>
                </a>
            </div>

            {{-- Conflict Alert Notice if Zayd or active candidate clashes --}}
            <template x-if="activeConflictsCount > 0">
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-300 text-rose-950 flex items-start gap-3">
                    <span class="text-xl">⚠️</span>
                    <div class="text-xs">
                        <h4 class="font-extrabold text-sm text-rose-950">Schedule Overlap Conflict Detected!</h4>
                        <p class="text-rose-900 mt-0.5">
                            This mentee has scheduled overlapping activities on today's calendar. Highlighted cards show the conflicting time interval.
                        </p>
                    </div>
                </div>
            </template>

            {{-- Mentee Activities List --}}
            <div>
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-3">Today's Scheduled Activities (Sunday, 8 Nov 2026)</h3>

                <div class="space-y-3">
                    <template x-for="act in activities" :key="act.id">
                        <div
                            class="p-4 rounded-2xl border transition-all flex items-center justify-between gap-4"
                            :class="highlightedActivityIds.includes(act.id) ? 'bg-rose-50/70 border-rose-400 ring-1 ring-rose-300 shadow-xs' : 'bg-white border-slate-200 hover:border-slate-300'"
                        >
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="w-2.5 h-10 rounded-full shrink-0" :class="{
                                    'bg-amber-400': act.category === 'Islamic Studies' || act.category === 'Salah',
                                    'bg-sky-500': act.category === 'Work' || act.category === 'Dawah',
                                    'bg-emerald-500': act.category === 'Habit' || act.category === 'Personal',
                                    'bg-rose-500': act.category === 'Health'
                                }"></div>

                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-slate-900" x-text="act.name"></h4>
                                        <template x-if="highlightedActivityIds.includes(act.id)">
                                            <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider bg-rose-500 text-white">Clashing Slot</span>
                                        </template>
                                    </div>
                                    <div class="text-xs text-slate-500 flex items-center gap-2 mt-0.5">
                                        <span class="font-bold text-slate-700" x-text="`${act.startTime} – ${act.endTime}`"></span>
                                        <span>•</span>
                                        <span class="px-2 py-0.2 rounded-md bg-slate-100 text-slate-700 font-semibold" x-text="act.category"></span>
                                        <span>•</span>
                                        <span class="italic text-slate-400" x-text="act.notes"></span>
                                    </div>
                                </div>
                            </div>

                            <span
                                class="text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider shrink-0"
                                :class="{
                                    'bg-emerald-100 text-emerald-800': act.status === 'Completed',
                                    'bg-amber-100 text-amber-800': act.status === 'Pending',
                                    'bg-rose-100 text-rose-800': act.status === 'Missed'
                                }"
                                x-text="act.status"
                            ></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </template>
</x-daei-layout>
