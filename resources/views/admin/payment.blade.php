@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 100% !important; 
}
td,th {
text-align: center;
}

</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Payment List</div>

                <div class="card-body">
                   @if(!$orders->isempty())
                   <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">Ref No</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">File name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Paid</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Update</th>
                              </tr>
                            </thead>
                            <tbody>
              
                                @foreach($orders as $ord)
                              <tr>
                                <th scope="row">{{$ord->ref_num}}</th>
                                <td>{{$ord->u_fullname}}</td>
                                <td>{{$ord->file_name}}</td>
                                <td>{{$ord->quantity_total}}</td>
                                <td>{{$ord->total_price}}</td>
                                @php $paid = $receipt->where('o_id',$ord->o_id)->first();  
                                        if(!$paid){
                                            $paid = 0;
                                            $operation = "insert";
                                            $re_id = "0";
                                        }else{
                                            $paid = $paid->total_paid;
                                            $operation = "update";
                                            $re_id = $receipt->where('o_id',$ord->o_id)->first();
                                        }                               
                                @endphp
                                <td>{{$paid}}</td>
                                <td>{{$ord->total_price - $paid}}</td>
                                <td>
                                    <button 
                                            class="btn btn-primary add" data-toggle="modal" data-target="#Modal"
                                            data-id="" >Update
                                    </button>
                                </td>
                              </tr>
                         
                              @endforeach
                              {{ $orders->links() }}
                            </tbody>
                          </table>
                   @else
                   No pending payment
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="stockform" name="stockform" action="">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Update Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">File Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="materials" name="materials" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Balance</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="oldstock" name="oldstock" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="newstock" class="col-sm-4 col-form-label">Value</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="value" name="value" required="required" >
                    <input type="hidden" name="m_id" id="mid">
                    <input type="hidden" name="oldvalue" id="oldvalue">
                    <input type="hidden" name="operator" id="operator">
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
$(document).on("click", ".add", function () {
     var name = $(this).data('name');
     var balance = $(this).data('bid');
     var nid = $(this).data('nid');
     var slid = $(this).data('slid');
     var utype = $(this).data('utype');
     var process = $(this).data('process');
     
     $(".modal-title").text( name );
     $(".modal-body #priceName").val( pricename );
     $(".modal-body #slId").val( slid );
     $(".modal-body #bId").val( bid );
     $(".modal-body #nId").val( nid );
     $(".modal-body #utype").val( utype );
     $(".modal-body #process").val( process );
     $(".modal-body #price").val( "" );

});    
</script>
@endsection
