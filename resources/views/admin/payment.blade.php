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
                <div class="card-header">Pending Payment List</div>

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
                                @php $paid = $receipt->where('o_id',$ord->o_id)->sum('total_paid');  
                                        if(!$paid){
                                            $paid = 0;
                                        }                               
                                @endphp
                                <td>{{$paid}}</td>
                                <td>{{$ord->balance}}</td>
                                <td>
                                    <button 
                                            class="btn btn-primary add" data-toggle="modal" data-target="#Modal" data-custname="{{$ord->u_fullname}}"
                                            data-oid="{{$ord->o_id}}" data-filename="{{$ord->file_name}}" data-balance="{{$ord->balance}}" >Update
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
        <form method="POST" id="paymentform" name="paymentform" action="">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Update Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="customer" class="col-sm-4 col-form-label">Customer Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="custname" name="cust_name" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="file_name" class="col-sm-4 col-form-label">File Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="filename" name="file_name" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="balance" class="col-sm-4 col-form-label">Balance</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="balance" name="balance" readonly="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Payment Description</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="description" name="description" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="payment" class="col-sm-4 col-form-label">Payment Value</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="payment" name="payment" required="required" >
                    <input type="hidden" name="o_id" id="oid">
                </div>
              </div>         
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" type="submit" class="btn btn-primary btn-submit">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on("click", ".add", function () {
     var custname = $(this).data('custname');
     var balance = $(this).data('balance');
     var oid = $(this).data('oid');
     var filename = $(this).data('filename');

     $(".modal-body #custname").val( custname );
     $(".modal-body #balance").val( balance );
     $(".modal-body #oid").val( oid );
     $(".modal-body #filename").val( filename );
     
     document.getElementById('payment').setAttribute("max", balance);
     $(".modal-body #description").val( "" );
     $(".modal-body #payment").val( "" );
     
     console.log(custname,oid,balance);

});

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-submit").click(function(e){
        e.preventDefault();

        var x = document.forms["paymentform"]["payment"].value;
        var y = document.forms["paymentform"]["description"].value;
        if (x == "") 
        {
            alert("Payment value must be filled out");
            return false;
        }
        if (y == "") 
        {
            alert("Payment Description must be filled out");
            return false;
        }
        else{
        var formData = {
            'oid'   : $('input[name=o_id]').val(),
            'payment'   : $('input[name=payment]').val(),
            'description'    : $('input[name=description]').val(),
            'balance' : $('input[name=balance]').val()
        };

        $.ajax({
           type:'POST',
           url:"{{url('admin/payment')}}",
           data:formData,
           success:function(data){
              $('#Modal').modal('hide');
                    location.reload();
           }
        });
      }
    });
</script>
@endsection
