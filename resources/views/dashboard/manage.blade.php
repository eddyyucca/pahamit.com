@extends('dashboard.layout', [
    'title'       => $title,
    'description' => $description,
])

@section('content')

<form class="editor-shell" action="{{ $formAction }}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    {{-- â”€â”€ Editor main â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
    <div class="editor-main">

        {{-- Title --}}
        <section class="card panel">
            <div class="panel-head">
                <div>
                    <h2>{{ $post->exists ? 'Edit' : 'Tulis' }} {{ $label }}</h2>
                    <p>Tulis judul yang jelas dan deskriptif untuk SEO yang lebih baik.</p>
                </div>
                @if ($post->exists)
                    <a class="btn btn-soft btn-sm" href="{{ route('dashboard.posts.create', $type) }}">+ Tulis Baru</a>
                @endif
                <a class="btn btn-soft btn-sm" href="{{ route('dashboard.posts.index', $type) }}">Daftar {{ $label }}</a>
            </div>
            <div class="field full">
                <label for="title">Judul {{ $label }}</label>
                <input class="editor-title" id="title" name="title" type="text"
                       value="{{ old('title', $post->title) }}"
                       placeholder="Tulis judul yang menarik di sini..."
                       required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </section>

        {{-- Content editor --}}
        <section class="card panel">
            <div class="editor-section-bar">
                <label for="content" style="font-size:.78rem;font-weight:700;color:var(--text2);">Isi Konten</label>
                <div class="editor-mode-actions">
                    <button type="button" id="btnEditorOnly" class="tool-btn tool-tab active" title="Mode Editor">Editor</button>
                    <button type="button" id="btnSplitView" class="tool-btn tool-tab" title="Editor + Preview">Split</button>
                    @if ($post->exists)
                    <a href="{{ route('dashboard.posts.preview', [$type, $post]) }}" target="_blank"
                       class="tool-btn" title="Lihat pratinjau artikel" style="display:inline-flex;align-items:center;gap:5px;font-size:.78rem;background:var(--brand-soft);color:var(--brand);border-color:rgba(79,70,229,.25);">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                        Preview
                    </a>
                    @endif
                </div>
            </div>

            {{-- Toolbar --}}
            <div class="editor-toolbar" id="editorToolbar">
                {{-- Format --}}
                <button class="tool-btn" type="button" data-insert="**teks tebal**" title="Bold (Ctrl+B)"><b>B</b></button>
                <button class="tool-btn" type="button" data-insert="*teks miring*" title="Italic (Ctrl+I)"><i>I</i></button>
                <button class="tool-btn" type="button" data-insert="~~dicoret~~" title="Strikethrough"><s>S</s></button>
                <span style="width:1px;height:22px;background:var(--border);display:inline-block;margin:0 2px;"></span>

                {{-- Headings --}}
                <button class="tool-btn" type="button" data-insert="## Judul Bagian&#10;" title="Heading 2" style="font-size:.75rem;font-weight:800;">H2</button>
                <button class="tool-btn" type="button" data-insert="### Sub-Judul&#10;" title="Heading 3" style="font-size:.75rem;font-weight:800;">H3</button>
                <span style="width:1px;height:22px;background:var(--border);display:inline-block;margin:0 2px;"></span>

                {{-- Lists --}}
                <button class="tool-btn" type="button" data-insert="&#10;- Item pertama&#10;- Item kedua&#10;- Item ketiga&#10;" title="Unordered List">List</button>
                <button class="tool-btn" type="button" data-insert="&#10;1. Item pertama&#10;2. Item kedua&#10;3. Item ketiga&#10;" title="Ordered List">1.</button>
                <button class="tool-btn" type="button" data-insert="&#10;> Tulis kutipan di sini&#10;" title="Blockquote">"</button>
                <button class="tool-btn" type="button" data-insert="&#10;---&#10;" title="Garis pemisah">-</button>
                <span style="width:1px;height:22px;background:var(--border);display:inline-block;margin:0 2px;"></span>

                {{-- Link --}}
                <button class="tool-btn" type="button" id="btnInsertLink" title="Sisipkan Link" style="font-size:.75rem;">Link</button>

                {{-- Code --}}
                <button class="tool-btn" type="button" data-insert="`kode inline`" title="Kode Inline">&lt;&gt;</button>
                <button class="tool-btn" type="button" id="btnInsertCode" title="Blok Kode / Script" style="font-size:.75rem;background:var(--code-bg,#0F172A);color:#E2E8F0;border-color:#1E293B;">Code Block</button>
                <span style="width:1px;height:22px;background:var(--border);display:inline-block;margin:0 2px;"></span>

                {{-- Image --}}
                <button class="tool-btn" type="button" id="btnInsertImage" title="Sisipkan Foto di Mana Saja" style="font-size:.75rem;">Gambar</button>

                {{-- Ad --}}
                <button class="tool-btn" type="button" id="btnInsertAd" title="Sisipkan Slot Iklan" style="font-size:.75rem;background:rgba(245,158,11,.1);color:#92400E;border-color:rgba(245,158,11,.3);">$ Iklan</button>
            </div>

            <div id="editorWrap" style="display:flex;gap:0;min-width:0;overflow:hidden;">
                <textarea class="editor-textarea" id="content" name="content"
                          style="flex:1;min-width:0;border-radius:0 0 10px 10px !important;resize:none;min-height:480px;"
                          placeholder="Mulai menulis di sini...

