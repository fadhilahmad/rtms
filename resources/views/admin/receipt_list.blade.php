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
                    <form action="{{ route('admin.filterreceiptlist') }}" method="post">
                        {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-1">
                            Month
                        </div>
                        <div class="col-md-3 bulan">
                            <select name="month" class="form-control" id="bulan">
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
                        </div>
                        <div class="col-md-1">
                            Year
                        </div>
                        <div class="col-md-3 tahun">
                            <select name="years" id="tahun" class="form-control">
                                @foreach($years as $year)
                                <option value="{{$year}}">{{$year}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" >Filter</button>
                        </div>
                    </div>
                    </form><br>
                    @if(!$receipts->isempty())                    
                   <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">Ref No</th>
                                <th scope="col">Customer Name</th>
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
                                <td>{{$receipt->u_fullname}}</td>
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

<script type="text/javascript">
$(document).ready(function () {

    $(".bulan #bulan").val( '{{$m}}' );
    $(".tahun #tahun").val( '{{$y}}' );

});    
</script>
@endsection
