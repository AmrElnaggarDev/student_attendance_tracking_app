<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 overflow-visible">
    <div class="relative"> {{-- Container للبحث والقائمة --}}

        <form wire:submit.prevent="search">
            <div class="flex flex-col sm:flex-row gap-4 sm:items-end">

                {{-- حقل البحث --}}
                <div class="flex-1 relative">
                    <label for="student_search" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">
                        Quick Student Search
                    </label>

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <input
                            id="student_search"
                            type="text"
                            wire:model.live.debounce.300ms="q" {{-- تم استخدام debounce عشان ميضغطش على السيرفر --}}
                            autocomplete="off"
                            placeholder="Search by student name..."
                            class="w-full bg-slate-50 rounded-xl border-none pl-10 pr-4 py-3 text-sm text-slate-700 ring-1 ring-slate-200 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200 outline-none shadow-sm placeholder:text-slate-400"
                            wire:keydown.escape="hideDropdown"
                        />
                    </div>
                </div>

                {{-- زرار البحث (للبحث الكامل) --}}
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-bold bg-blue-600 text-white hover:bg-blue-700 active:scale-95 transition-all duration-200 shadow-lg shadow-blue-200"
                >
                    <span>Search</span>
                </button>
            </div>
        </form>

        {{-- قائمة نتايج البحث (Dropdown) --}}
        @if($showDropdown && !empty($results))
            <div class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden">
                <div class="max-h-60 overflow-y-auto">
                    @foreach($results as $student)
                        <button
                            wire:click="selectStudent({{ $student['id'] }})"
                            class="w-full flex items-center justify-between px-4 py-3 hover:bg-blue-50 transition-colors border-b border-slate-50 last:border-0 group text-left"
                        >
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-slate-700 group-hover:text-blue-700">
                                    {{ $student['first_name'] }} {{ $student['last_name'] }}
                                </span>
                                <span class="text-xs text-slate-400">
                                    Grade: {{ $student['grade_name'] ?? 'N/A' }}
                                </span>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- خلفية شفافة عشان لما تدوس برا القائمة تقفل --}}
            <div class="fixed inset-0 z-40" wire:click="hideDropdown"></div>
        @endif

    </div>
</div>
