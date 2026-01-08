<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Header Section with Gradient --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 p-8 shadow-2xl">
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:20px_20px]"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-2">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 backdrop-blur-sm">
                    <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Monthly Attendance Report</h1>
                    <p class="text-blue-100 mt-1">Track and analyze student attendance performance</p>
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-indigo-500/20 blur-3xl"></div>
    </div>

    {{-- Filters Card --}}
    <div class="mb-8 rounded-3xl border border-slate-200/60 bg-white p-8 shadow-lg shadow-slate-200/50">
        <div class="mb-6 flex items-center gap-2">
            <div class="h-8 w-1 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600"></div>
            <h2 class="text-lg font-bold text-slate-800">Filter Reports</h2>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <div class="group">
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-600">
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Year
                    </span>
                </label>
                <input type="number" wire:model.live="year"
                       class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-800 transition-all duration-200 placeholder:text-slate-400 hover:border-blue-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none"
                       placeholder="2024">
            </div>

            <div class="group">
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-600">
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Month
                    </span>
                </label>
                <input type="number" min="1" max="12" wire:model.live="month"
                       class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-800 transition-all duration-200 placeholder:text-slate-400 hover:border-emerald-300 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 outline-none"
                       placeholder="1-12">
            </div>

            <div class="group">
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-600">
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Grade
                    </span>
                </label>
                <select wire:model.live="grade_id"
                        class="w-full rounded-xl border-2 border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-800 transition-all duration-200 hover:border-purple-300 focus:border-purple-500 focus:bg-white focus:ring-4 focus:ring-purple-500/10 outline-none">
                    <option value="">-- Select grade --</option>
                    @foreach($grades as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between gap-4">
            <div class="flex items-start gap-2 rounded-2xl bg-amber-50 border border-amber-200/60 p-4 flex-1">
                <svg class="h-5 w-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-amber-800">
                    <span class="font-bold">Important:</span> Students marked as <span class="font-semibold">Sick</span> are counted as non-present when calculating attendance percentage.
                </p>
            </div>

            <button
                wire:click="resetFilters"
                type="button"
                class="inline-flex items-center gap-2 rounded-xl border-2 border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 transition-all duration-200 hover:border-slate-400 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-300/40 shadow-sm hover:shadow-md"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v6h6M20 20v-6h-6M5 19a9 9 0 0114-7M19 5a9 9 0 01-14 7"/>
                </svg>
                Reset Filters
            </button>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-xl shadow-slate-200/50">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Student</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-purple-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Grade</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Present</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-rose-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Absent</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-amber-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Sick</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-slate-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Total</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full bg-indigo-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Attendance %</span>
                        </div>
                    </th>
                </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                @forelse($rows as $row)
                    <tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/30">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-4">
                                    @if($row->photo_path)
                                        <img src="{{ asset('storage/' . $row->photo_path) }}"  alt=""  class="h-14 w-14 rounded-xl object-cover" />
                                    @else
                                        @php
                                            $first = $row->first_name ?? '';
                                            $last = $row->last_name ?? '';
                                            $initials = strtoupper(mb_substr($first, 0, 1) . mb_substr($last, 0, 1));
                                        @endphp

                                        <div class="grid size-14 place-items-center rounded-2xl bg-blue-600 text-white font-bold text-lg shadow-sm">
                                            {{ $initials ?: 'S' }}
                                        </div>
                                    @endif
                                </div>
                                <span class="text-sm font-bold text-slate-900">
                                    {{ $row->first_name }} {{ $row->last_name }}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-xl bg-purple-100 px-3 py-1.5 text-xs font-bold text-purple-700 ring-1 ring-purple-200">
                                {{ $row->grade?->name ?? '-' }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100">
                                    <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-emerald-700">{{ (int)$row->present_count }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-rose-100">
                                    <svg class="h-4 w-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-rose-700">{{ (int)$row->absent_count }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100">
                                    <svg class="h-4 w-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-amber-700">{{ (int)$row->sick_count }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-xl bg-slate-100 px-3 py-1.5 text-sm font-bold text-slate-700 ring-1 ring-slate-200">
                                {{ (int)$row->total_records }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @if($row->attendance_percent === null)
                                <span class="inline-flex items-center rounded-xl bg-slate-100 px-3 py-2 text-sm font-bold text-slate-500">—</span>
                            @else
                                @php
                                    $p = $row->attendance_percent;
                                    $badge = $p >= 90 ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg shadow-emerald-500/30'
                                            : ($p >= 75 ? 'bg-gradient-to-r from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-500/30'
                                            : 'bg-gradient-to-r from-rose-500 to-red-600 text-white shadow-lg shadow-rose-500/30');
                                @endphp
                                <span class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-bold {{ $badge }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    {{ $p }}%
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16">
                            <div class="flex flex-col items-center justify-center gap-4">
                                <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-slate-100 to-slate-200">
                                    <svg class="h-10 w-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p class="text-base font-bold text-slate-700">No Data Available</p>
                                    <p class="mt-1 text-sm text-slate-500">Select Year, Month, and Grade to generate the report</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
