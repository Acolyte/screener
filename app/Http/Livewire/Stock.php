<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Stock extends Component
{
    /** @var string */
    public $position;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function render()
    {
        return view('livewire.stock');
    }
}
