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
                          <th style="width:5%">Faculty</th>
                          <th>General Ledger</th>
                          <th>Total (RM)</th>
                          <th style="width:5%">Status</th>
                          <th>Created At</th>
                          <th style="width:14%">Action</th>
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

              $('#DT_application tbody').on('click', '.view', function () {
                var id = $(this).attr('id');
                var account_type = "{{auth()->user()->account_type}}";
                console.log(account_type);
                    $.ajax({
                        url:"{{ route('view_application') }}",    //the page containing php script
                        type: "post",    //request type,
                        dataType: 'json',
                        data: {
                            id: id,
                        },
                        success:function(result){
                            var new_status = "";
                            if (result[0].status !== "Approved by Dean" && result[0].status !== "Approved by Bursary" && account_type == "faculty") {
                                var dialog = bootbox.dialog({
                                    title: "Application - " + result[0].title,
                                    message: result[0].message,
                                    size: "large",
                                    buttons: {
                                        ok: {
                                            label: "Edit",
                                            className: 'btn-info text-white',
                                            callback: function(){
                                                location.href = '/budget/' + id + '/edit';
                                            }
                                        },
                                        cancel: {
                                            label: "Close",
                                            className: 'btn-outline-secondary btn-icon-text',
                                            callback: function(){
                                            }
                                        },                                
                                    }
                                });
                            } else if (result[0].status == "Pending" && account_type == "dean") {
                                var dialog = bootbox.dialog({
                                    title: "Application - " + result[0].title,
                                    message: result[0].message,
                                    size: "large",
                                    buttons: {
                                        ok: {
                                            label: "Approve",
                                            className: 'btn-success text-white',
                                            callback: function(){
                                                $.ajax({
                                                    url:"{{ route('update_application') }}",    //the page containing php script
                                                    type: "post",    //request type,
                                                    dataType: 'json',
                                                    data: {
                                                        id: id,
                                                        status: "Approved by Dean",
                                                        remark: ""
                                                    },
                                                    success:function(result){
                                                        bootbox.alert({
                                                            message: result,
                                                            centerVertical: true,
                                                            callback: function () {
                                                                location.reload(); 
                                                            }
                                                        })
                                                    }
                                                });
                                            }
                                        },
                                        confirm: {
                                            label: "Reject",
                                            className: 'btn-danger',
                                            callback: function(){
                                                bootbox.prompt({
                                                    title: "Are you sure you want to reject application? Please state your remark.", 
                                                    centerVertical: true,
                                                    callback: function(result){ 
                                                        if (result) {
                                                            $.ajax({
                                                                url:"{{ route('update_application') }}",    //the page containing php script
                                                                type: "post",    //request type,
                                                                dataType: 'json',
                                                                data: {
                                                                    id: id,
                                                                    status: "Rejected by Dean",
                                                                    remark: result
                                                                },
                                                                success:function(result){
                                                                    bootbox.alert({
                                                                        message: result,
                                                                        centerVertical: true,
                                                                        callback: function () {
                                                                            location.reload(); 
                                                                        }
                                                                    })
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            }
                                        },
                                        cancel: {
                                            label: "Close",
                                            className: 'btn-outline-secondary btn-icon-text',
                                            callback: function(){
                                            }
                                        },                                
                                    }
                                });
                            } else if (result[0].status == "Approved by Dean" && account_type == "bursary") {
                                var dialog = bootbox.dialog({
                                    title: "Application - " + result[0].title,
                                    message: result[0].message,
                                    size: "large",
                                    buttons: {
                                        ok: {
                                            label: "Approve",
                                            className: 'btn-success text-white',
                                            callback: function(){
                                                bootbox.prompt({
                                                    title: "Are you sure you want to approve application? Please revise the approved total. (Proposed total is: RM" + result[0].total + ")", 
                                                    centerVertical: true,
                                                    callback: function(result){ 
                                                        if (result) {
                                                            $.ajax({
                                                                url:"{{ route('update_application') }}",    //the page containing php script
                                                                type: "post",    //request type,
                                                                dataType: 'json',
                                                                data: {
                                                                    id: id,
                                                                    status: "Approved by Bursary",
                                                                    remark: "",
                                                                    approved_total: result
                                                                },
                                                                success:function(result){
                                                                    bootbox.alert({
                                                                        message: result,
                                                                        centerVertical: true,
                                                                        callback: function () {
                                                                            location.reload(); 
                                                                        }
                                                                    })
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            }
                                        },
                                        confirm: {
                                            label: "Reject",
                                            className: 'btn-danger',
                                            callback: function(){
                                                bootbox.prompt({
                                                    title: "Are you sure you want to reject application? Please state your remark.", 
                                                    centerVertical: true,
                                                    callback: function(result){ 
                                                        if (result) {
                                                            $.ajax({
                                                                url:"{{ route('update_application') }}",    //the page containing php script
                                                                type: "post",    //request type,
                                                                dataType: 'json',
                                                                data: {
                                                                    id: id,
                                                                    status: "Rejected by Bursary",
                                                                    remark: result
                                                                },
                                                                success:function(result){
                                                                    bootbox.alert({
                                                                        message: result,
                                                                        centerVertical: true,
                                                                        callback: function () {
                                                                            location.reload(); 
                                                                        }
                                                                    })
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            }
                                        },
                                        cancel: {
                                            label: "Close",
                                            className: 'btn-outline-secondary btn-icon-text',
                                            callback: function(){
                                            }
                                        },                                
                                    }
                                });
                            } else {
                                var dialog = bootbox.dialog({
                                    title: "Application - " + result[0].title,
                                    message: result[0].message,
                                    size: "large",
                                    buttons: {
                                        // ok: {
                                        //     label: "Edit",
                                        //     className: 'btn-info text-white',
                                        //     callback: function(){
                                        //         location.href = '/budget/' + id + '/edit';
                                        //     }
                                        // },
                                        cancel: {
                                            label: "Close",
                                            className: 'btn-outline-secondary btn-icon-text',
                                            callback: function(){
                                            }
                                        },                                
                                    }
                                });
                            }
                        }
                    });
                });

              $('#DT_application tbody').on('click', '.delete', function () {
                var id = $(this).attr('id');
                  bootbox.confirm({
                    title: "Confirm delete",
                    message: "Are you sure you want to delete this application?",
                    centerVertical: true,
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancel'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Confirm'
                        }
                    },
                    callback: function (result) {
                      if (result == true) {
                        $.ajax({
                          url:"{{ route('delete_application') }}",    //the page containing php script
                          type: "post",    //request type,
                          dataType: 'json',
                          data: {
                              id: id,
                          },
                          success:function(result){
                            bootbox.alert({
                                message: result,
                                centerVertical: true,
                                callback: function () {
                                    location.reload();
                                }
                            });
                          }
                        });
                      }
                    }
                  });
                });
            });
        });
    </script>
</x-app-layout>
