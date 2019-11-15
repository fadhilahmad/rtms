@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 90% !important; 
}
td,th {
text-align: center;
} 
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Invoice List</div>

                <div class="card-body">

                    @if(!$invoice->isempty())
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">Ref Num</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">File Name</th>
                                <th scope="col">Total Quantity</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>                                
                                @foreach($invoice as $inv)
                              <tr>
                                <td>{{$inv->ref_num}}</td>
                                <td>{{$inv->u_fullname}}</td>
                                <td>{{$inv->file_name}}</td>
                                <td>{{$inv->quantity_total}}</td>
                                <td>{{$inv->total_price}}</td>
                                <td>{{$inv->created_at}}</td>
                                <td><a href="{{route('admin.invoiceinfo',$inv->o_id)}}"><button class="btn btn-primary">View</button></a>
                                
                                
                                </td>
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
