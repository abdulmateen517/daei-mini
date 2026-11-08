{{-- Add & Edit Activity Form Modal (Sections 4 & 5) --}}
<div
    x-show="isAddModalOpen || isEditModalOpen"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="activity-modal-title"
    role="dialog"
    aria-modal="true"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="isAddModalOpen || isEditModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"
        @click="closeFormModal()"
    ></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
        <div
            x-show="isAddModalOpen || isEditModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-lg transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-200"
        >
            {{-- Header with Dark Navy accent --}}
            <div class="bg-slate-900 px-6 py-5 text-white flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2 py-0.5 rounded-full border border-amber-400/20">
                        Daily Timetable
                    </span>
                    <h3 class="text-lg font-bold text-white mt-1" id="activity-modal-title" x-text="isEditModalOpen ? 'Edit Scheduled Activity' : 'Add New Activity'"></h3>
                    <p class="text-xs text-slate-300 mt-0.5">
                        <span x-show="!isEditModalOpen">Enter activity details below. Automatic conflict detection runs on submit.</span>
                        <span x-show="isEditModalOpen">Modify existing activity information and recheck schedule conflicts.</span>
                    </p>
                </div>
                <button
                    type="button"
                    @click="closeFormModal()"
                    class="rounded-xl p-1.5 text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
                >
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            {{-- Form Body --}}
            <form @submit.prevent="submitForm()" class="p-6 space-y-4">
                {{-- Activity Name --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Activity Name <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        x-model="formData.name"
                        placeholder="e.g. Ollaa Design Kickoff or Team Collaboration"
                        class="w-full rounded-xl border px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"
                        :class="formErrors.name ? 'border-rose-400 bg-rose-50/20' : 'border-slate-300 bg-white'"
                        required
                    />
                    <template x-if="formErrors.name">
                        <p class="mt-1 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span x-text="formErrors.name"></span>
                        </p>
                    </template>
                </div>

                {{-- Activity Date & Category Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    {{-- Activity Date --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Activity Date <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="date"
                            x-model="formData.date"
                            class="w-full rounded-xl border px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"
                            :class="formErrors.date ? 'border-rose-400 bg-rose-50/20' : 'border-slate-300 bg-white'"
                            required
                        />
                        <template x-if="formErrors.date">
                            <p class="mt-1 text-xs text-rose-600 font-medium" x-text="formErrors.date"></p>
                        </template>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Category
                        </label>
                        <select
                            x-model="formData.category"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"
                        >
                            <option value="Work">Work / Deep Focus</option>
                            <option value="Study">Study & Research</option>
                            <option value="Worship">Worship & Prayer</option>
                            <option value="Health">Exercise & Health</option>
                            <option value="Habit">Habit & Routine</option>
                        </select>
                    </div>
                </div>

                {{-- Start Time & End Time --}}
                <div class="grid grid-cols-2 gap-3.5">
                    {{-- Start Time --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Start Time <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="time"
                            x-model="formData.startTime"
                            class="w-full rounded-xl border px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"
                            :class="formErrors.time ? 'border-rose-400 bg-rose-50/20' : 'border-slate-300 bg-white'"
                            required
                        />
                    </div>

                    {{-- End Time --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            End Time <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="time"
                            x-model="formData.endTime"
                            class="w-full rounded-xl border px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"
                            :class="formErrors.time ? 'border-rose-400 bg-rose-50/20' : 'border-slate-300 bg-white'"
                            required
                        />
                    </div>
                </div>

                {{-- Time validation error message --}}
                <template x-if="formErrors.time">
                    <p class="text-xs text-rose-600 font-medium flex items-center gap-1.5 p-2 rounded-lg bg-rose-50 border border-rose-200">
                        <svg class="w-4 h-4 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span x-text="formErrors.time"></span>
                    </p>
                </template>

                {{-- Notes / Description (Optional) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Notes / Agenda (Optional)
                    </label>
                    <textarea
                        x-model="formData.notes"
                        rows="2"
                        placeholder="Add location, meeting link, or brief agenda..."
                        class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all resize-none"
                    ></textarea>
                </div>

                {{-- Form Actions --}}
                <div class="pt-3 flex items-center justify-end gap-2.5 border-t border-slate-100">
                    <button
                        type="button"
                        @click="closeFormModal()"
                        class="px-4 py-2.5 text-xs font-bold rounded-xl border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 transition-colors shadow-sm"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2.5 text-xs font-bold rounded-xl text-white bg-slate-900 hover:bg-slate-800 transition-colors shadow-sm flex items-center gap-2 border border-slate-800"
                    >
                        <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span x-text="isEditModalOpen ? 'Save Changes' : 'Schedule Activity'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
