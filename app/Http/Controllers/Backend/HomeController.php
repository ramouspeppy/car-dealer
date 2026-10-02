<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Contact;
use App\Models\Promo;
use App\Models\Product;
use App\Models\Testdrive;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $currentInquiries = DB::table('contacts')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->count();
        $currentConsultations = DB::table('consultations')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->count();
        $currentTestdrives = DB::table('testdrives')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->count();
        $currentLeads = $currentInquiries + $currentConsultations + $currentTestdrives;

        $previousVisitors = (clone $previousLogs)->distinct('visitor_key')->count('visitor_key');
        $previousPageViews = (clone $previousLogs)->count();
        $previousInquiries = DB::table('contacts')->whereBetween('created_at', [$previousRange['start'], $previousRange['end']])->count();
        $previousConsultations = DB::table('consultations')->whereBetween('created_at', [$previousRange['start'], $previousRange['end']])->count();
        $previousTestdrives = DB::table('testdrives')->whereBetween('created_at', [$previousRange['start'], $previousRange['end']])->count();
        $previousLeads = $previousInquiries + $previousConsultations + $previousTestdrives;
        $leadVisitorStages = $this->getLeadVisitorStages($currentRange);
        $conversionRate = $currentVisitors > 0 ? round(($leadVisitorStages['lead'] / $currentVisitors) * 100, 1) : 0;

        $newLeadCount = DB::table('consultations')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->where('status', 'new')->count()
            + DB::table('contacts')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->where('status', 0)->count()
            + DB::table('testdrives')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->where('status', 0)->count();
        $contactedLeadCount = DB::table('consultations')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->where('status', 'contacted')->count()
            + DB::table('contacts')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->where('status', 1)->count()
            + DB::table('testdrives')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->where('status', 1)->count();
        $closedLeadCount = DB::table('consultations')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->where('status', 'closed')->count();

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
                'title' => 'Total Lead',
                'value' => $currentLeads,
                'icon' => 'fas fa-handshake',
                'bg' => 'warning',
                'trend' => $this->calculateTrend($currentLeads, $previousLeads),
                'label' => 'vs periode sebelumnya',
            ],
            [
                'title' => 'Konsultasi',
                'value' => $currentConsultations,
                'icon' => 'fas fa-comments',
                'bg' => 'success',
                'trend' => $this->calculateTrend($currentConsultations, $previousConsultations),
                'label' => 'vs periode sebelumnya',
            ],
            [
                'title' => 'Test Drive',
                'value' => $currentTestdrives,
                'icon' => 'fas fa-car',
                'bg' => 'info',
                'trend' => $this->calculateTrend($currentTestdrives, $previousTestdrives),
                'label' => 'vs periode sebelumnya',
            ],
            [
                'title' => 'Konversi',
                'value' => $conversionRate . '%',
                'icon' => 'fas fa-chart-line',
                'bg' => 'danger',
                'trend' => null,
                'label' => 'lead / visitor',
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
                    'status' => $item->getRawOriginal('status') == 0 ? 'new' : 'contacted',
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
                    'status' => $item->getRawOriginal('status') == 1 ? 'contacted' : 'new',
                    'created_at' => $item->created_at,
                ];
            })
        );

        $recentLeads = $recentLeads->sortByDesc('created_at')->take(8)->values();
        $latestTestdrives = Testdrive::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get();
        $latestConsultations = Consultation::with('product')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get();
        $chartData = $this->buildChartData($period, $currentRange['start'], $currentRange['end']);
        $popularProducts = $this->getPopularProducts($currentRange);
        $recentVisits = VisitorLog::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])
            ->latest()
            ->take(15)
            ->get();
        $leadStatusData = [
            'new' => $newLeadCount,
            'contacted' => $contactedLeadCount,
            'closed' => $closedLeadCount,
        ];
        $funnelLeadCount = min($currentVisitors, $leadVisitorStages['lead']);
        $funnelContactedCount = min($funnelLeadCount, $leadVisitorStages['contacted']);
        $funnelClosedCount = min($funnelContactedCount, $leadVisitorStages['closed']);
        $funnelData = [
            ['label' => 'Visitor', 'value' => $currentVisitors],
            ['label' => 'Lead', 'value' => $funnelLeadCount],
            ['label' => 'Contacted', 'value' => $funnelContactedCount],
            ['label' => 'Closed', 'value' => $funnelClosedCount],
        ];
        $leadAttribution = $this->getLeadAttributionData($currentRange);
        $productPerformance = $this->getProductPerformance($currentRange);
        $landingPagePerformance = $this->getLandingPagePerformance($currentRange);
        $visitorBreakdown = $this->getVisitorBreakdown($currentRange);
        $newLeadAlerts = $this->getNewLeadAlerts($currentRange);
        $newTestdriveAlerts = Testdrive::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])
            ->where('status', 0)->latest()->take(5)->get();
        $promoWindowEnd = $currentRange['end']->copy()->addDays(14)->endOfDay();
        $expiringPromos = Promo::where('status', 1)
            ->whereNotNull('effective_date')
            ->whereDate('effective_date', '>=', now()->toDateString())
            ->whereBetween('effective_date', [$currentRange['start'], $promoWindowEnd])
            ->orderBy('effective_date')->take(5)->get();
        $lowConversionProducts = $productPerformance->filter(function ($product) {
            return $product['views'] >= 10 && $product['leads'] <= 1;
        })->sortByDesc('views')->take(5)->values();
        $leadTypeData = [
            'labels' => ['Inquiry', 'Test Drive', 'Konsultasi Gratis'],
            'values' => [$currentInquiries, $currentTestdrives, $currentConsultations],
        ];

        return view('backend.dashboard', compact(
            'stats',
            'recentLeads',
            'latestTestdrives',
            'latestConsultations',
            'period',
            'chartData',
            'popularProducts',
            'leadTypeData',
            'recentVisits',
            'leadStatusData',
            'funnelData',
            'leadAttribution',
            'productPerformance',
            'landingPagePerformance',
            'visitorBreakdown',
            'newLeadAlerts',
            'newTestdriveAlerts',
            'expiringPromos',
            'lowConversionProducts'
        ));
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
            'conversion_rate' => $visitorCount > 0 ? round(($leadCount / $visitorCount) * 100, 1) : 0,
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

        $latestTestdrives = Testdrive::whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get();
        $latestConsultations = Consultation::with('product')->whereBetween('created_at', [$currentRange['start'], $currentRange['end']])->latest()->take(5)->get();

        return response()->json([
            'period' => $period,
            'kpis' => [
                'visitors' => $visitorCount,
                'page_views' => $pageViews,
                'leads' => $leadCount,
                'conversion_rate' => $kpis['conversion_rate'],
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

            $item->name = optional($product)->name ?? 'Produk tidak tersedia';
            $item->thumb = optional($product)->image_url ?? asset('images/no-image.png');

            return $item;
        });
    }

    protected function getLeadAttributionData(array $range)
    {
        $sourceCounts = [];
        $campaignCounts = [];

        foreach (['consultations', 'contacts', 'testdrives'] as $table) {
            $rows = DB::table($table)
                ->whereBetween('created_at', [$range['start'], $range['end']])
                ->get(['source', 'utm_source', 'utm_medium', 'utm_campaign', 'gclid', 'fbclid']);

            foreach ($rows as $row) {
                $source = $this->normalizeLeadSource($row);
                $sourceCounts[$source] = ($sourceCounts[$source] ?? 0) + 1;

                $utmSource = trim((string) $row->utm_source);
                $utmMedium = trim((string) $row->utm_medium);
                $campaign = trim((string) $row->utm_campaign);
                if ($utmSource !== '' || $utmMedium !== '' || $campaign !== '') {
                    $key = implode('|', [$utmSource, $utmMedium, $campaign]);
                    if (!isset($campaignCounts[$key])) {
                        $campaignCounts[$key] = [
                            'source' => $utmSource ?: '-',
                            'medium' => $utmMedium ?: '-',
                            'campaign' => $campaign ?: '(tanpa campaign)',
                            'leads' => 0,
                        ];
                    }
                    $campaignCounts[$key]['leads']++;
                }
            }
        }

        arsort($sourceCounts);
        uasort($campaignCounts, function ($left, $right) {
            return $right['leads'] <=> $left['leads'];
        });

        return [
            'sources' => collect($sourceCounts)->map(function ($count, $label) {
                return ['label' => $label, 'leads' => $count];
            })->values(),
            'campaigns' => collect($campaignCounts)->take(8)->values(),
        ];
    }

    protected function getLeadVisitorStages(array $range)
    {
        $leadKeys = collect();
        $contactedKeys = collect();
        $closedKeys = collect();

        $contacts = DB::table('contacts')->whereBetween('created_at', [$range['start'], $range['end']])->whereNotNull('visitor_key');
        $leadKeys = $leadKeys->merge((clone $contacts)->pluck('visitor_key'));
        $contactedKeys = $contactedKeys->merge((clone $contacts)->where('status', 1)->pluck('visitor_key'));

        $testdrives = DB::table('testdrives')->whereBetween('created_at', [$range['start'], $range['end']])->whereNotNull('visitor_key');
        $leadKeys = $leadKeys->merge((clone $testdrives)->pluck('visitor_key'));
        $contactedKeys = $contactedKeys->merge((clone $testdrives)->where('status', 1)->pluck('visitor_key'));

        $consultations = DB::table('consultations')->whereBetween('created_at', [$range['start'], $range['end']])->whereNotNull('visitor_key');
        $leadKeys = $leadKeys->merge((clone $consultations)->pluck('visitor_key'));
        $contactedKeys = $contactedKeys->merge((clone $consultations)->whereIn('status', ['contacted', 'closed'])->pluck('visitor_key'));
        $closedKeys = $closedKeys->merge((clone $consultations)->where('status', 'closed')->pluck('visitor_key'));

        return [
            'lead' => $leadKeys->unique()->count(),
            'contacted' => $contactedKeys->unique()->count(),
            'closed' => $closedKeys->unique()->count(),
        ];
    }

    protected function normalizeLeadSource($row)
    {
        $source = strtolower(trim((string) ($row->utm_source ?: $row->source)));
        $medium = strtolower(trim((string) $row->utm_medium));

        if (Str::contains($source, ['instagram', 'insta']) || $source === 'ig') {
            return 'Instagram';
        }
        if (Str::contains($source, ['google', 'gads']) || !empty($row->gclid)) {
            return 'Google';
        }
        if (Str::contains($source, ['facebook', 'meta', 'fb']) || !empty($row->fbclid)) {
            return 'Facebook';
        }
        if (Str::contains($source, 'organic') || Str::contains($medium, 'organic')) {
            return 'Organic';
        }
        if ($source === 'direct' || $source === 'website') {
            return 'Direct / Website';
        }
        if ($source === 'landing_page') {
            return 'Landing Page';
        }
        if ($source === '') {
            return 'Unknown / Tidak diketahui';
        }

        return ucfirst($source);
    }

    protected function getProductPerformance(array $range)
    {
        $views = VisitorLog::whereBetween('created_at', [$range['start'], $range['end']])
            ->whereNotNull('product_id')
            ->select('product_id', DB::raw('COUNT(*) as views'))
            ->groupBy('product_id')->pluck('views', 'product_id');

        $consultationLeads = DB::table('consultations')->whereBetween('created_at', [$range['start'], $range['end']])
            ->whereNotNull('product_id')->select('product_id', DB::raw('COUNT(*) as total'))
            ->groupBy('product_id')->pluck('total', 'product_id');

        $contactLeads = DB::table('contacts')->join('products', 'products.name', '=', 'contacts.subject')
            ->whereBetween('contacts.created_at', [$range['start'], $range['end']])
            ->select('products.id as product_id', DB::raw('COUNT(*) as total'))->groupBy('products.id')->pluck('total', 'product_id');

        $testdriveLeads = DB::table('testdrives')->join('products', 'products.slug', '=', 'testdrives.product')
            ->whereBetween('testdrives.created_at', [$range['start'], $range['end']])
            ->select('products.id as product_id', DB::raw('COUNT(*) as total'))->groupBy('products.id')->pluck('total', 'product_id');

        $closedLeads = DB::table('consultations')->whereBetween('created_at', [$range['start'], $range['end']])
            ->where('status', 'closed')->whereNotNull('product_id')
            ->select('product_id', DB::raw('COUNT(*) as total'))->groupBy('product_id')->pluck('total', 'product_id');

        return Product::where('status', 1)->get(['id', 'name', 'slug'])->map(function ($product) use ($views, $consultationLeads, $contactLeads, $testdriveLeads, $closedLeads) {
            $productViews = (int) $views->get($product->id, 0);
            $consultations = (int) $consultationLeads->get($product->id, 0);
            $inquiries = (int) $contactLeads->get($product->id, 0);
            $testdrives = (int) $testdriveLeads->get($product->id, 0);
            $leads = $consultations + $inquiries + $testdrives;

            return [
                'name' => $product->name,
                'slug' => $product->slug,
                'views' => $productViews,
                'leads' => $leads,
                'testdrives' => $testdrives,
                'closed' => (int) $closedLeads->get($product->id, 0),
                'conversion_rate' => $productViews > 0 ? round(($leads / $productViews) * 100, 1) : 0,
            ];
        })->sortByDesc('views')->values();
    }

    protected function getLandingPagePerformance(array $range)
    {
        $pages = [
            'V1' => 'promo-mobil',
            'V2' => 'promo-mobil-v2',
            'V3' => 'promo-mobil-v3',
            'V4' => 'promo-mobil-v4',
        ];
        $leadCounts = array_fill_keys(array_values($pages), 0);

        foreach (['consultations', 'contacts', 'testdrives'] as $table) {
            $landingUrls = DB::table($table)->whereBetween('created_at', [$range['start'], $range['end']])
                ->whereNotNull('landing_url')->pluck('landing_url');

            foreach ($landingUrls as $url) {
                $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
                if (array_key_exists($path, $leadCounts)) {
                    $leadCounts[$path]++;
                }
            }
        }

        return collect($pages)->map(function ($path, $version) use ($range, $leadCounts) {
            $logs = VisitorLog::whereBetween('created_at', [$range['start'], $range['end']])->where('path', $path);
            $views = (clone $logs)->count();
            $visitors = (clone $logs)->distinct('visitor_key')->count('visitor_key');
            $leads = $leadCounts[$path] ?? 0;

            return [
                'version' => $version,
                'path' => '/' . $path,
                'views' => $views,
                'visitors' => $visitors,
                'leads' => $leads,
                'conversion_rate' => $visitors > 0 ? round(($leads / $visitors) * 100, 1) : 0,
            ];
        })->values();
    }

    protected function getVisitorBreakdown(array $range)
    {
        $breakdown = [];

        foreach (['device', 'browser', 'os'] as $column) {
            $breakdown[$column] = VisitorLog::whereBetween('created_at', [$range['start'], $range['end']])
                ->selectRaw("COALESCE(NULLIF({$column}, ''), 'Unknown') as label, COUNT(*) as views, COUNT(DISTINCT visitor_key) as visitors")
                ->groupBy('label')->orderByDesc('views')->limit(8)->get()
                ->map(function ($row) {
                    return ['label' => $row->label, 'views' => (int) $row->views, 'visitors' => (int) $row->visitors];
                });
        }

        $referrerHost = "CASE WHEN referrer IS NULL OR referrer = '' THEN 'Direct' ELSE REPLACE(LOWER(SUBSTRING_INDEX(SUBSTRING_INDEX(referrer, '://', -1), '/', 1)), 'www.', '') END";
        $breakdown['referrer'] = DB::table('visitor_logs')->whereBetween('created_at', [$range['start'], $range['end']])
            ->selectRaw($referrerHost . ' as label, COUNT(*) as views')
            ->groupBy('label')->orderByDesc('views')->limit(8)->get()
            ->map(function ($row) {
                return ['label' => $row->label, 'views' => (int) $row->views];
            });

        return $breakdown;
    }

    protected function getNewLeadAlerts(array $range)
    {
        $alerts = DB::table('consultations')->leftJoin('products', 'products.id', '=', 'consultations.product_id')
            ->whereBetween('consultations.created_at', [$range['start'], $range['end']])
            ->where('consultations.status', 'new')
            ->select('consultations.name', 'products.name as product', 'consultations.created_at')
            ->latest('consultations.created_at')->take(5)->get()
            ->map(function ($item) {
                return ['name' => $item->name, 'product' => $item->product, 'type' => 'Konsultasi', 'created_at' => Carbon::parse($item->created_at)];
            });

        $inquiries = DB::table('contacts')->whereBetween('created_at', [$range['start'], $range['end']])
            ->where('status', 0)->select('name', 'subject as product', 'created_at')
            ->latest()->take(5)->get()->map(function ($item) {
                return ['name' => $item->name, 'product' => $item->product, 'type' => 'Inquiry', 'created_at' => Carbon::parse($item->created_at)];
            });

        return $alerts->merge($inquiries)->sortByDesc('created_at')->take(8)->values();
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
        $labels = $this->generateDateLabels($period, $rangeStart, $rangeEnd);
        if ($period === 'year') {
            $bucketExpression = "DATE_FORMAT(created_at, '%Y-%m')";
        } elseif ($period === 'today') {
            $bucketExpression = "DATE_FORMAT(created_at, '%H:00')";
        } else {
            $bucketExpression = 'DATE(created_at)';
        }
        $visitorRows = VisitorLog::whereBetween('created_at', [$rangeStart, $rangeEnd])
            ->selectRaw($bucketExpression . ' as bucket, COUNT(*) as page_views, COUNT(DISTINCT visitor_key) as visitors')
            ->groupBy('bucket')->get()->keyBy('bucket');
        $leadCountsByBucket = [];

        foreach (['contacts', 'consultations', 'testdrives'] as $table) {
            $rows = DB::table($table)->whereBetween('created_at', [$rangeStart, $rangeEnd])
                ->selectRaw($bucketExpression . ' as bucket, COUNT(*) as total')
                ->groupBy('bucket')->get();

            foreach ($rows as $row) {
                $leadCountsByBucket[$row->bucket] = ($leadCountsByBucket[$row->bucket] ?? 0) + (int) $row->total;
            }
        }

        $visitorCounts = [];
        $pageViewCounts = [];
        $leadCounts = [];

        foreach ($labels as $label) {
            $row = $visitorRows->get($label);
            $visitorCounts[] = $row ? (int) $row->visitors : 0;
            $pageViewCounts[] = $row ? (int) $row->page_views : 0;
            $leadCounts[] = (int) ($leadCountsByBucket[$label] ?? 0);
        }

        return [
            'labels' => $labels,
            'visitors' => $visitorCounts,
            'page_views' => $pageViewCounts,
            'leads' => $leadCounts,
        ];
    }

    protected function generateDateLabels($period, $rangeStart, $rangeEnd)
    {
        $labels = [];
        $cursor = $rangeStart->copy();

        if ($period === 'today') {
            $cursor->startOfDay();
            $lastHour = $rangeEnd->copy()->startOfHour();

            while ($cursor->lte($lastHour)) {
                $labels[] = $cursor->format('H:00');
                $cursor->addHour();
            }

            return $labels;
        }

        if ($period === 'year') {
            $cursor->startOfMonth();
            while ($cursor->lte($rangeEnd)) {
                $labels[] = $cursor->format('Y-m');
                $cursor->addMonth();
            }

            return $labels;
        }

        while ($cursor->lte($rangeEnd)) {
            $labels[] = $cursor->format('Y-m-d');
            $cursor->addDay();
        }

        return $labels;
    }
}
