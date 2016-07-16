<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function it_redirects_user_to_login_when_visiting_dashboard_without_having_permission(){
        $this->visit('dashboard')->seePageIs('login');
    }
    /** @test */
    public function it_redirects_user_to_previous_url_when_visiting_dashboard_without_having_permission(){
        $user = factory(App\User::class, 'admin')->create();
        $this->visit('dashboard')
            ->seePageIs('login')
            ->type($user->email, 'email')
            ->type('123pass', 'password')
            ->press('Login')
            ->seePageIs('dashboard');
    }

    /** @test */
    public function it_visits_dashboard(){
        $this->actingAsAdmin()->visit('dashboard')->seePageIs('dashboard');
    }
}
