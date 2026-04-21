<?php

namespace Tests\Feature;

use App\Models\SiteVisit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionSurfaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_privacy_page_is_available(): void
    {
        $this->get('/kebijakan-privasi')
            ->assertOk()
            ->assertSee('Kebijakan Privasi')
            ->assertSee('081250653005');
    }

    public function test_missing_page_uses_custom_error_page(): void
    {
        $this->get('/halaman-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman yang dicari tidak ditemukan');
    }

    public function test_sitemap_includes_static_public_pages(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('/kebijakan-privasi', false)
            ->assertSee('/tentang', false)
            ->assertSee('/berita', false)
            ->assertSee('/panduan', false);
    }

    public function test_site_visit_tracking_is_deduplicated_per_day_path_and_ip(): void
    {
        $headers = ['User-Agent' => 'Mozilla/5.0 ProductionSurfaceTest'];

        $this->get('/', $headers)->assertOk();
        $this->get('/', $headers)->assertOk();

        $this->assertSame(1, SiteVisit::count());
    }
}
