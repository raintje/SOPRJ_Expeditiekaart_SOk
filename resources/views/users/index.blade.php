@extends('layouts.app')

@section('head_script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/r-2.2.7/datatables.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')


    <div class="container mt-5">
        <div class="text-left pb-3">
            <h2 class="mb-4">Gebruikers overzicht  <i class="fas fa-info-circle" rel="tooltip" title="{{__('info.overview')}}"></i></h2>
            <a class="btn btn-primary" href="{{route('create.item')}}" role="button">Gebruiker toevoegen</a>

        </div>

        <table id="usersTable" class=" table table-bordered yajra-datatable">
            <thead>
            <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acties</th>
                <th></th>

            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">U staat op het punt een gebruiker te verwijderen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Weet u het zeker?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Terug</button>
                    <button type="button" class="btn btn-danger">Verwijderen</button>
                </div>
            </div>
        </div>
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
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('get.user') }}",
                columns: [
                    {data: 'name', name: 'name', sortable: true,},
                    {data: 'email', name: 'email'},
                    {data: null,
                        defaultContent: 'gebruiker',
                        name: 'role'
                    },
                    {
                        data: 'action',
                        name: 'acties',
                    },
                    {
                        data: 'extra',
                        name: 'extras',
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