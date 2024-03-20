<?php

namespace Tests\Browser;

use App\Enums\Association;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseTruncation;

    protected array $tablesToTruncate = ['users'];

    public function testRegistration(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/association/register')
                ->type('input[wire\\:model$="legal_name"]', 'John Doe')
                ->type('input[wire\\:model$="date_of_birth"]', '08061990')
                ->type('input[wire\\:model$="phone"]', '0612345678')
                ->type('input[wire\\:model$="email"]', 'john.doe@example.com')
                ->type('input[wire\\:model$="password"]', 'Welkom01!')
                ->type('input[wire\\:model$="passwordConfirmation"]', 'Welkom01!')
                ->click('button[wire\\:target=dispatchFormEvent]')
                ->waitFor('input[wire\\:model$="alias"]')
                ->type('input[wire\\:model$="alias"]', 'Spiderman')
                ->select('select[wire\\:model$="association"]', Association::Hero->value)
                ->type('textarea[wire\\:model$="backstory"]', 'This is a backstory')
                ->type('textarea[wire\\:model$="motivation"]', 'This is my motivation to become a superhero')
                ->click('button[type=submit]')
                ->waitFor('a[href*="/association/profiles/"]')
                ->assertSee('Profile');
        });
    }
}
