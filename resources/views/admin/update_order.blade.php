@extends ('layouts.layout')
@section ('content')
<style>
    .table {
       margin: auto;
       width: 80% !important; 
    }
</style>
<link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'> 
<script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 
<script src= "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {!! Form::open(array( 'route'=>'admin_update_order', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return confirm("Confirm submit your order?");')) !!}
            <div class="card">
                <div class="card-header">Update Order</div>
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-danger">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if ($prices != null)

                    <div class="form-group row">
                        <input type="hidden" name="custorderid" value="{{ $custorderid }}">
                        {{-- user type --}}
                        <label class="col-sm-2 col-form-label">
                            User Name
                        </label>
                        <div class="col-sm-4">
                            @foreach ($custunames as $custuname)
                                <input type="text" name="custuname" value="{{ $custuname->username }}" class="form-control" disabled> 
                                <input type="hidden" name="custid" value="{{ $custuname->u_id }}">
                                <input type="hidden" name="usertype" value="{{ $custuname->u_type }}">
                            @endforeach
                        </div>
                        
                        {{-- designer --}}
                        <label class="col-sm-2 col-form-label">
                            Designer                         
                        </label>
                        <div class="col-sm-4">
                            <select name="designer" id="designer" class="custom-select custom-select-sm" required>
                                @if(count($designers) > 0)
                                    @foreach ($designers as $designer)
                                        <option value="{{ $designer->u_id }}" <?php if($custorders->u_id_designer == $designer->u_id) echo 'selected' ?>>{{ $designer->username }}</option>
                                    @endforeach
                                @else
                                    <option value="">No designer registered</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        {{-- current date --}}  
                        <label class="col-sm-2 col-form-label"> 
                            Order Date
                        </label>
                        <div class="col-sm-4">
                            {{Form::date('current_date', \Carbon\Carbon::now(new DateTimeZone('Asia/Kuala_Lumpur')), ['class' => 'form-control', 'disabled' => 'disabled'])}}
                        </div>
                        {{-- quantity --}}
                        <label class="col-sm-2 col-form-label">
                            Quantity
                            <input type="hidden" name="hiddenquantity" id="hiddenquantity">
                            <input type="hidden" name="hiddennsquantity" id="hiddennsquantity">
                        </label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" value="{{ $custorders->quantity_total }}" id="total_quantity" name="total_quantity" readonly="true">
                        </div>
                    </div>

                    <div class="form-group row">
                        {{-- cloth name --}}
                        <label class="col-sm-2 col-form-label">
                            Cloth Name
                        </label>
                        <div class="col-sm-4">
                            {{Form::text('cloth_name', $custorders->file_name, ['class' => 'form-control', 'placeholder' => 'Write cloth name here', 'required' => 'required'])}}
                        </div>
                        {{-- delivery date --}}
                        <label class="col-sm-2 col-form-label">
                                Delivery Date  
                        </label>

                        <div class="col-sm-4">  
                            <input type="text" name="somedate" value="{{ $custorders->delivery_date }}" id="my_date_picker1" class="form-control"> 
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        {{-- material --}}
                        <label class="col-sm-2 col-form-label">
                            Material
                        </label>
                        <div class="col-sm-4">
                            <select name="material" id="material" class="custom-select custom-select-sm" required>
                                @if(count($materials) > 0)
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->m_id }}" <?php if($custorders->material_id == $material->m_id) echo 'selected' ?>>{{ $material->m_desc }}</option>
                                    @endforeach
                                @else
                                    <option value="">No material recorded</option>
                                @endif
                            </select>
                        </div>
                        
                        {{-- delivery type --}}
                        <label class="col-sm-2 col-form-label">
                            Delivery Type                         
                        </label>
                        <div class="col-sm-4">
                            <select name="dealtype" id="delivery" class="custom-select custom-select-sm" required>    
                                <option value="Delivery" <?php if($custorders->delivery_type == 'Delivery') echo 'selected' ?>>Delivery</option>
                                <option value="Self-pickup" <?php if($custorders->delivery_type == 'Self-pickup') echo 'selected' ?>>Self-pickup</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        {{-- mockup design --}}
                        <label class="col-sm-2 col-form-label">
                                Mockup Design
                        </label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="cover_image">
                                @foreach ($designs as $design)
                                    <label class="custom-file-label" for="customFile">{{ $design->d_url }}</label>  
                                    <input type="hidden" name="namemockupimg" id="namemockupimg" value="{{ $design->d_url }}">
                                    <input type="hidden" name="idmockupimg" value="{{ $design->id }}">
                                @endforeach                             
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        {{-- note --}}
                        <label class="col-sm-2 col-form-label">Note</label>
                        <div class="col-sm-10">
                            <textarea class="form-control rounded-0" rows="5" name="note" placeholder="Write your note here.">{{ $custorders->note }}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <center><img id="blah" src="{{URL::to('/')}}/orders/mockup/{{$design->d_url}}" height="500" width="500" /></center>
                    </div>
                    
                </div>
            </div>

            <table id="settable" style="width:100%; margin: 0px auto; margin-top:20px;">
                <?php $numz = 0; $numo = 1; $totns = 1; $totalspec = count($specorders)?>
                @foreach ($specorders as $specorder)
                    <input type="hidden" name="specid<?php echo $numz ?>" value="{{ $specorder->s_id }}">
                    <tr>
                        <td>
                            <div class="card" id="sets">
                                <div class="card-header bg-dark text-white">Set Details 
                                    <button type="button" style="display: inline-block" onclick="addSet()" class="btn btn-primary" name="btnAddSet" id="btnAddSet">Add Set</button>
                                    <button type="button" style="visibility:<?php if($numo != $totalspec) echo 'hidden;'?>" onclick="deleterow(<?php echo $numo ?>); $(this).closest(&#39;tr&#39;).remove();" class="btn btn-danger" name="btnRemoveRow" id="btnRemoveRow<?php echo $numz ?>">Remove Set</button>
                                    <label class="labelset" id="labelsetnumber1" style="float:right; padding-top:1%;">Set number: <?php echo $numo ?></label>
                                </div>
                                <div class="card-body"> 
                                    {{-- Collar Type --}}
                                    <div class="form-group row">
                                        <label  class="col-sm-2 col-form-label">
                                            <strong>Collar Type</strong>                                                  
                                        </label>
                                    </div>
                                    <div class="form-group row">
                                        @if(count($necks) > 0)
                                            @foreach ($necks as $neck)
                                                <div class="col-sm-4">
                                                    <label>
                                                        <input type="radio" name="necktype<?php echo $numz ?>" id="necktype<?php echo $numz ?>" value="{{ $neck->n_id }}" <?php if($specorder->n_id == $neck->n_id) echo 'checked' ?>/> 
                                                        <img src="{{URL::to('/')}}/uploads/{{$neck->n_url}}" width="70">{{ $neck->n_desc }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        {{-- Body type --}}
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Body Type</strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <select name="type<?php echo $numz ?>" id="type<?php echo $numz ?>" class="custom-select custom-select-sm" required>
                                                @if(count($bodies) > 0)
                                                    @foreach ($bodies as $body)
                                                        <option value="{{ $body->b_id }}" <?php if($specorder->b_id == $body->b_id) echo 'selected' ?>>{{ $body->b_desc }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">No body type recorded</option>
                                                @endif
                                            </select>
                                        </div>
                                        {{-- Sleeve type --}}
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Sleeve Type</strong>                                                        
                                        </label>
                                        <div class="col-sm-4">
                                            <select name="sleeve<?php echo $numz ?>" id="sleeve<?php echo $numz ?>" class="custom-select custom-select-sm" required>
                                                @if(count($sleeves) > 0)
                                                    @foreach ($sleeves as $sleeve)
                                                        <option value="{{ $sleeve->sl_id }}" <?php if($specorder->sl_id == $sleeve->sl_id) echo 'selected' ?>>{{ $sleeve->sl_desc }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">No sleeve type recorded</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {{-- collar color --}}
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Collar Color</strong>
                                        </label>
                                        <div class="col-sm-4">
                                            {{Form::text("collar_color$numz", "$specorder->collar_color", ["class" => "form-control", "placeholder" => "Write color or hex code here"])}}
                                        </div>
                                        {{-- category --}}
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Category</strong>
                                        </label>
                                        <div class="col-sm-2">
                                            <label>
                                                <input type="radio" onclick="javascript:categoryType(<?php echo $numz ?>);" value="Size" name="category<?php echo $numz ?>" id="size<?php echo $numz ?>" <?php if($specorder->category == 'Size') echo 'checked' ?> required/> Size
                                            </label>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>
                                                <input type="radio" onclick="javascript:categoryType(<?php echo $numz ?>);" value="Nameset" name="category<?php echo $numz ?>" id="nameset<?php echo $numz ?>" <?php if($specorder->category == 'Nameset') echo 'checked' ?>/> Nameset
                                            </label>
                                        </div>
                                    </div>

                                    {{-- case size --}}
                                    @if($unitorders->s_id = $specorder->s_id)
                                        <div id="adddivsize<?php echo $numz ?>" class="card" style="display:<?php if($specorder->category == 'Nameset') echo 'none' ?>">
                                            <div class="card-header bg-dark text-white">Size</div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <table id="namesettablesize" class="table table-hover" style="text-align: center">
                                                            <thead class="thead-dark">
                                                            <tr>
                                                                <th id="namesethead">Size</th>
                                                                <th id="namesethead">Quantity</th> 
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">XXS</td>
                                                                <?php $unitsizexxs = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'XXS')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsizexxs = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'XXS')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsizexxs ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantityxxs<?php echo $numz ?>" name="quantitysinglexxs<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitidxxs<?php echo $numz ?>" value="{{$unitidsizexxs}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">XS</td>
                                                                <?php $unitsizexs = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'XS')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsizexs = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'XS')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsizexs ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantityxs<?php echo $numz ?>" name="quantitysinglexs<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitidxs<?php echo $numz ?>" value="{{$unitidsizexs}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">S</td>
                                                                <?php $unitsizes = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'S')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsizes = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'S')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsizes ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantitys<?php echo $numz ?>" name="quantitysingles<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitids<?php echo $numz ?>" value="{{$unitidsizes}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">M</td>
                                                                <?php $unitsizem = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'M')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsizem = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'M')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsizem ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantitym<?php echo $numz ?>" name="quantitysinglem<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitidm<?php echo $numz ?>" value="{{$unitidsizem}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">L</td>
                                                                <?php $unitsizel = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'l')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsizel = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'l')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsizel ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantityl<?php echo $numz ?>" name="quantitysinglel<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitidl<?php echo $numz ?>" value="{{$unitidsizel}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">XL</td>
                                                                <?php $unitsizexl = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'XL')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsizexl = \App\Unit::where('s_id', $specorder->s_id)->where('size', 'XL')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsizexl ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantityxl<?php echo $numz ?>" name="quantitysinglexl<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitidxl<?php echo $numz ?>" value="{{$unitidsizexl}}">
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                    <div class="col-sm-6">

                                                        <table id="namesettablesize" class="table table-hover" style="text-align: center">
                                                            <thead class="thead-dark">
                                                            <tr>
                                                                <th id="namesethead">Size</th>
                                                                <th id="namesethead">Quantity</th> 
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">2XL</td>
                                                                <?php $unitsize2xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '2XL')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsize2xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '2XL')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsize2xl ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantity2xl<?php echo $numz ?>" name="quantitysingle2xl<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitid2xl<?php echo $numz ?>" value="{{$unitidsize2xl}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">3XL</td>
                                                                <?php $unitsize3xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '3XL')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsize3xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '3XL')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsize3xl ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantity3xl<?php echo $numz ?>" name="quantitysingle3xl<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitid3xl<?php echo $numz ?>" value="{{$unitidsize3xl}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">4XL</td>
                                                                <?php $unitsize4xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '4XL')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsize4xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '4XL')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsize4xl ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantity4xl<?php echo $numz ?>" name="quantitysingle4xl<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitid4xl<?php echo $numz ?>" value="{{$unitidsize4xl}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">5XL</td>
                                                                <?php $unitsize5xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '5XL')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsize5xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '5XL')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsize5xl ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantity5xl<?php echo $numz ?>" name="quantitysingle5xl<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitid5xl<?php echo $numz ?>" value="{{$unitidsize5xl}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">6XL</td>
                                                                <?php $unitsize6xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '6XL')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsize6xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '6XL')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsize6xl ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantity6xl<?php echo $numz ?>" name="quantitysingle6xl<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitid6xl<?php echo $numz ?>" value="{{$unitidsize6xl}}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td id="namesetdata">7XL</td>
                                                                <?php $unitsize7xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '7XL')->pluck('un_quantity')->first() ?>
                                                                <?php $unitidsize7xl = \App\Unit::where('s_id', $specorder->s_id)->where('size', '7XL')->pluck('un_id')->first() ?>
                                                                <td id="namesetdata">
                                                                    <input oninput="findTotalSize(<?php echo $numz ?>)" type="number" value="<?php if($specorder->category == 'Size') echo $unitsize7xl ?>" min="1" class="form-control totalsize<?php echo $numz ?>" id="quantity7xl<?php echo $numz ?>" name="quantitysingle7xl<?php echo $numz ?>">
                                                                    <input type="hidden" name="unitid7xl<?php echo $numz ?>" value="{{$unitidsize7xl}}">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    {{-- case nameset --}}
                                        <div id="adddivnameset<?php echo $numz ?>" class="card" style="display:<?php if($specorder->category == 'Size') echo 'none;' ?>">
                                            <div class="card-header bg-dark text-white">Nameset</div>
                                            <div class="card-body">
                                                <table id="namesettable<?php echo $numz ?>" class="table table-hover" style="text-align: center; border: 0.5px solid #aaa; border-collapse: collapse; padding: 10px;">
                                                    <tr>
                                                        <th id="namesethead">
                                                            Name/Number
                                                            <button type="button" style="float: right; display:<?php if($numo == 1) echo 'none;'?>;" id="btnRemovensRow<?php echo $numz ?>" onclick="removeRow(<?php echo $numz ?>)">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                            <button type="button" style="float: right; display:inline-block;" id="btnAddRow" onclick="addRow(<?php echo $numz ?>)">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </th> 
                                                        <th id="namesethead">Size</th>
                                                    </tr>
                                                    <?php $custunits = \App\Unit::where('s_id', $specorder->s_id)->get() ?>
                                                    <?php $ns = 0 ?>
                                                    @if($specorder->category == 'Nameset')
                                                        @foreach ($custunits as $custunit)
                                                            <input type="hidden" id="unitidns<?php echo $numz ?>-<?php echo $ns ?>" name="unitidns<?php echo $numz ?>-<?php echo $ns ?>" value="{{$custunit->un_id}}">
                                                            <tr>
                                                                <td id="namesetdata">
                                                                    <input type="text" placeholder="Your Name / Number" value="{{$custunit->name}}" class="form-control" id="name<?php echo $numz ?>-<?php echo $ns ?>" name="name<?php echo $numz ?>-<?php echo $ns ?>">
                                                                </td>
                                                                <td id="namesetdata">
                                                                    <select name="size<?php echo $numz ?>-<?php echo $ns ?>" id="size<?php echo $numz ?>-<?php echo $ns ?>" class="form-control">
                                                                        <option value="" disabled>Select Size</option>
                                                                        <option value="XXS" <?php if($custunit->size == 'XXS') echo 'selected' ?>>XXS</option>
                                                                        <option value="XS" <?php if($custunit->size == 'XS') echo 'selected' ?>>XS</option>
                                                                        <option value="S" <?php if($custunit->size == 'S') echo 'selected' ?>>S</option>
                                                                        <option value="M" <?php if($custunit->size == 'M') echo 'selected' ?>>M</option>
                                                                        <option value="L" <?php if($custunit->size == 'L') echo 'selected' ?>>L</option>
                                                                        <option value="XL" <?php if($custunit->size == 'XL') echo 'selected' ?>>XL</option>
                                                                        <option value="2XL" <?php if($custunit->size == '2XL') echo 'selected' ?>>2XL</option>
                                                                        <option value="3XL" <?php if($custunit->size == '3XL') echo 'selected' ?>>3XL</option>
                                                                        <option value="4XL" <?php if($custunit->size == '4XL') echo 'selected' ?>>4XL</option>
                                                                        <option value="5XL" <?php if($custunit->size == '5XL') echo 'selected' ?>>5XL</option>
                                                                        <option value="6XL" <?php if($custunit->size == '6XL') echo 'selected' ?>>6XL</option>
                                                                        <option value="7XL" <?php if($custunit->size == '7XL') echo 'selected' ?>>7XL</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <?php $ns++; $totns++; ?>
                                                        @endforeach
                                                        <input type="hidden" id="namesetnum<?php echo $numz ?>" name="namesetnum<?php echo $numz ?>" value="<?php echo $ns ?>">
                                                    @else
                                                        <tr>
                                                            <input type="hidden" id="unitidns<?php echo $numz ?>-0" name="unitidns<?php echo $numz ?>-0" value="newns">
                                                            <td id="namesetdata">
                                                                <input type="text" placeholder="Your Name / Number" class="form-control" id="name<?php echo $numz ?>-<?php echo $ns ?>" name="name<?php echo $numz ?>-<?php echo $ns ?>">
                                                            </td>
                                                            <td id="namesetdata">
                                                                <select name="size<?php echo $numz ?>-0" id="size<?php echo $numz ?>-0" class="form-control">
                                                                    <option value="" selected disabled>Select Size</option>
                                                                    <option value="XXS">XXS</option>
                                                                    <option value="XS">XS</option>
                                                                    <option value="S">S</option>
                                                                    <option value="M">M</option>
                                                                    <option value="L">L</option>
                                                                    <option value="XL">XL</option>
                                                                    <option value="2XL">2XL</option>
                                                                    <option value="3XL">3XL</option>
                                                                    <option value="4XL">4XL</option>
                                                                    <option value="5XL">5XL</option>
                                                                    <option value="6XL">6XL</option>
                                                                    <option value="7XL">7XL</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <input type="hidden" id="namesetnum<?php echo $numz ?>" name="namesetnum<?php echo $numz ?>" value="1">
                                                    @endif
                                                </table>  
                                            </div>
                                        </div>
                                    <button type="button" style="display: inline-block" onclick="addSet()" class="btn btn-primary" name="btnAddSet" id="btnAddSet">Add Set</button>
                                        
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <?php $numz++; $numo++; ?>
                @endforeach 
            </table>

            <input type="hidden" id="totset" name="totset" value="<?php echo $numz ?>">
            <input type="hidden" id="setamount" name="setamount" value="<?php echo $numz ?>">
            <input type="hidden" id="totalcasenameset" name="totalcasenameset">
            <input type="hidden" id="totalcasesize" name="totalcasesize">
            <br>
        
        
            {{-- Submit button --}}
            <div style="text-align:center;">
                <input type="Submit" class="btn btn-primary" onclick="validate()">
            </div>
            <br>

            {!! Form::close() !!} 

            @else
            <p>Price is not set yet. Please contact admin</p> 
            @endif

        </div>
    </div>
