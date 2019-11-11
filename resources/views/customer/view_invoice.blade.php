@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">View Invoice Page</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($users as $user)
                        <p><b>Customer Name:</b> {{$user->u_fullname}}</p>
                    @endforeach
                    @foreach($invoices as $invoice)
                        @if($invoice->o_id == $orderid)
                        <p><b>Invoice Date:</b> {{date('d/m/Y', strtotime($invoice->created_at))}}</p>
                        @endif
                    @endforeach
                    @foreach($orders as $order)
                        <p><b>File Name:</b> {{$order->file_name}}</p>
                        <p><b>Category:</b> {{$order->category}}</p>
                    @endforeach

                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">Body Type</th>
                            <th scope="col">Sleeve Type</th>
                            <th scope="col">Neck Type</th>
                            <th scope="col">Collar Color</th>
                            <th scope="col">Name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; $index = 0;?>
                            @foreach($units as $unit)
                                <tr>
                                    @foreach($specs as $spec)
                                        @if($spec->s_id == $unit->s_id)
                                            <th scope="row"><?php echo $no; ?></th>
                                            @foreach($bodies as $body)
                                                @if($body->b_id == $spec->b_id)
                                                    <td>{{$body->b_desc}}</td>
                                                @endif
                                            @endforeach
                                            @foreach($sleeves as $sleeve)
                                                @if($sleeve->sl_id == $spec->sl_id)
                                                    <td>{{$sleeve->sl_desc}}</td>
                                                @endif
                                            @endforeach
                                            @foreach($necks as $neck)
                                                @if($neck->n_id == $spec->n_id)
                                                    <td>{{$neck->n_desc}}</td>
                                                @endif
                                            @endforeach
                                            <td>{{$spec->collar_color}}</td>
                                            @if($unit->name == "")
                                                <td>No Name</td>
                                            @else
                                                <td>{{$unit->name}}</td>
                                            @endif
                                            <td>{{$unit->size}}</td>
                                            <td>{{$unit->un_quantity}}</td>
                                            <td>
                                                <?php 
                                                    echo $prices[$index];
                                                ?>
                                            </td>
                                        @endif
                                    @endforeach
                                    <?php $no++; $index++;?>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan = "7"><b>TOTAL</b></td>
                                @foreach($orders as $order)
                                    <td><b>{{$order->quantity_total}}</b></td>
                                @endforeach
                                @foreach($invoices as $invoice)
                                    <td><b>{{$invoice->total_price}}</b></td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
