@extends('dashboard.layout', [
    'title' => 'Seri Panduan',
    'description' => 'Kelola seri/batch panduan pembelajaran yang saling terhubung.',
])

@section('content')

<section class="card panel">
    <div class="panel-head">
        <div>
            <h2>Seri Panduan</h2>
            <p>{{ $series->total() }} seri tersimpan. Panduan dalam satu seri akan tampil terurut & saling terhubung.</p>
        </div>
        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.series.create') }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Buat Seri Baru
        </a>
    </div>

    @if(session('status'))
        <div class="alert alert-success" style="margin:0 0 16px;padding:10px 14px;background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);border-radius:8px;color:#059669;font-size:.87rem;">
            {{ session('status') }}
        </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th>Judul Seri</th>
                <th>Slug</th>
                <th>Jumlah Panduan</th>
                <th>Status</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($series as $s)
            <tr>
                <td><strong>{{ $s->title }}</strong><br><small class="muted">{{ Str::limit($s->description, 80) }}</small></td>
                <td><code style="font-size:.78rem;">{{ $s->slug }}</code></td>
                <td>{{ $s->posts_count }} panduan</td>
                <td>
                    <span class="badge {{ $s->status === 'active' ? 'badge-green' : 'badge-muted' }}">
                        {{ $s->status === 'active' ? 'Aktif' : 'Arsip' }}
                    </span>
                </td>
                <td style="text-align:right;">
                    <div style="display:flex;gap:6px;justify-content:flex-end;">
                        <a class="btn btn-soft btn-sm" href="{{ route('dashboard.series.edit', $s) }}">Edit</a>
                        <form method="POST" action="{{ route('dashboard.series.destroy', $s) }}" onsubmit="return confirm('Hapus seri ini? Panduan yang terhubung tidak ikut terhapus.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:32px;color:#888;">
                    Belum ada seri. <a href="{{ route('dashboard.series.create') }}">Buat seri pertama</a>.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:16px;">
        {{ $series->links() }}
    </div>
</section>

@endsection
