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
<div class="container">
    <div class="row justify-content-center">
        <div class="card-profile">
            <div class="card-header d-flex align-items-center">
                <h4><i class="fa fa-table"></i> Leave Balance</h4>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Annual Leave</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" value="{{$days->al_day  }}" readonly>
                    </div>
                    <label class="col-sm-3 col-form-label">Emergency Leave</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" value="{{$days->el_day  }}" readonly>
                    </div>
                    <label class="col-sm-1 col-form-label">MC</label>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" value="{{$days->mc_day  }}" readonly>
                    </div>                    
                </div>                 
            </div>
        </div>    
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="card-profile">
            <div class="card-header d-flex align-items-center">
                <h4><i class="fa fa-tag"></i> Leave List</h4>
            </div>
            <div class="card-body">
                <div class="form-group row">
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
                          <td>{{$leav->raeson}}</td>
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
                </div>                 
            </div>
        </div>    
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
           
        <div class="card-profile">
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
                <form method="post" action="{{ route('department.leave') }}" >
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
                            <input type="date" name="apply_date" id="applyDate"  value= "{{ old('apply_date', $today) }}" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Start Date</label>
                        <div class="col-sm-8">
                            <input type="date" name="start_date" id="startDate"  value= "{{ old('start_date') }}" class="form-control">
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">End Date</label>
                        <div class="col-sm-8">
                            <input type="date" name="end_date" id="endDate"  value= "{{ old('end_date') }}" class="form-control">
                        </div>
                    </div>                
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Leave Type</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="leave_type">
                                <option selected>Please select</option>
                                <option value="1">Annual Leave</option>
                                <option value="2">Emergency Leave</option>
                                <option value="3">MC</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Reason</label>
                        <div class="col-sm-8">
                            <input type="text" id="reason"  name="reason" value= "{{ old('reason') }}" class="form-control" required>
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

@endsection
