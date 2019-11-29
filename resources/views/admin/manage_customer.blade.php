@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-user"></i> End User List<a class="btn btn-primary float-right" href="{{ url('admin/add_customer') }}"><i class="fa fa-plus"></i> New End User</a></div>
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
                                <th scope="col">Address</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($customer as $cust)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$cust->u_fullname}}</td>
                                <td>{{$cust->username}}</td>
                                <td>{{$cust->address}}</td>
                                <td>{{$cust->email}}</td>
                                <td>{{$cust->phone}}</td>
                                <td>
                                    <form class="delete" action="{{route('edit_customer', $cust->u_id)}}" method="POST">
                                        <input type="hidden" name="id" value=" {{$cust->u_id}}">
                                        {{ csrf_field() }}
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this customer?')" value="Delete"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </td>
<!--                                <td><a class="btn btn-danger" onclick="return confirm('Are you sure to delete this customer?')" href="{{route('edit_customer', $cust->u_id)}}"><i class="fa fa-trash"></i></a></td>-->
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              {{ $customer->links() }}
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
