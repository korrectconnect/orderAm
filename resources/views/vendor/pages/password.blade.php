@extends('vendor.base')

@section('content')

    <div class="admin-container-wrapper">

        <div class="container">

            <div class="GridLex-gap-15-wrappper">

                <div class="GridLex-grid-noGutter-equalHeight">

                    @include('vendor.inc.menu')

                    <div class="GridLex-col-9_sm-8_xs-12">

                        <div class="admin-content-wrapper">

                            <h2>Change Password</h2>

                            <div class="row">
                                <div class="col-md-6">
                                    <form data-href="{{route('vendor.password.change')}}" id="changePasswordForm">
                                        @csrf

                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title"><strong>Change Password</strong></div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="old">Old Password</label>
                                                    <input type="password" name="old" id="old" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="new">New Password</label>
                                                    <input type="password" name="password" id="new" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="confirm">Confirm New Password</label>
                                                    <input type="password" name="password_confirmation" id="confirm" class="form-control">
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button class="btn btn-md btn-primary" type="submit" id="changePasswordFormBtn">Change Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
