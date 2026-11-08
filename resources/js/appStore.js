import {
    timeToMinutes,
    minutesToTime,
    format12Hour,
    formatDuration,
    validateActivityTimes,
    findConflicts,
    buildConflictMap
} from './utils/conflictDetector.js';

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
    COMMENTS: 'daei_mentor_comments_v1',
    ACTIVE_ROLE: 'daei_active_role_v1',
};

// 1. Initial User Profile
export const INITIAL_USER = {
    id: 'u-1',
    name: 'Zayd Ibn Khalid',
    email: 'zayd.khalid@daeimini.org',
    role: 'user',
    circle: 'Circle Badr (Youth Dawah)',
    mentorName: 'Ustadh Farhan Al-Mansoor',
    joinedDate: 'Shawwal 1447 AH',
    streakDays: 14,
    hijriDate: '19 Jumada al-Awwal 1448 AH',
    gregorianDate: 'Sunday, 8 November 2026',
    spiritualScore: 88,
};

// 2. Initial Admin Profile
export const INITIAL_ADMIN = {
    id: 'adm-1',
    name: 'Ustadh Farhan Al-Mansoor',
    email: 'farhan.mansoor@daeimini.org',
    role: 'admin',
    title: 'Senior Murabbi & Circle Lead',
    assignedMenteesCount: 18,
    activeCirclesCount: 3,
};

// 3. Initial Prayers (Five Daily Prayers)
export const INITIAL_PRAYERS = [
    { id: 'fajr', name: 'Fajr', time: '05:15 AM', completed: true, inJamaah: true, sunnahCompleted: true, timestamp: '05:25 AM' },
    { id: 'dhuhr', name: 'Dhuhr', time: '12:35 PM', completed: true, inJamaah: true, sunnahCompleted: true, timestamp: '12:45 PM' },
    { id: 'asr', name: 'Asr', time: '03:45 PM', completed: true, inJamaah: false, sunnahCompleted: true, timestamp: '03:55 PM' },
    { id: 'maghrib', name: 'Maghrib', time: '05:40 PM', completed: true, inJamaah: true, sunnahCompleted: true, timestamp: '05:50 PM' },
    { id: 'isha', name: 'Isha', time: '07:10 PM', completed: false, inJamaah: false, sunnahCompleted: false, timestamp: null },
];

// 4. Initial Timetable Activities (Preserving Task 3)
export const INITIAL_ACTIVITIES = [
    {
        id: 'act-1',
        name: 'Weekly Team Standup',
        date: '2026-11-08',
        startTime: '09:00',
        endTime: '12:00',
        category: 'Work',
        notes: 'Sprint progress review and blocker resolution',
        status: 'Completed',
        completed: true
    },
    {
        id: 'act-2',
        name: 'Dhuhr Prayer & Reflection',
        date: '2026-11-08',
        startTime: '12:30',
        endTime: '13:15',
        category: 'Worship',
        notes: 'Congregational prayer at mosque',
        status: 'Completed',
        completed: true
    },
    {
        id: 'act-3',
        name: 'Team Collaboration',
        date: '2026-11-08',
        startTime: '14:00',
        endTime: '16:15',
        category: 'Work',
        notes: 'Cross-functional UI/UX sync and code review',
        status: 'Pending',
        completed: false
    },
    {
        id: 'act-4',
        name: 'Quran Study Slot: Surah Al-Kahf',
        date: '2026-11-08',
        startTime: '16:30',
        endTime: '17:30',
        category: 'Study',
        notes: 'Review verses 1-30 and reflection notes',
        status: 'Pending',
        completed: false
    },
    {
        id: 'act-5',
        name: 'Maghrib Prayer & Family Dinner',
        date: '2026-11-08',
        startTime: '17:45',
        endTime: '18:45',
        category: 'Worship',
        notes: 'Evening prayer and family time',
        status: 'Pending',
        completed: false
    }
];

