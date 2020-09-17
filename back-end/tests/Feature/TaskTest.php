<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetTasksSuccess()
    {
        $user = User::all()->first();
        $response = $this->actingAs($user)
            ->get('/api/tasks');

        $response->assertStatus(200);
    }

    /**
     * Teste de cadastro de task
     * @return void
     */
    public function testCreateTaskSuccess()
    {
        $task = Task::factory()->make();
        $user = User::all()->first();

        $response = $this->actingAs($user)
            ->post('api/tasks', $task->toArray());

        $response->assertCreated()
            ->assertJson(['success' => true]);
    }

    /**
     * Teste de atualização de task
     * @return void
     */
    public function testUpdateTaskSuccess()
    {
        $task = Task::all()->random(1)->first();
        $user = User::all()->first();

        $response = $this->actingAs($user)
            ->put(
                'api/tasks/' . $task->id,
                $task->toArray()
            );

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    /**
     * Teste de exclusão de task
     * @return void
     */
    public function testRemoveTaskSuccess()
    {
        $task = Task::all()->random(1)->first();
        $user = User::all()->first();

        $response = $this->actingAs($user)
            ->delete(
                'api/tasks/' . $task->id
            );

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }


}
