<?php

namespace Tests;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public $auth_user;

    /**
     * @var string
     */
    public $auth_password;


    public $auth_account;

    public function setUp()
    {
        parent::setUp();

        $this->auth_user        = factory(User::class)->create();
        $this->auth_account     = factory(Account::class)->create(['owner_id' => $this->auth_user->id]);
        $this->auth_password    = $this->auth_user['password'];
        $this->actingAs($this->auth_user, 'api');
    }


}