// 5. Initial Habits
export const INITIAL_HABITS = [
    { id: 'h-1', title: 'Morning Adhkar & Gratitude', category: 'Spiritual', streak: 18, targetPerWeek: '7/7 days', completedToday: true, history: [true, true, true, true, true, true, true] },
    { id: 'h-2', title: 'Tahajjud / Qiyam al-Layl (2+ Rakaat)', category: 'Spiritual', streak: 5, targetPerWeek: '4/7 days', completedToday: true, history: [false, true, true, true, true, true, true] },
    { id: 'h-3', title: 'Daily Quran & Tafseer Study Slot (20m+)', category: 'Knowledge', streak: 14, targetPerWeek: '7/7 days', completedToday: true, history: [true, true, true, true, true, true, true] },
    { id: 'h-4', title: 'Physical Activity / 30m Workout', category: 'Health', streak: 9, targetPerWeek: '5/7 days', completedToday: true, history: [true, true, false, true, true, true, true] },
    { id: 'h-5', title: 'Evening Adhkar & Self-Reckoning (Muhasabah)', category: 'Spiritual', streak: 12, targetPerWeek: '7/7 days', completedToday: false, history: [true, true, true, true, true, true, false] },
    { id: 'h-6', title: 'Digital Fast (No screens 1hr before sleep)', category: 'Mindset', streak: 6, targetPerWeek: '6/7 days', completedToday: false, history: [true, false, true, true, true, true, false] },
];

// 6. Initial Personal Goals
export const INITIAL_GOALS = [
    { id: 'g-1', title: 'Complete Memorization of Surah Al-Mulk', category: 'Quran & Hifdh', targetDate: '2026-12-15', progress: 80, milestonesTotal: 30, milestonesDone: 24, description: 'Memorize with Tajweed and revise 5 verses daily.' },
    { id: 'g-2', title: 'Read 4 Books on Seerah of the Prophet ﷺ', category: 'Islamic Studies', targetDate: '2027-01-30', progress: 50, milestonesTotal: 4, milestonesDone: 2, description: 'Finish The Sealed Nectar and When the Moon Split.' },
    { id: 'g-3', title: 'Establish 100% On-Time Jama’ah for Fajr', category: 'Spiritual Discipline', targetDate: '2026-12-31', progress: 68, milestonesTotal: 30, milestonesDone: 20, description: 'Maintain strict sleep hygiene to wake up 45m before Fajr Adhan.' },
    { id: 'g-4', title: 'Weekly 10km Running Target', category: 'Health & Fitness', targetDate: '2026-11-30', progress: 85, milestonesTotal: 10, milestonesDone: 8.5, description: 'Split into three 3.5km runs per week.' }
];

// 7. Initial Exercises
export const INITIAL_EXERCISES = [
    { id: 'ex-1', title: 'Brisk Walking & Sunnah Calisthenics', date: '2026-11-08', duration: '45 mins', timeSlot: '06:30 AM', intensity: 'Moderate', calories: 230, completed: true, notes: 'Outdoor park walk with Dhikr repetition' },
    { id: 'ex-2', title: 'Bodyweight Pushups & Core Routine', date: '2026-11-08', duration: '25 mins', timeSlot: '05:00 PM', intensity: 'High', calories: 180, completed: false, notes: '3 sets of 15 pushups, 2m plank, 30 air squats' },
    { id: 'ex-3', title: 'Post-Fajr Jog & Stretching', date: '2026-11-07', duration: '30 mins', timeSlot: '06:00 AM', intensity: 'Low', calories: 160, completed: true, notes: 'Light cardio and mobility stretches' }
];

// 8. Initial Digital Library & Reading Tracking
export const INITIAL_READING = [
    { id: 'lib-1', title: 'Riyadh as-Saliheen (Gardens of the Righteous)', author: 'Imam An-Nawawi', category: 'Hadith & Character', totalPages: 620, readPages: 310, completed: false, status: 'Currently Reading', keyTakeaway: 'The classical anthology on cultivating upright Islamic morals and everyday Sunnah etiquette.' },
    { id: 'lib-2', title: 'The Sealed Nectar (Ar-Raheeq Al-Makhtum)', author: 'Safiur Rahman Al-Mubarakpuri', category: 'Seerah & History', totalPages: 480, readPages: 480, completed: true, status: 'Completed', keyTakeaway: 'Comprehensive and award-winning biography of the Prophet Muhammad ﷺ.' },
    { id: 'lib-3', title: 'Purification of the Heart (Diseases and Cures)', author: 'Hamza Yusuf / Imam Al-Mawlud', category: 'Tazkiyah & Spirituality', totalPages: 210, readPages: 145, completed: false, status: 'Currently Reading', keyTakeaway: 'Signposts on detecting envy, pride, and medicinal prescriptions from the Quran and Sunnah.' },
    { id: 'lib-4', title: 'Tafseer Jalalayn (Concise Study Companion)', author: 'Al-Mahalli & As-Suyuti', category: 'Quranic Sciences', totalPages: 550, readPages: 220, completed: false, status: 'In Progress', keyTakeaway: 'Indispensable concise commentary on linguistic and legal Quranic interpretations.' }
];

