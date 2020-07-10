<header id="header">


    <!-- start Navbar (Header) -->
    <nav class="navbar navbar-default fixed-top navbar-sticky-function">

        <div class="container">

            <div class="logo-wrapper">
                <div class="logo">
                    <a href="{{route('user.home')}}"><img src="{{asset('images/orderam logo.png')}}" alt="Logo" width="85" /></a>
                </div>
            </div>

            <div id="navbar" class="navbar-nav-wrapper navbar-arrow">

                <ul class="nav " id="responsive-menu">
                    {{-- navbar-nav --}}
                    <li>
                        <a href="{{route('user.vendors.home')}}" style="color: #fff;">Vendors</a>
                    </li>

                </ul>

            </div>

            <div class="nav-mini-wrapper">
                @if (auth()->user())
                    <ul class="nav-mini sign-in">
                        <li><a href="{{route('user.profile')}}" ><i class="fa fa-user-circle"></i> &nbsp; Account <i class="fa fa-angle-double-down"></i></a></li>
                    </ul>
                @else
                    <ul class="nav-mini sign-in">
                        <li><a href="javascript:void()" id="showLoginAuth">login</a></li>
                        <li><a href="javascript:void()" id="showRegisterAuth">register</a></li>
                    </ul>
                @endif
            </div>

        </div>

        <div id="slicknav-mobile"></div>

    </nav>
    <!-- end Navbar (Header) -->
</header>

<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="bicoinModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">

            <div class="row authNav">
                <div class="col-xs-2 authNavBtn" id="authNavLogin" data-href="{{route('user.login')}}">
                    <i class="fa fa-door-open"></i><br>
                    Sign In
                </div>

                <div class="col-xs-2 authNavBtn" id="authNavRegister" data-href="{{route('user.register')}}">
                    <i class="fa fa-door-open"></i><br>
                    Sign Up
                </div>

                <div class="col-xs-2 authNavBtn" id="authNavRecover" data-href="{{route('user.recover')}}">
                    <i class="fa fa-user"></i><br>
                    Recover
                </div>
            </div>

            <div id="authDisplayDiv" class="myscrollW">
                <center><br><br><i class='fa fa-spin fa-circle-notch fa-2x' style='color:rgb(120,120,120);'></i><br><br></center>
            </div>

        </div>
      </div>
    </div>
  </div>

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
