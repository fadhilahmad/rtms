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
                    <strong>INVOICE</strong>
                    <img src="{{URL::to('/')}}/img/logo.jpeg" style="width:18%; float:right">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">16, Jalan Meru Bistari A12</div>
                        <div class="col-md-2" >{{$orders->ref_num}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">Medan Meru Bistari<br>30020 Ipoh, Perak</div>
                        <div class="col-md-6">+60176350023/+60195556577</div>
                    </div>
                    <br><br>
                    
                    <div class="row">
                        <div class="col-md-9">Bil Kepada : {{$user->u_fullname}}</div>
                        <!-- <div class="col-md-8">{{$user->u_fullname}}</div> -->
                        <div class="col-md-2">{{date('d/m/Y', strtotime($invoice->created_at))}}</div>
                    </div>

                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col"></th>
                            <th scope="col">Perkara</th>
                            <th scope="col">Kuantiti</th>
                            <th scope="col">Harga Seunit(RM)</th>
                            <th scope="col">Jumlah(RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; $index=0; @endphp
                            @foreach($specs as $spec)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$spec->b_desc}} {{$spec->sl_desc}} {{$spec->n_desc}}<br>
                                @php $check_4xl = $units->where('s_id',$spec->s_id)->where('size','4XL')->pluck('un_quantity')->first();  
                                     $check_5xl = $units->where('s_id',$spec->s_id)->where('size','5XL')->pluck('un_quantity')->first();
                                     $check_6xl = $units->where('s_id',$spec->s_id)->where('size','6XL')->pluck('un_quantity')->first();
                                     $check_7xl = $units->where('s_id',$spec->s_id)->where('size','7XL')->pluck('un_quantity')->first();
                                @endphp
                                @if(!empty ( $check_4xl ))
                                    4XL   {{$check_4xl}} unit (+RM{{4*$check_4xl}})<br>
                                @endif
                                @if(!empty ( $check_5xl ))
                                    5XL   {{$check_5xl}} unit (+RM{{4*$check_5xl}})<br>
                                @endif
                                @if(!empty ( $check_6xl ))
                                    6XL   {{$check_6xl}} unit (+RM{{8*$check_6xl}})<br>
                                @endif
                                @if(!empty ( $check_7xl ))
                                    7XL    {{$check_7xl}} unit (+RM{{8*$check_7xl}})<br>                                         
                                @endif
                                </td>
                                @php $display = $invoice_p->where('s_id',$spec->s_id)->first();  @endphp
                                <td>{{$total_unit[] = $display->spec_total_quantity}}</td>
                                @php 
                                if($orders->category=="Nameset"){
                                $harga = $display->one_unit_price + 4 ;}else{$harga=$display->one_unit_price;}
                                @endphp
                                <td>{{$harga}}</td>                                                               
                                <td>{{$total_price[] = $display->spec_total_price}}</td>
                            </tr>
                            @php $no++; $index++ @endphp
                            @endforeach
                            
                            @foreach($charges as $charge)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$charge->ac_desc}}</td>
                                <td></td>
                                <td></td>                                                               
                                <td>{{$total_price[] = $charge->charges}}</td>
                            </tr>
                            @php $no++; $index++ @endphp
                            @endforeach
                            
                            <tr>
                                <td></td>
                                <td>Jumlah Keseluruhan</td>
                                <td>{{array_sum ( $total_unit )}}</td>
                                <td></td>
                                <td>{{--array_sum ( $total_price )--}}{{$invoice->total_price}}</td>
                            </tr>  
<!--                            <tr>
                                <td class="no-border"></td>
                                <td class="no-border"></td>
                                <td class="no-borderbottom"></td>
                                <td class="no-padding">DEPOSIT</td>
                                <td class="red"></td>
                            </tr> 
                            <tr>
                                <td class="no-border"></td>
                                <td class="no-border"></td>
                                <td class="no-borderbottom"></td>
                                <td class="no-padding">BAKI</td>
                                <td class="blue"></td>
                                <td class="no-padding green">PAID  &nbsp; </td>
                                <td class="no-padding no-border"> 12/9 </td>
                            </tr>                            -->
                        </tbody>
                    </table><br><br>
                    
                    <div class="row">
                        <div class="col-md-12"><center>Bayaran Boleh Dibuat Melalui Akaun</center></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4" style="border:1px solid">Maybank<br>Mohd Fazrul Hafiz Bin Ahmad Azhar<br>MBB 158172962998</div>
                        <div class="col-md-1"><center>@</center></div>
                        <div class="col-md-3" style="border:1px solid">CIMB<br>Rizqi Eryna<br>8602849419</div>
                    </div><br><br>
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
