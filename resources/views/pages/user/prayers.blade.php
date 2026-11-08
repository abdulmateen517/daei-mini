<x-daei-layout title="Prayer Tracker — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Salah • الصلاة عماد الدين
                    </span>
                    <span class="text-xs text-slate-400" x-text="`${user.gregorianDate} • ${user.hijriDate}`"></span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Five Daily Prayers Tracker
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Maintain punctuality in your obligatory prayers, track congregation (Jama'ah) attendance, and record established Sunnah prayers.
                </p>
            </div>

            {{-- Progress Ring / Summary --}}
            <div class="flex items-center gap-3">
                <div class="px-5 py-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Completion</div>
                    <div class="text-2xl font-black text-amber-400 mt-0.5" x-text="`${completedPrayersCount}/5`"></div>
                </div>
                <div class="px-5 py-3 rounded-2xl bg-white/5 border border-white/10 text-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">In Jamaah</div>
                    <div class="text-2xl font-black text-white mt-0.5" x-text="jamaahPrayersCount"></div>
                </div>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="mt-6 pt-4 border-t border-slate-800">
            <div class="flex items-center justify-between text-xs font-bold mb-2">
                <span class="text-slate-300">Daily Salah Compliance</span>
                <span class="text-amber-400" x-text="`${Math.round((completedPrayersCount / 5) * 100)}% Complete`"></span>
            </div>
            <div class="h-3 w-full bg-slate-800 rounded-full overflow-hidden p-0.5 border border-slate-700">
                <div
                    class="h-full bg-gradient-to-r from-amber-400 to-yellow-300 rounded-full transition-all duration-500 shadow-xs"
                    :style="`width: ${(completedPrayersCount / 5) * 100}%`"
                ></div>
            </div>
        </div>
    </div>

    {{-- Five Prayers Interactive Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <template x-for="prayer in prayers" :key="prayer.id">
            <div
                class="rounded-3xl p-5 border transition-all flex flex-col justify-between"
                :class="prayer.completed ? 'bg-white border-slate-300 shadow-sm' : 'bg-white/80 border-slate-200/90'"
            >
                <div>
                    {{-- Card Header --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full" :class="prayer.completed ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'" x-text="prayer.name"></span>
                            <h3 class="text-base font-extrabold text-slate-900 mt-1" x-text="prayer.name"></h3>
                        </div>
                        <button
                            type="button"
                            @click="togglePrayer(prayer.id)"
                            class="w-8 h-8 rounded-xl flex items-center justify-center transition-all cursor-pointer active:scale-95"
                            :class="prayer.completed ? 'bg-amber-400 text-slate-950 font-black shadow-xs' : 'border-2 border-slate-300 hover:border-slate-400 bg-slate-50 text-transparent'"
                            title="Toggle Prayer Completed"
                        >
                            ✓
                        </button>
                    </div>

                    {{-- Time Slot --}}
                    <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-500">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="font-bold text-slate-700" x-text="prayer.time"></span>
                        <template x-if="prayer.timestamp">
                            <span class="text-[10px] text-slate-400" x-text="`(@ ${prayer.timestamp})`"></span>
                        </template>
                    </div>

                    {{-- Description / Rakaat --}}
                    <div class="mt-2 text-xs text-slate-500">
                        <span class="font-semibold text-slate-700" x-text="`${prayer.rakaat} Fard Rakaat`"></span>
                        <template x-if="prayer.sunnahRakaat">
                            <span class="text-slate-400" x-text="`+ ${prayer.sunnahRakaat} Sunnah`"></span>
                        </template>
                    </div>
                </div>

                {{-- Action Toggles --}}
                <div class="mt-5 pt-4 border-t border-slate-100 space-y-2">
                    {{-- Jamaah Toggle --}}
                    <button
                        type="button"
                        @click="togglePrayerJamaah(prayer.id)"
                        class="w-full flex items-center justify-between px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors"
                        :class="prayer.inJamaah ? 'bg-amber-100 text-amber-950 border border-amber-300' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'"
                    >
                        <span>In Jama'ah (Masjid)</span>
                        <span class="text-xs" x-text="prayer.inJamaah ? '✓ Yes' : 'No'"></span>
                    </button>

                    {{-- Sunnah Toggle --}}
                    <button
                        type="button"
                        @click="togglePrayerSunnah(prayer.id)"
                        class="w-full flex items-center justify-between px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors"
                        :class="prayer.sunnahCompleted ? 'bg-emerald-100 text-emerald-950 border border-emerald-300' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'"
                    >
                        <span>Sunnah Mu'akkadah</span>
                        <span class="text-xs" x-text="prayer.sunnahCompleted ? '✓ Done' : 'Pending'"></span>
                    </button>
                </div>
            </div>
        </template>
    </div>

    {{-- Prayer Disciplines & Reminders Box --}}
    <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/80">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-2xl bg-amber-400/20 text-amber-700 flex items-center justify-center font-bold text-lg shrink-0">
                ✨
            </div>
            <div>
                <h3 class="text-sm font-extrabold text-slate-900">Sunnah of Daily Prayers</h3>
                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                    The Prophet ﷺ said: <span class="italic font-medium text-slate-800">"Whoever prays twelve rak'ahs during the day and night, a house will be built for him in Paradise: four before Dhuhr, two after it, two after Maghrib, two after Isha, and two before Fajr."</span> (Sunan an-Nasa'i).
                </p>
                <div class="mt-3 flex flex-wrap items-center gap-2 text-xs">
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">Adhan Punctuality</span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">Focus & Khushoo'</span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">Post-Prayer Adhkar</span>
                </div>
            </div>
        </div>
    </div>
</x-daei-layout>
