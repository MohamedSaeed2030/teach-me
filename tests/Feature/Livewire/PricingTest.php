<?php

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Pricing;





// it('has pricing page', function () {
//     $response = $this->get('/pricing');

//     $response->assertStatus(200);
// });


beforeEach(function () {


    $this->pricing=config('stripe.pricing');

});

it('showa the stripe price IDs', function () {

    Livewire::test(Pricing::class)
    ->assertSee([
        $this->pricing['monthly'],
        $this->pricing['yearly'],
        $this->pricing['lifetime'],
    ]);
}
);


it('redirects to the register page when not signed in', function () {
    Livewire::test(Pricing::class)
    ->call('checkout',$this->pricing['monthly'])
    ->assertRedirect('register');

});

it('can create subscriptions', function () {
    $user=User::factory()->create();
    $product= config('stripe.product');
    $user->newSubscription($product,$this->pricing['monthly'])->create('pm_card_visa');
    expect($user->subscribed($product, $this->pricing['monthly']))->toBeTrue();
});



// it('can perform one off payments', function () {

//     $user=User::factory()->create();
//     $product= config('stripe.product');

//     $user->checkout([$this->pricing['lifetime'] => 1],[
//         'success_url'=> route('courses.index'),
//         'cancel_url'=> route('courses.index'),
//     ])->create('pm_card_visa');
//     expect($user->subscribed($product, $this->pricing['lifetime']))->toBeTrue();

// });


