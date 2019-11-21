@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Job List</div>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                <div class="card-body">
                    @if(!$orders->isempty())
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Ref No</th>
                                    <th scope="col">File Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Design Link</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                  <tr>
                                    <td>{{$order->ref_num}}</td>
                                    <td>{{$order->file_name}}</td>
                                    <td>{{$order->category}}</td>
                                    <td>{{$order->quantity_total}}</td>
                                    <td>{{$order->delivery_date}}</td>
                                    <td><a href="{{$order->design_link}}" target="_blank">Google Drive Link</a></td>
                                    <td>
                                      
                                       @if($department==3)
                                         @if($order->design_link != "")
                                         <button class="btn btn-default addLink" data-toggle="modal" data-target="#Modal" data-link="{{$order->design_link}}" data-operation="update" data-title="Update Design Link" data-oid="{{$order->o_id}}">Update Link</button>
                                         @else
                                         <button class="btn btn-default addLink" data-toggle="modal" data-target="#Modal" data-link="" data-operation="add" data-title="Add Design Link" data-oid="{{$order->o_id}}">Add Link</button>
                                         @endif
                                    <a href="{{route('job_design',$order->o_id)}}"><button class="btn btn-primary">Update Job</button></a>
                                       @endif
                                       @if($department==4)
                                    <a href="{{route('job_sew',$order->o_id)}}"><button class="btn btn-primary">Sew</button></a>
                                       @endif
                                       @if($department==5)
                                    <a href="{{route('job_print',$order->o_id)}}"><button class="btn btn-primary">Print</button></a>
                                       @endif
                                    </td>                                    
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                    @else
                    No job
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="form" name="form" >
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          *Please insert full link including "https://docs.google.com/"<br><br>
              <div class="form-group row">
                <label for="description" class="col-sm-2 col-form-label">Full Link</label>
                <div class="col-sm-10">
                    <textarea id="links" name="links" rows="4" cols="40" ></textarea>
<!--                    <input type="textarea" rows="4" cols="40" class="form-control" id="links" name="links">-->
                    <input type="hidden" name="oid" id="oId">
                    <input type="hidden" name="operation" id="operation">
                </div>
              </div>        
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" type="submit" class="btn btn-primary btn-submit">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on("click", ".addLink", function () {
     var name = $(this).data('title');
     var ops = $(this).data('operation');
     var oid = $(this).data('oid');
     var link = $(this).data('link');
     
     $(".modal-title").text( name );
     $(".modal-body #links").val( link );
     $(".modal-body #oId").val( oid );
     $(".modal-body #operation").val( ops );

});
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-submit").click(function(e){
        e.preventDefault();

        var x = document.forms["form"]["links"].value;
        if (x == "") 
        {
            alert("Link must be filled out");
            return false;
        }
        else{
        var formData = {
            'link'   : $('textarea#links').val(),
            'o_id'   : $('input[name=oid]').val(),
            'operation'    : $('input[name=operation]').val(),
            'page' : 'putDesignLink'
        };

        console.log(formData);
        $.ajax({
           type:'POST',
           url:"{{url('department/joblist')}}",
           data:formData,
           success:function(data){
              $('#Modal').modal('hide');
                   location.reload();
                  // console.log(data);
           }
        });
      }
    });    
</script>
@endsection
