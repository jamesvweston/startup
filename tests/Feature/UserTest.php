<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    private $users = [];

    public function testUpdate()
    {
        for ($i = 0; $i <= 10; $i++)
        {
            $user_data  = factory(User::class)->make();
            $password   = $user_data['password'];
            $user_data  = $user_data->toArray();
            $user_data['password'] = $user_data['password_confirmation'] = $password;


            $account_data = factory(Account::class)->make();
            $user_data['account'] = $account_data->toArray();
            unset($user_data['id']);
            unset($user_data['account']['id']);

            //  $user       = $this->postJson('/api/users', $user_data);
            //  dd($user);
        }
    }

}
