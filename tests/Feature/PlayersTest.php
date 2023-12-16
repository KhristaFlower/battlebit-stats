<?php

use App\Models\Player;
use App\Models\User;
use App\Models\Weapon;

test('guests cannot access the players page', function () {
    $response = $this->get('/players');

    $response->assertRedirect('/login');
});

test('logged in users can access the players page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/players');

    $response->assertStatus(200);
});

test('user can see their players', function () {
    $user = User::factory()->create();

    $player1 = Player::factory()->create([
        'user_id' => $user->id,
    ]);
    $player2 = Player::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get('/players');

    $response
        ->assertSee($player1->player_name)
        ->assertSee($player2->player_name);
});

test('user cannot see other users players', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $myPlayer = Player::factory()->create([
        'user_id' => $user->id,
    ]);
    $otherPlayer = Player::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->actingAs($user)->get('/players');

    $response
        ->assertSee($myPlayer->player_name)
        ->assertDontSee($otherPlayer->player_name);
});

test('user can access the create new player page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/players/create');

    $response->assertStatus(200);
});

test('user can not submit an empty new player form', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/players', []);

    $response->assertSessionHasErrors([
        'player_name' => 'The player name field is required.',
    ]);
});

test('user cannot create a player with a name that exists already', function () {
    $user = User::factory()->create();

    $player = Player::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->post('/players', [
        'player_name' => $player->player_name,
    ]);

    $response->assertSessionHasErrors([
        'player_name' => 'The player name has already been taken.',
    ]);
});

test('user can create a new player', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/players', [
        'player_name' => 'New Player',
    ]);

    $response->assertRedirect('/players');

    $this->assertDatabaseHas('players', [
        'player_name' => 'New Player',
    ]);
});

test('user can view their player', function () {
    $user = User::factory()->create();

    $player = Player::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get('/players/' . $player->player_name);

    $response->assertStatus(200)
        ->assertSee($player->player_name);
});

test('user can access the edit player page', function () {
    $user = User::factory()->create();

    $player = Player::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get('/players/' . $player->player_name . '/edit');

    $response->assertStatus(200);
});

test('user can change their players name', function () {
    $user = User::factory()->create();

    $player = Player::factory()->create([
        'user_id' => $user->id,
        'player_name' => 'OldPlayerName',
    ]);

    $response = $this->actingAs($user)->patch('/players/' . $player->player_name, [
        'player_name' => 'NewPlayerName',
    ]);

    $response->assertRedirect('/players/NewPlayerName');

    $this->assertDatabaseHas('players', [
        'player_name' => 'NewPlayerName',
    ]);
});

test('user can delete their player', function () {
    $user = User::factory()->create();

    $player = Player::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->delete('/players/' . $player->player_name);

    $response->assertRedirect('/players')
        ->assertDontSee($player->player_name);

    $this->assertDatabaseMissing('players', [
        'player_name' => $player->player_name,
    ]);
});

test('user cannot delete players they do not own', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $player = Player::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $response = $this->actingAs($user)->delete('/players/' . $player->player_name);

    $response->assertStatus(403);

    $this->assertDatabaseHas('players', [
        'player_name' => $player->player_name,
    ]);
});

test('user can update their weapon kills', function () {
    $user = User::factory()->withPlayer()->create();
    $player = $user->players->first();

    $weapon = Weapon::factory()->create();
    $player->weapons()->attach($weapon, [
        'kill_count' => 1337,
    ]);

    $this->actingAs($user)->get('/players/' . $player->player_name)
        ->assertSee($weapon->weapon_name)
        ->assertSee(1337);

    $this->actingAs($user)
        ->patch('/players/' . $player->player_name . '/stats', [
            'weapon_kills' => [
                $weapon->weapon_id => [
                    'kill_count' => 1991,
                ],
            ],
        ])
        ->assertRedirect('/players/' . $player->player_name);

    $this->actingAs($user)->get('/players/' . $player->player_name)
        ->assertSee($weapon->weapon_name)
        ->assertSee(1991);
});
