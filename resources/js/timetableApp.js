import {
    timeToMinutes,
    minutesToTime,
    format12Hour,
    formatDuration,
    validateActivityTimes,
    findConflicts,
    buildConflictMap
} from './utils/conflictDetector.js';

import {
    INITIAL_USER,
    INITIAL_ADMIN,
    INITIAL_PRAYERS,
    INITIAL_ACTIVITIES,
    INITIAL_HABITS,
    INITIAL_GOALS,
    INITIAL_EXERCISES,
    INITIAL_READING,
    INITIAL_JOURNAL,
    INITIAL_REPORTS,
    INITIAL_ADMIN_USERS,
    INITIAL_CIRCLES,
    getStored,
    setStored
} from './appStore.js';

const STORAGE_KEYS = {
    USER: 'daei_user_profile_v1',
    ACTIVITIES: 'daei_mini_timetable_activities_v1',
    PRAYERS: 'daei_prayers_v1',
    HABITS: 'daei_habits_v1',
    GOALS: 'daei_goals_v1',
    EXERCISES: 'daei_exercises_v1',
    JOURNAL: 'daei_journal_v1',
    REPORTS: 'daei_reports_v1',
    READING: 'daei_reading_v1',
    ADMIN_USERS: 'daei_admin_users_v1',
    CIRCLES: 'daei_circles_v1',
    ACTIVE_ROLE: 'daei_active_role_v1',
};

