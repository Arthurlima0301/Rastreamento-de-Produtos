<?php

namespace App\Livewire\Items;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Items')]
class ItemIndex extends Component
{
    public function render()
    {
        return view('livewire.items.item-index');
    }
}
