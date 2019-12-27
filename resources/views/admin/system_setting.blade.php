@extends ('layouts.layout')
@section ('content')
<style>
#logo {
  border: 1px solid #ddd;
  border-radius: 4px;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-gear"></i> System Settings</div>
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            @if(count($systemsettings) > 0)

                                <div class="card">
                                    <div class="card-header">Company Details</div>
                                    <div class="card-body">
                                        @foreach ($systemsettings as $systemsetting)
                                            <table class="table table-hover" style="text-align: center; border: 0.5px solid #aaa; border-collapse: collapse; padding: 10px;">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th style="width: 15%">Settings</th>
                                                        <th style="width: 70%">Details</th>
                                                        <th style="width: 15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-top: 2%"><b>Company Name</b></td>
                                                        <td style="padding-top: 2%">{{$systemsetting->company_name}}</td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Company Name" data-table="compname" 
                                                                data-id="{{$systemsetting->ss_id}}" data-desc="{{$systemsetting->company_name}}"><i class="fa fa-edit"></i> Edit
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 2%"><b>System Name</b></td>
                                                        <td style="padding-top: 2%">{{$systemsetting->system_name}}</td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update System Name" data-table="sysname" 
                                                                data-id="{{$systemsetting->ss_id}}" data-desc="{{$systemsetting->system_name}}"><i class="fa fa-edit"></i> Edit
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 2%"><b>Company Address</b></td>
                                                        <td style="padding-top: 2%">
                                                            {{$systemsetting->address_first}}<br>
                                                            {{$systemsetting->address_second}}<br>
                                                            {{$systemsetting->poscode}} {{$systemsetting->city}}, {{$systemsetting->state}}
                                                        </td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Company Address" data-table="compaddress" 
                                                                data-id="{{$systemsetting->ss_id}}" data-desc="{{$systemsetting->address_first}}"><i class="fa fa-edit"></i> Edit
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 2%"><b>Company Logo</b></td>
                                                        <td style="padding-top: 2%"><img class="" src="{{url('img/logo/'.$systemsetting->company_logo)}}" width="80%" id="logo"></td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Company Logo" data-table="complogo" 
                                                                data-id="{{$systemsetting->ss_id}}" data-desc="{{$systemsetting->company_logo}}"><i class="fa fa-edit"></i> Edit
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        @endforeach     
                                    </div>
                                </div>

                                @if(count($bankdetails) > 0)
                                <div class="card">
                                    <div class="card-header">
                                        Bank Details <input type="button" style="float:right;" onclick="appendBank2()" class="btn btn-primary" name="add_bank" id="addBank" value="Add">
                                        <button type="button" style="display:none; float:right;" id="removebank" onclick="removeBank(0);" class="btn btn-danger btnremove">Remove</button>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($bankdetails as $bankdetail)
                                            <table class="table table-hover" style="text-align: center; border: 0.5px solid #aaa; border-collapse: collapse; padding: 10px;">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th style="width: 15%">Settings</th>
                                                        <th style="width: 70%">Details</th>
                                                        <th style="width: 15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-top: 2%"><b>Bank Name</b></td>
                                                        <td style="padding-top: 2%">{{$bankdetail->bank_name}}</td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Bank Name" data-table="bankname" 
                                                                data-id="{{$bankdetail->bd_id}}" data-desc="{{$bankdetail->bank_name}}"><i class="fa fa-edit"></i> Edit
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 2%"><b>Account Name</b></td>
                                                        <td style="padding-top: 2%">{{$bankdetail->account_name}}</td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Account Name" data-table="accname" 
                                                                data-id="{{$bankdetail->bd_id}}" data-desc="{{$bankdetail->account_name}}"><i class="fa fa-edit"></i> Edit
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 2%"><b>Account Number</b></td>
                                                        <td style="padding-top: 2%">{{$bankdetail->account_number}}</td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Account Number" data-table="accnum" 
                                                                data-id="{{$bankdetail->bd_id}}" data-desc="{{$bankdetail->account_number}}"><i class="fa fa-edit"></i> Edit
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <form action="{{route('admin.update_company_profile')}}" method="POST" onsubmit="return confirm('Are you sure to delete this bank details?');" enctype="multipart/form-data">{{ csrf_field() }}
                                                                <input type="hidden" value="{{$bankdetail->bd_id}}" name="deletebank" />
                                                                <button class="btn btn-danger" type="submit" value="X"><i class="fa fa-trash"></i> Delete</button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        @endforeach     
                                    </div>
                                    <form action="{{route('admin.update_company_profile')}}" method="POST" enctype="multipart/form-data">{{ csrf_field() }}
                                        <div id="appbk"></div>
                                        <div style="text-align:center;">
                                            <input type="Submit" class="btn btn-primary" id="sbmtbtnbank" style="display:none;">
                                        </div>
                                    </form>
                                </div>

                                

                                @else
                                    <p>No bank details recorded</p>
                                    <input type="button" onclick="appendBank2()" class="btn btn-primary" name="add_bank" id="addBank" value="Add">
                                    <form action="{{route('admin.update_company_profile')}}" method="POST" enctype="multipart/form-data">{{ csrf_field() }}
                                        <div id="appbk"></div>
                                        <div style="text-align:center;">
                                            <input type="Submit" class="btn btn-primary" id="sbmtbtnbank" style="display:none;">
                                        </div>
                                    </form>
                                @endif

                                @if(count($contactdetails) > 0)
                                <div class="card">
                                    <div class="card-header">
                                        Contact Details  <input type="button" style="float:right;" onclick="appendContact2()" class="btn btn-primary" name="add_contact" id="addContact" value="Add">
                                        <button type="button" style="display:none; float:right;" id="removecontact" onclick="removeContact(0);" class="btn btn-danger btnremove">Remove</button>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($contactdetails as $contactdetail)
                                            <table class="table table-hover" style="text-align: center; border: 0.5px solid #aaa; border-collapse: collapse; padding: 10px;">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th style="width: 15%">Settings</th>
                                                        <th style="width: 70%">Details</th>
                                                        <th style="width: 15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-top: 2%"><b>Telco Name</b></td>
                                                        <td style="padding-top: 2%">{{$contactdetail->telco_name}}</td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Telco Name" data-table="telconame" 
                                                                data-id="{{$contactdetail->cn_id}}" data-desc="{{$contactdetail->telco_name}}"><i class="fa fa-edit"></i> Edit
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top: 2%"><b>Contact Number</b></td>
                                                        <td style="padding-top: 2%">{{$contactdetail->contact_number}}</td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Contact Number" data-table="contactnum" 
                                                                data-id="{{$contactdetail->cn_id}}" data-desc="{{$contactdetail->contact_number}}"><i class="fa fa-edit"></i> Edit
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <form action="{{route('admin.update_company_profile')}}" method="POST" onsubmit="return confirm('Are you sure to delete this contact details?');" enctype="multipart/form-data">{{ csrf_field() }}
                                                                <input type="hidden" value="{{$contactdetail->cn_id}}" name="deletecontact" />
                                                                <button class="btn btn-danger" type="submit" value="X"><i class="fa fa-trash"></i> Delete</button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        @endforeach     
                                    </div>
                                    <form action="{{route('admin.update_company_profile')}}" method="POST" enctype="multipart/form-data">{{ csrf_field() }}
                                        <div id="appct"></div>
                                        <div style="text-align:center;">
                                            <input type="Submit" class="btn btn-primary" id="sbmtbtncontact" style="display:none;">
                                        </div>
                                    </form>
                                </div>
                                @else
                                    <p>No contact details recorded</p>
                                    <input type="button" onclick="appendContact2()" class="btn btn-primary" name="add_bank" id="addBank" value="Add">
                                    <form action="{{route('admin.update_company_profile')}}" method="POST" enctype="multipart/form-data">{{ csrf_field() }}
                                        <div id="appct"></div>
                                        <div style="text-align:center;">
                                            <input type="Submit" class="btn btn-primary" id="sbmtbtncontact" style="display:none;">
                                        </div>
                                    </form>
                                @endif

                            @else
                                <form action="{{route('admin.update_company_profile')}}" method="POST" enctype="multipart/form-data">{{ csrf_field() }}
                                    
                                    <div class="card">
                                        <div class="card-header">Company Details</div>
                                        <div class="card-body">
                                    
                                            {{-- company name --}}  
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                    Company Name
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="companyname" class="form-control" required>
                                                </div>
                                            </div>
                                            {{-- system name --}}  
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                    System Name
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="systemname" class="form-control" required>
                                                </div>
                                            </div>
                                            {{-- company address --}}  
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                    Company Address
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="street1" class="form-control" required>
                                                    <small style="color:gray">Street address</small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="street2" class="form-control" required>
                                                    <small style="color:gray">Street address line 2</small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                </label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="city" class="form-control" required>
                                                    <small style="color:gray">City</small>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="text" name="state" class="form-control" required>
                                                    <small style="color:gray">State</small>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                </label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="poscode" class="form-control" required>
                                                    <small style="color:gray">Postal code</small>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="text" name="country" value="Malaysia" class="form-control" required>
                                                    <small style="color:gray">Country</small>
                                                </div>
                                            </div>
                                            {{-- company logo --}}  
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                    Company Logo
                                                </label>
                                                <div class="col-sm-10">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile" name="companylogo" required>
                                                        <label class="custom-file-label" for="customFile">Choose file</label>                               
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                {{-- display company logo --}}
                                                <center><img id="blah" /></center>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="card" id="bankid0">
                                        <div class="card-header">
                                            Bank Details <input type="button" style="float:right;" onclick="appendBank()" class="btn btn-primary" name="add_bank" id="addBank" value="Add">
                                            <button type="button" style="display:none; float:right;" id="removebank" onclick="removeBank(0);" class="btn btn-danger btnremove">Remove</button>
                                        </div>
                                        <div class="card-body">
                                    
                                            {{-- bank name --}}  
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                    Bank Name
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="bankname[]" class="form-control" required>
                                                </div>
                                            </div>
                                            {{-- account name --}}  
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                    Account Name
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="accountname[]" class="form-control" required>
                                                </div>
                                            </div>
                                            {{-- account number --}}  
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                    Account Number
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="accountnumber[]" class="form-control" required>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div id="appb"></div>

                                    <div class="card" id="contactid0">
                                        <div class="card-header">Contact Details <input type="button" style="float:right;" onclick="appendContact()" class="btn btn-primary" name="add_contact" id="addContact" value="Add"></div>
                                        <button type="button" style="display:none; float:right;" id="removecontact" onclick="removeContact(0);" class="btn btn-danger btnremove">Remove</button>
                                        <div class="card-body">
                                    
                                            {{-- telco name --}}  
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                    Telco Name
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="telconame[]" class="form-control" required>
                                                </div>
                                            </div>
                                            {{-- contact number --}}  
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label"> 
                                                    Contact Number
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="contactnumber[]" class="form-control" required>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div id="appc"></div>
                                    <br>
                                    <br>
                                    {{-- Submit button --}}
                                    <div style="text-align:center;">
                                        <input type="Submit" class="btn btn-primary">
                                    </div>
                                </form>
                            @endif                                                                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="POST" id="updateform" name="updateform" action="{{ route('admin.update_company_profile') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Order Setting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group row" id="description">
                        <label for="description" class="col-sm-4 col-form-label">Details</label>
                        <div class="col-sm-8">
                            <input type="text" min="0" class="form-control" id="description" name="description" required>
                            <input type="hidden" name="id" id="itemId">
                            <input type="hidden" name="type" id="type">
                            <input type="hidden" name="table" id="table">
                        </div>
                    </div> 

                    <div class="form-group row" id="complogo">
                        <label for="complogo" class="col-sm-4 col-form-label">Company Logo</label>
                        <div class="col-sm-8" id="complogo">
                            <input id="neck_image" type="file" class="form-control" name="complogo" required/>
                        </div>
                    </div> 
                    
                    <div class="form-group row" id="compaddress">
                        <label for="compaddress" class="col-sm-4 col-form-label">Company Address</label>
                        <div class="col-sm-8">
                            <input type="text" min="0" class="form-control" id="street1" name="street1" placeholder="Street line 1" required>
                            <small style="color:gray">Street address</small>
                            <input type="text" min="0" class="form-control" id="street2" name="street2" placeholder="Street line 2" required>
                            <small style="color:gray">Street address line 2</small>
                            <input type="text" min="0" class="form-control" id="poscode" name="poscode" placeholder="Postal code" required>
                            <small style="color:gray">Postal code</small>
                            <input type="text" min="0" class="form-control" id="city" name="city" placeholder="City" required>
                            <small style="color:gray">City</small>
                            <input type="text" min="0" class="form-control" id="state" name="state" placeholder="State" required>
                            <small style="color:gray">State</small>
                            <input type="text" min="0" class="form-control" id="country" name="country" placeholder="Country" required>
                            <small style="color:gray">Country</small>
                            <input type="hidden" name="id" id="itemId">
                            <input type="hidden" name="type" id="type">
                            <input type="hidden" name="table" id="table">
                        </div>
                    </div> 
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="validateForm()" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    </div>

