<?php

use DB;
use App\Models\User;

describe('CreateTaskTest', function () {
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

    it('can create a task', function () {
        DB::beginTransaction();

        try {
            $query = <<<GQL
                mutation CreateTask {
                    createTask(task: "Creating new task", user_id: "1") {
                        id
                        task
                        status
                    }
                }
            GQL;

            $response = $this->postJson('/graphql', [
                'query' => $query,
            ], [
                'Authorization' => 'Bearer ' . $this->token,
            ]);

            $response->assertStatus(200);

            $data = $response->json('data.createTask');

            $this->assertDatabaseHas('tasks', [
                'task' => $data['task'],
                'status' => 'todo',
            ]);
        } finally {
            DB::rollBack();
        }
    });
});