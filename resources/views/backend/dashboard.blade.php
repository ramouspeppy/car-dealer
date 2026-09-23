@extends('backend.layouts.app')
@section('title', 'Dashboard - ' . config('settings.site_name'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Filter Periode</h4>
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
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-{{ $stat['bg'] }}">
                                <i class="{{ $stat['icon'] }}"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ $stat['title'] }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($stat['value']) }}
                                </div>
                            </div>
                        </div>
                        <div class="text-small mt-2">
                            <span class="{{ $stat['trend'] >= 0 ? 'text-success' : 'text-danger' }}">
                                <i class="fas {{ $stat['trend'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                {{ abs($stat['trend']) }}%
                            </span>
                            {{ $stat['label'] }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lead Terbaru</h4>
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
                            <h4>Komposisi Lead</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $inquiryCount = App\Models\Contact::whereBetween('created_at', [now()->subDays(29)->startOfDay(), now()])->count();
                                $consultationCount = App\Models\Consultation::whereBetween('created_at', [now()->subDays(29)->startOfDay(), now()])->count();
                                $testDriveCount = App\Models\Testdrive::whereBetween('created_at', [now()->subDays(29)->startOfDay(), now()])->count();
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
                            <h4>Mobil Terpopuler</h4>
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
                            <h4>Jenis Leads</h4>
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
                            <h4>Grafik Visitor & Page Views</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="dashboardChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Test Drive Terbaru</h4>
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
                            <h4>Konsultasi Terbaru</h4>
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