Contoh shortcode yang tersedia:
## Heading 2
### Sub Heading

**tebal**, *miring*, `kode`

[img: https://url-gambar.com/foto.jpg | Keterangan foto]

\`\`\`bash
sudo apt-get update
\`\`\`

[iklan]
[iklan: leaderboard]

> Kutipan penting di sini.

- List item 1
- List item 2">{{ old('content', $post->content) }}</textarea>

                <div id="previewPane" style="display:none;flex:1;min-width:0;border:1px solid var(--border);border-left:none;border-radius:0 0 10px 0;overflow-y:auto;padding:20px 24px;background:var(--surface);height:480px;font-size:.93rem;line-height:1.8;">
                    <div id="previewContent" style="font-family:'Plus Jakarta Sans',sans-serif;"></div>
                </div>
            </div>

            @error('content') <span class="text-danger">{{ $message }}</span> @enderror

            {{-- Shortcode reference --}}
            <details style="margin-top:10px;">
                <summary style="font-size:.76rem;font-weight:700;color:var(--text3);cursor:pointer;padding:6px 0;">Panduan shortcode yang tersedia</summary>
                <div style="margin-top:8px;padding:14px;border-radius:8px;background:var(--surface2);font-size:.78rem;line-height:1.9;color:var(--text2);font-family:monospace;">
                    <strong style="font-family:inherit;">Format teks:</strong><br>
                    **tebal** - *miring* - `kode inline` - ~~coret~~<br><br>
                    <strong style="font-family:inherit;">Heading:</strong><br>
                    ## Heading 2 - ### Heading 3<br><br>
                    <strong style="font-family:inherit;">Sisipkan gambar di mana saja:</strong><br>
                    [img: https://url-foto.com/gambar.jpg | Keterangan opsional]<br><br>
                    <strong style="font-family:inherit;">Blok kode / script:</strong><br>
                    ```bash<br>
                    sudo apt-get update<br>
                    ```<br><br>
                    <strong style="font-family:inherit;">Slot iklan:</strong><br>
                    [iklan] - [iklan: leaderboard] - [iklan: rectangle]<br><br>
                    <strong style="font-family:inherit;">Kutipan &amp; list:</strong><br>
                    > kutipan - - item - 1. item bernomor
                </div>
            </details>
        </section>

        {{-- Excerpt --}}
        <section class="card panel">
            <div class="field full">
                <label for="excerpt">Ringkasan / Excerpt</label>
                <textarea id="excerpt" name="excerpt" style="min-height:90px;"
                          placeholder="Ringkasan singkat (150-200 karakter) yang tampil di kartu berita dan hasil pencarian.">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </section>

        <section class="card panel seo-panel">
            <div class="panel-head">
                <div>
                    <h2>SEO & Distribusi</h2>
                    <p>Optimalkan tampilan artikel di Google dan media sosial.</p>
                </div>
                <span class="badge blue" id="seoScoreBadge">SEO Check</span>
            </div>
            <div class="seo-grid">
                <div class="field full">
                    <label for="seo_title">SEO Title</label>
                    <input id="seo_title" name="seo_title" type="text" value="{{ old('seo_title', $post->seo_title) }}" placeholder="Judul untuk hasil pencarian Google">
                    <small class="seo-hint"><span id="seoTitleCount">0</span>/60 karakter ideal</small>
                    @error('seo_title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="seo_description">Meta Description</label>
                    <textarea id="seo_description" name="seo_description" style="min-height:88px;" placeholder="Ringkasan 140-160 karakter untuk hasil pencarian.">{{ old('seo_description', $post->seo_description) }}</textarea>
                    <small class="seo-hint"><span id="seoDescCount">0</span>/160 karakter ideal</small>
                    @error('seo_description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="focus_keyword">Focus Keyword</label>
                    <input id="focus_keyword" name="focus_keyword" type="text" value="{{ old('focus_keyword', $post->focus_keyword) }}" placeholder="Cth: subnetting dasar">
                    @error('focus_keyword') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="tags">Tags</label>
                    <input id="tags" name="tags" type="text" value="{{ old('tags', implode(', ', $post->tags ?? [])) }}" placeholder="MikroTik, jaringan, server">
                    @error('tags') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="field full">
                    <label for="canonical_url">Canonical URL</label>
                    <input id="canonical_url" name="canonical_url" type="url" value="{{ old('canonical_url', $post->canonical_url) }}" placeholder="Opsional, isi jika artikel bersumber dari URL utama lain">
                    @error('canonical_url') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="seo-preview">
                <span>{{ parse_url(config('app.url'), PHP_URL_HOST) ?: 'pahamit.com' }}</span>
                <strong id="seoPreviewTitle">{{ old('seo_title', $post->seo_title) ?: old('title', $post->title) ?: 'Judul artikel akan tampil di sini' }}</strong>
                <p id="seoPreviewDesc">{{ old('seo_description', $post->seo_description) ?: old('excerpt', $post->excerpt) ?: 'Meta description atau ringkasan artikel akan tampil di sini.' }}</p>
            </div>
            <div class="seo-checklist" id="seoChecklist">
                <div data-check="title"><span></span> SEO title ideal</div>
                <div data-check="description"><span></span> Meta description ideal</div>
                <div data-check="keyword"><span></span> Focus keyword terisi</div>
                <div data-check="tags"><span></span> Minimal satu tag</div>
                <div data-check="image"><span></span> Featured image tersedia</div>
                <div data-check="content"><span></span> Konten cukup panjang</div>
            </div>
        </section>

    </div>

    {{-- â”€â”€ Editor sidebar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
    <aside class="editor-side">

        {{-- Publish --}}
        <section class="card panel">
            <div class="panel-head">
                <div>
                    <h2>Publish</h2>
                    <p>Simpan sebagai draft atau langsung publikasikan.</p>
                </div>
            </div>
            <div style="display:grid;gap:10px;">
                <div class="field">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        @foreach (['draft' => 'Draft', 'review' => 'Review', 'published' => 'Published'] as $val => $lbl)
                            <option value="{{ $val }}" @selected(old('status', $post->status) === $val)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button class="btn btn-primary" type="submit" style="width:100%;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    {{ $post->exists ? 'Update Konten' : 'Publikasikan' }}
                </button>
                @if ($post->exists)
                    <a class="btn btn-soft" href="{{ route('dashboard.posts.index', $type) }}" style="width:100%;justify-content:center;">Batal Edit</a>
                @endif
            </div>
        </section>

        {{-- Detail --}}
        <section class="card panel">
            <div class="panel-head">
                <div>
                    <h2>Detail Konten</h2>
                    <p>Kategori dan metadata tambahan.</p>
                </div>
            </div>
            <div style="display:grid;gap:12px;">
                <div class="field">
                    <label for="category">Kategori</label>
                    <input id="category" name="category" type="text"
                           value="{{ old('category', $post->category) }}"
                           placeholder="Cth: Networking, Cloud, Security">
                    @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @if ($type === 'jualan')
                <div class="field">
                    <label for="price">Harga (Rp)</label>
                    <input id="price" name="price" type="number" min="0" step="1000"
                           value="{{ old('price', $post->price) }}"
                           placeholder="0 untuk gratis">
                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @endif
                @if ($type === 'tutorial')
                <div class="field">
                    <label for="series_id">Seri Panduan <small style="font-weight:400;color:#888;">(opsional)</small></label>
                    <select id="series_id" name="series_id">
                        <option value="">- Tidak ada seri -</option>
                        @foreach($allSeries as $s)
                            <option value="{{ $s->id }}" {{ old('series_id', $post->series_id) == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
                        @endforeach
                    </select>
                    @error('series_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="series_order">Urutan dalam Seri</label>
                    <input id="series_order" name="series_order" type="number" min="1"
                           value="{{ old('series_order', $post->series_order) }}"
                           placeholder="Cth: 1, 2, 3">
                    @error('series_order') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @endif
                <div class="field">
                    <label for="image_url">URL Gambar Eksternal</label>
                    <input id="image_url" name="image_url" type="url"
                           value="{{ old('image_url', $post->image_url) }}"
                           placeholder="https://...">
                    @error('image_url') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </section>

        {{-- Featured image --}}
        <section class="card panel">
            <div class="panel-head">
                <div>
                    <h2>Featured Image</h2>
                    <p>JPG, PNG, atau WebP - maks 2MB.</p>
                </div>
            </div>
            <label class="image-preview" for="featured_image" id="imagePreview">
                @if ($post->featured_image_url)
                    <img src="{{ $post->featured_image_url }}" alt="Featured image">
                @else
                    <div style="padding:20px;font-size:.83rem;line-height:1.6;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="margin:0 auto 10px;opacity:.4;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <strong style="display:block;">Klik untuk upload</strong>
                        <span style="color:var(--text3);">JPG, PNG, WebP - maks 2MB</span>
                    </div>
                @endif
            </label>
            <input id="featured_image" name="featured_image" type="file"
                   accept="image/png,image/jpeg,image/webp" style="display:none;">
            @error('featured_image') <span class="text-danger">{{ $message }}</span> @enderror
        </section>

    </aside>
</form>

@isset($items)
{{-- â”€â”€ Post list â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
<section class="card panel" style="margin-top:20px;">
    <div class="panel-head">
        <div>
            <h2>Daftar {{ $label }}</h2>
            <p>{{ $items->total() }} total {{ strtolower($label) }} tersimpan.</p>
        </div>
        <form action="{{ route('dashboard.posts.index', $type) }}" method="get">
            <div class="field" style="flex-direction:row;gap:8px;align-items:center;">
                <input name="q" type="search" value="{{ request('q') }}"
                       placeholder="Cari judul..."
                       style="min-width:200px;min-height:36px;">
                <button class="btn btn-soft btn-sm" type="submit">Cari</button>
            </div>
        </form>
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
                    <td class="title-cell">{{ Str::limit($item->title, 55) }}</td>
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
                        <div style="display:flex;gap:6px;">
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
                        style="text-align:center;padding:36px;color:var(--text3);">
                        Belum ada data {{ strtolower($label) }}.
                        <a href="{{ route('dashboard.posts.index', $type) }}" style="color:var(--brand);font-weight:700;">Tambah sekarang -></a>
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
@endisset

@endsection

@push('scripts')
<script>
// â”€â”€ Editor helpers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
const contentBox = document.getElementById('content');

function insertAtCursor(text) {
    const start = contentBox.selectionStart ?? 0;
    const end   = contentBox.selectionEnd   ?? 0;
    contentBox.value = contentBox.value.slice(0, start) + text + contentBox.value.slice(end);
    contentBox.focus();
    const pos = start + text.length;
    contentBox.setSelectionRange(pos, pos);
    renderPreview();
}

// data-insert buttons
document.querySelectorAll('[data-insert]').forEach(btn => {
    btn.addEventListener('click', () => insertAtCursor(btn.dataset.insert.replace(/\\n/g, '\n')));
});

// â”€â”€ Insert Link â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
document.getElementById('btnInsertLink').addEventListener('click', () => {
    const url  = prompt('URL link:', 'https://');
    if (!url) return;
    const text = prompt('Teks link:', 'Klik di sini') || url;
    insertAtCursor(`[${text}](${url})`);
});

// â”€â”€ Insert Code Block â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
document.getElementById('btnInsertCode').addEventListener('click', () => {
    const lang = prompt('Bahasa / jenis kode (bash, php, js, python, sql, text, dll):', 'bash') || 'bash';
    insertAtCursor(`\n\`\`\`${lang}\n// tulis kode di sini\n\`\`\`\n`);
});

