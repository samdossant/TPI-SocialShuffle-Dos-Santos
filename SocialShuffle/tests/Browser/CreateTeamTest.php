<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateTeamTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test that creating a full team works
     */
public function testCreateTeam(): void
{
    // Arrange
    $user = User::factory()->create([
        'username' => 'jDoe',
        'email' => 'johndoe@gmail.com',
        'password' => bcrypt('0000'),
        'admin' => false,
    ]);

    // Act
    $this->browse(function (Browser $browser) use ($user) {
        $browser->visit('/')

                // Login
                ->clickLink('Se connecter')
                ->type('email', $user->username)
                ->type('password', '0000')
                ->click('@login-button')

                // Team name
                ->clickLink('+ Nouvelle équipe')
                ->type('name', 'duskTeam')
                ->click('@next-button')

                // Add members
                ->type('firstname', 'John')
                ->type('lastname', 'Doe')
                ->type('email', 'm1@a.a')
                ->type('phone_number', '9999999999')
                ->click('@add-member')
                
                ->type('firstname', 'Jane')
                ->type('lastname', 'Doe')
                ->type('email', 'm2@a.a')
                ->type('phone_number', '9999999999')
                ->click('@add-member')
                
                ->click('@next')
                
                // Group generation data
                ->type('nbMemberPerGroup', 1)
                ->type('nbActivities', 1)

                ->click('@create-groups')

                ->screenshot('finish')

                // Assert
                ->assertPathIs('/team/1');
    });
}
}
