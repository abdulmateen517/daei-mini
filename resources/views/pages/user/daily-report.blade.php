<x-daei-layout title="Daily Reports — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Taqreer Yawmi • Daily Accountability
                    </span>
                    <span class="text-xs text-slate-400">Formal Submissions</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Daily Accountability Reports
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Submit your end-of-day summary to your mentor. Today's report is editable until submitted; historical reports are permanently archived and read-only.
                </p>
            </div>

            {{-- Date Selector Tabs --}}
            <div class="flex items-center gap-2 bg-slate-800/90 p-1.5 rounded-2xl border border-slate-700 shrink-0">
                <template x-for="(rep, dKey) in reports" :key="dKey">
                    <button
                        type="button"
                        @click="activeReportDate = dKey"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5"
                        :class="activeReportDate === dKey ? 'bg-amber-400 text-slate-950 shadow-xs' : 'text-slate-300 hover:text-white'"
                    >
                        <template x-if="dKey === todayDateString">
                            <span>Today</span>
                        </template>
                        <template x-if="dKey !== todayDateString">
                            <span x-text="dKey.slice(5)"></span>
                        </template>
                        <template x-if="dKey !== todayDateString">
                            <span class="text-[9px]">🔒</span>
                        </template>
                    </button>
                </template>
            </div>
        </div>
    </div>

    {{-- Strict Invariant Status Banner --}}
    <div>
        {{-- Banner for TODAY (Editable) --}}
        <template x-if="isReportEditable(activeReportDate)">
            <div class="rounded-3xl p-5 bg-amber-50 border border-amber-200 text-amber-950 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-2xl bg-amber-200 text-amber-900 font-bold shrink-0">
                        ✏️
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-amber-950">Active Report (Current Day: Sunday, 8 Nov 2026)</h4>
                        <p class="text-xs text-amber-900/90 mt-0.5">
                            You may freely adjust your daily ratings, add reflections, and submit your report to your mentor.
                        </p>
                    </div>
                </div>
                <template x-if="reports[activeReportDate]?.isSubmitted">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-900 font-extrabold text-xs rounded-xl border border-emerald-300 shrink-0">
                        Submitted to Mentor ✓
                    </span>
                </template>
            </div>
        </template>

        {{-- Banner for PAST DATES (Strictly Read-Only Locked) --}}
        <template x-if="!isReportEditable(activeReportDate)">
            <div class="rounded-3xl p-5 bg-slate-100 border-2 border-slate-300 text-slate-800 flex items-center justify-between gap-3 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-2xl bg-slate-200 text-slate-700 font-bold text-base shrink-0">
                        🔒
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-black text-slate-900">Historical Report — Strictly Read-Only</h4>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-slate-200 text-slate-700">Archived</span>
                        </div>
                        <p class="text-xs text-slate-600 mt-0.5">
                            This report was locked upon the close of the calendar day. Past submissions cannot be altered to preserve audit integrity.
                        </p>
                    </div>
                </div>
                <span class="hidden sm:inline text-xs font-black px-3 py-1 bg-slate-200 text-slate-800 rounded-xl border border-slate-300">
                    Locked 🔒
                </span>
            </div>
        </template>
    </div>

    {{-- Report Content Card --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-slate-200/90 space-y-6">
        <template x-if="reports[activeReportDate]">
            <div class="space-y-6">
                {{-- Top Metadata --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900" x-text="reports[activeReportDate].displayDate"></h3>
                        <p class="text-xs text-slate-500 mt-0.5" x-text="reports[activeReportDate].submittedAt ? `Submission recorded: ${reports[activeReportDate].submittedAt}` : 'Submission pending'"></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs font-extrabold px-3 py-1 rounded-xl uppercase tracking-wider"
                            :class="reports[activeReportDate].isSubmitted ? 'bg-emerald-100 text-emerald-900' : 'bg-amber-100 text-amber-900'"
                            x-text="reports[activeReportDate].isSubmitted ? 'Submitted to Ustadh Farhan' : 'Draft / In Progress'"
                        ></span>
                    </div>
                </div>

                {{-- Quantitative Metrics Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Salah Tracked</div>
                        <div class="text-xl font-black text-slate-900 mt-1" x-text="`${reports[activeReportDate].prayersCompleted || completedPrayersCount} / 5`"></div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Habits Done</div>
                        <div class="text-xl font-black text-slate-900 mt-1" x-text="`${reports[activeReportDate].habitsCompleted || completedHabitsToday} / ${habits.length}`"></div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Timetable Slots</div>
                        <div class="text-xl font-black text-slate-900 mt-1" x-text="`${reports[activeReportDate].tasksCompleted || 3} / ${reports[activeReportDate].tasksTotal || 3}`"></div>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Spiritual Avg</div>
                        <div class="text-xl font-black text-amber-600 mt-1" x-text="`${(((reports[activeReportDate].spiritualRating || 4) + (reports[activeReportDate].productivityRating || 4) + (reports[activeReportDate].disciplineRating || 5)) / 3).toFixed(1)} / 5`"></div>
                    </div>
                </div>

                {{-- Ratings Breakdown (Disabled if not editable) --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <div class="p-4 rounded-2xl border" :class="isReportEditable(activeReportDate) ? 'bg-white border-slate-200' : 'bg-slate-50/70 border-slate-200'">
                        <div class="text-xs font-bold text-slate-600">Spiritual Focus</div>
                        <div class="text-lg font-black text-slate-900 mt-0.5" x-text="`${reports[activeReportDate].spiritualRating || todaySelfAssessment.spiritualRating} / 5 ⭐`"></div>
                    </div>
                    <div class="p-4 rounded-2xl border" :class="isReportEditable(activeReportDate) ? 'bg-white border-slate-200' : 'bg-slate-50/70 border-slate-200'">
                        <div class="text-xs font-bold text-slate-600">Timetable Discipline</div>
                        <div class="text-lg font-black text-slate-900 mt-0.5" x-text="`${reports[activeReportDate].productivityRating || todaySelfAssessment.productivityRating} / 5 ⚡`"></div>
                    </div>
                    <div class="p-4 rounded-2xl border" :class="isReportEditable(activeReportDate) ? 'bg-white border-slate-200' : 'bg-slate-50/70 border-slate-200'">
                        <div class="text-xs font-bold text-slate-600">Character & Mindset</div>
                        <div class="text-lg font-black text-slate-900 mt-0.5" x-text="`${reports[activeReportDate].disciplineRating || todaySelfAssessment.disciplineRating} / 5 🛡️`"></div>
                    </div>
                </div>

                {{-- Qualitative Notes Area --}}
                <div>
                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-800 mb-1.5">
                        Daily Reflection & Accountability Notes
                    </label>
                    <textarea
                        rows="3"
                        class="w-full rounded-2xl border p-3.5 text-xs sm:text-sm resize-none focus:outline-none"
                        :class="isReportEditable(activeReportDate) ? 'bg-white border-slate-300 text-slate-900 focus:ring-2 focus:ring-slate-900' : 'bg-slate-100 border-slate-200 text-slate-600 cursor-not-allowed'"
                        :disabled="!isReportEditable(activeReportDate)"
                        x-model="todaySelfAssessment.notes"
                    ></textarea>
                </div>

                {{-- Mentor Comments & Advice on this specific report --}}
                <div class="p-5 rounded-2xl bg-slate-900 text-white space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-amber-400">💬</span>
                            <h4 class="text-xs font-black uppercase tracking-wider text-amber-400">Mentor Supervisory Guidance</h4>
                        </div>
                        <span class="text-[11px] text-slate-400">Ustadh Farhan Al-Mansoor</span>
                    </div>

                    <template x-if="reports[activeReportDate].mentorFeedback">
                        <div class="text-xs text-slate-200 leading-relaxed italic bg-slate-800/80 p-3.5 rounded-xl border border-slate-700">
                            “<span x-text="reports[activeReportDate].mentorFeedback.comment"></span>”
                        </div>
                    </template>
                    <template x-if="!reports[activeReportDate].mentorFeedback">
                        <div class="text-xs text-slate-400 italic">
                            No mentor commentary entered yet for this submission.
                        </div>
                    </template>
                </div>

                {{-- Submission Action (Enabled ONLY for today) --}}
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <template x-if="isReportEditable(activeReportDate)">
                        <div class="text-xs text-slate-500">
                            Submitting sends your updated metrics and self-assessment to your Circle Mentor.
                        </div>
                    </template>
                    <template x-if="!isReportEditable(activeReportDate)">
                        <div class="text-xs text-slate-400 italic">
                            Historical reports are locked for editing.
                        </div>
                    </template>

                    <template x-if="isReportEditable(activeReportDate)">
                        <button
                            type="button"
                            @click="submitTodayReport()"
                            class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95 shrink-0"
                        >
                            <span x-text="reports[activeReportDate]?.isSubmitted ? 'Resubmit Updated Report ✓' : 'Submit Daily Report 🚀'"></span>
                        </button>
                    </template>
                </div>
            </div>
        </template>
    </div>
</x-daei-layout>
