<div class="max-h-[400px] w-full overflow-y-auto border-1 border-gray-300 rounded-lg shadow-sm">
    <table class="w-full text-center border-collapse">
        <thead class="sticky inset-0 bg-main text-muted">
            <tr class="text-md">
                {{ $header }}
            </tr>
        </thead>
        <tbody>
            @if($rows->isEmpty())
                <tr>
                    <td colspan="10" class="p-4">Nenhum registro encontrado.</td>
                </tr>
            @endif
            {{ $rows }}
        </tbody>
    </table>
</div>