<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateTeamTest extends DuskTestCase
{
    use DatabaseTruncation;

    /**
     * Test that creating a full test works
     */
    public function create_team_test(): void
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
                    ->clickLink('Se Connecter')
                    ->type('email', $user->username)
                    ->type('password', '0000')
                    ->clickLink('+ Nouvelle équipe')
                    ->type('name', 'duskTeam')
                    ->clickLink('Suivant')

                    ->type('firstname', 'm1')
                    ->type('lastname', 'm1')
                    ->type('email', 'm1@a.a')
                    ->type('phoneNumber', '9999999999')

                    ->clickLink('+ Ajouter un membre')

                    ->type('firstname', 'm2')
                    ->type('lastname', 'm2')
                    ->type('email', 'm2@a.a')
                    ->type('phoneNumber', '9999999999')

                    ->clickLink('Suivant')

                    ->type('nbMemberPerGroup', 1)
                    ->type('nbActivities', 1)

                    ->clickLink('Créer les groupes')

                    ->screenshot('groups')
                    // Assert
                    ->assertPathIs('/team');
        });
    }
}
