<header class="w-full p-4 bg-main" x-data="{ menuOpen: false }">
    <button @click="menuOpen = !menuOpen" class="relative rounded-md p-2 bg-primary text-muted cursor-pointer">Menu</button>

    <x-menu></x-menu>
</header>
