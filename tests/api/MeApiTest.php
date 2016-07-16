<?php

use App\Transformers\UserTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeApiTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_returns_me()
    {
        $user = createUser();
        $this->actingAs($user)
             ->get(route('api.me.show'))
             ->seeJson()
             ->seeJsonContains(
                 Fractal::item($user, new UserTransformer)->getArray()
             );
    }

    /** @test */
    public function it_returns_me_with_role()
    {
        $user = createUser();
        $this->actingAs($user)
             ->get(route('api.me.show') . '?include=role')
             ->seeJson()
             ->seeJsonContains(
                 Fractal::includes(['role'])->item($user, new UserTransformer)->getArray()
             );
    }

    /** @test */
    public function it_updates_me()
    {
        $user    = createUser(['password' => bcrypt('123pass')]);
        $updates = [
            'name'                      => 'Alexxx',
            'username'                  => 'hootlex',
            'email'                     => 'hootlex@hootlex.com',
            'password'                  => '123pass',
            'bio'                       => 'I used to train pokemons when I was young.',
            'new_password'              => 'superpass',
            'new_password_confirmation' => 'superpass'
        ];
        $this->actingAs($user)
             ->patch(route('api.me.update'), $updates)
             ->seeStatusCode(200)
             ->seeJson()
             ->seeInDatabase('users', [
                 'id'       => $user->id,
                 'name'     => $updates['name'],
                 'username' => $updates['username'],
                 'email'    => $updates['email'],
                 'bio'      => $updates['bio']
             ]);

        $this->assertTrue(
            Hash::check($updates['new_password'], \App\User::find($user->id)->password)
        );
    }

    /** @test */
    public function it_updates_me_when_non_unique_data_are_passed()
    {
        $user    = createUser(['password' => bcrypt('123pass')]);
        $updates = [
            'name'                      => 'Alexxx',
            'username'                  => $user['username'],
            'email'                     => 'hootlex@hootlex.com',
            'password'                  => '123pass',
            'new_password'              => 'superpass',
            'new_password_confirmation' => 'superpass'
        ];
        $this->actingAs($user)
             ->patch(route('api.me.update'), $updates)
             ->seeJsonContains(
                 Fractal::item($user->fill($updates), new UserTransformer)->getArray()
             )
             ->seeInDatabase('users', [
                 'id'       => $user->id,
                 'name'     => $updates['name'],
                 'username' => $updates['username'],
                 'email'    => $updates['email']
             ]);

        $this->assertTrue(
            Hash::check($updates['new_password'], \App\User::find($user->id)->password)
        );
    }

    /** @test */
    public function it_throws_error_on_update_when_new_pass_not_confirmed()
    {
        $user    = createUser(['password' => bcrypt('123pass')]);
        $updates = ['name' => 'Alexxx', 'new_password' => 'superpass', 'password' => '123pass'];
        $this->actingAs($user)
             ->patch(route('api.me.update'), $updates)
             ->seeStatusCode(400)
             ->seeJsonContains(['message' => 'The new password confirmation does not match.'])
             ->dontSeeInDatabase('users', ['id' => $user->id, 'name' => $updates['name']]);
    }

    /** @test */
    public function it_throws_error_on_update_when_email_is_taken()
    {
        $user      = createUser(['password' => bcrypt('123pass')]);
        $takenMail = \App\User::first()->email;
        $updates   = ['name' => 'Alexxx', 'email' => $takenMail, 'password' => '123pass'];
        $this->actingAs($user)
             ->patch(route('api.me.update'), $updates)
             ->seeStatusCode(400)
             ->seeJsonContains(['message' => 'The email has already been taken.'])
             ->dontSeeInDatabase('users', ['id' => $user->id, 'name' => $updates['name']]);
    }

    /** @test */
    public function it_throws_error_on_update_when_password_is_invalid()
    {

        $user    = createUser();
        $updates = ['name' => 'Alexxx', 'password' => 'wrong'];
        $this->actingAs($user)
             ->patch(route('api.me.update'), $updates)
             ->seeStatusCode(403)
             ->seeJsonContains(['message' => 'Invalid current password.'])
             ->dontSeeInDatabase('users', ['id' => $user->id, 'name' => $updates['name']]);
    }

}
