<?php

describe('RegisterTest', function () {
    it('can register a user', function () {
        $faker = \Faker\Factory::create();

        $data = [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->email(),
            'password' => 'password',
        ];

        $query = <<<GQL
            mutation Register {
                register(first_name: "{$data['first_name']}", last_name: "{$data['last_name']}", email: "{$data['email']}", password: "{$data['password']}") {
                    message
                }
            }
        GQL;

        $response = $this->postJson('/graphql/auth', [
            'query' => $query,
        ]);

        $response->assertStatus(200);
    });

    it('can not register a user if email already exists', function () {
        // Register a user
        $faker = \Faker\Factory::create();

        // Then re-use the same email
        $data = [
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->email(),
            'password' => 'password',
        ];

        $query = <<<GQL
            mutation Register {
                register(first_name: "{$data['first_name']}", last_name: "{$data['last_name']}", email: "{$data['email']}", password: "{$data['password']}") {
                    message
                }
            }
        GQL;

        $response = $this->postJson('/graphql/auth', [
            'query' => $query,
        ]);

        $response->assertStatus(200);
    });
});
