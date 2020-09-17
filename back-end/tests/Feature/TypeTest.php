<?php

namespace Tests\Feature;

use App\Models\Type;
use App\Models\User;
use Tests\TestCase;

/**
 * Testes para o CRUD de types
 * Class TypeTest
 * @package Tests\Feature
 */
class TypeTest extends TestCase
{
    /**
     * Teste para o endpoint /types
     * @return void
     */
    public function testGetTypesSuccess()
    {
        $user = User::all()->first();
        $response = $this->actingAs($user)
            ->get('/api/types');

        $response->assertStatus(200);
    }

    /**
     * Teste de cadastro de type
     * @return void
     */
    public function testCreateTypeSuccess()
    {
        $type = Type::factory()->make();
        $user = User::all()->first();

        $response = $this->actingAs($user)
            ->post('api/types', $type->toArray());

        $response->assertCreated()
            ->assertJson(['success' => true]);
    }

    /**
     * Teste de atualização de type
     * @return void
     */
    public function testUpdateTypeSuccess()
    {
        $type = Type::all()->random(1)->first();
        $user = User::all()->first();

        $response = $this->actingAs($user)
            ->put(
                'api/types/' . $type->id,
                $type->toArray()
            );

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    /**
     * Teste de exclusão de type
     * @return void
     */
    public function testRemoveTypeSuccess()
    {
        $type = Type::all()->random(1)->first();
        $user = User::all()->first();

        $response = $this->actingAs($user)
            ->delete(
                'api/types/' . $type->id
            );

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

}
