@extends('layouts.layout')

@section('content')
<style>
    .namesetDiv,.sizeDiv {
  display: none;
}
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
                <div class="card-header bg-dark text-white">Order Details</div>

                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Order Date</label>
                        <div class="col-sm-4">
                            <input type="date" name="current_date" value= "{{ $today }}" class="form-control" readonly="readonly">
                        </div>
                        <label class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-4">
                            <input type="text" name="total_quantity" value= "" class="form-control" readonly="" aria-describedby="totalQuantity">
<!--                            <small id="totalQuantity" class="form-text text-muted">
                                This field is auto generate
                            </small>-->
                        </div>                       
                     </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Cloth Name</label>
                        <div class="col-sm-4">
                            <input type="text" name="cloth_name" value= "" class="form-control" required="required" placeholder="Write cloth name here">
                        </div>                       
                        <label class="col-sm-2 col-form-label">Delivery Date</label>
                        <div class="col-sm-4">
                            <input type="date" min="" name="delivery_date" class="form-control" required="" aria-describedby="deliveryDate">
<!--                            <small id="deliveryDate" class="form-text text-muted">
                                Minimum 7 days from today
                            </small>-->
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Material</label>                                                
                        <div class="col-sm-4">
                            <select name="material" id="material" class="custom-select custom-select-sm">
                                    @if(count($materials) > 0)
                                        <option selected disabled>--Please select material--</option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material->m_id }}">{{ $material->m_desc }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No material recorded</option>
                                    @endif
                           </select>
                        </div>
                        
                        <label class="col-sm-2 col-form-label">Delivery Type</label>
                        <div class="col-sm-4">
                            <select name="dealtype" id="material" class="custom-select custom-select-sm">                                   
                                <option selected disabled>--Please select delivery type--</option>
                                <option value="Delivery">Delivery</option>
                                <option value="Self-pickup">Self-pickup</option>
                           </select>
                        </div>
                    </div>
                                                          
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mockup Design</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="cover_image">
                                <label class="custom-file-label" for="customFile">Choose file</label>                               
                            </div>
                        </div>                       
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Note</label>
                        <div class="col-sm-10">
                            <textarea class="form-control rounded-0" rows="5" name="note" placeholder="Write your note here."></textarea>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <center><img id="blah" /></center>
                    </div>
                    
                </div>
            </div>
            
            <div class="card" id="sets">
                <div class="card-header bg-dark text-white">Set Details <input type="button" onclick="duplicate()" class="btn btn-primary" name="add_set" id="addSet" value="Add Set"></div>
                <div class="card-body">                                        
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Collar Type</label>                                              
                    </div>
                    
                    <div class="form-group row">
                        @if(count($necks) > 0)
                                @php $no=0; @endphp
                                @foreach ($necks as $neck)
                                  <div class="col-sm-4">
                                    <div class="custom-control custom-radio custom-control-inline necktype">
                                        <input type="radio" id="neckRadioInline{{$no}}" name="neck" value="{{$neck->n_id}}" class="custom-control-input">
                                        <label class="custom-control-label" for="neckRadioInline{{$no}}"><img src="{{URL::to('/')}}/uploads/{{$neck->n_url}}" width="70" height="70">{{ $neck->n_desc }}</label>
                                    </div>
                                  </div>
                                @php $no++; @endphp
                                @endforeach                        
                        @else
                        No neck type
                        @endif
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Body Type</label>                       
                        <div class="col-sm-4">
                            <select name="body" id="body" class="custom-select custom-select-sm">
                                    @if(count($bodies) > 0)
                                        <option selected disabled>--Please select body type--</option>
                                        @foreach ($bodies as $body)
                                            <option value="{{ $body->b_id }}">{{ $body->b_desc }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No body type recorded</option>
                                    @endif
                           </select>
                        </div>
                        
                        <label class="col-sm-2 col-form-label">Sleeve Type</label>                       
                        <div class="col-sm-4">
                            <select name="sleeve" id="sleeve" class="custom-select custom-select-sm">
                                    @if(count($sleeves) > 0)
                                        <option selected disabled>--Please select sleeve type--</option>
                                        @foreach ($sleeves as $sleeve)
                                            <option value="{{ $sleeve->sl_id }}">{{ $sleeve->sl_desc }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No sleeve type recorded</option>
                                    @endif
                           </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Collar Color</label>                       
                        <div class="col-sm-4">
                            <input type="text" name="collar_color" placeholder="Write color or hex code here" class="form-control" required="">
                        </div>

                        <label class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-2">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="category1" name="category" value="Nameset" class="custom-control-input" data-waschecked="false">
                                <label class="custom-control-label" for="category1">Nameset</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="category2" name="category" value="Size" class="custom-control-input" data-waschecked="false">
                                <label class="custom-control-label" for="category2">Size</label>
                            </div>
                        </div>                                         
                    </div>
                    
                    <div class="card namesetDiv" id="namesetDiv">
                        <div class="card-header bg-dark text-white">Nameset</div>
                        <div class="card-body">

                                <center>
                                <table class="table table-hover">
                                   <tr>
                                       <th>Name/Number &nbsp;<input type="button"  class="btn btn-primary" name="add_set" id="addSet" value="Add Name"></th>
                                      <th>Size</th>
                                   </tr>
                                   <tr>
                                        <td id="namesetdata"><input type="text" placeholder="Your Name / Number" class="form-control" id="name0" name="name0-0"></td>
                                        <td id="namesetdata">
                                            <select name="size0-0" id="size0" class="form-control">
                                                <option selected disabled="">Select Size</option>
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
                                </table>
                                </center>
                         
                        </div>
                    </div>
                    
                    <div class="card sizeDiv" id="sizeDiv">
                        <div class="card-header bg-dark text-white">Size</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                                    <table class="table table-hover">
                                                        <thead class="thead-dark">
                                                        <tr class="">
                                                            <th id="namesethead">Size</th>
                                                            <th id="namesethead">Quantity</th> 
                                                        </tr>
                                                        </thead>
                                                        <tr>
                                                            <td id="namesetdata">XXS</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantityxxs0" name="quantitysinglexxs0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">XS</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantityxs0" name="quantitysinglexs0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">S</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantitys0" name="quantitysingles0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">M</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantitym0" name="quantitysinglem0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">L</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantityl0" name="quantitysinglel0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">XL</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantityxl0" name="quantitysinglexl0"></td>
                                                        </tr>
                                                    </table>
                                </div>
                                <div class="col-sm-6">
                                                    <table class="table table-hover">
                                                        <thead class="thead-dark">
                                                        <tr>
                                                            <th id="namesethead">Size</th>
                                                            <th id="namesethead">Quantity</th> 
                                                        </tr>
                                                        </thead>
                                                        <tr>
                                                            <td id="namesetdata">2XL</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantity2xl0" name="quantitysingle2xl0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">3XL</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantity3xl0" name="quantitysingle3xl0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">4XL</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantity4xl0" name="quantitysingle4xl0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">5XL</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantity5xl0" name="quantitysingle5xl0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">6XL</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantity6xl0" name="quantitysingle6xl0"></td>
                                                        </tr>
                                                        <tr>
                                                            <td id="namesetdata">7XL</td>
                                                            <td id="namesetdata"><input oninput="findTotal()" type="number" min="1" class="form-control totalnameset" id="quantity7xl0" name="quantitysingle7xl0"></td>
                                                        </tr>
                                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="button" onclick="duplicate()" class="btn btn-primary" name="add_set" id="addSet" value="Add Set">
                </div>
            </div>
            <center><button class="btn btn-primary">Submit Order</button></center><br><br>
        </div>
    </div>
</div>

<script type="text/javascript">
        //put file name beside browse button
    document.querySelector('.custom-file-input').addEventListener('change',function(e){
    var fileName = document.getElementById("customFile").files[0].name;
        console.log("custom-file-input");
    
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = fileName
    })

    //display upload file
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        console.log("readURL");
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
        console.log("customFile");
    readURL(this);
    });

    //show nameset category
    $(document).on("click", "#category1", function () {
        $(".card #sizeDiv").hide();
        $(".card #namesetDiv").show();
    });

    //show size category
    $(document).on("click", "#category2", function () {
        $(".card #sizeDiv").show();
        $(".card #namesetDiv").hide();
    });

    var i = 0;
    var original = document.getElementById('sets');

    function duplicate() {
        var clone = original.cloneNode(true); // "deep" clone
        clone.id = "sets" + ++i;
        // or clone.id = ""; if the divs don't need an ID
        original.parentNode.appendChild(clone);
    }
</script>
@endsection
