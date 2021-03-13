<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Budget Application') }}
        </h2>
    </x-slot>
    
    @livewire('items', ['app_id' => $id])

</x-app-layout>
