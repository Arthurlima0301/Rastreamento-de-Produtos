<div class="flex justify-between items-center w-full p-4 border-2 border-stroke shadow-md rounded-md">
    <div class="flex items-center gap-3">
        <button onclick="window.history.back()">
            <img src="{{ asset('/img/buttons/btn-return.svg') }}" class="h-9 cursor-pointer" alt="">
        </button>

        <h1 class="text-xl font-bold">{{ $title }}</h1>
    </div>

    <div>
        {{ $slot }}
    </div>
</div>
