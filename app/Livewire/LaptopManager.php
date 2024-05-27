<?php

namespace App\Livewire;

use Livewire\Component;
use App\routes;

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
    public function save()
    {
        $queryParameters = http_build_query(['laptops' => $this->laptops]);
        $url = url('savelaptop'). '?' . $queryParameters;

        return redirect()->to($url);
    }
    public function render()
    {
        return view('livewire.laptop-manager');
    }
}
