<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-speedometer"></i>
                        <span>Dashboards</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('table') }}" class="waves-effect">
                        <i class="fas fa-list-ul"></i>
                        <span>Table</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user') }}" class="waves-effect">
                        <i class="fas fa-user"></i>
                        <span>User</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>