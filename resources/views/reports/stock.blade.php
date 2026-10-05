@extends('layouts.app')

@section('title', 'Laporan Persediaan')

@section('content')
    <div class="page-header">
        <div>
            <h1>Laporan Persediaan Barang</h1>
            <div class="subtitle">
                {{ $period_title }} · Rincian barang masuk, barang keluar, dan saldo akhir per bulan
            </div>
        </div>

        <div class="actions no-print">
            <a href="{{ route('reports.stock.excel', request()->query()) }}" class="btn btn-primary">
                📊 Export Excel
            </a>
            <a href="{{ route('reports.stock.pdf', request()->query()) }}" class="btn btn-danger">
                📄 Export PDF
            </a>
            <button type="button" onclick="window.print()" class="btn btn-secondary">
                🖨 Cetak
            </button>
        </div>
    </div>

    <form action="{{ route('reports.stock') }}" method="GET" class="card no-print stock-filters">
        <div class="stock-filter-grid">
            <div class="form-group">
                <label for="search">Cari Barang</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Kode atau nama barang..."
                >
            </div>

            <div class="form-group">
                <label for="year">Tahun</label>
                <select id="year" name="year" class="form-control">
                    @foreach(range(max(2000, now()->year - 5), min(2100, now()->year + 1)) as $optionYear)
                        <option value="{{ $optionYear }}" {{ $year === $optionYear ? 'selected' : '' }}>
                            {{ $optionYear }}
                        </option>
                    @endforeach
                    @if($year < max(2000, now()->year - 5) || $year > min(2100, now()->year + 1))
                        <option value="{{ $year }}" selected>{{ $year }}</option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester" class="form-control">
                    <option value="1" {{ $semester === 1 ? 'selected' : '' }}>Semester I · Januari–Juni</option>
                    <option value="2" {{ $semester === 2 ? 'selected' : '' }}>Semester II · Juli–Desember</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stock_status">Status Buffer Stock</label>
                <select id="stock_status" name="stock_status" class="form-control">
                    <option value="">Semua</option>
                    <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Menipis</option>
                    <option value="safe" {{ request('stock_status') === 'safe' ? 'selected' : '' }}>Aman</option>
                </select>
            </div>

            <div class="stock-filter-actions">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
                <a href="{{ route('reports.stock') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <div class="stock-summary no-print">
        <div class="stock-summary-card">
            <span>Stok Awal (Akumulasi Satuan)</span>
            <strong>{{ number_format($summary['opening_stock'], 0, ',', '.') }}</strong>
        </div>
        <div class="stock-summary-card">
            <span>Barang Masuk (Akumulasi Satuan)</span>
            <strong>{{ number_format($summary['total_incoming'], 0, ',', '.') }}</strong>
        </div>
        <div class="stock-summary-card">
            <span>Barang Keluar (Akumulasi Satuan)</span>
            <strong>{{ number_format($summary['total_outgoing'], 0, ',', '.') }}</strong>
        </div>
        <div class="stock-summary-card stock-summary-highlight">
            <span>Buffer Stock (Akumulasi Satuan)</span>
            <strong>{{ number_format($summary['buffer_stock'], 0, ',', '.') }}</strong>
        </div>
        <div class="stock-summary-card">
            <span>Nilai Total Buffer Stock</span>
            <strong>
                {{ $summary['total_value'] !== null ? 'Rp ' . number_format($summary['total_value'], 0, ',', '.') : '-' }}
            </strong>
        </div>
    </div>

    <div class="stock-report-note">
        Buffer Stock adalah saldo akhir periode (stok awal + barang masuk − barang keluar).
        Saldo ini otomatis menjadi stok awal pada semester berikutnya. Stok awal direkonstruksi dari saldo barang
        saat ini dan riwayat transaksi; pastikan seluruh transaksi tercatat dengan tanggal yang benar.
        Nilai total tidak mencakup barang yang belum memiliki harga satuan.
    </div>

    <div class="card stock-report-card">
        <div class="table-wrapper">
            <table class="stock-report-table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Kode Barang</th>
                        <th rowspan="2">Nama Barang</th>
                        <th rowspan="2">Kategori</th>
                        <th rowspan="2">Satuan</th>
                        <th rowspan="2">Sumber Dana</th>
                        <th rowspan="2">{{ $opening_stock_label }}</th>
                        @foreach($months as $month)
                            <th colspan="2">{{ $month['name'] }}</th>
                        @endforeach
                        <th rowspan="2">Total Barang Masuk</th>
                        <th rowspan="2">Total Barang Keluar</th>
                        <th rowspan="2">Buffer Stock</th>
                        <th rowspan="2">Harga Satuan</th>
                        <th rowspan="2">Total Harga</th>
                        <th rowspan="2">Minimum</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2" class="no-print">Aksi</th>
                    </tr>
                    <tr>
                        @foreach($months as $month)
                            <th>Masuk</th>
                            <th>Keluar</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->code }}</td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>{{ $item->category->name ?? '-' }}</td>
                            <td>{{ $item->unit->name ?? '-' }}</td>
                            <td>{{ $item->supplier->name ?? '-' }}</td>
                            <td class="numeric">{{ number_format($item->opening_stock, 0, ',', '.') }}</td>
                            @foreach($months as $month)
                                <td class="numeric">{{ number_format($item->monthly_movements[$month['number']]['incoming'], 0, ',', '.') }}</td>
                                <td class="numeric">{{ number_format($item->monthly_movements[$month['number']]['outgoing'], 0, ',', '.') }}</td>
                            @endforeach
                            <td class="numeric">{{ number_format($item->total_incoming, 0, ',', '.') }}</td>
                            <td class="numeric">{{ number_format($item->total_outgoing, 0, ',', '.') }}</td>
                            <td class="numeric"><strong>{{ number_format($item->buffer_stock, 0, ',', '.') }}</strong></td>
                            <td class="numeric">
                                {{ $item->price !== null ? 'Rp ' . number_format((float) $item->price, 0, ',', '.') : '-' }}
                            </td>
                            <td class="numeric">
                                {{ $item->total_value !== null ? 'Rp ' . number_format($item->total_value, 0, ',', '.') : '-' }}
                            </td>
                            <td class="numeric">{{ number_format($item->minimum_stock, 0, ',', '.') }}</td>
                            <td>
                                @if($item->buffer_stock <= $item->minimum_stock)
                                    <span class="badge badge-red">Menipis</span>
                                @else
                                    <span class="badge badge-green">Aman</span>
                                @endif
                            </td>
                            <td class="no-print">
                                <form
                                    action="{{ route('items.destroy', $item) }}"
                                    method="POST"
                                    data-confirm-message="Hapus data barang {{ $item->name }}? Barang yang sudah digunakan dalam transaksi tidak dapat dihapus."
                                    onsubmit="return window.simlogConfirmEnabled ? true : confirm('Hapus data barang ini?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="27" class="empty-row">Data barang tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .stock-filters {
            margin-bottom: 18px;
        }

        .stock-filter-grid {
            display: grid;
            grid-template-columns: minmax(220px, 2fr) repeat(3, minmax(150px, 1fr)) auto;
            gap: 14px;
            align-items: end;
        }

        .stock-filter-grid .form-group {
            margin-bottom: 0;
        }

        .stock-filter-actions {
            display: flex;
            gap: 8px;
            padding-bottom: 18px;
        }

        .stock-summary {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }

        .stock-summary-card {
            display: flex;
            min-height: 82px;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
            padding: 14px 16px;
            border: 1px solid #e8edf2;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .035);
        }

        .stock-summary-card span {
            color: #64748b;
            font-size: 12px;
        }

        .stock-summary-card strong {
            color: #1e293b;
            font-size: 20px;
        }

        .stock-summary-highlight {
            border-color: rgba(212, 175, 55, .4);
            background: #fffbeb;
        }

        .stock-summary-highlight strong {
            color: #7c2d12;
        }

        .stock-report-note {
            margin-bottom: 14px;
            padding: 12px 15px;
            border-left: 3px solid #d4af37;
            border-radius: 5px;
            background: #fffbeb;
            color: #713f12;
            font-size: 13px;
        }

        .stock-report-card {
            padding: 12px;
        }

        .stock-report-table {
            min-width: 1900px;
            font-size: 12px;
        }

        .stock-report-table th,
        .stock-report-table td {
            padding: 9px 8px;
            vertical-align: middle;
        }

        .stock-report-table thead th {
            background: #f8f5e9;
            color: #473d25;
            text-align: center;
            white-space: nowrap;
        }

        .stock-report-table thead tr:first-child th {
            border-bottom-color: #d9c98d;
        }

        .stock-report-table .numeric {
            text-align: right;
            white-space: nowrap;
        }

        .stock-report-table .empty-row {
            padding: 36px;
            text-align: center;
        }

        @media (max-width: 1100px) {
            .stock-filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .stock-filter-grid .form-group:first-child {
                grid-column: 1 / -1;
            }

            .stock-filter-actions {
                padding-bottom: 18px;
            }

            .stock-summary {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .stock-filter-grid {
                grid-template-columns: 1fr;
            }

            .stock-filter-grid .form-group:first-child {
                grid-column: auto;
            }

            .stock-filter-actions {
                padding-bottom: 0;
            }

            .stock-summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media print {
            @page {
                size: landscape;
                margin: 8mm;
            }

            .sidebar,
            .sidebar-overlay,
            .topbar,
            .mobile-header,
            .no-print,
            .stock-summary,
            .stock-report-note {
                display: none !important;
            }

            .content {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .page-header {
                margin-bottom: 10px;
            }

            .page-header h1 {
                font-size: 17px;
                text-align: center;
            }

            .page-header .subtitle {
                margin-top: 4px;
                text-align: center;
            }

            .stock-report-card,
            .card {
                padding: 0;
                border: 0;
                box-shadow: none;
            }

            .table-wrapper {
                overflow: visible;
            }

            .stock-report-table {
                min-width: 0;
                width: 100%;
                font-size: 7px;
            }

            .stock-report-table th,
            .stock-report-table td {
                padding: 3px;
            }

            .stock-report-table thead {
                display: table-header-group;
            }

            .stock-report-table tr {
                page-break-inside: avoid;
            }
        }
    </style>
@endsection
