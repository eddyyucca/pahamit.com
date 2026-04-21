@php
    $footerPartners = [
        [
            'name' => 'Reseller IT',
            'meta' => 'Produk jaringan & perangkat kerja',
            'svg'  => '<svg viewBox="0 0 60 32" fill="none" xmlns="http://www.w3.org/2000/svg"><text x="4" y="22" font-family="Arial,sans-serif" font-weight="900" font-size="13" fill="#0b6fee">RS</text><text x="22" y="22" font-family="Arial,sans-serif" font-weight="700" font-size="11" fill="#071f4f">Reseller</text></svg>',
        ],
        [
            'name' => 'Cloud & Hosting',
            'meta' => 'Domain, hosting, email bisnis',
            'svg'  => '<svg viewBox="0 0 70 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 24c-3.3 0-6-2.7-6-6a6 6 0 0 1 5.1-5.9A8 8 0 0 1 23 14h1a5 5 0 0 1 0 10H8Z" fill="#0b6fee" opacity=".18" stroke="#0b6fee" stroke-width="1.2"/><path d="M8 24c-3.3 0-6-2.7-6-6a6 6 0 0 1 5.1-5.9A8 8 0 0 1 23 14h1a5 5 0 0 1 0 10H8Z" fill="none" stroke="#0b6fee" stroke-width="1.5"/><text x="32" y="21" font-family="Arial,sans-serif" font-weight="900" font-size="11" fill="#071f4f">Cloud</text></svg>',
        ],
        [
            'name' => 'Logistik',
            'meta' => 'Pengiriman produk fisik',
            'svg'  => '<svg viewBox="0 0 70 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="10" width="28" height="16" rx="2" fill="#ed1c24" opacity=".12" stroke="#ed1c24" stroke-width="1.4"/><path d="M31 16h8l4 6H31V16Z" fill="#ed1c24" opacity=".18" stroke="#ed1c24" stroke-width="1.4"/><circle cx="11" cy="27" r="2.5" fill="#ed1c24" opacity=".7"/><circle cx="35" cy="27" r="2.5" fill="#ed1c24" opacity=".7"/><text x="44" y="21" font-family="Arial,sans-serif" font-weight="900" font-size="10" fill="#071f4f">Logistik</text></svg>',
        ],
        [
            'name' => 'Payment Gateway',
            'meta' => 'Pembayaran online',
            'svg'  => '<svg viewBox="0 0 72 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="8" width="30" height="20" rx="3" fill="#0b6fee" opacity=".12" stroke="#0b6fee" stroke-width="1.4"/><rect x="3" y="13" width="30" height="5" fill="#0b6fee" opacity=".25"/><text x="37" y="21" font-family="Arial,sans-serif" font-weight="900" font-size="9" fill="#071f4f">Payment</text></svg>',
        ],
        [
            'name' => 'Komunitas IT',
            'meta' => 'Kolaborasi edukasi teknologi',
            'svg'  => '<svg viewBox="0 0 72 32" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="16" r="7" fill="#0b6fee" opacity=".15" stroke="#0b6fee" stroke-width="1.4"/><circle cx="24" cy="16" r="7" fill="#ed1c24" opacity=".12" stroke="#ed1c24" stroke-width="1.4"/><text x="36" y="21" font-family="Arial,sans-serif" font-weight="900" font-size="9" fill="#071f4f">Komunitas</text></svg>',
        ],
        [
            'name' => 'Training Partner',
            'meta' => 'Kelas, workshop, dan sertifikasi',
            'svg'  => '<svg viewBox="0 0 72 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 22 L18 8 L32 22" stroke="#0b6fee" stroke-width="2" stroke-linecap="round" fill="none"/><path d="M10 22 v-6 h5 v6" stroke="#0b6fee" stroke-width="1.5" fill="none"/><text x="36" y="21" font-family="Arial,sans-serif" font-weight="900" font-size="9" fill="#071f4f">Training</text></svg>',
        ],
    ];
@endphp

<section class="footer-partners" aria-labelledby="footer-partners-title">
    <div class="footer-partners-head">
        <div>
            <p class="footer-col-title" id="footer-partners-title">Akreditasi & Partner</p>
            <span>Ekosistem kerja sama pahamIT.</span>
        </div>
        <a href="mailto:info@pahamit.com?subject=Kerja%20Sama%20Partner%20Pahamit">Ajukan Partner</a>
    </div>
    <div class="footer-partner-list">
        @foreach ($footerPartners as $partner)
            <div class="footer-partner-card">
                <div class="footer-partner-logo">{!! $partner['svg'] !!}</div>
                <span>
                    <strong>{{ $partner['name'] }}</strong>
                    <small>{{ $partner['meta'] }}</small>
                </span>
            </div>
        @endforeach
    </div>
</section>
