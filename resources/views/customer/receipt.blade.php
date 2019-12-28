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
                <div class="card-header">Payment Receipt</div>

                <div class="card-body">
                    @if(!$receipts->isempty())
                   <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">Ref No</th>
                                <th scope="col">File name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Payment Date</th>
                                <th scope="col">View</th>
                              </tr>
                            </thead>
                            <tbody>
              
                                @foreach($receipts as $receipt)
                              <tr>
                                <th scope="row">{{$receipt->ref_num}}</th>
                                <td>{{$receipt->file_name}}</td>
                                <td>{{$receipt->quantity_total}}</td>
                                <td>{{$receipt->total_paid}}</td>
                                <td>{{date('d/m/Y', strtotime($receipt->created_at))}}</td>
                                <td><a href="{{route('general.receipt',$receipt->re_id)}}"><button class="btn btn-primary">View</button></td>
                              </tr>
                         
                              @endforeach
                              {{ $receipts->links() }}
                            </tbody>
                          </table>
                   @else
                   No Receipt Available<br>
                   Please Update Payment
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
