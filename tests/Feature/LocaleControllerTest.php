<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_user_can_switch_locale(): void
    {
        $response = $this->from('/')->post('/locale', [
            'locale' => 'vi',
        ]);

        $response->assertRedirect('/');
        $this->assertEquals('vi', session('locale'));
    }

    public function test_invalid_locale_is_rejected(): void
    {
        $response = $this->from('/')->post('/locale', [
            'locale' => 'fr',
        ]);

        $response->assertSessionHasErrors('locale');
    }
}
