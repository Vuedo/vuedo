<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_knows_if_user_is_admin(){
        $admin = factory(\App\User::class, 'admin')->create();
        $this->assertTrue($admin->isAdmin());

        $member = factory(\App\User::class)->create();
        $this->assertFalse($member->isAdmin());
    }

    /** @test */
    public function it_knows_if_user_owns_a_post(){
        $user = createUser();
        $anotherUser = createUser();
        $post = createPost(['created_by' => $user->id]);

        $this->assertTrue($user->owns($post));
        $this->assertFalse($anotherUser->owns($post));
    }

    /** @test */
    public function it_applies_admin_scope(){
        createUser([], 2);
        factory(\App\User::class, 'admin', 2)->create();

        $admins = \App\User::admin()->get();
        foreach ($admins as $admin) {
            $this->assertTrue($admin->isAdmin());
        }
    }

    /** @test */
    public function it_applies_notAdmin_scope(){
        createUser([], 2);
        factory(\App\User::class, 'admin', 2)->create();

        $notAdmins = \App\User::notAdmin()->get();
        foreach ($notAdmins as $notAdmin) {
            $this->assertFalse($notAdmin->isAdmin());
        }
    }
}
