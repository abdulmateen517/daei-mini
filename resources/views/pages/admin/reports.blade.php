<x-daei-layout title="Daily Reports Review — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-950 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Idarah • Review Queue
                    </span>
                    <span class="text-xs text-slate-400">Accountability Reports</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Daily Reports Review
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Inspect submitted accountability reports from mentees. Review their self-assessments, habit completion, and provide tailored mentorship comments.
                </p>
            </div>

            {{-- Date Tabs --}}
            <div class="flex items-center gap-2 bg-slate-900 p-1.5 rounded-2xl border border-slate-800 shrink-0">
                <template x-for="(rep, dKey) in reports" :key="dKey">
                    <button
                        type="button"
                        @click="activeReportDate = dKey"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all"
                        :class="activeReportDate === dKey ? 'bg-amber-400 text-slate-950 shadow-xs' : 'text-slate-400 hover:text-white'"
                        x-text="dKey === todayDateString ? 'Today' : dKey.slice(5)"
                    ></button>
                </template>
            </div>
        </div>
    </div>

    {{-- Report Inspection Detail Card --}}
    <template x-if="reports[activeReportDate]">
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-slate-200/90 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-black text-slate-900" x-text="reports[activeReportDate].displayDate"></h2>
                        <span
                            class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider"
                            :class="reports[activeReportDate].isSubmitted ? 'bg-emerald-100 text-emerald-900' : 'bg-amber-100 text-amber-900'"
                            x-text="reports[activeReportDate].isSubmitted ? 'Submitted by Zayd Khan ✓' : 'Draft'"
                        ></span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5" x-text="reports[activeReportDate].submittedAt || 'Pending mentee submission'"></p>
                </div>

                <div class="text-xs font-bold text-slate-600 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200">
                    Mentee: <strong class="text-slate-900">Zayd Khan</strong> (Circle Badr)
                </div>
            </div>

            {{-- Quantitative Metrics --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Salah Tracked</div>
                    <div class="text-xl font-black text-slate-900 mt-1" x-text="`${reports[activeReportDate].prayersCompleted || 5} / 5`"></div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Habits Done</div>
                    <div class="text-xl font-black text-slate-900 mt-1" x-text="`${reports[activeReportDate].habitsCompleted || 3} / 4`"></div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Timetable Slots</div>
                    <div class="text-xl font-black text-slate-900 mt-1" x-text="`${reports[activeReportDate].tasksCompleted || 3} / 3`"></div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Spiritual Avg</div>
                    <div class="text-xl font-black text-amber-600 mt-1" x-text="`${reports[activeReportDate].spiritualRating || 4} / 5 ⭐`"></div>
                </div>
            </div>

            {{-- Mentee Qualitative Notes --}}
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <h4 class="text-xs font-black uppercase tracking-wider text-slate-700">Mentee's Daily Reflection Notes</h4>
                <p class="text-xs sm:text-sm text-slate-800 leading-relaxed italic" x-text="`“${reports[activeReportDate].notes || 'Consistent focus across all activities, Alhamdulillah.'}”`"></p>
            </div>

            {{-- Mentor Feedback Section --}}
            <div class="p-6 rounded-2xl bg-slate-950 text-white space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-amber-400">💬</span>
                        <h4 class="text-xs font-black uppercase tracking-wider text-amber-400">Your Mentor Commentary</h4>
                    </div>
                    <span class="text-xs text-slate-400" x-text="admin.name"></span>
                </div>

                <template x-if="reports[activeReportDate].mentorFeedback">
                    <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 text-xs sm:text-sm text-slate-200 italic">
                        “<span x-text="reports[activeReportDate].mentorFeedback.comment"></span>”
                    </div>
                </template>

                {{-- Interactive Comment Box --}}
                <div class="space-y-3 pt-2">
                    <textarea
                        rows="3"
                        x-model="newMentorCommentText"
                        placeholder="Write encouragement, guidance, or scheduling advice for this report..."
                        class="w-full rounded-xl bg-slate-900 border border-slate-800 p-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-400 resize-none"
                    ></textarea>

                    <div class="flex justify-end">
                        <button
                            type="button"
                            @click="addMentorGuidance(activeReportDate)"
                            class="px-5 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs"
                        >
                            Send Mentor Advice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</x-daei-layout>
