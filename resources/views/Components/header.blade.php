<flux:header class="dark:bg-zinc-900 p-4" x-data>
    <x-menu></x-menu>
    <flux:spacer />
    <flux:dropdown>
        <x-button icon="ellipsis-horizontal" />

        <flux:menu>
            <flux:menu.item 
                class="cursor-pointer" 
                icon="moon" 
                x-on:click="$flux.appearance = $flux.appearance === 'light' ? 'dark' : 'light'"
            >
                Trocar Tema
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</flux:header>