// â”€â”€ Insert Image anywhere â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
document.getElementById('btnInsertImage').addEventListener('click', () => {
    const url = prompt('URL gambar:', 'https://');
    if (!url) return;
    const cap = prompt('Keterangan / caption (opsional):', '') || '';
    const shortcode = cap ? `[img: ${url} | ${cap}]` : `[img: ${url}]`;
    insertAtCursor('\n' + shortcode + '\n');
});

// â”€â”€ Insert Ad slot â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
document.getElementById('btnInsertAd').addEventListener('click', () => {
    const type = prompt('Tipe iklan:\n banner (468x60) - default\n rectangle (300x250)\n leaderboard (728x90)', 'banner') || 'banner';
    insertAtCursor(`\n[iklan: ${type}]\n`);
});

// â”€â”€ Split / editor only tabs â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
const previewPane  = document.getElementById('previewPane');
const previewContent = document.getElementById('previewContent');
let splitMode = false;

document.getElementById('btnEditorOnly').addEventListener('click', () => {
    splitMode = false;
    previewPane.style.display = 'none';
    contentBox.style.borderRadius = '0 0 10px 10px';
    document.getElementById('btnEditorOnly').classList.add('active');
    document.getElementById('btnSplitView').classList.remove('active');
});
document.getElementById('btnSplitView').addEventListener('click', () => {
    splitMode = true;
    previewPane.style.display = 'block';
    contentBox.style.borderRadius = '0 0 0 10px';
    document.getElementById('btnSplitView').classList.add('active');
    document.getElementById('btnEditorOnly').classList.remove('active');
    renderPreview();
});

