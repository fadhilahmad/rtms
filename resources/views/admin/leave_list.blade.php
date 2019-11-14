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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Leave List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!$leave->isempty())
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Total Day</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Leave Type</th>
                              </tr>
                            </thead>
                            <tbody>                                
                                @foreach($leave as $lev)
                              <tr>
                                <td>{{$lev->u_fullname}}</td>
                                <td>{{$lev->start_date}}</td>
                                <td>{{$lev->end_date}}</td>
                                <td>{{$lev->total_day}}</td>
                                <td>{{$lev->reason}}</td>
                                <td>
                                        @if($lev->l_type==1)
                                           Annual
                                        @endif
                                        @if($lev->l_type==2)
                                           Emergency
                                        @endif
                                        @if($lev->l_type==3)
                                           MC
                                        @endif                                
                                </td> 
                              </tr>
                              @endforeach
                              {{ $leave->links() }}
                            </tbody>
                          </table>                    
                    
                    
                    @else
                    No approved leave
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
