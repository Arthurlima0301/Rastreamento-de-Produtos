@extends('Layout.layout')

@section('title', 'Saídas')

@section('content')
    <x-error-message></x-error-message>


    <section class="flex gap-3 w-full"
        x-data='{
            allItems: @json($items),
            items: @json($items),
            search: "",
            selectedItems: [],

            searchItem() {
                if (this.search !== "") {
                     this.items = this.allItems.filter(item =>
                        item.insumo.nome.toLowerCase().includes(this.search.toLowerCase())
                    );
                } else {
                    this.items = this.allItems;
                }
            },

            selectItem(item) {
                const exists = this.selectedItems.some(i => i.id === item.id);

                if (!exists) {
                    this.selectedItems.push(item);
                } else {
                    this.selectedItems = this.selectedItems.filter(i => i.id !== item.id);
                }
            }
}'>

        <div>
            <x-card title="Criar Saída">
                <x-slot name="slot">
                    <input type="text" placeholder="Buscar item..." x-model="search" @input="searchItem()"
                        class="border-2 border-stroke p-2 rounded w-[400px]" />
                </x-slot>
            </x-card>



            <x-table>
                <x-slot name="header">
                    <th class="p-2">Código</th>
                    <th class="p-2">Descrição</th>
                    <th class="p-2">Item</th>
                    <th class="p-2">Unidade de Medida</th>
                    <th class="p-2">Quantidade</th>
                    <th class="p-2">Nota Fiscal</th>
                    <th class="p-2">Data</th>
                    <th class="p-2">Saldo</th>
                    <th class="p-2">Ações</th>
                </x-slot>

                <x-slot name="rows">
                    <!-- Loop through listed items -->
                    <template x-for="item in items" :key="item.id">
                        <tr class="hover:bg-stroke">
                            <td class="p-2 hobe"><span x-text="item.insumo.codigo_insumo"></span></td>
                            <td class="p-2"><span x-text="item.insumo.nome"></span></td>
                            <td class="p-2"><span x-text="item.numero"></span></td>
                            <td class="p-2"><span x-text="item.insumo.unidade_medida"></span></td>
                            <td class="p-2"><span x-text="item.quantidade"></span></td>
                            <td class="p-2"><span x-text="item.nota_fiscal.codigo_nf"></span></td>
                            <td class="p-2"><span x-text="item.nota_fiscal.data_emissao"></span></td>
                            <td class="p-2"><span x-text="item.saldo"></span></td>

                            <td class="p-2">
                                <button class="text-muted p-2 cursor-pointer rounded"
                                    :class="{
                                        'bg-primary': !selectedItems.some(i => i.id === item.id),
                                        'bg-secondary': selectedItems.some(i => i.id === item.id)
                                    }"
                                    @click="selectItem(item)">Selecionar</button>
                            </td>
                        </tr>
                    </template>

                </x-slot>
            </x-table>
        </div>

        @include('Components.selected-items-list')

    </section>
@endsection
