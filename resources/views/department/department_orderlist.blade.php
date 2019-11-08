@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                @endif
               
                <div class="card-header">Order List</div>

                <div class="card-body">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Cloth Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Mockup Design</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @php $no=1; @endphp
                                    @foreach($orders as $order)
                                  <tr>
                                    <td>{{$no}}</td>
                                    <td>{{$order->file_name}}</td>
                                    <td>{{$order->category}}</td>
                                    <td>{{$order->quantity_total}}</td>
                                    <td>{{$order->note}}</td>
                                    <td>{{$order->delivery_date}}</td>
                                    <td><button class="btn btn-primary">View</button></td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#Modal" data-tittle="Update Design" 
                                            data-oid="{{$order->o_id}}" data-uid="{{$order->u_id_designer}}">Update Design
                                        </button>                                       
                                    </td>
                                  </tr>
                                  @php $no++; @endphp
                                  @endforeach
                                </tbody>
                            </table> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form enctype="multipart/form-data" method="POST" id="designform" name="designform" action="{{ route('update_order') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Update Design</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="note" class="col-sm-4 col-form-label">Note</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="note" name="note" >
                    <input type="hidden" name="u_id" id="uid">
                    <input type="hidden" name="o_id" id="oid">
                </div>
              </div> 

              <div class="form-group row" id="neckdiv">
                <label for="design" class="col-sm-4 col-form-label">Design</label>
                <div class="col-sm-8">
                    <input id="design" type="file" class="form-control" name="design">
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
$(document).on("click", ".edit", function () {
     var name = $(this).data('tittle');
     var oid = $(this).data('oid');
     var uid = $(this).data('uid');
     $(".modal-title").text( name );
     $(".modal-body #oid").val( oid );
     $(".modal-body #uid").val( uid );
     $(".modal-body #note").val( "" );

});

  function validateForm() {
    var x = document.forms["designform"]["design"].value;
        if (x == "") 
        {
        alert("Please insert image");
        return false;
        }
        else
        {
          document.getElementById("designform").submit();  
        }       
    }
</script>
@endsection
