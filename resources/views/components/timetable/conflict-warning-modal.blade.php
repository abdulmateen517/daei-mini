{{-- Time Conflict Warning Modal (Section 8) --}}
<div
    x-show="isConflictModalOpen"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="conflict-modal-title"
    role="dialog"
    aria-modal="true"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="isConflictModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
        @click="dismissConflictModal()"
    ></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
        <div
            x-show="isConflictModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-2xl transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-amber-200/80"
        >
            {{-- Modal Top Warning Bar --}}
            <div class="h-2 w-full bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500"></div>

            <div class="p-6 sm:p-8">
                {{-- Modal Header --}}
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 border border-amber-200/60">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 mb-1 border border-amber-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Schedule Clash Detected
                            </span>
                            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight" id="conflict-modal-title">
                                Time Conflict Detected
                            </h3>
                            <p class="mt-1 text-sm text-slate-600">
                                This activity overlaps with an existing scheduled activity.
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="dismissConflictModal()"
                        class="rounded-xl p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors"
                        title="Dismiss Warning"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                {{-- Conflict Comparison Section --}}
                <div class="mt-6 space-y-4">
                    {{-- 1. New Activity Card --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 sm:p-5">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/80 mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                <span class="inline-block h-2 w-2 rounded-full bg-blue-500"></span>
                                New Activity (Not Saved)
                            </span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-700" x-text="conflictData.candidate ? conflictData.candidate.date : ''"></span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <span class="block text-xs font-medium text-slate-500">Activity Name</span>
                                <span class="text-base font-bold text-slate-900" x-text="conflictData.candidate ? conflictData.candidate.name : ''"></span>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-slate-500">Scheduled Time</span>
                                <div class="flex items-center gap-1.5 text-sm font-bold text-slate-900 mt-0.5">
                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span x-text="conflictData.candidate ? `${conflictData.candidate.formattedStartTime} – ${conflictData.candidate.formattedEndTime}` : ''"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Conflicting Activities List --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-700 flex items-center gap-1.5">
                                <span class="inline-block h-2 w-2 rounded-full bg-amber-500"></span>
                                Conflicting Scheduled Activity (<span x-text="conflictData.conflicts.length"></span> Found)
                            </span>
                            <span class="text-[11px] font-medium text-amber-800 bg-amber-100/70 px-2 py-0.5 rounded">
                                Overlap condition: (newStart < existingEnd) AND (newEnd > existingStart)
                            </span>
                        </div>

                        <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                            <template x-for="(conflict, index) in conflictData.conflicts" :key="index">
                                <div class="rounded-2xl border-2 border-amber-300 bg-amber-50/50 p-4 sm:p-5 relative overflow-hidden transition-all">
                                    {{-- Highlight accent strip --}}
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-amber-400"></div>

                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-amber-200/60 mb-3">
                                        <div>
                                            <span class="text-xs font-semibold text-amber-800">Conflicting Activity #<span x-text="index + 1"></span>:</span>
                                            <h4 class="text-base font-bold text-slate-900" x-text="conflict.name"></h4>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-200 text-amber-900 self-start sm:self-auto border border-amber-300">
                                            ⚠️ <span class="ml-1" x-text="conflict.overlapDurationLabel"></span>
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                        <div>
                                            <span class="text-slate-500 font-medium">Existing Start Time</span>
                                            <span class="block text-sm font-bold text-slate-800" x-text="conflict.formattedStartTime"></span>
                                        </div>
                                        <div>
                                            <span class="text-slate-500 font-medium">Existing End Time</span>
                                            <span class="block text-sm font-bold text-slate-800" x-text="conflict.formattedEndTime"></span>
                                        </div>
                                        <div>
                                            <span class="text-amber-800 font-medium">Overlapping Interval</span>
                                            <span class="block text-sm font-bold text-amber-900 bg-amber-100/90 px-2 py-0.5 rounded" x-text="conflict.formattedOverlapRange"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Information alert box --}}
                <div class="mt-5 rounded-xl bg-slate-50 p-3.5 border border-slate-200 flex items-start gap-2.5 text-xs text-slate-600">
                    <svg class="h-4 w-4 text-slate-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <span class="font-bold text-slate-800">Note:</span> This conflicting activity has <strong class="text-slate-900">not</strong> been saved. You can choose to dismiss this warning to return to the timetable, or click <em>Modify Times</em> to select a non-overlapping time slot.
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5 pt-4 border-t border-slate-100">
                    <button
                        type="button"
                        @click="dismissConflictModal()"
                        class="w-full sm:w-auto px-5 py-2.5 text-xs font-bold rounded-xl border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 transition-colors shadow-sm"
                    >
                        Dismiss (Do Not Save)
                    </button>
                    <button
                        type="button"
                        @click="adjustConflictTimes()"
                        class="w-full sm:w-auto px-5 py-2.5 text-xs font-bold rounded-xl text-slate-900 bg-amber-400 hover:bg-amber-300 transition-colors shadow-sm flex items-center justify-center gap-1.5"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Modify Activity Times</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
