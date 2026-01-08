<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Top Bar --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('student.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>

            <a href="{{route('student.edit', $student->id)}}"
               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L7.5 19.125 3 21l1.875-4.5L16.862 4.487z" />
                </svg>
                Edit
            </a>
        </div>

        {{-- Status Badge --}}
        <div class="flex items-center gap-2">
            @php $active = (bool)($student->is_active ?? true); @endphp

            <span
                class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-semibold
                {{ $active ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-rose-50 text-rose-700 ring-1 ring-rose-200' }}">
                <span class="size-2 rounded-full {{ $active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                {{ $active ? 'Active' : 'Inactive' }}
            </span>

            <span class="text-sm text-gray-500">
                ID: <span class="font-semibold text-gray-700">#{{ $student->id }}</span>
            </span>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">

            <div class="flex items-center gap-4">
                @if($student->photo_path)
                    <img src="{{ asset('storage/' . $student->photo_path) }}"  alt=""  class="h-14 w-14 rounded-xl object-cover" />
                @else
                    @php
                        $first = $student->first_name ?? '';
                        $last = $student->last_name ?? '';
                        $initials = strtoupper(mb_substr($first, 0, 1) . mb_substr($last, 0, 1));
                    @endphp

                    <div class="grid size-14 place-items-center rounded-2xl bg-blue-600 text-white font-bold text-lg shadow-sm">
                        {{ $initials ?: 'S' }}
                    </div>
                @endif
            </div>

            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $student->first_name }} {{ $student->last_name }}
                </h1>

                <div class="mt-1 flex flex-wrap items-center gap-2 text-sm text-gray-600">
                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-1">
                        Grade:
                        <span class="font-semibold text-gray-800">
                            {{ $student->grade?->name ?? '-' }}
                        </span>
                    </span>

                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-1">
                        Age:
                        <span class="font-semibold text-gray-800">
                            {{ $student->age ?? '-' }}
                        </span>
                    </span>

                    {{-- Gender badge --}}
                    @php $gender = strtolower($student->gender ?? ''); @endphp
                    @if($gender === 'male')
                        <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-1 text-blue-700 ring-1 ring-blue-200">
                            <span class="text-base">♂️</span> Male
                        </span>
                    @elseif($gender === 'female')
                        <span class="inline-flex items-center gap-1 rounded-full bg-pink-50 px-2 py-1 text-pink-700 ring-1 ring-pink-200">
                            <span class="text-base">♀️</span> Female
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-1 text-gray-700 ring-1 ring-gray-200">
                            Gender: -
                        </span>
                    @endif
                </div>
            </div>

            {{-- Quick chips --}}
            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center gap-2 rounded-xl bg-amber-50 px-3 py-2 text-sm font-semibold text-amber-700 ring-1 ring-amber-200">
                    Attendance tracked
                </span>
                <span class="inline-flex items-center gap-2 rounded-xl bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 ring-1 ring-emerald-200">
                    Profile ready
                </span>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $pageAtt = $attendances->getCollection();
        $totalDays   = $attendances->total();
        $presentDays = $pageAtt->where('status', 'present')->count();
        $absentDays  = $pageAtt->where('status', 'absent')->count();
        $lateDays    = $pageAtt->where('status', 'late')->count();
    @endphp

    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Total Records</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalDays }}</p>
            <p class="mt-1 text-sm text-gray-500">Attendance entries</p>
        </div>

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-emerald-700">Present (this page)</p>
            <p class="mt-2 text-3xl font-bold text-emerald-900">{{ $presentDays }}</p>
            <p class="mt-1 text-sm text-emerald-700">Records</p>
        </div>

        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-rose-700">Absent (this page)</p>
            <p class="mt-2 text-3xl font-bold text-rose-900">{{ $absentDays }}</p>
            <p class="mt-1 text-sm text-rose-700">Records</p>
        </div>

        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-amber-700">Late (this page)</p>
            <p class="mt-2 text-3xl font-bold text-amber-900">{{ $lateDays }}</p>
            <p class="mt-1 text-sm text-amber-700">Records</p>
        </div>
    </div>

    {{-- Attendance History --}}
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Attendance History</h2>
                <p class="text-sm text-gray-500">Latest records for this student</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-4 px-6 py-4 bg-slate-50 border-b border-slate-200 shadow-[inset_0_-1px_0_rgba(0,0,0,0.04)]">
            <div class="flex items-center gap-2">
                <label class="text-xs font-semibold uppercase tracking-wide text-slate-600 whitespace-nowrap">From:</label>
                <input type="date" wire:model.live="fromDate" class="w-[160px] rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 outline-none transition">
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs font-semibold uppercase tracking-wide text-slate-600 whitespace-nowrap">To:</label>
                <input type="date" wire:model.live="toDate" class="w-[160px] rounded-lg border border-slate-300 bg-white px-2 py-1.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 outline-none transition">
            </div>

            @if($fromDate || $toDate)
                <button wire:click="clearFilter" class="inline-flex items-center gap-1 rounded-lg bg-white px-3 py-2 text-sm font-medium text-slate-600 border border-slate-300 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-300 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Clear Filter
                </button>
            @endif
        </div>

        @if($fromDate || $toDate)
            <div class="mx-6 mb-3 mt-3 flex items-start gap-3 rounded-xl bg-blue-50 px-4 py-3 text-sm text-blue-700 ring-1 ring-blue-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 size-4 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 018 17V13.414L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                <p class="leading-relaxed">
                    <span class="font-semibold text-blue-800">Filters applied:</span>
                    @if($fromDate && $toDate)
                        from <span class="font-semibold">{{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }}</span> to <span class="font-semibold">{{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</span>
                    @elseif($fromDate)
                        from <span class="font-semibold">{{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }}</span>
                    @else
                        until <span class="font-semibold">{{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</span>
                    @endif
                </p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Notes</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($attendances as $attendance)
                    @php $st = strtolower($attendance->status ?? ''); @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ optional($attendance->date)->format('M d, Y') ?? ($attendance->date ?? '-') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($st === 'present')
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">Present</span>
                            @elseif($st === 'absent')
                                <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 ring-1 ring-rose-200">Absent</span>
                            @elseif($st === 'late')
                                <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-amber-200">Late</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">{{ $attendance->status ?? 'Unknown' }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $attendance->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-500">
                            {{ ($fromDate || $toDate) ? 'No records found for the selected date range' : 'No attendance record yet' }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $attendances->links() }}
    </div>

</div>
