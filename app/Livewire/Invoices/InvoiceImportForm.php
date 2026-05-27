<?php

namespace App\Livewire\Invoices;

use App\Rules\Invoices\ValidXMLInvoice;
use App\Services\Invoices\ImportInvoiceFromXMLService;
use Livewire\Component;
use Livewire\WithFileUploads;

class InvoiceImportForm extends Component
{
    use WithFileUploads;

    public $xml_file;

    public function import(ImportInvoiceFromXMLService $importService)
    {
        $this->validate([
            'xml_file' => ['required', 'file', 'max:5120', new ValidXMLInvoice],
        ], [
            'xml_file.required' => 'Arquivo XML é obrigatório.',
            'xml_file.file' => 'Envie um arquivo válido.',
            'xml_file.max' => 'O arquivo deve ter no máximo 5MB.',
        ]);

        try {
            $importService->import($this->xml_file);
        } catch (\Throwable $e) {
            return redirect()->route('invoices.index')->with('error', 'Erro ao importar nota fiscal: '.$e->getMessage());
        }

        return redirect()->route('invoices.index')->with('success', 'Nota fiscal importada com sucesso!');
    }

    public function render()
    {
        return view('livewire.invoices.invoice-import-form');
    }
}
