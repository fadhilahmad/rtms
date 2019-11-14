@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Leave Application</div>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                <div class="card-body">
                   @if(!$leave->isempty())                
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Apply Date</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Total Day</th>
                                <th scope="col">Reason</th>
                                <th scope="col">File</th>
                                <th scope="col">Leave Type</th>
                                <th scope="col">Approve</th>
                                <th scope="col">Reject</th>
                              </tr>
                            </thead>
                            <tbody>                                
                                @foreach($leave as $lev)
                              <tr>
                                <td>{{$lev->u_fullname}}</td>
                                <td>{{$lev->apply_date}}</td>
                                <td>{{$lev->start_date}}</td>
                                <td>{{$lev->end_date}}</td>
                                <td>{{$lev->total_day}}</td>
                                <td>{{$lev->reason}}</td>
                                <td>
                                    @if($lev->file_url == NULL)
                                    -
                                    @else
                                      <form action="" method="POST">{{ csrf_field() }}
                                        <input class="btn btn-default" type="submit" value="Download">
                                        <input type="hidden" name="id" value=" {{$lev->l_id}}">
                                        <input type="hidden" name="file_url" value=" {{$lev->file_url}}">
                                        <input type="hidden" name="function" value="download">                                   
                                      </form>
                                    @endif
                                </td>
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
                                    <td>
                                      <form action="" method="POST">{{ csrf_field() }}
                                        <input class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to approve this application?')" value="/">
                                        <input type="hidden" name="id" value=" {{$lev->l_id}}">
                                        <input type="hidden" name="uid" value=" {{$lev->u_id}}">
                                        <input type="hidden" name="total_day" value=" {{$lev->total_day}}">
                                        <input type="hidden" name="leave_type" value=" {{$lev->l_type}}">
                                        <input type="hidden" name="function" value="approve">                                   
                                      </form>                                   
                                    </td>
                                    <td>
                                     <form action="" method="POST">{{ csrf_field() }}
                                        <input class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to reject this application?')" value="X">
                                        <input type="hidden" name="id" value=" {{$lev->l_id}}">
                                        <input type="hidden" name="function" value="reject">                                   
                                    </form>                                      
                                    </td> 
                              </tr>
                              @endforeach
                              {{ $leave->links() }}
                            </tbody>
                          </table>
                
                @else
                No application
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
