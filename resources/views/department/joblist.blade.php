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
                                    <th scope="col">File Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                  <tr>
                                    <td>{{$order->ref_num}}</td>
                                    <td>{{$order->file_name}}</td>
                                    <td>{{$order->category}}</td>
                                    <td>{{$order->quantity_total}}</td>
                                    <td>{{$order->delivery_date}}</td>
                                    <td>
                                      
                                       @if($department==3)
                                    <a href="{{route('job_design',$order->o_id)}}"><button class="btn btn-primary">Upload Design</button></a>
                                       @endif
                                       @if($department==4)
                                    <a href="{{route('job_sew',$order->o_id)}}"><button class="btn btn-primary">Sew</button></a>
                                       @endif
                                       @if($department==5)
                                    <a href="{{route('job_print',$order->o_id)}}"><button class="btn btn-primary">Print</button></a>
                                       @endif
                                    </td>                                    
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                    @else
                    No job
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
