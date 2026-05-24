@props([
    'itemId',
    'supplyName',
])

<button type="button" class="rounded p-2 text-md"
    x-data="{ itemId: {{ $itemId }}, selectedItemIds: window.dispatchSelectedItemIds ??= [] }"
    x-on:item-selected.window="
        const selectedItemId = Number($event.detail.itemId);

        if (!selectedItemIds.includes(selectedItemId)) {
            selectedItemIds.push(selectedItemId);
        }
    "
    x-on:item-removed.window="
        const removedItemId = Number($event.detail.itemId);

        selectedItemIds = selectedItemIds.filter((selectedItemId) => selectedItemId !== removedItemId);
        window.dispatchSelectedItemIds = selectedItemIds;
    "
    wire:click="$dispatch('item-selected', { itemId: {{ $itemId }}, itemSupplyName: @js($supplyName) })"

    :class="selectedItemIds.includes(itemId) ? 'bg-gray-200 text-gray-700' : 'bg-blue-500 text-white'">
    <span x-text="selectedItemIds.includes(itemId) ? 'Selecionado' : 'Selecionar'"></span>
</button>
