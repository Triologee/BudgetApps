<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Item;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new-budget');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $grand_total = 0;
        foreach ($request->budgetItems as $item) {
            $item_total = $item['item_price'] * $item['item_quantity'];

            $grand_total = number_format($grand_total + $item_total, 2);
        }

        $application = Application::create([
            'title' => $request->application_title,
            'justification' => $request->justification,
            'faculty' => $user->faculty,
            'budget_type' => $request->budget_type,
            'usage_type' =>  $request->usage_type,
            'total' => $grand_total,
            'general_ledger' => $request->general_ledger,
            'status' => "Pending"
        ]);

        foreach ($request->budgetItems as $item) {
            $item_total = $item['item_price'] * $item['item_quantity'];

            $itemModel = Item::create([
                'app_id' => $application->id,
                'item_name' => $item['item_name'],
                'item_type' => $item['item_type'],
                'item_justification' => $item['item_justification'],
                'item_price' => $item['item_price'],
                'item_quantity' => $item['item_quantity'],
                'item_unit_of_measurement' => $item['item_unit_of_measurement'],
                'item_total' => $item_total
            ]);
        }

        return redirect('dashboard')->with(['success' => 'Budget Application successfully created!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
