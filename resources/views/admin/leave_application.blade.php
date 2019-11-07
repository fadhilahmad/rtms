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
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Apply Date</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">Total Day</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Leave Type</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($leave as $lev)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$lev->u_fullname}}</td>
                                <td>{{$lev->apply_date}}</td>
                                <td>{{$lev->start_date}}</td>
                                <td>{{$lev->start_date}}</td>
                                <td>{{$lev->raeson}}</td>
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
                                    <a class="btn btn-primary" href="{{route('leave_application',[$lev->l_id,'app'])}}"><i class="fa fa-ticket"></i></a> |
                                    <a class="btn btn-danger" href="{{route('leave_application', [$lev->l_id,'rej'])}}"><i class="fa fa-trash-o"></i></a>                                    
                                </td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              {{ $leave->links() }}
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
