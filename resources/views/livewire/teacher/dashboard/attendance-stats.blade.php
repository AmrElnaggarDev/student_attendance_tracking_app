<div class="bg-white p-6 mt-6 rounded-lg shadow-md border border-gray-100">

    {{-- Header + Styled Grade Filter --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h3 class="text-xl font-bold text-gray-800">
                Weekly Attendance Rate
            </h3>
            <p class="text-sm text-gray-500">Monitoring student presence over the current week</p>
        </div>

        <div class="w-full md:w-72">
            <label for="grade_filter" class="block text-sm font-semibold text-gray-600 mb-2 ml-1">
                Filter by Grade
            </label>
            <div class="relative">
                <select
                    id="grade_filter"
                    wire:model.live="grade_id"
                    class="block w-full px-4 py-3 pr-10 leading-tight bg-gray-50 border border-gray-200 text-gray-700 rounded-xl appearance-none focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 shadow-sm cursor-pointer"
                >
                    <option value="">All Grades (Show All)</option>
                    @foreach($grades as $g)
                        <option value="{{ $g->id }}">Grade: {{ $g->name }}</option>
                    @endforeach
                </select>

                {{-- Custom Arrow Icon --}}
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards Section --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 transition-hover hover:shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Students</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
        </div>

        <div class="rounded-xl border border-green-100 bg-green-50 p-4 transition-hover hover:shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-green-600">Present Today</p>
            <p class="text-2xl font-bold text-green-700">{{ $presentToday }}</p>
        </div>

        <div class="rounded-xl border border-red-100 bg-red-50 p-4 transition-hover hover:shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-red-600">Absent Today</p>
            <p class="text-2xl font-bold text-red-700">{{ $absentToday }}</p>
        </div>

        <div class="rounded-xl border border-yellow-100 bg-yellow-50 p-4 transition-hover hover:shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-yellow-600">Sick Today</p>
            <p class="text-2xl font-bold text-yellow-700">{{ $sickToday }}</p>
        </div>

        <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-4 transition-hover hover:shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Weekly Rate</p>
            <p class="text-2xl font-bold text-indigo-700">{{ $weeklyAttendanceRate }}%</p>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
        <div style="height:320px" wire:ignore>
            <canvas id="weeklyAttendanceChart"></canvas>
        </div>
    </div>

    {{-- Chart.js Library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let weeklyChartInstance = null;

        function renderWeeklyChart(data) {
            if (!data || data.length === 0) return;

            const labels = data.map(item => item.label);
            const values = data.map(item => item.percent);

            const canvas = document.getElementById('weeklyAttendanceChart');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            if (weeklyChartInstance) {
                weeklyChartInstance.destroy();
            }

            weeklyChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Attendance %',
                        data: values,
                        backgroundColor: '#4f46e5',
                        hoverBackgroundColor: '#4338ca',
                        borderRadius: 8,
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { display: true, color: '#f3f4f6' },
                            ticks: {
                                callback: (value) => value + '%',
                                font: { size: 11 }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 12, weight: '600' } }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function (context) {
                                    const i = context.dataIndex;
                                    const row = data[i];
                                    return ` ${row.percent}% | Present: ${row.present}/${row.total}`;
                                }
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('livewire:init', () => {
            renderWeeklyChart(@json($weeklyChart));

            Livewire.on('weekly-chart-updated', (event) => {
                const chartData = Array.isArray(event) ? event[0].weeklyChart : event.weeklyChart;
                renderWeeklyChart(chartData);
            });
        });
    </script>
</div>