// â”€â”€ Live preview (client-side mini-renderer) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function renderPreview() {
    if (!splitMode) return;
    const raw = contentBox.value;
    previewContent.innerHTML = clientRender(raw);
}
contentBox.addEventListener('input', renderPreview);

function clientRender(raw) {
    if (!raw.trim()) return '<p style="color:#94A3B8;font-style:italic;">Ketik konten untuk melihat pratinjau...</p>';
    let t = raw.replace(/\r\n/g, '\n').replace(/\r/g, '\n');

    // protect code blocks
    const codes = [];
    t = t.replace(/```(\w*)\n([\s\S]*?)```/gm, (_, lang, code) => {
        const id = `%%C${codes.length}%%`;
        codes.push(`<div style="margin:1em 0;border-radius:8px;overflow:hidden;"><div style="background:#1E293B;padding:8px 14px;font-size:.72rem;font-weight:700;color:#475569;text-transform:uppercase;">${lang||'text'}</div><pre style="margin:0;background:#0F172A;padding:16px;overflow-x:auto;"><code style="font-family:monospace;font-size:.86rem;color:#E2E8F0;white-space:pre;">${escHtml(code)}</code></pre></div>`);
        return id;
    });

    // protect image shortcodes
    const imgs = [];
    t = t.replace(/\[img:\s*([^\]|]+?)(?:\s*\|\s*([^\]]*))?\]/gi, (_, url, cap) => {
        const id = `%%I${imgs.length}%%`;
        imgs.push(`<figure style="margin:1.5em 0;border-radius:8px;overflow:hidden;"><img src="${escHtml(url.trim())}" alt="${escHtml((cap||'').trim())}" style="width:100%;display:block;">${cap?`<figcaption style="padding:8px 12px;background:#F1F5F9;font-size:.8rem;color:#64748B;text-align:center;">${escHtml(cap.trim())}</figcaption>`:''}</figure>`);
        return id;
    });

    // protect ad slots
    const ads = [];
    t = t.replace(/\[iklan(?::\s*([^\]]*))?\]/gi, (_, type) => {
        const id = `%%A${ads.length}%%`;
        ads.push(`<div style="margin:1.5em 0;padding:16px;border:2px dashed #E2E8F0;border-radius:8px;text-align:center;color:#94A3B8;font-size:.82rem;">Iklan Slot Iklan - ${type||'banner'}</div>`);
        return id;
    });

    // headings
    t = t.replace(/^## (.+)$/gm, '<h2 style="font-size:1.4rem;font-weight:800;margin:1.8em 0 .6em;border-bottom:2px solid #E2E8F0;padding-bottom:.4em;">$1</h2>');
    t = t.replace(/^### (.+)$/gm, '<h3 style="font-size:1.15rem;font-weight:700;margin:1.5em 0 .5em;">$1</h3>');

    // blockquote
    t = t.replace(/^> (.+)$/gm, '<blockquote style="border-left:3px solid #4F46E5;background:#EEF2FF;padding:12px 16px;border-radius:0 8px 8px 0;margin:1em 0;color:#475569;font-style:italic;">$1</blockquote>');

    // HR
    t = t.replace(/^---$/gm, '<hr style="border:none;border-top:1px solid #E2E8F0;margin:1.5em 0;">');

    // bold/italic/code
    t = t.replace(/\*\*\*(.+?)\*\*\*/g, '<strong><em>$1</em></strong>');
    t = t.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
    t = t.replace(/\*([^*\n]+?)\*/g, '<em>$1</em>');
    t = t.replace(/`([^`]+)`/g, '<code style="background:#EEF2FF;color:#4338CA;padding:2px 6px;border-radius:4px;font-size:.88em;">$1</code>');

    // links
    t = t.replace(/\[([^\]]+)\]\((https?:\/\/[^\)]+)\)/g, '<a href="$2" style="color:#4F46E5;font-weight:700;">$1</a>');

    // paragraphs (double newline separated)
    const paras = t.split(/\n{2,}/);
    t = paras.map(p => {
        p = p.trim();
        if (!p) return '';
        if (p.startsWith('<h') || p.startsWith('<blockquote') || p.startsWith('<hr') || p.match(/^%%[CIA]\d+%%$/)) return p;
        // unordered list
        if (/^[-*] /.test(p)) {
            const items = p.split('\n').filter(l => /^[-*] /.test(l)).map(l => `<li style="margin-bottom:.4em;">${l.replace(/^[-*] /, '')}</li>`);
            return `<ul style="padding-left:1.5em;margin:.5em 0;">${items.join('')}</ul>`;
        }
        // ordered list
        if (/^\d+\. /.test(p)) {
            const items = p.split('\n').filter(l => /^\d+\. /.test(l)).map(l => `<li style="margin-bottom:.4em;">${l.replace(/^\d+\. /, '')}</li>`);
            return `<ol style="padding-left:1.5em;margin:.5em 0;">${items.join('')}</ol>`;
        }
        return `<p style="margin:0 0 1em;">${p.replace(/\n/g, '<br>')}</p>`;
    }).join('');

    // restore
    codes.forEach((c, i) => { t = t.replace(`%%C${i}%%`, c); });
    imgs.forEach((c, i)  => { t = t.replace(`%%I${i}%%`, c); });
    ads.forEach((c, i)   => { t = t.replace(`%%A${i}%%`, c); });

    return t;
}
function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// keyboard shortcuts in textarea
contentBox.addEventListener('keydown', e => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        const sel = contentBox.value.substring(contentBox.selectionStart, contentBox.selectionEnd);
        insertAtCursor(sel ? `**${sel}**` : '**teks tebal**');
    }
    if ((e.ctrlKey || e.metaKey) && e.key === 'i') {
        e.preventDefault();
        const sel = contentBox.value.substring(contentBox.selectionStart, contentBox.selectionEnd);
        insertAtCursor(sel ? `*${sel}*` : '*teks miring*');
    }
    // Tab -> 2 spaces
    if (e.key === 'Tab') {
        e.preventDefault();
        insertAtCursor('  ');
    }
});

// â”€â”€ Featured image preview â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
const imgInput   = document.getElementById('featured_image');
const imgPreview = document.getElementById('imagePreview');
imgInput.addEventListener('change', () => {
    const file = imgInput.files?.[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => { imgPreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`; };
    reader.readAsDataURL(file);
});

