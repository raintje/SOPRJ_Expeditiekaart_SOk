@extends('layouts.app')

@section('head_script')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"  rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" defer rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<div class="container mt-5">
    <h2 class="mb-4">Item overzicht</h2>
    <table id="itemsTable" class="table table-bordered yajra-datatable">
        <thead>
        <tr>
            <th>Titel</th>
            <th>inhoud</th>
            <th>acties</th>

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
                $.noConflict();
                $('#itemsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('get.item') }}",
                    columns: [
                        {data: 'title', name: 'Titel'},
                        {data: 'body', name: 'Inhoud'},
                        {
                            data: 'action',
                            name: 'acties',
                            orderable: true,
                        },
                    ]
                });

            });
        </script>
    @endsection
@endsection

