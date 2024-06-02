<?php

namespace Tests\Browser;

use App\Models\Team;
use App\Models\User;
use App\Models\Member;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RemoveTeamTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     */
    public function testRemoveTeam(): void
    {
        $user = User::factory()->create([
            'username' => 'jDoe',
            'email' => 'johndoe@gmail.com',
            'password' => bcrypt('0000'),
            'admin' => false,
        ]);
        $team = Team::factory()->create([
            'name' => 'team1',
            'user_id' => $user->id,
        ]);
        Member::factory(10)->create();

        $this->browse(function (Browser $browser) use ($user, $team) {
            $browser->visit('/')

                    // Login
                    ->clickLink('Se connecter')
                    ->type('email', $user->username)
                    ->type('password', '0000')
                    ->click('@login-button')

                    ->assertSee('team1')

                    ->visit('team/1')
                    ->click('@delete-button')

                    ->assertDontSee('team1');

        });
    }
}
