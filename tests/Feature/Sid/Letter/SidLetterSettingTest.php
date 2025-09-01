<?php

namespace Tests\Feature\Sid\Letter;

use App\Models\Sid\SidLetterSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidLetterSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_letter_setting_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/letters/settings');

        $response->assertOk();
    }

    public function test_sid_letter_setting_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $setting = SidLetterSetting::factory()->create();

        $response = $this->post('/dashboard/sid/letters/settings', [
            'header_text' => 'Updated Header',
            'footer_text' => 'Updated Footer',
            'signature_text' => 'Updated Signature',
            'logo_path' => 'updated_logo.png',
        ]);

        $setting->refresh();

        $this->assertEquals('Updated Header', $setting->header_text);
        $this->assertEquals('updated_logo.png', $setting->logo_path);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