// 9. Initial Journal Entries (Private)
export const INITIAL_JOURNAL = [
    {
        id: 'j-1',
        date: '2026-11-08',
        displayDate: 'Sunday, 8 November 2026',
        mood: 'Peaceful & Grateful',
        title: 'Reflections on Surah Al-Kahf & Sincerity in Dawah',
        content: 'Today after Fajr, during my study slot for Surah Al-Kahf, the story of the Companions of the Cave resonated profoundly. They were young men who stood firmly for truth despite societal pressure.\n\nIn our dawah efforts, intention is everything. Am I speaking to be praised, or purely for the sake of Allah? May Allah purify my heart from ostentation (Riyaa) and grant me steadfastness upon the Sunnah.',
        tags: ['Al-Kahf', 'Dawah', 'Muhasabah', 'Gratitude']
    },
    {
        id: 'j-2',
        date: '2026-11-07',
        displayDate: 'Saturday, 7 November 2026',
        mood: 'Reflective',
        title: 'Time Management & The Illusion of Distraction',
        content: 'Noticed that in the afternoon I delayed my tafseer session by scrolling through tech forums. The Prophet ﷺ taught us that health and free time are two blessings many people lose.\n\nRe-organized my timetable for tomorrow to ensure a clear buffer between work and spiritual blocks.',
        tags: ['Productivity', 'Self-Discipline', 'Barakah']
    },
    {
        id: 'j-3',
        date: '2026-11-06',
        displayDate: 'Friday, 6 November 2026',
        mood: 'Motivated',
        title: 'The Sweetness of Tahajjud Prayer',
        content: 'Woke up 40 minutes before Fajr. The silence of the last third of the night is truly incomparable. Made Dua for the Ummah and for clarity in my studies and dawah work. SubhanAllah how much Barakah fills the day when it begins in Qiyam.',
        tags: ['Tahajjud', 'Spiritual', 'Dua']
    }
];

// 10. Initial Daily Reports (Today is editable, Past days are locked read-only)
export const INITIAL_REPORTS = {
    '2026-11-08': {
        date: '2026-11-08',
        displayDate: 'Today (Sunday, 8 Nov 2026)',
        isToday: true,
        isSubmitted: false,
        prayersCompleted: 4,
        prayersTotal: 5,
        habitsCompleted: 4,
        habitsTotal: 6,
        tasksCompleted: 4,
        tasksTotal: 5,
        spiritualRating: 4, // 1-5
        productivityRating: 4, // 1-5
        disciplineRating: 5, // 1-5
        exerciseCompleted: true,
        notes: 'Alhamdulillah, strong focus during the morning block. Still need to complete Isha and evening Adhkar before sleep.',
        submittedAt: null,
        mentorComments: [
            {
                id: 'c-101',
                author: 'Ustadh Farhan Al-Mansoor',
                role: 'Murabbi / Mentor',
                time: '11:30 AM',
                text: 'BarakAllahu Feek, Zayd. I noticed you logged your morning study slot on Surah Al-Kahf on time. Keep up this consistency.'
            }
        ]
    },
    '2026-11-07': {
        date: '2026-11-07',
        displayDate: 'Yesterday (Saturday, 7 Nov 2026)',
        isToday: false, // Locked read-only
        isSubmitted: true,
        prayersCompleted: 5,
        prayersTotal: 5,
        habitsCompleted: 5,
        habitsTotal: 6,
        tasksCompleted: 6,
        tasksTotal: 6,
        spiritualRating: 5,
        productivityRating: 4,
        disciplineRating: 4,
        exerciseCompleted: true,
        notes: 'All 5 prayers prayed with Jamaah. Completed 45 mins of Tafseer study. Had some afternoon fatigue but recovered by Asr.',
        submittedAt: 'Saturday at 09:30 PM',
        mentorComments: [
            {
                id: 'c-102',
                author: 'Ustadh Farhan Al-Mansoor',
                role: 'Murabbi / Mentor',
                time: 'Saturday at 10:15 PM',
                text: 'Excellent consistency on your Jama’ah attendance, Zayd. Masha’Allah! Keep this momentum guarded.'
            }
        ]
    },
    '2026-11-06': {
        date: '2026-11-06',
        displayDate: 'Friday, 6 Nov 2026',
        isToday: false, // Locked read-only
        isSubmitted: true,
        prayersCompleted: 5,
        prayersTotal: 5,
        habitsCompleted: 6,
        habitsTotal: 6,
        tasksCompleted: 8,
        tasksTotal: 8,
        spiritualRating: 5,
        productivityRating: 5,
        disciplineRating: 5,
        exerciseCompleted: true,
        notes: 'A perfect 100% adherence day! Tahajjud was peaceful and productive deep work hours achieved.',
        submittedAt: 'Friday at 09:45 PM',
        mentorComments: [
            {
                id: 'c-103',
                author: 'Ustadh Farhan Al-Mansoor',
                role: 'Murabbi / Mentor',
                time: 'Saturday at 08:00 AM',
                text: 'Masha’Allah TabarakAllah! Days like these prove what is possible with steadfast Barakah.'
            }
        ]
    }
};

