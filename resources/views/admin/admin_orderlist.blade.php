@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-list"></i> Order List</div>

                <div class="card-body">
                    @if(!$order->isempty())
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">Ref No</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">File name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Delivery Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Details</th>
                              </tr>
                            </thead>
                            <tbody>
              
                                @foreach($order as $ord)
                              <tr>
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
                                <td><a href="{{route('order_info',$ord->o_id)}}"><button class="btn btn-primary">View</button></a></td>
                              </tr>
                         
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
@endsection
