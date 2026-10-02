@extends('backend.layouts.app')
@section('title', 'Dashboard - ' . config('settings.site_name'))

@section('css')
    <style>
        .dashboard-page {
            --dashboard-accent: #6777ef;
            --dashboard-ink: #34395e;
            --dashboard-shadow: 0 8px 24px rgba(52, 57, 94, 0.07);
            --dashboard-shadow-hover: 0 14px 32px rgba(52, 57, 94, 0.12);
        }

        .dashboard-page .card {
            border: 1px solid #edf0f6;
            border-radius: 6px;
            box-shadow: var(--dashboard-shadow);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .dashboard-page .card:hover {
            transform: translateY(-2px);
            border-color: #e3e7f1;
            box-shadow: var(--dashboard-shadow-hover);
        }

        .dashboard-page .card-header {
            min-height: 68px;
        }

        .dashboard-page .card-header h4 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dashboard-ink);
        }

        .dashboard-page .dashboard-heading-icon {
            display: inline-grid;
            place-items: center;
            flex: 0 0 32px;
            width: 32px;
            height: 32px;
            border-radius: 9px;
            color: var(--dashboard-accent);
            background: rgba(103, 119, 239, 0.1);
            font-size: 13px;
        }

        .dashboard-page .dashboard-filter-card {
            border-left: 3px solid var(--dashboard-accent);
        }

        .dashboard-page .dashboard-filter-card .btn-group {
            flex-wrap: wrap;
            gap: 5px;
        }

        .dashboard-page .dashboard-filter-card .btn {
            border-radius: 20px !important;
            padding: 7px 13px !important;
            transition: background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .dashboard-page .dashboard-filter-card .btn-primary {
            box-shadow: 0 4px 10px rgba(103, 119, 239, 0.24);
        }

        .dashboard-page .dashboard-kpi {
            min-height: 136px;
            overflow: hidden;
            border-top: 2px solid rgba(103, 119, 239, 0.16);
        }

        .dashboard-page .dashboard-kpi .card-icon {
            width: 58px;
            height: 58px;
            margin: 16px 12px 12px 16px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            line-height: 1;
            float: left;
            box-shadow: 0 7px 16px rgba(52, 57, 94, 0.12);
        }

        .dashboard-page .dashboard-kpi .card-wrap {
            overflow: hidden;
        }

        .dashboard-page .dashboard-kpi .card-header {
            padding: 23px 12px 5px 0;
        }

        .dashboard-page .dashboard-kpi .card-body {
            padding: 0 12px 12px 0;
            color: var(--dashboard-ink);
            font-size: 23px;
            line-height: 1.2;
        }

        .dashboard-page .dashboard-trend {
            min-height: 24px;
            color: #98a6ad;
            font-size: 11px;
            line-height: 1.4;
        }

        .dashboard-page .progress {
            overflow: hidden;
            border-radius: 99px;
            background: #f0f2f7;
        }

        .dashboard-page .progress-bar {
            border-radius: 99px;
        }

        .dashboard-page .table thead th {
            color: #7c8495;
            background: #fafbfe;
            border-top: 0;
            white-space: nowrap;
            font-size: 11px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .dashboard-page .table tbody tr {
            transition: background-color 0.16s ease;
        }

        .dashboard-page .table tbody tr:hover {
            background-color: #f8f9fe;
        }

        .dashboard-page .dashboard-chart-wrap {
            height: 320px;
        }

        .dashboard-page .dashboard-chart-wrap canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .dashboard-page .dashboard-alert-card .list-group-item {
            padding: 14px 16px;
            border-color: #f0f2f7;
            line-height: 1.45;
        }

        .dashboard-page .dashboard-alert-card .list-group-item small {
            display: inline-block;
            margin-top: 4px;
            color: #98a6ad;
        }

        @media (max-width: 767.98px) {
            .dashboard-page .dashboard-filter-card .card-header {
                align-items: flex-start !important;
                flex-direction: column;
                gap: 12px;
            }

            .dashboard-page .dashboard-filter-card .btn-group {
                width: 100%;
            }

            .dashboard-page .dashboard-filter-card .btn {
                flex: 1 1 auto;
            }

            .dashboard-page .dashboard-chart-wrap {
                height: 260px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="section dashboard-page">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card dashboard-filter-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4><i class="fas fa-calendar-alt dashboard-heading-icon"></i>Filter Periode</h4>
                            <div class="btn-group" role="group">
                                @php
                                    $periods = [
                                        'today' => 'Hari Ini',
                                        '7' => '7 Hari',
                                        '30' => '30 Hari',
                                        'month' => 'Bulan Ini',
                                        '3month' => '3 Bulan',
                                        'year' => 'Tahun Ini',
                                    ];
                                @endphp
                                @foreach ($periods as $key => $label)
                                    <a href="{{ route('backend.home', ['period' => $key]) }}" class="btn btn-sm {{ $period == $key ? 'btn-primary' : 'btn-light' }}">
                                        {{ $label }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($stats as $stat)
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card card-statistic-1 dashboard-kpi">
                            <div class="card-icon bg-{{ $stat['bg'] }}">
                                <i class="{{ $stat['icon'] }}"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ $stat['title'] }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ is_numeric($stat['value']) ? number_format($stat['value']) : $stat['value'] }}
                                </div>
                            </div>
                        </div>
                        @if (!is_null($stat['trend']))
                            <div class="text-small mt-2 dashboard-trend">
                                <span class="{{ $stat['trend'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="fas {{ $stat['trend'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                    {{ abs($stat['trend']) }}%
                                </span>
                                {{ $stat['label'] }}
                            </div>
                        @else
                            <div class="text-small mt-2 dashboard-trend">{{ $stat['label'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-user-plus dashboard-heading-icon"></i>Lead Terbaru</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Tipe</th>
                                            <th>Produk</th>
                                            <th>Status</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentLeads as $lead)
                                            <tr>
                                                <td>{{ $lead['name'] ?? '-' }}</td>
                                                <td>{{ $lead['type'] ?? '-' }}</td>
                                                <td>{{ $lead['product'] ?? '-' }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $lead['status'] == 'new' || $lead['status'] == 0 ? 'warning' : 'success' }}">
                                                        {{ $lead['status'] == 'new' || $lead['status'] == 0 ? 'Baru' : ucfirst($lead['status']) }}
                                                    </span>
                                                </td>
                                                <td>{{ optional($lead['created_at'])->diffForHumans() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">Belum ada lead terbaru</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-chart-pie dashboard-heading-icon"></i>Komposisi Lead</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $inquiryCount = $leadTypeData['values'][0] ?? 0;
                                $testDriveCount = $leadTypeData['values'][1] ?? 0;
                                $consultationCount = $leadTypeData['values'][2] ?? 0;
                                $totalLead = max($inquiryCount + $consultationCount + $testDriveCount, 1);
                            @endphp

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Inquiry</span>
                                    <span>{{ $inquiryCount }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: {{ ($inquiryCount / $totalLead) * 100 }}%"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Test Drive</span>
                                    <span>{{ $testDriveCount }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ ($testDriveCount / $totalLead) * 100 }}%"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Konsultasi</span>
                                    <span>{{ $consultationCount }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: {{ ($consultationCount / $totalLead) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-7 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-car dashboard-heading-icon"></i>Mobil Terpopuler</h4>
                        </div>
                        <div class="card-body">
                            @forelse ($popularProducts as $key => $product)
                                @php
                                    $maxViews = $popularProducts->max('views') ?? 0;
                                    $progress = $maxViews > 0 ? round(($product->views / $maxViews) * 100) : 0;
                                @endphp
                                <div class="media mb-3">
                                    <div class="mr-3">
                                        <div class="avatar avatar-xl">
                                            <img alt="{{ $product->name }}" src="{{ $product->thumb }}">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong>{{ $key + 1 }}. {{ $product->name }}</strong>
                                            <span class="text-muted">{{ number_format($product->views) }} Views</span>
                                        </div>
                                        <div class="progress mt-2" style="height: 8px;">
                                            <div class="progress-bar bg-primary" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Belum ada data produk yang dilihat.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-layer-group dashboard-heading-icon"></i>Jenis Leads</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $leadTypeValues = $leadTypeData['values'] ?? [0, 0, 0];
                                $leadTypeTotal = array_sum($leadTypeValues);
                            @endphp
                            @foreach (['Inquiry' => ['primary', $leadTypeValues[0] ?? 0], 'Test Drive' => ['success', $leadTypeValues[1] ?? 0], 'Konsultasi Gratis' => ['warning', $leadTypeValues[2] ?? 0]] as $label => [$color, $value])
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>{{ $label }}</span>
                                        <strong>{{ $value }}</strong>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $color }}" style="width: {{ $leadTypeTotal > 0 ? ($value / $leadTypeTotal) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-chart-line dashboard-heading-icon"></i>Visitor Analytics: Traffic & Leads</h4>
                        </div>
                        <div class="card-body">
                            <div class="dashboard-chart-wrap">
                                <canvas id="dashboardChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-globe dashboard-heading-icon"></i>Halaman Terbaru</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Pengunjung</th>
                                            <th>Halaman</th>
                                            <th>Perangkat</th>
                                            <th>Browser / OS</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentVisits as $visit)
                                            <tr>
                                                <td><code>{{ substr($visit->visitor_key, 0, 10) }}</code></td>
                                                <td>
                                                    <strong>{{ $visit->page_title ?: $visit->path }}</strong><br>
                                                    <a href="{{ $visit->url ?: url($visit->path) }}" target="_blank" rel="noopener">
                                                        {{ $visit->path }}
                                                    </a>
                                                </td>
                                                <td>{{ ucfirst($visit->device ?: '-') }}</td>
                                                <td>{{ $visit->browser ?: '-' }} / {{ $visit->os ?: '-' }}</td>
                                                <td title="{{ $visit->created_at->format('d/m/Y H:i:s') }}">
                                                    {{ $visit->created_at->diffForHumans() }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">Belum ada kunjungan pada periode ini</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-filter dashboard-heading-icon"></i>Funnel Visitor ke Closed</h4>
                        </div>
                        <div class="card-body">
                            @php $funnelMaximum = max($funnelData[0]['value'] ?? 0, 1); @endphp
                            @foreach ($funnelData as $stage)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>{{ $stage['label'] }}</span>
                                        <strong>{{ number_format($stage['value']) }}</strong>
                                    </div>
                                    <div class="progress" style="height: 9px;">
                                        <div class="progress-bar bg-primary" style="width: {{ min(100, round(($stage['value'] / $funnelMaximum) * 100)) }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-tasks dashboard-heading-icon"></i>Status Lead</h4>
                        </div>
                        <div class="card-body">
                            @foreach (['new' => ['Baru', 'warning'], 'contacted' => ['Contacted', 'info'], 'closed' => ['Closed', 'success']] as $key => [$label, $color])
                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                    <span>{{ $label }}</span>
                                    <span class="badge badge-{{ $color }}">{{ number_format($leadStatusData[$key] ?? 0) }}</span>
                                </div>
                            @endforeach
                            <small class="text-muted d-block mt-2">Status closed tersedia pada data konsultasi; status inquiry dan test drive dipetakan dari status dibaca.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-share-alt dashboard-heading-icon"></i>Sumber Lead</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Sumber</th>
                                            <th class="text-right">Lead</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leadAttribution['sources'] as $source)
                                            <tr>
                                                <td>{{ $source['label'] }}</td>
                                                <td class="text-right">{{ number_format($source['leads']) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-3">Belum ada atribusi sumber untuk periode ini</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-bullhorn dashboard-heading-icon"></i>Kampanye UTM</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Source</th>
                                            <th>Medium</th>
                                            <th>Campaign</th>
                                            <th class="text-right">Lead</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leadAttribution['campaigns'] as $campaign)
                                            <tr>
                                                <td>{{ $campaign['source'] }}</td>
                                                <td>{{ $campaign['medium'] }}</td>
                                                <td>{{ $campaign['campaign'] }}</td>
                                                <td class="text-right">{{ number_format($campaign['leads']) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-3">Belum ada campaign UTM pada periode ini</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-car-side dashboard-heading-icon"></i>Performa Produk</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Views</th>
                                            <th>Lead</th>
                                            <th>Test Drive</th>
                                            <th>Closed</th>
                                            <th>Konversi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($productPerformance as $product)
                                            <tr>
                                                <td>{{ $product['name'] }}</td>
                                                <td>{{ number_format($product['views']) }}</td>
                                                <td>{{ number_format($product['leads']) }}</td>
                                                <td>{{ number_format($product['testdrives']) }}</td>
                                                <td>{{ number_format($product['closed']) }}</td>
                                                <td>{{ number_format($product['conversion_rate'], 1) }}%</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-3">Belum ada data produk pada periode ini</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-window-maximize dashboard-heading-icon"></i>Performa Landing Page V1–V4</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Versi</th>
                                            <th>Path</th>
                                            <th>Visitor</th>
                                            <th>Page Views</th>
                                            <th>Lead</th>
                                            <th>Konversi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($landingPagePerformance as $page)
                                            <tr>
                                                <td>{{ $page['version'] }}</td>
                                                <td><code>{{ $page['path'] }}</code></td>
                                                <td>{{ number_format($page['visitors']) }}</td>
                                                <td>{{ number_format($page['views']) }}</td>
                                                <td>{{ number_format($page['leads']) }}</td>
                                                <td>{{ number_format($page['conversion_rate'], 1) }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                @foreach (['device' => ['Perangkat', 'fa-mobile-alt'], 'browser' => ['Browser', 'fa-window-restore'], 'os' => ['Sistem Operasi', 'fa-desktop'], 'referrer' => ['Referrer', 'fa-link']] as $key => [$label, $icon])
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card h-100">
                            <div class="card-header">
                                <h4><i class="fas {{ $icon }} dashboard-heading-icon"></i>{{ $label }}</h4>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    @forelse ($visitorBreakdown[$key] as $item)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>{{ $item['label'] }}</span><strong>{{ number_format($item['views']) }}</strong>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted">Belum ada data</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card h-100 dashboard-alert-card">
                        <div class="card-header">
                            <h4><i class="fas fa-bell dashboard-heading-icon"></i>Lead Baru</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($newLeadAlerts as $lead)
                                    <li class="list-group-item"><strong>{{ $lead['name'] }}</strong><br><small>{{ $lead['type'] }} · {{ $lead['product'] ?: 'Produk umum' }} · {{ $lead['created_at']->diffForHumans() }}</small></li>
                                @empty
                                    <li class="list-group-item text-muted">Tidak ada lead baru pada periode ini</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card h-100 dashboard-alert-card">
                        <div class="card-header">
                            <h4><i class="fas fa-car dashboard-heading-icon"></i>Test Drive Baru</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($newTestdriveAlerts as $item)
                                    <li class="list-group-item"><strong>{{ $item->name }}</strong><br><small>{{ $item->product }} · {{ $item->created_at->diffForHumans() }}</small></li>
                                @empty
                                    <li class="list-group-item text-muted">Tidak ada test drive baru pada periode ini</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card h-100 dashboard-alert-card">
                        <div class="card-header">
                            <h4><i class="fas fa-hourglass-half dashboard-heading-icon"></i>Promo Segera Berakhir</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($expiringPromos as $promo)
                                    <li class="list-group-item"><strong>{{ $promo->promo }}</strong><br><small>{{ optional($promo->effective_date)->format('d M Y') }}</small></li>
                                @empty
                                    <li class="list-group-item text-muted">Tidak ada promo yang segera berakhir</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card h-100 dashboard-alert-card">
                        <div class="card-header">
                            <h4><i class="fas fa-exclamation-triangle dashboard-heading-icon"></i>Views Tinggi, Lead Rendah</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($lowConversionProducts as $product)
                                    <li class="list-group-item"><strong>{{ $product['name'] }}</strong><br><small>{{ number_format($product['views']) }} views · {{ $product['leads'] }} lead</small></li>
                                @empty
                                    <li class="list-group-item text-muted">Belum ada produk yang memenuhi kondisi alert</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-car dashboard-heading-icon"></i>Test Drive Terbaru</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($latestTestdrives as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $item->name }}</strong><br>
                                            <small>{{ $item->phone ?? '-' }}</small>
                                        </div>
                                        <span class="badge badge-{{ $item->status == 1 ? 'success' : 'warning' }}">
                                            {{ $item->status == 1 ? 'Dibaca' : 'Baru' }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center py-4">Belum ada test drive</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-comments dashboard-heading-icon"></i>Konsultasi Terbaru</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($latestConsultations as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $item->name }}</strong><br>
                                            <small>{{ optional($item->product)->name ?? 'Produk umum' }}</small>
                                        </div>
                                        <span class="badge badge-{{ $item->status == 'read' ? 'success' : 'warning' }}">
                                            {{ $item->status == 'read' ? 'Dibaca' : 'Baru' }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center py-4">Belum ada konsultasi</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('dashboardChart');
            if (!canvas || typeof Chart === 'undefined') {
                return;
            }

            const chartData = @json($chartData ?? ['labels' => [], 'visitors' => [], 'page_views' => []]);

            new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartData.labels || [],
                    datasets: [{
                            label: 'Pengunjung',
                            data: chartData.visitors || [],
                            borderColor: '#6777ef',
                            backgroundColor: 'rgba(103,119,239,0.15)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 3,
                        },
                        {
                            label: 'Page Views',
                            data: chartData.page_views || [],
                            borderColor: '#47c363',
                            backgroundColor: 'rgba(71,195,99,0.10)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 3,
                        },
                        {
                            label: 'Lead',
                            data: chartData.leads || [],
                            borderColor: '#f3a536',
                            backgroundColor: 'rgba(243,165,54,0.10)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 3,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        });
    </script>
@endpush
