<?php

namespace Tests\Feature;

use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function username_is_required()
    {
        $response = $this->postJson(route('games'), [
            'username'  => '',
        ]);
        $response->assertJsonValidationErrors('username');
    }

    /** @test */
    public function size_of_hand_cannot_be_empty()
    {
        $cards = [];

        $response = $this->postJson(route('games'), [
            'cards' => $cards,
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors([
            'cards',
        ]);
    }

    /** @test */
    public function size_of_the_hand_should_be_one_card_min()
    {
        $response = $this->postJson(route('games'), [
            'username'  => 'jon',
            'cards'     => ['1'],
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function validate_card_figures()
    {
        $cards = ['1', '12', '13', '-1', 'j', 'k', 'J', 'K'];

        $response = $this->postJson(route('games'), [
            'cards' => $cards,
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors([
            'cards.1',
            'cards.2',
            'cards.3',
            'cards.4',
            'cards.5',
        ]);
    }

    /** @test */
    public function it_should_accept_valid_figures()
    {
        $cards = ['1', '2', '3', '4', '5', '6', '7', '9', '10', 'J', 'Q', 'K', 'A'];

        $response = $this->postJson(route('games'), [
            'username'   => 'jon',
            'cards'      => $cards,
        ]);

        $response->assertJsonMissingValidationErrors()->assertOk();
    }

    /** @test */
    public function it_should_return_game_results()
    {
        $cards = ['5', 'K'];

        $response = $this->postJson(route('games'), [
            'username'   => 'jon',
            'cards'      => $cards,
        ]);

        $response->assertOk()->assertJson(function (AssertableJson $json) use ($cards) {
            $json->has('results')
                 ->etc();
        });
    }

    /** @test */
    public function save_the_user_game()
    {
        $cards = ['5', 'K'];

        $response = $this->postJson(route('games'), [
            'username'   => 'jon',
            'cards'      => $cards,
        ]);

        $response->assertOk();
        $this->assertNotNull(Game::where('username', 'jon')->first());
    }
}
