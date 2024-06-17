<?php
use App\Models\User;

describe('LogoutTest', function () {
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

    it('can logout', function () {
        $query = <<<GQL
            mutation {
                logout
            }
        GQL;

        $response = $this->postJson('/graphql', [
            'query' => $query,
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);
    });

    it('returns a message after logout', function () {
        $query = <<<GQL
            mutation {
                logout {
                    message
                }
            }
        GQL;

        $response = $this->postJson('/graphql', [
            'query' => $query,
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'logout' => [
                    'message' => 'Successfully logged out',
                ],
            ],
        ]);
    });
});