// SEO preview
const titleInput = document.getElementById('title');
const excerptInput = document.getElementById('excerpt');
const seoTitleInput = document.getElementById('seo_title');
const seoDescInput = document.getElementById('seo_description');
const seoTitleCount = document.getElementById('seoTitleCount');
const seoDescCount = document.getElementById('seoDescCount');
const seoPreviewTitle = document.getElementById('seoPreviewTitle');
const seoPreviewDesc = document.getElementById('seoPreviewDesc');
const seoScoreBadge = document.getElementById('seoScoreBadge');
const hasFeaturedImage = @json((bool) $post->featured_image_url);

function updateSeoPreview() {
    const title = (seoTitleInput.value || titleInput.value || 'Judul artikel akan tampil di sini').trim();
    const desc = (seoDescInput.value || excerptInput.value || 'Meta description atau ringkasan artikel akan tampil di sini.').trim();
    seoTitleCount.textContent = title.length;
    seoDescCount.textContent = desc.length;
    seoPreviewTitle.textContent = title;
    seoPreviewDesc.textContent = desc;

    const checks = {
        title: title.length >= 35 && title.length <= 65,
        description: desc.length >= 120 && desc.length <= 170,
        keyword: document.getElementById('focus_keyword').value.trim().length > 0,
        tags: document.getElementById('tags').value.trim().length > 0,
        image: hasFeaturedImage || (document.getElementById('featured_image').files?.length > 0) || document.getElementById('image_url').value.trim().length > 0,
        content: contentBox.value.trim().split(/\s+/).filter(Boolean).length >= 300,
    };
    const score = Object.values(checks).filter(Boolean).length;

    seoScoreBadge.textContent = score >= 5 ? 'SEO Baik' : (score >= 3 ? 'SEO Cukup' : 'Perlu SEO');
    seoScoreBadge.className = 'badge ' + (score >= 5 ? 'green' : (score >= 3 ? 'amber' : 'rose'));

    Object.entries(checks).forEach(([name, passed]) => {
        const item = document.querySelector(`[data-check="${name}"]`);
        item?.classList.toggle('ok', passed);
    });
}

