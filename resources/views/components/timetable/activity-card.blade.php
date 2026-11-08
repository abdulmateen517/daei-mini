{{-- Activity Card Component (Sections 3, 5, 6 & 9) --}}
<div
    class="relative rounded-2xl bg-white p-4 sm:p-5 transition-all duration-200 border"
    :class="[
        isActivityConflicted(activity.id)
            ? 'border-2 border-amber-400 bg-amber-50/30 shadow-md ring-2 ring-amber-400/20'
            : activity.completed
                ? 'border-slate-200/60 bg-slate-50/50 opacity-80'
                : 'border-slate-200/90 shadow-sm hover:shadow-md hover:border-slate-300'
    ]"
>
    {{-- Top Row: Time, Category Badge, Conflict Pill & Duration --}}
    <div class="flex flex-wrap items-center justify-between gap-2 pb-2.5 mb-2.5 border-b border-slate-100">
        <div class="flex items-center gap-2">
            {{-- Time Badge --}}
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-extrabold bg-slate-900 text-white shadow-sm">
                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span x-text="`${format12(activity.startTime)} – ${format12(activity.endTime)}`"></span>
            </span>

            {{-- Category Badge --}}
            <span
                class="px-2.5 py-0.5 rounded-lg text-[11px] font-bold border"
                :class="{
                    'bg-blue-50 text-blue-700 border-blue-200': activity.category === 'Work',
                    'bg-purple-50 text-purple-700 border-purple-200': activity.category === 'Study',
                    'bg-emerald-50 text-emerald-700 border-emerald-200': activity.category === 'Worship',
                    'bg-rose-50 text-rose-700 border-rose-200': activity.category === 'Health',
                    'bg-amber-50 text-amber-800 border-amber-200': activity.category === 'Habit',
                }"
                x-text="activity.category"
            ></span>

            {{-- Duration --}}
            <span class="text-[11px] font-semibold text-slate-500" x-text="formatDur(getActivityDurationMinutes(activity))"></span>
        </div>

        {{-- Conflict Highlighting Badge --}}
        <template x-if="isActivityConflicted(activity.id)">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-900 border border-amber-300 animate-pulse">
                <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span>Overlap Detected</span>
            </span>
        </template>
    </div>

    {{-- Middle Row: Checkbox, Name, Date, Notes --}}
    <div class="flex items-start justify-between gap-3">
        <div class="flex items-start gap-3 flex-1 min-w-0">
            {{-- Checkbox / Completed Toggle --}}
            <button
                type="button"
                @click="toggleComplete(activity.id)"
                class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-md border transition-colors"
                :class="activity.completed ? 'bg-emerald-600 border-emerald-600 text-white' : 'border-slate-300 hover:border-slate-400 bg-white'"
                title="Mark completed"
            >
                <template x-if="activity.completed">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </template>
            </button>

            <div class="flex-1 min-w-0">
                <div class="flex items-baseline gap-2 flex-wrap">
                    <h3
                        class="text-base font-bold text-slate-900 tracking-tight"
                        :class="{ 'line-through text-slate-400': activity.completed }"
                        x-text="activity.name"
                    ></h3>
                    <span class="text-xs font-medium text-slate-400" x-text="`• ${activity.date}`"></span>
                </div>

                {{-- Notes / Agenda --}}
                <template x-if="activity.notes">
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2" x-text="activity.notes"></p>
                </template>
            </div>
        </div>

        {{-- Action Buttons: Edit & Delete --}}
        <div class="flex items-center gap-1.5 shrink-0">
            {{-- Edit Button --}}
            <button
                type="button"
                @click="openEditModal(activity)"
                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold rounded-lg text-slate-700 hover:text-slate-900 hover:bg-slate-100 transition-colors border border-transparent hover:border-slate-200"
                title="Edit Activity"
            >
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit</span>
            </button>

            {{-- Delete Button --}}
            <button
                type="button"
                @click="confirmDeleteActivity(activity)"
                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold rounded-lg text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition-colors border border-transparent hover:border-rose-100"
                title="Delete Activity"
            >
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>Delete</span>
            </button>
        </div>
    </div>

    {{-- Bottom Conflict Highlighting Details Banner (Section 9) --}}
    <template x-if="isActivityConflicted(activity.id)">
        <div class="mt-3 pt-2.5 border-t border-amber-200/80">
            <template x-for="(conf, cIdx) in getActivityConflicts(activity.id)" :key="cIdx">
                <div class="flex items-center justify-between text-xs font-semibold text-amber-900 bg-amber-100/60 px-3 py-1.5 rounded-lg mb-1">
                    <div class="flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                        <span>Overlaps with <strong x-text="conf.peerName"></strong></span>
                    </div>
                    <span class="text-amber-800 bg-white/70 px-2 py-0.5 rounded font-mono text-[11px]" x-text="`${conf.overlapMinutes}m clash (${conf.formattedRange})`"></span>
                </div>
            </template>
        </div>
    </template>
</div>
