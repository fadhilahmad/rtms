@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
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
                <div class="card-header">Payment Receipt <div class="float-right">Total Receipts : {{$receipts->count()}}</div></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.filterreceiptlist') }}" method="post">
                                {{ csrf_field() }}
                            <select name="month" class="form-control-sm" id="bulan">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
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
                            <a href="{{ route('admin.receiptlist') }}"><button class="btn-sm" >Reset</button></a><br>
                        </div>
                    </div><br>
                    @if(!$receipts->isempty())                    
                   <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Ref No</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">File name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Payment Date</th>
                                <th scope="col">View</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($receipts as $receipt)
                              <tr>
                                <td>{{$no}}</td>
                                <th scope="row">{{$receipt->ref_num}}</th>
                                <td>{{$receipt->u_fullname}}</td>
                                <td>{{$receipt->file_name}}</td>
                                <td>{{$receipt->quantity_total}}</td>
                                <td>{{$invoice->where('o_id',$receipt->o_id)->pluck('total_price')->first()}}</td>
                                <td>{{$receipt->total_paid}}</td>
                                <td>{{date('d/m/Y', strtotime($receipt->created_at))}}</td>
                                <td><a href="{{route('general.receipt',$receipt->re_id)}}"><button class="btn btn-primary">View</button></td>
                              </tr>
                              @php $no++; @endphp
                              @endforeach
                              {{ $receipts->links() }}
                            </tbody>
                          </table>
                   @else
                   No Receipt Available<br>
                   Please Update Payment
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {

    $("#bulan").val( '{{$m}}' );
    $("#tahun").val( '{{$y}}' );

});    
</script>
@endsection
