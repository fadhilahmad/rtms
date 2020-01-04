@extends ('layouts.layout')
@section ('content')
<div>
    <div class="card-header">Dashboard   
        <div class="float-lg-right">
            <div class="row">
                @php
                if(isset($start)){$s = $start;}else{$s='';}
                if(isset($end)){$e = $end;}else{$e='';}
                @endphp
                <form class = "form-inline d-print-none" method="post" action="{{route('filter.dashboard')}}">@csrf
                <div class="col-sm-1">Start</div>
                <div class="col-sm-4"><input type="date" id="start" name="start" class="form-control-sm" required="" value="{{$s}}"></div>
                <div class="col-sm-1">End</div>
                <div class="col-sm-4"><input type="date" id="end" name="end" class="form-control-sm" required="" value="{{$e}}"></div>
                <button class="btn-sm" type="submit">Filter</button>
                </form>
                <a href="{{ route('admin.dashboard') }}"><button class="btn-sm d-print-none" ><i class="fa fa-refresh"></i></button></a>
                <a href=""><button class="btn-sm d-print-none" onclick="printFunction()"><i class="fa fa-print"></i></button></a>
            </div>
        </div>           
    </div>
    <div class="card-body">

    </div>
    <section class="dashboard-counts section-padding">
        <div class="container-fluid">
          <div class="row">
            <!-- Count item widget-->
            <div class="col-xl-3 col-md-4 col-4">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-user"></i></div>
                <div class="name"><strong class="text-uppercase">Registered Users</strong>
                  <div class="count-number">{{$user}}</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-3 col-md-4 col-4">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-padnote"></i></div>
                <div class="name"><strong class="text-uppercase">New Application</strong>
                  <div class="count-number">{{$application}}</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-3 col-md-4 col-4">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-check"></i></div>
                <div class="name"><strong class="text-uppercase">Submited Orders</strong>
                  <div class="count-number">{{$orders}}</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-3 col-md-4 col-4">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-bill"></i></div>
                <div class="name"><strong class="text-uppercase">Orders Delivered</strong>
                  <div class="count-number">{{$deliver}}</div>
                </div>
              </div>
            </div>
          </div><br><br>
            <div class="row">
            <div class="col-xl-3 col-md-4 col-4">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-list"></i></div>
                <div class="name"><strong class="text-uppercase">Invoice Quoted</strong>
                  <div class="count-number">{{$invoice}}</div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-4 col-4">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-list-1"></i></div>
                <div class="name"><strong class="text-uppercase">Payment Done</strong>
                  <div class="count-number">{{$payment}}</div>
                </div>
              </div>
            </div>
                <div class="col-xl-3 col-md-4 col-4">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-list"></i></div>
                <div class="name"><strong class="text-uppercase">Total unit</strong>
                  <div class="count-number">{{$total_unit}}</div>
                </div>
              </div>
            </div>
                <div class="col-xl-3 col-md-4 col-4">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-padnote"></i></div>
                <div class="name"><strong class="text-uppercase">Reprint Rate</strong>
                  <div class="count-number">{{$reprint_rate}}%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Header Section-->
      <section class="dashboard-header section-padding">
        <div class="container-fluid">
          <div class="row d-flex align-items-md-stretch">
            <!-- To Do List-->
<!--            <div class="col-lg-3 col-md-6">
              <div class="card to-do">
                <h2 class="display h4">Quick Links</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <ul class="check-lists list-unstyled">
                  <li class="d-flex align-items-center"> 
                    <a href="{{ route('admin.delivery') }}">Delivery Schedule</a>
                  </li>
                  <li class="d-flex align-items-center"> 
                    <a href="{{ route('admin.payment') }}">Pending Payment</a>
                  </li>
                  <li class="d-flex align-items-center"> 
                    <a href="{{ route('admin.invoicelist') }}">Invoice </a>
                  </li>
                  <li class="d-flex align-items-center"> 
                    <a href="{{ route('admin.newapplication') }}">User Application</a>
                  </li>
                  <li class="d-flex align-items-center"> 
                    <a href="{{ route('admin.leaveapplication') }}">Leave Application</a>
                  </li>
                  <li class="d-flex align-items-center"> 
                    <a href="{{ route('admin.staffperformance') }}">Performance</a>
                  </li>
                  <li class="d-flex align-items-center"> 
                    <a href="{{ route('admin.orderlist') }}">Job Order</a>
                  </li>
                  <li class="d-flex align-items-center"> 
                    <a href="{{ route('admin.receiptlist') }}">Receipt</a>
                  </li>
                </ul>
              </div>
            </div>-->
            <!-- Pie Chart-->
            <div class="col-lg-6 col-md-12">
              <div class="card project-progress">
                <h2 class="display h4">Payment Status Percentage</h2>
<!--                <p>Percentage of complete, deposited and pending payment from overall orders</p>-->
                <div class="pie-chart">
                  <canvas id="paymentChart" width="300" height="300"> </canvas>
                </div>
              </div>
            </div>
            <!-- Line Chart -->
            <div class="col-lg-6 col-md-12 flex-lg-last flex-md-first align-self-baseline">
              <div class="card sales-report">
                <h2 class="display h4">Payment Collected </h2>
