<?php

namespace Tests\Browser;

use App\Models\AttackType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AttackTypeTest extends DuskTestCase
{
    use DatabaseTruncation;

    protected array $tablesToTruncate = ['attack_types'];

    public function testCreateAttackType(): void
    {
        $user = User::factory()->asHero()->create();
        AttackType::factory(2)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/association/attack-types/create')
                ->select('select[wire\\:model$="effective_against"]', '1')
                ->select('select[wire\\:model$="weak_against"]', '2')
                ->type('input[wire\\:model$="name"]', 'Cool Attack')
                ->type('input[wire\\:model$="damage"]', '10')
                ->type('textarea[wire\\:model$="description"]', 'This is a very cool attack!')
                ->press('Create')
                ->waitForTextIn('h3', 'Created')
                ->assertSee('Edit Attack Type')
                ->assertValue('input[wire\\:model$="name"]', 'Cool Attack')
                ->assertValue('input[wire\\:model$="damage"]', '10')
                ->assertValue('textarea[wire\\:model$="description"]', 'This is a very cool attack!');
        });
    }

    public function testCreateWrongAttackType(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/association/attack-types/create')
                ->press('Create')
                ->pause(1000)
                ->assertSee('Create Attack Type');
        });
    }

    public function testEditAttackType(): void
    {
        AttackType::factory(2)->create();
        $attackType = AttackType::factory()->create();

        $this->browse(function (Browser $browser) use ($attackType) {
            $browser->visit("/association/attack-types/{$attackType->id}/edit")
                ->assertSee('Edit Attack Type')
                ->assertValue('input[wire\\:model$="name"]', $attackType->name)
                ->assertValue('input[wire\\:model$="damage"]', $attackType->damage)
                ->assertValue('textarea[wire\\:model$="description"]', $attackType->description)
                ->select('select[wire\\:model$="effective_against"]', '1')
                ->select('select[wire\\:model$="weak_against"]', '2')
                ->type('input[wire\\:model$="name"]', 'Cool Attack')
                ->type('input[wire\\:model$="damage"]', '10')
                ->type('textarea[wire\\:model$="description"]', 'This is a very cool attack!')
                ->press('Save changes')
                ->waitForTextIn('h3', 'Saved')
                ->assertSee('Edit Attack Type')
                ->assertValue('select[wire\\:model$="effective_against"]', '1')
                ->assertValue('select[wire\\:model$="weak_against"]', '2')
                ->assertValue('input[wire\\:model$="name"]', 'Cool Attack')
                ->assertValue('input[wire\\:model$="damage"]', '10')
                ->assertValue('textarea[wire\\:model$="description"]', 'This is a very cool attack!');
        });
    }

    public function testEditWrongAttackType(): void
    {
        $attackType = AttackType::factory()->create();

        $this->browse(function (Browser $browser) use ($attackType) {
            $browser->visit("/association/attack-types/{$attackType->id}/edit")
                ->press('Save changes')
                ->pause(1000)
                ->assertSee('Edit Attack Type');
        });
    }
}
