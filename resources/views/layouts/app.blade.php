<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIMLOG')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            width: 250px;
            background: #1e293b;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 25px 14px;
            overflow-y: auto;
        }

        .brand {
            padding: 0 16px;
            font-size: 25px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .brand-subtitle {
            padding: 5px 16px 25px;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.5;
        }

        .menu-title {
            padding: 18px 16px 7px;
            font-size: 11px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 600;
        }

        .menu a {
            display: flex;
            align-items: center;
            padding: 11px 16px;
            margin: 3px 0;
            border-radius: 8px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
            transition: .2s;
        }

        .menu a:hover {
            background: #334155;
            color: white;
        }

        .menu a.active {
            background: #2563eb;
            color: white;
            font-weight: 600;
        }

        /* CONTENT */

        .content {
            width: calc(100% - 250px);
            margin-left: 250px;
            padding: 32px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 28px;
            color: #0f172a;
        }

        .subtitle {
            margin-top: 7px;
            color: #64748b;
            font-size: 14px;
        }

        /* CARD */

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, .05);
        }

        /* BUTTON */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            transition: .2s;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-detail {
            background: #0ea5e9;
            color: white;
        }

        /* TABLE */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
        }

        td {
            color: #334155;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        /* ALERT */

        .alert {
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        /* BADGE */

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-green {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-red {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* FORM */

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            background: white;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            .content {
                width: calc(100% - 210px);
                margin-left: 210px;
                padding: 20px;
            }

        }

        @media (max-width: 700px) {

            .sidebar {
                position: static;
                width: 100%;
            }

            .layout {
                display: block;
            }

            .content {
                width: 100%;
                margin-left: 0;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <div class="layout">

        <aside class="sidebar">

            <div class="brand">
                SIMLOG
            </div>

            <div class="brand-subtitle">
                Sistem Informasi Inventory Logistik
            </div>

            <nav class="menu">

                <div class="menu-title">
                    Utama
                </div>

                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <div class="menu-title">
                    Master Data
                </div>

                <a href="{{ route('items.index') }}" class="{{ request()->routeIs('items.*') ? 'active' : '' }}">
                    Barang
                </a>

                <a href="{{ route('categories.index') }}"
                    class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    Kategori
                </a>

                <a href="{{ route('units.index') }}" class="{{ request()->routeIs('units.*') ? 'active' : '' }}">
                    Satuan
                </a>

                <a href="{{ route('warehouses.index') }}"
                    class="{{ request()->routeIs('warehouses.*') ? 'active' : '' }}">
                    Gudang
                </a>

                <a href="{{ route('suppliers.index') }}"
                    class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    Supplier
                </a>

                <a href="{{ route('departments.index') }}"
                    class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">
                    Unit / Bidang
                </a>

                <div class="menu-title">
                    Transaksi
                </div>

                <a href="{{ route('incoming-transactions.index') }}"
                    class="{{ request()->routeIs('incoming-transactions.*') ? 'active' : '' }}">
                    Barang Masuk
                </a>

                <a href="{{ route('outgoing-transactions.index') }}"
                    class="{{ request()->routeIs('outgoing-transactions.*') ? 'active' : '' }}">
                    Barang Keluar
                </a>

                <div class="menu-title">
                    Laporan
                </div>

                <a href="{{ route('reports.stock') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    Laporan Stok
                </a>

            </nav>

        </aside>

        <main class="content">

            @yield('content')

        </main>

    </div>

</body>

</html>