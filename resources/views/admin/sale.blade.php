@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Sale Chart</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1">
                            Month
                        </div>
                        <div class="col-md-3 bulan">
                            <select class="form-control" id="bulan">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            Year
                        </div>
                        <div class="col-md-3 tahun">
                            <select name="years" id="tahun" class="form-control">
                                @foreach($years as $year)
                                <option value="{{$year}}">{{$year}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                       <div class="col-md-8 flex-lg-last flex-md-first align-self-baseline">
                        <div class="card sales-report">
<!--                          <h2 class="display h4">Sales Chart</h2>
                          <br><br>-->
                          <div class="line-chart">
                            <canvas id="saleChart"></canvas>
                          </div>
                        </div>
                      </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
/*global $, document, Chart, LINECHART, data, options, window*/
$(document).ready(function () {

    'use strict';

    // Main Template Color
    var brandPrimary = '#33b35a';

    $(".bulan #bulan").val( '{{$m}}' );
    $(".tahun #tahun").val( '{{$y}}' );
    //var month = Date.getMonth();

    // ------------------------------------------------------- //
    // Line Chart
    // ------------------------------------------------------ //
    var LINECHART = $('#saleChart');
    var myLineChart = new Chart(LINECHART, {
        type: 'line',
        options: {
            legend: {
                display: false
            }
        },
        data: {
            labels: [                   
                    @foreach($labelday as $day)    
                    {{$day}},
                    @endforeach                            
                    ],
            datasets: [
                {
                    label: "Sale",
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: "rgba(77, 193, 75, 0.4)",
                    borderColor: brandPrimary,
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 1,
                    pointBorderColor: brandPrimary,
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: brandPrimary,
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 0,
                    data: [
                    @foreach($labelsale as $sale)    
                    {{$sale}},
                    @endforeach
                    ],
                    spanGaps: false
                }
            ]
        }
    });

});

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
$(document).on("change", ".bulan", function (e) {
     e.preventDefault();
    
     var bulan = $(".bulan #bulan").val();
     var tahun = $(".tahun #tahun").val();
    
        var formData = {
            'month'   : bulan,
            'year'   : tahun
        };

        $.ajax({
           type:'POST',
           url:"{{url('admin/sale')}}",
           data:formData,
           success:function(data){            
                'use strict';
                var brandPrimary = '#33b35a';
                var LINECHART = $('#saleChart');
                var myLineChart = new Chart(LINECHART, {
                    type: 'line',
                    options: {legend: {display: false}},
                    data: {labels: data.labelday,
                        datasets: [{
                                label: "Sale",
                                fill: true,
                                lineTension: 0.3,
                                backgroundColor: "rgba(77, 193, 75, 0.4)",
                                borderColor: brandPrimary,
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                borderWidth: 1,
                                pointBorderColor: brandPrimary,
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: brandPrimary,
                                pointHoverBorderColor: "rgba(220,220,220,1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 0,
                                data: data.labelsale,
                                spanGaps: false}]}
                });              
           }
        });
    
   
});

$(document).on("change", ".tahun", function (e) {
     e.preventDefault();
    
     var bulan = $(".bulan #bulan").val();
     var tahun = $(".tahun #tahun").val();
    
        var formData = {
            'month'   : bulan,
            'year'   : tahun
        };

        $.ajax({
           type:'POST',
           url:"{{url('admin/sale')}}",
           data:formData,
           success:function(data){            
                'use strict';
                var brandPrimary = '#33b35a';
                var LINECHART = $('#saleChart');
                var myLineChart = new Chart(LINECHART, {
                    type: 'line',
                    options: {legend: {display: false}},
                    data: {labels: data.labelday,
                        datasets: [{
                                label: "Sale",
                                fill: true,
                                lineTension: 0.3,
                                backgroundColor: "rgba(77, 193, 75, 0.4)",
                                borderColor: brandPrimary,
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                borderWidth: 1,
                                pointBorderColor: brandPrimary,
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: brandPrimary,
                                pointHoverBorderColor: "rgba(220,220,220,1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 0,
                                data: data.labelsale,
                                spanGaps: false}]}
                });              
           }
        });   
});
    
</script>
@endsection
