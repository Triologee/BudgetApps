<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Application;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class Items extends Component
{
    public $budgetItems = [];
    public $justificationItems = [];
    public $app_id;


    public $application_title;
    public $justification;
    public $budget_type;
    public $usage_type;
    public $general_ledger;
    public $edit;

    public function render()
    {
        info($this->budgetItems);
        return view('livewire.items');
    }

    public function mount($app_id)
    {
        if ($app_id == "N/A") {
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
                ],
            ];
            $this->edit = false;

        } else {
            $applications = DB::table('applications')->where('id', $app_id)->get();

            if ((auth()->user()->faculty !== $applications[0]->faculty)) {
                return redirect('dashboard');
            } else {
                $this->application_title = $applications[0]->title;
                $this->justification = $applications[0]->justification;
                $this->budget_type = $applications[0]->budget_type;
                $this->usage_type = $applications[0]->usage_type;
                $this->general_ledger = $applications[0]->general_ledger;

                $items = DB::table('items')->where('app_id', $app_id)->get();
                foreach ($items as $item) {
                    // $this->budgetItems[$index] = $item;
                    // if ($item->item_type == "Service") {
                    //     $this->justificationItems[$index] = ['Maintenance', 'Training', 'Consultation', 'Honorarium', 'Reimbursement', 'Others'];
                    // } else {
                    //     $this->justificationItems[$index] = ['New Purchase', 'Replacing Old Asset'];
                    // }
                    // $index++;

                    if ($item->item_type == "Service") {
                        $this->justificationItems[] = ['Maintenance', 'Training', 'Consultation', 'Honorarium', 'Reimbursement', 'Others'];
                    } else {
                        $this->justificationItems[] = ['New Purchase', 'Replacing Old Asset'];
                    }
                    $this->budgetItems[] = [
                        'item_name' => $item->item_name, 
                        'item_type' => $item->item_type,
                        'item_justification' => $item->item_justification,
                        'item_price' => $item->item_price,
                        'item_quantity' => $item->item_quantity,
                        'item_unit_of_measurement' => $item->item_unit_of_measurement,
                        'item_total' => $item->item_total,
                        ];
                }
                $this->edit = true;
                $this->app_id = $app_id;
            }

            
        }
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
        // $this->budgetItems[$index]['item_price'] = number_format((float)($this->budgetItems[$index]['item_price']), 2);
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
