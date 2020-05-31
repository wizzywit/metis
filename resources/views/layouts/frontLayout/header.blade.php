<!-- header-start -->
<header>
    <div class="header-area ">
        <div class="header-top_area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-md-6 ">
                        <div class="social_media_links">
                            <a href="#">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="short_contact_list">
                            <ul>
                                <li><a href="mailto:info@metistechnologies.com"> <i class="fa fa-envelope"></i> info@metistechnologies.com</a></li>
                                <li><a href="tel:23470908999"> <i class="fa fa-phone"></i> +234 70908999</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sticky-header" class="main-header-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-2">
                        <div class="logo">
                            <a href="{{url('/')}}">
                                <img src="{{ asset('images/admin/logo1.png') }}" alt="" style="width:45px; "><strong> Metis Technologies</strong>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7">
                        <div class="main-menu  d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a class="active" href="{{url('/')}}">home</a></li>
                                    <li><a href="#">Pages<i class="ti-angle-down"></i></a>
                                        <ul class="submenu">
                                            <li><a href="departments.html">Department</a></li>
                                            <li><a href="Doctors.html">Doctors</a></li>
                                            <li><a href="about.html">about</a></li>
                                        </ul>
                                    </li>
                                    @if(Auth::guard('web')->check())
                                    <li><a href="{{route('appointments')}}">Appointments</a></li>
                                    @else
                                    <li><a href="#">For Doctors <i class="ti-angle-down"></i></a>
                                        <ul class="submenu">
                                            <li><a href="{{route('doctor.register')}}">Register</a></li>
                                            <li><a href="{{route('doctor.login')}}">Login</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">For Patients <i class="ti-angle-down"></i></a>
                                        <ul class="submenu">
                                            <li><a href="{{route('register')}}">Register</a></li>
                                            <li><a href="{{route('login')}}">Login</a></li>
                                        </ul>
                                    </li>
                                    @endif
                                    <li><a href="contact.html">Contact</a></li>
                                    @if(Auth::guard('web')->check())
                                    <li><a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Logout</a></li>
                                    @endif
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                        <div class="Appointment">
                            <div class="book_btn d-none d-lg-block">
                                <a class="" href="{{url('/patient')}}">Make an Appointment</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-end -->
