<x-daei-layout title="Quran & Tafseer Slots — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Kalam Allah • Time Block Tracker
                    </span>
                    <span class="text-xs text-slate-400">Scheduled Study Slots</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Quran & Tafseer Session Tracking
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Schedule and protect dedicated daily blocks for your Quran recitation, memorization review, and Tafseer contemplation.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button
                    type="button"
                    @click="isAddQuranSlotModalOpen = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span>+ Schedule Study Slot</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Strict Scope Disclaimer Notice (Mandatory Requirement) --}}
    <div class="rounded-3xl p-5 bg-amber-50 border-2 border-amber-300/80 text-amber-950 flex items-start gap-3.5 shadow-xs">
        <div class="p-2 rounded-xl bg-amber-200 text-amber-900 shrink-0 mt-0.5">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div class="text-xs">
            <h4 class="font-extrabold text-amber-950 text-sm">Scope Clarification — Activity Tracker Only</h4>
            <p class="text-amber-900/90 mt-1 leading-relaxed">
                Use your own physical Mus-haf or preferred study resources for reading. This app strictly tracks your scheduled study session activity, start/end times, and duration to ensure collision-free timetable planning. No Quran text or audio player is included.
            </p>
        </div>
    </div>

    {{-- Scheduled Study Slots List --}}
    <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/80">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Today's Scheduled Quran & Tafseer Blocks</h3>
                <p class="text-xs text-slate-500 mt-0.5">Sessions synchronized with your Daily Timetable engine.</p>
            </div>
            <a href="{{ url('/timetable') }}" class="text-xs font-bold text-slate-700 hover:text-slate-900">
                View Full Timetable →
            </a>
        </div>

        <div class="space-y-3">
            <template x-for="act in todayActivities.filter(a => a.category === 'Islamic Studies' || a.name.includes('Quran') || a.name.includes('Tafseer'))" :key="act.id">
                <div class="p-4 rounded-2xl border border-slate-200/90 hover:border-slate-300 transition-all flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-900 flex items-center justify-center font-bold shrink-0">
                            📖
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-sm font-bold text-slate-900" x-text="act.name"></h4>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-purple-100 text-purple-900">Islamic Studies</span>
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-2">
                                <span class="font-bold text-slate-700" x-text="`${act.startTime} – ${act.endTime}`"></span>
                                <span>•</span>
                                <span x-text="act.notes || 'Focused contemplation and review'"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <span
                            class="text-[10px] font-bold px-2 py-1 rounded-lg uppercase tracking-wider"
                            :class="{
                                'bg-emerald-100 text-emerald-800': act.status === 'Completed',
                                'bg-amber-100 text-amber-800': act.status === 'Pending',
                                'bg-rose-100 text-rose-800': act.status === 'Missed'
                            }"
                            x-text="act.status"
                        ></span>
                        <button
                            type="button"
                            @click="openEditModal(act)"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-slate-900 hover:bg-slate-100"
                            title="Edit Slot"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</x-daei-layout>
