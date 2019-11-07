@extends('layouts.layout')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Order</div>

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
                        <div class="form-group">
                            {{-- label for title --}}
                            {{Form::label('date', 'Date')}}<br>
                            {{-- input text field for title --}}
                            {{Form::date('current_date', \Carbon\Carbon::now(), array('disabled'))}}
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
                                    <input name="somedate" type="date" min={{\Carbon\Carbon::now()->addDays($deliverysetting->min_day)}}>
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
                            {{Form::file('cover_image')}}
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
                                            {{Form::label('size', 'Case Size')}}
                                            <table id="namesettablesize" style="width:80%; margin: 0px auto;">
                                                <tr>
                                                    <th id="namesethead">Size</th>
                                                    <th id="namesethead">Quantity</th> 
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">XXS</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantityxxs" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">XS</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantityxs" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">S</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantitys" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">M</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantitym" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">L</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantityl" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantityxl" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">2XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantity2xl" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">3XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantity3xl" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">4XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantity4xl" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">5XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantity5xl" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">6XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantity6xl" name="quantitysingle"></td>
                                                </tr>
                                                <tr>
                                                    <td id="namesetdata">7XL</td>
                                                    <td id="namesetdata"><input onblur="findTotal()" type="number" class="form-control" id="quantity7xl" name="quantitysingle"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
            
                                    {{-- case nameset --}}
                                    <div id="divnameset" style="display:none">
                                        <div class="form-group">
                                            {{Form::label('nameset', 'Case Nameset')}}
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
                                                    <td id="namesetdata"><input type="text" class="form-control" id="name" name="name"></td>
                                                    <td id="namesetdata"><select name="size" id="size" class="form-control">
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
                                                    <td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control" id="quantitynameset" name="quantitysinglenameset"></td>
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
                        
                                                    <input type='radio' onclick='javascript:collarType();' name="collartype0" id="roundneck" value="Round Neck"/> Round Neck<br>
                                                    <input type="radio" onclick="javascript:collarType();" name="collartype0" id="collar" value="Collar"/> Collar
                                                    
                                                    <div id="typecollar" style="display:none">
                                                        <br>
                                                        {{Form::label('collartype', 'Collar Type')}}<br>

                                                        <select name="necktype0" id="necktype0" class="form-control">
                                                            {{-- radio field for collar neck --}}
                                                            @if(count($necks) > 0)
                                                                @foreach ($necks as $neck)
                                                                    <option value="{{ $neck->n_id }}">{{ $neck->n_desc }}</option>
                                                                @endforeach
                                                            @else
                                                                <option value="">No collar type recorded</option>
                                                            @endif
                                                        </select>
                                                        
                                                    </div>
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
                        <br>
                        {{-- Submit button --}}
                        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}

                    {!! Form::close() !!}

                    


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    #namesettable, #namesettablesize, #namesethead, #namesetdata {
        border: 1px solid black;
        border-collapse: collapse;
    }
    #namesethead, #namesetdata {
        padding: 10px;
    }
</style>