</div>


<script>

    var deliverysetting = {!! json_encode($deliverysettings, JSON_HEX_TAG) !!};

    if(deliverysetting != ""){
        var date = new Date();
        date.setDate(date.getDate() + deliverysetting.min_day);
    }else{
        var date = new Date();
    }
    
    var dDates = new Array();
    var blockdate = {!! json_encode($blockdates, JSON_HEX_TAG) !!};
    for(var i=0; i < blockdate.length; i++){
        dDates.push(blockdate[i].date);
    } 

    var dDays = new Array();
    var blockday = {!! json_encode($blockdays, JSON_HEX_TAG) !!};
    for(var i=0; i < blockday.length; i++){
        dDays.push(blockday[i].day);
    } 
    

    $(document).ready(function() { 
        $(function() { 
            $("#my_date_picker1").datepicker({ 
                minDate: date,
                dateFormat: 'yy-mm-dd', 
                beforeShowDay: my_check
            });
        });
        function my_check(in_date) { 
            var day = in_date.getDay();
            if(dDays.length != 0){
                if (dDays.indexOf(day.toString()) > -1) { 
                    return [false, "notav", 'Not Available']; 
                } else { 
                    return my_check2(in_date); 
                } 
            }else{
                return my_check2(in_date); 
            }
        }
        
    });

    function my_check2(in_date) { 
        var m = in_date.getMonth()+1;
        var d = in_date.getDate();
        in_date = in_date.getFullYear() + '-' + m.toString().padStart(2, '0') + '-' + d.toString().padStart(2, '0'); 
        if (dDates.indexOf(in_date) >= 0) { 
            return [false, "notav", 'Not Available']; 
        } else { 
            return [true, "av", "available"]; 
        } 
        
    } 

