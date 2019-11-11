@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 80% !important; 
}
td,th {
text-align: center;
} 
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Order Sheet</div>

                <div class="card-body">
                            @foreach($orders as $order)
                            <div class="panel panel-primary">
                                <div class="panel-heading"></div>                                                                  
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">Ref Num</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->ref_num}}</div>
                                    </div><br>
<!--                                    <div class="row">
                                        <div class="col-sm-3">Customer Name</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->file_name}}</div>
                                    </div><br>-->
                                    <div class="row">
                                        <div class="col-sm-3">File name</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->file_name}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Category</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->category}}</div>
                                    </div><br> 
                                    <div class="row">
                                        <div class="col-sm-3">Total Quantity</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->quantity_total}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Material</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->m_desc}}</div>
                                    </div><br>                                    
                                    <div class="row">
                                        <div class="col-sm-3">Note</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->note}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Delivery Date</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->delivery_date}}</div>
                                    </div><br>
<!--                                    <div class="row">
                                        <div class="col-sm-3">Designer</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->delivery_date}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Print</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->delivery_date}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Taylor</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->delivery_date}}</div>
                                    </div><br>                                    -->
                            @php $no=0; @endphp
                            
                            @foreach($specs as $spec)
                            <div class="panel panel-primary">
                                <br><br><div class="panel-heading"><center><h2 style="text-transform: uppercase;">{{$spec->b_desc}} {{$spec->sl_desc}} {{$spec->n_desc}}</h2></center></div><br><br>                                                                  
                                <div class="panel-body">
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                          <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Download</th>
                                            <th scope="col">Design Status</th>
                                            <th scope="col">Print Status</th>
                                            <th scope="col">Sew Status</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>                                              
                                              <td>{{$unit->name}}</td>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              <td>{{$unit->un_quantity}}</td>
                                              <td>
                                                  @php $d_id = $design->where('o_id',$unit->o_id)->where('un_id',$unit->un_id)->first()  @endphp
<!--                                                  <form method="post" action="">@csrf
                                                  <input type="hidden" name="process" value="download">
                                                  <input type="hidden" name="d_id" value="{{$d_id['id']}}">                                                                                                       
                                                  </form> -->
                                                  <center><button type="submit" class="btn btn-secondary edit" >Download</button></center>
                                              </td>
                                              <td>
                                                  @if($design->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('d_type','3')->count()>0)
                                                  <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                  @else
                                                  <input type="checkbox" name="jobdone" value="" disabled="">
                                                  @endif
                                              </td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','0')->count()>0)
                                                  <input type="checkbox" name="jobdone" value="" disabled="">                                                                                                                                                    
                                                  @else
                                                  <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                  @endif
                                              </td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','2')->count()>0)
                                                  <input type="checkbox" name="jobdone" value="" checked="" disabled="">                                                                                                                                                  
                                                  @else
                                                  <input type="checkbox" name="jobdone" value=""  disabled="">
                                                  @endif
                                              </td>                                              
                                          </tr>
                                    @php $no++; @endphp
                                    @endforeach                                                                                   
                                        </tbody>
                                    </table>                                                                        
                                </div>                                   
                            </div>
                            @endforeach       
                                                                                                 
                                </div>                                
                            </div>
                         @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
