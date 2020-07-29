<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Video Call</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,900" rel="stylesheet">
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="/videocall/Assets/css/style.css">
<link rel="stylesheet" href="/videocall/Assets/css/colors/blue.css" id="colors">
@if(Auth::guard('web')->user())
    <script>
	const id = Math.floor(Math.random() * 10000);
        window.user =  {
                name: "{{ Auth::guard('web')->user()->name }}",
                id: id+{{ Auth::guard('web')->id() }},
                image: null,
                role: "{{$appointment['user_role']}}",
                status: 0,
                room: "{{$appointment['meeting']}}"
            }

        window.csrfToken = "{{ csrf_token() }}";
    </script>
    @endif

     @if(Auth::guard('doctor')->user())
        <script>
	const id = Math.floor(Math.random() * 10000);
            window.user = {
                name: "{{ Auth::guard('doctor')->user()->name }}",
                id: id + {{ Auth::guard('doctor')->id() }},
                image: null,
                role: "{{$appointment['user_role']}}",
                status: 0,
                room: "{{$appointment['meeting']}}"
            };


            window.csrfToken = "{{ csrf_token() }}";
        </script>
        @endif
<body >
      @if(Auth::guard('doctor')->user())
         <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/doctor') }}">
                        <img src="{{ asset('images/admin/logo1.png') }}" alt="" style="width:30px; "><strong> Metis Technologies</strong>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('doctor.dashboard') }}">{{ __('Back') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::guard('doctor')->user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('doctor.logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout_vid-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout_vid-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>

                        </ul>
                    </div>
                </div>
            </nav>

        @endif

        @if(Auth::guard('web')->user())
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/doctor') }}">
                        <img src="{{ asset('images/admin/logo1.png') }}" alt="" style="width:30px; "><strong> Metis Technologies</strong>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/patient') }}">{{ __('Close') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::guard('web')->user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout_vid-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout_vid-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>

                        </ul>
                    </div>
                </div>
            </nav>

    @endif
<div id="conference"></div>
<script src="{{ asset('js/app.js') }}"></script>

<script type="text/javascript" src="/videocall/Assets/scripts/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/owl.carousel.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/counterup.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/waypoints.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.isotope.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.sticky-kit.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.twentytwenty.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.event.move.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.photogrid.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.tooltips.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.pricefilter.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.stacktable.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.contact-form.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/jquery.jpanelmenu.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/headroom.min.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/modernizr.custom.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/puregrid.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/flexibility.js"></script>
<script type="text/javascript" src="/videocall/Assets/scripts/custom.js"></script>
</body>
</html>
