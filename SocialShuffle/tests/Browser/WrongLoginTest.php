<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WrongLoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     */
    public function testWrongLogin(): void
    {
        // Arrange
        $user = User::factory()->create([
            'username' => 'jDoe',
            'email' => 'johndoe@gmail.com',
            'password' => bcrypt('0000'),
            'admin' => false,
        ]);

        $this->browse(function (Browser $browser) use($user) {
            $browser->visit('/')

                    // Login
                    ->clickLink('Se connecter')
                    ->type('email', 'blabla')
                    ->type('password', 'Mauvais mot de passe')
                    ->click('@login-button');
                    
                    // ->assertSee('jDoe');
        });
    }
}
