<flux:dropdown position="bottom" align="end">
    <x-button icon="bars-3" @click="menuOpen = !menuOpen">Menu</x-button>

    <flux:menu>
        <flux:menu.group heading="Geral">
            <flux:menu.item href="{{ route('clients.index') }}" icon="user">Clientes</flux:menu.item>
            <flux:menu.item href="{{ route('machines.index') }}" icon="cog">Máquinas</flux:menu.item>
        </flux:menu.group>
        <flux:menu.group heading="Material e Bobinas">
            <flux:menu.item href="{{ route('orders.index') }}" icon="clipboard">Ordens de Corte</flux:menu.item>
            <flux:menu.item href="{{ route('material-invoices.index') }}" icon="document-text">Notas Fiscais
            </flux:menu.item>
            <flux:menu.item href="{{ route('item-materials.index') }}" icon="rectangle-stack">Itens
            </flux:menu.item>
            <flux:menu.item href="{{ route('loads.index') }}" icon="inbox-stack">Cargas
            </flux:menu.item>
            <flux:menu.item href="{{ route('rolls.index') }}" icon="circle-stack">Bobinas
            </flux:menu.item>
        </flux:menu.group>
        <flux:menu.group heading="Insumos">
            <flux:menu.item href="{{ route('supplies.index') }}" icon="cube">Insumos</flux:menu.item>
            <flux:menu.item href="{{ route('supply-invoices.index') }}" icon="document-text">Notas Fiscais  
            </flux:menu.item>
            <flux:menu.item href="{{ route('supply-items.index') }}" icon="rectangle-stack">Itens 
            </flux:menu.item>
       
        </flux:menu.group>
        <flux:menu.group heading="Relatórios">
            <flux:menu.item href="{{ route('dispatches.index') }}" icon="truck">Saídas</flux:menu.item>
        </flux:menu.group>
    </flux:menu>
</flux:dropdown>
