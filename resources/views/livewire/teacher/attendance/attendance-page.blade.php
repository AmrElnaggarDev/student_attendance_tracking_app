{{-- resources/views/livewire/teacher/attendance/attendance-page.blade.php --}}

<div class="space-y-6">

    {{-- ===================== Page Header ===================== --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Attendance
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Attendance Management (Status + Note Type)
            </p>
        </div>

        <div class="flex items-center gap-3">
            <p class="hidden text-xs text-gray-500 dark:text-gray-400 sm:block">
                Choose Year / Month / Grade then manage attendance
            </p>

            <button
                wire:click="exportToExcel"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 hover:text-gray-900 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-200 dark:hover:bg-neutral-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export
            </button>
        </div>
    </div>

    {{-- ===================== Filters ===================== --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            {{-- Year --}}
            <div>
                <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-400">
                    Year
                </label>
                <select
                    wire:model.live="year"
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-600 dark:bg-neutral-900 dark:text-gray-200"
                >
                    <option value="">Select year</option>
                    @for ($y = now()->year - 2; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>
            </div>

            {{-- Month --}}
            <div>
                <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-400">
                    Month
                </label>
                <select
                    wire:model.live="month"
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-600 dark:bg-neutral-900 dark:text-gray-200"
                >
                    <option value="">Select month</option>
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Grade --}}
            <div>
                <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-400">
                    Grade
                </label>
                <select
                    wire:model.live="grade"
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-600 dark:bg-neutral-900 dark:text-gray-200"
                >
                    <option value="">Select grade</option>
                    @foreach ($grades as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Status Hint --}}
            <div class="flex items-end">
                @if (!$year || !$month || !$grade)
                    <div class="flex items-center gap-2 rounded-lg bg-amber-50 px-3 py-2 dark:bg-amber-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium text-amber-700 dark:text-amber-300">
                            Select all filters
                        </p>
                    </div>
                @else
                    <div class="flex items-center gap-2 rounded-lg bg-emerald-50 px-3 py-2 dark:bg-emerald-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium text-emerald-700 dark:text-emerald-300">
                            Ready
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ===================== Loading State ===================== --}}
    <div wire:loading.delay class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center dark:border-neutral-600 dark:bg-neutral-900/50">
        <div class="flex items-center justify-center gap-3">
            <svg class="h-5 w-5 animate-spin text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Loading attendance data...</span>
        </div>
    </div>

    {{-- ===================== Empty State ===================== --}}
    @if (($year && $month && $grade) && count($students) === 0)
        <div class="rounded-xl border border-gray-200 bg-white p-12 text-center shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                No students found
            </h3>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                There are no students enrolled in this grade for the selected period.
            </p>
            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                Try adjusting the selected grade or time period.
            </p>
        </div>
    @endif

    {{-- ===================== Attendance Table ===================== --}}
    @if ($year && $month && $grade && count($students) > 0)
        <div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-800">

            {{-- Saving indicator --}}
            <div
                wire:loading
                wire:target="updateAttendance,updateNoteType,markAll"
                class="absolute right-4 top-4 z-50 flex items-center gap-2 rounded-lg bg-gray-900 px-3 py-2 text-xs font-medium text-white shadow-lg dark:bg-neutral-700"
            >
                <svg class="h-3 w-3 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-sm">
                    <thead class="sticky top-0 z-20 bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        {{-- Student name header --}}
                        <th class="sticky left-0 z-30 w-56 border-b-2 border-r border-gray-200 bg-gray-50 px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:border-neutral-600 dark:bg-neutral-700 dark:text-gray-200">
                            Student
                        </th>

                        {{-- Days header --}}
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            <th class="min-w-[150px] border-b-2 border-gray-200 px-3 py-3 text-center dark:border-neutral-600">
                                <div class="flex flex-col gap-2">
                                    <span class="text-xs font-bold uppercase tracking-wide text-gray-700 dark:text-gray-200">
                                        Day {{ $day }}
                                    </span>
                                    <select
                                        wire:change="markAll({{ $day }}, $event.target.value)"
                                        class="w-full rounded-md border-gray-300 bg-white text-xs font-medium shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-gray-200"
                                    >
                                        <option value="">Mark All</option>
                                        <option value="present">✓ Present</option>
                                        <option value="absent">✗ Absent</option>
                                        <option value="sick">🤕 Sick</option>
                                    </select>
                                </div>
                            </th>
                        @endfor
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @foreach ($students as $student)
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-neutral-700/50">
                            {{-- Student name --}}
                            <td class="sticky left-0 z-10 border-r border-gray-200 bg-white px-4 py-3 font-semibold text-gray-800 dark:border-neutral-600 dark:bg-neutral-800 dark:text-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
                                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                    </div>
                                    <span class="text-sm">{{ $student->first_name }} {{ $student->last_name }}</span>
                                </div>
                            </td>

                            {{-- Days --}}
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $cell = $attendance[$student->id][$day] ?? [
                                        'status' => 'present',
                                        'note_type' => 'general',
                                    ];

                                    $status   = $cell['status'] ?? 'present';
                                    $noteType = $cell['note_type'] ?? 'general';

                                    $statusColors = [
                                        'present' => 'border-emerald-200 bg-emerald-50 text-emerald-700 focus:border-emerald-500 focus:ring-emerald-500 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-300',
                                        'absent'  => 'border-rose-200 bg-rose-50 text-rose-700 focus:border-rose-500 focus:ring-rose-500 dark:border-rose-800 dark:bg-rose-900/20 dark:text-rose-300',
                                        'sick'    => 'border-amber-200 bg-amber-50 text-amber-700 focus:border-amber-500 focus:ring-amber-500 dark:border-amber-800 dark:bg-amber-900/20 dark:text-amber-300',
                                    ];

                                    $noteColors = [
                                        'general'    => 'border-slate-200 bg-slate-50 text-slate-700 focus:border-slate-500 focus:ring-slate-500 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-300',
                                        'medical'    => 'border-sky-200 bg-sky-50 text-sky-700 focus:border-sky-500 focus:ring-sky-500 dark:border-sky-800 dark:bg-sky-900/20 dark:text-sky-300',
                                        'behavioral' => 'border-violet-200 bg-violet-50 text-violet-700 focus:border-violet-500 focus:ring-violet-500 dark:border-violet-800 dark:bg-violet-900/20 dark:text-violet-300',
                                    ];

                                    $statusClass = $statusColors[$status] ?? $statusColors['present'];
                                    $noteClass   = $noteColors[$noteType] ?? $noteColors['general'];
                                @endphp

                                <td class="border-gray-200 px-3 py-3 align-top dark:border-neutral-700">
                                    <div class="flex flex-col gap-2">
                                        {{-- Status --}}
                                        <select
                                            wire:change="updateAttendance({{ $student->id }}, {{ $day }}, $event.target.value)"
                                            class="w-full cursor-pointer rounded-md border text-xs font-medium shadow-sm transition {{ $statusClass }}"
                                        >
                                            <option value="present" @selected($cell['status'] === 'present')>✓ Present</option>
                                            <option value="absent" @selected($cell['status'] === 'absent')>✗ Absent</option>
                                            <option value="sick" @selected($cell['status'] === 'sick')>🤕 Sick</option>
                                        </select>

                                        {{-- Note Type --}}
                                        @php
                                            $isPresent = ($status === 'present');
                                        @endphp

                                        <select
                                            wire:change="updateNoteType({{ $student->id }}, {{ $day }}, $event.target.value)"
                                            @disabled($isPresent)
                                            class="w-full cursor-pointer rounded-md border text-xs font-medium shadow-sm transition
                                            {{ $noteClass }}
                                            {{ $isPresent ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        >
                                            <option value="general" @selected($cell['note_type'] === 'general')>📝 General</option>
                                            <option value="medical" @selected($cell['note_type'] === 'medical')>🏥 Medical</option>
                                            <option value="behavioral" @selected($cell['note_type'] === 'behavioral')>⚠️ Behavioral</option>
                                        </select>

                                        @if($isPresent)
                                            <p class="text-[10px] text-gray-400">Note type available only when not Present</p>
                                        @endif
                                    </div>
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    @endif

</div>
