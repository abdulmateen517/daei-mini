{{-- Top Header Navigation Component --}}
<header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/90 px-4 sm:px-6 lg:px-8 py-3 shadow-xs">
    <div class="flex items-center justify-between gap-4">
        {{-- Left: Mobile Toggle & Breadcrumbs --}}
        <div class="flex items-center gap-3">
            <button
                type="button"
                @click="isSidebarOpen = true"
                class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                title="Toggle Menu"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-500">Daei Mini</span>
                    <span class="text-slate-300">/</span>
                    <span
                        class="text-xs font-extrabold uppercase tracking-wider"
                        :class="currentRole === 'admin' ? 'text-amber-600' : 'text-slate-900'"
                        x-text="currentRole === 'admin' ? 'Admin & Mentor Console' : 'User Productivity Panel'"
                    ></span>
                </div>
                <div class="text-xs text-slate-500 hidden sm:block">
                    <span x-text="user.gregorianDate"></span> • <span class="text-amber-700 font-medium" x-text="user.hijriDate"></span>
                </div>
            </div>
        </div>

        {{-- Right: Role Switcher, Indicators, Add Button --}}
        <div class="flex items-center gap-2.5 sm:gap-3">
            {{-- Quick Role Switcher Pill --}}
            <div class="inline-flex rounded-xl p-1 bg-slate-100 border border-slate-200 text-xs font-bold">
                <a
                    href="{{ url('/dashboard') }}"
                    @click="switchRole('user')"
                    class="px-3 py-1 rounded-lg transition-all flex items-center gap-1.5"
                    :class="currentRole === 'user' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span>User</span>
                </a>
                <a
                    href="{{ url('/admin') }}"
                    @click="switchRole('admin')"
                    class="px-3 py-1 rounded-lg transition-all flex items-center gap-1.5"
                    :class="currentRole === 'admin' ? 'bg-amber-400 text-slate-950 shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    <span>Admin</span>
                </a>
            </div>

            {{-- Streak Pill (User) --}}
            <template x-if="currentRole === 'user'">
                <div class="hidden md:flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-900 border border-amber-200 text-xs font-bold">
                    <span>🔥</span>
                    <span x-text="`${user.streakDays}d Streak`"></span>
                </div>
            </template>

            {{-- Action Button --}}
            <template x-if="currentRole === 'user'">
                <button
                    type="button"
                    @click="openAddModal()"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span class="hidden sm:inline">Add Activity</span>
                </button>
            </template>

            <template x-if="currentRole === 'admin'">
                <button
                    type="button"
                    @click="isAddGroupModalOpen = true"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 transition-colors shadow-xs active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                    <span class="hidden sm:inline">New Circle</span>
                </button>
            </template>
        </div>
    </div>
</header>
