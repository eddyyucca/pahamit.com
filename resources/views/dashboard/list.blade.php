@extends('dashboard.layout', [
    'title' => 'Daftar ' . $label,
    'description' => 'Kelola daftar ' . strtolower($label) . ' yang sudah tersimpan.',
])

@section('content')

<section class="card panel">
    <div class="panel-head">
        <div>
            <h2>Daftar {{ $label }}</h2>
            <p>{{ $items->total() }} total {{ strtolower($label) }} tersimpan.</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <form action="{{ route('dashboard.posts.index', $type) }}" method="get">
                <div class="field" style="flex-direction:row;gap:8px;align-items:center;">
                    <input name="q" type="search" value="{{ request('q') }}"
                           placeholder="Cari judul..."
                           style="min-width:220px;min-height:38px;">
                    <button class="btn btn-soft btn-sm" type="submit">Cari</button>
                </div>
            </form>
            <a class="btn btn-primary btn-sm" href="{{ route('dashboard.posts.create', $type) }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                Posting {{ $label }}
            </a>
        </div>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    @if ($type === 'jualan') <th>Harga</th> @endif
                    <th>Views</th>
                    <th>Diperbarui</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                <tr>
                    <td class="title-cell">{{ Str::limit($item->title, 60) }}</td>
                    <td class="muted">{{ $item->category ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $item->status === 'published' ? 'green' : ($item->status === 'review' ? 'amber' : 'rose') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    @if ($type === 'jualan')
                    <td class="muted">
                        {{ $item->price ? 'Rp ' . number_format($item->price, 0, ',', '.') : 'Gratis' }}
                    </td>
                    @endif
                    <td class="muted">{{ number_format($item->views_count) }}</td>
                    <td class="muted">{{ $item->updated_at->diffForHumans() }}</td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            @if ($item->status === 'published')
                                <a class="btn btn-soft btn-sm" href="{{ route($type === 'tutorial' ? 'post.panduan' : ($type === 'jualan' ? 'post.toko' : 'post.berita'), $item->slug) }}" target="_blank">Lihat</a>
                            @else
                                <a class="btn btn-soft btn-sm" href="{{ route('dashboard.posts.preview', [$type, $item]) }}" target="_blank">Preview</a>
                            @endif
                            <a class="btn btn-soft btn-sm" href="{{ route('dashboard.posts.edit', [$type, $item]) }}">Edit</a>
                            <form class="inline-form" method="post"
                                  action="{{ route('dashboard.posts.destroy', [$type, $item]) }}"
                                  onsubmit="return confirm('Hapus \'{{ addslashes($item->title) }}\'?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm" type="submit"
                                        style="background:var(--rose-soft);color:var(--rose);border:1px solid transparent;">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $type === 'jualan' ? 7 : 6 }}"
                        style="text-align:center;padding:42px;color:var(--text3);">
                        Belum ada data {{ strtolower($label) }}.
                        <a href="{{ route('dashboard.posts.create', $type) }}" style="color:var(--brand);font-weight:700;">Posting sekarang -></a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($items->hasPages())
    <div class="pagination">
        @for ($p = 1; $p <= $items->lastPage(); $p++)
            @if ($p === $items->currentPage())
                <span class="active">{{ $p }}</span>
            @else
                <a href="{{ $items->url($p) }}">{{ $p }}</a>
            @endif
        @endfor
    </div>
    @endif
</section>

@endsection
