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
                <div class="card-header">Job Sheet</div>

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
                                            <th scope="col">Upload</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>
                                              <td>{{$unit->name}}</td>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              <td>{{$unit->un_quantity}}</td>
                                              <td>
                                                  @if($design->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('d_type','3')->count()>0)
                                                  Uploaded
                                                  @else
                                                  <form enctype="multipart/form-data" method="post" action="{{route('update.design')}}">
                                                  @csrf                                           
                                                  <input type="file" name="job" required="" >
                                                  <input type="hidden" name="o_id" value="{{$unit->o_id}}">
                                                  <input type="hidden" name="un_id" value="{{$unit->un_id}}">
                                                  <input type="hidden" name="u_id" value="{{Auth::id()}}">
                                                  <input type="hidden" name="process" value="design">
                                                  <button type="submit" class="btn btn-primary edit" >Upload</button>
                                                  </form>
                                                  @endif
                                              </td>                                                                                                               
                                          </tr>
                                    @php $no++; @endphp
                                    @endforeach                                                                                   
                                        </tbody>
                                    </table>                                                                        
                                </div>                                   
                            </div>
                            
                            @php
                            $completed =  $design->where('o_id',$spec->o_id)->where('d_type','3')->count()
                            @endphp
                            @endforeach       
                                
                             <br><br>
                            @if($no==$completed)
                            <form method="post" action="{{route('update.design')}}">@csrf
                             <input type="hidden" name="process" value="update">
                             <input type="hidden" name="o_id" value="{{$order->o_id}}">
                             <center><button type="submit" class="btn btn-primary edit" >Submit To Print</button></center>                                         
                            @endif                                              
                                </div>                                
                            </div>
                         @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
