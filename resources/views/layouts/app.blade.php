<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIMLOG')</title>

    <script>
        document.documentElement.classList.add('js-loading');
        window.setTimeout(() => document.documentElement.classList.remove('js-loading'), 8000);
        document.addEventListener('DOMContentLoaded', () => {
            requestAnimationFrame(() => document.documentElement.classList.remove('js-loading'));
        }, { once: true });
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        .mobile-header {
            display: none;
        }

        @media (max-width: 700px) {

            .mobile-header {
                display: block;
                margin-bottom: 10px;
            }

        }

        @media (max-width: 700px) {

            .actions {
                width: 100%;
            }

            .actions .btn {
                flex: 1;
            }

            .card {
                padding: 15px;
            }

            .table-wrapper {
                margin-left: -15px;
                margin-right: -15px;
                width: calc(100% + 30px);
            }

        }

        .mobile-menu-button {
            display: none;
            width: 42px;
            height: 42px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 700px) {

            .mobile-menu-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .sidebar {
                position: fixed;
                z-index: 1000;
                width: 250px;
                transform: translateX(-100%);
                transition: transform .25s ease;
                box-shadow: 5px 0 20px rgba(15, 23, 42, .15);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay {
                position: fixed;
                z-index: 999;
                inset: 0;
                background: rgba(15, 23, 42, .45);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .content {
                width: 100%;
                margin-left: 0;
                padding: 15px;
            }

            .topbar {
                padding: 0 12px;
            }

            .topbar-title {
                display: none;
            }

            .user-info {
                display: none;
            }

            .page-header h1 {
                font-size: 24px;
            }
        }

        .topbar {
            min-height: 64px;
            background: white;
            border: 1px solid #d8e0e9;
            border-radius: 12px;
            padding: 0 20px;
            margin-bottom: 25px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
        }

        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
        }

        .user-role {
            margin-top: 2px;
            font-size: 11px;
            color: #64748b;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #2563eb;
            color: white;

            font-size: 14px;
            font-weight: 700;
        }

        body {
            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                radial-gradient(circle at 8% 5%,
                    rgba(139, 36, 50, .06),
                    transparent 28%),
                radial-gradient(circle at 90% 15%,
                    rgba(212, 175, 55, .07),
                    transparent 25%),
                #f5f3f2;

            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            width: 250px;

            background:
                linear-gradient(180deg,
                    rgba(72, 15, 24, .98) 0%,
                    rgba(98, 23, 36, .96) 100%);

            color: white;

            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;

            padding: 20px 14px;
            overflow-y: auto;
            z-index: 1000;

            border-right: 1px solid rgba(212, 175, 55, .22);

            box-shadow: 4px 0 18px rgba(41, 7, 15, .10);

            scrollbar-width: thin;
            scrollbar-color: rgba(212, 175, 55, .4) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, .35);
            border-radius: 10px;
        }

        /* MENU */

        .menu a {
            display: flex;
            align-items: center;

            min-height: 42px;

            padding: 8px 12px;
            margin: 4px 2px;

            border-radius: 8px;

            color: #f1dfe1;

            text-decoration: none;

            font-size: 13.5px;
            font-weight: 500;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease,
                border-color .2s ease;
        }

        /* ICON */

        .menu-icon {
            width: 20px;
            min-width: 20px;

            margin-right: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #d4af37;

            transition:
                color .2s ease,
                transform .2s ease;
        }

        .menu-icon svg {
            width: 18px;
            height: 18px;

            stroke: currentColor;
            stroke-width: 1.8;

            fill: none;
        }

        /* HOVER */

        .menu a:hover {
            background: rgba(255, 255, 255, .04);
            color: #ffffff;
            transform: translateX(1px);
            border-left: 2px solid rgba(212, 175, 55, .8);
        }

        .menu a:hover .menu-icon {
            color: #f1c75b;

            transform: scale(1.08);
        }

        /* ACTIVE */

        .menu a.active {
            background:
                linear-gradient(135deg,
                    rgba(154, 30, 45, .9),
                    rgba(112, 28, 42, .72));

            color: #ffffff;
            font-weight: 600;

            border: 1px solid rgba(212, 175, 55, .28);
            box-shadow: inset 3px 0 0 #f1c75b;
        }

        .menu a.active .menu-icon {
            color: #f1c75b;
        }

        /* USER CARD */

        .sidebar-user {
            margin-top: 20px;
            padding: 14px;

            border-radius: 14px;

            background:
                linear-gradient(135deg,
                    rgba(212, 175, 55, .10),
                    rgba(255, 255, 255, .035));

            border: 1px solid rgba(212, 175, 55, .18);

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .04);
        }

        .sidebar-user-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-avatar {
            width: 38px;
            height: 38px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background:
                linear-gradient(135deg,
                    #d4af37,
                    #f1c75b);

            color: #4a1018;

            font-size: 14px;
            font-weight: 800;

            box-shadow:
                0 5px 14px rgba(212, 175, 55, .25);
        }

        .sidebar-user-info {
            min-width: 0;
        }

        .sidebar-user-name {
            color: white;

            font-size: 12px;
            font-weight: 600;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            margin-top: 3px;

            color: #e0bfc3;

            font-size: 10px;
        }

        .sidebar-logout {
            width: 100%;

            margin-top: 12px;

            padding: 9px 10px;

            border: 1px solid rgba(212, 175, 55, .15);

            border-radius: 9px;

            background:
                rgba(255, 255, 255, .04);

            color: #ead7d9;

            font-size: 12px;

            cursor: pointer;

            transition: .2s;
        }

        .sidebar-logout:hover {
            background: rgba(212, 175, 55, .12);

            color: #f1c75b;

            border-color: rgba(212, 175, 55, .30);
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
            border: 1px solid #e8edf2;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 1px 0 rgba(15, 23, 42, .02), 0 8px 18px rgba(15, 23, 42, .03);
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

        .actions .btn-warning,
        .actions .btn-danger {
            min-height: 34px;
            padding: 7px 11px;
            border: 1px solid transparent;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1;
            transition: background-color .15s ease, color .15s ease, border-color .15s ease;
        }

        .actions .btn-warning {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .actions .btn-warning:hover {
            background: #dbeafe;
            border-color: #bfdbfe;
        }

        .actions .btn-danger {
            background: #fef2f2;
            color: #b91c1c;
        }

        .actions .btn-danger:hover {
            background: #fee2e2;
            border-color: #fecaca;
        }

        .actions .btn:focus-visible {
            outline: 2px solid #2563eb;
            outline-offset: 2px;
        }

        .btn-detail {
            background: #0ea5e9;
            color: white;
        }

        /* TABLE */

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        .table-wrapper table {
            min-width: 700px;
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

            .content {
                width: 100%;
                margin-left: 0;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .pagination {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                gap: 5px;
                margin-top: 20px;
                flex-wrap: wrap;
            }

            .pagination a,
            .pagination span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 34px;
                height: 34px;
                padding: 0 10px;
                border-radius: 7px;
                text-decoration: none;
                font-size: 13px;
                border: 1px solid #e5e7eb;
                background: white;
                color: #475569;
            }

            .pagination a:hover {
                background: #f1f5f9;
            }

            .pagination .page-active {
                background: #2563eb;
                color: white;
                border-color: #2563eb;
                font-weight: 600;
            }

            .pagination .page-disabled {
                color: #cbd5e1;
                background: #f8fafc;
            }
        }

        @media (max-width: 700px) {

            .form-group {
                margin-bottom: 15px;
            }

            .form-control {
                width: 100%;
                font-size: 16px;
                padding: 12px;
            }

            .form-group label {
                font-size: 13px;
            }

            .card {
                width: 100%;
            }

            .actions {
                width: 100%;
                flex-direction: row;
                align-items: center;
                flex-wrap: nowrap;
            }

            .actions .btn {
                width: auto;
                flex: 0 0 auto;
            }

        }

        /* =====================================================
   SIMLOG LIQUID GLASS SIDEBAR
   MAROON + GOLD
===================================================== */

        /* SIDEBAR */

        .sidebar {
            width: 250px;

            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;

            padding: 18px 13px;

            overflow-y: auto;
            overflow-x: hidden;

            z-index: 1000;
            isolation: isolate;

            color: #fff;

            background:
                linear-gradient(145deg,
                    rgba(104, 24, 40, .92) 0%,
                    rgba(82, 17, 31, .88) 48%,
                    rgba(43, 8, 16, .94) 100%);

            backdrop-filter:
                blur(12px) saturate(125%);

            -webkit-backdrop-filter:
                blur(12px) saturate(125%);

            border-right:
                1px solid rgba(255, 255, 255, .16);

            box-shadow:
                8px 0 24px rgba(36, 5, 12, .16),
                inset -1px 0 0 rgba(212, 175, 55, .10),
                inset 1px 0 0 rgba(255, 255, 255, .05);
        }



        /* CAHAYA AMBIENT */

        .sidebar::before {
            content: "";

            position: absolute;

            width: 320px;
            height: 320px;

            top: -150px;
            right: -150px;

            border-radius: 50%;

            background:
                radial-gradient(circle,
                    rgba(244, 208, 111, .12) 0%,
                    rgba(212, 175, 55, .045) 35%,
                    transparent 72%);

            filter: blur(10px);

            pointer-events: none;

            z-index: -1;
        }


        /* SECOND LIGHT */

        .sidebar::after {
            content: "";

            position: absolute;

            width: 280px;
            height: 280px;

            left: -170px;
            bottom: 80px;

            border-radius: 50%;

            background:
                radial-gradient(circle,
                    rgba(139, 36, 50, .20) 0%,
                    rgba(255, 255, 255, .025) 35%,
                    transparent 72%);

            filter: blur(12px);

            pointer-events: none;

            z-index: -1;
        }


        /* =====================================================
   BRAND
===================================================== */

        .sidebar .brand {
            position: relative;
            z-index: 2;

            display: flex;
            flex: 0 0 auto;
            flex-direction: column;
            justify-content: center;
            width: 100%;

            min-height: 104px;
            margin: 0 0 18px;

            padding: 14px 16px 15px;

            border-radius: 18px;
            isolation: isolate;

            background:
                linear-gradient(145deg,
                    rgba(139, 36, 50, .38),
                    rgba(255, 255, 255, .055));

            backdrop-filter:
                blur(10px) saturate(125%);

            -webkit-backdrop-filter:
                blur(10px) saturate(125%);

            border:
                1px solid rgba(255, 255, 255, .18);

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .12),
                inset 0 -1px 0 rgba(0, 0, 0, .10),
                0 8px 20px rgba(32, 5, 10, .16);

            overflow: hidden;
        }


        /* REFLECTION BRAND */

        .sidebar .brand::before {
            content: "";

            position: absolute;
            z-index: 0;

            width: 180px;
            height: 60px;

            top: -22px;
            right: -55px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, .045);

            filter: blur(10px);

            transform: rotate(-15deg);

            pointer-events: none;
        }


        /* GOLD LINE BRAND */

        .sidebar .brand::after {
            content: "";

            position: absolute;
            z-index: 0;

            left: 18px;
            right: 18px;
            bottom: 0;

            height: 2px;

            background:
                linear-gradient(90deg,
                    transparent,
                    rgba(212, 175, 55, .25),
                    #f4d06f,
                    rgba(212, 175, 55, .25),
                    transparent);

            box-shadow:
                0 0 6px rgba(212, 175, 55, .16);

            border-radius: 10px;
        }


        /* SIMLOG */

        .sidebar .brand-title {
            position: relative;
            z-index: 2;

            display: block;
            font-size: 26px;

            font-weight: 800;

            letter-spacing: 1px;

            line-height: 1.18;

            color: #f4d06f;

            text-shadow:
                0 2px 15px rgba(0, 0, 0, .25);
        }


        /* SUBTITLE */

        .sidebar .brand-subtitle {
            position: relative;
            z-index: 1;

            display: block;
            margin-top: 7px;
            padding: 0;

            color:
                rgba(255, 240, 241, .82);

            font-size: 11px;

            line-height: 1.5;

            letter-spacing: .15px;
        }


        /* =====================================================
   MENU SECTION
===================================================== */

        .sidebar .menu-title {
            position: relative;
            z-index: 2;

            min-height: 14px;
            margin: 20px 2px 8px;
            padding: 0 0 0 9px;

            color: #f1c75b;

            font-size: 11px;
            line-height: 14px;
            font-weight: 800;
            letter-spacing: .12em;

            text-transform: uppercase;

            border-left: 2px solid rgba(241, 199, 91, .8);
        }


        /* =====================================================
   MENU ITEM
===================================================== */

        .sidebar .menu a {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;

            min-height: 45px;

            margin: 4px 2px;

            padding: 10px 13px;

            border-radius: 12px;

            color:
                rgba(255, 239, 241, .82);

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, .035),
                    rgba(255, 255, 255, .012));

            border:
                1px solid rgba(255, 255, 255, .025);

            text-decoration: none;

            font-size: 13.5px;

            font-weight: 500;

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .025);

            transition:
                all .25s ease;
        }


        /* ICON */

        .sidebar .menu-icon {
            width: 20px;
            min-width: 20px;

            margin-right: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #d8b84d;

            transition:
                color .25s ease,
                transform .25s ease;
        }

        .sidebar .menu-icon svg {
            width: 18px;
            height: 18px;

            stroke: currentColor;

            stroke-width: 1.8;

            fill: none;
        }


        /* HOVER */

        .sidebar .menu a:hover {
            transform: translateX(3px);

            color: #fff;

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, .075),
                    rgba(212, 175, 55, .045));

            border:
                1px solid rgba(255, 255, 255, .12);

            box-shadow:
                inset 3px 0 0 #d4af37,
                inset 0 1px 0 rgba(255, 255, 255, .07),
                0 5px 14px rgba(28, 4, 9, .12);
        }

        .sidebar .menu a:hover .menu-icon {
            color: #f6d873;

            transform: scale(1.08);
        }


        /* =====================================================
   ACTIVE MENU
===================================================== */

        .sidebar .menu a.active {
            color: #fff;

            background:
                linear-gradient(135deg,
                    rgba(155, 42, 61, .62),
                    rgba(124, 28, 45, .52));

            border:
                1px solid rgba(212, 175, 55, .34);

            box-shadow:
                inset 3px 0 0 #f1c75b,
                inset 0 1px 0 rgba(255, 255, 255, .10),
                0 5px 16px rgba(38, 5, 11, .15);
        }

        .sidebar .menu a.active .menu-icon {
            color: #f6d873;
        }


        /* =====================================================
   USER CARD
===================================================== */

        /* =========================================
   LIQUID GLASS SIDEBAR V2
========================================= */

        .sidebar {
            width: 250px;

            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;

            padding: 18px 13px;

            overflow-y: auto;
            overflow-x: hidden;

            z-index: 1000;
            isolation: isolate;

            color: #fff;

            background:
                linear-gradient(145deg,
                    rgba(104, 24, 40, .92) 0%,
                    rgba(82, 17, 31, .88) 48%,
                    rgba(43, 8, 16, .94) 100%);

            backdrop-filter:
                blur(12px) saturate(125%);

            -webkit-backdrop-filter:
                blur(12px) saturate(125%);

            border-right:
                1px solid rgba(255, 255, 255, .16);

            box-shadow:
                8px 0 24px rgba(36, 5, 12, .16),
                inset -1px 0 0 rgba(212, 175, 55, .10),
                inset 1px 0 0 rgba(255, 255, 255, .05);
        }


        /* =========================================
   AMBIENT LIGHT
========================================= */

        .sidebar::before {
            content: "";

            position: absolute;

            width: 320px;
            height: 320px;

            top: -150px;
            right: -150px;

            border-radius: 50%;

            background:
                radial-gradient(circle,
                    rgba(244, 208, 111, .12) 0%,
                    rgba(212, 175, 55, .045) 35%,
                    transparent 72%);

            filter: blur(10px);

            pointer-events: none;

            z-index: -1;
        }


        /* SECOND LIGHT */

        .sidebar::after {
            content: "";

            position: absolute;

            width: 280px;
            height: 280px;

            left: -170px;
            bottom: 80px;

            border-radius: 50%;

            background:
                radial-gradient(circle,
                    rgba(139, 36, 50, .20) 0%,
                    rgba(255, 255, 255, .025) 35%,
                    transparent 72%);

            filter: blur(12px);

            pointer-events: none;

            z-index: -1;
        }


        /* =========================================
   BRAND GLASS
========================================= */

        .sidebar .brand {
            position: relative;
            z-index: 2;

            display: flex;
            flex: 0 0 auto;
            flex-direction: column;
            justify-content: center;
            width: 100%;

            min-height: 104px;
            margin: 0 0 18px;

            padding: 14px 16px 15px;

            border-radius: 18px;
            isolation: isolate;

            background:
                linear-gradient(145deg,
                    rgba(139, 36, 50, .38),
                    rgba(255, 255, 255, .055));

            backdrop-filter:
                blur(10px) saturate(125%);

            -webkit-backdrop-filter:
                blur(10px) saturate(125%);

            border:
                1px solid rgba(255, 255, 255, .18);

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .12),
                inset 0 -1px 0 rgba(0, 0, 0, .10),
                0 8px 20px rgba(32, 5, 10, .16);

            overflow: hidden;
        }


        /* GLASS REFLECTION BRAND */

        .sidebar .brand::before {
            content: "";

            position: absolute;
            z-index: 0;

            width: 180px;
            height: 60px;

            top: -22px;
            right: -55px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, .045);

            filter: blur(10px);

            transform: rotate(-15deg);

            pointer-events: none;
        }


        /* GOLD EDGE */

        .sidebar .brand::after {
            content: "";

            position: absolute;
            z-index: 0;

            left: 18px;
            right: 18px;
            bottom: 0;

            height: 2px;

            background:
                linear-gradient(90deg,
                    transparent,
                    rgba(212, 175, 55, .25),
                    #f4d06f,
                    rgba(212, 175, 55, .25),
                    transparent);

            box-shadow:
                0 0 6px rgba(212, 175, 55, .16);

            border-radius: 10px;
        }


        /* =========================================
   BRAND TEXT
========================================= */

        .sidebar .brand-title {
            position: relative;
            z-index: 2;

            display: block;
            font-size: 26px;

            font-weight: 800;

            letter-spacing: 1px;

            line-height: 1.18;

            color: #f4d06f;

            text-shadow:
                0 2px 15px rgba(0, 0, 0, .25);
        }


        .sidebar .brand-subtitle {
            position: relative;
            z-index: 1;

            display: block;
            margin-top: 7px;
            padding: 0;

            color:
                rgba(255, 240, 241, .82);

            font-size: 11px;

            line-height: 1.5;

            letter-spacing: .15px;
        }


        /* =========================================
   MENU SECTION
========================================= */

        .sidebar .menu-title {
            position: relative;
            z-index: 2;

            min-height: 14px;
            margin: 20px 2px 8px;
            padding: 0 0 0 9px;

            color: #f1c75b;

            font-size: 11px;
            line-height: 14px;
            font-weight: 800;
            letter-spacing: .12em;

            text-transform: uppercase;

            border-left: 2px solid rgba(241, 199, 91, .8);
        }


        /* =========================================
   MENU ITEM GLASS
========================================= */

        .sidebar .menu a {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;

            min-height: 45px;

            margin: 4px 2px;

            padding: 10px 13px;

            border-radius: 12px;

            color:
                rgba(255, 239, 241, .82);

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, .035),
                    rgba(255, 255, 255, .012));

            border:
                1px solid rgba(255, 255, 255, .025);

            text-decoration: none;

            font-size: 13.5px;

            font-weight: 500;

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .025);

            transition:
                all .25s ease;
        }


        /* =========================================
   ICON
========================================= */

        .sidebar .menu-icon {
            width: 20px;
            min-width: 20px;

            margin-right: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #d8b84d;

            transition:
                color .25s ease,
                transform .25s ease;
        }

        .sidebar .menu-icon svg {
            width: 18px;
            height: 18px;

            stroke: currentColor;

            stroke-width: 1.8;

            fill: none;
        }


        /* =========================================
   HOVER GLASS
========================================= */

        .sidebar .menu a:hover {
            transform: translateX(3px);

            color: #fff;

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, .075),
                    rgba(212, 175, 55, .045));

            border:
                1px solid rgba(255, 255, 255, .12);

            box-shadow:
                inset 3px 0 0 #d4af37,
                inset 0 1px 0 rgba(255, 255, 255, .07),
                0 5px 14px rgba(28, 4, 9, .12);
        }

        .sidebar .menu a:hover .menu-icon {
            color: #f6d873;

            transform: scale(1.08);
        }


        /* =========================================
   ACTIVE GLASS
========================================= */

        .sidebar .menu a.active {
            color: #fff;

            background:
                linear-gradient(135deg,
                    rgba(155, 42, 61, .62),
                    rgba(124, 28, 45, .52));

            border:
                1px solid rgba(212, 175, 55, .34);

            box-shadow:
                inset 3px 0 0 #f1c75b,
                inset 0 1px 0 rgba(255, 255, 255, .10),
                0 5px 16px rgba(38, 5, 11, .15);
        }

        .sidebar .menu a.active .menu-icon {
            color: #f6d873;
        }


        /* =========================================
   USER GLASS
========================================= */

        .sidebar .sidebar-user {
            position: relative;
            z-index: 2;

            margin-top: 22px;

            padding: 14px;

            border-radius: 17px;

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, .065),
                    rgba(212, 175, 55, .025));

            backdrop-filter:
                blur(10px) saturate(125%);

            -webkit-backdrop-filter:
                blur(10px) saturate(125%);

            border:
                1px solid rgba(255, 255, 255, .13);

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .08),
                0 6px 18px rgba(28, 4, 9, .14);
        }


        /* USER HEADER */

        .sidebar .sidebar-user-header {
            display: flex;

            align-items: center;

            gap: 10px;
        }


        /* AVATAR */

        .sidebar .sidebar-avatar {
            background:
                linear-gradient(145deg,
                    #d4af37,
                    #f4d06f);

            color: #54101b;

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .40),
                0 6px 18px rgba(212, 175, 55, .20);
        }


        /* USER INFO */

        .sidebar .sidebar-user-info {
            min-width: 0;

            flex: 1;
        }

        .sidebar .sidebar-user-name {
            color: #fff;

            font-size: 12px;

            font-weight: 600;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .sidebar .sidebar-user-role {
            margin-top: 3px;

            color:
                rgba(255, 224, 227, .68);

            font-size: 10px;
        }


        /* =====================================================
   LOGOUT
===================================================== */

        .sidebar .sidebar-logout {
            width: 100%;

            margin-top: 12px;

            padding: 9px 10px;

            border-radius: 9px;

            border:
                1px solid rgba(255, 255, 255, .08);

            background:
                rgba(255, 255, 255, .035);

            color:
                rgba(255, 237, 239, .78);

            font-size: 12px;

            cursor: pointer;

            backdrop-filter: blur(10px);

            -webkit-backdrop-filter: blur(10px);

            transition: all .22s ease;
        }

        .sidebar .sidebar-logout:hover {
            background:
                rgba(212, 175, 55, .09);

            border-color:
                rgba(212, 175, 55, .25);

            color:
                #f4d06f;

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .08);
        }

        main.content {
            position: relative;
        }

        .toast-container {
            position: fixed;
            z-index: 2000;
            top: 18px;
            right: 20px;
            display: grid;
            gap: 10px;
            width: min(390px, calc(100vw - 32px));
            pointer-events: none;
        }

        .toast {
            display: grid;
            grid-template-columns: 24px minmax(0, 1fr) 28px;
            align-items: center;
            gap: 12px;
            padding: 14px 12px 14px 15px;
            color: #263445;
            background: rgba(255, 255, 255, .97);
            border: 1px solid #dbe2ea;
            border-left: 4px solid #a88628;
            border-radius: 9px;
            box-shadow: 0 8px 24px rgba(25, 30, 40, .12);
            pointer-events: auto;
            animation: toast-enter .22s ease-out both;
        }

        .toast--success {
            border-left-color: #56866a;
        }

        .toast--error {
            border-left-color: #b93e48;
        }

        .toast--warning {
            border-left-color: #b88622;
        }

        .toast--info {
            border-left-color: #762735;
        }

        .toast-icon {
            display: grid;
            width: 24px;
            height: 24px;
            place-items: center;
            color: #7c5c18;
        }

        .toast--success .toast-icon {
            color: #3d7653;
        }

        .toast--error .toast-icon {
            color: #ad303d;
        }

        .toast--info .toast-icon {
            color: #762735;
        }

        .toast-icon svg {
            width: 21px;
            height: 21px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .toast-message {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.45;
        }

        .toast-close {
            width: 28px;
            height: 28px;
            padding: 0;
            border: 0;
            border-radius: 5px;
            background: transparent;
            color: #64748b;
            font-size: 21px;
            line-height: 1;
            cursor: pointer;
        }

        .toast-close:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .toast.is-leaving {
            animation: toast-exit .18s ease-in forwards;
        }

        @keyframes toast-enter {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes toast-exit {
            to { opacity: 0; transform: translateY(-6px); }
        }

        .confirm-modal {
            position: fixed;
            z-index: 2100;
            inset: 0;
            display: none;
            place-items: center;
            padding: 20px;
            background: rgba(24, 18, 20, .42);
        }

        .confirm-modal.is-open {
            display: grid;
            animation: modal-fade-in .16s ease-out both;
        }

        .confirm-dialog {
            width: min(420px, 100%);
            padding: 22px;
            border: 1px solid #e2e6eb;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 16px 40px rgba(25, 20, 22, .2);
            animation: modal-scale-in .16s ease-out both;
        }

        .confirm-dialog h2 {
            margin: 0;
            color: #1e293b;
            font-size: 18px;
        }

        .confirm-dialog p {
            margin: 10px 0 22px;
            color: #475569;
            font-size: 14px;
            line-height: 1.55;
        }

        .confirm-actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
        }

        .confirm-actions button {
            min-height: 38px;
            padding: 8px 14px;
            border: 1px solid #d8dee7;
            border-radius: 7px;
            background: #fff;
            color: #334155;
            font: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .confirm-actions button:hover {
            background: #f8fafc;
        }

        .confirm-actions .confirm-delete {
            border-color: #8d2937;
            background: #8d2937;
            color: #fff;
        }

        .confirm-actions .confirm-delete:hover {
            background: #70202c;
        }

        body.modal-open {
            overflow: hidden;
        }

        @keyframes modal-fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modal-scale-in {
            from { opacity: 0; transform: scale(.98); }
            to { opacity: 1; transform: scale(1); }
        }

        .page-skeleton {
            position: fixed;
            z-index: 900;
            inset: 0 0 0 250px;
            display: none;
            overflow: hidden;
            padding: 32px;
            background: #f5f3f2;
        }

        html.js-loading .page-skeleton {
            display: block;
        }

        html.js-loading main.content > :not(.page-skeleton) {
            visibility: hidden;
        }

        .skeleton {
            background: linear-gradient(100deg, #e4e7eb 30%, #f2f4f6 48%, #e4e7eb 66%);
            background-size: 220% 100%;
            animation: skeleton-shimmer 1.25s ease-in-out infinite;
        }

        @keyframes skeleton-shimmer {
            to { background-position-x: -220%; }
        }

        .skeleton-mobile-menu {
            display: none;
            width: 42px;
            height: 42px;
            margin-bottom: 10px;
            border-radius: 7px;
        }

        .skeleton-dashboard-intro {
            margin: 0 0 22px;
        }

        .skeleton-heading {
            width: min(340px, 55%);
            height: 30px;
            border-radius: 5px;
        }

        .skeleton-subheading {
            width: min(500px, 72%);
            height: 15px;
            margin-top: 10px;
            border-radius: 4px;
        }

        .skeleton-dashboard-chart,
        .skeleton-table-card {
            padding: 20px;
            border: 1px solid #e1e5ea;
            border-radius: 9px;
            background: #fff;
        }

        .skeleton-dashboard-chart {
            margin-bottom: 20px;
        }

        .skeleton-title {
            width: 190px;
            height: 19px;
            margin-bottom: 18px;
            border-radius: 4px;
        }

        .skeleton-chart {
            width: 100%;
            height: 260px;
            border-radius: 5px;
        }

        .skeleton-dashboard-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .skeleton-stat {
            padding: 17px;
            border: 1px solid #e1e5ea;
            border-radius: 9px;
            background: white;
        }

        .skeleton-label {
            width: 65%;
            height: 13px;
            margin-bottom: 14px;
            border-radius: 4px;
        }

        .skeleton-number {
            width: 38%;
            height: 27px;
            border-radius: 4px;
        }

        .skeleton-dashboard-tables {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .skeleton-dashboard-tables .skeleton-table-card:first-child {
            grid-column: 1 / -1;
        }

        .skeleton-row {
            height: 15px;
            margin: 16px 0;
            border-radius: 4px;
        }

        .skeleton-list-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
        }

        .skeleton-action {
            width: 140px;
            height: 38px;
            border-radius: 6px;
        }

        .skeleton-filter {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            height: 82px;
            margin-bottom: 20px;
            padding: 16px;
            border: 1px solid #e1e5ea;
            border-radius: 9px;
            background: #fff;
        }

        .skeleton-filter-field {
            width: min(420px, 65%);
            height: 44px;
            border-radius: 5px;
        }

        .skeleton-filter-button {
            width: 90px;
            height: 38px;
            border-radius: 5px;
        }

        .skeleton-table-header,
        .skeleton-table-row {
            display: grid;
            grid-template-columns: repeat(5, minmax(70px, 1fr));
            gap: 18px;
            align-items: center;
            min-width: 520px;
            padding: 14px 8px;
            border-bottom: 1px solid #e8edf2;
        }

        .skeleton-table-header {
            background: #f8fafc;
        }

        .skeleton-cell {
            height: 13px;
            border-radius: 4px;
        }

        .skeleton-table-row:nth-child(odd) .skeleton-cell:nth-child(even) {
            width: 72%;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
        }

        .sidebar .menu {
            display: flex;
            flex: 1 0 auto;
            flex-direction: column;
        }

        .sidebar .sidebar-user {
            margin-top: auto;
        }

        .sidebar .menu-accordion-toggle {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            width: calc(100% - 4px);
            min-height: 45px;
            margin: 4px 2px;
            padding: 10px 13px;
            border: 1px solid rgba(255, 255, 255, .025);
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(255, 255, 255, .035), rgba(255, 255, 255, .012));
            color: rgba(255, 239, 241, .82);
            font: inherit;
            font-size: 13.5px;
            font-weight: 500;
            text-align: left;
            cursor: pointer;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .025);
            transition: all .25s ease;
        }

        .sidebar .menu-accordion-toggle:hover,
        .sidebar .menu-accordion-toggle.is-open {
            color: #fff;
            background: linear-gradient(135deg, rgba(255, 255, 255, .075), rgba(212, 175, 55, .045));
            border-color: rgba(255, 255, 255, .12);
            box-shadow: inset 3px 0 0 #d4af37, inset 0 1px 0 rgba(255, 255, 255, .07), 0 5px 14px rgba(28, 4, 9, .12);
        }

        .sidebar .menu-accordion-toggle:focus-visible {
            outline: 2px solid #f1c75b;
            outline-offset: 2px;
        }

        .sidebar .menu-chevron {
            width: 16px;
            height: 16px;
            margin-left: auto;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            transition: transform .2s ease;
        }

        .sidebar .menu-accordion-toggle.is-open .menu-chevron {
            transform: rotate(180deg);
        }

        .sidebar .menu-submenu {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height .22s ease, opacity .18s ease;
        }

        .sidebar .menu-submenu.is-open {
            max-height: 360px;
            opacity: 1;
        }

        .sidebar .menu-submenu a {
            margin-left: 10px;
        }

        @media (max-width: 900px) {
            .page-skeleton {
                left: 210px;
                padding: 20px;
            }

            .skeleton-dashboard-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {
            .toast-container {
                top: 12px;
                right: 12px;
                left: 12px;
                width: auto;
            }

            .page-skeleton {
                inset: 0;
                padding: 15px;
            }

            .skeleton-mobile-menu {
                display: block;
            }

            .skeleton-dashboard-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .skeleton-dashboard-tables {
                grid-template-columns: 1fr;
            }

            .skeleton-dashboard-tables .skeleton-table-card:first-child {
                grid-column: auto;
            }

            .skeleton-chart {
                height: 190px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .skeleton,
            .toast,
            .toast.is-leaving,
            .confirm-modal.is-open,
            .confirm-dialog,
            .sidebar .menu-chevron,
            .sidebar .menu-submenu,
            .sidebar .menu-accordion-toggle {
                animation-duration: .01ms;
                transition-duration: .01ms;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <x-toast />

    <div class="confirm-modal" id="deleteConfirmModal" aria-hidden="true">
        <section class="confirm-dialog" role="alertdialog" aria-modal="true" aria-labelledby="deleteConfirmTitle" aria-describedby="deleteConfirmMessage">
            <h2 id="deleteConfirmTitle">Konfirmasi penghapusan</h2>
            <p id="deleteConfirmMessage">Data yang sudah dihapus tidak dapat dikembalikan.</p>
            <div class="confirm-actions">
                <button type="button" data-confirm-cancel>Batal</button>
                <button type="button" class="confirm-delete" data-confirm-submit>Hapus</button>
            </div>
        </section>
    </div>

    <div class="layout">

        <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <aside class="sidebar">

            {{-- BRAND --}}
            <div class="brand">
                <div class="brand-title">
                    SIMLOG
                </div>

                <div class="brand-subtitle">
                    Sistem Informasi Inventory<br>
                    Logistik
                </div>
            </div>


            @php
                $isSupportRoute = request()->routeIs(
                    'items.*',
                    'categories.*',
                    'units.*',
                    'suppliers.*',
                    'departments.*'
                );
            @endphp

            <nav class="menu">
                <div class="menu-title">Utama</div>

                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                        </svg>
                    </span>
                    <span>Dashboard</span>
                </a>

                <div class="menu-title">Operasional</div>

                <a href="{{ route('incoming-transactions.index') }}"
                    class="{{ request()->routeIs('incoming-transactions.*') ? 'active' : '' }}">
                    <span class="menu-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 3v12"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <path d="M5 21h14"></path>
                        </svg>
                    </span>
                    <span>Barang Masuk</span>
                </a>

                <a href="{{ route('outgoing-transactions.index') }}"
                    class="{{ request()->routeIs('outgoing-transactions.*') ? 'active' : '' }}">
                    <span class="menu-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 21V9"></path>
                            <polyline points="17 14 12 9 7 14"></polyline>
                            <path d="M5 3h14"></path>
                        </svg>
                    </span>
                    <span>Barang Keluar</span>
                </a>

                <div class="menu-title">Laporan</div>

                <a href="{{ route('reports.stock') }}"
                    class="{{ request()->routeIs('reports.stock') ? 'active' : '' }}">
                    <span class="menu-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 19V5"></path>
                            <path d="M4 19h16"></path>
                            <polyline points="7 15 11 11 14 14 20 8"></polyline>
                        </svg>
                    </span>
                    <span>Laporan Stok</span>
                </a>

                <a href="{{ route('reports.incoming') }}"
                    class="{{ request()->routeIs('reports.incoming') ? 'active' : '' }}">
                    <span class="menu-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M6 2h9l4 4v16H6z"></path>
                            <path d="M14 2v5h5"></path>
                            <path d="M9 13h6"></path>
                            <path d="M9 17h6"></path>
                            <path d="M9 9h2"></path>
                        </svg>
                    </span>
                    <span>Barang Masuk</span>
                </a>

                <a href="{{ route('reports.outgoing') }}"
                    class="{{ request()->routeIs('reports.outgoing') ? 'active' : '' }}">
                    <span class="menu-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M6 2h9l4 4v16H6z"></path>
                            <path d="M14 2v5h5"></path>
                            <path d="M9 13h6"></path>
                            <path d="M9 17h5"></path>
                            <path d="M15 9h1"></path>
                        </svg>
                    </span>
                    <span>Barang Keluar</span>
                </a>

                <div class="menu-title">Data Pendukung</div>
                <button
                    type="button"
                    class="menu-accordion-toggle {{ $isSupportRoute ? 'is-open' : '' }}"
                    data-sidebar-accordion
                    aria-expanded="{{ $isSupportRoute ? 'true' : 'false' }}"
                    aria-controls="supportMenu"
                >
                    <span class="menu-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 5h16"></path>
                            <path d="M4 12h16"></path>
                            <path d="M4 19h16"></path>
                        </svg>
                    </span>
                    <span>Kelola Data</span>
                    <svg class="menu-chevron" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </button>

                <div
                    class="menu-submenu {{ $isSupportRoute ? 'is-open' : '' }}"
                    id="supportMenu"
                    aria-hidden="{{ $isSupportRoute ? 'false' : 'true' }}"
                    @if (!$isSupportRoute) inert @endif
                >
                    <a href="{{ route('items.index') }}" class="{{ request()->routeIs('items.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                <line x1="12" y1="22" x2="12" y2="12"></line>
                            </svg>
                        </span>
                        <span>Barang</span>
                    </a>

                    <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M20.59 13.41 11 3.83V3H4v7h.83l9.58 9.59a2 2 0 0 0 2.83 0l3.35-3.35a2 2 0 0 0 0-2.83Z"></path>
                                <circle cx="7.5" cy="6.5" r="1"></circle>
                            </svg>
                        </span>
                        <span>Kategori</span>
                    </a>

                    <a href="{{ route('units.index') }}" class="{{ request()->routeIs('units.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 4h16v4H4z"></path>
                                <path d="M4 10h16v4H4z"></path>
                                <path d="M4 16h16v4H4z"></path>
                            </svg>
                        </span>
                        <span>Satuan</span>
                    </a>

                    <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="6" width="18" height="12" rx="2"></rect>
                                <path d="M7 10h10"></path>
                                <path d="M8 14h4"></path>
                            </svg>
                        </span>
                        <span>Sumber Dana</span>
                    </a>

                    <a href="{{ route('departments.index') }}" class="{{ request()->routeIs('departments.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                                <path d="M8 8h8"></path>
                                <path d="M8 12h8"></path>
                                <path d="M8 16h5"></path>
                            </svg>
                        </span>
                        <span>Unit / Bidang</span>
                    </a>
                </div>

                @if(auth()->user()->role === 'admin')
                    <div class="menu-title">Administrasi</div>
                    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <span class="menu-icon">
                            <svg viewBox="0 0 24 24">
                                <circle cx="9" cy="8" r="3"></circle>
                                <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"></path>
                                <path d="M16 11c2.2 0 4 1.8 4 4"></path>
                                <path d="M17 5.5a2.5 2.5 0 0 1 0 5"></path>
                            </svg>
                        </span>
                        <span>Manajemen User</span>
                    </a>
                @endif

                <div class="sidebar-user">
                    <div class="sidebar-user-header">
                        <div class="sidebar-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="sidebar-user-info">
                            <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                            <div class="sidebar-user-role">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-logout">Logout</button>
                    </form>
                </div>
            </nav>

        </aside>

        <main class="content">

            <x-page-skeleton />

            <div class="mobile-header">

                <button type="button" class="mobile-menu-button" onclick="toggleSidebar()" aria-label="Buka menu">
                    ☰
                </button>

            </div>

            @yield('content')

        </main>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        document.querySelectorAll('[data-sidebar-accordion]').forEach((button) => {
            const panel = document.getElementById(button.getAttribute('aria-controls'));
            if (!panel) return;

            button.addEventListener('click', () => {
                const isExpanded = button.getAttribute('aria-expanded') !== 'true';
                button.setAttribute('aria-expanded', String(isExpanded));
                button.classList.toggle('is-open', isExpanded);
                panel.classList.toggle('is-open', isExpanded);
                panel.setAttribute('aria-hidden', String(!isExpanded));
                panel.inert = !isExpanded;
            });
        });

        document.querySelectorAll('[data-toast]').forEach((toast) => {
            const dismiss = () => {
                if (toast.classList.contains('is-leaving')) return;
                toast.classList.add('is-leaving');
                window.setTimeout(() => toast.remove(), 200);
            };

            toast.querySelector('[data-toast-close]')?.addEventListener('click', dismiss);
            window.setTimeout(dismiss, 4500);
        });

        const confirmModal = document.getElementById('deleteConfirmModal');
        const confirmMessage = document.getElementById('deleteConfirmMessage');
        const confirmCancel = confirmModal.querySelector('[data-confirm-cancel]');
        const confirmSubmit = confirmModal.querySelector('[data-confirm-submit]');
        let pendingDeleteForm = null;
        let previousFocus = null;

        const closeDeleteConfirm = () => {
            confirmModal.classList.remove('is-open');
            confirmModal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            pendingDeleteForm = null;
            previousFocus?.focus();
        };

        document.addEventListener('submit', (event) => {
            const form = event.target.closest('form[data-confirm-message]');
            if (!form) return;

            event.preventDefault();
            pendingDeleteForm = form;
            previousFocus = document.activeElement;
            confirmMessage.textContent = form.dataset.confirmMessage;
            confirmModal.classList.add('is-open');
            confirmModal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
            confirmCancel.focus();
        });

        confirmCancel.addEventListener('click', closeDeleteConfirm);

        confirmSubmit.addEventListener('click', () => {
            if (!pendingDeleteForm) return;
            HTMLFormElement.prototype.submit.call(pendingDeleteForm);
        });

        confirmModal.addEventListener('click', (event) => {
            if (event.target === confirmModal) closeDeleteConfirm();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && confirmModal.classList.contains('is-open')) {
                closeDeleteConfirm();
            }

            if (event.key === 'Tab' && confirmModal.classList.contains('is-open')) {
                const focusable = confirmModal.querySelectorAll('button:not([disabled])');
                const first = focusable[0];
                const last = focusable[focusable.length - 1];

                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });

        window.simlogConfirmEnabled = true;
    </script>
</body>

</html>