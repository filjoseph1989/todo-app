<?php

use App\Models\Task;
use App\Models\User;

describe('UpdateTaskTest', function () {
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

    it('can update a task', function () {
        DB::beginTransaction();

        try {
            $password = 'password';

            $user = User::factory()->create([
                'password' => bcrypt($password),
            ]);

            $task = Task::factory()->create();

            $query = <<<GQL
                mutation UpdateTask {
                    updateTask(id: "{$task->id}", task: "Updated Task", status: "todo", user_id: "{$task->user_id}") {
                        id
                        task
                        status
                        user_id
                    }
                }
            GQL;

            $response = $this->actingAs($user)
                ->postJson('/graphql', [
                    'query' => $query,
                ], [
                    'Authorization' => "Bearer {$this->token}",
                ]);

            $this->assertDatabaseHas('tasks', [
                'id' => $task->id,
            ]);

            $response->assertStatus(200);

            $data = $response->json('data.updateTask');

            $this->assertEquals($task->id, $data['id']);
            $this->assertEquals("Updated Task", $data['task']);
            $this->assertEquals('TODO', $data['status']);
            $this->assertEquals($task->user_id, $data['user_id']);
        } finally {
            DB::rollBack();
        }
    });

    it('cannot update a task that does not exist', function () {
        DB::beginTransaction();

        try {
            $password = 'password';

            $user = User::factory()->create([
                'password' => bcrypt($password),
            ]);

            $query = <<<GQL
                mutation UpdateTask {
                    updateTask(id: "wrongid", task: "Updated Task", status: "todo", user_id: "{$user->id}") {
                        id
                        task
                        status
                        user_id
                    }
                }
            GQL;

            $response = $this->actingAs($user)
                ->postJson('/graphql', [
                    'query' => $query,
                ], [
                    'Authorization' => "Bearer {$this->token}",
                ]);

            $response->assertStatus(200);

            $data = $response->json('data.updateTask');

            $this->assertNull($data);
        } finally {
            DB::rollBack();
        }
    });

    it('cannot update a task that belongs to another user', function () {
        DB::beginTransaction();

        try {
            $password = 'password';

            $user = User::factory()->create([
                'password' => bcrypt($password),
            ]);

            $task = Task::factory()->create();

            $query = <<<GQL
                mutation UpdateTask {
                    updateTask(id: "{$task->id}", task: "Updated Task", status: "todo", user_id: "{$user->id}") {
                        id
                        task
                        status
                        user_id
                    }
                }
            GQL;

            $response = $this->actingAs($user)
                ->postJson('/graphql', [
                    'query' => $query,
                ], [
                    'Authorization' => "Bearer {$this->token}",
                ]);

            $response->assertStatus(200);

            $data = $response->json('data.updateTask');

            $this->assertNull($data);
        } finally {
            DB::rollBack();
        }
    });

    // TODO: Fixed testing updating task without authentication because it will still update the task
    // it('cannot update a task without authentication', function () {
    //     $query = <<<GQL
    //         mutation UpdateTask {
    //             updateTask(id: "2", task: "aaaaaaaa", status: "todo", user_id: "1") {
    //                 id
    //                 task
    //                 status
    //                 user_id
    //             }
    //         }
    //     GQL;

    //     $response = $this->postJson('/graphql', [
    //         'query' => $query,
    //     ]);

    //     $response->assertStatus(200);

    //     $data = $response->json('data.updateTask');
    // });
});