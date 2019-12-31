@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-gear"></i>  Leave Setting</div>

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
                                <th scope="col">Position</th>
                                <th scope="col">Annual</th>
                                <th scope="col">Emergency</th>
                                <th scope="col">MC</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($staff as $sta)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$sta->u_fullname}}</td> 
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
                                <td>{{$sta->al_day}}</td>
                                <td>{{$sta->el_day}}</td>
                                <td>{{$sta->mc_day}}</td>
                                @if($leave->where('u_id',$sta->u_id)->isempty())
                                <td>
                                    <button 
                                        class="btn btn-primary add" data-toggle="modal" data-target="#addnew" 
                                        data-uid="{{$sta->u_id}}" data-fullname="{{$sta->u_fullname}}"><i class="fa fa-plus"></i> Add
                                    </button>
                                </td>
                                @else
                                <td>
                                    <button 
                                        class="btn btn-secondary update" data-toggle="modal" data-target="#update" 
                                        data-uid="{{$sta->u_id}}" data-fullname="{{$sta->u_fullname}}"
                                        data-alday="{{$sta->al_day}}" data-elday="{{$sta->el_day}}" data-mcday="{{$sta->mc_day}}">Update
                                    </button>
                                </td>
                                @endif
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              {{ $staff->links() }}
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal to add leave -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="addform" name="addform" action="{{ route('leave_setting') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Leave Day</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Name</label>
                <div class="col-sm-8">
                    <input type="text" name="name" class="form-control" id="staffname" disabled="disable">
                    <input type="hidden" name="uid" id="uid">
                </div>
              </div>
              <div class="form-group row">
                <label for="alday" class="col-sm-4 col-form-label">Annual Leave</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="alday" name="alday" required="required" >
                </div>
              </div>
              <div class="form-group row">
                <label for="elday" class="col-sm-4 col-form-label">Emergency Leave</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="elday" name="elday" required="required">
                </div>
              </div>
              <div class="form-group row">
                <label for="mcday" class="col-sm-4 col-form-label">MC Leave</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="mcday" name="mcday" required="required">
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
<!-- modal to update leave -->
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="updateform" action="{{ route('leave_update') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Leave Day</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Name</label>
                <div class="col-sm-8">
                    <input type="text" name="name" class="form-control" id="ustaffname" disabled="disable">
                    <input type="hidden" name="uid" id="uuid">
                </div>
              </div>
              <div class="form-group row">
                <label for="alday" class="col-sm-4 col-form-label">Annual Leave</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="ualday" name="alday" required="required" >
                </div>
              </div>
              <div class="form-group row">
                <label for="elday" class="col-sm-4 col-form-label">Emergency Leave</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="uelday" name="elday" required="required">
                </div>
              </div>
              <div class="form-group row">
                <label for="mcday" class="col-sm-4 col-form-label">MC Leave</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="umcday" name="mcday" required="required">
                </div>
              </div>                
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="form_update()" type="submit" class="btn btn-primary">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on("click", ".add", function () {
     var name = $(this).data('fullname');
     var id = $(this).data('uid');
     $(".modal-body #staffname").val( name );
     $(".modal-body #uid").val( id );
});

$(document).on("click", ".update", function () {
     var name = $(this).data('fullname');
     var id = $(this).data('uid');
     var al = $(this).data('alday');
     var el = $(this).data('elday');
     var mc = $(this).data('mcday');
     $(".modal-body #ustaffname").val( name );
     $(".modal-body #uuid").val( id );
     $(".modal-body #ualday").val( al );
     $(".modal-body #uelday").val( el );
     $(".modal-body #umcday").val( mc );
});

  function form_submit() {
    document.getElementById("addform").submit();   
   } 
   
  function form_update() {
    document.getElementById("updateform").submit();
   }
   
  function validateForm() {
    var x = document.forms["addform"]["alday"].value;
    var y = document.forms["addform"]["elday"].value;
    var z = document.forms["addform"]["mcday"].value;
        if (x == "") {
            alert("Annual leave must be filled out");
        return false;
        }
        if(y == ""){
            alert("Emergency leave must be filled out");
        return false;
        }
        if(z == ""){
            alert("MC leave must be filled out");
        return false;
        }else{
          document.getElementById("addform").submit();  
        }       
    }
</script>
@endsection
