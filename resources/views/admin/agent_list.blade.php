@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Agent List</div>

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
                                @foreach($agent as $agents)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$agents->u_fullname}}</td>
                                <td>{{$agents->username}}</td>
                                <td>{{$agents->email}}</td>
                                <td>{{$agents->phone}}</td>
                                <td>
                                    <form class="delete" action="{{route('edit_agent', $agents->u_id)}}" method="POST">
                                        <input type="hidden" name="id" value=" {{$agents->u_id}}">
                                        {{ csrf_field() }}
                                    <input class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this agent?')" value="Delete">
                                    </form>
                                </td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              {{ $agent->links() }}
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
