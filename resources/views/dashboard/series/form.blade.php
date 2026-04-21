@extends('dashboard.layout', [
    'title' => $series->exists ? 'Edit Seri: '.$series->title : 'Buat Seri Baru',
    'description' => 'Seri panduan memungkinkan beberapa panduan saling terhubung sebagai satu alur belajar.',
])

@section('content')

<form method="POST" action="{{ $formAction }}">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <section class="card panel">
        <div class="panel-head">
            <div>
                <h2>{{ $series->exists ? 'Edit Seri' : 'Buat Seri Baru' }}</h2>
                <p>Setelah membuat seri, buka editor panduan dan pilih seri ini beserta urutan bagian (Part 1, 2, 3, dan seterusnya).</p>
            </div>
            <div style="display:flex;gap:8px;">
                <a class="btn btn-soft btn-sm" href="{{ route('dashboard.series.index') }}"><- Kembali</a>
                <button class="btn btn-primary btn-sm" type="submit">Simpan Seri</button>
            </div>
        </div>

        <div style="display:grid;gap:14px;max-width:600px;">
            <div class="field">
                <label for="title">Judul Seri <span style="color:#e55;">*</span></label>
                <input id="title" name="title" type="text" required
                       value="{{ old('title', $series->title) }}"
                       placeholder="Cth: Belajar Jaringan dari Nol, Seri Docker, dan lainnya">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="description">Deskripsi Singkat</label>
                <textarea id="description" name="description" style="min-height:80px;"
                          placeholder="Apa yang dipelajari dalam seri ini?">{{ old('description', $series->description) }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="active"    {{ old('status', $series->status) === 'active'   ? 'selected' : '' }}>Aktif</option>
                    <option value="archived"  {{ old('status', $series->status) === 'archived' ? 'selected' : '' }}>Arsip</option>
                </select>
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </section>

    @if($series->exists && $series->posts->count())
    <section class="card panel" style="margin-top:16px;">
        <div class="panel-head"><h2>Panduan dalam Seri Ini</h2></div>
        <table class="data-table">
            <thead><tr><th>Urutan</th><th>Judul Panduan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($series->posts()->orderBy('series_order')->get() as $p)
                <tr>
                    <td>Part {{ $p->series_order ?? '-' }}</td>
                    <td>{{ $p->title }}</td>
                    <td><span class="badge {{ $p->status === 'published' ? 'badge-green' : 'badge-muted' }}">{{ $p->status }}</span></td>
                    <td><a class="btn btn-soft btn-sm" href="{{ route('dashboard.posts.edit', ['tutorial', $p]) }}">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    @endif
</form>

@endsection
