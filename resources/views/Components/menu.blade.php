<flux:dropdown position="bottom" align="end">
    <x-button icon="bars-3" @click="menuOpen = !menuOpen">Menu</x-button>

    <flux:navmenu>
        <flux:menu.group heading="Geral">
            <flux:navmenu.item href="{{ route('clients.index') }}" icon="user">Clientes</flux:navmenu.item>
        </flux:menu.group>



        <flux:menu.group heading="Bobinas e Materiais">
            <flux:navmenu.item href="{{ route('orders.index') }}" icon="clipboard-document-list">Ordem de Corte</flux:navmenu.item>
        </flux:menu.group>



        <flux:menu.group heading="Insumos">
            <flux:navmenu.item href="{{ route('invoices.index') }}" icon="document-text">Notas Fiscais</flux:navmenu.item>
            <flux:navmenu.item href="{{ route('items.index') }}" icon="rectangle-stack">Itens</flux:navmenu.item>
            <flux:navmenu.item href="{{ route('supplies.index') }}" icon="cube">Insumos</flux:navmenu.item>
            <flux:navmenu.item href="{{ route('dispatches.index') }}" icon="truck">Saídas</flux:navmenu.item>
        </flux:menu.group>

    </flux:navmenu>
</flux:dropdown>
