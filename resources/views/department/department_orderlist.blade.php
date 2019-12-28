@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 70% !important; 
}
td,th {
text-align: center;
} 
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                @endif               

                <div class="card-body">
                    @if(Auth::user()->u_type==3)
                        <div class="card-header">DESIGNER ORDER LIST</div><br>
                        @php $no=1; @endphp
                                    @foreach($orders as $order)
                            <div class="panel panel-primary">
                                <div class="panel-heading">Order Status : @if($order->o_status==0) Draft @else Customer Request Redesign @endif</div>                                                                  
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">File name</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->file_name}}</div>
                                    </div><br> 
                                    <div class="row">
                                        <div class="col-sm-3">Quantity</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->quantity_total}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Material</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->m_desc}}</div>
                                    </div><br>                                    
                                    <div class="row">
                                        <div class="col-sm-3">Note</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->note}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Delivery Date</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->delivery_date}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Mockup Design</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">
                                    @php
                                        $show = App\Http\Controllers\HomeController::getMockup($order->o_id);
                                    @endphp                                            
                                        <img class="" src="{{url('orders/mockup/'.$show)}}" width="200" height="200">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-8">
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#Modal" data-tittle="Update Design" data-role="designer" 
                                            data-oid="{{$order->o_id}}" data-uid="{{$order->u_id_designer}}">Update Design
                                        </button>                                         
                                        </div>                                                                                 
                                    </div>                                    
                                </div>                                
                            </div>
                          @php $no++; @endphp
                                  @endforeach
                    @endif

                    @if($department==4 || $department==5)
                        <div class="card-header">ORDER LIST</div><br>
                        @php $no=1; @endphp
                        @foreach($orders as $order)
                        <div class="row">
                            <div class="col-sm-12"><center>REF NO : {{$order->ref_num}}</center></div>
                        </div><br>
                           <table class="table table-hover">
                                  <tr>
                                    <thead class="thead-light">
                                    <th scope="col">Status</th>
                                    <td>@if($order->o_status=3) Waiting to print @else($order->o_status=5) Waiting to sew @endif</td>
                                    </thead>
                                  </tr>
                                  <tr>
                                    <thead class="thead-light">
                                    <th scope="col">File Name</th>
                                    <td>{{$order->file_name}}</td>
                                    </thead>
                                  </tr>
                                  <tr>
                                    <thead class="thead-light">
                                    <th scope="col">Quantity</th>
                                    <td>{{$order->quantity_total}}</td>
                                    </thead>
                                  </tr>
                                  <tr>
                                    <thead class="thead-light">
                                    <th scope="col">Material</th>
                                    <td>{{$order->m_desc}}</td>
                                    </thead>
                                  </tr>
                                  <tr>
                                    <thead class="thead-light">
                                    <th scope="col">Note</th>
                                    <td>{{$order->note}}</td>
                                    </thead>
                                  </tr>
                                  <tr>
                                    <thead class="thead-light">
                                    <th scope="col">Delivery Date</th>
                                    <td>{{$order->delivery_date}}</td>
                                    </thead>
                                  </tr>
                                  <tr>
                                    <thead class="thead-light">
                                    <td colspan="2">
                                        <form class="lock" action="{{ route('update_order') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="oid" value=" {{$order->o_id}}">
                                                @php if(Auth::user()->u_type==5){$role='print';}if(Auth::user()->u_type==4){$role='tailor';} @endphp
                                                <input type="hidden" name="role" value=" {{$role}}">
                                            <input class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to lock this order?')" value="Lock">
                                        </form>
                                    </td>
                                    </thead>
                                  </tr>
                           </table><br>
                           <hr><br>
                        
<!--                            <div class="panel panel-primary">                                                                 
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">Order Status</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">@if($order->o_status=3) Waiting to print @else($order->o_status=5) Waiting to sew @endif</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">File name</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->file_name}}</div>
                                    </div><br> 
                                    <div class="row">
                                        <div class="col-sm-3">Quantity</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->quantity_total}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Material</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->m_desc}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Note</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->note}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Delivery Date</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{ date('d/m/Y', strtotime($order->delivery_date)) }}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-8">
                                            <form class="lock" action="{{ route('update_order') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="oid" value=" {{$order->o_id}}">
                                                @php if(Auth::user()->u_type==5){$role='print';}if(Auth::user()->u_type==4){$role='tailor';} @endphp
                                                <input type="hidden" name="role" value=" {{$role}}">
                                            <input class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to lock this order?')" value="Lock">
                                            </form>                                        
                                        </div>                                                                                 
                                    </div>                                    
                                </div>                                
                            </div>-->
                          @php $no++; @endphp
                         @endforeach
                    @endif                    
                                      
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
                    <input type="hidden" name="role" id="role">
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

<script type="text/javascript">
$(document).on("click", ".edit", function () {
     var name = $(this).data('tittle');
     var oid = $(this).data('oid');
     var uid = $(this).data('uid');
     var role = $(this).data('role');
     $(".modal-title").text( name );
     $(".modal-body #oid").val( oid );
     $(".modal-body #uid").val( uid );
     $(".modal-body #note").val( "" );
     $(".modal-body #role").val( role );

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
