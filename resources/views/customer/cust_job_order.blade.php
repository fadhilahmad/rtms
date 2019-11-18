@extends('layouts.layout')

@section('content')
<div class="container-scroll">
    <div class ="card">
        <div class="card-header order-form ">REZEAL TEXTILE ORDER FORM</div>  
            <div class="card-body">   
                <form class="form-horizontal row">
                    <div class="scroll_page">
                        <!-- <div class="row"> -->
                            <!-- first column -->
                            <div class="col-12 scroll_page--box">
                                <!-- date & ref.num field -->
                                <div class="form-group row">
                                    <label class="col-sm-2">Date</label>
                                    <div class="col-sm-3">
                                       : {{Form::date('current_date', \Carbon\Carbon::now(new DateTimeZone('Asia/Kuala_Lumpur')), array('disabled'))}}
                                    </div>
                                    <label class="col-sm-1">Ref Num</label>
                                    <div class="col-sm-3">
                                        {{-- @foreach ($order as $order)
                                            <img style="width:80%" src="/orders/draft/{{ $design->d_url }}">
                                            @break
                                        @endforeach --}}
                                        : <input id="refnum" name="refnum"  type="text" value="{{$order->ref_num}}" disabled>
                                    </div>
                                </div>
                                <!-- customer field -->
                                <div class="form-group row">
                                    <label class="col-sm-2">Customer</label>
                                    <div class="col-sm-7">
                                    : <input id="customer"  name="customer" type="text" value="{{$user->u_fullname}}" disabled>
                                    </div>
                                </div>
                                <!-- file name field -->
                                <div class="form-group row">
                                    <label class="col-sm-2">File Name</label>
                                    <div class="col-sm-7">
                                    : <input id="file_name" name="file_name" type="text" value="{{$order->file_name}}" disabled>
                                    </div>
                                </div>
                                <!-- material checkbox -->
                                <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Material</label> :
                                    <div class="row col-sm-10">
                                        @foreach ($materials as $material)
                                            @if($material->m_id == $order->material_id)
                                                <div class="i-checks col-sm-3">
                                                    <input id="checkboxCustom" type="checkbox" value="" checked disabled>
                                                    <label for="checkboxCustom">{{ $material->m_desc }}</label>
                                                </div>
                                            @else
                                                <div class="i-checks col-sm-3">
                                                    <input id="checkboxCustom" type="checkbox" value="" disabled>
                                                    <label for="checkboxCustom">{{ $material->m_desc }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <!-- sleeve checkbox -->                                
                                <div class="form-group row">
                                    <label class="col-sm-2">Sleeve</label> :
                                    <div class="row col-sm-8">
                                            @foreach ($specs as $spec)
                                                    <div class="i-checks col-sm-3">
                                                        <input id="checkboxCustom" type="checkbox" value="" checked disabled>
                                                        <label for="checkboxCustom">{{ $spec->sl_desc }}</label>
                                                    </div>
                                            @endforeach
                                    </div>
                                </div>
                                 <!-- collar no field -->                                
                                 <div class="form-group row">
                                    <label class="col-sm-2">Neck description</label> :
                                    <div class="row col-sm-8">
                                            @foreach ($specs as $spec)
                                                    <div class="i-checks col-sm-3">
                                                        <input id="checkboxCustom" type="checkbox" value="" checked disabled>
                                                        <label for="checkboxCustom">{{ $spec->n_desc }}</label>
                                                    </div>
                                            @endforeach
                                    </div>
                                </div>
                                <!-- delivery date field -->                                
                                <div class="form-group row">
                                    <label class="col-sm-2">Delivery Date</label>
                                    <div class="col-sm-5">
                                    : {{Form::date('current_date', $order->delivery_date, array('disabled'))}}
                                    </div>
                                </div>
                                <!-- Person in charge field -->                                
                                <div class="form-group row">
                                    <label class="col-sm-2">Person in charge</label>
                                    <div class="col-sm-5">
                                    : <input id="pic" name="pic" type="text" value="{{$designer->u_fullname}}" disabled>
                                    </div>
                                </div>
                                <!-- collar colour field -->                                
                                <div class="form-group row">
                                    <label class="col-sm-2">Collar Colour : </label>
                                    <div class="col-sm-8">
                                        @foreach ($specs as $spec)
                                            @if($spec->collar_color != "")
                                                <input id="col_color" name="col_color" type="text" value="{{$spec->collar_color}}" disabled>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <!-- jpeg mockup field -->                                                            
                                <div class="form-group row">
                                    <label class="col-sm-2">JPEG Mockup :</label>
                                    <div class="col-sm-6">
                                    <img src="https://cf.shopee.com.my/file/2ec64dfe152eb0fca6a715ae1cd33aac" width="100%">
                                    </div>
                                </div>
                                <!-- remarks field -->        
                                <div class="form-group row">
                                    <label class="col-sm-2">Remarks</label> :
                                    <div class="col-sm-6">
                                        <textarea rows="4" cols="50" disabled>{{$order->note}}</textarea>
                                    </div>
                                </div>
                            
                            </div>
                            <!-- Second column -->
                            <div class="col-12 scroll_page--box">
                                <div class="row">
                                <div class="col-sm-6">
                                    <img src="{{url('img/collar-type.jpeg')}}" style="width:35vw; margin: 0px auto; margin-bottom:20px;">
                                </div>
                                <div class="col-sm-6">
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
                                            <input class="col-4" disabled  value="{{$order->quantity_total}}" style="background-color:red; color:white"/> <p>PCS</p>
                                        </div>
                                        <div class="text-big-red">
                                            @foreach ($materials as $material)
                                                @if($order->material_id == $material->m_id)
                                                    <h1 style="font-size:150px;">{{$material->m_desc}} <br> EYELET</h1>
                                                @endif
                                            @endforeach
                                        </div>
                                </div>
                                </div>
                                <br>
                                <br>
                                <div class="form-group col-sm-6">
                                    @foreach ($specs as $spec)
                                        <strong>{{$spec->b_desc}}, {{$spec->sl_desc}} SLEEVE, <span style="color: red; font-size:25px; text-transform: uppercase;">{{$spec->n_desc}}</span></strong>
                                    
                                    
                                    <div class="row">
                                        <table class="table table-bordered"  style="width:50%; margin: 0px auto; margin-top:20px; text-align: center;">
                                            <thead  style="background-color:yellow; color:black">
                                                <tr>
                                                    @if($order->category == "Nameset")
                                                        <th scope="col">Name</th>
                                                    @endif
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Designed</th>
                                                    <th scope="col">Printed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                {{-- <tr>
                                                    @if($order->category == "Nameset")
                                                        <td></td>
                                                    @endif
                                                    <td>XXS</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr> --}}
                                                @foreach ($units as $unit)
                                                    @if($spec->s_id == $unit->s_id)
                                                        <tr>
                                                            @if($order->category == "Nameset")
                                                                <td>{{$unit->name}}</td>
                                                            @endif
                                                            <td>{{$unit->size}}</td>
                                                            <td>{{$unit->un_quantity}}</td>
                                                            @if($unit->d_type == 3)
                                                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                            @if($unit->un_status == 1)
                                                                <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    @if($order->category == "Nameset")
                                                        <td></td>
                                                    @endif
                                                    <th scope="row">Total</th>
                                                    @foreach ($invoicepermanents as $invoicepermanent)
                                                        @if($invoicepermanent->s_id == $spec->s_id)
                                                            <td style="background-color:#0051ff; color:black;">{{$invoicepermanent->spec_total_quantity}}</td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                        {{-- <table class="table table-bordered" style="width:50%; margin: 0px auto; margin-top:20px;">
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
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3XL</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4XL</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5XL</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">6XL</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">7XL</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Total</th>
                                                    <td style="background-color:#0051ff"></td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table> --}}
                                    </div>
                                    <br>
                                    @endforeach
                                </div>
                                
                                <div class="form-group row">       
                                <div class="col-sm-8 offset-sm-3">
                                    <input type="submit" value="PRINT" class="btn btn-primary float-right ">
                                    </div>                     
                                </div>
                            </div>
                        
                        <!-- </div> -->
                   
                    </div>
                   
                </form>
            </div>  
        </div>        
    </div>  
</div>      
@endsection

