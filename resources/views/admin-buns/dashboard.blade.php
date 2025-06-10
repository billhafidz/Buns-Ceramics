@extends('layouts.admin')

@section('content')
    <div class="p-6" id="dashboard-content">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ session('admin_nama') }}!</h1>
                <p class="text-gray-600 mb-2">Berikut adalah ringkasan data sistem hari ini:</p>
            </div>
            <button id="printDashboard"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Dashboard
            </button>
        </div>

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
                @if (count($labelsTopClasses) === 0)
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
                    @foreach ($allClasses as $kelas)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $kelas->nama_kelas }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $kelas->jumlah }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">Rp
                                {{ number_format($kelas->total_pendapatan, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Print-only version of the dashboard -->
    <div id="print-dashboard" style="display: none;">
        <div id="watermark" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1000;"></div>
        
        <div class="print-header">
            <h1 style="text-align: center; font-size: 24px; font-weight: bold; margin-bottom: 5px;">Laporan Dashboard Admin
            </h1>
            <p style="text-align: center; margin-bottom: 15px;" id="print-date"></p>
            <hr style="margin-bottom: 20px;">
        </div>

        <div class="print-summary" style="margin-bottom: 20px;">
            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">Ringkasan Data Sistem</h2>
            <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                <div style="width: 30%; text-align: center; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <h3 style="font-weight: bold; margin-bottom: 8px;">💰 Total Uang Masuk</h3>
                    <p style="font-size: 20px; color: #059669; font-weight: bold;" id="print-total-uang"></p>
                </div>
                <div style="width: 30%; text-align: center; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <h3 style="font-weight: bold; margin-bottom: 8px;">👤 Total Member</h3>
                    <p style="font-size: 20px; color: #2563eb; font-weight: bold;" id="print-total-member"></p>
                </div>
                <div style="width: 30%; text-align: center; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <h3 style="font-weight: bold; margin-bottom: 8px;">🙋 Non-Member</h3>
                    <p style="font-size: 20px; color: #ef4444; font-weight: bold;" id="print-total-non-member"></p>
                </div>
            </div>
        </div>

        <div class="print-monthly-revenue" style="margin-bottom: 30px;">
            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">📈 Pendapatan Bulanan Tahun
                {{ date('Y') }}</h2>
            <div style="height: 300px; width: 100%; position: relative;">
                <canvas id="print-monthly-chart"></canvas>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 30px; page-break-inside: avoid;">
            <div style="width: 48%;">
                <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">👥 Komposisi Member & Non-Member</h2>
                <div
                    style="height: 250px; width: 100%; position: relative; display: flex; justify-content: center; align-items: center;">
                    <canvas id="print-doughnut-chart" style="max-width: 250px; max-height: 250px;"></canvas>
                </div>
            </div>
            <div style="width: 48%;">
                <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">🎯 3 Kelas Paling Sering Dibeli</h2>
                <div
                    style="height: 250px; width: 100%; position: relative; display: flex; justify-content: center; align-items: center;">
                    <canvas id="print-pie-chart" style="max-width: 250px; max-height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <div class="print-table" style="margin-bottom: 30px; page-break-inside: avoid;">
            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">📊 Detail Kelas dan Pendapatan</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f3f4f6;">
                        <th style="padding: 10px; text-align: left; border: 1px solid #e5e7eb;">Nama Kelas</th>
                        <th style="padding: 10px; text-align: left; border: 1px solid #e5e7eb;">Jumlah Pembelian</th>
                        <th style="padding: 10px; text-align: left; border: 1px solid #e5e7eb;">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody id="print-table-body">
                    <!-- Will be filled by JavaScript -->
                </tbody>
            </table>
        </div>

        <div class="print-footer"
            style="text-align: center; margin-top: 40px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
            <p>© {{ date('Y') }} Sistem Manajemen Dashboard</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyRevenue = @json(array_values($monthlyRevenue));
        const totalPurchases = {{ array_sum($dataTopClasses) }};
        const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        const totalMember = {{ $totalMember }};
        const totalNonMember = {{ $totalNonMember }};
        const labelsTopClasses = @json($labelsTopClasses);
        const dataTopClasses = @json($dataTopClasses);
        const totalUangMasuk = '{{ number_format($totalUangMasuk, 0, ',', '.') }}';

        const classData = [];
        @foreach ($allClasses as $kelas)
            classData.push({
                nama: '{{ $kelas->nama_kelas }}',
                jumlah: {{ $kelas->jumlah }},
                pendapatan: '{{ number_format($kelas->total_pendapatan, 0, ',', '.') }}'
            });
        @endforeach

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
                    legend: {
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
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
                        labels: {
                            font: {
                                size: 14
                            },
                            boxWidth: 20
                        }
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
        if (labelsTopClasses.length > 0) {
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
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
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

        document.getElementById('printDashboard').addEventListener('click', function() {
            const now = new Date();
            const formattedDate = now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('print-date').textContent = 'Dicetak pada: ' + formattedDate;

            document.getElementById('print-total-uang').textContent = 'Rp ' + totalUangMasuk;
            document.getElementById('print-total-member').textContent = totalMember;
            document.getElementById('print-total-non-member').textContent = totalNonMember;

            const tableBody = document.getElementById('print-table-body');
            tableBody.innerHTML = '';
            classData.forEach(kelas => {
                const row = `
                    <tr>
                        <td style="padding: 10px; border: 1px solid #e5e7eb;">${kelas.nama}</td>
                        <td style="padding: 10px; border: 1px solid #e5e7eb;">${kelas.jumlah}</td>
                        <td style="padding: 10px; border: 1px solid #e5e7eb;">Rp ${kelas.pendapatan}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            document.getElementById('print-dashboard').style.display = 'block';
            
            setupWatermark();

            setTimeout(() => {
                createPrintCharts();

                const style = document.createElement('style');
                style.innerHTML = `
                    @media print {
                        body * {
                            visibility: hidden;
                        }
                        #print-dashboard, #print-dashboard * {
                            visibility: visible;
                        }
                        #print-dashboard {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 100%;
                        }
                        #watermark {
                            display: block !important;
                            visibility: visible !important;
                        }
                        @page {
                            size: A4;
                            margin: 1cm;
                        }
                        .page-break-inside-avoid {
                            page-break-inside: avoid;
                        }
                    }
                `;
                document.head.appendChild(style);

                setTimeout(() => {
                    window.print();
                    document.getElementById('print-dashboard').style.display = 'none';
                    document.head.removeChild(style);
                }, 1000);
            }, 100);
        });

        function setupWatermark() {
            const watermark = document.getElementById('watermark');
            
            const canvas = document.createElement('canvas');
            canvas.width = 2000;
            canvas.height = 2000;
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            canvas.style.position = 'absolute';
            canvas.style.top = '0';
            canvas.style.left = '0';
            
            const ctx = canvas.getContext('2d');
            
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            ctx.translate(canvas.width / 2, canvas.height / 2);
            ctx.rotate(Math.PI / 4);
            ctx.translate(-canvas.width / 2, -canvas.height / 2);
            
            ctx.font = 'bold 70px Arial';
            ctx.fillStyle = 'rgba(150, 150, 150, 0.15)';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            
            for (let i = -2; i <= 2; i += 2) {
                for (let j = -2; j <= 2; j += 2) {
                    const x = (canvas.width / 2) + (i * 500);
                    const y = (canvas.height / 2) + (j * 500);
                    ctx.fillText('Buns Ceramics', x, y);
                }
            }
            
            watermark.innerHTML = '';
            watermark.appendChild(canvas);
        }

        function createPrintCharts() {
            Chart.helpers.each(Chart.instances, function(instance) {
                if (instance.canvas.id.includes('print-')) {
                    instance.destroy();
                }
            });

            // Monthly Revenue Chart for printing
            const printMonthlyCanvas = document.getElementById('print-monthly-chart');
            if (printMonthlyCanvas) {
                const printMonthlyCtx = printMonthlyCanvas.getContext('2d');
                new Chart(printMonthlyCtx, {
                    type: 'line',
                    data: {
                        labels: monthLabels,
                        datasets: [{
                            label: 'Pendapatan Bulanan (Rp)',
                            data: monthlyRevenue,
                            fill: true,
                            backgroundColor: 'rgba(75, 192, 192, 0.4)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString();
                                    },
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 10
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    }
                });
            }

            // Doughnut Chart for printing
            const printDoughnutCanvas = document.getElementById('print-doughnut-chart');
            if (printDoughnutCanvas) {
                const printDoughnutCtx = printDoughnutCanvas.getContext('2d');
                new Chart(printDoughnutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Member', 'Non Member'],
                        datasets: [{
                            data: [totalMember, totalNonMember],
                            backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)'],
                            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        aspectRatio: 1,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 10
                                    },
                                    boxWidth: 15,
                                    padding: 10
                                }
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    }
                });
            }

            // Pie Chart for printing
            const printPieCanvas = document.getElementById('print-pie-chart');
            if (printPieCanvas && labelsTopClasses.length > 0) {
                const printPieCtx = printPieCanvas.getContext('2d');
                new Chart(printPieCtx, {
                    type: 'pie',
                    data: {
                        labels: labelsTopClasses,
                        datasets: [{
                            label: 'Persentase Pembelian',
                            data: percentageTopClasses,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                            ],
                            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        aspectRatio: 1,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 10
                                    },
                                    boxWidth: 15,
                                    padding: 10
                                }
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    }
                });
            }
        }
    </script>
@endsection