<script>

    //put file name beside browse button
    document.querySelector('.custom-file-input').addEventListener('change',function(e){
        var fileName = document.getElementById("customFile").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    });

    //display upload file
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
            //document.getElementById("blah").height = "500";
            document.getElementById("blah").width = '500';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    //initiate display upload file function
    $("#customFile").change(function() {
    readURL(this);
    });

</script>

<script type="text/javascript">

    var typechose = '';
    $(document).on("click", ".edit", function () {
        typechose = 'desc';
        document.getElementById('description').type = 'text';
        var name = $(this).data('tittle');
        var id = $(this).data('id');
        var desc = $(this).data('desc');
        var table = $(this).data('table');
        $(".modal-title").text( name );
        $(".modal-body #description").val( desc );
        $(".modal-body #type").val( "update" );
        $(".modal-body #itemId").val( id );
        $(".modal-body #table").val( table );
        $(".modal-body #description").show();
        $(".modal-body #neckdiv").hide();
        $(".modal-body #complogo").hide();
        $(".modal-body #compaddress").hide();
        
        if(table=="complogo"){
            typechose = 'logo';
            
            var sysset = {!! json_encode($systemsettings, JSON_HEX_TAG) !!};

            //$(".modal-body #neck_image").val( sysset[0].company_logo );   

            $(".modal-body #complogo").show();
            $(".modal-body #description").hide();
            $(".modal-body #compaddress").hide();
        }
        if(table=="compaddress"){
            typechose = 'addr';

            var sysset = {!! json_encode($systemsettings, JSON_HEX_TAG) !!};
            
            $(".modal-body #street1").val( sysset[0].address_first );
            $(".modal-body #street2").val( sysset[0].address_second );
            $(".modal-body #poscode").val( sysset[0].poscode );
            $(".modal-body #city").val( sysset[0].city );
            $(".modal-body #state").val( sysset[0].state );
            $(".modal-body #country").val( sysset[0].country );

            $(".modal-body #compaddress").show();
            $(".modal-body #description").hide();
            $(".modal-body #complogo").hide();
        }
    });
    
    function validateForm() { 

        if(typechose == 'desc'){
            var desc = document.forms["updateform"]["description"].value;
            if(desc == ""){
                alert("Details must be filled out");
                return false;
            }else{
                document.getElementById("updateform").submit();  
            }  
        }
        if(typechose == 'logo'){
            var complogo = document.forms["updateform"]["neck_image"].value;
            if(document.getElementById("neck_image").files.length == 0){
                alert("You must select file for logo");
                return false;
            }else{
                document.getElementById("updateform").submit();  
            }  
        }
        if(typechose == 'addr'){
            var street1 = document.forms["updateform"]["street1"].value;
            var street2 = document.forms["updateform"]["street2"].value;
            var poscode = document.forms["updateform"]["poscode"].value;
            var city = document.forms["updateform"]["city"].value;
            var state = document.forms["updateform"]["state"].value;
            var country = document.forms["updateform"]["country"].value;
            if(street1 == "" || street2 == "" || poscode == "" || city == "" || state == "" || country == ""){
                alert("Addres must be filled out");
                return false;
            }else{
                document.getElementById("updateform").submit();  
            }  
        }
        
    }
    
    function submitForm() {
        var x = document.forms["blockform"]["date"].value;
        var y = document.forms["blockform"]["remark"].value;
        if (x == "") 
        {
            alert("Date must be filled out");
            return false;
        }
        if(y=="")
        {
            alert("Remark must be filled out");
            return false;  
        }
        else{
            document.getElementById("blockform").submit();  
        }
    }

    var b = 1;
    function appendBank(){
        $("#appb").append('<div class="card" id="bankid'+b.toString()+'">'+
                                '<div class="card-header">'+
                                    'Bank Details <input type="button" style="float:right;" onclick="appendBank()" class="btn btn-primary" name="add_bank" id="addBank" value="Add">'+
                                    '<button type="button" style="float:right;" id="removebank" onclick="removeBank('+b.toString()+');" class="btn btn-danger btnremove">Remove</button>'+
                                '</div>'+
                                '<div class="card-body">'+
                                    '<div class="form-group row">'+
                                        '<label class="col-sm-2 col-form-label">'+
                                            'Bank Name'+
                                        '</label>'+
                                        '<div class="col-sm-10">'+
                                            '<input type="text" name="bankname[]" class="form-control" required>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group row">'+
                                        '<label class="col-sm-2 col-form-label">'+
                                            'Account Name'+
                                        '</label>'+
                                        '<div class="col-sm-10">'+
                                            '<input type="text" name="accountname[]" class="form-control" required>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group row">'+
                                        '<label class="col-sm-2 col-form-label">'+
                                            'Account Number'+
                                        '</label>'+
                                        '<div class="col-sm-10">'+
                                            '<input type="text" name="accountnumber[]" class="form-control" required>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div id="appb'+b.toString()+'"></div>');
        b++;
    }

    function removeBank(banknum){
        $("#bankid"+banknum).remove();
    }

    var c = 1;
    function appendContact(){
        $("#appc").append('<div class="card" id="contactid'+c.toString()+'">'+
                            '<div class="card-header">Contact Details <input type="button" style="float:right;" onclick="appendContact()" class="btn btn-primary" name="add_contact" id="addContact" value="Add">'+
                                '<button type="button" style="float:right;" id="removecontact" onclick="removeContact('+c.toString()+');" class="btn btn-danger btnremove">Remove</button>'+
                            '</div>'+
                            '<div class="card-body">'+
                                '<div class="form-group row">'+
                                    '<label class="col-sm-2 col-form-label">'+
                                        'Telco Name'+
                                    '</label>'+
                                    '<div class="col-sm-10">'+
                                        '<input type="text" name="telconame[]" class="form-control" required>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group row">'+
                                    '<label class="col-sm-2 col-form-label">'+
                                        'Contact Number'+
                                    '</label>'+
                                    '<div class="col-sm-10">'+
                                        '<input type="text" name="contactnumber[]" class="form-control" required>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div id="appc'+c.toString()+'"></div>');
        c++;
    }

    function removeContact(contactnum){
        $("#contactid"+contactnum).remove();
    }


    var b2 = 1;
    function appendBank2(){
        document.getElementById("sbmtbtnbank").style.display = "inline-block";
        $("#appbk").append('<div class="card" id="bankid'+b2.toString()+'">'+
                                '<div class="card-header">'+
                                    'Bank Details <input type="button" style="float:right;" onclick="appendBank2()" class="btn btn-primary" name="add_bank" id="addBank" value="Add">'+
                                    '<button type="button" style="float:right;" id="removebank" onclick="removeBank2('+b2.toString()+');" class="btn btn-danger btnremove">Remove</button>'+
                                '</div>'+
                                '<div class="card-body">'+
                                    '<div class="form-group row">'+
                                        '<label class="col-sm-2 col-form-label">'+
                                            'Bank Name'+
                                        '</label>'+
                                        '<div class="col-sm-10">'+
                                            '<input type="text" name="banknameadd[]" class="form-control" required>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group row">'+
                                        '<label class="col-sm-2 col-form-label">'+
                                            'Account Name'+
                                        '</label>'+
                                        '<div class="col-sm-10">'+
                                            '<input type="text" name="accountnameadd[]" class="form-control" required>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group row">'+
                                        '<label class="col-sm-2 col-form-label">'+
                                            'Account Number'+
                                        '</label>'+
                                        '<div class="col-sm-10">'+
                                            '<input type="text" name="accountnumberadd[]" class="form-control" required>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div id="appb'+b2.toString()+'"></div>');
        b2++;
    }

    function removeBank2(banknum){
        $("#bankid"+banknum).remove();
        b2--;
        if(b2 == 1){
            document.getElementById("sbmtbtnbank").style.display = "none";
        }
    }

