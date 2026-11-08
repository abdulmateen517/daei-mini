{{-- All Feature Action Modals --}}

{{-- 1. Add Habit Modal --}}
<div x-show="isAddHabitModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="isAddHabitModalOpen = false"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl border border-slate-200">
            <h3 class="text-base font-bold text-slate-900 mb-1">Create Daily Habit</h3>
            <p class="text-xs text-slate-500 mb-4">Establish positive habits and maintain your daily Barakah streak.</p>

            <form @submit.prevent="addHabitSubmit()" class="space-y-3.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Habit Title *</label>
                    <input type="text" x-model="newHabit.title" placeholder="e.g., Tahajjud (2 Rakaat) or Read 10 Pages" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900" required />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Category</label>
                        <select x-model="newHabit.category" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs text-slate-900">
                            <option value="Spiritual">Spiritual / Ibadah</option>
                            <option value="Knowledge">Knowledge / Study</option>
                            <option value="Health">Physical / Health</option>
                            <option value="Mindset">Mindset / Discipline</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Target Frequency</label>
                        <select x-model="newHabit.targetPerWeek" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs text-slate-900">
                            <option value="7/7 days">Daily (7/7 days)</option>
                            <option value="5/7 days">5 days / week</option>
                            <option value="3/7 days">3 days / week</option>
                        </select>
                    </div>
                </div>

                <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="isAddHabitModalOpen = false" class="px-4 py-2 text-xs font-bold rounded-xl border border-slate-300 text-slate-700">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl text-slate-900 bg-amber-400 hover:bg-amber-300">Create Habit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. Add Personal Goal Modal --}}
<div x-show="isAddGoalModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="isAddGoalModalOpen = false"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl border border-slate-200">
            <h3 class="text-base font-bold text-slate-900 mb-1">Set Personal Goal</h3>
            <p class="text-xs text-slate-500 mb-4">Define a spiritual, memorization, or personal development milestone.</p>

            <form @submit.prevent="addGoalSubmit()" class="space-y-3.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Goal Title *</label>
                    <input type="text" x-model="newGoal.title" placeholder="e.g. Complete Memorization of Surah Al-Kahf" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900" required />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Category</label>
                        <select x-model="newGoal.category" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs text-slate-900">
                            <option value="Quran & Hifdh">Quran & Hifdh</option>
                            <option value="Islamic Studies">Islamic Studies</option>
                            <option value="Spiritual Discipline">Spiritual Discipline</option>
                            <option value="Health & Fitness">Health & Fitness</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Target Date</label>
                        <input type="date" x-model="newGoal.targetDate" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900" required />
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Total Milestones / Units</label>
                    <input type="number" min="1" max="500" x-model="newGoal.milestonesTotal" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900" placeholder="e.g., 30 verses" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Description / Action Plan</label>
                    <textarea rows="2" x-model="newGoal.description" placeholder="Specific daily action to hit this milestone..." class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 resize-none"></textarea>
                </div>

                <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="isAddGoalModalOpen = false" class="px-4 py-2 text-xs font-bold rounded-xl border border-slate-300 text-slate-700">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl text-slate-900 bg-amber-400 hover:bg-amber-300">Save Goal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 3. Log Exercise Modal --}}
<div x-show="isAddExerciseModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="isAddExerciseModalOpen = false"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl border border-slate-200">
            <h3 class="text-base font-bold text-slate-900 mb-1">Log Exercise Activity</h3>
            <p class="text-xs text-slate-500 mb-4">Record your workout or calisthenics routine to stay physically upright.</p>

            <form @submit.prevent="addExerciseSubmit()" class="space-y-3.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Workout Activity *</label>
                    <input type="text" x-model="newExercise.title" placeholder="e.g. Brisk Walking or Pushups & Planks" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900" required />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Duration</label>
                        <select x-model="newExercise.duration" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs text-slate-900">
                            <option value="15 mins">15 mins</option>
                            <option value="30 mins">30 mins</option>
                            <option value="45 mins">45 mins</option>
                            <option value="60 mins">60 mins</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Intensity</label>
                        <select x-model="newExercise.intensity" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs text-slate-900">
                            <option value="Low">Low (Walk/Stretch)</option>
                            <option value="Moderate">Moderate (Jogging)</option>
                            <option value="High">High (Calisthenics)</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="add-to-tt" x-model="newExercise.addToTimetable" class="rounded text-amber-500 focus:ring-amber-400" />
                    <label for="add-to-tt" class="text-xs font-medium text-slate-700">Add directly to my Daily Timetable</label>
                </div>

                <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="isAddExerciseModalOpen = false" class="px-4 py-2 text-xs font-bold rounded-xl border border-slate-300 text-slate-700">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl text-slate-900 bg-amber-400 hover:bg-amber-300">Log Workout</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 4. Quran / Tafseer Session Slot Modal (Strictly No Reader Disclaimer) --}}
