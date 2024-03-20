<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function testLogin(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/association/login')
                ->type('input[type=email]', $user->email)
                ->type('input[type=password]', 'password')
                ->click('button[type=submit]')
                ->waitFor('a[href$="/association/profiles/' . $user->id . '"]')
                ->assertSee('Profile');
        });
    }
}
