<?php

namespace App\Livewire;

use Livewire\Component;

class LaptopManager extends Component
{
    public $laptops = [];
    public $newLaptop = '';

    public function addLaptop()
    {
        if (!empty($this->newLaptop)) {
            $this->laptops[] = $this->newLaptop;
            $this->newLaptop = '';
        }
    }
    public function removeLaptop($index)
    {
        unset($this->laptops[$index]);
        $this->laptops = array_values($this->laptops);
    }
    // public function save(){
    //     app('App\Http\Controllers\LaptopController')->Create($this->laptops);
    // }
    public function render()
    {
        return view('livewire.laptop-manager');
    }
}