<div x-show="isAddQuranSlotModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="isAddQuranSlotModalOpen = false"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl border border-slate-200">
            <div class="flex items-start justify-between pb-3 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Schedule Study Session Slot</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Plan your Quran reading or Tafseer contemplation block.</p>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-900 border border-amber-200">
                    Time Tracker Only
                </span>
            </div>

            {{-- Prominent Mandatory Scope Disclaimer --}}
            <div class="p-3 rounded-2xl bg-slate-100 border border-slate-200 text-xs text-slate-700 mb-4 flex items-start gap-2">
                <span class="text-amber-500 font-bold shrink-0">📖 Notice:</span>
                <div>
                    Use your own physical Mus-haf or preferred study books for reading. This app strictly tracks your scheduled activity and duration to avoid conflicts.
                </div>
            </div>

            <form @submit.prevent="addQuranSlotSubmit()" class="space-y-3.5">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Session Type</label>
                        <select x-model="newQuranSlot.type" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs text-slate-900">
                            <option value="Quran">Quran Recitation / Hifdh</option>
                            <option value="Tafseer">Tafseer Commentary Study</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Surah / Topic *</label>
                        <input type="text" x-model="newQuranSlot.topic" placeholder="e.g. Surah Al-Kahf (1-30)" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900" required />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Start Time</label>
                        <input type="time" x-model="newQuranSlot.startTime" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900" required />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">End Time</label>
                        <input type="time" x-model="newQuranSlot.endTime" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900" required />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Notes / Reflection Aim</label>
                    <textarea rows="2" x-model="newQuranSlot.notes" placeholder="e.g. Review Ibn Kathir commentary on verses 10-15..." class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 resize-none"></textarea>
                </div>

                <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="isAddQuranSlotModalOpen = false" class="px-4 py-2 text-xs font-bold rounded-xl border border-slate-300 text-slate-700">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl text-slate-900 bg-amber-400 hover:bg-amber-300">Add to Timetable</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 5. Add Reading Book Modal --}}
<div x-show="isAddReadingModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="isAddReadingModalOpen = false"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl border border-slate-200">
            <h3 class="text-base font-bold text-slate-900 mb-1">Track New Literature / Book</h3>
            <p class="text-xs text-slate-500 mb-4">Add a book to track pages read and personal reading progress.</p>

            <form @submit.prevent="addReadingSubmit()" class="space-y-3.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Book Title *</label>
                    <input type="text" x-model="newReading.title" placeholder="e.g. Riyadh as-Saliheen" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900" required />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Author</label>
                        <input type="text" x-model="newReading.author" placeholder="Author / Scholar" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Total Pages</label>
                        <input type="number" min="1" x-model="newReading.totalPages" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900" required />
                    </div>
                </div>

                <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="isAddReadingModalOpen = false" class="px-4 py-2 text-xs font-bold rounded-xl border border-slate-300 text-slate-700">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl text-slate-900 bg-amber-400 hover:bg-amber-300">Add Book</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 6. Add Journal Modal (Private) --}}
<div x-show="isAddJournalModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="isAddJournalModalOpen = false"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Personal Reflection & Journal</h3>
                    <p class="text-xs text-slate-500">Private entry — locked from administrator inspection.</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                    🔒 Strictly Confidential
                </span>
            </div>

            <form @submit.prevent="addJournalSubmit()" class="space-y-3.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Reflection Title *</label>
                    <input type="text" x-model="newJournal.title" placeholder="e.g. Sincerity in Dawah and Heart Purification" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900" required />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Current Mood / State</label>
                        <select x-model="newJournal.mood" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs text-slate-900">
                            <option value="Grateful">Peaceful & Grateful</option>
                            <option value="Reflective">Reflective / Muhasabah</option>
                            <option value="Determined">Determined & Motivated</option>
                            <option value="Contrite">Contrite (Tawbah / Seeking Forgiveness)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tags (comma separated)</label>
                        <input type="text" x-model="newJournal.tags" placeholder="Gratitude, Dawah, Salah" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900" />
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Journal Thoughts & Reflections *</label>
                    <textarea rows="4" x-model="newJournal.content" placeholder="Write your honest reflections, personal lessons, and prayers for today..." class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 resize-none" required></textarea>
                </div>

                <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="isAddJournalModalOpen = false" class="px-4 py-2 text-xs font-bold rounded-xl border border-slate-300 text-slate-700">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl text-slate-900 bg-amber-400 hover:bg-amber-300">Save Journal Entry</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 7. Add Group / Circle Modal (Admin) --}}
<div x-show="isAddGroupModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="isAddGroupModalOpen = false"></div>
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl border border-slate-200">
            <h3 class="text-base font-bold text-slate-900 mb-1">Create Mentee Circle</h3>
            <p class="text-xs text-slate-500 mb-4">Organize mentees into structured accountability halaqahs.</p>

            <form @submit.prevent="addGroupSubmit()" class="space-y-3.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Circle Name *</label>
                    <input type="text" x-model="newGroup.name" placeholder="e.g. Circle Yarmouk (Seerah & Dawah)" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900" required />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Weekly Meeting Slot</label>
                    <input type="text" x-model="newGroup.meetingDay" placeholder="e.g. Tuesdays 8:00 PM" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900" required />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Circle Scope / Focus</label>
                    <textarea rows="2" x-model="newGroup.description" placeholder="Circle curriculum and focus areas..." class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs text-slate-900 resize-none"></textarea>
                </div>

                <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="isAddGroupModalOpen = false" class="px-4 py-2 text-xs font-bold rounded-xl border border-slate-300 text-slate-700">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl text-slate-900 bg-amber-400 hover:bg-amber-300">Create Circle</button>
                </div>
            </form>
        </div>
    </div>
</div>
