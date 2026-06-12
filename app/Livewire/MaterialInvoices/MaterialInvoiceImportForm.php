<?php

namespace App\Livewire\MaterialInvoices;

use App\Rules\MaterialInvoices\ValidXMLMaterialInvoice;
use App\Services\MaterialInvoices\ImportMaterialInvoiceFromXMLService;
use Livewire\Component;
use Livewire\WithFileUploads;

class MaterialInvoiceImportForm extends Component
{
    use WithFileUploads;

    public $xml_file;

    public function import(ImportMaterialInvoiceFromXMLService $importService)
    {
        $this->validate([
            'xml_file' => ['required', 'file', 'max:5120', new ValidXMLMaterialInvoice],
        ], [
            'xml_file.required' => 'Um arquivo é obrigatório.',
            'xml_file.file' => 'Envie um arquivo válido. O formato do arquivo deve ser obrigatoriamente XML.',
            'xml_file.max' => 'O arquivo deve ter no máximo 5MB.',
        ]);

        try {
            $importService->import($this->xml_file);
        } catch (\Throwable $e) {
            return redirect()->route('material-invoices.index')->with('error', 'Erro ao importar nota fiscal: '.$e->getMessage());
        }

        return redirect()->route('material-invoices.index')->with('success', 'Nota fiscal importada com sucesso!');
    }

    public function render()
    {
        return view('livewire.material-invoices.material-invoice-import-form');
    }
}
