@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Order List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Order List page

                    <div class="panel-body">
                        <br>
                        <h3>Your Order</h3>

                        @if(count($orders) > 0)
                            @foreach($orders as $order)
                                <div class="card card-body bg-light">
                                    <h3><a href="/customer/vieworder/{{$order->o_id}}">{{$order->file_name}}</a></h3>
                                    {{-- <small>Ordered on {{$order->created_at}} by {{$order->user->name}}</small> --}}
                                </div>
                            @endforeach
                            
                            {{$orders->links()}} 
                        @else
                            <p>No order found</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
