@extends ('layouts.layout')
@section ('content')
<style>
#logo {
  border: 1px solid #ddd;
  border-radius: 4px;
}

.table {
   margin: auto;
   width: 80% !important; 
}
td,th {
text-align: center;
}
.modal-open {
    overflow: scroll;
}
form, form formbutton { display: inline; }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-gear"></i> Company Profile 
                    <div class="float-right">
                        @if(!$company)
                        <button data-toggle="modal" data-target="#companyModal" data-process="add" class="btn-sm addcompany">Add</button>
                        @else
                        <button data-toggle="modal" data-target="#companyModal" data-process="update" class="btn-sm updatecompany">Update</button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">Company Name</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-4">@if($company){{$company->company_name}}@endif</div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-3">System Name</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-4">@if($company){{$company->system_name}}@endif</div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-3">Address</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-4">@if($company){{$company->address_first}}@endif ,</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4">@if($company){{$company->address_second}}@endif ,</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4">@if($company){{$company->poscode}}@endif @if($company){{$company->city}}@endif , @if($company){{$company->state}}@endif</div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-3">Logo</div>
                        <div class="col-sm-1">:</div>
                        <div class="col-sm-4">
                            @if($company)
                            <img class="" src="{{url('img/logo/'.$company->company_logo)}}" width="80%" id="logo">
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> Bank Detail <div class="float-right"><button data-toggle="modal" data-target="#bankModal" data-process="addBank" class="btn-sm bankAdd">Add</button></div></div>
                <div class="card-body">
                    @if(!$banks->isempty())
                    <table class='table borderless'>
                        <tr>
                            <th>Bank Name</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
<!--                            <th>Bank logo</th>-->
                            <th>Action</th>
                        </tr>
                        @foreach($banks as $bank)
                        <tr>
                            <td>{{$bank->bank_name}}</td>
                            <td>{{$bank->account_name}}</td>
                            <td>{{$bank->account_number}}</td>
<!--                            <td><img class="" src="{{url('img/logo/'.$bank->bank_logo)}}" width="70" height="70"></td>-->
                            <td class="inline">
                                <button data-toggle="modal" data-target="#bankModal" data-process="updateBank" data-bdid="{{$bank->bd_id}}" data-bankname="{{$bank->bank_name}}" data-accountname="{{$bank->account_name}}" data-accountnumber="{{$bank->account_number}}" class="btn-sm bankUpdate">Update</button>
                                <form action="{{route('admin.update_company_profile')}}" method="POST">{{ csrf_field() }}
                                        <button class="btn-sm bankUpdate formbutton" type="submit" onclick="return confirm('Are you sure to delete this bank detail?')" >Delete</button>                         
                                        <input type="hidden" name="bd_id" value=" {{$bank->bd_id}}">
                                        <input type="hidden" name="operation" value="bank">
                                        <input type="hidden" name="process" value="bankDelete">                                   
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    No record
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> Contact Number <div class="float-right"><button data-toggle="modal" data-target="#contactModal" data-process="addContact" class="btn-sm addContact">Add</button></div></div>
                <div class="card-body">
                    @if(!$contacts->isempty())
                    <table class='table borderless'>
                        <tr>
                            <th>Contact Number</th>
                            <th>Telco</th>
                            <th>Action</th>
                        </tr>
                        @foreach($contacts as $contact)
                        <tr>
                            <td>{{$contact->contact_number}}</td>
                            <td>{{$contact->telco_name}}</td>
                            <td>
                                <button data-toggle="modal" data-target="#contactModal" data-process="updateContact" data-cnid="{{$contact->cn_id}}" data-num="{{$contact->contact_number}}" data-telco="{{$contact->telco_name}}" class="btn-sm contactUpdate">Update</button>
                                <form action="{{route('admin.update_company_profile')}}" method="POST">{{ csrf_field() }}
                                        <button class="btn-sm formbutton" type="submit" onclick="return confirm('Are you sure to delete this contact number?')" >Delete</button>                         
                                        <input type="hidden" name="cn_id" value=" {{$contact->cn_id}}">
                                        <input type="hidden" name="operation" value="contact">
                                        <input type="hidden" name="process" value="contactDelete">                                   
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    No record
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <form enctype="multipart/form-data" method="POST" id="companyform" name="companyform" action="{{route('admin.update_company_profile')}}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Company Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Company Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="description" name="name" placeholder="Company Name" value="@if($company){{$company->company_name}}@endif" required="required" >
                    <input type="hidden" name="ss_id" value="@if($company){{$company->ss_id}}@endif">
                    <input type="hidden" name="operation" value="company">
                    <input type="hidden" name="process" id="companyProcess">
                </div>
              </div> 

              <div class="form-group row">
                <label for="ssname" class="col-sm-4 col-form-label">System Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="ssname" name="ssname" placeholder="System Name" value="@if($company){{$company->system_name}}@endif" required="required" >
                </div>
              </div>
          
             <div class="form-group row">
                <label for="address1" class="col-sm-4 col-form-label">Company Address</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Street 1" value="@if($company){{$company->address_first}}@endif" required="required" >
                </div>
             </div>
          
             <div class="form-group row">
                <label class="col-sm-4"></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Street 2" value="@if($company){{$company->address_second}}@endif" required="required" >
                </div>
             </div>
          
            <div class="form-group row">
                <label class="col-sm-4"></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="poscode" name="poscode" placeholder="Poscode" value="@if($company){{$company->poscode}}@endif" required="required" >
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" value="@if($company){{$company->city}}@endif" required="required" >
                </div>
             </div>
          
             <div class="form-group row">
                <label class="col-sm-4"></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="state" name="state" placeholder="State" value="@if($company){{$company->state}}@endif" required="required" >
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="@if($company){{$company->country}}@endif" required="required" >
                </div>
             </div>
          
              <div class="form-group row">
                <label for="logo" class="col-sm-4 col-form-label">Company Logo</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="logo">
                </div>
              </div>          
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="validateCompany()" type="submit" class="btn btn-primary">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<div class="modal fade" id="bankModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form enctype="multipart/form-data" method="POST" id="bankform" name="bankform" action="">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Bank Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="bankname" class="col-sm-4 col-form-label">Bank Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="bankname" name="bank_name" placeholder="Bank Name" required="required" >
                    <input type="hidden" name="bd_id" id="bdid">
                    <input type="hidden" name="process" id="bankProcess">
                    <input type="hidden" name="operation" value="bank">
                </div>
              </div> 

              <div class="form-group row">
                <label for="accountname" class="col-sm-4 col-form-label">Account Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="accountname" name="account_name" placeholder="Account Name" required="required" >
                </div>
              </div>
          
             <div class="form-group row">
                <label for="accnum" class="col-sm-4 col-form-label">Account Number</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="accnum" name="account_num" placeholder="Account Number" required="required" >
                </div>
             </div>
          
