<div class="w-full">
    <x-card title="Detalhes do Insumo" />
    
    <p><strong>Código:</strong> {{ $supply->supply_code }}</p>
    <p><strong>Nome:</strong> {{ $supply->name }}</p>
    <p><strong>Unidade de Medida:</strong> {{ $supply->unit_of_measure }}</p>
    <p><strong>Cliente:</strong> {{ $supply->client->name }}</p>
</div>
