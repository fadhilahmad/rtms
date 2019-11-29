@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 100% !important; 
}
td,th {
text-align: center;
} 
</style>
<div class="container col-md-12">
    <div class="row justify-content-center">
        <div class="card-leave">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif            
            <div class="card-header d-flex align-items-center">
                <h4><i class="fa fa-table"></i> Leave Balance</h4>
            </div>
            <div class="card-body">
                <div class="form-group row days">
                    <label class="col-sm-2 col-form-label">Annual Leave</label>
                    <div class="col-sm-2">
                        @if($days)
                        <input class="form-control" id="al" type="text" value="{{$days->al_day  }}" readonly>
                        @else
                        <input class="form-control" id="al" type="text" value="0" readonly>
                        @endif
                    </div>
                    <label class="col-sm-3 col-form-label">Emergency Leave</label>
                    <div class="col-sm-2">
                        @if($days)
                        <input class="form-control" id="el" type="text" value="{{$days->el_day  }}" readonly>
                        @else
                        <input class="form-control" id="el" type="text" value="0" readonly>
                        @endif
                    </div>
                    <label class="col-sm-1 col-form-label">MC</label>
                    <div class="col-sm-2">
                         @if($days)
                        <input class="form-control" id="mc" type="text" value="{{$days->mc_day  }}" readonly>
                        @else
                        <input class="form-control" id="mc" type="text" value="0" readonly>
                        @endif
                    </div>                    
                </div>                 
            </div>
        </div>    
    </div>
</div>
<div class="container col-md-12">
    <div class="row justify-content-center">       
        <div class="card-leave">
            <div class="card-header d-flex align-items-center">
                <h4><i class="fa fa-tag"></i> Leave List</h4>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    @if(!$leave->isempty())
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Apply Date</th>
                          <th scope="col">Start Date</th>
                          <th scope="col">End Date</th>
                          <th scope="col">Leave Type</th>
                          <th scope="col">Reason</th>
                          <th scope="col">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $no=1; @endphp
                        @forelse($leave as $leav)
                        <tr>
                          <th scope="row">{{$no}}</th>
                          <td>{{$leav->apply_date}}</td>
                          <td>{{$leav->start_date}}</td>
                          <td>{{$leav->end_date}}</td>
                          <td>
                                        @if($leav->l_type==1)
                                           Annual
                                        @endif
                                        @if($leav->l_type==2)
                                           Emergency
                                        @endif
                                        @if($leav->l_type==3)
                                           MC
                                        @endif
                          </td>
                          <td>{{$leav->reason}}</td>
                          <td>
                                        @if($leav->l_status==0)
                                           Rejected
                                        @endif
                                        @if($leav->l_status==1)
                                           Approved
                                        @endif
                                        @if($leav->l_status==2)
                                           Pending
                                        @endif
                          </td>
                        </tr>
                        @php $no++; @endphp
                        @empty
                        No leave application
                        @endforelse
                      </tbody>
                    </table>
                    @else
                    No leave application
                    @endif
                </div>                 
            </div>
        </div>
    </div>
