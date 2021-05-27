@extends('layouts.app')

@section('content')

    <h1 class="text-center mb-4">Gebruiker aanpassen</h1>

    <div class="container">

        @if(count($errors) > 0)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="p-0 m-0 list-unstyled">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row gutters">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user->id) }}"
                              enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="user" class="form-control" value="{{$user->id}}">
                            <div class="row gutters mb-4">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-3"><b>Persoonsgegevens</b></h6>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="fullName">Naam</label>
                                        <input type="text" name="name" class="form-control"
                                               value="{{old('name', $user->name)}}"
                                               id="fullName" placeholder="Enter full name">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="eMail">Email</label>
                                        <input type="email" name="email" class="form-control"
                                               value="{{old('email', $user->email)}}"
                                               id="eMail" placeholder="Enter email ID">
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" id="submit" name="submit" class="btn btn-primary">
                                    Persoongegevens bijwerken
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>


            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update.password', $user->id) }}"
                              enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="user" class="form-control" value="{{$user->id}}">

                            <div class="col-12 col-sm-12 mb-3">
                                <div class="mb-3"><b>Verander Wachtwoord</b></div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Nieuw wachtwoord</label>
                                            <input class="form-control" value="{{old('password', '')}}" name="password" type="password" placeholder="Wachtwoord">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Bevestig <span class="d-none d-xl-inline">Wachtwoord</span></label>
                                            <input class="form-control" value="{{old('password_confirmation', '')}}" name="password_confirmation" type="password" placeholder="Wachtwoord"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Update
                                        Wachtwoord
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update.role', $user->id) }}"
                              enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="user" class="form-control" value="{{$user->id}}">

                            <div class="col-12 col-sm-12 mb-3">
                                <div class="mb-3"><b>Verander Deelbeheerders rol</b></div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <select name="role" class="custom-select">
                                                @foreach ($roles as $role)
                                                    <option @if ($user->hasRole($role))
                                                        selected
                                                    @endif value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Update
                                        Deelbeheerders rol
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
