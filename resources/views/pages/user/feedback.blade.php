<x-daei-layout title="Mentor Guidance — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Naseehah • Mentor Supervision
                    </span>
                    <span class="text-xs text-slate-400">Accountability Halaqah</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Mentor Feedback & Guidance
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Constructive naseehah and action points provided by your halaqah mentor, Ustadh Farhan Al-Mansoor, based on your daily reports and timetable consistency.
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center shrink-0">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Assigned Mentor</div>
                <div class="text-sm font-bold text-white mt-1">Ustadh Farhan</div>
                <div class="text-[11px] text-amber-400">Circle Badr Lead</div>
            </div>
        </div>
    </div>

    {{-- Feedback Stream Cards --}}
    <div class="space-y-4">
        {{-- Item 1 (From Nov 7 report) --}}
        <div class="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs space-y-3">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-900 text-amber-400 flex items-center justify-center font-black text-xs shrink-0 shadow-xs">
                        FM
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-slate-900">Ustadh Farhan Al-Mansoor</h3>
                            <span class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md bg-amber-100 text-amber-900 border border-amber-200">Mentor</span>
                        </div>
                        <p class="text-xs text-slate-500">Regarding Daily Report • Saturday, 7 Nov 2026</p>
                    </div>
                </div>
                <span class="text-xs font-bold text-slate-400">Yesterday</span>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs sm:text-sm text-slate-800 leading-relaxed italic">
                “Barakallahu feek Zayd. Your Fajr and Dhuhr jama'ah consistency is exemplary. I noticed you scheduled a late evening coding block right around Isha yesterday which caused slight fatigue during morning Tahajjud. Try shifting heavy cognitive tasks earlier in the afternoon so your night remains tranquil for rest and reflection.”
            </div>

            <div class="pt-2 flex items-center justify-between text-xs">
                <span class="text-emerald-700 font-bold flex items-center gap-1.5">
                    <span>✓</span>
                    <span>Action Point: Shift late study blocks before 8:00 PM</span>
                </span>
                <button
                    type="button"
                    @click="showToast('Feedback acknowledged! Action items noted in plan.')"
                    class="px-4 py-1.5 rounded-xl font-bold bg-slate-900 text-white hover:bg-slate-800 transition-colors"
                >
                    Acknowledge Advice
                </button>
            </div>
        </div>

        {{-- Item 2 (From Nov 6 report) --}}
        <div class="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs space-y-3">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-900 text-amber-400 flex items-center justify-center font-black text-xs shrink-0 shadow-xs">
                        FM
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-slate-900">Ustadh Farhan Al-Mansoor</h3>
                            <span class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md bg-amber-100 text-amber-900 border border-amber-200">Mentor</span>
                        </div>
                        <p class="text-xs text-slate-500">Regarding Daily Report • Friday, 6 Nov 2026</p>
                    </div>
                </div>
                <span class="text-xs font-bold text-slate-400">2 days ago</span>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs sm:text-sm text-slate-800 leading-relaxed italic">
                “Great progress on completing your Surah Al-Kahf recitation on Friday. Keep guarding your Istighfar habit after Asr prayer.”
            </div>

            <div class="pt-2 flex items-center justify-between text-xs">
                <span class="text-slate-500 font-medium">Archived Feedback</span>
                <span class="text-emerald-700 font-bold">Acknowledged ✓</span>
            </div>
        </div>
    </div>
</x-daei-layout>
