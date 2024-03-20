<?php

namespace Tests\Browser;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AvailabilityTest extends DuskTestCase
{
    use DatabaseTruncation;

    protected array $tablesToTruncate = ['availabilities'];

    public function testCreateAvailability(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/association/availabilities/create')
                ->type('input[wire\\:model$="start_date"]', '11062050')
                ->type('input[wire\\:model$="end_date"]', '15062050')
                ->press('Create')
                ->waitForTextIn('h3', 'Created')
                ->assertSee('Edit Availability')
                ->assertValue('input[wire\\:model$="start_date"]', '2050-06-11')
                ->assertValue('input[wire\\:model$="end_date"]', '2050-06-15');
        });
    }

    public function testCreateWrongAvailability(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/association/availabilities/create')
                ->type('input[wire\\:model$="start_date"]', '11062050')
                ->type('input[wire\\:model$="end_date"]', '09062050')
                ->press('Create')
                ->waitForTextIn('p', 'The end date must be after the start date.')
                ->assertSee('The end date must be after the start date.');
        });
    }

    public function testEditAvailability(): void
    {
        $user = User::factory()->create();
        $availability = $user->availabilities()->saveMany(
            Availability::factory(1)->make()
        )->first();

        $this->browse(function (Browser $browser) use ($user, $availability) {
            $browser->loginAs($user)
                ->visit("/association/availabilities/{$availability->id}/edit")
                ->assertSee('Edit Availability')
                ->assertValue('input[wire\\:model$="start_date"]', $availability->start_date->format('Y-m-d'))
                ->assertValue('input[wire\\:model$="end_date"]', $availability->end_date->format('Y-m-d'))
                ->type('input[wire\\:model$="start_date"]', '11062050')
                ->type('input[wire\\:model$="end_date"]', '15062050')
                ->press('Save changes')
                ->waitForTextIn('h3', 'Saved')
                ->assertSee('Edit Availability')
                ->assertValue('input[wire\\:model$="start_date"]', '2050-06-11')
                ->assertValue('input[wire\\:model$="end_date"]', '2050-06-15');
        });
    }

    public function testEditWrongAvailability(): void
    {
        $user = User::factory()->create();
        $availability = $user->availabilities()->saveMany(
            Availability::factory(1)->make()
        )->first();

        $this->browse(function (Browser $browser) use ($user, $availability) {
            $browser->loginAs($user)
                ->visit("/association/availabilities/{$availability->id}/edit")
                ->assertSee('Edit Availability')
                ->assertValue('input[wire\\:model$="start_date"]', $availability->start_date->format('Y-m-d'))
                ->assertValue('input[wire\\:model$="end_date"]', $availability->end_date->format('Y-m-d'))
                ->type('input[wire\\:model$="start_date"]', '11062050')
                ->type('input[wire\\:model$="end_date"]', '09062050')
                ->press('Save changes')
                ->waitForTextIn('p', 'The end date must be after the start date.')
                ->assertSee('The end date must be after the start date.');
        });
    }
}