</div>
<div class="container col-md-12" style="margin-bottom:10%">
    <div class="row justify-content-center">
           
        <div class="card-leave">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
             @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                   <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card-header d-flex align-items-center">
                <h4><i class="fa fa-edit"></i> Leave Application</h4>
            </div>
            <div class="card-body">
                *End date is your start working date<br><br>
                <form enctype="multipart/form-data" method="post" action="{{ route('department.leave') }}" >
                <!-- <form > -->
                <?php 

                $month = date('m');
                $day = date('d');
                $year = date('Y');

                $today = $year . '-' . $month . '-' . $day;
                ?>
                {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Apply Date</label>
                        <div class="col-sm-8">
                            <input type="date" name="apply_date" id="applyDate"  value= "{{ old('apply_date', $today) }}" class="form-control" readonly="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Leave Type</label>
                        <div class="col-sm-8 leave">
                            <select class="form-control" id="leaveType" name="leave_type">
                                <option value="1">Annual Leave</option>
                                <option value="2">Emergency Leave</option>
                                <option value="3">MC</option>
                            </select>
                        </div>
                    </div>                

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Start Date</label>
                        <div class="col-sm-8 startDate">
                            <input type="date" min="{{$today}}" name="start_date" id="startDate" class="form-control" required="">
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">End Date</label>
                        <div class="col-sm-8 endDate">
                            <input type="date" oninput="validateDay()" name="end_date" id="endDate"  value= "{{ old('end_date') }}" class="form-control" required="">
                        </div>
                    </div> 
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Total Day</label>
                        <div class="col-sm-8 reason">
                            <input type="text" id="totalDay"  name="total_day" id="totalDay" value="" class="form-control" readonly="">
                        </div>
                    </div>                
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Reason</label>
                        <div class="col-sm-8 reason">
                            <input type="text" id="reason"  name="reason" value= "{{ old('reason') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Supporting File</label>
                        <div class="col-sm-8">
                            <input type="file" id="support"  name="support" class="form-control">
                        </div>
                    </div>                
                                                                           
                    <div class="form-group row">       
                        <div class="col-sm-8 offset-sm-2">
                            <input type="hidden" name="u_id" value="{{$staff->u_id}}">
                            <input type="submit" value="Submit" class="btn btn-primary float-right ">
                        </div>
                      
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).on("click", ".endDate", function () {
     var date = new Date($('#startDate').val());
     var leave = $(".leave #leaveType").val();
     var al = $(".days #al").val();
     var el = $(".days #el").val();
     var mc = $(".days #mc").val();

    dd = date.getDate()+01;
    var alday = date.getDate()+ al;
    var elday = date.getDate()+ el;
    var mcday = date.getDate()+ mc;
    mm = date.getMonth() + 1;
    year = date.getFullYear();
      if(isNaN(dd)){
         alert('Please select start date first');
     }   
    if (dd < 10) {
    dd = '0' + dd;
    } 
    if (mm < 10) {
    mm = '0' + mm;
    }
    
    document.getElementById('endDate').setAttribute("min", year+'-'+mm+'-'+dd);
    
    //console.log(alday);
});

function validateDay() {
     var start = new Date($('#startDate').val());
     var end = new Date($('#endDate').val());
     var leave = $(".leave #leaveType").val();
     var al = $(".days #al").val();
     var el = $(".days #el").val();
     var mc = $(".days #mc").val();

    var diff = dateDifference(start, end);
    
    if(leave == 1){
        
      if(diff==0){
          alert('Leave must be more than one day');
           $('#endDate').val("");
           $('#totalDay').val("");
      }else{
      
      if(diff>al){
                
          alert("Not enough annual leave balance");
          $('#endDate').val("");
          $('#totalDay').val("");
        }else{
            document.getElementById('totalDay').value=diff;
        }      
      }
    }
    if(leave == 2){
        
      if(diff==0){
          alert('Leave must be more than one day');
           $('#endDate').val("");
           $('#totalDay').val("");
      }else{
      
      if(diff>el){
                
          alert("Not enough emergency leave balance");
          $('#endDate').val("");
          $('#totalDay').val("");
        }else{
          document.getElementById('totalDay').value=diff;  
        }       
      }
    }
    if(leave == 3){
        
      if(diff==0){
          alert('Leave must be more than one day');
           $('#endDate').val("");
           $('#totalDay').val("");
      }else{
      
      if(diff>mc){
                
          alert("Not enough MC balance");
          $('#endDate').val("");
          $('#totalDay').val("");
        }else{
         document.getElementById('totalDay').value=diff;   
        }       
      }
    }  
    
    console.log(diff);
}

// Expects start date to be before end date
// start and end are Date objects
function dateDifference(start, end) {

  // Copy date objects so don't modify originals
  var s = new Date(+start);
  var e = new Date(+end);

  // Set time to midday to avoid dalight saving and browser quirks
  s.setHours(12,0,0,0);
  e.setHours(12,0,0,0);

  // Get the difference in whole days
  var totalDays = Math.round((e - s) / 8.64e7);

  // Get the difference in whole weeks
  var wholeWeeks = totalDays / 7 | 0;

  // Estimate business days as number of whole weeks * 5
  var days = wholeWeeks * 5;

  // If not even number of weeks, calc remaining weekend days
  if (totalDays % 7) {
    s.setDate(s.getDate() + wholeWeeks * 7);

    while (s < e) {
      s.setDate(s.getDate() + 1);

      // If day isn't a Sunday or Saturday, add to business days
      if (s.getDay() != 0 && s.getDay() != 6) {
        ++days;
      }
    }
  }
  return days;
}
</script>

@endsection
