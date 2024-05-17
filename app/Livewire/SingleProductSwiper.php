<?php

namespace App\Livewire;

use Livewire\Component;

class SingleProductSwiper extends Component
{
    public $product;
    public $sizes;
    public $color_photo = null;

    
    protected $listeners = ['productColorPhoto'];
    public function render()
    {
        return view('livewire.single-product-swiper')->layout('front-end.master');;
    }

    public function productColorPhoto($color_photo)
    {
        $this->color_photo = $color_photo;
        // $this->dispatch('loadMyJs');
    }
}