<!--                <p>Payment collected vs Pending</p>-->
                <br><br>
                <div class="line-chart">
                  <canvas id="saleChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Statistics Section-->
      <section class="statistics">
        <div class="container-fluid">
          <div class="row d-flex">
            <div class="col-lg-4">
              <!-- Income-->
              <div class="card income text-center">
                <div class="icon"><i class="icon-bill"></i></div>
                <div class="number">RM {{$income}}</div><strong class="text-primary">Collected</strong>
                <p>Total collected payment.</p>
              </div>
            </div>
            <div class="col-lg-4">
              <!-- Income-->
              <div class="card income text-center">
                <div class="icon"><i class="icon-check"></i></div>
                <div class="number">RM {{$income2}}</div><strong class="text-primary">Pending</strong>
                <p>Total pending value.</p>
              </div>
            </div>
            <div class="col-lg-4">
              <!-- Income-->
              <div class="card income text-center">
                <div class="icon"><i class="icon-line-chart"></i></div>
                <div class="number">RM {{$income3}}</div><strong class="text-primary">Income</strong>
                <p>Total sale.
               
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <section class="statistics mt-30px mb-30px">
        <div class="container-fluid">
          <div class="row d-flex">
            <div class="col-lg-4">
              <div class="card user-activity">
                <h2 class="display h4">Design Department</h2>
                <div class="number">{{$design}}</div>
                <h3 class="h4 display">Designed</h3>
                <div class="progress">
                  <div role="progressbar" style="width: {{$dp}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>
                </div>
                <div class="page-statistics d-flex justify-content-between">
                  <div class="page-statistics-left"><span>Total Job</span><strong>{{$total_unit}}</strong></div>
                  <div class="page-statistics-right"><span>Completed</span><strong>{{$design_p}}%</strong></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card user-activity">
                <h2 class="display h4">Print Department</h2>
                <div class="number">{{$print}}</div>
                <h3 class="h4 display">Printed</h3>
                <div class="progress">
                  <div role="progressbar" style="width: {{$pp}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>
                </div>
                <div class="page-statistics d-flex justify-content-between">
                  <div class="page-statistics-left"><span>Total Job</span><strong>{{$total_unit}}</strong></div>
                  <div class="page-statistics-right"><span>Completed</span><strong>{{$print_p}}%</strong></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card user-activity">
                <h2 class="display h4">Tailor</h2>
                <div class="number">{{$tailor}}</div>
                <h3 class="h4 display">Sew</h3>
                <div class="progress">
                  <div role="progressbar" style="width: {{$tp}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>
                </div>
                <div class="page-statistics d-flex justify-content-between">
                  <div class="page-statistics-left"><span>Total Job</span><strong>{{$total_unit}}</strong></div>
                  <div class="page-statistics-right"><span>Completed</span><strong>{{$tailor_p}}%</strong></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>
<script type="text/javascript">
/*global $, document, Chart, LINECHART, data, options, window*/
$(document).on("click", "#end", function () {

    var start = $('#start').val();
    if(start == ""){
        alert('Please select start date first');
    }
    document.getElementById('end').setAttribute("min", start);
});

$(document).ready(function () {

    'use strict';

    // Main Template Color
    var brandPrimary = '#33b35a';


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
                    label: "Payment",
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
                },
//                {
//                    label: "Pending",
//                    fill: true,
//                    lineTension: 0.3,
//                    backgroundColor: "rgba(75,192,192,0.4)",
//                    borderColor: "rgba(75,192,192,1)",
//                    borderCapStyle: 'butt',
//                    borderDash: [],
//                    borderDashOffset: 0.0,
//                    borderJoinStyle: 'miter',
//                    borderWidth: 1,
//                    pointBorderColor: "rgba(75,192,192,1)",
//                    pointBackgroundColor: "#fff",
//                    pointBorderWidth: 1,
//                    pointHoverRadius: 5,
//                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
//                    pointHoverBorderColor: "rgba(220,220,220,1)",
//                    pointHoverBorderWidth: 2,
//                    pointRadius: 1,
//                    pointHitRadius: 10,
//                    data: [65, 59, 30, 81, 46, 55, 30],
//                    spanGaps: false
//                }
            ]
        }
    });


    // ------------------------------------------------------- //
    // Pie Chart
    // ------------------------------------------------------ //
    var PIECHART = $('#paymentChart');
    var myPieChart = new Chart(PIECHART, {
        type: 'doughnut',
        data: {
            labels: [
                "Completed",
                "Deposited",
                "Pending"
            ],
            datasets: [
                {
                    data: [{{$com}}, {{$depo}}, {{$pen}}],
                    borderWidth: [1, 1, 1],
                    backgroundColor: [
                        brandPrimary,
                        "rgba(75,192,192,1)",
                        "#FFCE56"
                    ],
                    hoverBackgroundColor: [
                        brandPrimary,
                        "rgba(75,192,192,1)",
                        "#FFCE56"
                    ]
                }]
        }
    });

});
 
 function printFunction() {
  window.print();
}
</script>
@endsection