// 11. Admin Data (Users, Circles, Activity Stream)
export const INITIAL_ADMIN_USERS = [
    { id: 'u-1', name: 'Zayd Ibn Khalid', email: 'zayd.khalid@daeimini.org', circle: 'Circle Badr (Youth Dawah)', streak: 14, todayReportStatus: 'Pending Submission', prayersToday: '4/5', lastActivity: '12 mins ago', spiritualScore: 88, timetableCompletion: '4/5' },
    { id: 'u-2', name: 'Bilal Al-Ansari', email: 'bilal.ansari@daeimini.org', circle: 'Circle Badr (Youth Dawah)', streak: 21, todayReportStatus: 'Submitted', prayersToday: '5/5', lastActivity: '25 mins ago', spiritualScore: 95, timetableCompletion: '8/8' },
    { id: 'u-3', name: 'Tariq Hamdan', email: 'tariq.h@daeimini.org', circle: 'Circle Uhud (Leadership)', streak: 7, todayReportStatus: 'Submitted', prayersToday: '4/5', lastActivity: '1 hour ago', spiritualScore: 78, timetableCompletion: '6/8' },
    { id: 'u-4', name: 'Hamza Al-Ghamdi', email: 'hamza.g@daeimini.org', circle: 'Youth Halaqah (Beginners)', streak: 3, todayReportStatus: 'Missing', prayersToday: '2/5', lastActivity: '4 hours ago', spiritualScore: 60, timetableCompletion: '2/7' },
    { id: 'u-5', name: 'Yusuf Qureshi', email: 'yusuf.q@daeimini.org', circle: 'Circle Uhud (Leadership)', streak: 11, todayReportStatus: 'Submitted', prayersToday: '5/5', lastActivity: '45 mins ago', spiritualScore: 92, timetableCompletion: '7/8' },
];

export const INITIAL_CIRCLES = [
    { id: 'c-1', name: 'Circle Badr (Youth Dawah)', membersCount: 8, leadMentor: 'Ustadh Farhan Al-Mansoor', meetingDay: 'Tuesdays 8 PM', description: 'Youth mentorship circle focused on daily Sunnah adherence, prayer discipline, and public dawah.' },
    { id: 'c-2', name: 'Circle Uhud (Leadership)', membersCount: 6, leadMentor: 'Sheikh Abdullah Nazir', meetingDay: 'Thursdays 7 PM', description: 'Advanced leadership development, Seerah application, and community project execution.' },
    { id: 'c-3', name: 'Youth Halaqah (Beginners)', membersCount: 12, leadMentor: 'Ustadh Farhan Al-Mansoor', meetingDay: 'Saturdays 10 AM', description: 'Foundational study circle covering Salah, Tajweed basics, and daily Islamic habits.' },
];

// Helper to get or set from LocalStorage safely
export function getStored(key, defaultVal) {
    try {
        const item = localStorage.getItem(key);
        if (item) return JSON.parse(item);
    } catch (e) {
        console.error(`Failed to load ${key} from storage:`, e);
    }
    return defaultVal;
}

export function setStored(key, val) {
    try {
        localStorage.setItem(key, JSON.stringify(val));
    } catch (e) {
        console.error(`Failed to save ${key} to storage:`, e);
    }
}
