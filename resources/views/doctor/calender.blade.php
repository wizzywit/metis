@extends('layouts.frontLayout.doctorLayout.design')
@section('styles')
 <!-- fullCalendar -->
 <link rel="stylesheet" href="{{asset('js/admin_js/plugins/fullcalendar/main.min.css')}}">
 <link rel="stylesheet" href="{{asset('js/admin_js/plugins/fullcalendar-daygrid/main.min.css')}}">
 <link rel="stylesheet" href="{{asset('js/admin_js/plugins/fullcalendar-timegrid/main.min.css')}}">
 <link rel="stylesheet" href="{{asset('js/admin_js/plugins/fullcalendar-bootstrap/main.min.css')}}">

@endsection

@section('content')
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="span3">
                @include('layouts.frontLayout.doctorLayout.sidebar')
            </div>
            <!--/.span3-->
            <div class="span9">
                <div class="content">
                    <div class="module">
                        <div class="module-head">
                            <h3>
                                Appointments Calender</h3>
                        </div>
                        <div class="module-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                <!--/.content-->
            </div>
            <!--/.span9-->
        </div>
    </div>
    <!--/.container-->
 </div>
@endsection


@section('scripts')
<!-- fullCalendar 2.2.5 -->
<script src="{{asset('js/admin_js/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('js/admin_js/plugins/fullcalendar/main.min.js')}}"></script>
<script src="{{asset('js/admin_js/plugins/fullcalendar-daygrid/main.min.js')}}"></script>
<script src="{{asset('js/admin_js/plugins/fullcalendar-timegrid/main.min.js')}}"></script>
<script src="{{asset('js/admin_js/plugins/fullcalendar-interaction/main.min.js')}}"></script>
<script src="{{asset('js/admin_js/plugins/fullcalendar-bootstrap/main.min.js')}}"></script>
<!-- Page specific script -->
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;

    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------
    events = {!!json_encode($events)!!}


    var calendar = new Calendar(calendarEl, {
      plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      'themeSystem': 'standard',
      //Random default events
      events    : events,
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }
    });

    calendar.render();
    // $('#calendar').fullCalendar()


  })
</script>
@endsection