export function timetableManager() {
    return {
        // --- Core Application State ---
        currentRole: 'user', // 'user' | 'admin'
        activeUserTab: 'dashboard', // 'dashboard' | 'timetable' | 'prayers' | 'habits' | 'goals' | 'exercise' | 'quran' | 'reading' | 'journal' | 'self-assessment' | 'reports' | 'feedback'
        activeAdminTab: 'overview', // 'overview' | 'users' | 'groups' | 'timetables' | 'progress' | 'reports' | 'feedback'

        user: INITIAL_USER,
        admin: INITIAL_ADMIN,
        selectedDate: '2026-11-08',
        todayDateString: '2026-11-08',

        // Data Collections
        activities: [],
        prayers: [],
        habits: [],
        goals: [],
        exercises: [],
        readingList: [],
        journalEntries: [],
        reports: {},
        adminUsers: [],
        circles: [],

        // Timetable & Conflict State (Preserving Task 3)
        filterCategory: 'All',
        searchQuery: '',
        isAddModalOpen: false,
        isEditModalOpen: false,
        isConflictModalOpen: false,
        isDeleteModalOpen: false,
        activityToDelete: null,

        formData: {
            id: null,
            name: '',
            date: '2026-11-08',
            startTime: '09:00',
            endTime: '10:00',
            category: 'Work',
            notes: '',
        },
        formErrors: { name: '', date: '', time: '' },

        conflictData: {
            candidate: null,
            conflicts: [],
            isEditing: false,
        },
        highlightedActivityIds: [],

        // Modal States for Other Features
        isAddHabitModalOpen: false,
        newHabit: { title: '', category: 'Spiritual', targetPerWeek: '7/7 days' },

        isAddGoalModalOpen: false,
        newGoal: { title: '', category: 'Quran & Hifdh', targetDate: '2026-12-31', milestonesTotal: 10, description: '' },

        isAddExerciseModalOpen: false,
        newExercise: { title: '', duration: '30 mins', timeSlot: '07:00 AM', intensity: 'Moderate', calories: 200, notes: '', addToTimetable: true },

        isAddQuranSlotModalOpen: false,
        newQuranSlot: { type: 'Quran', topic: 'Surah Al-Mulk Review', startTime: '06:00', endTime: '06:45', reminder: true, notes: 'Focus on verses 1-15' },

        isAddReadingModalOpen: false,
        newReading: { title: '', author: '', category: 'Seerah & History', totalPages: 300, keyTakeaway: '' },

        isAddJournalModalOpen: false,
        newJournal: { title: '', mood: 'Grateful', content: '', tags: 'Reflections' },
        selectedJournalItem: null,

        // Daily Report & Self-Assessment State
        activeReportDate: '2026-11-08',
        todaySelfAssessment: {
            spiritualRating: 4,
            productivityRating: 4,
            disciplineRating: 5,
            notes: 'Alhamdulillah, steady focus and consistent prayer tracking.',
        },

        // Admin Inspector
        selectedAdminUser: null,
        newMentorCommentText: '',
        isAddGroupModalOpen: false,
        newGroup: { name: '', meetingDay: 'Sundays 6 PM', description: '', leadMentor: 'Ustadh Farhan Al-Mansoor' },

        // Toast & Sidebar
        toast: { show: false, message: '', type: 'success' },
        isSidebarOpen: false,

        // --- Lifecycle ---
        init() {
            this.loadAllState();
            this.detectActiveUrlRoute();
            this.refreshConflictsHighlighting();
        },

        detectActiveUrlRoute() {
            const path = window.location.pathname;
            if (path.startsWith('/admin')) {
                this.currentRole = 'admin';
                if (path === '/admin/users') this.activeAdminTab = 'users';
                else if (path === '/admin/groups') this.activeAdminTab = 'groups';
                else if (path === '/admin/timetables') this.activeAdminTab = 'timetables';
                else if (path === '/admin/progress') this.activeAdminTab = 'progress';
                else if (path === '/admin/reports') this.activeAdminTab = 'reports';
                else if (path === '/admin/feedback') this.activeAdminTab = 'feedback';
                else this.activeAdminTab = 'overview';
            } else {
                this.currentRole = 'user';
                if (path === '/timetable') this.activeUserTab = 'timetable';
                else if (path === '/prayers') this.activeUserTab = 'prayers';
                else if (path === '/habits') this.activeUserTab = 'habits';
                else if (path === '/goals') this.activeUserTab = 'goals';
                else if (path === '/exercise') this.activeUserTab = 'exercise';
                else if (path === '/quran-tafseer') this.activeUserTab = 'quran';
                else if (path === '/reading') this.activeUserTab = 'reading';
                else if (path === '/journal') this.activeUserTab = 'journal';
                else if (path === '/self-assessment') this.activeUserTab = 'self-assessment';
                else if (path === '/daily-report') this.activeUserTab = 'reports';
                else if (path === '/feedback') this.activeUserTab = 'feedback';
                else this.activeUserTab = 'dashboard';
            }
        },

        loadAllState() {
            this.activities = getStored(STORAGE_KEYS.ACTIVITIES, INITIAL_ACTIVITIES);
            this.prayers = getStored(STORAGE_KEYS.PRAYERS, INITIAL_PRAYERS);
            this.habits = getStored(STORAGE_KEYS.HABITS, INITIAL_HABITS);
            this.goals = getStored(STORAGE_KEYS.GOALS, INITIAL_GOALS);
            this.exercises = getStored(STORAGE_KEYS.EXERCISES, INITIAL_EXERCISES);
            this.readingList = getStored(STORAGE_KEYS.READING, INITIAL_READING);
            this.journalEntries = getStored(STORAGE_KEYS.JOURNAL, INITIAL_JOURNAL);
            this.reports = getStored(STORAGE_KEYS.REPORTS, INITIAL_REPORTS);
            this.adminUsers = getStored(STORAGE_KEYS.ADMIN_USERS, INITIAL_ADMIN_USERS);
            this.circles = getStored(STORAGE_KEYS.CIRCLES, INITIAL_CIRCLES);
            this.selectedAdminUser = this.adminUsers[0] || null;
        },

        saveAllState() {
            setStored(STORAGE_KEYS.ACTIVITIES, this.activities);
            setStored(STORAGE_KEYS.PRAYERS, this.prayers);
            setStored(STORAGE_KEYS.HABITS, this.habits);
            setStored(STORAGE_KEYS.GOALS, this.goals);
            setStored(STORAGE_KEYS.EXERCISES, this.exercises);
            setStored(STORAGE_KEYS.READING, this.readingList);
            setStored(STORAGE_KEYS.JOURNAL, this.journalEntries);
            setStored(STORAGE_KEYS.REPORTS, this.reports);
            setStored(STORAGE_KEYS.ADMIN_USERS, this.adminUsers);
            setStored(STORAGE_KEYS.CIRCLES, this.circles);
        },

        // --- Role Switcher ---
        switchRole(newRole) {
            this.currentRole = newRole;
            this.showToast(`Switched to ${newRole === 'admin' ? 'Admin / Mentor' : 'User'} Workspace.`);
        },

        navigateToUserTab(tab) {
            this.currentRole = 'user';
            this.activeUserTab = tab;
            this.isSidebarOpen = false;
        },

        navigateToAdminTab(tab) {
            this.currentRole = 'admin';
            this.activeAdminTab = tab;
            this.isSidebarOpen = false;
        },

        // ==========================================
        // 1. PRAYER TRACKER FUNCTIONALITY
        // ==========================================
        togglePrayer(prayerId) {
            const p = this.prayers.find(item => item.id === prayerId);
            if (p) {
                p.completed = !p.completed;
                p.timestamp = p.completed ? new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : null;
                this.saveAllState();
                this.showToast(`${p.name} marked ${p.completed ? 'completed ✓' : 'incomplete'}.`);
            }
        },

        togglePrayerJamaah(prayerId) {
            const p = this.prayers.find(item => item.id === prayerId);
            if (p) {
                p.inJamaah = !p.inJamaah;
                this.saveAllState();
                this.showToast(`${p.name} congregation status updated.`);
            }
        },

        togglePrayerSunnah(prayerId) {
            const p = this.prayers.find(item => item.id === prayerId);
            if (p) {
                p.sunnahCompleted = !p.sunnahCompleted;
                this.saveAllState();
                this.showToast(`${p.name} Sunnah status updated.`);
            }
        },

        get completedPrayersCount() {
            return this.prayers.filter(p => p.completed).length;
        },

        get jamaahPrayersCount() {
            return this.prayers.filter(p => p.inJamaah).length;
        },

        get prayersScore() {
            return Math.round((this.completedPrayersCount / (this.prayers.length || 5)) * 100);
        },

        // ==========================================
        // 2. HABITS & GOALS FUNCTIONALITY
        // ==========================================
        toggleHabit(habitId) {
            const h = this.habits.find(item => item.id === habitId);
            if (h) {
                h.completedToday = !h.completedToday;
                if (h.completedToday) {
                    h.streak = (h.streak || 0) + 1;
                } else {
                    h.streak = Math.max(0, (h.streak || 1) - 1);
                }
                this.saveAllState();
                this.showToast(`Habit "${h.title}" ${h.completedToday ? 'completed for today! 🔥' : 'marked incomplete.'}`);
            }
        },

        addHabitSubmit() {
            if (!this.newHabit.title.trim()) return;
            const habit = {
                id: `h-${Date.now()}`,
                title: this.newHabit.title.trim(),
                category: this.newHabit.category || 'Spiritual',
                streak: 1,
                targetPerWeek: this.newHabit.targetPerWeek || '7/7 days',
                completedToday: true,
                history: [true]
            };
            this.habits.unshift(habit);
            this.newHabit = { title: '', category: 'Spiritual', targetPerWeek: '7/7 days' };
            this.isAddHabitModalOpen = false;
            this.saveAllState();
            this.showToast(`Habit "${habit.title}" created successfully.`);
        },

        deleteHabit(id) {
            this.habits = this.habits.filter(h => h.id !== id);
            this.saveAllState();
            this.showToast('Habit removed.');
        },

        get completedHabitsToday() {
            return this.habits.filter(h => h.completedToday).length;
        },

        // Goals
        addGoalSubmit() {
            if (!this.newGoal.title.trim()) return;
            const goal = {
                id: `g-${Date.now()}`,
                title: this.newGoal.title.trim(),
                category: this.newGoal.category || 'Islamic Studies',
                targetDate: this.newGoal.targetDate || '2026-12-31',
                progress: 10,
                milestonesTotal: parseInt(this.newGoal.milestonesTotal, 10) || 10,
                milestonesDone: 1,
                description: this.newGoal.description.trim() || 'Personal development milestone'
            };
            this.goals.unshift(goal);
            this.newGoal = { title: '', category: 'Quran & Hifdh', targetDate: '2026-12-31', milestonesTotal: 10, description: '' };
            this.isAddGoalModalOpen = false;
            this.saveAllState();
            this.showToast(`Personal Goal "${goal.title}" created.`);
        },

        updateGoalProgress(goalId, newProgress) {
            const g = this.goals.find(item => item.id === goalId);
            if (g) {
                g.progress = Math.min(100, Math.max(0, parseInt(newProgress, 10)));
                g.milestonesDone = Math.round((g.progress / 100) * (g.milestonesTotal || 10));
                this.saveAllState();
            }
        },

        deleteGoal(id) {
            this.goals = this.goals.filter(g => g.id !== id);
            this.saveAllState();
            this.showToast('Goal removed.');
        },

        // ==========================================
        // 3. EXERCISE & FITNESS TRACKER
        // ==========================================
        toggleExerciseCompleted(id) {
            const ex = this.exercises.find(e => e.id === id);
            if (ex) {
                ex.completed = !ex.completed;
                this.saveAllState();
                this.showToast(`Exercise "${ex.title}" updated.`);
            }
        },

        addExerciseSubmit() {
            if (!this.newExercise.title.trim()) return;
            const ex = {
                id: `ex-${Date.now()}`,
                title: this.newExercise.title.trim(),
                date: this.selectedDate,
                duration: this.newExercise.duration || '30 mins',
                timeSlot: this.newExercise.timeSlot || '07:00 AM',
                intensity: this.newExercise.intensity || 'Moderate',
                calories: parseInt(this.newExercise.calories, 10) || 200,
                completed: false,
                notes: this.newExercise.notes || ''
            };
            this.exercises.unshift(ex);

            // Optional: Automatically add to daily timetable
            if (this.newExercise.addToTimetable) {
                const startHour = this.newExercise.timeSlot.includes('PM') ? '17:00' : '07:00';
                const endHour = this.newExercise.timeSlot.includes('PM') ? '17:45' : '07:45';
                this.activities.push({
                    id: `act-${Date.now()}`,
                    name: `Exercise: ${ex.title}`,
                    date: this.selectedDate,
                    startTime: startHour,
                    endTime: endHour,
                    category: 'Health',
                    notes: `${ex.intensity} intensity (${ex.duration})`,
                    completed: false
                });
            }

            this.newExercise = { title: '', duration: '30 mins', timeSlot: '07:00 AM', intensity: 'Moderate', calories: 200, notes: '', addToTimetable: true };
            this.isAddExerciseModalOpen = false;
            this.saveAllState();
            this.showToast(`Exercise logged and synchronized.`);
        },

        deleteExercise(id) {
            this.exercises = this.exercises.filter(e => e.id !== id);
            this.saveAllState();
            this.showToast('Exercise record removed.');
        },

        // ==========================================
        // 4. QURAN & TAFSEER SESSION TRACKING (NO READER)
        // ==========================================
        addQuranSlotSubmit() {
            if (!this.newQuranSlot.topic.trim()) return;
            const candidate = {
                id: `act-${Date.now()}`,
                name: `${this.newQuranSlot.type} Session: ${this.newQuranSlot.topic.trim()}`,
                date: this.selectedDate,
                startTime: this.newQuranSlot.startTime,
                endTime: this.newQuranSlot.endTime,
                category: 'Study',
                notes: this.newQuranSlot.notes.trim() || 'Personal study session using external Mus-haf / Tafseer book',
                completed: false
            };

            // Run Conflict Detection before saving
            const conflicts = findConflicts(candidate, this.activities);
            if (conflicts.length > 0) {
                this.conflictData = {
                    candidate: {
                        name: candidate.name,
                        date: candidate.date,
                        startTime: candidate.startTime,
                        endTime: candidate.endTime,
                        formattedStartTime: format12Hour(candidate.startTime),
                        formattedEndTime: format12Hour(candidate.endTime)
                    },
                    conflicts,
                    isEditing: false
                };
                this.highlightedActivityIds = conflicts.map(c => c.conflictingId);
                this.isAddQuranSlotModalOpen = false;
                this.isConflictModalOpen = true;
                this.showToast('Conflict Detected with existing schedule slot!', 'warning');
                return;
            }

            this.activities.push(candidate);
            this.isAddQuranSlotModalOpen = false;
            this.newQuranSlot = { type: 'Quran', topic: '', startTime: '06:00', endTime: '06:45', reminder: true, notes: '' };
            this.saveAllState();
            this.showToast(`${candidate.name} added to your Daily Timetable.`);
        },

        // ==========================================
        // 5. DIGITAL LIBRARY & READING MANAGEMENT
        // ==========================================
        updateReadingProgress(bookId, deltaPages) {
            const book = this.readingList.find(b => b.id === bookId);
            if (book) {
                const current = parseInt(book.readPages, 10) || 0;
                const total = parseInt(book.totalPages, 10) || 100;
                const updated = Math.min(total, Math.max(0, current + deltaPages));
                book.readPages = updated;
                book.completed = updated >= total;
                book.status = book.completed ? 'Completed' : 'Currently Reading';
                this.saveAllState();
                this.showToast(`Updated "${book.title}" to ${updated}/${total} pages.`);
            }
        },

        addReadingSubmit() {
            if (!this.newReading.title.trim()) return;
            const book = {
                id: `lib-${Date.now()}`,
                title: this.newReading.title.trim(),
                author: this.newReading.author.trim() || 'Islamic Scholar',
                category: this.newReading.category || 'Seerah & History',
                totalPages: parseInt(this.newReading.totalPages, 10) || 200,
                readPages: 0,
                completed: false,
                status: 'Currently Reading',
                keyTakeaway: this.newReading.keyTakeaway || 'Study of authentic literature'
            };
            this.readingList.unshift(book);
            this.newReading = { title: '', author: '', category: 'Seerah & History', totalPages: 300, keyTakeaway: '' };
            this.isAddReadingModalOpen = false;
            this.saveAllState();
            this.showToast(`Book "${book.title}" added to your Reading Tracker.`);
        },

        deleteReadingBook(id) {
            this.readingList = this.readingList.filter(b => b.id !== id);
            this.saveAllState();
            this.showToast('Book removed from library.');
        },

        // ==========================================
        // 6. PERSONAL JOURNAL (CONFIDENTIAL)
        // ==========================================
        addJournalSubmit() {
            if (!this.newJournal.title.trim() || !this.newJournal.content.trim()) return;
            const tags = this.newJournal.tags.split(',').map(t => t.trim()).filter(Boolean);
            const entry = {
                id: `j-${Date.now()}`,
                date: this.todayDateString,
                displayDate: `Sunday, 8 November 2026`,
                mood: this.newJournal.mood || 'Reflective',
                title: this.newJournal.title.trim(),
                content: this.newJournal.content.trim(),
                tags: tags.length > 0 ? tags : ['Personal', 'Muhasabah']
            };
            this.journalEntries.unshift(entry);
            this.newJournal = { title: '', mood: 'Grateful', content: '', tags: 'Reflections' };
            this.isAddJournalModalOpen = false;
            this.saveAllState();
            this.showToast('Confidential Journal entry saved locally.');
        },

        deleteJournalEntry(id) {
            this.journalEntries = this.journalEntries.filter(j => j.id !== id);
            if (this.selectedJournalItem?.id === id) {
                this.selectedJournalItem = null;
            }
            this.saveAllState();
            this.showToast('Journal entry deleted.');
        },

        // ==========================================
        // 7. DAILY REPORT & SELF-ASSESSMENT
        // ==========================================
        isReportEditable(dateStr) {
            return dateStr === this.todayDateString;
        },

        saveSelfAssessment() {
            const todayKey = this.todayDateString;
            if (!this.reports[todayKey]) {
                this.reports[todayKey] = {
                    date: todayKey,
                    displayDate: 'Today (Sunday, 8 Nov 2026)',
                    isToday: true,
                    isSubmitted: false,
                    mentorComments: []
                };
            }
            this.reports[todayKey].spiritualRating = this.todaySelfAssessment.spiritualRating;
            this.reports[todayKey].productivityRating = this.todaySelfAssessment.productivityRating;
            this.reports[todayKey].disciplineRating = this.todaySelfAssessment.disciplineRating;
            this.reports[todayKey].notes = this.todaySelfAssessment.notes;
            this.saveAllState();
            this.showToast('Daily self-assessment scores updated! ✓');
        },

        submitTodayReport() {
            const todayKey = this.todayDateString;
            const report = this.reports[todayKey] || {
                date: todayKey,
                displayDate: 'Today (Sunday, 8 Nov 2026)',
                isToday: true,
                mentorComments: []
            };

            report.isSubmitted = true;
            report.submittedAt = 'Just now at ' + new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            report.prayersCompleted = this.completedPrayersCount;
            report.prayersTotal = this.prayers.length;
            report.habitsCompleted = this.completedHabitsToday;
            report.habitsTotal = this.habits.length;
            report.tasksCompleted = this.activities.filter(a => a.completed).length;
            report.tasksTotal = this.activities.length;
            report.spiritualRating = this.todaySelfAssessment.spiritualRating;
            report.productivityRating = this.todaySelfAssessment.productivityRating;
            report.disciplineRating = this.todaySelfAssessment.disciplineRating;
            report.notes = this.todaySelfAssessment.notes;

            this.reports[todayKey] = report;
            this.saveAllState();
            this.showToast('Daily Accountability Report submitted for mentor review! ✓');
        },

        // ==========================================
        // 8. ADMIN & MENTOR PANEL FUNCTIONALITY
        // ==========================================
        selectAdminUser(userId) {
            this.selectedAdminUser = this.adminUsers.find(u => u.id === userId) || this.adminUsers[0];
        },

        addMentorGuidance(reportDate) {
            if (!this.newMentorCommentText.trim()) return;
            const targetReport = this.reports[reportDate] || this.reports[this.todayDateString];
            if (targetReport) {
                if (!targetReport.mentorComments) targetReport.mentorComments = [];
                targetReport.mentorComments.unshift({
                    id: `c-${Date.now()}`,
                    author: this.admin.name,
                    role: this.admin.title,
                    time: 'Just now',
                    text: this.newMentorCommentText.trim()
                });
                this.newMentorCommentText = '';
                this.saveAllState();
                this.showToast('Guidance comment sent to mentee report.');
            }
        },

        addGroupSubmit() {
            if (!this.newGroup.name.trim()) return;
            const group = {
                id: `c-${Date.now()}`,
                name: this.newGroup.name.trim(),
                membersCount: 1,
                leadMentor: this.newGroup.leadMentor || this.admin.name,
                meetingDay: this.newGroup.meetingDay || 'Saturdays 8 PM',
                description: this.newGroup.description.trim() || 'Active mentee circle'
            };
            this.circles.push(group);
            this.newGroup = { name: '', meetingDay: 'Sundays 6 PM', description: '', leadMentor: 'Ustadh Farhan Al-Mansoor' };
            this.isAddGroupModalOpen = false;
            this.saveAllState();
            this.showToast(`Circle "${group.name}" created successfully.`);
        },

        deleteGroup(id) {
            this.circles = this.circles.filter(c => c.id !== id);
            this.saveAllState();
            this.showToast('Circle removed.');
        },

        // ==========================================
        // 9. TASK 3 TIMETABLE & CONFLICT ENGINE (PRESERVED)
        // ==========================================
        get conflictMap() {
            return buildConflictMap(this.activities);
        },

        get filteredActivities() {
            return this.activities
                .filter(act => {
                    const matchDate = this.selectedDate === 'all' || act.date === this.selectedDate;
                    const matchCat = this.filterCategory === 'All' || act.category === this.filterCategory;
                    const matchSearch = !this.searchQuery ||
                        act.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        (act.notes && act.notes.toLowerCase().includes(this.searchQuery.toLowerCase()));
                    return matchDate && matchCat && matchSearch;
                })
                .sort((a, b) => {
                    if (a.date !== b.date) return a.date.localeCompare(b.date);
                    return timeToMinutes(a.startTime) - timeToMinutes(b.startTime);
                });
        },

        get totalActivitiesCount() { return this.activities.length; },
        get todayActivitiesCount() { return this.activities.filter(a => a.date === this.selectedDate).length; },

        get activeConflictsCount() {
            const map = this.conflictMap;
            let count = 0;
            for (const key in map) {
                if (map[key] && map[key].length > 0) count++;
            }
            return count;
        },

        get scheduledMinutesToday() {
            return this.activities
                .filter(a => a.date === this.selectedDate)
                .reduce((acc, curr) => acc + Math.max(0, timeToMinutes(curr.endTime) - timeToMinutes(curr.startTime)), 0);
        },

        get scheduledHoursFormatted() {
            return formatDuration(this.scheduledMinutesToday);
        },

        openAddModal(prefill = {}) {
            this.formData = {
                id: null,
                name: prefill.name || '',
                date: prefill.date || this.selectedDate || '2026-11-08',
                startTime: prefill.startTime || '11:30',
                endTime: prefill.endTime || '12:30',
                category: prefill.category || 'Work',
                notes: prefill.notes || '',
            };
            this.formErrors = { name: '', date: '', time: '' };
            this.isAddModalOpen = true;
            this.isEditModalOpen = false;
        },

        openEditModal(activity) {
            if (!activity) return;
            this.formData = {
                id: activity.id,
                name: activity.name,
                date: activity.date,
                startTime: activity.startTime,
                endTime: activity.endTime,
                category: activity.category || 'Work',
                notes: activity.notes || '',
            };
            this.formErrors = { name: '', date: '', time: '' };
            this.isEditModalOpen = true;
            this.isAddModalOpen = false;
        },

        closeFormModal() {
            this.isAddModalOpen = false;
            this.isEditModalOpen = false;
            this.formErrors = { name: '', date: '', time: '' };
        },

        validateForm() {
            let isValid = true;
            this.formErrors = { name: '', date: '', time: '' };

            if (!this.formData.name || !this.formData.name.trim()) {
                this.formErrors.name = 'Activity name is required.';
                isValid = false;
            }
            if (!this.formData.date) {
                this.formErrors.date = 'Activity date is required.';
                isValid = false;
            }
            if (!this.formData.startTime) {
                this.formErrors.time = 'Start time is required.';
                isValid = false;
            } else if (!this.formData.endTime) {
                this.formErrors.time = 'End time is required.';
                isValid = false;
            } else {
                const timeCheck = validateActivityTimes(this.formData.startTime, this.formData.endTime);
                if (!timeCheck.valid) {
                    this.formErrors.time = timeCheck.error;
                    isValid = false;
                }
            }
            return isValid;
        },

        submitForm() {
            if (!this.validateForm()) return;

            const isEditing = Boolean(this.formData.id);
            const candidate = {
                id: this.formData.id || `act-${Date.now()}`,
                name: this.formData.name.trim(),
                date: this.formData.date,
                startTime: this.formData.startTime,
                endTime: this.formData.endTime,
                category: this.formData.category,
                notes: this.formData.notes.trim(),
                status: 'Pending',
                completed: false
            };

            const conflicts = findConflicts(
                candidate,
                this.activities,
                isEditing ? this.formData.id : null
            );

            if (conflicts.length > 0) {
                this.conflictData = {
                    candidate: {
                        name: candidate.name,
                        date: candidate.date,
                        startTime: candidate.startTime,
                        endTime: candidate.endTime,
                        formattedStartTime: format12Hour(candidate.startTime),
                        formattedEndTime: format12Hour(candidate.endTime),
                    },
                    conflicts,
                    isEditing,
                };
                this.highlightedActivityIds = conflicts.map(c => c.conflictingId);
                this.closeFormModal();
                this.isConflictModalOpen = true;
                this.showToast('Time Conflict Detected! Overlap alert triggered.', 'warning');
                return;
            }

            if (isEditing) {
                const index = this.activities.findIndex(a => a.id === this.formData.id);
                if (index !== -1) {
                    this.activities[index] = { ...this.activities[index], ...candidate };
                }
                this.showToast(`Activity "${candidate.name}" updated successfully.`);
            } else {
                this.activities.push(candidate);
                this.showToast(`Activity "${candidate.name}" scheduled.`);
            }

            this.saveAllState();
            this.closeFormModal();
            this.highlightedActivityIds = [];
        },

        dismissConflictModal() {
            this.isConflictModalOpen = false;
            this.conflictData = { candidate: null, conflicts: [], isEditing: false };
            this.showToast('Conflicting activity was not saved.', 'warning');
        },

        adjustConflictTimes() {
            const candidate = this.conflictData.candidate;
            const isEditing = this.conflictData.isEditing;
            this.isConflictModalOpen = false;

            if (candidate) {
                this.formData = {
                    id: isEditing ? this.formData.id : null,
                    name: candidate.name,
                    date: candidate.date,
                    startTime: candidate.startTime,
                    endTime: candidate.endTime,
                    category: this.formData.category || 'Work',
                    notes: this.formData.notes || '',
                };
            }

            if (isEditing) {
                this.isEditModalOpen = true;
            } else {
                this.isAddModalOpen = true;
            }
        },

        confirmDeleteActivity(activity) {
            this.activityToDelete = activity;
            this.isDeleteModalOpen = true;
        },

        deleteActivityConfirmed() {
            if (!this.activityToDelete) return;
            const id = this.activityToDelete.id;
            const name = this.activityToDelete.name;

            this.activities = this.activities.filter(a => a.id !== id);
            this.saveAllState();
            this.highlightedActivityIds = this.highlightedActivityIds.filter(hid => hid !== id);
            this.isDeleteModalOpen = false;
            this.activityToDelete = null;
            this.showToast(`Activity "${name}" deleted from timetable.`);
        },

        toggleComplete(id) {
            const act = this.activities.find(a => a.id === id);
            if (act) {
                act.completed = !act.completed;
                act.status = act.completed ? 'Completed' : 'Pending';
                this.saveAllState();
            }
        },

        format12(timeStr) { return format12Hour(timeStr); },
        formatDur(mins) { return formatDuration(mins); },

        getActivityDurationMinutes(activity) {
            return Math.max(0, timeToMinutes(activity.endTime) - timeToMinutes(activity.startTime));
        },

        isActivityConflicted(activityId) {
            const conflicts = this.conflictMap[activityId];
            return (conflicts && conflicts.length > 0) || this.highlightedActivityIds.includes(activityId);
        },

        getActivityConflicts(activityId) {
            return this.conflictMap[activityId] || [];
        },

        refreshConflictsHighlighting() {
            const map = this.conflictMap;
            const ids = [];
            for (const id in map) {
                if (map[id] && map[id].length > 0) ids.push(id);
            }
            this.highlightedActivityIds = ids;
        },

        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => { this.toast.show = false; }, 4000);
        },

        // Test Scenarios (Task 3 Section 11)
        loadScenario1() {
            this.selectedDate = '2026-11-08';
            this.activities = [
                { id: 'sc1-standup', name: 'Weekly Team Standup', date: '2026-11-08', startTime: '09:00', endTime: '12:00', category: 'Work', status: 'Pending', notes: 'Sprint review meeting', completed: false }
            ];
            this.saveAllState();
            this.highlightedActivityIds = [];
            this.openAddModal({ name: 'Ollaa Design Kickoff', date: '2026-11-08', startTime: '11:30', endTime: '12:30', category: 'Work' });
            this.showToast('Loaded Example 1: Click "Schedule Activity" to test 30-min overlap alert.');
        },

        loadScenario2() {
            this.selectedDate = '2026-11-08';
            this.activities = [
                { id: 'sc2-collab', name: 'Team Collaboration', date: '2026-11-08', startTime: '14:00', endTime: '16:15', category: 'Work', status: 'Pending', notes: 'Collaborative development', completed: false }
            ];
            this.saveAllState();
            this.highlightedActivityIds = [];
            this.openAddModal({ name: 'Content Approval', date: '2026-11-08', startTime: '16:00', endTime: '18:15', category: 'Work' });
            this.showToast('Loaded Example 2: Click "Schedule Activity" to test 15-min overlap alert.');
        },

        loadScenarioBoundary() {
            this.selectedDate = '2026-11-08';
            this.activities = [
                { id: 'sc-b1', name: 'Sprint Planning Block 1', date: '2026-11-08', startTime: '09:00', endTime: '10:00', category: 'Work', status: 'Pending', notes: 'Touching boundary test', completed: false }
            ];
            this.saveAllState();
            this.highlightedActivityIds = [];
            this.openAddModal({ name: 'Sprint Planning Block 2', date: '2026-11-08', startTime: '10:00', endTime: '11:00', category: 'Work' });
            this.showToast('Loaded Boundary Test: Starts exactly at 10:00 (No conflict).');
        },

        loadScenarioDifferentDates() {
            this.activities = [
                { id: 'sc-d1', name: 'Sunday Morning Standup', date: '2026-11-08', startTime: '09:00', endTime: '10:30', category: 'Work', status: 'Pending', notes: 'Sunday session', completed: false }
            ];
            this.selectedDate = '2026-11-09';
            this.saveAllState();
            this.highlightedActivityIds = [];
            this.openAddModal({ name: 'Monday Morning Standup', date: '2026-11-09', startTime: '09:00', endTime: '10:30', category: 'Work' });
            this.showToast('Loaded Different Dates Test: 2026-11-09 vs 2026-11-08.');
        },

        loadScenarioMultipleConflicts() {
            this.selectedDate = '2026-11-08';
            this.activities = [
                { id: 'sc-m1', name: 'Weekly Sprint Review', date: '2026-11-08', startTime: '09:00', endTime: '10:30', category: 'Work', status: 'Pending', notes: 'First conflicting activity', completed: false },
                { id: 'sc-m2', name: 'Design System Alignment', date: '2026-11-08', startTime: '11:00', endTime: '12:00', category: 'Work', status: 'Pending', notes: 'Second conflicting activity', completed: false }
            ];
            this.saveAllState();
            this.highlightedActivityIds = [];
            this.openAddModal({ name: 'All-Hands Architecture Workshop', date: '2026-11-08', startTime: '10:00', endTime: '12:30', category: 'Study' });
            this.showToast('Loaded Multiple Conflicts Test: Click Schedule to see multiple conflict cards.');
        },

        resetToDefaults() {
            this.activities = [...INITIAL_ACTIVITIES];
            this.prayers = [...INITIAL_PRAYERS];
            this.habits = [...INITIAL_HABITS];
            this.goals = [...INITIAL_GOALS];
            this.exercises = [...INITIAL_EXERCISES];
            this.readingList = [...INITIAL_READING];
            this.journalEntries = [...INITIAL_JOURNAL];
            this.reports = { ...INITIAL_REPORTS };
            this.adminUsers = [...INITIAL_ADMIN_USERS];
            this.circles = [...INITIAL_CIRCLES];
            this.selectedDate = '2026-11-08';
            this.filterCategory = 'All';
            this.searchQuery = '';
            this.saveAllState();
            this.refreshConflictsHighlighting();
            this.closeFormModal();
            this.isConflictModalOpen = false;
            this.showToast('Daei Mini reset to standard initial data.');
        }
    };
}
