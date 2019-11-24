@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Job List</div>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                <div class="card-body">
                    @if(!$orders->isempty())
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Ref No</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">File Name</th>                                    
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Delivery Date</th>                                    
                                    <th scope="col">Job Order</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                  <tr>
                                    <td>{{$order->ref_num}}</td>
                                    <td>{{$order->u_fullname}}</td>
                                    <td>{{$order->address}}</td>
                                    <td>{{$order->phone}}</td>
                                    <td>{{$order->file_name}}</td>
                                    <td>{{$order->quantity_total}}</td>
                                    <td>{{ date('d/m/Y', strtotime($order->delivery_date)) }}</td>                                   
                                    <td><a href="{{ route('department.joborder',$order->o_id) }}" target="_blank">Job Order {{$order->ref_num}}</a></td>
                                    <td><a href="{{route('job_delivery',$order->o_id)}}"><button class="btn btn-primary">Update Delivery</button></a></td>                                                               
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                    @else
                    No delivery job
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
