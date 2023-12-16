<?php

use App\Models\Player;
use App\Models\User;

test('search page shows to guests', function () {
    $response = $this->get('/search');

    $response->assertStatus(200);

    $response->assertSee('Search');
});

test('search page is displayed', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/search');

    $response->assertStatus(200);
});

test('searching for players returns results', function () {
    $player = Player::factory()->create([
        'player_name' => 'Khrista',
    ]);

    $response = $this->get('/search?for=' . $player->player_name);

    $response->assertSee($player->player_name);
});

test('searching for players returns no results', function () {
    $response = $this->get('/search?for=Khrista');

    $response->assertSee('No players found.');
});

test('searching only returns results matching the search', function () {
    Player::factory()->create(['player_name' => 'Alice']);
    Player::factory()->create(['player_name' => 'Bob']);
    Player::factory()->create(['player_name' => 'Charlie']);
    Player::factory()->create(['player_name' => 'Dave']);

    $response = $this->get('/search?for=Alice');

    $response->assertSee('Alice');
    $response->assertDontSee('Bob');
    $response->assertDontSee('Charlie');
    $response->assertDontSee('Dave');
    $response->assertDontSee('No players found.');
});
