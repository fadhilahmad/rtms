@extends('layouts.layout')

@section('content')
<style>
    form, form formbutton { display: inline; }
    .pending{
    background-color: #ff6961;
    color: white;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-list"></i> Completed Order  <div class="float-right">Total Orders : {{$order->count()}}</div></div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div><br>
                    @endif                    
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.filterhistory') }}" method="post">
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
                            <a href="{{ route('admin.orderhistory') }}"><button class="btn-sm" >Reset</button></a><br>
                        </div>
                    </div><br>
                    @if(!$order->isempty())
                        <table class="table">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Ref No</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">File name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Delivery Date</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Debt</th>
                                <th scope="col">Job Order</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($order as $ord)
                                @php                                  
                                    if($ord->balance <>'0'){$css = 'pending';}
                                    else{$css = '';}                               
                                @endphp
                              <tr class="{{$css}}">
                                <td>{{$no}}</td>
                                <th scope="row">{{$ord->ref_num}}</th>
                                <td>{{date('d/m/Y', strtotime($ord->created_at))}}</td>
                                <td>{{$ord->u_fullname}}</td>
                                <td>{{$ord->file_name}}</td>
                                <td>{{$ord->quantity_total}}</td>
                                <td>{{date('d/m/Y', strtotime($ord->delivery_date))}}</td>
                                <td>RM {{$invoice->where('o_id',$ord->o_id)->pluck('total_price')->first()}}</td>
                                <td>{{$ord->balance}}</td>
                                <td><a href="{{route('general.joborder',$ord->o_id)}}"><button >View</button></a></td>
                              </tr>
                               @php $no ++; @endphp
                              @endforeach
                              {{ $order->links() }}
                            </tbody>
                          </table>
                    @else
                    No Completed Order
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
