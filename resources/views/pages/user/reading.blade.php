<x-daei-layout title="Reading Tracking — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Iqra • Continuous Learning
                    </span>
                    <span class="text-xs text-slate-400">Islamic & Contemporary Books</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Digital Library & Reading Tracker
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Track the books and treatises you are reading, record pages completed daily, and capture core insights from scholars.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button
                    type="button"
                    @click="isAddReadingModalOpen = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span>+ Track New Book</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Books Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="book in readingList" :key="book.id">
            <div class="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div>
                    {{-- Category & Status --}}
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700" x-text="book.category"></span>
                        <span
                            class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded-md"
                            :class="book.status === 'Completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-900'"
                            x-text="book.status"
                        ></span>
                    </div>

                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight" x-text="book.title"></h3>
                    <p class="text-xs font-medium text-slate-500 mt-0.5" x-text="`by ${book.author}`"></p>

                    <template x-if="book.keyTakeaway">
                        <div class="mt-3 p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs text-slate-600 italic">
                            “<span x-text="book.keyTakeaway"></span>”
                        </div>
                    </template>

                    {{-- Progress Bar --}}
                    <div class="mt-5 space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-700" x-text="`${book.pagesRead} of ${book.totalPages} pages`"></span>
                            <span class="text-amber-600 font-extrabold" x-text="`${Math.round((book.pagesRead / book.totalPages) * 100)}%`"></span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden p-0.5 border border-slate-200">
                            <div
                                class="h-full bg-slate-900 rounded-full transition-all duration-300"
                                :style="`width: ${(book.pagesRead / book.totalPages) * 100}%`"
                            ></div>
                        </div>
                    </div>
                </div>

                {{-- Quick Progress Update Buttons --}}
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                    <span class="text-xs font-medium text-slate-500">Quick Log:</span>
                    <div class="flex items-center gap-1.5">
                        <button
                            type="button"
                            @click="updateReadingPages(book.id, 5)"
                            class="px-2.5 py-1 rounded-lg text-xs font-bold text-slate-800 bg-slate-100 hover:bg-slate-200 transition-colors"
                        >
                            +5 pgs
                        </button>
                        <button
                            type="button"
                            @click="updateReadingPages(book.id, 10)"
                            class="px-3 py-1 rounded-lg text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs"
                        >
                            +10 pgs
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-daei-layout>
