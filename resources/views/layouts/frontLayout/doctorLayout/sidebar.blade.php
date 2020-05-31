<div class="sidebar">
    <ul class="widget widget-menu unstyled">
    <li ><a class="{{ request()->is('doctor') ? 'active' : ''}}" href="{{url('doctor/')}}"><i class="menu-icon icon-home"></i>Home
        </a></li>
<<<<<<< HEAD
        <li><a class="{{ request()->is('patient/booking*') ? 'active' : ''}}" href="{{route('booking')}}"><i class="menu-icon icon-bullhorn"></i>Book Appointment</a>
        </li>
        <li><a class="{{ request()->is('patient/appointments') ? 'active' : ''}}" href="{{route('appointments')}}"><i class="menu-icon icon-calendar"></i>Appointments <b class="label green pull-right">
            {{App\Appointment::where('patient_id',Auth::guard('web')->id())->count()}}</b> </a></li>
        <li><a class="{{ request()->is('patient/scheduled') ? 'active' : ''}}" href="task.html"><i class="menu-icon icon-tasks"></i>Scheduled <b class="label orange pull-right">
            {{App\Appointment::where(['patient_id'=>Auth::guard('web')->id(),'scheduled'=>true])->count()}}</b> </a></li>
            <li><a class="{{ request()->is('patient/video') ? 'active' : ''}}" href="task.html"><i class="menu-icon icon-suitcase"></i>Conference Room</a></li>
    </ul>
    <ul class="widget widget-menu unstyled">
        <li><a class="collapsed {{ request()->is('patient/setting*') ? 'active' : ''}}" data-toggle="collapse" href="#togglePages"><i class="menu-icon icon-cog">
        </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
        </i>Account Settings</a>
            <ul id="togglePages" class="collapse unstyled">
                <li><a href="{{route('patient.view')}}"><i class="icon-eye-open"></i>View Profile </a></li>
                <li><a class="{{ request()->is('patient/setting/password') ? 'active' : ''}}" href="{{route('patient.password.form')}}"><i class="icon-bolt"></i>Change Password </a></li>
            </ul>
        </li>
        <li><a href="{{ route('doctor.logout') }}"  onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="menu-icon icon-signout"></i>Logout </a></li>
            <form id="logout-form" action="{{ route('doctor.logout') }}" method="POST" style="display: none;">
=======
        <li><a class="" href="#"><i class="menu-icon icon-bullhorn"></i>Scheduled Appointment</a>
        </li>
            <li><a class="" href="#"><i class="menu-icon icon-suitcase"></i>Conference Room</a></li>
    </ul>
    <ul class="widget widget-menu unstyled">
        <li><a class="collapsed " data-toggle="collapse" href="#togglePages"><i class="menu-icon icon-cog">
        </i><i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
        </i>Account Settings</a>
            <ul id="togglePages" class="collapse unstyled">
                <li><a href="#"><i class="icon-eye-open"></i>View Profile </a></li>
                <li><a class="" href="#"><i class="icon-bolt"></i>Change Password </a></li>
            </ul>
        </li>
        <li><a href="{{ route('doctor.logout') }}"  onclick="event.preventDefault();
            document.getElementById('logout-form1').submit();"><i class="menu-icon icon-signout"></i>Logout </a></li>
            <form id="logout-form1" action="{{ route('doctor.logout') }}" method="POST" style="display: none;">
>>>>>>> c9f46201ad969a1e66c2b47b616abb9c43490320
                @csrf
            </form>
    </ul>
</div>
<!--/.sidebar-->
