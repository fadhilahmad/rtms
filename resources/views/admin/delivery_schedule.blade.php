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
                <div class="card-header"><i class="fa fa-calendar"></i> Delivery Schedule</div>

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

            //function utk tukar color date
            dayRender: function (date, cell) {               
                var today = new Date();
                var tomorrow = new Date();
                     tomorrow.setDate(tomorrow.getDate() + 1);
                var lusa = new Date();
                     lusa.setDate(lusa.getDate() + 2);
                
                if (date.isSame(today, "day")) {
                        cell.css("background-color", "yellow");
                    }
                                     
                if (date.isSame(tomorrow, "day")) {
                        cell.css("background-color", "yellow");
                    }
                    
                if (date.isSame(lusa, "day")) {
                        cell.css("background-color", "yellow");
                    }

            },
            events : [ 
                
                @foreach($orders as $order)               
                {
                    title : '{{$order->ref_num}}: {{$order->quantity_total}}',
                    start : '{{$order->delivery_date}}',
                },
                @endforeach
                
                @foreach($total as $tot)               
                {
                    title : 'Total: {{$tot->sum}}',
                    start : '{{$tot->delivery_date}}',
                },
                @endforeach 
            ],
            //add extra field
//            eventRender: function(event, element) {
//                var new_description =                    
//                     '<strong>Total: </strong>' + event.total;
//                element.append(new_description);
//                //if nak change color specific field
//                if(event.total != null) {
//                    element.css('background-color', '#000');
//                }
//            }

        })
    });
</script>
@endsection
