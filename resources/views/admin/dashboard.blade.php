<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Reutiliz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="antialiased">
    <div x-data="{ mobileMenuOpen: false }">
        <x-header />
        <!-- Main Content -->
        <main class="py-8">
            <div class="container mx-auto px-4">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex items-center mb-4 mt-8">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-tachometer-alt text-blue-500 mr-2"></i>
                            Tableau de bord administrateur
                        </h2>
                    </div>
                    <!-- Dashboard Widgets Example -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                            <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">{{ $usersCount ?? '...' }}</div>
                                <div class="text-xs text-gray-500">Utilisateurs inscrits</div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                            <div class="bg-green-100 text-green-600 rounded-full p-3">
                                <i class="fas fa-bullhorn fa-lg"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">{{ $annoncesCount ?? '...' }}</div>
                                <div class="text-xs text-gray-500">Annonces publiées</div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                            <div class="bg-yellow-100 text-yellow-600 rounded-full p-3">
                                <i class="fas fa-comment fa-lg"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">{{ $commentsCount ?? '...' }}</div>
                                <div class="text-xs text-gray-500">Comments</div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                            <div class="bg-red-100 text-red-600 rounded-full p-3">
                                <i class="fas fa-flag fa-lg"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">{{ $reportsCount ?? '...' }}</div>
                                <div class="text-xs text-gray-500">Signalements</div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow p-2 overflow-x-auto">
                            <h3 class="text-sm font-semibold mb-1 flex items-center"><i class="fas fa-users text-blue-400 mr-2"></i>Utilisateurs inscrits</h3>
                            <div style="min-width: 300px; max-width: 100%;">
                                <canvas id="usersChart" height="120"></canvas>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-2 overflow-x-auto">
                            <h3 class="text-sm font-semibold mb-1 flex items-center"><i class="fas fa-flag text-red-400 mr-2"></i>Signalements</h3>
                            <div style="min-width: 300px; max-width: 100%;">
                                <canvas id="reportsChart" height="120"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow p-2 overflow-x-auto">
                            <h3 class="text-base font-semibold mb-2 flex items-center"><i class="fas fa-bullhorn text-green-400 mr-2"></i>Annonces publiées</h3>
                            <div style="min-width: 350px; max-width: 100%;">
                                <canvas id="itemsChart" height="160"></canvas>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-2 overflow-x-auto">
                            <h3 class="text-base font-semibold mb-2 flex items-center"><i class="fas fa-comment text-yellow-400 mr-2"></i>Comments</h3>
                            <div style="min-width: 350px; max-width: 100%;">
                                <canvas id="commentsChart" height="160"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Annonces Section -->
                    <div class="bg-white rounded-xl shadow p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center"><i class="fas fa-bullhorn text-green-400 mr-2"></i>Dernières annonces publiées</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentAnnonces as $annonce)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $annonce->title }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $annonce->user->name ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $annonce->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="px-4 py-2 text-gray-500">Aucune annonce récente.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Comments Section -->
                    <div class="bg-white rounded-xl shadow p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center"><i class="fas fa-comments text-blue-400 mr-2"></i>Derniers commentaires</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Annonce</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentComments as $comment)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $comment->item->title ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $comment->user->name ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ Str::limit($comment->content, 50) }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">
                                                {{ $comment->created_at ? (\Carbon\Carbon::parse($comment->created_at)->format('d/m/Y H:i')) : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-4 py-2 text-gray-500">Aucun commentaire récent.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                    <!-- Recent Users Section -->
                    <div class="bg-white rounded-xl shadow p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center"><i class="fas fa-users text-blue-400 mr-2"></i>Nouveaux utilisateurs</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentUsers as $user)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $user->name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $user->email }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="px-4 py-2 text-gray-500">Aucun nouvel utilisateur.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Reports Section -->
                    <div class="bg-white rounded-xl shadow p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center"><i class="fas fa-flag text-red-400 mr-2"></i>Derniers signalements</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Annonce</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raison</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php $recentReports = \App\Models\Report::with(['user', 'item'])->orderBy('date', 'desc')->take(5)->get(); @endphp
                                    @forelse($recentReports as $report)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $report->date ? \Carbon\Carbon::parse($report->date)->format('d/m/Y H:i') : '' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $report->user->name ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $report->item->title ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $report->reason }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-4 py-2 text-gray-500">Aucun signalement récent.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Footer -->
        
