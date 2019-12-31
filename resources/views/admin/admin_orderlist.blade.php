@extends('layouts.layout')

@section('content')
<style>
    form, form formbutton { display: inline; }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-list"></i> Order List <div class="float-right">Total Orders : {{$order->count()}}</div></div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div><br>
                    @endif               
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('admin.filterorder') }}" method="post">
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
                            <a href="{{ route('admin.orderlist') }}"><button class="btn-sm" >Reset</button></a><br>
                        </div>
                    </div><br>
                    
                    @if(!$order->isempty())
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Ref No</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">File name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Delivery Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($order as $ord)
                              <tr>
                                <td>{{$no}}</td>
                                <th scope="row">{{$ord->ref_num}}</th>
                                <td>{{$ord->u_fullname}}</td>
                                <td>{{$ord->file_name}}</td>
                                <td>{{$ord->quantity_total}}</td>
                                <td>{{$ord->delivery_date}}</td>
                                <td>
                                        @if($ord->o_status==1)
                                           Waiting for design
                                        @endif
                                        @if($ord->o_status==2)
                                           Order Confirm
                                        @endif
                                        @if($ord->o_status==3)
                                           Design Confirm
                                        @endif
                                        @if($ord->o_status==4)
                                           Printing
                                        @endif
                                        @if($ord->o_status==5)
                                           Waiting for Tailor
                                        @endif
                                        @if($ord->o_status==6)
                                           Sewing
                                        @endif
                                        @if($ord->o_status==7)
                                           Deliver
                                        @endif
                                        @if($ord->o_status==8)
                                           Reprint
                                        @endif
                                        @if($ord->o_status==9)
                                           Completed
                                        @endif
                                        @if($ord->o_status==10)
                                           Customer Request Design
                                        @endif
                                        @if($ord->o_status==0)
                                           Draft
                                        @endif
                                </td>
                                <td>
                                    <a href="{{route('admin.updateorder',$ord->o_id)}}"><button ><i class="fa fa-edit"></i></button></a>
                                
                                    <form class="formbutton" action="{{route('admin.deleteorder')}}" method="POST">{{ csrf_field() }}
                                        <button  type="submit" onclick="return confirm('Are you sure to delete this order?')" ><i class="fa fa-trash"></i></button>
                                        <input type="hidden" name="o_id" value=" {{$ord->o_id}}">                                 
                                    </form>
                                    
                                    <a href="{{route('general.joborder',$ord->o_id)}}" target="_blank"><button >Job Order</button></a></td>
                              </tr>
                              @php $no ++; @endphp
                              @endforeach
                              {{ $order->links() }}
                            </tbody>
                          </table>
                    @else
                    No Order
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
