<x-daei-layout title="Group Management — Daei Mini">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-950 text-white p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-amber-400/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-2.5 py-0.5 rounded-full border border-amber-400/20">
                        Halaqat • Study Circles
                    </span>
                    <span class="text-xs text-slate-400">Accountability Cohorts</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Group & Circle Management
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Organize mentees into structured accountability halaqahs. Set weekly meeting slots, curricula, and track cohort milestones.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button
                    type="button"
                    @click="isAddGroupModalOpen = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span>+ Create New Circle</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Circles Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="circle in circles" :key="circle.id">
            <div class="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs flex flex-col justify-between hover:border-slate-300 transition-all">
                <div>
                    {{-- Header & Members Count --}}
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-200">
                            Active Halaqah
                        </span>
                        <span class="text-xs font-extrabold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-xl" x-text="`${circle.membersCount} Mentees`"></span>
                    </div>

                    <h3 class="text-lg font-extrabold text-slate-900 tracking-tight" x-text="circle.name"></h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed" x-text="circle.description"></p>

                    {{-- Meeting Time & Lead Mentor --}}
                    <div class="mt-5 space-y-2.5 pt-4 border-t border-slate-100 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">Weekly Meeting:</span>
                            <span class="font-bold text-slate-900" x-text="circle.meetingDay"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">Lead Mentor:</span>
                            <span class="font-bold text-slate-700" x-text="circle.leadMentor"></span>
                        </div>
                    </div>
                </div>

                {{-- Action Footer --}}
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] font-bold text-emerald-700">● Live Session Active</span>
                    <a
                        href="{{ url('/admin/users') }}"
                        class="text-xs font-bold text-slate-900 hover:text-amber-600 flex items-center gap-1"
                    >
                        <span>View Members</span>
                        <span>→</span>
                    </a>
                </div>
            </div>
        </template>
    </div>
</x-daei-layout>
