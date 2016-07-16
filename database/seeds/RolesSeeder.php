<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->truncate();

        $member = [
            'name' => 'Member',
            'level' => 1
        ];
        $moderator = [
            'name' => 'Moderator',
            'level' => 5
        ];
        $sModerator = [
            'name' => 'Super Moderator',
            'level' => 7
        ];
        $admin = [
            'name' => 'Admin',
            'level' => 9
        ];
        
        factory(App\Role::class)->create($admin);
        factory(App\Role::class)->create($member);
        factory(App\Role::class)->create($moderator);
        factory(App\Role::class)->create($sModerator);
    }
}