<!--              <div class="form-group row">
                <label for="banklogo" class="col-sm-4 col-form-label">Bank Logo</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" id="banklogo" name="bank_logo">
                </div>
              </div>          -->
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="validateBank()" type="submit" class="btn btn-primary">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="contactform" name="contactform" action="">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Contact Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="contactnumber" class="col-sm-4 col-form-label">Contact Number</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="contactnumber" name="contact_number" placeholder="Contact Number" required="required" >
                    <input type="hidden" name="cn_id" id="cnid">
                    <input type="hidden" name="operation" value="contact">
                    <input type="hidden" name="process" id="contactProcess">
                </div>
              </div> 

              <div class="form-group row">
                <label for="telco" class="col-sm-4 col-form-label">Telco</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="telco" name="telco" placeholder="Telco" required="required" >
                </div>
              </div>       
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="validateContact()" type="submit" class="btn btn-primary">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).on("click", ".addcompany", function () {
     var process = $(this).data('process');
     $("#companyProcess").val( process );
});

$(document).on("click", ".updatecompany", function () {
     var process = $(this).data('process');
     $("#companyProcess").val( process );
});

$(document).on("click", ".bankAdd", function () {
     var process = $(this).data('process');
     $("#bankProcess").val( process );
     $("#bdid").val("");
     $("#bankname").val("");
     $("#accountname").val("");
     $("#accnum").val("");
});

$(document).on("click", ".bankUpdate", function () {
     var process = $(this).data('process');
     var bdid = $(this).data('bdid');
     var bankname = $(this).data('bankname');
     var account = $(this).data('accountname');
     var num = $(this).data('accountnumber');
     $("#bankProcess").val( process );
     $("#bdid").val( bdid );
     $("#bankname").val( bankname );
     $("#accountname").val( account );
     $("#accnum").val( num );
});

$(document).on("click", ".addContact", function () {
     var process = $(this).data('process');
     $("#contactProcess").val( process );
     $("#cnid").val("");
     $("#contactnumber").val("");
     $("#telco").val("");
     
     console.log(process);
});

$(document).on("click", ".contactUpdate", function () {
     var process = $(this).data('process');
     var cnid = $(this).data('cnid');
     var num = $(this).data('num');
     var telco = $(this).data('telco');
     $("#contactProcess").val( process );
     $("#cnid").val(cnid);
     $("#contactnumber").val(num);
     $("#telco").val(telco);
});

function validateCompany() {
    var x = document.forms["companyform"]["name"].value;
        if (x == "") 
        {
        alert("Please fill all field");
        return false;
        }
        else
        {
          document.getElementById("companyform").submit();  
        }       
    }
    
function validateBank() {
    var x = document.forms["bankform"]["bank_name"].value;
    var y = document.forms["bankform"]["account_name"].value;
    var z = document.forms["bankform"]["account_num"].value;
        if (x == "") 
        {
        alert("Please fill bank name");
        return false;
        }
        if (y == "") 
        {
        alert("Please fill account name");
        return false;
        }
        if (z == "") 
        {
        alert("Please fill account number");
        return false;
        }
        else
        {
          document.getElementById("bankform").submit();  
        }       
    }
    
    function validateContact() {
    var x = document.forms["contactform"]["contact_number"].value;
    var y = document.forms["contactform"]["telco"].value;
        if (x == "") 
        {
        alert("Contact number must be filled out");
        return false;
        }
        if (y == "") 
        {
        alert("Telco must be filled out");
        return false;
        }
        else
        {
          document.getElementById("contactform").submit();  
        }       
    }
</script>
@endsection