var c2 = 1;
function appendContact2(){
    document.getElementById("sbmtbtncontact").style.display = "inline-block";
    $("#appct").append('<div class="card" id="contactid'+c2.toString()+'">'+
                        '<div class="card-header">Contact Details <input type="button" style="float:right;" onclick="appendContact2()" class="btn btn-primary" name="add_contact" id="addContact" value="Add">'+
                            '<button type="button" style="float:right;" id="removecontact" onclick="removeContact2('+c2.toString()+');" class="btn btn-danger btnremove">Remove</button>'+
                        '</div>'+
                        '<div class="card-body">'+
                            '<div class="form-group row">'+
                                '<label class="col-sm-2 col-form-label">'+
                                    'Telco Name'+
                                '</label>'+
                                '<div class="col-sm-10">'+
                                    '<input type="text" name="telconameadd[]" class="form-control" required>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group row">'+
                                '<label class="col-sm-2 col-form-label">'+
                                    'Contact Number'+
                                '</label>'+
                                '<div class="col-sm-10">'+
                                    '<input type="text" name="contactnumberadd[]" class="form-control" required>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div id="appc'+c2.toString()+'"></div>');
    c2++;
}

function removeContact2(contactnum){
    $("#contactid"+contactnum).remove();
    c2--;
    if(c2 == 1){
        document.getElementById("sbmtbtncontact").style.display = "none";
    }
}






    // var i = 0;
    // var oribank = document.getElementById("bankid");
    // function duplicateBank() {
    //     //document.getElementById("removebank").style.display = "inline-block";
    //     var newbank = oribank.cloneNode(true);
    //     //newbank.id = "bankid" + ++i;
    //     oribank.appendChild(newbank);
    //     oribank.id = "bankid" + ++i;
    //     // oribank.parentNode.appendChild(newbank);
        
    //     // var hid = document.getElementById("hiddenbank").value;
    //     // console.log(i);
    //     // if(hid == 1){
    //     //     document.getElementById("hiddenbank").value = '2';
    //     //     document.getElementById("bankid").appendChild(newbank);
    //     // }else{
    //     //     newbank.id = "bankid" + ++i;  
    //     //     document.getElementById("bankid").appendChild(newbank);
    //     // }
          
    // }

    // var j = 0;
    // function duplicateContact() {
    //     var oricontact = document.getElementById("contactid");
    //     var newcontact = oricontact.cloneNode(true);
    //     document.getElementById("contactid").appendChild(newcontact);
    //     oricontact.id = "contactid" + ++j;
    // }
    
</script>

@endsection