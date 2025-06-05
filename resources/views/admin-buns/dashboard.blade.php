@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ session('admin_nama') }}!</h1>
    <p class="text-gray-600 mb-6">Berikut adalah ringkasan data sistem hari ini:</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-lg font-semibold mb-2">💰 Total Uang Masuk</h2>
            <p class="text-3xl text-green-600 font-bold">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-lg font-semibold mb-2">👤 Total Member</h2>
            <p class="text-3xl text-blue-600 font-bold">{{ $totalMember }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h2 class="text-lg font-semibold mb-2">🙋 Non-Member</h2>
            <p class="text-3xl text-red-500 font-bold">{{ $totalNonMember }}</p>
        </div>
    </div>

    {{-- Kurva Pendapatan Bulanan --}}
    <div class="bg-white rounded-lg shadow p-6 mb-10">
        <h2 class="text-lg font-semibold mb-4">📈 Pendapatan Bulanan Tahun {{ date('Y') }}</h2>
        <canvas id="monthlyRevenueChart" class="w-full" style="max-height: 350px;"></canvas>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Doughnut Chart: Member dan Non Member --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">👥 Komposisi Member & Non-Member</h2>
            <canvas id="doughnutChart" class="mx-auto" style="max-width: 400px; max-height:400px;"></canvas>
        </div>

        {{-- Pie Chart: 3 Kelas Paling Sering Dibeli --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">🎯 3 Kelas Paling Sering Dibeli</h2>
            @if(count($labelsTopClasses) === 0)
                <p class="text-center text-gray-500 mt-4">Tidak ada data kelas yang dibeli.</p>
            @else
                <canvas id="pieChart" class="mx-auto" style="max-width: 400px; max-height:400px;"></canvas>
            @endif
        </div>
    </div>

    {{-- Tabel detail kelas dan pendapatan --}}
    <div class="bg-white rounded-lg shadow p-6 mt-10">
        <h2 class="text-lg font-semibold mb-4">📊 Detail Kelas dan Pendapatan</h2>
        <table class="min-w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama Kelas</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Jumlah Pembelian</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($labelsTopClasses as $index => $kelas)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $kelas }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $dataTopClasses[$index] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">Rp {{ number_format($totalPendapatanClasses[$index], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data backend
    const monthlyRevenue = @json(array_values($monthlyRevenue));
    const totalPurchases = {{ array_sum($dataTopClasses) }};
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    // Data statistik member dan non-member
    const totalMember = {{ $totalMember }};
    const totalNonMember = {{ $totalNonMember }};
    const labelsTopClasses = @json($labelsTopClasses);
    const dataTopClasses = @json($dataTopClasses);

    // Hitung persentase
    const percentageTopClasses = dataTopClasses.map(function(count) {
        return ((count / totalPurchases) * 100).toFixed(2);
    });

    // Line Chart: Pendapatan Bulanan
    const ctxMonthly = document.getElementById('monthlyRevenueChart').getContext('2d');
    const gradient = ctxMonthly.createLinearGradient(0, 0, 0, 350);
    gradient.addColorStop(0, 'rgba(75, 192, 192, 0.4)');
    gradient.addColorStop(1, 'rgba(75, 192, 192, 0)');

    new Chart(ctxMonthly, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Pendapatan Bulanan (Rp)',
                data: monthlyRevenue,
                fill: true,
                backgroundColor: gradient,
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.4,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: { labels: { font: { size: 14 }} },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Doughnut Chart: Member dan Non Member
    const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Member', 'Non Member'],
            datasets: [{
                data: [totalMember, totalNonMember],
                backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(255, 99, 132, 0.7)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 14 }, boxWidth: 20 }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' orang';
                        }
                    }
                }
            }
        }
    });

    // Pie Chart: 3 Kelas Paling Sering Dibeli
    if(labelsTopClasses.length > 0){
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: labelsTopClasses,
                datasets: [{
                    label: 'Persentase Pembelian',
                    data: percentageTopClasses,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { size: 14 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endsection