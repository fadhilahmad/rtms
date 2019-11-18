@extends ('layouts.layout')
@section ('content')
<div>
    <div class="card-header">Dashboard</div>
    <div class="card-body">

    </div>
    <section class="dashboard-counts section-padding">
        <div class="container-fluid">
          <div class="row">
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-user"></i></div>
                <div class="name"><strong class="text-uppercase">Registered End Users</strong>
                  <div class="count-number">{{$end_user}}</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-padnote"></i></div>
                <div class="name"><strong class="text-uppercase">Active Agents</strong>
                  <div class="count-number">{{$agent}}</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-check"></i></div>
                <div class="name"><strong class="text-uppercase">Pending Application</strong>
                  <div class="count-number">{{$application}}</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-bill"></i></div>
                <div class="name"><strong class="text-uppercase">Submited Orders</strong>
                  <div class="count-number">{{$orders}}</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-list"></i></div>
                <div class="name"><strong class="text-uppercase">Invoice Quoted</strong>
                  <div class="count-number">{{$invoice}}</div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-list-1"></i></div>
                <div class="name"><strong class="text-uppercase">Payment Completed</strong>
                  <div class="count-number">{{$payment}}</div>
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
            <div class="col-lg-3 col-md-6">
              <div class="card to-do">
                <h2 class="display h4">Quick Links</h2>
<!--                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>-->
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
            </div>
            <!-- Pie Chart-->
            <div class="col-lg-3 col-md-6">
              <div class="card project-progress">
                <h2 class="display h4">Project Beta progress</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <div class="pie-chart">
                  <canvas id="pieChart" width="300" height="300"> </canvas>
                </div>
              </div>
            </div>
            <!-- Line Chart -->
            <div class="col-lg-6 col-md-12 flex-lg-last flex-md-first align-self-baseline">
              <div class="card sales-report">
                <h2 class="display h4">Sales marketing report</h2>
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor amet officiis</p>
                <div class="line-chart">
                  <canvas id="lineCahrt"></canvas>
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
                <div class="icon"><i class="icon-line-chart"></i></div>
                <div class="number">{{$income}}</div><strong class="text-primary">All Income</strong>
                <p>Total payment collected.</p>
              </div>
            </div>
            <div class="col-lg-4">
              <!-- Monthly Usage-->
              <div class="card data-usage">
                <h2 class="display h4">Disk Usage</h2>
                <div class="row d-flex align-items-center">
                  <div class="col-sm-6">
                    <div id="progress-circle" class="d-flex align-items-center justify-content-center"></div>
                  </div>
                  <div class="col-sm-6"><strong class="text-primary">80.56 Gb</strong><small>Current Plan</small><span>100 Gb</span></div>
                </div>
                <p>Keep below 80% for best perormance</p>
              </div>
            </div>
            <div class="col-lg-4">
              <!-- User Actibity-->
              <div class="card user-activity">
                <h2 class="display h4">Orders Activity</h2>
<!--                <div class="number">210</div>
                <h3 class="h4 display">Social Users</h3>
                <div class="progress">
                  <div role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>
                </div>-->
                <div class="page-statistics d-flex justify-content-between">
                  <div class="page-statistics-left"><span>Designing</span><strong>230</strong></div>
                  <div class="page-statistics-right"><span>Completed</span><strong>73.4%</strong></div>
                </div>
                <div class="page-statistics d-flex justify-content-between">
                  <div class="page-statistics-left"><span>Printing</span><strong>230</strong></div>
                  <div class="page-statistics-right"><span>Completed</span><strong>73.4%</strong></div>
                </div>
                <div class="page-statistics d-flex justify-content-between">
                  <div class="page-statistics-left"><span>Sewing</span><strong>230</strong></div>
                  <div class="page-statistics-right"><span>Completed</span><strong>73.4%</strong></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>
@endsection