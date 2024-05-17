<?php

namespace App\Livewire;

use Livewire\Component;
use App\Cart;

class VerifyMobile extends Component
{
    public $cartItems;
    protected $listeners = ['cartComponent'];
    
    public function cartComponent()
    {
        // reload component 
    }
    public function decrementCart($product_id)
    {
        $cart = Cart::content()[$product_id];
        $qty = $cart['qty'] - 1;
    
        // Ensure the quantity does not go below 1
        $qty = max(1, $qty);
    
        Cart::update($product_id, $qty);
        $this->cartItems = Cart::content();
        $this->dispatch('footerComponent');
    }
    
    public function incrementCart($product_id)
    {
        $cart = Cart::content()[$product_id];
        $qty = $cart['qty'] + 1;
    
        Cart::update($product_id, $qty);
        $this->cartItems = Cart::content();
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
        $this->cartItems =  Cart::content();
        return view('livewire.verify-mobile')->layout('front-end.master');;
    }
}
