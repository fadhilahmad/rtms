@extends('layouts.layout')

@section('content')
<!-- <div class="container-scroll">
    <div class ="card">
        <div class="card-header">Order Form</div>
            <div class="scroll_page">
                <div class="row">
                    <div class="col-11 scroll_page--box">
                    <div class="col-lg-12">
                      
                            <div class="card-header d-flex align-items-center">
                            <h4>All form elements</h4>
                            </div>
                            <div class="card-body">
                            <form class="form-horizontal">
                        <div class="form-group row">
                        <label class="col-sm-2">Email</label>
                        <div class="col-sm-10">
                            <input id="inputHorizontalSuccess" type="email" placeholder="Email Address"form-control-success"><small class="form-text">Example help text that remains unchanged.</small>
                        </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2">Password</label>
                        <div class="col-sm-10">
                            <input id="inputHorizontalWarning" type="password" placeholder="Pasword"form-control-warning"><small class="form-text">Example help text that remains unchanged.</small>
                        </div>
                        </div>
                        <div class="form-group row">       
                        <div class="col-sm-10 offset-sm-2">
                            <input type="submit" value="Signin" class="btn btn-primary">
                        </div>
                        </div>
                    </form>
                            
                            </div>
                        </div>
                   
               
                    </div>
                       
                        
                    <div class="col-11 scroll_page--box">
                        <p>Lorem ipsum dolor sit amet consectetur.</p>
                    <form class="form-horizontal">
                        <div class="form-group row">
                        <label class="col-sm-2">Email</label>
                        <div class="col-sm-10">
                            <input id="inputHorizontalSuccess" type="email" placeholder="Email Address"form-control-success"><small class="form-text">Example help text that remains unchanged.</small>
                        </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-2">Password</label>
                        <div class="col-sm-10">
                            <input id="inputHorizontalWarning" type="password" placeholder="Pasword"form-control-warning"><small class="form-text">Example help text that remains unchanged.</small>
                        </div>
                        </div>
                        <div class="form-group row">       
                        <div class="col-sm-10 offset-sm-2">
                            <input type="submit" value="Signin" class="btn btn-primary">
                        </div>
                        </div>
                    </form></div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="container-scroll">
    <div class ="card">
        <div class="card-header order-form ">REZEAL TEXTILE ORDER FORM</div>  
            <div class="card-body">   
                <form class="form-horizontal row">
                    <div class="scroll_page">
                        <!-- <div class="row"> -->
                            <!-- first column -->
                            <div class="col-10 scroll_page--box">
                                <!-- date & ref.num field -->
                                <div class="form-group row">
                                    <label class="col-sm-2">Date</label>
                                    <div class="col-sm-3">
                                       : <input id="date" name="date" type="email">
                                    </div>
                                    <label class="col-sm-1">Ref Num</label>
                                    <div class="col-sm-3">
                                       : <input id="refnum" name="refnum"  type="text" >
                                    </div>
                                </div>
                                <!-- customer field -->
                                <div class="form-group row">
                                    <label class="col-sm-2">Customer</label>
                                    <div class="col-sm-7">
                                    : <input id="customer"  name="customer" type="text">
                                    </div>
                                </div>
                                <!-- file name field -->
                                <div class="form-group row">
                                    <label class="col-sm-2">File Name</label>
                                    <div class="col-sm-7">
                                    : <input id="file_name" name="file_name" type="text">
                                    </div>
                                </div>
                                <!-- material checkbox -->
                                <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Material</label> :
                                    <div class="row col-sm-10">
                                        <div class="i-checks col-sm-3">
                                            <input id="checkboxCustom" type="checkbox" value=""  checked=""custom">
                                            <label for="checkboxCustom">Microfiber</label>
                                        </div>
                                        <div class="i-checks col-sm-3">
                                            <input id="checkboxCustom1" type="checkbox" value=""custom">
                                            <label for="checkboxCustom1">Interlock</label>
                                        </div>
                                        <div class="i-checks col-sm-3">
                                            <input id="checkboxCustom2" type="checkbox" value="" checked=""custom">
                                            <label for="checkboxCustom2">BWJ (Cotton)</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- sleeve checkbox -->                                
                                <div class="form-group row">
                                    <label class="col-sm-2">Sleeve</label> :
                                    <div class="row col-sm-8">
                                        <div class="i-checks col-sm-3">
                                            <input id="checkboxCustom3" type="checkbox" value="" checked=""custom">
                                            <label for="checkboxCustom3">Short</label>
                                        </div>
                                        <div class="i-checks col-sm-3">
                                            <input id="checkboxCustom4" type="checkbox" value="" checked=""custom">
                                            <label for="checkboxCustom4">Long</label>
                                        </div>
                                        <div class="i-checks col-sm-3">
                                            <input id="checkboxCustom5" type="checkbox" value="" checked=""custom">
                                            <label for="checkboxCustom5">Sleeveless</label>
                                        </div>
                                        <div class="i-checks col-sm-3">
                                            <input id="checkboxCustom6" type="checkbox" value="" checked=""custom">
                                            <label for="checkboxCustom6">Singlet</label>
                                        </div>
                                      
                                    </div>
                                </div>
                                 <!-- collar no field -->                                
                                 <div class="form-group row">
                                    <label class="col-sm-2">Collar No</label>
                                    <div class="col-sm-5">
                                    : <input id="collor_no" name="collor_no" type="text">
                                    </div>
                                </div>
                                <!-- delivery date field -->                                
                                <div class="form-group row">
                                    <label class="col-sm-2">Delivery Date</label>
                                    <div class="col-sm-5">
                                    : <input id="delivery_date" name="delivery_date" type="text">
                                    </div>
                                </div>
                                <!-- Person in charge field -->                                
                                <div class="form-group row">
                                    <label class="col-sm-2">Person in charge</label>
                                    <div class="col-sm-5">
                                    : <input id="pic" name="pic" type="text">
                                    </div>
                                </div>
                                <!-- collar colour field -->                                
                                <div class="form-group row">
                                    <label class="col-sm-2">Collar Colour</label>
                                    <div class="col-sm-5">
                                    : <input id="col_color" name="col_color" type="text">
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
                                        <textarea rows="4" cols="50">                                
                                        </textarea>
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
                                            <input class="col-4" disabled  value="1" style="background-color:red; color:white"/> <p>PCS</p>
                                        </div>
                                        <div class="text-big-red">
                                            <h1 style="font-size:150px;">MF <br> EYELET</h1>
                                            <!-- <h1 style="font-size:150px;"></h1> -->
                                        </div>
                                    
                           
                                </div>
                            
                                </div>
                                <br>
                                <br>
                                <div class="form-group col-sm-6">
                                    <strong>Adult Short Sleeve ROUNDNECK</strong>
                                    <div class="row">
                                        <table class="table table-bordered"  style="width:50%; margin: 0px auto; margin-top:20px;">
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
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">XS</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">S</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">M</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">L</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">XL</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered" style="width:50%; margin: 0px auto; margin-top:20px;">
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
                                        </table>
                                    </div>
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

