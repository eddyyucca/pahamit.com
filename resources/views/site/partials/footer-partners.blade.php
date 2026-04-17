@php
    $footerPartners = [
        ['initial' => 'RS', 'name' => 'Reseller IT', 'meta' => 'Produk jaringan & perangkat kerja'],
        ['initial' => 'CL', 'name' => 'Cloud & Hosting', 'meta' => 'Domain, hosting, email bisnis'],
        ['initial' => 'LG', 'name' => 'Logistik', 'meta' => 'Pengiriman produk fisik'],
        ['initial' => 'PG', 'name' => 'Payment Gateway', 'meta' => 'Pembayaran online'],
        ['initial' => 'CM', 'name' => 'Komunitas IT', 'meta' => 'Kolaborasi edukasi teknologi'],
        ['initial' => 'TR', 'name' => 'Training Partner', 'meta' => 'Kelas, workshop, dan sertifikasi'],
    ];
@endphp

<section class="footer-partners" aria-labelledby="footer-partners-title">
    <div class="footer-partners-head">
        <div>
            <p class="footer-col-title" id="footer-partners-title">Akreditasi & Partner</p>
            <span>Daftar ekosistem kerja sama Pahamit.</span>
        </div>
        <a href="mailto:info@pahamit.com?subject=Kerja%20Sama%20Partner%20Pahamit">Ajukan Partner</a>
    </div>
    <div class="footer-partner-list">
        @foreach ($footerPartners as $partner)
            <div class="footer-partner-card">
                <span class="footer-partner-mark">{{ $partner['initial'] }}</span>
                <span>
                    <strong>{{ $partner['name'] }}</strong>
                    <small>{{ $partner['meta'] }}</small>
                </span>
            </div>
        @endforeach
    </div>
</section>
