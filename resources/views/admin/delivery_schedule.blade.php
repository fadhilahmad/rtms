@extends('layouts.layout')

@section('content')
<style>
td.fc-event-container{
 color: white;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Delivery Schedule</div>

                <div class="card-body">
                      <div id='calendar'></div>  
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events : [ 
                
                @foreach($orders as $order)               
                {
                    title : '{{$order->ref_num}}: {{$order->quantity_total}}',
                    start : '{{$order->delivery_date}}',
                },
                @endforeach             
            ]
        })
    });
</script>
@endsection
