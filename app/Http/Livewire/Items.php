<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Items extends Component
{
    public $budgetItems = [];
    public $justificationItems = [];

    public function render()
    {
        info($this->budgetItems);

        return view('livewire.items');
    }

    public function mount()
    {
        $this->justificationItems = [['New Purchase', 'Replacing Old Asset']];
        $this->budgetItems = [
            [
            'item_name' => '', 
            'item_type' => 'Asset',
            'item_justification' => 'New Purchase',
            'item_price' => '',
            'item_quantity' => '',
            'item_unit_of_measurement' => '',
            'item_total' => '',
            ]
        ];

    }

    public function addItem()
    {
        $this->justificationItems[] = ['New Purchase', 'Replacing Old Asset'];
        $this->budgetItems[] = [
            'item_name' => '', 
            'item_type' => 'Asset',
            'item_justification' => 'New Purchase',
            'item_price' => '',
            'item_quantity' => '',
            'item_unit_of_measurement' => '',
            'item_total' => '',
            ];
    }

    public function removeItem($index)
    {
        unset($this->budgetItems[$index]);
        $this->budgetItems = array_values($this->budgetItems);
    }

    public function calculateTotal($index)
    {
        $this->budgetItems[$index]['item_price'] = number_format((float)($this->budgetItems[$index]['item_price']), 2);
        $this->budgetItems[$index]['item_total'] = number_format((float)($this->budgetItems[$index]['item_price']) * (float)($this->budgetItems[$index]['item_quantity']), 2);
    }

    public function updateJustification($index)
    {
        if ($this->budgetItems[$index]['item_type'] == "Service") {
            $this->justificationItems[$index] = ['Maintenance', 'Training', 'Consultation', 'Honorarium', 'Reimbursement', 'Others'];
        } else {
            $this->justificationItems[$index] = ['New Purchase', 'Replacing Old Asset'];
        }
    }

    

}
