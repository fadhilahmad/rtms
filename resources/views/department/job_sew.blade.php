@extends('layouts.layout')

@section('content')
<style>
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
                <div class="card-header">Job Sheet</div>

                <div class="card-body">
                            @foreach($orders as $order)
                            <div class="panel panel-primary">
                                <div class="panel-heading"></div>                                                                  
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">Ref Num</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->ref_num}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">File name</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->file_name}}</div>
                                    </div><br> 
                                    <div class="row">
                                        <div class="col-sm-3">Total Quantity</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->quantity_total}}</div>
                                    </div><br>                                    
                                    <div class="row">
                                        <div class="col-sm-3">Note</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->note}}</div>
                                    </div><br>
                            @if($order->category=="Size")
                            @php $no=0; @endphp
                            @foreach($specs as $spec)
                            <div class="panel panel-primary">
                                <br><br><div class="panel-heading"><center><h2 style="text-transform: uppercase;">{{$spec->b_desc}} {{$spec->sl_desc}} {{$spec->n_desc}}</h2></center></div><br><br>                                                                  
                                <div class="panel-body">
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                          <tr>
                                            <th scope="col">Size</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Sewed</th>
                                            <th scope="col">Request Reprint</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              <td>{{$unit->un_quantity}}</td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','2')->count()>0)
                                                  <button 
                                                        class="btn btn-primary done" data-target="#Modal" data-table="body" data-uid="{{Auth::id()}}" data-process="sew"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}">Completed
                                                  </button>
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
                                                  x
                                                  @else
                                                  <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                  @endif
                                              </td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','3')->count()>0)
                                                  <input type="checkbox" name="jobdone" value="" disabled="">                                                  
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','2')->count()>0)
                                                  <button 
                                                        class="btn btn-default reprint" data-toggle="modal" data-target="#modal" data-refnum="{{$order->ref_num}}" data-name="{{$unit->name}}" data-size="{{$unit->size}}"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}" data-category="Size" data-maxquan="{{$unit->un_quantity}}">Request
                                                  </button>
                                                  @else
                                                  <input type="checkbox" name="jobdone" value="" checked="" disabled=""> 
                                                  @endif
                                              </td>
                                          </tr>
                                    @php $no++; @endphp
                                    @endforeach                                                                                   
                                        </tbody>
                                    </table>                                                                        
                                </div>                                   
                            </div>
                            
                            @php
                            $completed =  $units->where('o_id',$spec->o_id)->where('un_status','3')->count()
                            @endphp
                            @endforeach       
                            @endif
                            
                            @if($order->category=="Nameset")
                            @php $no=0; @endphp
                            @foreach($specs as $spec)
                            <div class="panel panel-primary">
                                <br><br><div class="panel-heading"><center><h2 style="text-transform: uppercase;">{{$spec->b_desc}} {{$spec->sl_desc}} {{$spec->n_desc}}</h2></center></div><br><br>                                                                  
                                <div class="panel-body">
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                          <tr>
                                            <th scope="col">Name/Number</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Sewed</th>
                                            <th scope="col">Request Reprint</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>
                                              <td>{{$unit->name}}</td>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              <td>{{$unit->un_quantity}}</td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','2')->count()>0)
                                                  <button 
                                                        class="btn btn-primary done" data-target="#Modal" data-table="body" data-uid="{{Auth::id()}}" data-process="sew"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}">Completed
                                                  </button>
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
                                                  x
                                                  @else
                                                  <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                  @endif
                                              </td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','3')->count()>0)
                                                  <input type="checkbox" name="jobdone" value="" disabled="">                                                  
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','2')->count()>0)
                                                  <button 
                                                        class="btn btn-default reprint" data-toggle="modal" data-target="#modal" data-refnum="{{$order->ref_num}}" data-name="{{$unit->name}}" data-size="{{$unit->size}}"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}" data-category="Nameset" data-maxquan="{{$unit->un_quantity}}">Request
                                                  </button>
                                                  @else
                                                  <input type="checkbox" name="jobdone" value="" checked="" disabled=""> 
                                                  @endif
                                              </td>
                                          </tr>
                                    @php $no++; @endphp
                                    @endforeach                                                                                   
                                        </tbody>
                                    </table>                                                                        
                                </div>                                   
                            </div>
                            
                            @php
                            $completed =  $units->where('o_id',$spec->o_id)->where('un_status','3')->count()
                            @endphp
                            @endforeach
                            
                            @endif
                             <br><br>
                            @if($no==$completed)
                            <form method="post" action="{{route('update.sew')}}">@csrf
                             <input type="hidden" name="process" value="complete">
                             <input type="hidden" name="o_id" value="{{$order->o_id}}">
                             <center><button type="submit" class="btn btn-primary edit" >Ready To Deliver</button></center>                                         
                            @endif                                              
                                </div>                                
                            </div>
                         @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="form" name="form">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Request Reprint</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Order Ref Num</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="refnum" name="refnum" value="" disabled="" >
                </div>
              </div>
          
              <div class="form-group row namediv">
                <label for="description" class="col-sm-4 col-form-label">Name/Number</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" value="" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Size</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="size" name="size" value="" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Quantity Reprint</label>
                <div class="col-sm-8">
                    <input type="number" min="1" class="form-control" id="quantity" name="quantity" >
                    <input type="hidden" class="form-control" id="oid" name="oid">
                    <input type="hidden" class="form-control" id="unid" name="unid">
                    <input type="hidden" class="form-control" id="process" name="process_re" value="reprint">
                </div>
              </div>        
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submits">Confirm</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on("click", ".reprint", function () {
     var oid = $(this).data('oid');
     var unid = $(this).data('unid');
     var refnum = $(this).data('refnum');
     var category = $(this).data('category');
     var name = $(this).data('name');
     var size = $(this).data('size');
     var maxquan = $(this).data('maxquan');
     var res = size.toUpperCase();
     
     document.getElementById('quantity').setAttribute("max", maxquan);

     $(".modal-body #refnum").val( refnum );
     $(".modal-body #oid").val( oid );
     $(".modal-body #unid").val( unid );
     $(".modal-body #name").val( name );
     $(".modal-body #size").val( res );
     $(".modal-body #quantity").val( '1' );
     
     if(category==="Size"){
         $(".modal-body .namediv").hide();
     }
     if(category==="Nameset"){
         $(".modal-body .namediv").show();
     }

});

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".done").click(function(e){
        e.preventDefault();
        
        var unid = $(this).data('unid');
        var oid = $(this).data('oid');
        var uid = $(this).data('uid');
        var process = $(this).data('process');
       // console.log(unid,oid,uid,process);
       
        var formData = {
            'un_id'   : unid,
            'o_id'   : oid,
            'u_id'    : uid,
            'process'   : process
        };

        $.ajax({
           type:'POST',
           url:"{{url('department/job_sew')}}",
           data:formData,
           success:function(data){
               location.reload();
           }
        });
      
    });
    
    $(".submits").click(function(e){
        e.preventDefault();
       
       var x = document.forms["form"]["quantity"].value;
        if (x == "") 
        {
            alert("Quantity value must be filled out");
            return false;
        }
        var formData = {
            'un_id'   : $('input[name=unid]').val(),
            'o_id'   : $('input[name=oid]').val(),
            'quantity'    : $('input[name=quantity]').val(),
            'process'   : $('input[name=process_re]').val()
        };
//console.log(formData);
        $.ajax({
           type:'POST',
           url:"{{url('department/job_sew')}}",
           data:formData,
           success:function(data){
               location.reload();
           }
        });
      
    });
    
</script>
@endsection
