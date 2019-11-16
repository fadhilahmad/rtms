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
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">INVOICE</div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-10">16, Jalan Meru Bistari A12</div>
                        <div class="col-md-2">{{$orders->ref_num}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">Medan Meru Bistari</div>
                        <div class="col-md-4">+60176350023/+60195556577</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">30020 Ipoh, Perak</div>
                    </div><br><br>
                    
                    <div class="row">
                        <div class="col-md-2">Bil Kepada :</div>
                        <div class="col-md-8">{{$user->u_fullname}}</div>
                        <div class="col-md-2">{{date('d/m/Y', strtotime($invoice->created_at))}}</div>
                    </div><br><br>

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
                                                                  
                                </td>
                                @php $display = $invoice_p->where('s_id',$spec->s_id)->first();  @endphp
                                <td>{{$total_unit[] = $display->spec_total_quantity}}</td>
                                <td>{{$display->one_unit_price}}</td>                                                               
                                <td>{{$total_price[] = $display->spec_total_price}}</td>
                            </tr>
                            @php $no++; $index++ @endphp
                            @endforeach
                            <tr>
                                <td></td>
                                <td>Jumlah Keseluruhan</td>
                                <td>{{array_sum ( $total_unit )}}</td>
                                <td></td>
                                <td>{{array_sum ( $total_price )}}</td>
                            </tr>                            
                        </tbody>
                    </table><br><br>
                    
                    <div class="row">
                        <div class="col-md-12"><center>Bayaran Boleh Dibuat Melalui Akaun</center></div>
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
