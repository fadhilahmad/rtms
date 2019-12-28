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

                    @if(!$invoice->isempty())
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">Ref Num</th>
                                <th scope="col">File Name</th>
                                <th scope="col">Delivery</th>
                                <th scope="col">Total Quantity</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">View</th>
                              </tr>
                            </thead>
                            <tbody>                                
                                @foreach($invoice as $inv)
                              <tr>
                                <td>{{$inv->ref_num}}</td>
                                <td>{{$inv->file_name}}</td>
                                <td>{{$inv->delivery_type}}</td>
                                <td>{{$inv->quantity_total}}</td>
                                <td>{{$inv->total_price}}</td>
                                <td>{{date('d/m/Y', strtotime($inv->created_at))}}</td>
                                <td><a href="{{route('general.invoice',$inv->o_id)}}"><button class="btn btn-primary">View</button></a></td>
                              </tr>
                              @endforeach
                              {{ $invoice->links() }}
                            </tbody>
                          </table>                    
                    
                    
                    @else
                    No invoice
                    @endif 
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
