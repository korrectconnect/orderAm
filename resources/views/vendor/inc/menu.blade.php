<div class="GridLex-col-3_sm-4_xs-12">

    <div class="admin-sidebar">

        <div class="admin-user-item">

            <div class="image" style="background-image: url('{{$vendor->image}}')"></div>

            <h4>{{$vendor->name}}</h4>
            <p class="user-role">{{$vendor->state." . ".$vendor->lga." . ".$vendor->area}}</p>

            @if ($auth == true)
                <a href="javascript:void()" class="btn btn-sm btn-primary">VENDOR ADMIN ACTIVE</a>
            @endif

        </div>

        <ul class="admin-user-menu clearfix">
            <li>
                <a href="{{route('vendor.dashboard')}}"><i class="fa fa-list"></i> Orders</a>
            </li>
            <li>
                <a href="{{route('vendor.menus')}}"><i class="fa fa-hamburger"></i> Menus</a>
            </li>
            <li>
                <a href="{{route('vendor.profile')}}"><i class="fa fa-user"></i> Profile</a>
            </li>
            @if ($auth == true)
                <li>
                    <a href="{{route('vendor.finances')}}"><i class="fa fa-chart-line"></i> Finances</a>
                </li>
            @endif
            @if ($auth == true)
                <li>
                    <a href="{{route('vendor.password')}}"><i class="fa fa-lock"></i> Password</a>
                </li>
            @endif
            {{-- <li>
                <a href="{{route('user.vendor.favourite')}}"><i class="fa fa-coins"></i> Coupons</a>
            </li>
            <li>
                <a href="{{route('user.password.change')}}"><i class="fa fa-digital-tachograph"></i> Finances</a>
            </li> --}}
            <li>
                <a href="{{route('vendor.authAdmin')}}"><i class="fa fa-key"></i> Authenticate Admin</a>
            </li>

        </ul>

    </div>

</div>
