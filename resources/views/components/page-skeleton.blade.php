@php
    $isDashboard = request()->routeIs('dashboard');
    $isTablePage = request()->routeIs(
        'items.index',
        'categories.index',
        'units.index',
        'suppliers.index',
        'departments.index',
        'incoming-transactions.index',
        'outgoing-transactions.index',
        'users.index',
        'reports.stock',
        'reports.incoming',
        'reports.outgoing'
    );
@endphp

@if ($isDashboard || $isTablePage)
    <div class="page-skeleton" aria-hidden="true">
        <div class="skeleton-mobile-menu skeleton"></div>

        @if ($isDashboard)
            <div class="skeleton-dashboard-intro">
                <div class="skeleton skeleton-heading"></div>
                <div class="skeleton skeleton-subheading"></div>
            </div>

            <div class="skeleton-dashboard-chart">
                <div class="skeleton skeleton-title"></div>
                <div class="skeleton skeleton-chart"></div>
            </div>

            <div class="skeleton-dashboard-stats">
                @foreach (range(1, 4) as $card)
                    <div class="skeleton-stat">
                        <div class="skeleton skeleton-label"></div>
                        <div class="skeleton skeleton-number"></div>
                    </div>
                @endforeach
            </div>

            <div class="skeleton-dashboard-tables">
                @foreach (range(1, 3) as $table)
                    <div class="skeleton-table-card">
                        <div class="skeleton skeleton-title"></div>
                        @foreach (range(1, 4) as $row)
                            <div class="skeleton skeleton-row"></div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <div class="skeleton-list-heading">
                <div class="skeleton skeleton-heading"></div>
                <div class="skeleton skeleton-action"></div>
            </div>

            <div class="skeleton-filter skeleton">
                <div class="skeleton skeleton-filter-field"></div>
                <div class="skeleton skeleton-filter-button"></div>
            </div>

            <div class="skeleton-table-card">
                <div class="skeleton-table-header">
                    @foreach (range(1, 5) as $column)
                        <div class="skeleton skeleton-cell"></div>
                    @endforeach
                </div>
                @foreach (range(1, 6) as $row)
                    <div class="skeleton-table-row">
                        @foreach (range(1, 5) as $column)
                            <div class="skeleton skeleton-cell"></div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif
