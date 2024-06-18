<?php
use App\Models\User;

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

describe('LogoutTest', function () {
    it('can login a user', function () {
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

        expect($response->json('data.login.token'))->not()->toBeNull('Token is present in the response');

        $this->user->delete();
    });
});

