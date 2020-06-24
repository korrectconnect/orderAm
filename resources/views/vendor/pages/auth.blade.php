@extends('vendor.base')

@section('content')

    <div class="admin-container-wrapper">

        <div class="container">

            <div class="GridLex-gap-15-wrappper">

                <div class="GridLex-grid-noGutter-equalHeight">

                    @include('vendor.inc.menu')

                    <div class="GridLex-col-9_sm-8_xs-12">

                        <div class="admin-content-wrapper">

                            <h2>Vendor Admin Authenticator</h2>

                            @if ($auth == true)
                                <p class="text-success" style="font-size: 15px;">Vendor Admin mode is active !</p><br>

                                <form action="{{route('vendor.authAdminLogout')}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-md btn-danger">Logout Admin Mode</button>
                                </form>
                            @else
                                <p class="text-danger" style="font-size: 15px;">Vendor Admin mode is not active !</p><br>

                                <form action="{{route('vendor.authAdmin')}}" method="POST">
                                    @csrf
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="secret">Enter Admin Pin</label>
                                            <input type="password" name="secret" class="form-control">
                                        </div><br>
                                        <button type="submit" class="btn btn-md btn-danger">Authenticate</button>
                                    </div>
                                </form>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
