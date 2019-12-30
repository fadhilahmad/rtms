@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 100% !important; 
}
td,th {
text-align: left;
} 

.table .thead-dark th {
    color: black;
    background-color:white;
    border-color: #0ace9e;
}
.table-bordered td {
    border:1px #0ace9e;

}
.table-bordered td.no-border {
    border:1px solid white;
    border-right:1px solid white;
}
.table-bordered td.no-borderbottom {
    border-bottom:1px solid white;
}

.table-bordered td.red {
    background-color:red;
}
.table-bordered td.blue {
    background-color:#00adfc;
}
.table-bordered td.green {
    background-color:#00fc04;
    color:black;
}
.table-bordered td.no-padding {
    padding:0px;
}

.card-header.invoice{
    background-color: #0ace9e;
    color: white;
    height:8vh;
    margin-bottom:40px;
   
}
.card-body {
    padding-top:5px;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header invoice">
                    <h1 style="font-size:40px">RECEIPT 
                        @if($settings)
                        <img src="{{URL::to('/')}}/img/logo/{{$settings->company_logo}}" style="width:110px; float:right; margin-top:-17px">
                        @endif
                    </h1>
                  
                </div>
                <div class="card-body">
                    @if($settings)
                    <div class="row">
                        <div class="col-md-10"><strong>{{$settings->company_name}}</strong></div>
                        <div class="col-md-10">
                            {{$settings->address_first}}<br>
                            {{$settings->address_second}}<br>
                            {{$settings->poscode}} {{$settings->state}} , {{$settings->country}}
                        </div>
                    </div>
                    @endif                    
                    <br><br>
                    
                    <div class="row">
                        <div class="col-md-9">Bil Kepada : {{$receipts->u_fullname}}</div>
                        <div class="col-md-2">{{date('d/m/Y', strtotime($receipts->created_at))}}</div>
                    </div>

                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col"></th>
                            <th scope="col">Butiran Pembayaran</th>
                            <th scope="col">Jumlah(RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{$receipts->description}}</td>
                                <td>{{$receipts->total_paid}}</td>
                            </tr>
                            
                        </tbody>
                    </table><br><br>
                    
                    <div class="row">
                        <div class="col-md-12"><center>Terima Kasih Atas Sokongan Anda</center></div>
                    </div><br><br>
                    <div class="row">
                        <div class="col-md-10"></div>
                        <div class="col-md-2"><button class="print" onclick="printFunction()"><i class="fa fa-print"></i></button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function printFunction() {
  window.print();
}    
</script>
@endsection
