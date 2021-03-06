<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
            <i class="icon-reorder shaded"></i></a><a class="brand" href="{{url('doctor/')}}">
                <img src="{{ asset('images/admin/logo1.png') }}" alt="" style="width:30px; "><strong> Metis Technologies</strong>
            </a>
            <div class="nav-collapse collapse navbar-inverse-collapse">
                <ul class="nav pull-right">
                    <li><a href="#">Hello Doc. </a></li>
                    <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('images/doctors/'.Auth::guard('doctor')->user()->passport) }}" class="nav-avatar" />
                        <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('doctor.view')}}">Your Profile</a></li>
                            <li><a href="{{route('doctor.edit')}}">Edit Profile</a></li>
                            <li><a href="{{route('doctor.password.form')}}">Password Setting</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ route('doctor.logout') }}"  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.nav-collapse -->
        </div>
    </div>
    <!-- /navbar-inner -->
</div>
<!-- /navbar -->
