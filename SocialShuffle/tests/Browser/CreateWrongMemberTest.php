<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateWrongMemberTest extends DuskTestCase
{
    use DatabaseMigrations;


    /**
     * A Dusk test example.
     */
    public function tesCreateWrongMember(): void
    {
        // Arrange
        $user = User::factory()->create([
            'username' => 'jDoe',
            'email' => 'johndoe@gmail.com',
            'password' => bcrypt('0000'),
            'admin' => false,
        ]);

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

                    // Add member with wrong information
                    ->type('firstname', '@@@@')
                    ->type('lastname', '&&&&')
                    ->type('email', 'Not an email')
                    ->type('phone_number', 'Not a phone number')
                    ->click('@add-member')

                    // Assert that the expected error messaged are displayed
                    ->assertSee('Les informations que vous avez entrés ne sont pas valides')
                    ->assertSee('Ce champ doir contenir un adresse Email valide (ex. exemple@exemple.com)');
        });
    }
}
