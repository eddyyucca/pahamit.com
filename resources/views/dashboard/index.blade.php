@extends('dashboard.layout', [
    'title' => 'Overview Dashboard',
    'description' => 'Ringkasan performa Pahamit: pengunjung, post view, top berita, dan aktivitas terbaru.',
])

@php
    $mixTotal = max(1, array_sum($postMix));
    $beritaPct = round(($postMix['berita'] / $mixTotal) * 100);
    $tutorialPct = round(($postMix['tutorial'] / $mixTotal) * 100);
    $jualanPct = 100 - $beritaPct - $tutorialPct;

    $visitArr = collect($visitChart)->toArray();
    $postViewArr = collect($postViewChart)->toArray();
    $sourceArr = collect($sourceBreakdown)->toArray();

    $chartLabels = json_encode(array_column($visitArr, 'label'));
    $chartVisits = json_encode(array_column($visitArr, 'total'));
    $chartViews = json_encode(array_column($postViewArr, 'total'));
    $sourceLabels = json_encode(array_column($sourceArr, 'label'));
    $sourceTotals = json_encode(array_column($sourceArr, 'total'));
@endphp

@section('content')
<div class="stats-grid" style="margin-bottom:20px;">
    @foreach ($stats as $stat)
        @php
            $toneMap = ['blue' => 'blue', 'green' => 'green', 'amber' => 'amber', 'red' => 'rose', 'gray' => 'gray'];
            $tone = $toneMap[$stat['tone']] ?? 'blue';
        @endphp
        <div class="stat-card {{ $tone }}">
            <div class="stat-top">
                <div>
                    <div class="stat-label">{{ $stat['label'] }}</div>
                    <div class="stat-value">{{ number_format($stat['value']) }}</div>
                    <div class="stat-trend {{ in_array($stat['tone'], ['green', 'blue']) ? 'up' : 'flat' }}">
                        @if (in_array($stat['tone'], ['green', 'blue']))
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Data live 7 hari
                        @else
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            Total konten
                        @endif
                    </div>
                </div>
                <div class="stat-icon {{ $tone }}">
                    @if ($stat['icon'] === 'visits')
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    @elseif ($stat['icon'] === 'news')
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 5h16M4 10h16M4 15h10M4 20h7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    @elseif ($stat['icon'] === 'guide')
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M8 4h12v16H8a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4Zm0 0v16M12 8h4M12 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    @else
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4ZM3 6h18M16 10a4 4 0 0 1-8 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="grid-2" style="margin-bottom:20px;">
    <div class="card panel">
        <div class="panel-head">
            <div>
                <h2>Pengunjung dan View Konten</h2>
                <p>Pengunjung homepage dibandingkan dengan view unik artikel per hari.</p>
            </div>
            <div style="display:flex;gap:14px;align-items:center;font-size:.75rem;font-weight:700;color:var(--text3);">
                <span style="display:flex;align-items:center;gap:5px;"><span style="width:10px;height:3px;border-radius:2px;background:#4F46E5;display:inline-block;"></span>Pengunjung</span>
                <span style="display:flex;align-items:center;gap:5px;"><span style="width:10px;height:3px;border-radius:2px;background:#06B6D4;display:inline-block;"></span>Post view</span>
            </div>
        </div>
        <div class="chart-wrap" style="height:220px;">
            <canvas id="visitorsChart"></canvas>
        </div>
    </div>

    <div class="card panel">
        <div class="panel-head">
            <div>
                <h2>Komposisi Konten</h2>
                <p>Distribusi berita, tutorial, dan toko.</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:28px;flex-wrap:wrap;">
            <div style="position:relative;width:140px;height:140px;flex-shrink:0;min-width:140px;">
                <canvas id="contentDonut" style="width:140px!important;height:140px!important;"></canvas>
                <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
                    <div style="font-size:1.4rem;font-weight:800;">{{ $mixTotal }}</div>
                    <div style="font-size:.7rem;color:var(--text3);font-weight:600;">Total</div>
                </div>
            </div>
            <div style="display:grid;gap:12px;flex:1;">
                @foreach ([['Berita', $postMix['berita'], $beritaPct, '#4F46E5'], ['Tutorial', $postMix['tutorial'], $tutorialPct, '#10B981'], ['Jualan', $postMix['jualan'], $jualanPct, '#F59E0B']] as [$name, $count, $pct, $color])
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                        <div style="display:flex;align-items:center;gap:8px;font-size:.83rem;font-weight:600;color:var(--text2);">
                            <span style="width:10px;height:10px;border-radius:3px;background:{{ $color }};flex-shrink:0;display:inline-block;"></span>
                            {{ $name }}
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:80px;height:5px;border-radius:3px;background:var(--border);overflow:hidden;">
                                <div style="height:100%;width:{{ $pct }}%;background:{{ $color }};border-radius:3px;"></div>
                            </div>
                            <strong style="font-size:.83rem;min-width:28px;text-align:right;">{{ $count }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="grid-2" style="margin-bottom:20px;">
    <div class="card panel">
        <div class="panel-head">
            <div>
                <h2>Top Berita</h2>
                <p>Berita paling banyak dibaca berdasarkan view unik.</p>
            </div>
            <a class="btn btn-soft btn-sm" href="{{ route('dashboard.posts.index', 'berita') }}">Daftar</a>
        </div>
        <div class="top-list">
            @forelse ($topPosts as $item)
                @php
                    $rankClass = match($loop->iteration) { 1 => 'gold', 2 => 'silver', 3 => 'bronze', default => '' };
                @endphp
                <div class="top-item">
                    <div class="rank-badge {{ $rankClass }}">{{ $loop->iteration }}</div>
                    <div style="min-width:0;flex:1;">
                        <div class="top-title">{{ Str::limit($item->title, 55) }}</div>
                        <div class="top-meta">{{ $item->category ?? 'Tanpa kategori' }} · {{ number_format($item->views_7d) }} view 7 hari</div>
                    </div>
                    <div class="top-views">{{ number_format($item->views_count) }} total</div>
                </div>
            @empty
                <div style="padding:24px;text-align:center;color:var(--text3);font-size:.88rem;">Belum ada berita untuk ditampilkan.</div>
            @endforelse
        </div>
    </div>

    <div style="display:grid;gap:16px;align-content:start;">
        <div class="card panel">
            <div class="panel-head">
                <div>
                    <h2>Aksi Cepat</h2>
                    <p>Buat konten baru sekarang.</p>
                </div>
            </div>
            <div class="qa-list">
                <a class="qa-item" href="{{ route('dashboard.posts.create', 'berita') }}"><div class="qa-icon" style="background:var(--brand-soft);color:var(--brand);">+</div>Tulis Berita Baru</a>
                <a class="qa-item" href="{{ route('dashboard.posts.create', 'tutorial') }}"><div class="qa-icon" style="background:var(--green-soft);color:var(--green);">+</div>Buat Tutorial Baru</a>
                <a class="qa-item" href="{{ route('dashboard.posts.create', 'jualan') }}"><div class="qa-icon" style="background:rgba(245,158,11,.12);color:var(--amber);">+</div>Tambah Produk / Jasa</a>
                <a class="qa-item" href="{{ route('dashboard.ai.index') }}"><div class="qa-icon" style="background:var(--rose-soft);color:var(--rose);">AI</div>Diskusi Dengan AI Agent</a>
            </div>
        </div>

        <div class="card panel">
            <div class="panel-head">
                <div>
                    <h2>Sumber View</h2>
                    <p>Pengelompokan dari referer post view 7 hari.</p>
                </div>
            </div>
            <div class="chart-wrap" style="height:150px;">
                <canvas id="sourceBar"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card panel">
    <div class="panel-head">
        <div>
            <h2>Postingan Terbaru</h2>
            <p>Konten terakhir yang ditambahkan.</p>
        </div>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Diperbarui</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestPosts as $item)
                    <tr>
                        <td class="title-cell">{{ Str::limit($item->title, 60) }}</td>
                        <td><span class="badge {{ ['berita' => 'blue', 'tutorial' => 'green', 'jualan' => 'amber'][$item->type] ?? 'gray' }}">{{ ucfirst($item->type) }}</span></td>
                        <td><span class="badge {{ $item->status === 'published' ? 'green' : ($item->status === 'review' ? 'amber' : 'rose') }}">{{ ucfirst($item->status) }}</span></td>
                        <td class="muted">{{ number_format($item->views_count) }}</td>
                        <td class="muted">{{ $item->updated_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--text3);">Belum ada postingan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
(function () {
    const isDark = () => document.documentElement.getAttribute('data-theme') === 'dark';
    const c = {
        brand: '#4F46E5',
        accent: '#06B6D4',
        green: '#10B981',
        amber: '#F59E0B',
        rose: '#F43F5E',
        grid: () => isDark() ? 'rgba(255,255,255,.07)' : 'rgba(15,23,42,.06)',
        text: () => isDark() ? '#64748B' : '#94A3B8',
        bg: () => isDark() ? '#111827' : '#ffffff',
    };

    Chart.defaults.font.family = "'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif";
    Chart.defaults.font.size = 12;

    const visitCtx = document.getElementById('visitorsChart').getContext('2d');
    const gradBlue = visitCtx.createLinearGradient(0, 0, 0, 220);
    gradBlue.addColorStop(0, 'rgba(79,70,229,.22)');
    gradBlue.addColorStop(1, 'rgba(79,70,229,0)');
    const gradCyan = visitCtx.createLinearGradient(0, 0, 0, 220);
    gradCyan.addColorStop(0, 'rgba(6,182,212,.18)');
    gradCyan.addColorStop(1, 'rgba(6,182,212,0)');

    const visitorsChart = new Chart(visitCtx, {
        type: 'line',
        data: {
            labels: {!! $chartLabels !!},
            datasets: [
                { label: 'Pengunjung', data: {!! $chartVisits !!}, borderColor: c.brand, backgroundColor: gradBlue, borderWidth: 2.5, pointRadius: 4, pointBackgroundColor: c.brand, pointBorderColor: c.bg(), pointBorderWidth: 2, fill: true, tension: .4 },
                { label: 'Post view', data: {!! $chartViews !!}, borderColor: c.accent, backgroundColor: gradCyan, borderWidth: 2, pointRadius: 3, pointBackgroundColor: c.accent, pointBorderColor: c.bg(), pointBorderWidth: 2, fill: true, tension: .4 },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: c.grid(), drawBorder: false }, ticks: { color: c.text() } },
                y: { grid: { color: c.grid(), drawBorder: false }, ticks: { color: c.text() }, beginAtZero: true },
            },
        },
    });

    new Chart(document.getElementById('contentDonut').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Berita', 'Tutorial', 'Jualan'],
            datasets: [{ data: [{{ $postMix['berita'] }}, {{ $postMix['tutorial'] }}, {{ $postMix['jualan'] }}], backgroundColor: [c.brand, c.green, c.amber], borderColor: c.bg(), borderWidth: 3, hoverOffset: 6 }],
        },
        options: { responsive: true, cutout: '68%', plugins: { legend: { display: false } } },
    });

    new Chart(document.getElementById('sourceBar').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! $sourceLabels !!},
            datasets: [{ label: 'View', data: {!! $sourceTotals !!}, backgroundColor: ['rgba(79,70,229,.75)', 'rgba(6,182,212,.75)', 'rgba(16,185,129,.75)', 'rgba(245,158,11,.75)', 'rgba(244,63,94,.75)'], borderRadius: 6, borderSkipped: false }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: c.grid(), drawBorder: false }, ticks: { color: c.text() }, beginAtZero: true },
                y: { grid: { display: false }, ticks: { color: c.text() } },
            },
        },
    });

    document.getElementById('themeToggle')?.addEventListener('click', () => {
        setTimeout(() => {
            visitorsChart.options.scales.x.grid.color = c.grid();
            visitorsChart.options.scales.x.ticks.color = c.text();
            visitorsChart.options.scales.y.grid.color = c.grid();
            visitorsChart.options.scales.y.ticks.color = c.text();
            visitorsChart.update('none');
        }, 50);
    });
})();
</script>
@endpush
