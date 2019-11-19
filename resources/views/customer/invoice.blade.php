@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Invoice Page</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif 

                    @if(count($orders) > 0)

                        @if(count($invoiceconfirm) > 0)

                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Cloth Name</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Order Date</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; ?>
                                    @foreach($orders as $order)
                                        <tr>
                                            <th scope="row"><?php echo $no; ?></th>
                                            <td>{{$order->file_name}}</td>
                                            @foreach($materials as $material)
                                                @if($material->m_id == $order->material_id)
                                                    <td>{{$material->m_desc}}</td>
                                                @endif
                                            @endforeach
                                            <td>{{$order->quantity_total}}</td>
                                            <td>{{$order->category}}</td>
                                            @foreach($invoices as $invoice)
                                                @if($invoice->o_id == $order->o_id)
                                                    <td>{{date('d/m/Y', strtotime($invoice->created_at))}}</td>
                                                @endif
                                            @endforeach
                                            <td>
                                                {!! Form::open(array( 'route'=>'customer.viewinvoice', 'method' => 'POST')) !!}
                                                    <input type="hidden" name="orderid" value="{{$order->o_id}}">
                                                    <input type="submit" style="display: inline-block;" name="actionbutton" value="View" class="btn btn-primary">
                                                {!!Form::close()!!}

                                            </td>
                                            
                                        </tr>
                                        <?php $no++; ?>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        @else
                            <p>Invoice still pending</p>
                        @endif

                    @else
                        <p>No order created</p>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
