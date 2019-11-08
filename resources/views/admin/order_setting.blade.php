@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 80% !important; 
}
td,th {
text-align: center;
} 
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Order Setting</div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <center><h2>MATERIAL <a href="" class="popup" data-toggle="modal" data-target="#orderModal" data-tittle="Add Material" data-table="material" >+</a></h2></center><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Description</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($material as $mat)
                                  <tr>
                                    <td>{{$mat->m_desc}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Material" data-table="material"
                                            data-id="{{$mat->m_id}}" data-desc="{{$mat->m_desc}}">/
                                        </button>                                       
                                    </td>
                                    <td>
                                     <form class="delete" action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                        <input class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this material?')" value="X">
                                        <input type="hidden" name="id" value=" {{$mat->m_id}}">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="table" value="material">                                   
                                    </form>                                      
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>                                                                         
                        </div>
                        
                        <div class="col-md-6">
                            <center><h2>BODY <a href="" class="popup" data-toggle="modal" data-target="#orderModal" data-tittle="Add Body Type" data-table="body">+</a></h2></center><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Description</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($body as $bod)
                                  <tr>
                                    <td>{{$bod->b_desc}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Body Type" data-table="body"
                                            data-id="{{$bod->b_id}}" data-desc="{{$bod->b_desc}}">/
                                        </button>                                   
                                    </td>
                                    <td>
                                     <form class="delete" action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                        <input class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this body type?')" value="X">
                                        <input type="hidden" name="id" value=" {{$bod->b_id}}">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="table" value="body">                                   
                                    </form>                                      
                                    </td>                                    
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>                                                                         
                        </div>
                        
                    </div>
                    
                    <hr>
                    <br><br>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <center><h2>DELIVERY DAY</h2></center><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Minimum Day</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>

                                  <tr>
                                    <td>{{$delivery[0]->min_day}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Delivery Day" data-table="delivery" 
                                            data-id="{{$delivery[0]->ds_id}}" data-desc="{{$delivery[0]->min_day}}">Edit
                                        </button>                                   
                                    </td>
                                  </tr>
                                </tbody>
                            </table>                                                                         
                        </div>
                                           
                        <div class="col-md-6">
                            <center><h2>SLEEVE</h2></center><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col" >Description</th>
                                    <th scope="col" >Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($sleeve as $sle)
                                  <tr>
                                    <td>{{$sle->sl_desc}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Sleeve" data-table="sleeve" 
                                            data-id="{{$sle->sl_id}}" data-desc="{{$sle->sl_desc}}">Edit
                                        </button>                                   
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>                                                                         
                        </div>                       
                    </div> 
                    
                    <hr>
                    <br><br>
                        <div class="col-md-12">
                            <center><h2>NECK <a href="" class="popup" data-toggle="modal" data-target="#orderModal" data-tittle="Add Neck Type" data-table="neck">+</a></h2></center><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($neck as $nec)
                                  <tr>
                                    <td>{{$nec->n_desc}}</td>
                                    <td><img class="" src="{{url('uploads/'.$nec->n_url)}}" width="200" height="200"></td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Neck" data-table="neck" 
                                            data-id="{{$nec->n_id}}" data-desc="{{$nec->n_desc}}">/
                                        </button>                                   
                                    </td>
                                    <td>
                                     <form class="delete" action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                        <input class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this neck type?')" value="X">
                                        <input type="hidden" name="id" value=" {{$nec->n_id}}">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="table" value="neck">                                   
                                    </form>                                      
                                    </td>                                    
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>                                                                         
                        </div>
                                      
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form enctype="multipart/form-data" method="POST" id="orderform" name="orderform" action="{{ route('order_setting') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Order Setting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Description</label>
                <div class="col-sm-8">
                    <input type="text" min="0" class="form-control" id="description" name="description" required="required" >
                    <input type="hidden" name="id" id="itemId">
                    <input type="hidden" name="type" id="type">
                    <input type="hidden" name="table" id="table">
                </div>
              </div> 

              <div class="form-group row" id="neckdiv">
                <label for="neck_image" class="col-sm-4 col-form-label">Neck Image</label>
                <div class="col-sm-8">
                    <input id="neck_image" type="file" class="form-control" name="neck_image">
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

<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
$(document).on("click", ".popup", function () {
     var name = $(this).data('tittle');
     var table = $(this).data('table');
     $(".modal-title").text( name );
     $(".modal-body #description").val( "" );
     $(".modal-body #type").val( "add" );
     $(".modal-body #table").val( table );
     $(".modal-body #neckdiv").hide();
     document.getElementById('description').type = 'text';
     
     if(table=="neck"){
         $(".modal-body #neckdiv").show();
         console.log('sampai');
     }
//     console.log(table);
});

$(document).on("click", ".edit", function () {
     document.getElementById('description').type = 'text';
     var name = $(this).data('tittle');
     var id = $(this).data('id');
     var desc = $(this).data('desc');
     var table = $(this).data('table');
     $(".modal-title").text( name );
     $(".modal-body #description").val( desc );
     $(".modal-body #type").val( "update" );
     $(".modal-body #itemId").val( id );
     $(".modal-body #table").val( table );
     $(".modal-body #neckdiv").hide();
    
     if(table=="delivery"){
         document.getElementById('description').type = 'number';
         console.log('sampai');
     }
//     console.log(table);
});
  
  function validateForm() {
    var x = document.forms["orderform"]["description"].value;
        if (x == "") 
        {
        alert("Description must be filled out");
        return false;
        }
        else
        {
          document.getElementById("orderform").submit();  
        }       
    }
</script>
@endsection
