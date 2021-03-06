<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{route('admin.dashboard')}}">
        <i class="fa fa-pencil"></i> &nbsp; &nbsp;
        Dashboard
    </a>
</li>

<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{route('admin.orders')}}">
        <i class="fa fa-pencil"></i> &nbsp; &nbsp;
        Orders
    </a>
</li>

<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{route('admin.pending')}}">
        <i class="fa fa-pencil"></i> &nbsp; &nbsp;
        Pending Deliveries
    </a>
</li>

<li class="c-sidebar-nav-dropdown">
    <a class="c-sidebar-nav-dropdown-toggle" href="#">
        <i class="fa fa-pencil"></i> &nbsp; &nbsp;
        Vendors
    </a>

        <div class="c-sidebar-nav-dropdown-items">
            <a class="dropdown-item" href="{{route('admin.vendor.add')}}">
                <i class="fa fa-user-plus"></i> &nbsp; &nbsp;
                Add Vendor
            </a>
            <a class="dropdown-item" href="{{route('admin.vendor.view')}}">
                <i class="fa fa-list"></i> &nbsp; &nbsp;
                View All
            </a>
            <a class="dropdown-item" href="{{route('admin.vendor.category')}}">
                <i class="fa fa-building"></i> &nbsp; &nbsp;
                Vendor Category
            </a>
            <a class="dropdown-item" href="{{route('admin.vendor.location')}}">
                <i class="fa fa-location-arrow"></i> &nbsp; &nbsp;
                Vendor Location
            </a>
            <a class="dropdown-item" href="{{route('admin.vendor.funding')}}">
                <i class="fa fa-money-check"></i> &nbsp; &nbsp;
                Funding History
            </a>
        </div>

</li>

<li class="c-sidebar-nav-dropdown">
    <a class="c-sidebar-nav-dropdown-toggle" href="#">
        <i class="fa fa-pencil"></i> &nbsp; &nbsp;
        Riders
    </a>

        <div class="c-sidebar-nav-dropdown-items">
            <a class="dropdown-item" href="{{route('admin.rider.add')}}">
                <i class="fa fa-pencil"></i> &nbsp; &nbsp;
                Register Rider
            </a>
            <a class="dropdown-item" href="{{route('admin.rider.view')}}">
                <i class="fa fa-pencil"></i> &nbsp; &nbsp;
                View All Riders
            </a>
            <a class="dropdown-item" href="{{route('admin.rider.locations')}}">
                <i class="fa fa-pencil"></i> &nbsp; &nbsp;
                View Assigned Locations
            </a>
            <a class="dropdown-item" href="{{route('admin.rider.category')}}">
                <i class="fa fa-pencil"></i> &nbsp; &nbsp;
                Riders Category
            </a>
        </div>

</li>

<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{route('admin.transactions')}}">
        <i class="fa fa-pencil"></i> &nbsp; &nbsp;
        Transactions
    </a>
</li>

{{-- <li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="">
        <i class="fa fa-pencil"></i> &nbsp; &nbsp;
        Customers
    </a>
</li> --}}

<li class="c-sidebar-nav-dropdown">
    <a class="c-sidebar-nav-dropdown-toggle" href="#">
        <i class="fa fa-pencil"></i> &nbsp; &nbsp;
        Settings
    </a>

        <div class="c-sidebar-nav-dropdown-items">
            <a class="dropdown-item" href="{{route('admin.slider')}}">
                <i class="fa fa-pencil"></i> &nbsp; &nbsp;
                Home Slider
            </a>
        </div>
</li>



