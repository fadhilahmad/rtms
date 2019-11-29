@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">Agent List</div> -->
                <div class="card-header"><i class="fa fa-user-circle"></i> Agent List<a class="btn btn-primary float-right" href="{{ url('admin/add_agent') }}"><i class="fa fa-plus"></i> New Agent</a></div>

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
                                <th scope="col">Tier</th>
                                <th scope="col">Update</th>
                                <th scope="col">Delete</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($agent as $agents)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$agents->u_fullname}}</td>
                                <td>{{$agents->username}}</td>
                                <td>{{$agents->address}}</td>
                                <td>{{$agents->email}}</td>
                                <td>{{$agents->phone}}</td>
                                <td>@if($agents->u_type == 6)
                                    1
                                    @elseif($agents->u_type == 8)
                                    2
                                    @elseif($agents->u_type == 9)
                                    3
                                    @endif
                                </td>
                                <td>
                                    <button 
                                        class="btn btn-primary update" data-toggle="modal" data-target="#agentTier" data-username="{{$agents->username}}" data-tier="{{$agents->u_type}}"
                                        data-uid="{{$agents->u_id}}" data-fullname="{{$agents->u_fullname}}"><i class="fa fa-refresh"></i> 
                                    </button>                                 
                                </td>
                                <td>
                                    <form class="delete" action="{{route('edit_agent')}}" method="POST">
                                        <input type="hidden" name="id" value=" {{$agents->u_id}}">
                                        <input type="hidden" name="function" value="delete">
                                        {{ csrf_field() }}
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this agent?')" value="Delete"><i class="fa fa-trash"></i> </button>
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

<div class="modal fade" id="agentTier" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="tierUpdate" name="tierUpdate" action="{{route('edit_agent')}}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Agent Tier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Agent Name</label>
                <div class="col-sm-8">
                    <input type="text" name="name" class="form-control" id="name" disabled="disable">
                    <input type="hidden" name="id" id="uid">
                    <input type="hidden" name="function" value="update">
                </div>
              </div>
              <div class="form-group row">
                <label for="username" class="col-sm-4 col-form-label">Username</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="username" name="username" disabled="disable">
                </div>
              </div>
              <div class="form-group row">
                <label for="tier" class="col-sm-4 col-form-label">Tier</label>
                <div class="col-md-6">
                    <select id="tier" name="tier" class="form-control">
                        <option value="6">Tier 1</option>
                        <option value="8">Tier 2</option>
                        <option value="9">Tier 3</option>
                    </select>
                </div>
              </div>                
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="validateForm()" type="submit" class="btn btn-primary">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on("click", ".update", function () {
     var name = $(this).data('fullname');
     var username = $(this).data('username');
     var tier = $(this).data('tier');
     var id = $(this).data('uid');
     $(".modal-body #name").val( name );
     $(".modal-body #username").val( username );
     $(".modal-body #uid").val( id );
     $(".modal-body #tier").val( tier );
});
   
  function validateForm() {
          document.getElementById("tierUpdate").submit();        
    }
</script>
@endsection
