<?php

namespace App\Livewire;

use Livewire\Component;
use App\Cart;

class MobileVerify extends Component
{
    public $cartItems;
    public function decrementCart()
    {
        dd('hello');
    }
    public function render()
    {
        $this->cartItems =  Cart::content();
        return view('livewire.mobile-verify');
    }
}
