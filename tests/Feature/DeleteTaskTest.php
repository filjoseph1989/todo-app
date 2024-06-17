<?php

use App\Models\Task;
use App\Models\User;

describe('DeleteTaskTest', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();

        $query = <<<GQL
            mutation Login {
                login(email: "{$this->user->email}", password: "password") {
                    token
                }
            }
        GQL;

        $response = $this->postJson('/graphql/auth', [
            'query' => $query,
        ]);

        $response->assertStatus(200);

        $this->token = $response->json('data.login.token');
    });

    afterEach(function () {
        User::where('email', $this->user->email)->delete();
    });

    it('can delete a task', function () {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $query = <<<GQL
            mutation DeleteTask {
                deleteTask(id: "{$task->id}", user_id: "{$this->user->id}")
            }
        GQL;

        $response = $this->postJson('/graphql', [
            'query' => $query,
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);

        $this->assertTrue($response->json('data.deleteTask'));

        $this->assertNull(Task::find($task->id));
    });
});
