@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 100% !important; 
}
td,th {
text-align: left;
} 

.table .thead-dark th {
    color: black;
    background-color:white;
    border-color: #0ace9e;
}
.table-bordered td {
    border:1px #0ace9e;

}
.table-bordered td.no-border {
    border:1px solid white;
    border-right:1px solid white;
}
.table-bordered td.no-borderbottom {
    border-bottom:1px solid white;
}

.table-bordered td.red {
    background-color:red;
}
.table-bordered td.blue {
    background-color:#00adfc;
}
.table-bordered td.green {
    background-color:#00fc04;
    color:black;
}
.table-bordered td.no-padding {
    padding:0px;
}

.card-header.invoice{
    background-color: #0ace9e;
    color: white;
    height:8vh;
    margin-bottom:40px;
   
}
.card-body {
    padding-top:5px;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header invoice">
                    <h1 style="font-size:40px">INVOICE  
                        @if($settings)
                        <img src="{{URL::to('/')}}/img/logo/{{$settings->company_logo}}" style="width:110px; float:right; margin-top:-17px">
                        @endif
                    </h1>
                  
                </div>
                <div class="card-body">
                    @if($settings)
                    <div class="row">
                        <div class="col-md-10"><strong>{{$settings->company_name}}</strong></div><div class="float-right">REF {{$orders->ref_num}}</div>
                        <div class="col-md-10">
                            {{$settings->address_first}}<br>
                            {{$settings->address_second}}<br>
                            {{$settings->poscode}} {{$settings->state}} , {{$settings->country}}
                        </div>
                        <!-- <div class="col-md-2" >{{$orders->ref_num}}</div> -->
                    </div>
                    @endif
                    <!-- <div class="row">
                        <div class="col-md-6">Medan Meru Bistari<br>30020 Ipoh, Perak</div>
                        <div class="col-md-6">+60176350023/+60195556577</div>
                    </div> -->
                    <br><br>
                    
                    <div>
                        <div class="float-lg-left">Invoice to : {{$user->u_fullname}}</div> 
<!--                         <div class="col-md-8">{{$user->u_fullname}}</div> -->
                        <div style=" float:right">{{date('d/m/Y', strtotime($invoice->created_at))}}</div>
                    </div>

                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col"></th>
                            <th scope="col"><strong>Item</strong></th>
                            @can('isAdmin')
                            <th scope="col"><strong></strong></th>
                            @endcan
                            <th scope="col"><strong>Qty</strong></th>
                            <th scope="col"><strong>Price</strong>(RM)</th>
                            <th scope="col"><strong>Total</strong>(RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; $index=0; @endphp
                            @foreach($specs as $spec)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$spec->b_desc}} {{$spec->sl_desc}} {{$spec->n_desc}}<br>
                                @php $check_4xl = $units->where('s_id',$spec->s_id)->where('size','4XL')->pluck('un_quantity')->first();  
                                     $check_5xl = $units->where('s_id',$spec->s_id)->where('size','5XL')->pluck('un_quantity')->first();
                                     $check_6xl = $units->where('s_id',$spec->s_id)->where('size','6XL')->pluck('un_quantity')->first();
                                     $check_7xl = $units->where('s_id',$spec->s_id)->where('size','7XL')->pluck('un_quantity')->first();
                                @endphp
                                @if(!empty ( $check_4xl ))
                                    4XL   {{$check_4xl}} unit (+RM{{4*$check_4xl}})<br>
                                @endif
                                @if(!empty ( $check_5xl ))
                                    5XL   {{$check_5xl}} unit (+RM{{4*$check_5xl}})<br>
                                @endif
                                @if(!empty ( $check_6xl ))
                                    6XL   {{$check_6xl}} unit (+RM{{8*$check_6xl}})<br>
                                @endif
                                @if(!empty ( $check_7xl ))
                                    7XL    {{$check_7xl}} unit (+RM{{8*$check_7xl}})<br>                                         
                                @endif
                                </td>
                            @can('isAdmin')
                                <td></td>
                            @endcan
                                @php $display = $invoice_p->where('s_id',$spec->s_id)->first();  @endphp
                                <td>{{$total_unit[] = $display->spec_total_quantity}}</td>
                                @php 
                                if($spec->category=="Nameset"){
                                $harga = $display->one_unit_price + 4 ;}else{$harga=$display->one_unit_price;}
                                @endphp
                                <td>{{$harga}}</td>                                                               
                                <td>{{$total_price[] = $display->spec_total_price}}</td>
                            </tr>
                            @php $no++; $index++ @endphp
                            @endforeach
                            
                            @foreach($charges as $charge)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$charge->ac_desc}}</td>
                                @can('isAdmin')
                                <td>
                                    <form class="form-inline" action="{{route('general.alterprice')}}" method="POST">{{ csrf_field() }}
                                            <button class="d-print-none" type="submit" onclick="return confirm('Are you sure to delete this additional charge?')" ><i class="fa fa-trash"></i></button>                         
                                            <input type="hidden" name="oid" value=" {{$oid}}">
                                            <input type="hidden" name="ac_id" value=" {{$charge->ac_id}}">
                                            <input type="hidden" name="operation" value="delete_charge">                                 
                                    </form>
                                </td>
                                @endcan
                                <td></td>
                                <td></td>                                                               
                                <td>{{$total_price[] = $charge->charges}}</td>
                            </tr>
                            @php $no++; $index++ @endphp
                            @endforeach
                            
                            @foreach($discounts as $discount)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$discount->dis_desc}}</td>
                                @can('isAdmin')
                                <td>
                                    <form class="form-inline" action="{{route('general.alterprice')}}" method="POST">{{ csrf_field() }}
                                            <button class="d-print-none" type="submit" onclick="return confirm('Are you sure to delete this discount?')" ><i class="fa fa-trash"></i></button>                         
                                            <input type="hidden" name="oid" value=" {{$oid}}">
                                            <input type="hidden" name="dis_id" value=" {{$discount->dis_id}}">
                                            <input type="hidden" name="operation" value="delete_discount">                                 
                                    </form>
                                </td>
                                @endcan
                                <td></td>
                                <td></td>                                                               
                                <td>-{{$discount->dis_amount}}</td>
                            </tr>
                            @php $no++; $index++ @endphp
                            @endforeach
                            
                            <tr>
                                <td></td>
                                <td><strong>Subtotal</strong></td>
                                @can('isAdmin')
                                <td></td>
                                @endcan
                                <td><strong>{{array_sum ( $total_unit )}}</strong></td>
                                <td></td>
                                <td><strong>{{--array_sum ( $total_price )--}}{{$invoice->total_price}}</strong></td>
                            </tr>  
