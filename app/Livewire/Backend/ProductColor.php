<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProductColor extends Component
{
    use WithFileUploads;
    public $i = 1;
    public $inputs = [];

    public $color_name = [];
    public $color_photo = [];
    public $color_price = [];
    public $color_quantity = [];

    public function add()
    {
        $this->i++;
        array_push($this->inputs, $this->i);
    }

    public function remove($key)
    {
        unset($this->inputs[$key]);
    }

    public function updatedColorPhoto($key)
    {
        
        $this->validate([
            'color_photo.'.$key => 'image|max:1024',
        ]);
        $file = json_encode($key);
        $this->dispatch('fileUploaded', $file);
    }
    
    public function render()
    {
        $inputs = $this->inputs;
        return view('livewire.backend.product-color', [
            'inputs' => $inputs
        ])->layout('back-end.admin');
    }
}
