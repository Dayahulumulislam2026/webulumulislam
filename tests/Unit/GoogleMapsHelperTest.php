<?php

namespace Tests\Unit;

use Tests\TestCase;

class GoogleMapsHelperTest extends TestCase
{
    public function test_format_gmaps_embed_url_with_empty_input(): void
    {
        $url = format_gmaps_embed_url('');
        $this->assertStringContainsString('maps.google.com/maps?q=', $url);
        $this->assertStringContainsString('output=embed', $url);
    }

    public function test_format_gmaps_embed_url_with_iframe_tag(): void
    {
        $iframe = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d100!2d97.1!3d5.1" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
        $url = format_gmaps_embed_url($iframe);
        $this->assertEquals('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d100!2d97.1!3d5.1', $url);
    }

    public function test_format_gmaps_embed_url_with_direct_embed_link(): void
    {
        $embedLink = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d100!2d97.1!3d5.1';
        $url = format_gmaps_embed_url($embedLink);
        $this->assertEquals($embedLink, $url);
    }

    public function test_format_gmaps_embed_url_with_query_link(): void
    {
        $queryLink = 'https://maps.google.com/?q=5.18,97.14';
        $url = format_gmaps_embed_url($queryLink);
        $this->assertStringContainsString('output=embed', $url);
        $this->assertStringContainsString('5.18', urldecode($url));
    }

    public function test_format_gmaps_embed_url_with_shortlink(): void
    {
        $shortlink = 'https://maps.app.goo.gl/g6xvxkoSP4qHHXTy9';
        $url = format_gmaps_embed_url($shortlink);
        $this->assertStringContainsString('maps.google.com/maps?q=', $url);
        $this->assertStringContainsString('output=embed', $url);
        // Assert it extracted coordinates or place query
        $this->assertTrue(str_contains($url, '5.106') || str_contains($url, 'Ulumul'));
    }

    public function test_get_gmaps_direct_url(): void
    {
        $url = get_gmaps_direct_url('https://maps.app.goo.gl/example');
        $this->assertEquals('https://maps.app.goo.gl/example', $url);

        $iframe = '<iframe src="https://www.google.com/maps/embed?pb=123"></iframe>';
        $this->assertEquals('https://www.google.com/maps/embed?pb=123', get_gmaps_direct_url($iframe));
    }
}
