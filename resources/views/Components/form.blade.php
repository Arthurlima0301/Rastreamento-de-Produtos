<form action="{{ $action }}" method="{{ $method }}"
    class="flex flex-col gap-6 justify-center items-center h-[40rem] w-full bg-surface rounded-lg shadow-md border-2 border-stroke"
>
    @csrf

    <h1 class="text-[30px] font-bold ">{{ $title ?? 'Formulário' }}</h1>

    <div class="flex flex-col gap-4">
        {{ $slot }}
    </div>

    <button type="submit" class="min-w-[300px] bg-primary text-muted p-3 rounded-md cursor-pointer">
        {{ $buttonText ?? 'Enviar' }}
    </button>
</form>