<x-footer/>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Helper to format chart data
    function prepareChartData(data, labelKey, valueKey) {
        return {
            labels: data.map(row => row[labelKey]),
            data: data.map(row => row[valueKey])
        };
    }

    // Users Chart Data
    const usersByDay = @json($usersByDay);
    const usersByMonth = @json($usersByMonth);
    const usersByYear = @json($usersByYear);
    // Items Chart Data
    const itemsByDay = @json($itemsByDay);
    const itemsByMonth = @json($itemsByMonth);
    const itemsByYear = @json($itemsByYear);
    // comments Chart Data
    const commentsByDay = @json($commentsByDay);
    const commentsByMonth = @json($commentsByMonth);
    const commentsByYear = @json($commentsByYear);
    // Reports Chart Data
    const reportsByDay = @json($reportsByDay);
    const reportsByMonth = @json($reportsByMonth);
    const reportsByYear = @json($reportsByYear);

    // Modern Chart.js config for each chart
    function createModernChart(ctx, dataset, title, colors) {
        // Create gradient for the main dataset
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, colors.gradientFrom);
        gradient.addColorStop(1, colors.gradientTo);

        // Show all labels (no slicing)
        const labels = dataset.labels;

        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Par jour',
                        data: dataset.data,
                        borderColor: colors.line,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.5,
                        pointRadius: 5,
                        pointBackgroundColor: colors.line,
                        pointBorderWidth: 2,
                        pointHoverRadius: 7,
                        borderWidth: 3,
                        segment: {
                            borderCapStyle: 'round',
                        },
                        shadowOffsetX: 0,
                        shadowOffsetY: 4,
                        shadowBlur: 10,
                        shadowColor: colors.shadow,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: false,
                        text: title
                    },
                    legend: {
                        display: true,
                        labels: {
                            color: '#222',
                            font: { size: 13, weight: 'bold' },
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#222',
                        bodyColor: '#222',
                        borderColor: colors.line,
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                    }
                },
                layout: {
                    padding: 16
                },
                scales: {
                    x: {
                        display: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#888',
                            font: { size: 12 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            borderDash: [4, 4]
                        },
                        ticks: {
                            color: '#888',
                            font: { size: 12 }
                        }
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                }
            },
            plugins: [{
                // Drop shadow plugin for main line
                beforeDraw: chart => {
                    const ctx = chart.ctx;
                    ctx.save();
                    chart.data.datasets.forEach((dataset, i) => {
                        if (i === 0) {
                            ctx.shadowColor = colors.shadow;
                            ctx.shadowBlur = 10;
                            ctx.shadowOffsetY = 4;
                        } else {
                            ctx.shadowColor = 'rgba(0,0,0,0)';
                            ctx.shadowBlur = 0;
                            ctx.shadowOffsetY = 0;
                        }
                    });
                },
                afterDraw: chart => {
                    chart.ctx.restore();
                }
            }]
        });
    }

    // Prepare data for each chart
    const usersDay = prepareChartData(usersByDay, 'date', 'count');
    const itemsDay = prepareChartData(itemsByDay, 'date', 'count');
    const commentsDay = prepareChartData(commentsByDay, 'date', 'count');
    const reportsDay = prepareChartData(reportsByDay, 'date', 'count');

    // Render modern charts (only 'par jour')
    createModernChart(
        document.getElementById('usersChart').getContext('2d'),
        usersDay,
        'Utilisateurs inscrits',
        {
            line: '#3b82f6',
            gradientFrom: 'rgba(59,130,246,0.3)',
            gradientTo: 'rgba(59,130,246,0.05)',
            shadow: 'rgba(59,130,246,0.15)'
        }
    );
    createModernChart(
        document.getElementById('itemsChart').getContext('2d'),
        itemsDay,
        'Annonces publiées',
        {
            line: '#10b981',
            gradientFrom: 'rgba(16,185,129,0.3)',
            gradientTo: 'rgba(16,185,129,0.05)',
            shadow: 'rgba(16,185,129,0.15)'
        }
    );
    createModernChart(
        document.getElementById('commentsChart').getContext('2d'),
        commentsDay,
        'Commentaires',
        {
            line: '#f59e42',
            gradientFrom: 'rgba(245,158,66,0.3)',
            gradientTo: 'rgba(245,158,66,0.05)',
            shadow: 'rgba(245,158,66,0.15)'
        }
    );
    createModernChart(
        document.getElementById('reportsChart').getContext('2d'),
        reportsDay,
        'Signalements',
        {
            line: '#ef4444',
            gradientFrom: 'rgba(239,68,68,0.3)',
            gradientTo: 'rgba(239,68,68,0.05)',
            shadow: 'rgba(239,68,68,0.15)'
        }
    );
</script>
