 <nav class="absolute z-10 w-62 p-2 text-xl bg-surface shadow-md" x-show="menuOpen">
     <ul>
         <li>
             <a href="{{ route('invoices.index') }}" class="block p-2 w-full hover:bg-secondary">Notas</a>
         </li>

         <li class="w-full">
             <a href="{{ route('items.index') }}" class="block p-2 w-full hover:bg-secondary">Itens</a>
         </li>

         <li class="w-full">
             <a href="{{ route('supplies.index') }}" class="block p-2 w-full hover:bg-secondary">Insumos</a>
         </li>

        <li class="w-full">
            <a href="{{ route('dispatches.index') }}" class="block p-2 w-full hover:bg-secondary">Saídas</a>
        </li>
     </ul>
 </nav>
