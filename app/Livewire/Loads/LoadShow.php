<?php

namespace App\Livewire\Loads;

use App\Models\Load;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes da Carga')]
class LoadShow extends Component
{
    public Load $load;

    public string $page = 'rolls';

    /**
     * Mount the component with the load id.
     */
    public function mount(Load $load): void
    {
        $this->load = $load->load('rolls', 'pallets');
    }

    /**
     * Render the load detail page.
     */
    public function render(): View
    {
        $totalRolls = $this->load->rolls->count();
        $totalPallets = $this->load->pallets->count();

        return view('livewire.loads.load-show', compact('totalRolls', 'totalPallets'));
    }

    public function toggleTab(string $tab): void
    {
        $this->page = $tab;
    }
}
