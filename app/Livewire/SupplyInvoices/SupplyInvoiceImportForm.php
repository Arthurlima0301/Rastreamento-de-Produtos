<?php

namespace App\Livewire\SupplyInvoices;

use App\Rules\SupplyInvoices\ValidXMLSupplyInvoice;
use App\Services\SupplyInvoices\ImportSupplyInvoiceFromXMLService;
use Livewire\Component;
use Livewire\WithFileUploads;

class SupplyInvoiceImportForm extends Component
{
    use WithFileUploads;

    public $xml_file;

    public function import(ImportSupplyInvoiceFromXMLService $importService)
    {
        $this->validate([
            'xml_file' => ['required', 'file', 'max:5120', new ValidXMLSupplyInvoice],
        ], [
            'xml_file.required' => 'Arquivo XML é obrigatório.',
            'xml_file.file' => 'Envie um arquivo válido.',
            'xml_file.max' => 'O arquivo deve ter no máximo 5MB.',
        ]);

        try {
            $importService->import($this->xml_file);
        } catch (\Throwable $e) {
            return redirect()->route('supply-invoices.index')->with('error', 'Erro ao importar nota fiscal: '.$e->getMessage());
        }

        return redirect()->route('supply-invoices.index')->with('success', 'Nota fiscal importada com sucesso!');
    }

    public function render()
    {
        return view('livewire.supply-invoices.supply-invoice-import-form');
    }
}