[titleInput, excerptInput, seoTitleInput, seoDescInput, document.getElementById('focus_keyword'), document.getElementById('tags'), contentBox, document.getElementById('image_url'), document.getElementById('featured_image')]
    .forEach(el => el?.addEventListener('input', updateSeoPreview));
document.getElementById('featured_image')?.addEventListener('change', updateSeoPreview);
updateSeoPreview();
</script>

<style>
.tool-tab { font-size:.73rem; }
.tool-tab.active { background: var(--brand-soft); color: var(--brand); border-color: rgba(79,70,229,.3); }
.editor-section-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 14px;
}
.editor-mode-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: flex-end;
}
@media (max-width: 640px) {
    .editor-section-bar {
        display: grid;
        gap: 10px;
    }
    .editor-mode-actions {
        justify-content: flex-start;
    }
}
.seo-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}
.seo-grid .full {
    grid-column: 1 / -1;
}
.seo-hint {
    color: var(--text3);
    font-size: .74rem;
    font-weight: 700;
}
.seo-preview {
    margin-top: 18px;
    padding: 16px 18px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: var(--surface2);
}
.seo-preview span {
    display: block;
    color: var(--green);
    font-size: .78rem;
    margin-bottom: 5px;
}
.seo-preview strong {
    display: block;
    color: var(--brand);
    font-size: 1.05rem;
    line-height: 1.35;
    margin-bottom: 6px;
}
.seo-preview p {
    color: var(--text2);
    font-size: .86rem;
    line-height: 1.55;
    margin: 0;
}
.seo-checklist {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
    margin-top: 16px;
}
.seo-checklist div {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 12px;
    border-radius: 9px;
    background: var(--surface2);
    color: var(--text2);
    font-size: .82rem;
    font-weight: 700;
}
.seo-checklist span {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid var(--text3);
    flex-shrink: 0;
}
.seo-checklist .ok {
    color: #065F46;
    background: var(--green-soft);
}
.seo-checklist .ok span {
    border-color: var(--green);
    background: var(--green);
    box-shadow: inset 0 0 0 3px var(--green-soft);
}
@media (max-width: 640px) {
    .seo-grid {
        grid-template-columns: 1fr;
    }
    .seo-checklist {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
