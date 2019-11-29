@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">Staff List</div> -->
                <div class="card-header"><i class="fa fa-child"></i> Staff List<a class="btn btn-primary float-right" href="{{ url('admin/add_newstaff') }}"><i class="fa fa-plus"></i> New Staff</a></div>

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
                                @foreach($staffs as $staff)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$staff->u_fullname}}</td>
                                <td>{{$staff->username}}</td>
                                <td>{{$staff->email}}</td>
                                <td>{{$staff->phone}}</td>  
                                <td>
                                        @if($staff->u_type==3)
                                           Designer
                                        @endif
                                        @if($staff->u_type==4)
                                           Tailor
                                        @endif
                                        @if($staff->u_type==5)
                                           Printing
                                        @endif                                
                                </td>
                                <td>
                                    <form class="delete" action="{{route('edit_staff', $staff->u_id)}}" method="POST">
                                        <input type="hidden" name="id" value=" {{$staff->u_id}}">
                                        {{ csrf_field() }}
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this customer?')" value="Delete"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </td>
<!--                                <td><a class="btn btn-danger" onclick="return confirm('Are you sure to delete this customer?')" href=""><i class="fa fa-trash"></i></a></td>-->
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              {{ $staffs->links() }}
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
