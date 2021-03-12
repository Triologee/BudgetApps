<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-10">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <!-- <div>
                        <x-jet-application-logo class="block h-12 w-auto" />
                    </div> -->

                    @include('layouts.flash-message')

                    <div class="mt-2 text-2xl">
                        Budget Applications
                    </div>
                    
                    <div class="mt-6 text-gray-500">
                    <table class="table table-bordered" style="width:100%" id="DT_application">
                      <thead>
                        <tr>
                          <th style="width:5%">No.</th>
                          <th>Application Name</th>
                          <th>Faculty</th>
                          <th>General Ledger</th>
                          <th>Total</th>
                          <th>Status</th>
                          <th>Created At</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                        <!-- Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
                        to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
                        you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
                        ecosystem to be a breath of fresh air. We hope you love it. -->
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- delete script tag below until end of script to view, still unfinished datatables -->
    <script>

        $(document).ready(function() {
            $(function () {
            var table = $('#DT_application').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dt_application') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'faculty', name: 'faculty'},
                    {data: 'general_ledger', name: 'general_ledger'},
                    {data: 'total', name: 'total'},
                    {data: 'status', name: 'status'},
                    {
                        name: 'created_at.timestamp',
                        data: {
                            _: 'created_at.display',
                            sort: 'created_at.timestamp'
                        }
                    },
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ],
                order: [[ 6, "desc" ]],
                bLengthChange: false,
            });


            });
        });
    </script>
</x-app-layout>
