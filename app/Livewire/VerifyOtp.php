<?php

namespace App\Livewire;

use App\Cart;
use Livewire\Component;

class VerifyOtp extends Component
{
    public $mobileNumber;
    public $cartItems;
    protected $listeners = ['cartComponent'];
    
    public function cartComponent()
    {
        // reload component 
    }

    public function decrement($product_id)
    {
        $cart = Cart::find($product_id);
        $qty =$cart['qty'] - 1;
        if ($qty < 1) {
            $qty = 1;
        }
        Cart::update($product_id, $qty);
        $this->cartItems =  Cart::content();
        $this->dispatch('footerComponent');
    }
    
    public function increment($product_id)
    {
        $cart = Cart::find($product_id);
        $qty =$cart['qty'] + 1;
       
        Cart::update($product_id, $qty);
        $this->cartItems =  Cart::content();
        $this->dispatch('footerComponent');
    }

    public function removeItem($product_id)
    {
        Cart::remove($product_id);
        $this->cartItems =  Cart::content();
        $this->dispatch('footerComponent');
    }

    public function render()
    {
        $this->cartItems = Cart::content();
        return view('livewire.verify-otp')->layout('front-end.master');;
    }
}
