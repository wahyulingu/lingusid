<?php

namespace Tests\Feature\Sid\Population;

use App\Models\Sid\SidGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SidGroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_sid_group_page_can_be_rendered(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard/sid/population/groups');

        $response->assertOk();
    }

    public function test_sid_group_can_be_created(): void
    {
        $this->actingAs($this->createUser());

        $response = $this->post('/dashboard/sid/population/groups', [
            'name' => 'Kelompok Tani',
            'description' => 'Description for Kelompok Tani',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('sid_groups', [
            'name' => 'Kelompok Tani',
        ]);
    }

    public function test_sid_group_can_be_updated(): void
    {
        $this->actingAs($this->createUser());

        $group = SidGroup::factory()->create();

        $response = $this->put('/dashboard/sid/population/groups/'.$group->id, [
            'name' => 'Kelompok Ternak',
            'description' => 'Description for Kelompok Ternak',
        ]);

        $group->refresh();

        $this->assertEquals('Kelompok Ternak', $group->name);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_sid_group_can_be_deleted(): void
    {
        $this->actingAs($this->createUser());

        $group = SidGroup::factory()->create();

        $response = $this->delete('/dashboard/sid/population/groups/'.$group->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseMissing('sid_groups', [
            'id' => $group->id,
        ]);
    }
}
