@extends('layouts.layout')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">New Order</div>
                <!-- <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- ---------------------------- form ----------------------------------- --}}

                    {{-- form from laravel collective   ['action' => 'CustomerController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']   --}}
                    {!! Form::open(array( 'route'=>'customer.store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                        {{-- current date --}}
                        <div class="form-group">
                            {{-- label for title --}}
                            {{Form::label('date', 'Date')}}<br>
                            {{-- input text field for title --}}
                            {{Form::date('current_date', \Carbon\Carbon::now(new DateTimeZone('Asia/Kuala_Lumpur')), array('disabled'))}}
                        </div>
                        {{-- cloth name --}}
                        <div class="form-group">
                            {{-- label for cloth name --}}
                            {{Form::label('cloth_name', 'Cloth Name')}}
                            {{-- input text field for cloth name --}}
                            {{Form::text('cloth_name', '', ['class' => 'form-control', 'placeholder' => 'Cloth Name'])}}
                        </div>
                        <div class="form-group">
                            {{-- label for material --}}
                            {{Form::label('material', 'Material')}}
                            <br>
                            <select name="material" id="material" class="form-control">
                                @if(count($materials) > 0)
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->m_id }}">{{ $material->m_desc }}</option>
                                    @endforeach
                                @else
                                    <option value="">No material recorded</option>
                                @endif

                            </select>
                        </div>
                        {{-- quantity --}}
                        <div class="form-group">
                            {{-- label for quantity --}}
                            {{Form::label('quantity', 'Quantity')}}
                            {{-- input text field for amount --}}
                            <input type="number" class="form-control" id="total_quantity" name="total_quantity" readonly="true">
                            {{-- {{Form::number('total_quantity', '', ['class' => 'form-control', 'placeholder' => 'Total quantity ordered', 'disabled' => 'disabled'])}} --}}
                        </div>
                        {{-- delivery date --}}
                        <div class="form-group">
                            {{-- label for title --}}
                            {{Form::label('delivery_date', 'Delivery Date')}}<br>
                            
                            @if(count($deliverysettings) > 0)
                                @foreach ($deliverysettings as $deliverysetting)
                                    {{-- <input name="somedate" type="date" min={{\Carbon\Carbon::now()}} max={{\Carbon\Carbon::now()->addDays($deliverysetting->min_day)}}> --}}
                                    <input name="somedate" type="date" min={{\Carbon\Carbon::now(new DateTimeZone('Asia/Kuala_Lumpur'))->addDays($deliverysetting->min_day)}}>
                                @endforeach
                            @else
                                <p>No delivery setting recorded</p>
                            @endif
                            {{-- {{Form::date('delivery_date', \Carbon\Carbon::now()->addDays(7), array('disabled'))}} --}}
                        </div>
                        {{-- category --}}
                        <div class="form-group">
                                                    
                            {{Form::label('category', 'Category')}}
                            <br>

                            <input type='radio' onclick='javascript:categoryType();' value="Size" name="category" id="size"/> Size<br>
                            <input type="radio" onclick="javascript:categoryType();" value="Nameset" name="category" id="nameset"/> Nameset
                        </div>

                        

                        {{-- mockup design --}}
                        <div class="form-group">
                            {{-- label for mockup design --}}
                            {{Form::label('mockup_design', 'Mockup Design')}}<br>
                            {{-- use laravel collective package --}} 
                            {{-- {{Form::file('cover_image')}} --}}
                            <input type="file" name="cover_image">
                            {{-- <input type="file" name="cover_image[]" multiple> --}}
                        </div>
                        {{-- note --}}
                        <div class="form-group">
                            {{-- label for note --}}
                            {{Form::label('note', 'Note')}}
                            {{-- input text area field for note and add editor in the array --}}
                            {{Form::textarea('note', '', ['class' => 'form-control', 'placeholder' => 'Note'])}}
                        </div>
                        {{-- Set --}}
                        <div class="form-group">
                            <div class="card">
                                <div class="card-header">
                                    Set
                                    <button type="button" style="float: right"; id="btnAddRow" onclick="addSet()">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <button type="button" style="float: right"; id="btnRemoveRow" onclick="deleterow()">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <div class="card-body">

                                    {{-- case size --}}
                                    <div id="divsize" style="display:none">
                                        <div class="form-group">
                                            <input type="hidden" id="totset" name="totset" value="">
                                            {{Form::label("size", "Case Size")}}
                                            <table id="namesettablesize" style="width:80%; margin: 0px auto;">
                                                <tr>
                                                    <th id="namesethead">Size</th>
                                                    <th id="namesethead">Quantity</th> 
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">XXS</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantityxxs" name="quantitysinglexxs0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">XS</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantityxs" name="quantitysinglexs0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">S</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantitys" name="quantitysingles0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">M</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantitym" name="quantitysinglem0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">L</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantityl" name="quantitysinglel0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantityxl" name="quantitysinglexl0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">2XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity2xl" name="quantitysingle2xl0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">3XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity3xl" name="quantitysingle3xl0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">4XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity4xl" name="quantitysingle4xl0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">5XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity5xl" name="quantitysingle5xl0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">6XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity6xl" name="quantitysingle6xl0"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">7XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity7xl" name="quantitysingle7xl0"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
            
                                    {{-- case nameset --}}
                                    <div id="divnameset" style="display:none">
                                        <div class="form-group">
                                            <input type="hidden" id="namesetnum0" name="namesetnum0" value="1">
                                            {{Form::label("nameset", "Case Nameset")}}
                                            <table id="namesettable0" style="width:80%; margin: 0px auto;">
                                                <tr>
                                                    <th id="namesethead">
                                                        <button type="button" style="float: right"; id="btnAddRow" onclick="addRow(0)">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        <button type="button" style="float: right"; id="btnRemoveRow" onclick="removeRow(0)">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        Name
                                                    </th> 
                                                    <th id="namesethead">Size</th>
                                                    <th id="namesethead">Quantity</th> 
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata"><input type="text" class="form-control" id="name0" name="name0"></td>
                                                    <td id="namesetdata"><select name="size0" id="size0" class="form-control">
                                                            <option value="xxs">XXS</option>
                                                            <option value="xs">XS</option>
                                                            <option value="s">S</option>
                                                            <option value="m">M</option>
                                                            <option value="l">L</option>
                                                            <option value="xl">XL</option>
                                                            <option value="2xl">2XL</option>
                                                            <option value="3xl">3XL</option>
                                                            <option value="4xl">4XL</option>
                                                            <option value="5xl">5XL</option>
                                                            <option value="6xl">6XL</option>
                                                            <option value="7xl">7XL</option>
                                                        </select>
                                                    </td>
                                                    <td id="namesetdata"><input onblur="findTotalNameset()" class="form-control totalnameset" type="number" id="quantitynameset" name="quantitysinglenamesetname0"></td>
                                                    
                                                </tr>
                                            </table>  
                                        </div>
                                    </div>

                                    <table id="settable" style="width:100%; margin: 0px auto;">
                                        <th></th>
                                        <tr>
                                            <td>
                                                {{-- type --}}
                                                <div class="form-group">
                                                    {{-- label for type --}}
                                                    {{Form::label('type', 'Body Type')}}
                                                    <br>
                                                    {{-- radio field for type --}}
                                                    @if(count($bodies) > 0)
                                                        @foreach ($bodies as $body)
                                                            {{Form::radio('type0', $body->b_id)}} {{ $body->b_desc }}<br>
                                                            {{-- <p>{{$body->b_desc}}</p> --}}
                                                        @endforeach
                                                    @else
                                                        {{Form::radio('type0', '')}} No body type recorded
                                                        {{-- <p>No body recorded</p> --}}
                                                    @endif
                                                    
                                                </div>
                                                {{-- sleeve --}}
                                                <div class="form-group">
                                                    {{-- label for sleeve --}}
                                                    {{Form::label('sleeve', 'Sleeve')}}
                                                    <br>
                                                    {{-- radio field for sleeve --}}
                                                    @if(count($sleeves) > 0)
                                                        @foreach ($sleeves as $sleeve)
                                                            {{Form::radio('sleeve0', $sleeve->sl_id)}} {{ $sleeve->sl_desc }}<br>
                                                            {{-- <p>{{$sleeve->sl_desc}}</p> --}}
                                                        @endforeach
                                                    @else
                                                        {{Form::radio('sleeve0', '')}} No sleeve recorded
                                                        {{-- <p>No sleeve recorded</p> --}}
                                                    @endif
                                                </div>
                                                {{-- neck --}}
                                                <div class="form-group">
                                                    {{-- label for neck --}}
                                                    {{Form::label('type', 'Neck Type')}}
                                                    <br>
                        
                                                    {{-- <input type='radio' onclick='javascript:collarType();' name="collartype0" id="roundneck" value="0"/> Round Neck<br>
                                                    <input type="radio" onclick="javascript:collarType();" name="collartype0" id="collar" value="Collar"/> Collar
                                                    
                                                    <div id="typecollar" style="display:none">
                                                        <br> --}}
                                                    {{-- {{Form::label('collartype', 'Collar Type')}}<br> --}}

                                                    {{-- <select name="necktype0" id="necktype0" class="form-control"> --}}
                                                    {{-- radio field for collar neck --}}
                                                    @if(count($necks) > 0)
                                                        @foreach ($necks as $neck)
                                                            <input type="radio" name="necktype0" id="necktype0" value="{{ $neck->n_id }}"/> {{ $neck->n_desc }} <br>
                                                            {{-- <option value="{{ $neck->n_id }}">{{ $neck->n_desc }}</option> --}}
                                                        @endforeach
                                                    @endif
                                                    {{-- </select> --}}
                                                        
                                                    {{-- </div> --}}
                                                </div>



                                                {{-- collar color --}}
                                                <div class="form-group">
                                                    {{-- label for collar color --}}
                                                    {{Form::label('collar_color', 'Collar Color')}}
                                                    {{-- input text field for collar color --}}
                                                    {{Form::text('collar_color0', '', ['class' => 'form-control', 'placeholder' => 'Collar Color'])}}
                                                </div>

                                                
                                                
                                            </td>
                                        </tr>
                                        <tr>

                                        </tr>
                                    </table>

                                </div>
                                
                            </div>
                                
                        </div>
                        <input type="hidden" id="setamount" name="setamount">
                        <input type="hidden" id="totalcasenameset" name="totalcasenameset">
                        <input type="hidden" id="totalcasesize" name="totalcasesize">
                        <br>
                        {{-- Submit button --}}
                        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}

                    {!! Form::close() !!}

                </div> -->
                <div class="card-body">                 
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{-- ---------------------------- form ----------------------------------- --}}
                    {{-- form from laravel collective   ['action' => 'CustomerController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']   --}}
                    {!! Form::open(array( 'route'=>'customer.store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                    {{-- current date --}}                   
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label"> 
                            {{-- label for title --}}  
                            {{Form::label('date', 'Date')}}
                        </label>
                        <div class="col-sm-8">
                            {{-- input text field for title --}}
                            {{Form::date('current_date', \Carbon\Carbon::now(new DateTimeZone('Asia/Kuala_Lumpur')), array('disabled'))}}
                        </div>
                    </div>
                    {{-- cloth name --}}
                    <div class="line"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">
                            {{-- label for cloth name --}}
                            {{Form::label('cloth_name', 'Cloth Name')}}                          
                        </label>
                        <div class="col-sm-8">
                            {{-- input text field for cloth name --}}
                            {{Form::text('cloth_name', '', ['class' => 'form-control', 'placeholder' => 'Cloth Name'])}}
                        </div>
                    </div>
                    {{-- material --}}
                    <div class="line"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">
                            {{-- label for material --}}
                            {{Form::label('material', 'Material')}}
                        </label>
                        <div class="col-sm-8 mb-3">
                            <select name="material" id="material" class="form-control">
                                @if(count($materials) > 0)
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->m_id }}">{{ $material->m_desc }}</option>
                                    @endforeach
                                @else
                                    <option value="">No material recorded</option>
                                @endif
                            </select>
                        </div>                    
                    </div>
                    <div class="line"></div>
                    {{-- quantity --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">
                            {{-- label for quantity --}}
                            {{Form::label('quantity', 'Quantity')}}
                        </label>
                        <div class="col-sm-8">
                            {{-- input text field for amount --}}
                            <input type="number" class="form-control" id="total_quantity" name="total_quantity" readonly="true">
                            {{-- {{Form::number('total_quantity', '', ['class' => 'form-control', 'placeholder' => 'Total quantity ordered', 'disabled' => 'disabled'])}} --}}                       
                    </div>
                    </div>
                    <div class="line"></div>
                    {{-- delivery date --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">
                                {{-- label for title --}}
                                {{Form::label('delivery_date', 'Delivery Date')}}
                        </label>
                        <div class="col-sm-8">  
                            @if(count($deliverysettings) > 0)
                                @foreach ($deliverysettings as $deliverysetting)
                                    {{-- <input name="somedate" type="date" min={{\Carbon\Carbon::now()}} max={{\Carbon\Carbon::now()->addDays($deliverysetting->min_day)}}> --}}
                                    <input name="somedate" type="date" min={{\Carbon\Carbon::now(new DateTimeZone('Asia/Kuala_Lumpur'))->addDays($deliverysetting->min_day)}}>                              
                                @endforeach
                            @else
                                <p>No delivery setting recorded</p>
                            @endif
                            {{-- {{Form::date('delivery_date', \Carbon\Carbon::now()->addDays(7), array('disabled'))}} --}}
                    </div>
                    </div>
                    <div class="line"></div>
                    {{-- category --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">
                            {{Form::label('category', 'Category')}}                          
                        </label>
                        <div class="col-sm-10">
                            <div>
                                <input type='radio' onclick='javascript:categoryType();' value="Size" name="category" id="size"/> 
                                <label for="radio">Size</label>
                            </div>
                            <div>
                                <input type="radio" onclick="javascript:categoryType();" value="Nameset" name="category" id="nameset"/> 
                                <label for="radio">Nameset</label>
                            </div>
                        </div>
                    </div>
                    <div class="line"></div>
                    {{-- mockup design --}}
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">
                            {{-- label for mockup design --}}
                            {{Form::label('mockup_design', 'Mockup Design')}}
                        </label>
                        <div class="col-sm-8">
                            {{-- use laravel collective package --}} 
                            {{-- {{Form::file('cover_image')}} --}}
                            <input type="file" name="cover_image">
                            {{-- <input type="file" name="cover_image[]" multiple> --}}
                    </div>
                        
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">
                            {{-- label for note --}}
                            {{Form::label('note', 'Note')}}
                        </label>
                        <div class="col-sm-8">
                            {{-- input text area field for note and add editor in the array --}}
                            {{Form::textarea('note', '', ['class' => 'form-control', 'placeholder' => 'Note'])}}
                        </div>              
                    </div>
                    <div class="line"></div>
                    {{-- Set --}}
                    <div class="form-group">
                    
                        <div class="card-header col-sm-10 ">
                            Set
                            <button type="button" class="btn btn-primary" style="float: right"; id="btnAddRow" onclick="addSet()">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-primary" style="float: right"; id="btnRemoveRow" onclick="deleterow()">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>                          
                        <div class="card-body col-sm-10">
                            
                            <table id="settable" style="width:100%; margin: 0px auto; margin-top:20px;">
                                <th></th>
                                <tr>
                                    <td>
                                        <div class="row">
                                            {{-- type --}}
                                            <div class="col-sm">
                                                <div>
                                                    <label class="form-control-label">
                                                        {{-- label for type --}}
                                                        <Strong>{{Form::label('type', 'Body Type')}}</strong>
                                                    </label>
                                                    <div>
                                                        {{-- radio field for type --}}
                                                        @if(count($bodies) > 0)
                                                            @foreach ($bodies as $body)
                                                                {{Form::radio('type0', $body->b_id)}} {{ $body->b_desc }}<br>
                                                                {{-- <p>{{$body->b_desc}}</p> --}}
                                                            @endforeach
                                                        @else
                                                            {{Form::radio('type0', '')}} No body type recorded
                                                            {{-- <p>No body recorded</p> --}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- sleeve --}}
                                            <div class="col-sm">
                                                <div>
                                                    <label  class="form-control-label">
                                                        {{-- label for sleeve --}}
                                                        <Strong>{{Form::label('sleeve', 'Sleeve')}}</strong>                                                        
                                                    </label>
                                                    <div>
                                                    {{-- radio field for sleeve --}}
                                                    @if(count($sleeves) > 0)
                                                        @foreach ($sleeves as $sleeve)
                                                            {{Form::radio('sleeve0', $sleeve->sl_id)}} {{ $sleeve->sl_desc }}<br>
                                                            {{-- <p>{{$sleeve->sl_desc}}</p> --}}
                                                        @endforeach
                                                    @else
                                                        {{Form::radio('sleeve0', '')}} No sleeve recorded
                                                        {{-- <p>No sleeve recorded</p> --}}
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- collar color --}}
                                            <div class="col-sm">
                                                <label class="form-control-label">
                                                {{-- label for collar color --}}
                                                <strong>{{Form::label('collar_color', 'Collar Color')}}</strong>
                                                </label>

                                                <div>
                                                {{-- input text field for collar color --}}
                                                {{Form::text('collar_color0', '', ['class' => 'form-control', 'placeholder' => 'Collar Color'])}}
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            {{-- neck --}}
                                                <div class="col-sm">
                                                    <label  class="form-control-label">
                                                        {{-- label for neck --}}
                                                        <Strong>{{Form::label('type', 'Neck Type')}}</strong>                                                        
                                                    </label>
                                                    <div>
                                                        {{-- <input type='radio' onclick='javascript:collarType();' name="collartype0" id="roundneck" value="0"/> Round Neck<br>
                                                        <input type="radio" onclick="javascript:collarType();" name="collartype0" id="collar" value="Collar"/> Collar
                                                    </div>
                                                    <div id="typecollar" style="display:none">
                                                        <br> --}}
                                                    {{-- {{Form::label('collartype', 'Collar Type')}}<br> --}}

                                                    {{-- <select name="necktype0" id="necktype0" class="form-control"> --}}
                                                    {{-- radio field for collar neck --}}
                                                    @if(count($necks) > 0)
                                                        @foreach ($necks as $neck)
                                                            <input type="radio" name="necktype0" id="necktype0" value="{{ $neck->n_id }}"/> {{ $neck->n_desc }}
                                                            <img src="http://i1.wp.com/clipartportal.com/wp-content/uploads/2018/12/collared-shirt-clipart-3.jpg" style="width:10%">
                                                            {{-- <option value="{{ $neck->n_id }}">{{ $neck->n_desc }}</option> --}}
                                                        @endforeach
                                                    @endif
                                                    {{-- </select> --}}
                                                        
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                         {{-- case size --}}
                                        <div id="divsize" style="display:none">
                                            <div class="form-group">
                                                <input type="hidden" id="totset" name="totset" value="">
                                                <strong>{{Form::label("size", "Case Size")}}</strong>
                                                <div class="row">
                                                <table id="namesettablesize" style="width:48%; margin: 0px auto;">
                                                    <tr>
                                                        <th id="namesethead">Size</th>
                                                        <th id="namesethead">Quantity</th> 
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">XXS</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantityxxs" name="quantitysinglexxs0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">XS</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantityxs" name="quantitysinglexs0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">S</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantitys" name="quantitysingles0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">M</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantitym" name="quantitysinglem0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">L</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantityl" name="quantitysinglel0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">XL</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantityxl" name="quantitysinglexl0"></td>
                                                    </tr>
                                                </table>
                                                <table id="namesettablesize" style="width:48%; margin: 0px auto;">
                                                    <tr>
                                                        <th id="namesethead">Size</th>
                                                        <th id="namesethead">Quantity</th> 
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">2XL</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity2xl" name="quantitysingle2xl0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">3XL</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity3xl" name="quantitysingle3xl0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">4XL</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity4xl" name="quantitysingle4xl0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">5XL</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity5xl" name="quantitysingle5xl0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">6XL</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity6xl" name="quantitysingle6xl0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td id="namesetdata">7XL</td>
                                                        <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control totalnameset" id="quantity7xl" name="quantitysingle7xl0"></td>
                                                    </tr>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{-- case nameset --}}
                                        <div id="divnameset" style="display:none">
                                            <div class="form-group col-sm-10">
                                                <input type="hidden" id="namesetnum0" name="namesetnum0" value="1">
                                                <strong>{{Form::label("nameset", "Case Nameset")}}</strong>
                                                <div>
                                                    <table id="namesettable0"  style="width:100%; margin: 0px auto;">
                                                        <tr>
                                                            <th id="namesethead">
                                                                <button type="button" style="float: right"; id="btnAddRow" onclick="addRow(0)">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button type="button" style="float: right"; id="btnRemoveRow" onclick="removeRow(0)">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                                Name
                                                            </th> 
                                                            <th id="namesethead">Size</th>
                                                            <th id="namesethead">Quantity</th> 
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata"><input type="text" class="form-control" id="name0" name="name0-0"></td>
                                                            <td id="namesetdata"><select name="size0-0" id="size0" class="form-control">
                                                                    <option value="xxs">XXS</option>
                                                                    <option value="xs">XS</option>
                                                                    <option value="s">S</option>
                                                                    <option value="m">M</option>
                                                                    <option value="l">L</option>
                                                                    <option value="xl">XL</option>
                                                                    <option value="2xl">2XL</option>
                                                                    <option value="3xl">3XL</option>
                                                                    <option value="4xl">4XL</option>
                                                                    <option value="5xl">5XL</option>
                                                                    <option value="6xl">6XL</option>
                                                                    <option value="7xl">7XL</option>
                                                                </select>
                                                            </td>
                                                            <td id="namesetdata"><input onblur="findTotalNameset()" class="form-control totalnameset" 
                                                                type="number" id="quantitynameset" name="quantitysinglenamesetname0-0"></td>
                                                            
                                                        </tr>
                                                    </table>  
                                                <div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                            </table>      

                          
                        </div>
                                                        
                    </div>
                    <input type="hidden" id="setamount" name="setamount">
                    <input type="hidden" id="totalcasenameset" name="totalcasenameset">
                    <input type="hidden" id="totalcasesize" name="totalcasesize">
                    <br><br>
                
                
                    {{-- Submit button --}}
                    {{Form::submit('Submit', ['class'=>'btn btn-primary float-right'])}}
                    
                    {!! Form::close() !!}    
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    #namesettable, #namesettablesize, #namesethead, #namesetdata {
        border: 0.5px solid #aaa;
        border-collapse: collapse;
    }
    #namesethead, #namesetdata {
        padding: 10px;
    }
</style>


<script type="text/javascript">

    // function to calculate total quantity for case size
    function findTotal(){
        var arr = document.getElementsByClassName('totalnameset');
        var tot= 0;
        for(var i=0;i<arr.length;i++){
            if(parseInt(arr[i].value))
                // console.log(arr[i].value);
                tot += parseInt(arr[i].value);
                //console.log(typeof(arr[i].value));
        }
        if(tot == 0){
            document.getElementById('total_quantity').value = "";
        }else{
            document.getElementById('total_quantity').value = tot;
        }
    }

    // function to calculate total quantity for case nameset
    function findTotalNameset(){

        var arr = document.getElementsByClassName('totalnameset');
        var tot= 0;
        //console.log(arr.length);
        for(var i=0;i<arr.length;i++){
            if(parseInt(arr[i].value))
                // console.log(arr[i].value);
                tot += parseInt(arr[i].value);
                //console.log(typeof(arr[i].value));
        }
        if(tot == 0){
            document.getElementById('total_quantity').value = "";
        }else{
            document.getElementById('total_quantity').value = tot;
        }
        
    }
    
    var totnameset = 1;
    var namesetnumamount;
    // function to add one row in nameset table
    function addRow(numRow) {

        // get the value of namesetnum
        var namesetnumamount = document.getElementById('namesetnum'+numRow).value;
        //console.log(namesetnumamount);
        
        var newRow = $('<tr><td id="namesetdata"><input type="text" class="form-control" id="name" name="name'+ numRow.toString() +'-'+ namesetnumamount.toString() +'"></td>'+
            '<td id="namesetdata"><select name="size'+ numRow.toString() +'-'+ namesetnumamount.toString() +'" id="size" class="form-control">'+
                '<option value="xxs">XXS</option>'+
                '<option value="xs">XS</option>'+
                '<option value="s">S</option>'+
                '<option value="m">M</option>'+
                '<option value="l">L</option>'+
                '<option value="xl">XL</option>'+
                '<option value="2xl">2XL</option>'+
                '<option value="3xl">3XL</option>'+
                '<option value="4xl">4XL</option>'+
                '<option value="5xl">5XL</option>'+
                '<option value="6xl">6XL</option>'+
                '<option value="7xl">7XL</option>'+
            '</select></td>'+
            '<td id="namesetdata">'+
                '<input onblur="findTotalNameset()" type="number" class="form-control totalnameset"  '+
                'id="quantitynameset" name="quantitysinglenamesetname'+ numRow.toString() +'-'+ namesetnumamount.toString() +'">'+
            '</td></tr>');
        $('#namesettable'+ numRow.toString() +' tr:last').after(newRow);
        totnameset += 1;
        namesetnumamount = parseInt(namesetnumamount)+1;
        document.getElementById('namesetnum'+numRow).value = namesetnumamount;
        document.getElementById('totalcasenameset').value = totnameset;
        console.log("After add: "+document.getElementById('namesetnum'+numRow).value);
        numRow += 1;
        //console.log("After add: "+document.getElementById('namesetnum'+numRow).value)
        //console.log(document.getElementById('totalcasenameset').value);
    }

    // function to remove one row in nameset table
    function removeRow(numRow) {
        $('#namesettable'+ numRow.toString() +' tr:last').remove();
        // update quantity for nameset
        var arr = document.getElementById('quantitynameset');
        var tot= 0;
        for(var i=0;i<arr.length;i++){
            if(parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }
        var namesetnumamount = document.getElementById('namesetnum'+numRow).value;

        totnameset -= 1;
        namesetnumamount = parseInt(namesetnumamount)-1;
        document.getElementById('namesetnum'+numRow).value = namesetnumamount;
        console.log("After remove: "+document.getElementById('namesetnum'+numRow).value);
        document.getElementById('total_quantity').value = tot;
        document.getElementById('totalcasenameset').value = totnameset;
        //console.log("After remove: "+document.getElementById('totalcasenameset').value);
    }



    // {{Form::label("type", "Neck Type")}}<br><input type="radio" onclick="javascript:collarTypeAdd('+ num.toString() +');" name="collartype'+ num.toString() +'" id="roundneck'+ num.toString() +'" value="Round Neck"/> Round Neck<br><input type="radio" onclick="javascript:collarTypeAdd('+ num.toString() +');" name="collartype'+ num.toString() +'" id="collar'+ num.toString() +'" value="Collar"/> Collar<br><br><div id="typecollar'+ num.toString() +'" style="display:none">
    // function to add a new set row for spec table (type0, sleeve0, collartype0, necktype0, collar_color0)
    var num = 1;
    var numnameset = 1;
    function addSet() {
        var newRow = $('<tr><td><hr><div class="row">'+
                        '<div class="col-sm">'+
                            '<strong>{{Form::label("type", "Type")}}</strong><br>@foreach ($bodies as $body)<input type="radio" name="type'+ num.toString() +'" id="idtype'+ num.toString() +'" value={{ $body->b_id }}> {{ $body->b_desc }}<br>@endforeach</div><div class="col-sm"><strong>{{Form::label("sleeve", "Sleeve")}}</strong><br>@foreach ($sleeves as $sleeve)<input type="radio" name="sleeve'+ num.toString() +'" id="idsleeve'+ num.toString() +'" value={{ $sleeve->sl_id }}> {{ $sleeve->sl_desc }}<br>@endforeach</div><div class="col-sm"><strong>{{Form::label("collar_color", "Collar Color")}}</strong><input type="text" id="collar_color'+ num.toString() +'" name="collar_color'+ num.toString() +'" class="form-control"><br></div></div><br>'+
                            '<div class="row"><div class="col-sm"><strong>{{Form::label("type", "Neck Type")}}</strong><br>@if(count($necks) > 0) @foreach ($necks as $neck)<input type="radio" name="necktype'+ num.toString() +'" id="necktype'+ num.toString() +'" value="{{ $neck->n_id }}"/> {{ $neck->n_desc }} @endforeach @endif<br></div></div><div id="adddivsize'+ num.toString() +'" name="adddivsize" style="display:none">'+
                            '<div class="form-group"><input type="hidden" id="totset" name="totset" value="">'+
                            '<strong>{{Form::label("size", "Case Size")}}</strong><br>'+ 
                            '<div class="row" style="margin-bottom:20px">'+
                            '<table id="namesettablesize" style="width:48%; margin: 0px auto;">'+
                                '<tr><th id="namesethead">Size</th>'+
                                    '<th id="namesethead">Quantity</th> '+
                                '</tr>'+
                                '<tr><td id="namesetdata">XXS</td>'+
                                '   <td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantityxxs" name="quantitysinglexxs'+ num.toString() +'"></td>'+
                                '</tr>'+
                                '<tr><td id="namesetdata">XS</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantityxs" name="quantitysinglexs'+ num.toString() +'"></td>'+
                                '</tr>'+
                                '<tr><td id="namesetdata">S</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantitys" name="quantitysingles'+ num.toString() +'"></td></tr>'+
                                '<tr><td id="namesetdata">M</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantitym" name="quantitysinglem'+ num.toString() +'"></td></tr>'+
                                '<tr><td id="namesetdata">L</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantityl" name="quantitysinglel'+ num.toString() +'"></td></tr>'+
                                '<tr><td id="namesetdata">XL</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantityxl" name="quantitysinglexl'+ num.toString() +'"></td></tr>'+
                            '</table>'+
                            '<table id="namesettablesize" style="width:48%; margin: 0px auto;">'+
                                '<tr><th id="namesethead">Size</th>'+
                                    '<th id="namesethead">Quantity</th> '+
                                '</tr>'+
                                '<tr><td id="namesetdata">2XL</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantity2xl" name="quantitysingle2xl'+ num.toString() +'"></td></tr>'+
                                '<tr><td id="namesetdata">3XL</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantity3xl" name="quantitysingle3xl'+ num.toString() +'"></td></tr>'+
                                '<tr><td id="namesetdata">4XL</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantity4xl" name="quantitysingle4xl'+ num.toString() +'"></td></tr>'+
                                '<tr><td id="namesetdata">5XL</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantity5xl" name="quantitysingle5xl'+ num.toString() +'"></td></tr>'+
                                '<tr><td id="namesetdata">6XL</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantity6xl" name="quantitysingle6xl'+ num.toString() +'"></td></tr>'+
                                '<tr><td id="namesetdata">7XL</td>'+
                                    '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset" id="quantity7xl" name="quantitysingle7xl'+ num.toString() +'"></td></tr>'+
                            '</table></div></div></div><br>'+
                        '<div id="adddivnameset'+ num.toString() +'" name="adddivnameset" style="display:none">'+
                            '<div class="form-group col-sm-10"><input type="hidden" id="namesetnum'+ num.toString() +'" name="namesetnum'+ num.toString() +'" value="1">'+
                                '{{Form::label("nameset", "Case Nameset")}}'+
                                '<table id="namesettable'+ num.toString() +'" style="width:100%; margin: 0px auto;">'+
                                    '<tr><th id="namesethead"><button type="button" style="float: right"; id="btnAddRow" onclick="addRow('+ num.toString() +')"><i class="fa fa-plus"></i></button>'+
                                            '<button type="button" style="float: right"; id="btnRemoveRow" onclick="removeRow('+ num.toString() +')"><i class="fa fa-minus"></i></button>Name</th> '+
                                        '<th id="namesethead">Size</th>'+
                                        '<th id="namesethead">Quantity</th> '+
                                    '</tr>'+
                                    '<tr><td id="namesetdata"><input type="text" class="form-control" id="name" name="name'+ numnameset.toString() +'-0"></td>'+
                                        '<td id="namesetdata"><select name="size'+ numnameset.toString() +'-0" id="size" class="form-control">'+
                                            '<option value="xxs">XXS</option><option value="xs">XS</option>'+
                                            '<option value="s">S</option><option value="m">M</option>'+
                                            '<option value="l">L</option><option value="xl">XL</option>'+
                                            '<option value="2xl">2XL</option><option value="3xl">3XL</option>'+
                                            '<option value="4xl">4XL</option><option value="5xl">5XL</option>'+
                                            '<option value="6xl">6XL</option><option value="7xl">7XL</option>'+
                                            '</select>'+
                                        '</td>'+
                                        '<td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control totalnameset"'+
                                            ' id="quantity" name="quantitysinglenamesetname'+ numnameset.toString() +'-0">'+
                                        '</td>'+
                                    '</tr>'+
                                '</table>'+
                            '</div>'+
                        '</div><br></td></tr><tr></tr>');
        $('#settable tr:last').after(newRow);
        num += 1;
        numnameset += 1;
        document.getElementById('setamount').value = num;
        document.getElementById('totset').value = num;
        //console.log(document.getElementById('setamount').value);
        // console.log(typeof(document.getElementById('setamount').value));

        var totalsetnum = document.getElementById('totset').value -1;
        //console.log(totalsetnum);
        if(document.getElementById('totset').value != ""){

        var totalsetnum = document.getElementById('totset').value -1;
        //console.log(totalsetnum);
        if (document.getElementById('size').checked) {
            findTotal();
            var i;
            for(i = 1; i <= totalsetnum; i++){
                document.getElementById('adddivnameset'+ i.toString() +'').style.display = 'none';
                document.getElementById('adddivsize'+ i.toString() +'').style.display = 'block';
            }
            
            document.getElementById('divnameset').style.display = 'none';
            document.getElementById('divsize').style.display = 'block';
        } else if (document.getElementById('nameset').checked) {
            findTotalNameset();
            var i;
            for(i = 1; i <= totalsetnum; i++){
                document.getElementById('adddivnameset'+ i.toString() +'').style.display = 'block';
                document.getElementById('adddivsize'+ i.toString() +'').style.display = 'none';
            }
            document.getElementById('divsize').style.display = 'none';
            document.getElementById('divnameset').style.display = 'block';
        }

        }else{
            if (document.getElementById('size').checked) {
                findTotal();
                document.getElementById('divnameset').style.display = 'none';
                document.getElementById('divsize').style.display = 'block';
            } else if (document.getElementById('nameset').checked) {
                findTotalNameset();
                document.getElementById('divsize').style.display = 'none';
                document.getElementById('divnameset').style.display = 'block';
            }
        }

    }

    // function to remove one set row for spec table
    function deleterow() {
        var table = document.getElementById('settable');
        var rowCount = table.rows.length;
        num -= 1;
        document.getElementById('setamount').value = num;
        console.log(num);
        table.deleteRow(rowCount -1);
        table.deleteRow(rowCount -2);
    }

    // function to display or hide case nameset and size when user chose category
    function categoryType() {

        if(document.getElementById('totset').value != ""){

            var totalsetnum = document.getElementById('totset').value -1;
            console.log(totalsetnum);
            if (document.getElementById('size').checked) {
                findTotal();
                var i;
                for(i = 1; i <= totalsetnum; i++){
                    document.getElementById('adddivnameset'+ i.toString() +'').style.display = 'none';
                    document.getElementById('adddivsize'+ i.toString() +'').style.display = 'block';
                }
                
                document.getElementById('divnameset').style.display = 'none';
                document.getElementById('divsize').style.display = 'block';
            } else if (document.getElementById('nameset').checked) {
                findTotalNameset();
                var i;
                for(i = 1; i <= totalsetnum; i++){
                    document.getElementById('adddivnameset'+ i.toString() +'').style.display = 'block';
                    document.getElementById('adddivsize'+ i.toString() +'').style.display = 'none';
                }
                document.getElementById('divsize').style.display = 'none';
                document.getElementById('divnameset').style.display = 'block';
            }

        }else{
            if (document.getElementById('size').checked) {
                findTotal();
                document.getElementById('divnameset').style.display = 'none';
                document.getElementById('divsize').style.display = 'block';
            } else if (document.getElementById('nameset').checked) {
                findTotalNameset();
                document.getElementById('divsize').style.display = 'none';
                document.getElementById('divnameset').style.display = 'block';
            }
        }
        
    }

    // // function to display collar type if user choose collar
    // function collarType() {
    //     if (document.getElementById('roundneck').checked) {
    //         document.getElementById('typecollar').style.display = 'none';
    //     } else if (document.getElementById('collar').checked) {
    //         document.getElementById('typecollar').style.display = 'block';
    //     }
    // }

    // // function to display collar type if user choose collar in added set div
    // function collarTypeAdd(num) {
    //     if (document.getElementById('roundneck'+ num +'').checked) {
    //         document.getElementById('typecollar'+ num +'').style.display = 'none';
    //     } else if (document.getElementById('collar'+ num +'').checked) {
    //         document.getElementById('typecollar'+ num +'').style.display = 'block';
    //     }
    // }

</script>


