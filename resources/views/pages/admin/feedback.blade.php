<x-daei-layout title="Admin Guidance & Feedback — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-950 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Naseehah • Direct Mentorship
                    </span>
                    <span class="text-xs text-slate-400">Counsel & Guidance</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Provide Mentor Feedback
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Dispatch actionable advice and spiritual counsel to your mentees based on timetable conflicts, streak consistency, or submitted reports.
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center shrink-0">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Mentor Profile</div>
                <div class="text-sm font-bold text-white mt-1" x-text="admin.name"></div>
                <div class="text-[11px] text-amber-400" x-text="admin.title"></div>
            </div>
        </div>
    </div>

    {{-- Feedback Form Card --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-slate-200/90 space-y-6">
        <div>
            <h2 class="text-base font-extrabold text-slate-900">Compose Guidance Message</h2>
            <p class="text-xs text-slate-500 mt-0.5">Advice is delivered directly to the mentee's Mentor Guidance portal.</p>
        </div>

        <form @submit.prevent="addMentorGuidance(todayDateString)" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Select Mentee *</label>
                    <select
                        @change="selectAdminUser($event.target.value)"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-xs text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-slate-900"
                    >
                        <template x-for="u in adminUsers" :key="u.id">
                            <option :value="u.id" :selected="selectedAdminUser && selectedAdminUser.id === u.id" x-text="`${u.name} — ${u.circle}`"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Guidance Category</label>
                    <select class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-xs text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-slate-900">
                        <option>Timetable & Overlap Resolution</option>
                        <option>Salah & Jama'ah Attendance</option>
                        <option>Quran & Tafseer Habit Consistency</option>
                        <option>Character & Spiritual Focus</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Mentor Advice & Action Items *</label>
                <textarea
                    rows="4"
                    x-model="newMentorCommentText"
                    class="w-full rounded-2xl border border-slate-300 p-3.5 text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 resize-none"
                    placeholder="Enter actionable advice, scheduling recommendations, or words of encouragement..."
                    required
                ></textarea>
            </div>

            <div class="pt-2 flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    Dispatch Feedback to Mentee
                </button>
            </div>
        </form>
    </div>

    {{-- Recently Dispatched Advice Log --}}
    <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/90 space-y-4">
        <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Recently Dispatched Guidance</h3>

        <div class="space-y-3">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-1.5">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-900">To: Zayd Khan (Circle Badr)</span>
                    <span class="text-slate-400">Nov 7, 2026</span>
                </div>
                <p class="text-slate-600 italic">“Barakallahu feek Zayd. Try shifting heavy cognitive tasks earlier in the afternoon so your night remains tranquil for rest and reflection.”</p>
                <span class="text-[10px] font-bold text-emerald-700">Delivered ✓</span>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-1.5">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-900">To: Zayd Khan (Circle Badr)</span>
                    <span class="text-slate-400">Nov 6, 2026</span>
                </div>
                <p class="text-slate-600 italic">“Great progress on completing your Surah Al-Kahf recitation on Friday. Keep guarding your Istighfar habit after Asr prayer.”</p>
                <span class="text-[10px] font-bold text-emerald-700">Delivered ✓</span>
            </div>
        </div>
    </div>
</x-daei-layout>
