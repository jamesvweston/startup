<?php

namespace Tests\Feature\Unit;

use App\Models\Account;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $account_data = factory(Account::class)->make();
        $account_data = $account_data->toArray();
        $account       = $this->postJson('/api/accounts', $account_data);
    }
}
