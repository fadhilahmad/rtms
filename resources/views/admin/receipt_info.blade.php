@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 100% !important; 
}
td,th {
text-align: center;
} 

.table .thead-dark th {
    color: black;
    background-color:yellow;
    border-color: #32383e;
}
.table-bordered td {
    border:1px solid black;

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
    background-color: black;
    color: yellow;
    font-size: 25px;
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
                    <strong>RESIT</strong>
                    <img src="{{URL::to('/')}}/img/logo.jpeg" style="width:18%; float:right">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">16, Jalan Meru Bistari A12</div>
                        <div class="col-md-2" >{{$receipts->ref_num}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Medan Meru Bistari<br>30020 Ipoh, Perak</div>
                        <div class="col-md-6">+60176350023/+60195556577</div>
                    </div>
                    <br><br>
                    
                    <div class="row">
                        <div class="col-md-9">Bil Kepada : {{$receipts->u_fullname}}</div>
                        <div class="col-md-2">{{date('d/m/Y', strtotime($receipts->created_at))}}</div>
                    </div>

                    <table class="table table-bordered">
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
