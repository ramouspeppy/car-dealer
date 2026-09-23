<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Testdrive;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $period = $request->query('period', '30');
        $currentRange = $this->getPeriodRange($period);
        $previousRange = $this->getPreviousRange($period);

        $currentLogs = VisitorLog::whereBetween('created_at', [$currentRange['start'], $currentRange['end']]);
        $previousLogs = VisitorLog::whereBetween('created_at', [$previousRange['start'], $previousRange['end']]);

        $currentVisitors = (clone $currentLogs)->distinct('visitor_key')->count('visitor_key');
        $currentPageViews = (clone $currentLogs)->count();
        $currentInquiries = Contact::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->count();
        $currentConsultations = Consultation::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->count();
        $currentTestdrives = Testdrive::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->count();

        $previousVisitors = (clone $previousLogs)->distinct('visitor_key')->count('visitor_key');
        $previousPageViews = (clone $previousLogs)->count();
        $previousInquiries = Contact::whereBetween('created_at', [$previousRange['start'], $previousRange['end']])->count();
        $previousConsultations = Consultation::whereBetween('created_at', [$previousRange['start'], $previousRange['end']])->count();
        $previousTestdrives = Testdrive::whereBetween('created_at', [$previousRange['start'], $previousRange['end']])->count();

        $stats = [
            [
                'title' => 'Pengunjung',
                'value' => $currentVisitors,
                'icon' => 'fas fa-users',
                'bg' => 'primary',
                'trend' => $this->calculateTrend($currentVisitors, $previousVisitors),
                'label' => 'vs periode sebelumnya',
            ],
            [
                'title' => 'Page Views',
                'value' => $currentPageViews,
                'icon' => 'fas fa-eye',
                'bg' => 'info',
                'trend' => $this->calculateTrend($currentPageViews, $previousPageViews),
                'label' => 'vs periode sebelumnya',
            ],
            [
                'title' => 'Leads',
                'value' => $currentInquiries + $currentConsultations + $currentTestdrives,
                'icon' => 'fas fa-handshake',
                'bg' => 'warning',
                'trend' => $this->calculateTrend($currentInquiries + $currentConsultations + $currentTestdrives, $previousInquiries + $previousConsultations + $previousTestdrives),
                'label' => 'vs periode sebelumnya',
            ],
            [
                'title' => 'Test Drive',
                'value' => $currentTestdrives,
                'icon' => 'fas fa-car',
                'bg' => 'success',
                'trend' => $this->calculateTrend($currentTestdrives, $previousTestdrives),
                'label' => 'vs periode sebelumnya',
            ],
        ];

        $recentLeads = collect();
        $recentLeads = $recentLeads->merge(
            Contact::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get()->map(function ($item) {
                return [
                    'name' => $item->name,
                    'type' => 'Inquiry',
                    'product' => null,
                    'city' => null,
                    'budget' => null,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                ];
            })
        );

        $recentLeads = $recentLeads->merge(
            Consultation::with('product')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get()->map(function ($item) {
                return [
                    'name' => $item->name,
                    'type' => 'Konsultasi Gratis',
                    'product' => optional($item->product)->name,
                    'city' => $item->city,
                    'budget' => $item->budget,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                ];
            })
        );

        $recentLeads = $recentLeads->merge(
            Testdrive::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get()->map(function ($item) {
                return [
                    'name' => $item->name,
                    'type' => 'Test Drive',
                    'product' => $item->product,
                    'city' => null,
                    'budget' => null,
                    'status' => $item->status == 1 ? 'read' : 'new',
                    'created_at' => $item->created_at,
                ];
            })
        );

        $recentLeads = $recentLeads->sortByDesc('created_at')->take(8)->values();
        $latestTestdrives = Testdrive::latest()->take(5)->get();
        $latestConsultations = Consultation::with('product')->latest()->take(5)->get();
        $chartData = $this->buildChartData($period, $currentRange['start'], $currentRange['end']);
        $popularProducts = $this->getPopularProducts($currentRange);
        $leadTypeData = [
            'labels' => ['Inquiry', 'Test Drive', 'Konsultasi Gratis'],
            'values' => [$currentInquiries, $currentTestdrives, $currentConsultations],
        ];

        return view('backend.dashboard', compact('stats', 'recentLeads', 'latestTestdrives', 'latestConsultations', 'period', 'chartData', 'popularProducts', 'leadTypeData'));
    }

    public function stats(Request $request)
    {
        $period = $request->query('period', '30');
        $currentRange = $this->getPeriodRange($period);
        $previousRange = $this->getPreviousRange($period);

        $currentLogs = VisitorLog::whereBetween('created_at', [$currentRange['start'], $currentRange['end']]);
        $previousLogs = VisitorLog::whereBetween('created_at', [$previousRange['start'], $previousRange['end']]);

        $visitorCount = (clone $currentLogs)->distinct('visitor_key')->count('visitor_key');
        $pageViews = (clone $currentLogs)->count();

        $currentInquiries = Contact::whereBetween('created_at', [$currentRange['start'], $currentRange['end']]);
        $currentConsultations = Consultation::whereBetween('created_at', [$currentRange['start'], $currentRange['end']]);
        $currentTestdrives = Testdrive::whereBetween('created_at', [$currentRange['start'], $currentRange['end']]);

        $leadCount = $currentInquiries->count() + $currentConsultations->count() + $currentTestdrives->count();

        $kpis = [
            'visitors' => $visitorCount,
            'page_views' => $pageViews,
            'leads' => $leadCount,
            'test_drive' => $currentTestdrives->count(),
            'consultation' => $currentConsultations->count(),
        ];

        $previousVisitors = (clone $previousLogs)->distinct('visitor_key')->count('visitor_key');
        $previousPageViews = (clone $previousLogs)->count();
        $previousLeads = $this->leadCountForRange($previousRange);
        $previousTestdrives = Testdrive::whereBetween('created_at', [$previousRange['start'], $previousRange['end']])->count();
        $previousConsultations = Consultation::whereBetween('created_at', [$previousRange['start'], $previousRange['end']])->count();
        $previousInquiries = Contact::whereBetween('created_at', [$previousRange['start'], $previousRange['end']])->count();

        $chartData = $this->buildChartData($period, $currentRange['start'], $currentRange['end']);

        $popularProducts = $this->getPopularProducts($currentRange);

        $maxViews = $popularProducts->max('views') ?? 0;
        $popularProducts->each(function ($product) use ($maxViews) {
            $product->progress = $maxViews > 0 ? round(($product->views / $maxViews) * 100) : 0;
        });

        $leadTypes = [
            'labels' => ['Inquiry', 'Test Drive', 'Konsultasi Gratis'],
            'values' => [
                $currentInquiries->count(),
                $currentTestdrives->count(),
                $currentConsultations->count(),
            ],
        ];

        $recentLeads = collect();
        $recentLeads = $recentLeads->merge(
            Contact::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get()->map(function ($item) {
                return [
                    'name' => $item->name,
                    'type' => 'Inquiry',
                    'product' => null,
                    'city' => null,
                    'budget' => null,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                ];
            })
        );

        $recentLeads = $recentLeads->merge(
            Consultation::with('product')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get()->map(function ($item) {
                return [
                    'name' => $item->name,
                    'type' => 'Konsultasi Gratis',
                    'product' => optional($item->product)->name,
                    'city' => $item->city,
                    'budget' => $item->budget,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                ];
            })
        );

        $recentLeads = $recentLeads->merge(
            Testdrive::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get()->map(function ($item) {
                return [
                    'name' => $item->name,
                    'type' => 'Test Drive',
                    'product' => $item->product,
                    'city' => null,
                    'budget' => null,
                    'status' => $item->status == 1 ? 'read' : 'new',
                    'created_at' => $item->created_at,
                ];
            })
        );

        $recentLeads = $recentLeads->sortByDesc('created_at')->take(8)->values();

        $latestTestdrives = Testdrive::latest()->take(5)->get();
        $latestConsultations = Consultation::with('product')->latest()->take(5)->get();

        return response()->json([
            'period' => $period,
            'kpis' => [
                'visitors' => $visitorCount,
                'page_views' => $pageViews,
                'leads' => $leadCount,
                'test_drive' => $currentTestdrives->count(),
                'consultation' => $currentConsultations->count(),
                'trends' => [
                    'visitors' => $this->calculateTrend($visitorCount, $previousVisitors),
                    'page_views' => $this->calculateTrend($pageViews, $previousPageViews),
                    'leads' => $this->calculateTrend($leadCount, $previousLeads),
                    'test_drive' => $this->calculateTrend($currentTestdrives->count(), $previousTestdrives),
                    'consultation' => $this->calculateTrend($currentConsultations->count(), $previousConsultations),
                ],
            ],
            'chart' => $chartData,
            'popular_products' => $popularProducts,
            'lead_types' => $leadTypes,
            'recent_leads' => $recentLeads,
            'latest_testdrives' => $latestTestdrives,
            'latest_consultations' => $latestConsultations,
        ]);
    }

    protected function getPopularProducts(array $range)
    {
        $popularProducts = VisitorLog::with('product')->whereBetween('created_at', [$range['start'], $range['end']])
            ->whereNotNull('product_id')
            ->select('product_id', DB::raw('COUNT(*) as views'))
            ->groupBy('product_id')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        return $popularProducts->map(function ($item) {
            $product = $item->product;
            $productViews = $product ? visits($product)->count() : 0;

            $item->name = optional($product)->name ?? 'Produk tidak tersedia';
            $item->thumb = optional($product)->image_url ?? asset('images/no-image.png');
            $item->library_views = $productViews;

            return $item;
        });
    }

    protected function calculateTrend($current, $previous)
    {
        if ($previous <= 0) {
            return 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    protected function leadCountForRange(array $range)
    {
        return Contact::whereBetween('created_at', [$range['start'], $range['end']])->count()
            + Consultation::whereBetween('created_at', [$range['start'], $range['end']])->count()
            + Testdrive::whereBetween('created_at', [$range['start'], $range['end']])->count();
    }

    protected function getPeriodRange($period)
    {
        $end = now();

        switch ($period) {
            case 'today':
                $start = now()->startOfDay();
                break;
            case '7':
                $start = now()->subDays(6)->startOfDay();
                break;
            case '30':
            default:
                $start = now()->subDays(29)->startOfDay();
                break;
            case 'month':
                $start = now()->startOfMonth();
                break;
            case '3month':
                $start = now()->subMonths(2)->startOfMonth();
                break;
            case 'year':
                $start = now()->startOfYear();
                break;
        }

        return ['start' => $start, 'end' => $end];
    }

    protected function getPreviousRange($period)
    {
        $current = $this->getPeriodRange($period);
        $start = $current['start'];
        $end = $current['end'];

        switch ($period) {
            case 'today':
                $previousStart = $start->copy()->subDay()->startOfDay();
                $previousEnd = $start->copy()->subSecond();
                break;
            case '7':
                $previousStart = $start->copy()->subDays(7)->startOfDay();
                $previousEnd = $start->copy()->subSecond();
                break;
            case '30':
            default:
                $previousStart = $start->copy()->subDays(30)->startOfDay();
                $previousEnd = $start->copy()->subSecond();
                break;
            case 'month':
                $previousStart = $start->copy()->subMonth()->startOfMonth();
                $previousEnd = $start->copy()->subDay()->endOfDay();
                break;
            case '3month':
                $previousStart = $start->copy()->subMonths(3)->startOfMonth();
                $previousEnd = $start->copy()->subDay()->endOfDay();
                break;
            case 'year':
                $previousStart = $start->copy()->subYear()->startOfYear();
                $previousEnd = $start->copy()->subDay()->endOfDay();
                break;
        }

        return ['start' => $previousStart, 'end' => $previousEnd];
    }

    protected function buildChartData($period, $rangeStart, $rangeEnd)
    {
        $labels = [];
        $visitorCounts = [];
        $pageViewCounts = [];

        $query = VisitorLog::whereBetween('created_at', [$rangeStart, $rangeEnd])->selectRaw('DATE(created_at) as date, COUNT(*) as page_views, COUNT(DISTINCT visitor_key) as visitors')->groupBy('date')->orderBy('date');

        if ($period === 'year') {
            $query = VisitorLog::whereBetween('created_at', [$rangeStart, $rangeEnd])->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as date, COUNT(*) as page_views, COUNT(DISTINCT visitor_key) as visitors')->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))->orderBy('date');
        }

        $rows = $query->get();

        if ($period === 'year') {
            $labels = $rows->pluck('date')->all();
            $visitorCounts = $rows->pluck('visitors')->all();
            $pageViewCounts = $rows->pluck('page_views')->all();
        } else {
            $dateRange = $this->generateDateLabels($period, $rangeStart, $rangeEnd);
            $labels = $dateRange;
            $map = $rows->keyBy('date');

            foreach ($dateRange as $label) {
                $dateKey = Carbon::parse($label)->format('Y-m-d');
                $row = $map->get($dateKey, null);
                $visitorCounts[] = $row ? (int) $row->visitors : 0;
                $pageViewCounts[] = $row ? (int) $row->page_views : 0;
            }
        }

        return [
            'labels' => $labels,
            'visitors' => $visitorCounts,
            'page_views' => $pageViewCounts,
        ];
    }

    protected function generateDateLabels($period, $rangeStart, $rangeEnd)
    {
        $labels = [];
        $cursor = $rangeStart->copy();

        while ($cursor->lte($rangeEnd)) {
            if ($period === 'today') {
                $labels[] = $cursor->format('H:00');
            } else {
                $labels[] = $cursor->format('Y-m-d');
            }

            $cursor->addDay();
        }

        return $labels;
    }
}
