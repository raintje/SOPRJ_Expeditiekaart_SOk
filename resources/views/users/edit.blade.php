@extends('layouts.app')

@section('content')

    <h1 class="text-center mb-3">Gebruiker aanpassen</h1>

    <div class="container">
        <div class="row gutters">
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row gutters mb-4">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-3"><b>Personal Details</b></h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control" value="{{old('name', $user->name)}}"
                                           id="fullName" placeholder="Enter full name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="eMail">Email</label>
                                    <input type="email" class="form-control" value="{{old('email', $user->email)}}"
                                           id="eMail" placeholder="Enter email ID">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="submit" name="submit" class="btn btn-secondary">Cancel</button>
                            <button type="button" id="submit" name="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">

                            <div class="col-12 col-sm-12 mb-3">
                                <div class="mb-3"><b>Verander Wachtwoord</b></div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input class="form-control" type="password" placeholder="••••••">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                                            <input class="form-control" type="password" placeholder="••••••"></div>
                                    </div>
                                </div>
                        <div class="modal-footer">
                            <button type="button" id="submit" name="submit" class="btn btn-secondary">Cancel</button>
                            <button type="button" id="submit" name="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