{{-- <div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="">
                <i class="nav-icon icon-speedometer"></i> Dashboard
                <span class="badge badge-primary">NEW</span>
              </a>
            </li>
            <li class="nav-title">Theme</li>
            <li class="nav-item">
              <a class="nav-link" href="colors">
                <i class="nav-icon icon-drop"></i> Colors</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="typography">
                <i class="nav-icon icon-pencil"></i> Typography</a>
            </li>
            <li class="nav-title">Components</li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-puzzle"></i> Bdase</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="breadcrumb">
                    <i class="nav-icon icon-puzzle"></i> Breadcrumb</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cards">
                    <i class="nav-icon icon-puzzle"></i> Cards</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="carousel">
                    <i class="nav-icon icon-puzzle"></i> Carousel</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="collapse">
                    <i class="nav-icon icon-puzzle"></i> Collapse</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="forms">
                    <i class="nav-icon icon-puzzle"></i> Forms</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="jumbotron">
                    <i class="nav-icon icon-puzzle"></i> Jumbotron</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="list-group">
                    <i class="nav-icon icon-puzzle"></i> List group</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="navs">
                    <i class="nav-icon icon-puzzle"></i> Navs</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pagination">
                    <i class="nav-icon icon-puzzle"></i> Pagination</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="popovers">
                    <i class="nav-icon icon-puzzle"></i> Popovers</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="progress">
                    <i class="nav-icon icon-puzzle"></i> Progress</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="scrollspy">
                    <i class="nav-icon icon-puzzle"></i> Scrollspy</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="switches">
                    <i class="nav-icon icon-puzzle"></i> Switches</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="tables">
                    <i class="nav-icon icon-puzzle"></i> Tables</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="tabs">
                    <i class="nav-icon icon-puzzle"></i> Tabs</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="tooltips">
                    <i class="nav-icon icon-puzzle"></i> Tooltips</a>
                </li>
              </ul>
            </li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-cursor"></i> Buttons</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="buttons/buttons">
                    <i class="nav-icon icon-cursor"></i> Buttons</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="buttons/button-group">
                    <i class="nav-icon icon-cursor"></i> Buttons Group</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="buttons/dropdowns">
                    <i class="nav-icon icon-cursor"></i> Dropdowns</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="buttons/brand-buttons">
                    <i class="nav-icon icon-cursor"></i> Brand Buttons</a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="charts">
                <i class="nav-icon icon-pie-chart"></i> Charts</a>
            </li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-star"></i> Icons</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="icon/coreui-icons">
                    <i class="nav-icon icon-star"></i> CoreUI Icons
                    <span class="badge badge-success">NEW</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="icon/flags">
                    <i class="nav-icon icon-star"></i> Flags</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="icon/font-awesome">
                    <i class="nav-icon icon-star"></i> Font Awesome
                    <span class="badge badge-secondary">4.7</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="icon/simple-line-icons">
                    <i class="nav-icon icon-star"></i> Simple Line Icons</a>
                </li>
              </ul>
            </li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-bell"></i> Notifications</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="notifications/alerts">
                    <i class="nav-icon icon-bell"></i> Alerts</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="notifications/badge">
                    <i class="nav-icon icon-bell"></i> Badge</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="notifications/modals">
                    <i class="nav-icon icon-bell"></i> Modals</a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="widgets">
                <i class="nav-icon icon-calculator"></i> Widgets
                <span class="badge badge-primary">NEW</span>
              </a>
            </li>
            <li class="divider"></li>
            <li class="nav-title">Extras</li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-star"></i> Pages</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="login" target="_top">
                    <i class="nav-icon icon-star"></i> Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="register" target="_top">
                    <i class="nav-icon icon-star"></i> Register</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="404" target="_top">
                    <i class="nav-icon icon-star"></i> Error 404</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="500" target="_top">
                    <i class="nav-icon icon-star"></i> Error 500</a>
                </li>
              </ul>
            </li>
            <li class="nav-item mt-auto">
              <a class="nav-link nav-link-success" href="https://coreui.io" target="_top">
                <i class="nav-icon icon-cloud-download"></i> Download CoreUI</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-danger" href="https://coreui.io/pro/" target="_top">
                <i class="nav-icon icon-layers"></i> Try CoreUI
                <strong>PRO</strong>
              </a>
            </li>
          </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div> --}}
