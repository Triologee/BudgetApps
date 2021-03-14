@if ($edit)
<form action="{{ route('applications.update') }}" method="POST">
<input type="hidden" name="app_id" value="{{$app_id}}"/>
@else
<form action="{{ route('applications.store') }}" method="POST">
@endif
    @csrf
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="bg-white rounded px-8 mb-4 flex flex-col my-2">
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="application_title">
                                    Application Title
                                </label>
                                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                                id="application_title" name="application_title" type="text" placeholder="Application Title" value="{{ $application_title }}" required>
                                <!-- <p class="text-red text-xs italic">Please fill out this field.</p> -->
                            </div>
                            <div class="md:w-1/2 px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="justification">
                                    Justification
                                </label>
                                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                                id="justification" name="justification" type="text" placeholder="Justification" value="{{ $justification }}" required>
                            </div>
                        </div>
                        <!-- <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3">
                            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                                Password
                            </label>
                            <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" id="grid-password" type="password" placeholder="******************">
                            <p class="text-grey-dark text-xs italic">Make it as long and as crazy as you'd like</p>
                            </div>
                        </div> -->
                        <div class="-mx-3 md:flex mb-2">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="budget_type">
                                    Budget Type
                                </label>
                                <div class="relative">
                                    <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" name="budget_type" id="budget_type" value="{{ $budget_type }}" required>
                                        <option>OCAR</option>
                                        <option>BM</option>
                                    </select>
                                    <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-1/2 px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="usage_type">
                                    Usage Type
                                </label>
                                <div class="relative">
                                    <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" name="usage_type" id="usage_type">
                                        <option>Procurement</option>
                                        <option>Payment</option>
                                    </select>
                                    <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="-mx-3 py-2 md:flex mb-2">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="budget_type">
                                    General Ledger
                                </label>
                                <div class="relative">
                                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                                    id="general_ledger" name="general_ledger" type="text" placeholder="General Ledger" value="{{ $general_ledger }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@foreach ($budgetItems as $index => $budgetItem)
        <div class="py-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="bg-white rounded px-8 mb-4 flex flex-col my-2">
                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="item_name">
                                        Item Name
                                    </label>
                                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="budgetItems[{{$index}}][item_name]"
                                    name="budgetItems[{{$index}}][item_name]"
                                            wire:model="budgetItems.{{$index}}.item_name" type="text" placeholder="Item Name" required>
                                    <!-- <p class="text-red text-xs italic">Please fill out this field.</p> -->
                                </div>
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="item_type">
                                        Type
                                    </label>
                                    <div class="relative">
                                        <select class="select_item_type block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" id="budgetItems[{{$index}}][item_type]"
                                            name="budgetItems[{{$index}}][item_type]"
                                            wire:model="budgetItems.{{$index}}.item_type" wire:change="updateJustification({{$index}})"required>
                                            <option>Asset</option>
                                            <option>Service</option>
                                        </select>
                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                        </div>
                                    </div>
                                </div>
                                <div class="md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="item_justification">
                                        Justification
                                    </label>
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" id="budgetItems[{{$index}}][item_justification]"
                                            name="budgetItems[{{$index}}][item_justification]"
                                            wire:model="budgetItems.{{$index}}.item_justification" required>
                                            @foreach ($justificationItems[$index] as $indexx => $justification)
                                                <option>
                                                    {{ $justificationItems[$index][$indexx] }}
                                                </option>
                                            @endforeach


                                        </select>
                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="-mx-3 md:flex mb-2">
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="item_price">
                                        Price per unit (RM)
                                    </label>
                                    <input class="item_price appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="budgetItems[{{$index}}][item_price]"
                                            name="budgetItems[{{$index}}][item_price]"
                                            wire:model="budgetItems.{{$index}}.item_price" wire:change="calculateTotal({{$index}})" type="number" max="9999" placeholder="Price per Unit (RM)" required>
                                </div>
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="item_quantity">
                                        Quantity
                                    </label>
                                    <input class="item_quantity appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="budgetItems[{{$index}}][item_quantity]"
                                            name="budgetItems[{{$index}}][item_quantity]"
                                            wire:model="budgetItems.{{$index}}.item_quantity" wire:change="calculateTotal({{$index}})" type="number" placeholder="Quantity" required>
                                </div>
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="item_unit_of_measurement">
                                        Unit of Measurement
                                    </label>
                                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="budgetItems[{{$index}}][item_unit_of_measurement]"
                                            name="budgetItems[{{$index}}][item_unit_of_measurement]"
                                            wire:model="budgetItems.{{$index}}.item_unit_of_measurement" type="text" placeholder="Unit of Measurement" required>
                                </div>
                            </div>

                            <div class="-mx-3 md:flex mb-2">
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="item_total">
                                        Total (RM)
                                    </label>
                                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="budgetItems[{{$index}}][item_total]"
                                            name="budgetItems[{{$index}}][item_total]"
                                            wire:model="budgetItems.{{$index}}.item_total" type="text" placeholder="Total" disabled>
                                </div>
                                @if($index != 0)
                                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                        <button type="button" style="background-color: #e72349" class="bg-alert text-white px-3 py-2 rounded w-full mt-7" wire:click.prevent="removeItem({{$index}})">Delete Item</button>
                                    </div>
                                @endif
                                
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <button type="button" style="background-color: #2349e7" class="text-white px-3 py-2 rounded w-full mt-7" wire:click.prevent="addItem">Add Item</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endforeach
        <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class=" sm:px-20 bg-white border-b border-gray-200">
                    <div class="bg-white rounded px-8 mb-4 flex flex-col">
                        <div class="-mx-3 md:flex mb-2">
                            <div class="md:w-1/2 px-3 mb-6 mx-auto md:mb-0">
                                <button type="submit" style="background-color: #2349e7" class="text-white btn px-3 py-2 rounded w-full mt-7">Submit Budget Application</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>


    </script>
</form>

