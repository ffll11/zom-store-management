<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    public function it_can_list_roles(){
        Role::factory()->count(3)->create();
        $response = $this->getJson('/api/roles');
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }
    /** @test*/
    public function it_can_create_a_role(){

        $data = [
            'name' => 'Roletest',
            'slug' => 'roletest',
            'description' => "role-description"
        ];

        $response = $this->postJson('/api/roles', $data);
        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('roles', $data);

    }

     public function it_can_show_a_role(){
        $role = Role::factory()->create();

        $response = $this->getJson('/api/roles/' . $role->id);
        $response->assertStatus(200)
            ->assertJsonFragment($role->toArray());

    }

    public function it_can_update_a_role(){
        $role = Role::factory()->create();

        $data = [
            'name' => 'UpdatedRole',
            'slug' => 'updatedrole',
            'description' => "updated-description"
        ];

        $response = $this->putJson('/api/roles/' . $role->id, $data);
        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('roles', $data);

    }

    public function it_can_delete_a_role(){
        $role = Role::factory()->create();

        $response = $this->deleteJson('/api/roles/' . $role->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }


}