<!--                            <tr>
                                <td class="no-border"></td>
                                <td class="no-border"></td>
                                <td class="no-borderbottom"></td>
                                <td class="no-padding">DEPOSIT</td>
                                <td class="red"></td>
                            </tr> 
                            <tr>
                                <td class="no-border"></td>
                                <td class="no-border"></td>
                                <td class="no-borderbottom"></td>
                                <td class="no-padding">BAKI</td>
                                <td class="blue"></td>
                                <td class="no-padding green">PAID  &nbsp; </td>
                                <td class="no-padding no-border"> 12/9 </td>
                            </tr>                            -->
                        </tbody>
                    </table><br><br>
                    
                    @if($banks)
                    <div class="row">
                        <div class="col-md-12"><strong>Payment</strong></div>
                    </div>
                    <br>
                    <div class="row">
                        @foreach($banks as $bank)
                        <div class="col-md-3" >
<!--                        <img src="{{URL::to('/')}}/img/CIMB_Bank.png" style="width:60%"><br>-->
                            <strong>{{$bank->bank_name}}</strong><br>
                            <strong>{{$bank->account_name}}</strong><br>
                            <strong>{{$bank->account_number}}</strong><br>
                        </div>
                        @endforeach
                    </div><br><br>
                    @endif
                    
                    @can('isAdmin')
                    <div class="row">                        
                            <button class="btn btn-primary addCharges d-print-none" data-toggle="modal" data-target="#Modal" data-oid="{{$oid}}">Add Charges</button>
                            &nbsp;
                            <button class="btn btn-primary addDiscount d-print-none" data-toggle="modal" data-target="#discountModal" data-oid="{{$oid}}">Add Discount</button>                       
                    </div>
                    @endcan
                    <div class="row">
                        <div class="col-md-10"></div>
                        <div class="col-md-2"><button class="print d-print-none" onclick="printFunction()"><i class="fa fa-print"></i></button></div>
                    </div>
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
        <button type="button" type="submit" class="btn btn-primary btn-submit addcharge">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="discountform" name="discountform" action="{{route('general.alterprice')}}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Add Discount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="discount" class="col-sm-4 col-form-label">Description</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="discount" name="discount" required="required" >
                    <input type="hidden" name="oid" value="{{$oid}}">
                    <input type="hidden" name="operation" value="add_discount">
                </div>
              </div> 

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Amount (RM)</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="amount" name="amount" required="required" >
                </div>
              </div>          
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="validateDiscount()" type="submit" class="btn btn-primary btn-submit">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">
function printFunction() {
  window.print();
} 

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

    $(".addcharge").click(function(e){
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
    
    function validateDiscount() {
    var x = document.forms["discountform"]["discount"].value;
    var y = document.forms["discountform"]["amount"].value;
    if (x == "") 
        {
        alert("Description must be filled out");
        return false;
        }
        if(y=="")
        {
        alert("Amount must be filled out");
        return false;  
        }
        else{
      document.getElementById("discountform").submit();  
        }
    }
</script>
@endsection
