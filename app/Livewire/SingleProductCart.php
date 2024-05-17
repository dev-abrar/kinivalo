<?php

namespace App\Livewire;

use App\Cart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SingleProductCart extends Component
{
    public $product;
    public $sizes;
    public $product_price;
    public $qty = 1;

    //inputs
    public $color_id = null;
    public $color_name = null;
    public $color_price = 0;
    public $sizeValue = null;
    public $color_photo = null;

    //message
    public $colorMessage;

    public function getProductColorsProperty()
    {
        return DB::table('product_color')
            ->where('product_id', $this->product->id)
            ->get();
    }

    public function render()
    {
        $data['productColors'] = $this->productColors;
        $data['shareLinks'] = \Share::page(url("product/{$this->product->slug}"), $this->product->title)
                    ->facebook()
                    ->twitter()
                    ->linkedin()
                    ->whatsapp();

        return view('livewire.single-product-cart', $data)->layout('front-end.master');;
    }

    public function DecrementFunction()
    {
        if ($this->qty > 1) {
            $this->qty--;
        } else {
            $this->qty = 1;
        }
    }
    public function IncrementFunction()
    {
        $this->qty++;
    }

    public function color($color_id)
    {
        $color = DB::table('product_color')
            ->where('product_id', $this->product->id)
            ->where('id', $color_id)
            ->first();

        $this->color_id = $color->id;
        $this->color_price = $color->color_price;
        $this->color_name = $color->color_name;
        $this->product_price = $color->color_price;
        $this->color_photo = asset('image/color_photo/' . $color->color_photo);

        $this->dispatch('productColorPhoto', $this->color_photo);
    }

    public function productColorPhoto($color_photo)
    {
        $this->color_photo = $color_photo;
        // $this->dispatch('loadMyJs');
    }
    
    public function size($size)
    {
        $this->sizeValue = $size;
    }

    public function addToCartWithBuy()
    {
        
        if (count($this->productColors) > 0) {
            if ($this->color_id != null) {
                Cart::add([
                    'id' => $this->product->id,
                    'name' => $this->product->title,
                    'qty' => $this->qty,
                    'price' => $this->color_price,
                    'options' => ['color' => $this->color_id, 'size' => $this->sizeValue],
                ]);
                
                $this->dispatch('cartComponent');
                $this->dispatch('footerComponent');
                return redirect('cart');
            } else {
                $this->colorMessage = 'আপনার পছন্দের যেকোনো একটি কালার ক্লিক করে কালার সিলেক্ট করুন';
            }
        } else {
            Cart::add([
                'id' => $this->product->id,
                'name' => $this->product->title,
                'qty' => $this->qty,
                'price' => $this->product->sprice,
                'options' => ['color' => $this->color_id, 'size' => $this->sizeValue],
            ]);
            

            $this->dispatch('cartComponent');
            $this->dispatch('footerComponent');
            return redirect('cart');
        }

 
    }

    public function addToCart()
    {
        if (count($this->productColors) > 0) {
            if ($this->color_id != null) {
                Cart::add([
                    'id' => $this->product->id,
                    'name' => $this->product->title,
                    'qty' => $this->qty,
                    'price' => $this->color_price,
                    'options' => ['color' => $this->color_id, 'size' => $this->sizeValue],
                ]);
                
                $this->dispatch('cartComponent');
                $this->dispatch('footerComponent');
            } else {
                $this->colorMessage = 'আপনার পছন্দের যেকোনো একটি কালার ক্লিক করে কালার সিলেক্ট করুন';
            }
        } else {
            Cart::add([
                'id' => $this->product->id,
                'name' => $this->product->title,
                'qty' => $this->qty,
                'price' => $this->product->sprice,
                'options' => ['color' => $this->color_id, 'size' => $this->sizeValue],
            ]);
            

            $this->dispatch('cartComponent');
            $this->dispatch('footerComponent');
        }

    }
}
