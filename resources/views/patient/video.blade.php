<!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- <link rel="manifest" href="site.webmanifest"> -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/front_img/favicon.png') }}">
        <!-- Place favicon.ico in the root directory -->
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Metis | Conference</title>
        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        @if(Auth::guard('web')->user())
        <script>
            window.user = {
                id: {{ Auth::guard('web')->id() }},
                name: "{{ Auth::guard('web')->user()->name }}",
                channel: "{{$appointment['meeting']}}",
                doctor_id: {{$appointment['doctor_id']}},
                doctor_name: "{{$appointment['doctor_name']}}"
            };
            window.csrfToken = "{{ csrf_token() }}";
        </script>
        @endif
    </head>
    <body>
        <div id="app">
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
        </div>
        <main class="py-4">
            <div id="conference"></div>
        </main>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
    </html>
