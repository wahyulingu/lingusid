<?php

namespace Tests\Feature\Sid\Complaint;

use App\Models\Sid\SidComplaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidComplaintTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_complaint_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/complaints/complaints');

        $response->assertOk();
    }

    public function test_sid_complaint_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/complaints/complaints', [
            'subject' => 'Jalan Rusak',
            'description' => 'Jalan di depan balai desa rusak parah',
            'reporter_name' => 'Warga A',
            'reporter_email' => 'warga.a@example.com',
            'reporter_phone' => '081234567890',
            'status' => 'pending',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_complaints', [
            'subject' => 'Jalan Rusak',
        ]);
    }

    public function test_sid_complaint_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $complaint = SidComplaint::factory()->create();

        $response = $this->put('/dashboard/sid/complaints/complaints/'.$complaint->id, [
            'subject' => 'Sampah Menumpuk',
            'description' => 'Sampah di TPS menumpuk dan bau',
            'reporter_name' => 'Warga B',
            'reporter_email' => 'warga.b@example.com',
            'reporter_phone' => '089876543210',
            'status' => 'in_progress',
        ]);

        $complaint->refresh();

        $this->assertEquals('Sampah Menumpuk', $complaint->subject);
        $this->assertEquals('in_progress', $complaint->status);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_complaint_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $complaint = SidComplaint::factory()->create();

        $response = $this->delete('/dashboard/sid/complaints/complaints/'.$complaint->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_complaints', [
            'id' => $complaint->id,
        ]);
    }
}
