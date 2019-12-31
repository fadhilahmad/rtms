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
form, form formbutton { display: inline; }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Invoice List <div class="float-right">Total Invoices : {{$invoice->count()}}</div></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.filterinvoice') }}" method="post">
                                {{ csrf_field() }}
                            <select name="month" class="form-control-sm" id="bulan">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>

                            <select name="years" id="tahun" class="form-control-sm">
                                @foreach($years as $year)
                                <option value="{{$year}}">{{$year}}</option>
                                @endforeach
                            </select>                       
                            <button class="btn-sm" type="submit" >Filter</button>
                            </form>
                            <a href="{{ route('admin.invoicelist') }}"><button class="btn-sm" >Reset</button></a><br>
                        </div>
                    </div><br>
                    
                    @if(!$invoice->isempty())
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Ref Num</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">File Name</th>
                                <th scope="col">Delivery</th>
                                <th scope="col">Total Quantity</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Created Date</th>
<!--                                <th scope="col">Add Charges</th>-->
                                <th scope="col">View</th>
                              </tr>
                            </thead>
                            <tbody> 
                                @php $no = 1; @endphp
                                @foreach($invoice as $inv)
                              <tr>
                                <td>{{$no}}</td>
                                <td>{{$inv->ref_num}}</td>
                                <td>{{$inv->u_fullname}}</td>
                                <td>{{$inv->phone}}</td>
                                <td>{{$inv->file_name}}</td>
                                <td>{{$inv->delivery_type}}</td>
                                <td>{{$inv->quantity_total}}</td>
                                <td>{{$inv->total_price}}</td>
                                <td>{{date('d/m/Y', strtotime($inv->created_at))}}</td>
<!--                                <td><button class="btn btn-default addCharges" data-toggle="modal" data-target="#Modal" data-oid="{{$inv->o_id}}">Add</button></td>-->
<!--                                @if($inv->delivery_type=="Delivery")
                                <td><button class="btn btn-default addCharges" data-toggle="modal" data-target="#Modal" data-oid="{{$inv->o_id}}">Add</button></td>
                                @else
                                <td>-</td>
                                @endif-->
                                <td><a href="{{route('general.invoice',$inv->o_id)}}"><button class="btn btn-primary">View</button></a></td>
                              </tr>
                              @php $no++; @endphp
                              @endforeach
                              {{ $invoice->links() }}
                            </tbody>
                          </table>                    
                    
                    
                    @else
                    No invoice
                    @endif                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="chargesform" name="chargesform">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Add Charges</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Description</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="description" name="description" required="required" >
                    <input type="hidden" name="oid" id="oid">
                </div>
              </div> 

              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Price</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="price" name="price" required="required" >
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
$(document).on("click", ".addCharges", function () {
     var oid = $(this).data('oid');

     $(".modal-body #oid").val( oid );
     $(".modal-body #description").val( "" );

});
     
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-submit").click(function(e){
        e.preventDefault();

        var x = document.forms["chargesform"]["description"].value;
        var y = document.forms["chargesform"]["price"].value;
        if (x == "") 
        {
            alert("Description must be filled out");
            return false;
        }
        if (y == "") 
        {
            alert("Price must be filled out");
            return false;
        }
        else{
        var formData = {
            'price'   : $('input[name=price]').val(),
            'desc'   : $('input[name=description]').val(),
            'oid'   : $('input[name=oid]').val()
        };

        $.ajax({
           type:'POST',
           url:"{{url('admin/invoice_list')}}",
           data:formData,
           success:function(data){
              // console.log(data);
              $('#Modal').modal('hide');
                    location.reload();
           }
        });
      }
    }); 
    
$(document).ready(function () {

    $("#bulan").val( '{{$m}}' );
    $("#tahun").val( '{{$y}}' );

});
</script>
@endsection
