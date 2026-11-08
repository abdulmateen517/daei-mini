<x-daei-layout title="Personal Journal — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-400 bg-emerald-400/10 px-2.5 py-0.5 rounded-full border border-emerald-400/20">
                        Muhasabah • Self-Reflection
                    </span>
                    <span class="text-xs text-slate-400">Private & Confidential</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Personal Journal & Reflections
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    A safe, private sanctuary to record your innermost reflections, spiritual struggles, dua requests, and daily gratitude.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button
                    type="button"
                    @click="isAddJournalModalOpen = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span>+ New Reflection</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Strict Privacy Guarantee Banner --}}
    <div class="rounded-3xl p-5 bg-emerald-50 border border-emerald-200 text-emerald-950 flex items-center justify-between gap-3 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="p-2.5 rounded-2xl bg-emerald-100 text-emerald-800 font-bold shrink-0">
                🔒
            </div>
            <div>
                <h4 class="text-sm font-extrabold text-emerald-950">End-to-End Privacy Guarantee</h4>
                <p class="text-xs text-emerald-800 mt-0.5">
                    Your journal entries are strictly private to your personal user account. Mentors and group administrators CANNOT view, search, or inspect your private reflections.
                </p>
            </div>
        </div>
        <span class="hidden sm:inline text-xs font-black px-3 py-1 bg-white text-emerald-900 rounded-xl border border-emerald-300">
            Private 🔒
        </span>
    </div>

    {{-- Journal Entries Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="entry in journalEntries" :key="entry.id">
            <div class="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-all">
                <div>
                    {{-- Date & Mood Pill --}}
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="text-xs font-bold text-slate-500" x-text="entry.date"></span>
                        <span
                            class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full"
                            :class="{
                                'bg-emerald-100 text-emerald-900': entry.mood === 'Grateful',
                                'bg-purple-100 text-purple-900': entry.mood === 'Reflective',
                                'bg-amber-100 text-amber-900': entry.mood === 'Determined',
                                'bg-rose-100 text-rose-900': entry.mood === 'Contrite'
                            }"
                            x-text="entry.mood"
                        ></span>
                    </div>

                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight" x-text="entry.title"></h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed line-clamp-4" x-text="entry.content"></p>

                    {{-- Tags --}}
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        <template x-for="tag in entry.tags" :key="tag">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600" x-text="`#${tag}`"></span>
                        </template>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400">Strictly Confidential</span>
                    <button
                        type="button"
                        @click="selectedJournalItem = entry"
                        class="text-xs font-bold text-slate-900 hover:text-amber-600 flex items-center gap-1"
                    >
                        <span>Read Full</span>
                        <span>→</span>
                    </button>
                </div>
            </div>
        </template>
    </div>

    {{-- Journal Detail Modal Drawer --}}
    <div x-show="selectedJournalItem" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="selectedJournalItem = null"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-lg rounded-3xl bg-white p-6 sm:p-8 shadow-2xl border border-slate-200">
                <template x-if="selectedJournalItem">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-500" x-text="selectedJournalItem.date"></span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    🔒 Private to You
                                </span>
                            </div>
                            <button type="button" @click="selectedJournalItem = null" class="text-slate-400 hover:text-slate-900 p-1">
                                ✕
                            </button>
                        </div>

                        <h3 class="text-lg font-black text-slate-900 tracking-tight" x-text="selectedJournalItem.title"></h3>
                        <div class="mt-2 text-xs font-semibold text-amber-700">
                            Mood: <span x-text="selectedJournalItem.mood"></span>
                        </div>

                        <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs sm:text-sm text-slate-800 leading-relaxed whitespace-pre-line" x-text="selectedJournalItem.content"></div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" @click="selectedJournalItem = null" class="px-5 py-2 text-xs font-bold rounded-xl bg-slate-900 text-white hover:bg-slate-800">Close Reflection</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-daei-layout>
