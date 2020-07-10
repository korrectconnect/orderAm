<header id="header">


    <!-- start Navbar (Header) -->
    <nav class="navbar navbar-default fixed-top navbar-sticky-function">

        <div class="container">

            <div class="logo-wrapper">
                <div class="logo">
                    <a href="{{route('vendor.dashboard')}}"><img src="{{asset('images/orderam logo.png')}}" alt="Logo" width="85" /></a>
                </div>
            </div>

            <div id="navbar" class="navbar-nav-wrapper navbar-arrow">

                <ul class="nav " id="responsive-menu">
                    {{-- navbar-nav --}}
                    {{-- <li>
                        <a href="{{route('user.vendors.home')}}">Vendors</a>
                    </li> --}}

                </ul>

            </div>

            <div class="nav-mini-wrapper">
                @if (auth()->guard('vendor')->user())
                    <ul class="nav-mini sign-in">
                        <li>
                            <a href="javascript:void()" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    </ul>
                @endif
            </div>

        </div>
        <form id="logout-form" action="{{ route('vendor.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </nav>
    <!-- end Navbar (Header) -->
</header>

  <div class="modal fade" id="loadModal" tabindex="-1" role="dialog" aria-labelledby="bicoinModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">

            <div id="loadDisplayDiv" class="myscrollW">
                <center><br><br><i class='fa fa-spin fa-circle-notch fa-2x' style='color:rgb(120,120,120);'></i><br><br></center>
            </div>

        </div>
      </div>
    </div>
  </div>
