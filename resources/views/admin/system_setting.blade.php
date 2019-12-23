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
                                @foreach ($systemsettings as $systemsetting)
                                    <table class="table table-hover" style="text-align: center; border: 0.5px solid #aaa; border-collapse: collapse; padding: 10px;">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col-md-2">Settings</th>
                                                <th scope="col-md-8">Details</th>
                                                <th scope="col-md-2">Action</th>
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
                                                <td style="padding-top: 2%">{{$systemsetting->company_address}}</td>
                                                <td>
                                                    <button 
                                                        class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Company Address" data-table="compaddress" 
                                                        data-id="{{$systemsetting->ss_id}}" data-desc="{{$systemsetting->company_address}}"><i class="fa fa-edit"></i> Edit
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
                            @else
                                <form action="{{route('admin.update_company_profile')}}" method="POST" enctype="multipart/form-data">{{ csrf_field() }}
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
                                            <input type="text" name="companyaddress" class="form-control" required>
                                        </div>
                                    </div>
                                    <br>
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
                    <input id="neck_image" type="file" class="form-control" name="complogo" required>
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

    $(document).on("click", ".edit", function () {
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
        $(".modal-body #neckdiv").hide();
        $(".modal-body #complogo").hide();
        
        if(table=="complogo"){
            var neck = $(this).data('complogo');
            $(".modal-body #complogo").show();
            $(".modal-body #description").hide();
            
            if(neck==1){
                radiobtn = document.getElementById("n1");
                radiobtn.checked = true;
            }
            if(neck==2){
                radiobtn = document.getElementById("n2");
                radiobtn.checked = true;
            }
        }
    
        if(table=="delivery"){
            document.getElementById('description').type = 'number';
        }
    });
    
    function validateForm() {
        document.getElementById("updateform").submit();      
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
    
</script>

@endsection