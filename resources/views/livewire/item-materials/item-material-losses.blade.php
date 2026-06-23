<div class="w-full">
    <flux:card>
        <flux:heading class="mb-4" size="xl">Calcular Perdas do Item Material</flux:heading>

        <flux:separator horizontal variant="subtle" class="my-2" />
        <div class="flex gap-4 mb-2">
            <p><strong>Entrou: </strong> {{ $itemMaterial->formatted_total_weight }}</p>

            <flux:separator vertical variant="subtle" class="my-2" />

            <p><strong>Previsão: </strong> {{ number_format($itemMaterial->total_weight - $wasteQuantity, 2, ',', '.') }}</p>

            <flux:separator vertical variant="subtle" class="my-2" />

            <p><strong>Perca: </strong> {{ number_format($lossPercentage, 2, ',', '.') }}%</p>
            <p><strong>Aparas: </strong> {{ number_format($wasteQuantity, 2, ',', '.') }}</p>
        </div>
        <flux:separator horizontal variant="subtle" class="my-2" />

        <form wire:submit.prevent="calc">
            <x-input label="Quantidade de Pallets" type="number" placeholder="Digite a quantidade" min="0"
                wire:model="palletQuantity" />

            @error('palletQuantity')
                <p class="text-red-500">{{ $message }}</p>
            @enderror

            <x-button type="submit" variant="primary" class="w-full my-2">Calcular Perda</x-button>
        </form>
    </flux:card>
</div>