</script>

<script>

    $(document).ready(function(){
        var nm = document.getElementById('namemockupimg').value;
        console.log(nm);
    });

    //put file name beside browse button
    document.querySelector('.custom-file-input').addEventListener('change',function(e){
        var fileName = document.getElementById("customFile").files[0].name;
        document.getElementById('namemockupimg').value = fileName;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
        var nm = document.getElementById('namemockupimg').value;
        console.log(nm);
    });

    //display upload file
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
            document.getElementById("blah").height = "500";
            document.getElementById("blah").width = "500";
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    //initiate display upload file function
    $("#customFile").change(function() {
    readURL(this);
    });

</script>

@endsection


<script type="text/javascript">

    // validate form
    function validate() {

        var setamount = parseInt(document.getElementById('setamount').value);
        for(var i=0;i<setamount;i++){

            var category;
            if(document.getElementById("size"+i.toString()).checked){
                category = "size";
            }else if(document.getElementById("nameset"+i.toString()).checked){
                category = "nameset";
            }
            
            document.getElementById("necktype"+i.toString()).required = true;
            if(category == "size"){

                var xxs = document.getElementById("quantityxxs"+i.toString()).value;
                var xs = document.getElementById("quantityxs"+i.toString()).value;
                var s = document.getElementById("quantitys"+i.toString()).value;
                var m = document.getElementById("quantitym"+i.toString()).value;
                var l = document.getElementById("quantityl"+i.toString()).value;
                var xl = document.getElementById("quantityxl"+i.toString()).value;
                var xl2 = document.getElementById("quantity2xl"+i.toString()).value;
                var xl3 = document.getElementById("quantity3xl"+i.toString()).value;
                var xl4 = document.getElementById("quantity4xl"+i.toString()).value;
                var xl5 = document.getElementById("quantity5xl"+i.toString()).value;
                var xl6 = document.getElementById("quantity6xl"+i.toString()).value;
                var xl7 = document.getElementById("quantity7xl"+i.toString()).value;
                
                if(xxs == "" && xs == "" && s == "" && m == "" && l == "" && xl == "" && xl2 == "" && xl3 == "" && xl4 == "" && xl5 == "" && xl6 == "" && xl7 == ""){
                    document.getElementById("quantityxxs"+i.toString()).required = true;

                    var namesetamount = parseInt(document.getElementById('namesetnum'+i.toString()).value);
                    for(var j=0;j<namesetamount;j++){   
                        document.getElementById("name"+i.toString()+"-"+j.toString()).required = false;
                        document.getElementById("size"+i.toString()+"-"+j.toString()).required = false;
                    }

                }else{
                    document.getElementById("quantityxxs"+i.toString()).required = false;
                    var namesetamount = parseInt(document.getElementById('namesetnum'+i.toString()).value);
                    for(var j=0;j<namesetamount;j++){   
                        document.getElementById("name"+i.toString()+"-"+j.toString()).required = false;
                        document.getElementById("size"+i.toString()+"-"+j.toString()).required = false;
                    }
                }

            }else{

                var namesetamount = parseInt(document.getElementById('namesetnum'+i.toString()).value);
                for(var j=0;j<namesetamount;j++){   
                    document.getElementById("name"+i.toString()+"-"+j.toString()).required = true;
                    document.getElementById("size"+i.toString()+"-"+j.toString()).required = true;
                }

                document.getElementById("quantityxxs"+i.toString()).required = false;
            }
        }
        
    }

    //document.getElementById('totset').value = {!! json_encode($numz, JSON_HEX_TAG) !!};
    // function to display or hide case nameset and size when user chose category       
    function categoryType(catnum) {


        
        console.log(document.getElementById('totset').value);
        if(document.getElementById('totset').value != ""){
            var totalsetnum = document.getElementById('totset').value-1;
            if (document.getElementById('size'+ catnum.toString() +'').checked) {
                findTotalSize(catnum);
                document.getElementById('adddivnameset'+ catnum.toString() +'').style.display = 'none';
                document.getElementById('adddivsize'+ catnum.toString() +'').style.display = 'block';
            } else if (document.getElementById('nameset'+ catnum.toString() +'').checked) {
                // calctotarr(catnum.toString());
                findTotalQuantity();
                document.getElementById('adddivnameset'+ catnum.toString() +'').style.display = 'block';
                document.getElementById('adddivsize'+ catnum.toString() +'').style.display = 'none';
            }

        }else{
            if (document.getElementById('size'+ catnum.toString() +'').checked) {
                findTotalSize(catnum);
                document.getElementById('adddivnameset0').style.display = 'none';
                document.getElementById('adddivsize0').style.display = 'block';
            } else if (document.getElementById('nameset'+ catnum.toString() +'').checked) {
                // calctotarr(catnum.toString());
                findTotalQuantity();
                document.getElementById('adddivsize0').style.display = 'none';
                document.getElementById('adddivnameset0').style.display = 'block';
            }
        }
        
    }

    // function to calculate total quantity for case size   
    function findTotalSize(setnum){
        var arr = document.getElementsByClassName('totalsize'+setnum);
        var curtot = parseInt(document.getElementById('total_quantity').value);
        var totalsetnum;
        if(document.getElementById('totset').value == ""){
            totalsetnum = 1;
        }else{
            totalsetnum = document.getElementById('totset').value;
        }
        var tot= 0;
        for(var i=0;i<arr.length;i++){
            if(parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }
        var i;
        var totnsval = 0;
        for(i = 0; i < totalsetnum; i++){
            if(document.getElementById('nameset'+i).checked == true){
                if(i != parseInt(setnum)){
                    totnsval += getcurns(i);
                    // console.log('checkns. totnsval: '+totnsval);
                    // console.log('setnum: '+setnum);
                    // console.log('i: '+i);
                    // console.log('getcurns: '+getcurns(i));
                }
            }else{
                if(i != parseInt(setnum)){
                    totnsval += getcurs(i);
                    // console.log('!checkns. totnsval: '+totnsval);
                    // console.log('setnum: '+setnum);
                    // console.log('getcurs: '+getcurs(i));
                }
            }
        }
        tot += totnsval;
        document.getElementById('total_quantity').value = tot;

    }

    // function to calculate total quantity for case nameset
    function calctotarr(setnum){
        var t = 0;
        var l = arrnsamount.length;
        console.log(l)
        // for(var i=0; i<l; i++){
        //     if (document.getElementById('nameset'+i).checked) {
        //         t += parseInt(arrnsamount[i]);
        //     }
        //     //t += parseInt(arrnsamount[i]);
        // }
        t = l;
        if (document.getElementById('nameset'+setnum).checked) {

            var totalsetnum;
            if(document.getElementById('totset').value == ""){
                totalsetnum = 1;
            }else{
                totalsetnum = document.getElementById('totset').value;
            }
            var i;
            var totnsval = 0;
            for(i = 0; i < totalsetnum; i++){
                if(document.getElementById('nameset'+i).checked == false){
                    if(i != parseInt(setnum)){
                        totnsval += getcurs(i);
                    }
                }
            }
            t += totnsval;
            document.getElementById('total_quantity').value = t;
        }
    } 

    // function to calculate total quantity for current case size
    function getcurs(setnum){
        var arr = document.getElementsByClassName('totalsize'+setnum);
        var curtot = document.getElementById('total_quantity').value;
        var tot= 0;
        for(var i=0;i<arr.length;i++){
            if(parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }
        if(tot == 0){
            return 0;
        }else{
            return tot;
        }
    }

    // function to calculate total quantity for current case nameset
    function getcurns(setnum){
        var l = document.getElementById('namesetnum'+setnum).value;
        return parseInt(l);
    }  

    function findTotalQuantity(){
        var totalsetnum;
        if(document.getElementById('totset').value == ""){
            totalsetnum = 1;
        }else{
            totalsetnum = document.getElementById('totset').value;
        }
        var tot= 0;
        var i;
        var totnsval = 0;
        for(i = 0; i < totalsetnum; i++){
            if(document.getElementById('nameset'+i).checked == true){
                totnsval += getcurns(i);
            }else{
                totnsval += getcurs(i);
            }
        }
        tot += totnsval;
        document.getElementById('total_quantity').value = tot;
    }

    var totnameset = {!! json_encode($numz, JSON_HEX_TAG) !!};  
    var totns = {!! json_encode($totns, JSON_HEX_TAG) !!};  
    var namesetnumamount;
    //var arrnsamount = [1];
    var arrnsamount = new Array();
    for(var i = 0; i < totns; i++){
        arrnsamount.push(1);
    }
    // function to add one row in nameset table   {!! json_encode($totns, JSON_HEX_TAG) !!}  
    function addRow(numRow) {
        //console.log(totnameset);

        document.getElementById('btnRemovensRow'+numRow).style.display = 'inline-block';
        
        // get the value of namesetnum
        var namesetnumamount = parseInt(document.getElementById('namesetnum'+numRow).value);
        var newRow = $('<tr>'+'<input type="hidden" id="unitidns'+ numRow.toString() +'-'+ namesetnumamount.toString() +'" name="unitidns'+ numRow.toString() +'-'+ namesetnumamount.toString() +'" value="newns">'+
        '<td id="namesetdata"><input type="text" placeholder="Your Name / Number" class="form-control" id="name'+ numRow.toString() +'-'+ namesetnumamount.toString() +'" name="name'+ numRow.toString() +'-'+ namesetnumamount.toString() +'"/></td>'+
            '<td id="namesetdata"><select name="size'+ numRow.toString() +'-'+ namesetnumamount.toString() +'" id="size'+ numRow.toString() +'-'+ namesetnumamount.toString() +'" class="form-control">'+
                '<option value="" selected disabled>Select Size</option>'+
                '<option value="XXS">XXS</option>'+
                '<option value="XS">XS</option>'+
                '<option value="S">S</option>'+
                '<option value="M">M</option>'+
                '<option value="L">L</option>'+
                '<option value="XL">XL</option>'+
                '<option value="2XL">2XL</option>'+
                '<option value="3XL">3XL</option>'+
                '<option value="4XL">4XL</option>'+
                '<option value="5XL">5XL</option>'+
                '<option value="6XL">6XL</option>'+
                '<option value="7XL">7XL</option>'+
            '</select></td></tr>');
        $('#namesettable'+ numRow.toString() +' tr:last').after(newRow);
        totnameset += 1;
        namesetnumamount = parseInt(namesetnumamount)+1;
        //console.log(namesetnumamount);
        document.getElementById('namesetnum'+numRow).value = namesetnumamount;
        document.getElementById('totalcasenameset').value = totnameset;

        arrnsamount[numRow] = document.getElementById('namesetnum'+numRow).value;
        numRow += 1;
        findTotalQuantity();
    }

    // function to remove one row in nameset table
    function removeRow(numRow) {

        var namesetnumamount = document.getElementById('namesetnum'+numRow).value;
        if(namesetnumamount != 0){
            $('#namesettable'+ numRow.toString() +' tr:last').remove();
            var arr = document.getElementById('quantitynameset');
            var tot= 0;
            if(arr != null){
                for(var i=0;i<arr.length;i++){
                    if(parseInt(arr[i].value))
                        tot += parseInt(arr[i].value);
                }
            }
            
            totnameset -= 1;
            namesetnumamount = parseInt(namesetnumamount)-1;
            document.getElementById('namesetnum'+numRow).value = namesetnumamount;
            if(namesetnumamount == 1){
                document.getElementById('btnRemovensRow'+numRow).style.display = 'none';
            }
            arrnsamount[numRow] = document.getElementById('namesetnum'+numRow).value;
            // calctotarr(numRow);
            findTotalQuantity();
            document.getElementById('totalcasenameset').value = totnameset;

        }
        
    }

    // function to add a new set row for spec table     {!! json_encode($numz, JSON_HEX_TAG) !!}
    var num = {!! json_encode($numz, JSON_HEX_TAG) !!};
    var numnameset = {!! json_encode($numz, JSON_HEX_TAG) !!};
    var numbercat = {!! json_encode($numz, JSON_HEX_TAG) !!};
    var setnumber;
    function addSet() {
        
        setnumber = num;
        setnumber += 1;
        arrnsamount.push(1);
        var newRow = $('<tr>'+
                        '<input type="hidden" name="specid'+ num.toString() +'" value="newset">'+
                            '<td>'+
                                '<div class="card">'+
                                    '<div class="card-header bg-dark text-white">Set Details '+
                                        '<button type="button" style="display: inline-block" onclick="addSet()" class="btn btn-primary" name="btnAddSet" id="btnAddSet">Add Set</button> &nbsp;'+
                                        '<button type="button" style="display: inline-block;" onclick="deleterow('+ num.toString() +'); $(this).closest(&#39;tr&#39;).remove();" class="btn btn-danger" name="btnRemoveRow" id="btnRemoveRow'+ num.toString() +'">Remove Set</button>'+
                                        '<label class="labelset" id="labelsetnumber'+ setnumber.toString() +'" style="float:right; padding-top:1%;">Set number: '+ setnumber.toString() +'</label>'+
                                    '</div>'+
                                    '<div class="card-body">'+
                                        '<div class="form-group row">'+
                                            '<label  class="col-sm-2 col-form-label">'+
                                                '<strong>Collar Type</strong>'+
                                            '</label>'+
                                        '</div>'+
                                        '<div class="form-group row">'+
                                            '@if(count($necks) > 0)'+
                                                '@foreach ($necks as $neck)'+
                                                    '<div class="col-sm-4"><label>'+
                                                        '<input type="radio" name="necktype'+ num.toString() +'" id="necktype'+ num.toString() +'" value="{{ $neck->n_id }}">'+
                                                        '<img src="{{URL::to('/')}}/uploads/{{$neck->n_url}}" width="70">{{ $neck->n_desc }}'+
                                                    '</label></div>'+
                                                '@endforeach'+
                                            '@endif'+
                                        '</div>'+
                                        '<div class="form-group row">'+
                                            '<label class="col-sm-2 col-form-label">'+
                                                '<strong>Body Type</strong>'+
                                            '</label>'+
                                            '<div class="col-sm-4">'+
                                                '<select name="type'+ num.toString() +'" id="type'+ num.toString() +'" class="custom-select custom-select-sm" required>'+
                                                    '@if(count($bodies) > 0)'+
                                                        '<option value="" selected disabled>--Please select body type--</option>'+
                                                        '@foreach ($bodies as $body)'+
                                                            '<option value="{{ $body->b_id }}">{{ $body->b_desc }}</option>'+
                                                        '@endforeach'+
                                                    '@else'+
                                                        '<option value="">No body type recorded</option>'+
                                                    '@endif'+
                                                '</select>'+
                                            '</div>'+
                                            '<label class="col-sm-2 col-form-label">'+
                                                '<strong>Sleeve Type</strong>'+
                                            '</label>'+
                                            '<div class="col-sm-4">'+
                                                '<select name="sleeve'+ num.toString() +'" id="sleeve'+ num.toString() +'" class="custom-select custom-select-sm" required>'+
                                                    '@if(count($sleeves) > 0)'+
                                                        '<option value="" selected disabled>--Please select sleeve type--</option>'+
                                                        '@foreach ($sleeves as $sleeve)'+
                                                            '<option value="{{ $sleeve->sl_id }}">{{ $sleeve->sl_desc }}</option>'+
                                                        '@endforeach'+
                                                    '@else'+
                                                        '<option value="">No sleeve type recorded</option>'+
                                                    '@endif'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group row">'+
                                            '<label class="col-sm-2 col-form-label">'+
                                                '<strong>Collar Color</strong>'+
                                            '</label>'+
                                            '<div class="col-sm-4">'+
                                                '<input type="text" placeholder="Write color or hex code here" class="form-control" id="collar_color'+ num.toString() +'" name="collar_color'+ num.toString() +'">'+
                                            '</div>'+
                                            '<label class="col-sm-2 col-form-label">'+
                                                '<strong>Category</strong>'+
                                            '</label>'+
                                            '<div class="col-sm-2">'+
                                                '<label><input type="radio" onclick="javascript:categoryType('+ num.toString() +');" value="Size" name="category'+ num.toString() +'" id="size'+ num.toString() +'" required/> Size'+
                                                '</label>'+
                                            '</div>'+
                                            '<div class="col-sm-2">'+
                                                '<label><input type="radio" onclick="javascript:categoryType('+ num.toString() +');" value="Nameset" name="category'+ num.toString() +'" id="nameset'+ num.toString() +'"/> Nameset'+
                                                '</label>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div id="adddivsize'+ num.toString() +'" class="card" style="display:none">'+
                                            '<div class="card-header bg-dark text-white">Size</div>'+
                                            '<div class="card-body">'+
                                                '<div class="row">'+
                                                    '<div class="col-sm-6">'+
                                                        '<input type="hidden" id="totset" name="totset" value="">'+
                                                        '<table id="namesettablesize" class="table table-hover" style="text-align: center">'+
                                                            '<thead class="thead-dark">'+
                                                            '<tr>'+
                                                                '<th id="namesethead">Size</th>'+
                                                                '<th id="namesethead">Quantity</th>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">XXS</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantityxxs'+ num.toString() +'" name="quantitysinglexxs'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">XS</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantityxs'+ num.toString() +'" name="quantitysinglexs'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">S</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantitys'+ num.toString() +'" name="quantitysingles'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">M</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantitym'+ num.toString() +'" name="quantitysinglem'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">L</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantityl'+ num.toString() +'" name="quantitysinglel'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">XL</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantityxl'+ num.toString() +'" name="quantitysinglexl'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                        '</table>'+
                                                    '</div>'+
                                                    '<div class="col-sm-6">'+
                                                        '<table id="namesettablesize" class="table table-hover" style="text-align: center">'+
                                                            '<thead class="thead-dark">'+
                                                            '<tr>'+
                                                                '<th id="namesethead">Size</th>'+
                                                                '<th id="namesethead">Quantity</th>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">2XL</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantity2xl'+ num.toString() +'" name="quantitysingle2xl'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">3XL</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantity3xl'+ num.toString() +'" name="quantitysingle3xl'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">4XL</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantity4xl'+ num.toString() +'" name="quantitysingle4xl'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">5XL</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantity5xl'+ num.toString() +'" name="quantitysingle5xl'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">6XL</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantity6xl'+ num.toString() +'" name="quantitysingle6xl'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                            '<tr>'+
                                                                '<td id="namesetdata">7XL</td>'+
                                                                '<td id="namesetdata"><input oninput="findTotalSize('+ num +')" type="number" min="1" class="form-control totalsize'+ num.toString() +'" id="quantity7xl'+ num.toString() +'" name="quantitysingle7xl'+ num.toString() +'"></td>'+
                                                            '</tr>'+
                                                        '</table>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div id="adddivnameset'+ num.toString() +'" class="card" style="display:none">'+
                                            '<div class="card-header bg-dark text-white">Nameset</div>'+
                                            '<div class="card-body">'+
                                                '<input type="hidden" id="namesetnum'+ num.toString() +'" name="namesetnum'+ num.toString() +'" value="1">'+
                                                '<table id="namesettable'+ num.toString() +'" class="table table-hover" style="text-align: center; border: 0.5px solid #aaa; border-collapse: collapse; padding: 10px;">'+
                                                    '<tr>'+
                                                        '<th id="namesethead">'+
                                                            'Name/Number &nbsp;'+
                                                            '<button type="button" style="float: right; display:none;" id="btnRemovensRow'+ num.toString() +'" onclick="removeRow('+ num.toString() +')">'+
                                                                '<i class="fa fa-minus"></i>'+
                                                            '</button>'+
                                                            '<button type="button" style="float: right; display:inline-block;" id="btnAddRow" onclick="addRow('+ num.toString() +')">'+
                                                                '<i class="fa fa-plus"></i>'+
                                                            '</button> &nbsp;'+
                                                        '</th>'+
                                                        '<th id="namesethead">Size</th>'+
                                                    '</tr>'+
                                                    '<tr>'+
                                                        '<td id="namesetdata">'+
                                                            '<input type="text" placeholder="Your Name / Number" class="form-control" id="name'+ num.toString() +'-0" name="name'+ num.toString() +'-0">'+
                                                        '</td>'+
                                                        '<td id="namesetdata">'+
                                                            '<select name="size'+ num.toString() +'-0" id="size'+ num.toString() +'-0" class="form-control">'+
                                                                '<option value="" selected disabled>Select Size</option>'+
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
                                                            '</select>'+
                                                        '</td>'+
                                                    '</tr>'+
                                                '</table>'+
                                            '</div>'+
                                        '</div>'+
                                        '<button type="button" style="display: inline-block" onclick="addSet()" class="btn btn-primary" name="btnAddSet" id="btnAddSet">Add Set</button>'+
                                    '</div>'+
                                '</div>'+
                            '</td>'+
                        '</tr><tr></tr>');
        $('#settable tr:last').after(newRow);
        
        numbercat += 1;
        numnameset += 1;

        var totalsetnum = document.getElementById('totset').value -1;
        for(i = 1; i <= (num-1); i++){
            document.getElementById('btnRemoveRow'+ i.toString()).style.visibility = 'hidden';
        }
        if(document.getElementById('totset').value != ""){

            var totalsetnum = document.getElementById('totset').value -1;
            if (document.getElementById('size'+num).checked) {
                findTotalSize(num);
                var i;
                for(i = 1; i <= totalsetnum; i++){
                    document.getElementById('adddivnameset'+ i.toString() +'').style.display = 'none';
                    document.getElementById('adddivsize'+ i.toString() +'').style.display = 'block';
                }
                
                document.getElementById('divnameset').style.display = 'none';
                document.getElementById('divsize').style.display = 'block';
            } else if (document.getElementById('nameset'+num.toString()).checked) {
                var i;
                for(i = 1; i <= totalsetnum; i++){
                    document.getElementById('adddivnameset'+ i.toString() +'').style.display = 'block';
                    document.getElementById('adddivsize'+ i.toString() +'').style.display = 'none';
                }
                document.getElementById('divsize').style.display = 'none';
                document.getElementById('divnameset').style.display = 'block';
            }

        }else{
            if (document.getElementById('size'+num).checked) {
                findTotalSize(num);
                document.getElementById('divnameset').style.display = 'none';
                document.getElementById('divsize').style.display = 'block';
            } else if (document.getElementById('nameset'+num.toString()).checked) {
                document.getElementById('divsize').style.display = 'none';
                document.getElementById('divnameset').style.display = 'block';
            }
        }
        num += 1;
        console.log(num);
        document.getElementById('setamount').value = num;
        document.getElementById('totset').value = num;
    }

    // function to remove one set row for spec table
    function deleterow(deletenum) {

        var totalsetnum = document.getElementById('totset').value -2;
        if(num != 0){
            document.getElementById('btnRemoveRow'+ totalsetnum.toString()).style.visibility = 'visible';
        }else{
            document.getElementById('btnRemoveRow'+ totalsetnum.toString()).style.visibility = 'visible';
        }
        
        if(document.getElementById('setamount').value != "1"){

            var arramount = arrnsamount.pop();
            var table = document.getElementById('settable');
            var rowCount = table.rows.length;
            num -= 1;
            numbercat -= 1;
            document.getElementById('totset').value = num;
            document.getElementById('setamount').value = num;
        }
        if(num == 1){
            document.getElementById('btnRemoveRow'+ totalsetnum.toString()).style.visibility = 'hidden';
        }
        findTotalQuantity();
        //console.log(num);

    }

</script>