@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-child"></i>  Staff Application List</div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
               
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Position</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @forelse($staff as $sta)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$sta->u_fullname}}</td>
                                <td>{{$sta->username}}</td>
                                <td>{{$sta->email}}</td>
                                <td>{{$sta->phone}}</td>
                                <td>
                                        @if($sta->u_type==3)
                                           Designer
                                        @endif
                                        @if($sta->u_type==4)
                                           Tailor
                                        @endif
                                        @if($sta->u_type==5)
                                           Printing
                                        @endif                                
                                </td>                                
                                <td>
                                    <a class="btn btn-primary" href="{{route('staff_approve',[$sta->u_id,'app'])}}"><i class="fa fa-check"></i></a> |
                                    <a class="btn btn-danger" href="{{route('staff_approve', [$sta->u_id,'rej'])}}"><i class="fa fa-times"></i></a>
                                </td>
                              </tr>
                              <?php $no++; ?>
                              @empty
                            <td>No new application</td>
                              @endforelse
                              {{ $staff->links() }}
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
