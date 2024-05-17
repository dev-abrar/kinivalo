<?php

namespace App\Livewire;

use App\Cart;
use Livewire\Component;

class FooterCard extends Component
{
    public $cartItems;
    protected $listeners = ['footerComponent'];

    public function footerComponent()
    {
        // reload component 
    }

    
    public function removeItem($product_id)
    {
        Cart::remove($product_id);
        $this->cartItems =  Cart::content();
        $this->dispatch('cartComponent');
    }

    public function render()
    {
        $this->cartItems = Cart::content();
        return view('livewire.footer-card')->layout('front-end.master');;
    }
}
