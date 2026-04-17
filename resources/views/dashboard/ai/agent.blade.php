@extends('dashboard.layout', [
    'title' => 'AI Agent',
    'description' => 'Diskusi tema, buat draft dengan ChatGPT, lalu review dengan Claude.',
])

@php
    $types = [
        'berita' => 'Berita IT',
        'tutorial' => 'Panduan / Tutorial',
        'jualan' => 'Jualan / Jasa',
        'general' => 'Diskusi Umum',
    ];
@endphp

@section('content')
<section class="ai-hero">
    <div>
        <span class="ai-kicker">Pahamit AI Workspace</span>
        <h2>Diskusikan tema, susun draft, lalu review sebelum publish.</h2>
        <p>ChatGPT membantu merancang dan menulis. Claude disiapkan sebagai reviewer agar draft lebih rapi sebelum masuk ke konten.</p>
    </div>
    <div class="ai-hero-steps">
        <span>Brief</span>
        <span>Draft</span>
        <span>Review</span>
    </div>
</section>

<div class="ai-shell">
    <section class="card panel ai-sidebar">
        <div class="panel-head">
            <div>
                <h2>Percakapan</h2>
                <p>Riwayat brief dan draft AI.</p>
            </div>
        </div>

        <form action="{{ route('dashboard.ai.store') }}" method="post" class="ai-new-form">
            @csrf
            <div class="field">
                <label for="new_type">Mode</label>
                <select id="new_type" name="type">
                    @foreach ($types as $value => $name)
                        <option value="{{ $value }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="tone" value="Santai teknis">
            <button class="btn btn-primary" type="submit">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Percakapan Baru
            </button>
        </form>

        <div class="ai-convo-list">
            @foreach ($conversations as $item)
                <a class="ai-convo {{ $item->is($conversation) ? 'active' : '' }}"
                   href="{{ route('dashboard.ai.show', $item) }}">
                    <strong>{{ Str::limit($item->title, 34) }}</strong>
                    <span>{{ $types[$item->type] ?? ucfirst($item->type) }} · {{ $item->updated_at->diffForHumans() }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="ai-main">
        <section class="card panel ai-context">
            <div class="panel-head">
                <div>
                    <h2>Konteks Agent</h2>
                    <p>Isi ini agar ChatGPT dan Claude paham tujuan konten sebelum menulis.</p>
                </div>
            </div>
            <form action="{{ route('dashboard.ai.update', $conversation) }}" method="post" class="ai-context-grid">
                @csrf
                @method('PUT')
                <div class="field">
                    <label for="title">Nama Percakapan</label>
                    <input id="title" name="title" value="{{ old('title', $conversation->title) }}" required>
                </div>
                <div class="field">
                    <label for="type">Jenis Konten</label>
                    <select id="type" name="type" required>
                        @foreach ($types as $value => $name)
                            <option value="{{ $value }}" @selected(old('type', $conversation->type) === $value)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="goal">Tujuan</label>
                    <input id="goal" name="goal" value="{{ old('goal', $conversation->goal) }}" placeholder="Edukasi, trafik, lead jasa, jualan template...">
                </div>
                <div class="field">
                    <label for="audience">Target Pembaca</label>
                    <input id="audience" name="audience" value="{{ old('audience', $conversation->audience) }}" placeholder="Pemula, siswa SMK, teknisi, owner bisnis...">
                </div>
                <div class="field">
                    <label for="tone">Gaya Bahasa</label>
                    <input id="tone" name="tone" value="{{ old('tone', $conversation->tone) }}" placeholder="Santai teknis, profesional, praktis...">
                </div>
                <div class="field ai-save-context">
                    <label>&nbsp;</label>
                    <button class="btn btn-soft" type="submit">Simpan Konteks</button>
                </div>
            </form>
        </section>

        <section class="card panel ai-chat-card">
            <div class="panel-head">
                <div>
                    <h2>Chat Dengan Agent</h2>
                    <p>ChatGPT berdiskusi dan membuat draft. Claude mereview draft saat diminta.</p>
                </div>
                <div class="ai-provider-badges">
                    <span class="active">ChatGPT</span>
                    <span>Claude</span>
                </div>
            </div>

            @error('message')
                <div class="flash" style="background:var(--rose-soft);color:var(--rose);border-color:transparent;">{{ $message }}</div>
            @enderror

            <div class="ai-messages" id="aiMessages">
                @forelse ($conversation->messages as $message)
                    <article class="ai-message {{ $message->role === 'user' ? 'user' : 'assistant' }}">
                        <div class="ai-avatar">
                            @if ($message->role === 'user')
                                U
                            @elseif ($message->provider === 'anthropic')
                                C
                            @else
                                AI
                            @endif
                        </div>
                        <div class="ai-bubble">
                            <div class="ai-message-head">
                                <strong>
                                    @if ($message->role === 'user')
                                        Anda
                                    @elseif ($message->provider === 'anthropic')
                                        Claude Reviewer
                                    @elseif ($message->provider === 'system')
                                        AI Agent
                                    @else
                                        ChatGPT Agent
                                    @endif
                                </strong>
                                <span>{{ $message->created_at->format('d M H:i') }}</span>
                            </div>
                            <div class="ai-message-body">{!! nl2br(e($message->content)) !!}</div>
                        </div>
                    </article>
                @empty
                    <div class="ai-empty">
                        Mulai dengan menjelaskan tema, tujuan, target pembaca, dan gaya bahasa.
                    </div>
                @endforelse
            </div>

            <form action="{{ route('dashboard.ai.message', $conversation) }}" method="post" class="ai-compose">
                @csrf
                <textarea name="message" rows="4" required placeholder="Contoh: Saya ingin membuat panduan subnetting untuk siswa SMK. Tujuannya edukasi dan arahkan ke template IP planner Pahamit.">{{ old('message') }}</textarea>
                <div class="ai-actions">
                    <button class="btn btn-soft" name="action" value="chat" type="submit">Kirim Chat</button>
                    <button class="btn btn-soft" name="action" value="outline" type="submit">Outline</button>
                    <button class="btn btn-primary" name="action" value="draft" type="submit">Buat Draft</button>
                    <button class="btn btn-soft" name="action" value="review" type="submit">Review Claude</button>
                </div>
            </form>
        </section>
    </section>

    <section class="card panel ai-draft-panel">
        <div class="panel-head">
            <div>
                <h2>Draft Terbaru</h2>
                <p>Hasil draft AI masuk ke konten sebagai draft manual.</p>
            </div>
        </div>

        @if ($draft)
            <div class="ai-draft-meta">
                <span class="badge blue">{{ ucfirst($draft->type) }}</span>
                <span class="badge {{ $draft->status === 'saved' ? 'green' : 'amber' }}">{{ ucfirst($draft->status) }}</span>
            </div>
            <h3 class="ai-draft-title">{{ $draft->title }}</h3>
            <p class="ai-draft-excerpt">{{ $draft->excerpt }}</p>
            <div class="ai-draft-content">{!! nl2br(e(Str::limit($draft->content, 1800))) !!}</div>

            @if (! empty($draft->sources))
                <div class="ai-sources">
                    <strong>Sumber</strong>
                    @foreach ($draft->sources as $source)
                        <a href="{{ $source['url'] ?? '#' }}" target="_blank" rel="noreferrer">{{ $source['title'] ?? $source['url'] ?? 'Sumber' }}</a>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('dashboard.ai.drafts.save', [$conversation, $draft]) }}" method="post">
                @csrf
                <button class="btn btn-primary" type="submit" style="width:100%;justify-content:center;" @disabled($draft->media_post_id)>
                    {{ $draft->media_post_id ? 'Sudah Disimpan' : 'Simpan ke Draft Konten' }}
                </button>
            </form>
        @else
            <div class="ai-empty">
                Belum ada draft. Diskusikan tema dulu, lalu klik <strong>Buat Draft</strong>.
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<style>
    .ai-hero {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 16px;
        padding: 22px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background:
            linear-gradient(135deg, rgba(79,70,229,.12), rgba(6,182,212,.08)),
            var(--surface);
        box-shadow: var(--shadow);
    }
    .ai-kicker {
        display: inline-flex;
        margin-bottom: 8px;
        padding: 5px 9px;
        border-radius: 999px;
        background: var(--brand-soft);
        color: var(--brand);
        font-size: .7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .08em;
    }
    .ai-hero h2 {
        max-width: 720px;
        margin: 0;
        font-size: clamp(1.25rem, 2.4vw, 1.9rem);
        line-height: 1.15;
        letter-spacing: -.01em;
    }
    .ai-hero p {
        max-width: 760px;
        margin-top: 8px;
        color: var(--text2);
        font-size: .92rem;
        line-height: 1.65;
    }
    .ai-hero-steps {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end;
        flex-shrink: 0;
    }
    .ai-hero-steps span {
        padding: 7px 10px;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text2);
        font-size: .75rem;
        font-weight: 800;
    }
    .ai-shell {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 22px;
        align-items: stretch;
        max-width: 1120px;
        margin: 0 auto;
    }
    .ai-hero {
        max-width: 1120px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 22px;
    }
    .ai-sidebar,
    .ai-context,
    .ai-chat-card,
    .ai-draft-panel {
        padding: 26px;
    }
    .ai-sidebar,
    .ai-draft-panel {
        position: static;
    }
    .ai-new-form,
    .ai-main {
        display: grid;
        gap: 14px;
    }
    .ai-new-form {
        display: grid;
        grid-template-columns: minmax(190px, 260px) auto;
        align-items: end;
        gap: 16px;
        padding: 16px;
        border-radius: 12px;
        background: var(--surface2);
        border: 1px solid var(--border);
    }
    .ai-new-form .btn {
        width: 100%;
        justify-content: center;
    }
    .ai-convo-list {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding: 4px 2px 10px;
        -webkit-overflow-scrolling: touch;
    }
    .ai-convo {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 250px;
        max-width: 310px;
        padding: 15px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--surface2);
        transition: background .15s, border-color .15s, transform .15s;
    }
    .ai-convo:hover,
    .ai-convo.active {
        border-color: rgba(79,70,229,.35);
        background: var(--brand-soft);
    }
    .ai-convo:hover {
        transform: translateY(-1px);
    }
    .ai-convo-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .ai-convo strong {
        font-size: .86rem;
        line-height: 1.35;
    }
    .ai-convo em {
        width: 24px;
        height: 24px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: var(--surface);
        color: var(--brand);
        font-style: normal;
        font-size: .72rem;
        font-weight: 900;
        flex-shrink: 0;
    }
    .ai-convo span {
        color: var(--text3);
        font-size: .75rem;
        font-weight: 700;
    }
    .ai-context-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }
    .ai-context-grid .field:nth-child(1),
    .ai-context-grid .field:nth-child(3) {
        grid-column: 1 / -1;
    }
    .ai-context-grid .field input,
    .ai-context-grid .field select {
        min-height: 46px;
        padding-left: 14px;
        padding-right: 14px;
    }
    .ai-chat-card {
        min-height: 650px;
        display: grid;
        grid-template-rows: auto 1fr auto;
        overflow: hidden;
    }
    .ai-provider-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .ai-provider-badges span {
        padding: 5px 9px;
        border-radius: 999px;
        background: var(--surface2);
        color: var(--text2);
        font-size: .72rem;
        font-weight: 800;
        border: 1px solid var(--border);
    }
    .ai-provider-badges span.active {
        background: var(--brand-soft);
        color: var(--brand);
        border-color: rgba(79,70,229,.25);
    }
    .ai-messages {
        display: grid;
        gap: 18px;
        align-content: start;
        max-height: 560px;
        overflow-y: auto;
        padding: 10px 10px 10px 0;
    }
    .ai-message {
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }
    .ai-message.user {
        flex-direction: row-reverse;
    }
    .ai-avatar {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: var(--sidebar-bg);
        color: #fff;
        font-size: .72rem;
        font-weight: 900;
        flex-shrink: 0;
    }
    .ai-message.user .ai-avatar {
        background: var(--brand);
    }
    .ai-bubble {
        max-width: min(760px, 86%);
        padding: 16px 18px;
        border: 1px solid var(--border);
        border-radius: 14px;
        background: var(--surface2);
    }
    .ai-message.user .ai-bubble {
        background: var(--brand-soft);
        border-color: rgba(79,70,229,.25);
    }
    .ai-message-head {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 7px;
        color: var(--text3);
        font-size: .74rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .ai-message-body {
        color: var(--text2);
        font-size: .9rem;
        line-height: 1.75;
        white-space: normal;
        overflow-wrap: anywhere;
    }
    .ai-compose {
        display: grid;
        gap: 16px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }
    .ai-compose textarea {
        width: 100%;
        min-height: 140px;
        padding: 16px 18px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--surface);
        color: var(--text);
        resize: vertical;
        outline: none;
        line-height: 1.65;
        transition: border-color .15s, box-shadow .15s;
    }
    .ai-compose textarea:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(79,70,229,.12);
    }
    .ai-actions {
        display: grid;
        grid-template-columns: repeat(4, minmax(120px, 1fr));
        gap: 12px;
    }
    .ai-actions .btn {
        width: 100%;
        justify-content: center;
    }
    .ai-draft-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }
    .ai-draft-title {
        font-size: 1.05rem;
        line-height: 1.35;
        margin-bottom: 8px;
    }
    .ai-draft-excerpt {
        color: var(--text2);
        font-size: .86rem;
        line-height: 1.6;
        margin-bottom: 12px;
    }
    .ai-draft-content {
        max-height: 520px;
        overflow-y: auto;
        padding: 18px;
        border-radius: 12px;
        background: var(--surface2);
        color: var(--text2);
        font-size: .9rem;
        line-height: 1.8;
        margin-bottom: 14px;
        overflow-wrap: anywhere;
    }
    .ai-sources {
        display: grid;
        gap: 7px;
        margin-bottom: 14px;
        font-size: .82rem;
    }
    .ai-sources a {
        color: var(--brand);
        font-weight: 700;
        overflow-wrap: anywhere;
    }
    .ai-empty {
        padding: 28px 18px;
        border: 1px dashed var(--border);
        border-radius: 12px;
        color: var(--text3);
        text-align: center;
        line-height: 1.6;
        background: var(--surface2);
    }
    @media (max-width: 1180px) {}
    @media (max-width: 820px) {
        .ai-hero {
            display: grid;
            max-width: none;
        }
        .ai-hero-steps {
            justify-content: flex-start;
        }
        .ai-new-form {
            grid-template-columns: 1fr;
        }
        .ai-sidebar,
        .ai-context,
        .ai-chat-card,
        .ai-draft-panel {
            padding: 18px;
        }
        .ai-context-grid {
            grid-template-columns: 1fr;
        }
        .ai-context-grid .field {
            grid-column: auto !important;
        }
        .ai-chat-card {
            min-height: 0;
        }
        .ai-messages {
            max-height: 520px;
        }
        .ai-actions {
            grid-template-columns: 1fr 1fr;
        }
        .ai-actions .btn {
            width: 100%;
        }
    }
    @media (max-width: 480px) {
        .ai-hero {
            padding: 16px;
        }
        .ai-sidebar,
        .ai-context,
        .ai-chat-card,
        .ai-draft-panel {
            padding: 15px;
        }
        .ai-compose textarea {
            min-height: 130px;
            padding: 14px;
        }
        .ai-hero-steps span {
            flex: 1;
            text-align: center;
        }
        .ai-actions {
            grid-template-columns: 1fr;
        }
        .ai-message-head {
            display: grid;
        }
        .ai-message,
        .ai-message.user {
            flex-direction: column;
        }
        .ai-bubble {
            max-width: 100%;
            width: 100%;
        }
    }
</style>
<script>
    const aiMessages = document.getElementById('aiMessages');
    if (aiMessages) aiMessages.scrollTop = aiMessages.scrollHeight;
</script>
@endpush
