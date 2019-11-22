@extends('layouts.layout')

@section('content')
<div  class="container-scroll">
    <div class ="card">
        <div class="card-header order-form ">REZEAL TEXTILE ORDER FORM</div>  
            <div class="card-body">   
                <form class="form-horizontal">
                    <div class="scroll_page">
                        <!-- first column -->
                        <div class="col-8 scroll_page--box">
                            <!-- date & ref.num field -->
                            <div class="form-group row">
                                <label class="col-sm-2">Date</label>
                                <div class="col-sm-4">
                                    : <input id="date" name="date" type="email" value="{{ date('d/m/Y', strtotime($orders->created_at)) }}" disabled="">
                                </div>
                                <label class="col-sm-1">Ref Num</label>
                                <div class="col-sm-5">
                                    : <input id="refnum" name="refnum"  type="text" value="{{ $orders->ref_num }}" disabled="" >
                                </div>
                            </div>
                            <!-- customer field -->
                            <div class="form-group row">
                                <label class="col-sm-2">Customer</label>
                                <div class="col-sm-10">
                                : <input id="customer"  name="customer" type="text" value="{{ $orders->u_fullname }}" disabled="">
                                </div>
                            </div>
                            <!-- file name field -->
                            <div class="form-group row">
                                <label class="col-sm-2">File Name</label>
                                <div class="col-sm-10">
                                : <input id="file_name" name="file_name" type="text" value="{{ $orders->file_name }}" disabled="">
                                </div>
                            </div>
                            <!-- material checkbox -->
                            <div class="form-group row">
                                <label class="col-sm-2">Material</label>
                                <div class="col-sm-10">
                                : <input id="file_name" name="file_name" type="text" value="{{ $orders->m_desc }}" disabled="">
                                </div>
                            </div>
                            <!-- sleeve checkbox -->                                
                            <div class="form-group row">
                                <label class="col-sm-2">Sleeve</label>                                   
                                    <div class="col-sm-10">                                            
                                        : 
                                        @foreach ($specs as $spec)                                                    
                                                    <input id="checkboxCustom" type="checkbox" value="" checked disabled>
                                                    <label for="checkboxCustom">{{ $spec->sl_desc }}</label>                                                   
                                        @endforeach                                          
                                    </div>                                                                                                                
                            </div>
                                <!-- collar no field -->                                
                                <div class="form-group row">
                                <label class="col-sm-2">Collar No</label>
                                <div class="col-sm-10">
                                    : 
                                    @foreach ($specs as $spec) 
                                    {{ $spec->n_id }},
                                    @endforeach                                             
                                </div>
                            </div>
                            <!-- delivery date field -->                                
                            <div class="form-group row">
                                <label class="col-sm-2">Delivery Date</label>
                                <div class="col-sm-10">
                                : <input id="delivery_date" name="delivery_date" type="text" value="{{ date('d/m/Y', strtotime($orders->delivery_date)) }}" disabled="">
                                </div>
                            </div>
                            <!-- Person in charge field -->                                
                            <div class="form-group row">
                                <label class="col-sm-2">Person in charge</label>
                                <div class="col-sm-10">
                                : <input id="pic" name="pic" type="text" value="{{ $pic->u_fullname }}" disabled="">
                                </div>
                            </div>
                            <!-- collar colour field -->                                
                            <div class="form-group row">
                                <label class="col-sm-2">Collar Colour</label>
                                <div class="col-sm-10">
                                :
                                    @foreach ($specs as $spec)
                                        @if($spec->collar_color != "")
                                            {{$spec->collar_color}},
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <!-- jpeg mockup field -->                                                            
                            <div class="form-group row">
                                <label class="col-sm-2">JPEG Mockup </label>
                                <div class="col-sm-10">
                                    <img src="{{url('orders/mockup/'.$design->d_url)}}" width="70%">
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <div class="col-sm-5">                                   
                                <center><img src="{{url('orders/mockup/'.$design->d_url)}}" width="80%" height="80%"></center>
                                </div>
                            </div>         -->
                            <!-- remarks field -->        
                            <div class="form-group row">
                                <label class="col-sm-2">Remarks</label> :
                                <div class="col-sm-6">
                                    <textarea rows="4" cols="50" value="" disabled=""> {{ $orders->note }}                               
                                    </textarea>
                                </div>
                            </div>
                        
                        </div>
                        <!-- Second column -->
                        <div class="col-10 scroll_page--box">
                            <div class="row">
                                <div class="col">
                                    <img src="{{url('img/collar-type.jpeg')}}" style="width:30vw; margin: 0px auto; margin-bottom:20px;">
                                </div>
                                <div class="col">
                                    <table class="table table-bordered"  style="margin: 0px auto; margin-top:20px;">
                                            <thead  style="background-color:yellow; color:black">
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Notes</th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            
                                            </tbody>
                                        </table>
                                        <div class="row offset-sm-6" style="margin-top:50px;">
                                            <input class="col-3" disabled value="Total" style="background-color:yellow"/>
                                            <input class="col-3" disabled  value="{{ $orders->quantity_total }}" style="background-color:red; color:white"/> <p>PCS</p>
                                        </div>
                                        <div class="text-big-red">
                                            <h1 style="font-size:100px;">{{ $orders->m_desc }}</h1>
                                            <!-- <h1 style="font-size:150px;"></h1> -->
                                        </div>
                                    
                        
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group col-6">
                                @if($orders->category=="Size")
                                @foreach($specs as $spec)
                                <strong>{{$spec->b_desc}} {{$spec->sl_desc}} {{$spec->n_desc}}</strong>
                                <div style="display:flex; margin-top:20px">
                                    <table class="table table-bordered"  style=" margin: 0px auto; margin-top:20px;">
                                        <thead  style="background-color:yellow; color:black">
                                            <tr>
                                                <th scope="col">Size</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Designed</th>
                                                <th scope="col">Printed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">XXS</th>
                                                @php $xxs = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','XXS')->first();  @endphp
                                                <td>
                                                    @if($xxs!="NULL")
                                                    {{$xxs['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $xxs ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','XXS')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $xxs ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','XXS')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">XS</th>
                                                @php $xs = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','XS')->first();  @endphp
                                                <td>
                                                    @if($xxs!="NULL")
                                                    {{$xs['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $xs ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','XS')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $xs ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','XS')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">S</th>
                                                @php $s = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','S')->first();  @endphp
                                                <td>
                                                    @if($s!="NULL")
                                                    {{$s['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','S')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','S')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">M</th>
                                                @php $m = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','M')->first();  @endphp
                                                <td>
                                                    @if($m!="NULL")
                                                    {{$m['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $m ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','M')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $m ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','M')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">L</th>
                                                @php $l = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','L')->first();  @endphp
                                                <td>
                                                    @if($l!="NULL")
                                                    {{$l['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $l ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','L')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $l ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','L')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">XL</th>
                                                @php $xl = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','XL')->first();  @endphp
                                                <td>
                                                    @if($xl!="NULL")
                                                    {{$xl['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $xl ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','XL')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $xl ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','XL')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered" style="margin: 0px auto; margin-top:20px;">
                                        <thead  style="background-color:yellow; color:black">
                                            <tr>
                                                <th scope="col">Size</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Designed</th>
                                                <th scope="col">Printed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">2XL</th>
                                                @php $xl = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','2XL')->first();  @endphp
                                                <td>
                                                    @if($xl!="NULL")
                                                    {{$xl['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $xl ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','2XL')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $xl ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','2XL')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3XL</th>
                                                @php $s = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','3XL')->first();  @endphp
                                                <td>
                                                    @if($s!="NULL")
                                                    {{$s['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','3XL')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','3XL')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4XL</th>
                                                @php $s = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','4XL')->first();  @endphp
                                                <td>
                                                    @if($s!="NULL")
                                                    {{$s['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','4XL')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','4XL')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">5XL</th>
                                                @php $s = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','5XL')->first();  @endphp
                                                <td>
                                                    @if($s!="NULL")
                                                    {{$s['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','5XL')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','5XL')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">6XL</th>
                                                @php $s = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','6XL')->first();  @endphp
                                                <td>
                                                    @if($s!="NULL")
                                                    {{$s['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','6XL')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','6XL')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">7XL</th>
                                                @php $s = $units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id)->where('size','7XL')->first();  @endphp
                                                <td>
                                                    @if($s!="NULL")
                                                    {{$s['un_quantity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))                                                       
                                                        @if($designs->where('s_id',$spec->s_id)->where('size','7XL')->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif                                                                                                               
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty ( $s ))
                                                    @if($units->where('s_id',$spec->s_id)->where('size','7XL')->where('un_status','<>','0')->count()>0)
                                                    <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                    @else
                                                    <input type="checkbox" name="jobdone" value="" disabled="">
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Total</th>
                                                <td style="background-color:#0051ff; color:white">{{$units->where('s_id',$spec->s_id)->where('o_id',$spec->o_id)->sum('un_quantity')}}</td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <BR><BR>
                                @endforeach
                                @elseif($orders->category="Nameset")
                                
                                <div class="form-group col-6">
                                    @foreach($specs as $spec)
                                    <strong>{{$spec->b_desc}} {{$spec->sl_desc}} {{$spec->n_desc}}</strong>
                                    <div class="row">
                                        <table class="table table-bordered"  style="margin: 0px auto; margin-top:20px;">
                                            <thead  style="background-color:yellow; color:black">
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Designed</th>
                                                    <th scope="col">Printed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                                <tr>                                              
                                                    <td>{{$unit->name}}</td>
                                                    <td scope="row" style="text-transform: uppercase;">{{$unit->size}}</td>
                                                    <td>{{$unit->un_quantity}}</td>
                                                    <td>                                                                                                         
                                                        @if($designs->where('s_id',$spec->s_id)->where('d_type','3')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif 
                                                    </td>
                                                    <td>
                                                        @if($units->where('s_id',$spec->s_id)->where('un_status','<>','0')->count()>0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif
                                                    </td>                                             
                                                </tr>
                                                @endforeach 
                                                <tr>
                                                    <td></td>
                                                    <th scope="row">Total</th>
                                                    <td style="background-color:#0051ff; color:white">{{$units->where('s_id',$spec->s_id)->where('o_id',$spec->o_id)->sum('un_quantity')}}</td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endforeach
                                </div>
                                
                                @endif
                            </div>
                            
                            <div class="form-group row">       
                                <div class="col-sm-8 offset-sm-3">
                                    <div class="col-md-2"><button class="print" onclick="printFunction()"><i class="fa fa-print"></i></button></div>                                                         
                                </div>
                            </div>
                        </div>              
                    </div>
                </form>
            </div>  
        </div>        
    </div>  
</div>
<style type="text/css" media="print">
 @page { size: landscape;  }
</style>

<script type="text/javascript">
function printFunction() {
  window.print(); 
 }       
</script>
@endsection

