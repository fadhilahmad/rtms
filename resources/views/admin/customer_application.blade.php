@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-user-circle"></i> Agent Application List</div>

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
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @forelse($agent as $agents)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$agents->u_fullname}}</td>
                                <td>{{$agents->username}}</td>
                                <td>{{$agents->email}}</td>
                                <td>{{$agents->phone}}</td>                                
                                <td>
                                    <a class="btn btn-primary" href="{{route('approve',[$agents->u_id,'app'])}}"><i class="fa fa-check"></i></a> |
                                    <a class="btn btn-danger" href="{{route('approve', [$agents->u_id,'rej'])}}"><i class="fa fa-times"></i></a>
                                </td>
                              </tr>
                              <?php $no++; ?>
                              @empty
                            <td>No new application</td>
                              @endforelse
                              {{ $agent->links() }}
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-user"></i> End User Application List</div>

                <div class="card-body">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @forelse($customer as $cust)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$cust->u_fullname}}</td>
                                <td>{{$cust->username}}</td>
                                <td>{{$cust->email}}</td>
                                <td>{{$cust->phone}}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{route('approve', [$cust->u_id,'app'])}}"><i class="fa fa-check"></i></a> |
                                    <a class="btn btn-danger" href="{{route('approve', [$cust->u_id,'rej'])}}"><i class="fa fa-times"></i></a>
                                </td>
                              </tr>
                              <?php $no++; ?>
                              @empty
                            <td>No new application</td>
                              @endforelse
                              {{ $customer->links() }}
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
