@props([
    'supplyItemId',
    'supplyName',
])

<button type="button" class="rounded p-2 text-md"
    x-data="{ supplyItemId: {{ $supplyItemId }}, selectedSupplyItemIds: window.dispatchSelectedSupplyItemIds ??= [] }"
    x-on:supply-item-selected.window="
        const selectedSupplyItemId = Number($event.detail.supplyItemId);

        if (!selectedSupplyItemIds.includes(selectedSupplyItemId)) {
            selectedSupplyItemIds.push(selectedSupplyItemId);
        }
    "
    x-on:supply-item-removed.window="
        const removedSupplyItemId = Number($event.detail.supplyItemId);

        selectedSupplyItemIds = selectedSupplyItemIds.filter((selectedSupplyItemId) => selectedSupplyItemId !== removedSupplyItemId);
        window.dispatchSelectedSupplyItemIds = selectedSupplyItemIds;
    "
    wire:click="$dispatch('supply-item-selected', { supplyItemId: {{ $supplyItemId }}, supplyName: @js($supplyName) })"

    :class="selectedSupplyItemIds.includes(supplyItemId) ? 'bg-gray-200 text-gray-700' : 'bg-blue-500 text-white'">
    <span x-text="selectedSupplyItemIds.includes(supplyItemId) ? 'Selecionado' : 'Selecionar'"></span>
</button>