<script type="text/javascript">

    // function to calculate total quantity for case size
    function findTotal(){
        var arr = document.getElementsByName('quantitysingle');
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
        var arr = document.getElementsByName('quantitysinglenameset');
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

    // function to add one row in nameset table
    function addRow(numRow) {
        var newRow = $('<tr><td id="namesetdata"><input type="text" class="form-control" id="name" name="name"></td><td id="namesetdata"><select name="size" id="size" class="form-control"><option value="xxs">XXS</option><option value="xs">XS</option><option value="s">S</option><option value="m">M</option><option value="l">L</option><option value="xl">XL</option><option value="2xl">2XL</option><option value="3xl">3XL</option><option value="4xl">4XL</option><option value="5xl">5XL</option><option value="6xl">6XL</option><option value="7xl">7XL</option></select></td><td id="namesetdata"><input onblur="findTotalNameset()" type="number" class="form-control"  id="quantitynameset" name="quantitysinglenameset"></td></tr>');
        $('#namesettable'+ numRow.toString() +' tr:last').after(newRow);
        numRow += 1;
    }

    // function to remove one row in nameset table
    function removeRow(numRow) {
        $('#namesettable'+ numRow.toString() +' tr:last').remove();
        // update quantity for nameset
        var arr = document.getElementsByName('quantitysinglenameset');
        var tot= 0;
        for(var i=0;i<arr.length;i++){
            if(parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }
        document.getElementById('total_quantity').value = tot;
    }

    // function to add a new set row for spec table (type0, sleeve0, collartype0, necktype0, collar_color0)
    var num = 1;
    function addSet() {
        var newRow = $('<tr><td><hr><div class="form-group">{{Form::label("type", "Type")}}<br>@foreach ($bodies as $body)<input type="radio" name="type'+ num.toString() +'" id="idtype'+ num.toString() +'" value={{ $body->b_id }}/> {{ $body->b_desc }}<br>@endforeach</div><div class="form-group">{{Form::label("sleeve", "Sleeve")}}<br>@foreach ($sleeves as $sleeve)<input type="radio" name="sleeve'+ num.toString() +'" id="idsleeve'+ num.toString() +'" value={{ $sleeve->sl_id }}/> {{ $sleeve->sl_desc }}<br>@endforeach</div><div class="form-group">{{Form::label("type", "Neck Type")}}<br><input type="radio" onclick="javascript:collarTypeAdd('+ num.toString() +');" name="collartype'+ num.toString() +'" id="roundneck'+ num.toString() +'" value="Round Neck"/> Round Neck<br><input type="radio" onclick="javascript:collarTypeAdd('+ num.toString() +');" name="collartype'+ num.toString() +'" id="collar'+ num.toString() +'" value="Collar"/> Collar<br><br><div id="typecollar'+ num.toString() +'" style="display:none">{{Form::label("collartype", "Collar Type")}}<br><select name="necktype'+ num.toString() +'" id="necktype'+ num.toString() +'" class="form-control">@if(count($necks) > 0)@foreach ($necks as $neck)<option value="{{ $neck->n_id }}">{{ $neck->n_desc }}</option>@endforeach @else<option value="">No collar type recorded</option>@endif</select><br></div><div class="form-group">{{Form::label("collar_color", "Collar Color")}}{{Form::text("collar_color'+ num.toString() +'", "", ["class" => "form-control", "placeholder" => "Collar Color"])}}<br></div><div id="adddivsize'+ num.toString() +'" style="display:none"><div class="form-group">{{Form::label("size", "Case Size")}}<table id="namesettablesize" style="width:80%; margin: 0px auto;"><tr><th id="namesethead">Size</th><th id="namesethead">Quantity</th> </tr><tr><td id="namesetdata">XXS</td><td id="namesetdata"><input type="number" class="form-control" id="quantityxxs" name="quantityxxs"></td></tr><tr><td id="namesetdata">XS</td><td id="namesetdata"><input type="number" class="form-control" id="quantityxs" name="quantityxs"></td></tr><tr><td id="namesetdata">S</td><td id="namesetdata"><input type="number" class="form-control" id="quantitys" name="quantitys"></td></tr><tr><td id="namesetdata">M</td><td id="namesetdata"><input type="number" class="form-control" id="quantitym" name="quantitym"></td></tr><tr><td id="namesetdata">L</td><td id="namesetdata"><input type="number" class="form-control" id="quantityl" name="quantityl"></td></tr><tr><td id="namesetdata">XL</td><td id="namesetdata"><input type="number" class="form-control" id="quantityxl" name="quantityxl"></td></tr><tr><td id="namesetdata">2XL</td><td id="namesetdata"><input type="number" class="form-control" id="quantity2xl" name="quantity2xl"></td></tr><tr><td id="namesetdata">3XL</td><td id="namesetdata"><input type="number" class="form-control" id="quantity3xl" name="quantity3xl"></td></tr><tr><td id="namesetdata">4XL</td><td id="namesetdata"><input type="number" class="form-control" id="quantity4xl" name="quantity4xl"></td></tr><tr><td id="namesetdata">5XL</td><td id="namesetdata"><input type="number" class="form-control" id="quantity5xl" name="quantity5xl"></td></tr><tr><td id="namesetdata">6XL</td><td id="namesetdata"><input type="number" class="form-control" id="quantity6xl" name="quantity6xl"></td></tr><tr><td id="namesetdata">7XL</td><td id="namesetdata"><input type="number" class="form-control" id="quantity7xl" name="quantity7xl"></td></tr></table></div></div><div id="adddivnameset'+ num.toString() +'" style="display:none"><div class="form-group">{{Form::label("nameset", "Case Nameset")}}<table id="namesettable'+ num.toString() +'" style="width:80%; margin: 0px auto;"><tr><th id="namesethead"><button type="button" style="float: right"; id="btnAddRow" onclick="addRow('+ num.toString() +')"><i class="fa fa-plus"></i></button><button type="button" style="float: right"; id="btnRemoveRow" onclick="removeRow('+ num.toString() +')"><i class="fa fa-minus"></i></button>Name</th> <th id="namesethead">Size</th><th id="namesethead">Quantity</th> </tr><tr><td id="namesetdata"><input type="text" class="form-control" id="name" name="name"></td><td id="namesetdata"><select name="size" id="size" class="form-control"><option value="xxs">XXS</option><option value="xs">XS</option><option value="s">S</option><option value="m">M</option><option value="l">L</option><option value="xl">XL</option><option value="2xl">2XL</option><option value="3xl">3XL</option><option value="4xl">4XL</option><option value="5xl">5XL</option><option value="6xl">6XL</option><option value="7xl">7XL</option></select></td><td id="namesetdata"><input type="number" class="form-control" id="quantity" name="quantity"></td></tr></table></div></div></td></tr><tr></tr>');
        $('#settable tr:last').after(newRow);
        num += 1;
        document.getElementById('setamount').value = num;
        console.log(document.getElementById('setamount').value);
        console.log(typeof(document.getElementById('setamount').value));
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

    // function to display collar type if user choose collar
    function collarType() {
        if (document.getElementById('roundneck').checked) {
            document.getElementById('typecollar').style.display = 'none';
        } else if (document.getElementById('collar').checked) {
            document.getElementById('typecollar').style.display = 'block';
        }
    }

    // function to display collar type if user choose collar in added set div
    function collarTypeAdd(num) {
        if (document.getElementById('roundneck'+ num +'').checked) {
            document.getElementById('typecollar'+ num +'').style.display = 'none';
        } else if (document.getElementById('collar'+ num +'').checked) {
            document.getElementById('typecollar'+ num +'').style.display = 'block';
        }
    }

    // function to display or hide case nameset and size when user chose category
    function categoryType() {
        if (document.getElementById('size').checked) {
            findTotal();
            document.getElementById('divsize').style.display = 'block';
            document.getElementById('divnameset').style.display = 'none';
        } else if (document.getElementById('nameset').checked) {
            findTotalNameset();
            document.getElementById('divsize').style.display = 'none';
            document.getElementById('divnameset').style.display = 'block';
        }
    }

</script>


