<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Card;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $account_data = factory(Account::class)->make();
        $account_data = $account_data->toArray();
        $account       = $this->postJson('/api/accounts', $account_data);

        $cards          = [];
        for ($i = 0; $i < 2; $i++)
        {
            $card_data      = factory(Card::class)->make();
            $card_data['account_id'] = $account->json('id');
            $card_data  = $card_data->getAttributes();

            $card           = $this->postJson('/api/cards', $card_data);
            $cards[]    = $card->json();
        }


        $card_response  = $this->getJson('api/cards/' . $cards[1]['id'], ['Accept' => 'application/json']);
        dd($card_response);
    }
}
