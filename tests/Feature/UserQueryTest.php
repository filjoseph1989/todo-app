<?php

use DB;
use App\Models\User;

describe('login', function () {
    it('can login a user', function () {
        DB::beginTransaction();

        try {
            $password = 'password';

            $user = User::factory()->create([
                'password' => bcrypt($password),
            ]);

            $query = <<<GQL
                mutation Login {
                    login(email: "{$user->email}", password: "{$password}") {
                        id
                        abilities
                        expires_at
                        tokenable_id
                        tokenable_type
                        token
                    }
                }
            GQL;

            $response = $this->postJson('/graphql/auth', [
                'query' => $query,
            ]);

            $response->assertStatus(200);

            $data = $response->json('data.login');

            $this->assertArrayHasKey('id', $data);

            $abilities = json_decode($data['abilities'], true);
            $this->assertArrayHasKey('expires_in', $abilities);

            $expiresAt = $abilities['expires_in'];
            $this->assertTrue(strtotime($expiresAt) > time());

            $this->assertNull($data['expires_at']);
            $this->assertArrayHasKey('tokenable_id', $data);
            $this->assertEquals('App\\Models\\User', $data['tokenable_type']);
            $this->assertIsString($data['token']);
        } finally {
            DB::rollBack();
        }
    });

    it('cannot login a user with incorrect password', function () {
        DB::beginTransaction();

        try {
            $password = 'wrongpassword';
            $correctPassword = 'password';

            $user = User::factory()->create([
                'password' => bcrypt($correctPassword),
            ]);

            $query = <<<GQL
                mutation Login {
                    login(email: "{$user->email}", password: "{$password}") {
                        id
                        abilities
                        expires_at
                        tokenable_id
                        tokenable_type
                        token
                    }
                }
            GQL;

            $response = $this->postJson('/graphql/auth', [
                'query' => $query,
            ]);

            $response->assertStatus(200);

            $data = $response->json('data.login');

            $this->assertNull($data);
        } finally {
            DB::rollBack();
        }
    });

    it('cannot login a user that does not exist', function () {
        DB::beginTransaction();

        try {
            $query = <<<GQL
                mutation Login {
                    login(email: "wrongemail@example.com", password: "password") {
                        id
                        abilities
                        expires_at
                        tokenable_id
                        tokenable_type
                        token
                    }
                }
            GQL;

            $response = $this->postJson('/graphql/auth', [
                'query' => $query,
            ]);

            $response->assertStatus(200);

            $data = $response->json('data.login');

            $this->assertNull($data);
        } finally {
            DB::rollBack();
        }
    });

});