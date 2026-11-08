{{-- Sample Data & Test Scenarios Bar (Section 11) --}}
<div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-sm">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pb-3 border-b border-slate-100">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
                    ⚡ Task 3 Test Suite
                </span>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                    Interactive Validation Scenarios
                </h4>
            </div>
            <p class="text-xs text-slate-500 mt-0.5">
                Click any scenario below to instantly load test data and verify the conflict detection logic:
            </p>
        </div>

        <button
            type="button"
            @click="resetToDefaults()"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors self-start md:self-auto"
            title="Reset to default timetable schedule"
        >
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span>Reset Schedule</span>
        </button>
    </div>

    {{-- Scenario Buttons Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2.5 mt-3.5">
        {{-- Scenario 1 --}}
        <button
            type="button"
            @click="loadScenario1()"
            class="text-left p-3 rounded-xl border border-slate-200 hover:border-amber-400 hover:bg-amber-50/40 bg-slate-50/60 transition-all group"
        >
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-amber-800 bg-amber-100 px-1.5 py-0.5 rounded">Example 1</span>
                <span class="text-[10px] font-bold text-amber-700">30m Overlap</span>
            </div>
            <div class="mt-1.5 text-xs font-bold text-slate-900 group-hover:text-amber-900">
                Weekly Standup vs Ollaa
            </div>
            <div class="text-[11px] text-slate-500 mt-0.5">
                09:00–12:00 vs 11:30–12:30
            </div>
        </button>

        {{-- Scenario 2 --}}
        <button
            type="button"
            @click="loadScenario2()"
            class="text-left p-3 rounded-xl border border-slate-200 hover:border-amber-400 hover:bg-amber-50/40 bg-slate-50/60 transition-all group"
        >
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-amber-800 bg-amber-100 px-1.5 py-0.5 rounded">Example 2</span>
                <span class="text-[10px] font-bold text-amber-700">15m Overlap</span>
            </div>
            <div class="mt-1.5 text-xs font-bold text-slate-900 group-hover:text-amber-900">
                Team Collab vs Approval
            </div>
            <div class="text-[11px] text-slate-500 mt-0.5">
                02:00–04:15 vs 04:00–06:15
            </div>
        </button>

        {{-- Boundary Condition --}}
        <button
            type="button"
            @click="loadScenarioBoundary()"
            class="text-left p-3 rounded-xl border border-slate-200 hover:border-blue-400 hover:bg-blue-50/40 bg-slate-50/60 transition-all group"
        >
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-blue-800 bg-blue-100 px-1.5 py-0.5 rounded">Boundary</span>
                <span class="text-[10px] font-bold text-emerald-700">0m (Pass)</span>
            </div>
            <div class="mt-1.5 text-xs font-bold text-slate-900 group-hover:text-blue-900">
                Exact Touch at 10:00 AM
            </div>
            <div class="text-[11px] text-slate-500 mt-0.5">
                09:00–10:00 & 10:00–11:00
            </div>
        </button>

        {{-- Different Dates --}}
        <button
            type="button"
            @click="loadScenarioDifferentDates()"
            class="text-left p-3 rounded-xl border border-slate-200 hover:border-blue-400 hover:bg-blue-50/40 bg-slate-50/60 transition-all group"
        >
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-blue-800 bg-blue-100 px-1.5 py-0.5 rounded">Diff Date</span>
                <span class="text-[10px] font-bold text-emerald-700">0m (Pass)</span>
            </div>
            <div class="mt-1.5 text-xs font-bold text-slate-900 group-hover:text-blue-900">
                Different Calendar Days
            </div>
            <div class="text-[11px] text-slate-500 mt-0.5">
                Same times, different dates
            </div>
        </button>

        {{-- Multiple Conflicts --}}
        <button
            type="button"
            @click="loadScenarioMultipleConflicts()"
            class="text-left p-3 rounded-xl border border-slate-200 hover:border-amber-400 hover:bg-amber-50/40 bg-slate-50/60 transition-all group"
        >
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-extrabold text-amber-800 bg-amber-100 px-1.5 py-0.5 rounded">Multi-Clash</span>
                <span class="text-[10px] font-bold text-rose-700">2 Overlaps</span>
            </div>
            <div class="mt-1.5 text-xs font-bold text-slate-900 group-hover:text-amber-900">
                1 Long Slot Over 2 Tasks
            </div>
            <div class="text-[11px] text-slate-500 mt-0.5">
                10:00–12:30 spans two tasks
            </div>
        </button>
    </div>
</div>
