@extends('layouts.app')

@section('head_script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/datatables.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')


<div class="container mt-5">
    <div class="text-left pb-3">
        <h2 class="mb-4">Item overzicht  <i class="fas fa-info-circle" rel="tooltip" title="{{__('info.overview')}}"></i></h2>
        <a class="btn btn-primary" href="{{route('create.item')}}" role="button">Item toevoegen</a>
    </div>

    {{-- Styling for column actions are located in LayerItemController.php in method getItems--}}
    <table id="itemsTable" class=" table table-bordered yajra-datatable">
        <thead>
        <tr>
            <th>Titel</th>
            <th>Inhoud</th>
            <th>Acties</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

    @section('script')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


        <script type="text/javascript">
            $(document).ready(function (){
                $("[rel=tooltip]").tooltip();
                $.noConflict();
                $('#itemsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('get.item') }}",
                    columns: [
                        {data: 'title', name: 'title', sortable: true,},
                        {data: 'body', name: 'body'},
                        {
                            data: 'action',
                            name: 'acties',

                        },
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Dutch.json'
                    }
                });

            });
        </script>
    @endsection
@endsection

