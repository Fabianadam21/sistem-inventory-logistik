@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
            .dashboard-shell {
                max-width: 1200px;
                margin: 0 auto;
            }

            .page-intro {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 24px;
                margin-bottom: 22px;
            }

            .page-intro-copy {
                min-width: 0;
            }

            .page-title {
                margin: 0;
                color: #172033;
                font-size: 28px;
                line-height: 1.2;
                font-weight: 700;
            }

            .page-subtitle {
                margin: 8px 0 0;
                color: #475569;
                font-size: 15px;
                font-weight: 400;
            }

            .page-logo {
                display: block;
                flex: 0 0 auto;
                width: 56px;
                height: 78px;
                object-fit: contain;
            }

            .chart-card {
                background: white;
                border: 1px solid #d8e0e9;
                border-radius: 10px;
                padding: 22px 22px 18px;
                box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
                margin-bottom: 24px;
            }

            .chart-card-header {
                margin-bottom: 18px;
            }

            .chart-card h3 {
                margin: 0;
                font-size: 18px;
                color: #172033;
            }

            .chart-card .subtitle {
                margin: 8px 0 0;
                color: #475569;
                font-size: 14px;
                line-height: 1.5;
            }

            .cards {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
                margin-bottom: 24px;
            }

            .stat-card {
                background: white;
                border: 1px solid #d8e0e9;
                border-radius: 10px;
                padding: 18px 18px 16px;
                box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
            }

            .card-title {
                color: #475569;
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 10px;
            }

            .card-value {
                font-size: 28px;
                font-weight: 700;
                line-height: 1.2;
                color: #0f172a;
                letter-spacing: -.02em;
            }

            .section {
                margin-bottom: 24px;
            }

            .panel-table {
                background: white;
                border: 1px solid #d8e0e9;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
            }

            .panel-table h3 {
                margin: 0 0 14px;
                color: #172033;
                font-size: 18px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                padding: 12px 10px;
                border-bottom: 1px solid #dbe2ea;
                text-align: left;
                vertical-align: middle;
            }

            th {
                background: #f1f5f9;
                color: #334155;
                font-size: 12px;
                font-weight: 700;
                letter-spacing: .02em;
                text-transform: uppercase;
            }

            td {
                color: #263445;
                font-size: 14px;
            }

            tbody tr:hover {
                background: #f5f7fa;
            }

            .warning {
                color: #b91c1c;
                font-weight: 700;
            }

            .grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            @media (max-width: 900px) {
                .cards {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 640px) {
                .cards,
                .grid {
                    grid-template-columns: 1fr;
                }

                .page-title {
                    font-size: 24px;
                }

                .page-intro {
                    gap: 14px;
                }

                .page-logo {
                    width: 42px;
                    height: 60px;
                }
            }
    </style>
@endpush

@section('content')

        <div class="dashboard-shell">

            <div class="page-intro">
                <div class="page-intro-copy">
                    <h1 class="page-title">Ringkasan Inventory</h1>
                    <p class="page-subtitle">Selamat datang kembali, Administrator. Berikut ringkasan kondisi inventory saat ini.</p>
                </div>
                <img
                    class="page-logo"
                    src="{{ asset('images/logo-pemkot.png') }}"
                    alt="Logo Pemerintah Kota"
                >
            </div>

            <div class="chart-card">

                <div class="chart-card-header">
                    <h3>Grafik Transaksi</h3>
                    <div class="subtitle">
                        Perbandingan transaksi Barang Masuk dan Barang Keluar selama 6 bulan terakhir
                    </div>
                </div>

                <div style="height:330px;">
                    <canvas id="transactionChart"></canvas>
                </div>

            </div>

            <div class="cards">

                <div class="stat-card">
                    <div class="card-title">
                        Total Jenis Barang
                    </div>

                    <div class="card-value">
                        {{ $totalItems }}
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-title">
                        Total Stok
                    </div>

                    <div class="card-value">
                        {{ $totalStock }}
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-title">
                        Transaksi Barang Masuk
                    </div>

                    <div class="card-value">
                        {{ $totalIncoming }}
                    </div>
                </div>

                <div class="stat-card">
                    <div class="card-title">
                        Transaksi Barang Keluar
                    </div>

                    <div class="card-value">
                        {{ $totalOutgoing }}
                    </div>
                </div>

            </div>

            <div class="section">

                <div class="panel-table">

                    <h3>Stok Menipis</h3>

                    <table>

                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Stok</th>
                                <th>Minimum</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($lowStockItems as $item)

                                <tr>
                                    <td>
                                        {{ $item->name }}
                                    </td>

                                    <td class="warning">
                                        {{ $item->stock }}
                                    </td>

                                    <td>
                                        {{ $item->minimum_stock }}
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3">
                                        Tidak ada barang dengan stok menipis.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="grid">

                <div class="panel-table">

                    <h3>Barang Masuk Terbaru</h3>

                    <table>

                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Sumber Dana</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($recentIncoming as $transaction)

                                <tr>
                                    <td>
                                        {{ $transaction->transaction_number }}
                                    </td>

                                    <td>
                                        {{ $transaction->supplier->name }}
                                    </td>

                                    <td>
                                        {{ $transaction->date->format('d-m-Y') }}
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3">
                                        Belum ada transaksi.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="panel-table">

                    <h3>Barang Keluar Terbaru</h3>

                    <table>

                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Unit</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($recentOutgoing as $transaction)

                                <tr>
                                    <td>
                                        {{ $transaction->transaction_number }}
                                    </td>

                                    <td>
                                        {{ $transaction->department->name }}
                                    </td>

                                    <td>
                                        {{ $transaction->date->format('d-m-Y') }}
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3">
                                        Belum ada transaksi.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        const chartLabels = @json($chartLabels);

        const incomingChartData = @json($incomingChartData);

        const outgoingChartData = @json($outgoingChartData);


        const ctx =
            document
                .getElementById('transactionChart')
                .getContext('2d');


        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: chartLabels,

                datasets: [

                    {
                        label: 'Barang Masuk',
                        data: incomingChartData,
                        backgroundColor: '#3478e5',
                        borderColor: '#245fbd',
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false,
                        maxBarThickness: 26
                    },

                    {
                        label: 'Barang Keluar',
                        data: outgoingChartData,
                        backgroundColor: '#bd4d59',
                        borderColor: '#963844',
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false,
                        maxBarThickness: 26
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {

                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'rect',
                            padding: 16,
                            color: '#263445'
                        }
                    }

                },

                scales: {

                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#475569'
                        }
                    },

                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#d8e0e9'
                        },
                        ticks: {
                            precision: 0,
                            color: '#475569'
                        }
                    }

                }

            }

        });

    </script>

@endsection