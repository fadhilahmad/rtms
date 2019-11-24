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
                                    <div class="row">
                                        <div class="col-sm-3">Design Link</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8"><a href="{{$order->design_link}}" target="_blank">Google Drive Link</a></div>
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
                                            <th scope="col">Printed</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              <td>{{$unit->un_quantity}}</td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','1')->count()>0)
                                                  <button 
                                                        class="btn btn-primary done" data-target="#Modal" data-uid="{{Auth::id()}}" data-process="print"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}">Completed
                                                  </button>
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
                                                  <button 
                                                        class="btn btn-primary done" data-target="#Modal" data-uid="{{Auth::id()}}" data-process="print"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}">Completed
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
                            $completed =  $units->where('o_id',$spec->o_id)->where('un_status','2')->count()
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
                                            <th scope="col">Printed</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>
                                              <td>{{$unit->name}}</td>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              <td>{{$unit->un_quantity}}</td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','1')->count()>0)
                                                  <button 
                                                        class="btn btn-primary done" data-target="#Modal" data-uid="{{Auth::id()}}" data-process="print"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}">Completed
                                                  </button>
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
                                                  <button 
                                                        class="btn btn-primary done" data-target="#Modal" data-uid="{{Auth::id()}}" data-process="print"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}">Completed
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
                            $completed =  $units->where('o_id',$spec->o_id)->where('un_status','2')->count()
                            @endphp
                            @endforeach
                            
                            @endif
                             <br><br>
                            @if($no==$completed)
                             <center><button class="btn btn-primary edit" data-toggle="modal" data-target="#modal" data-oid="{{$order->o_id}}" data-refnum="{{$order->ref_num}}" >Select Tailor</button></center>                                         
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
        <h5 class="modal-title" id="modalTitle">Submit To Tailor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Order Ref Num</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="refnum" name="refnum" value="" disabled="" >
                    <input type="hidden" class="form-control" id="oid" name="oid">
                    <input type="hidden" class="form-control" id="process" name="process" value="complete">
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Tailor</label>
                <div class="col-sm-8">
                    <select id="tailor" name="tailor" class="form-control" >
                        @foreach($tailors as $tailor)
                                    <option value="{{$tailor->u_id}}">{{$tailor->u_fullname}}</option>
                        @endforeach
                   </select>
                </div>
              </div>        
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-submits">Confirm</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on("click", ".edit", function () {
     var oid = $(this).data('oid');
     var refnum = $(this).data('refnum');

     $(".modal-body #refnum").val( refnum );
     $(".modal-body #oid").val( oid );

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
           url:"{{url('department/job_print')}}",
           data:formData,
           success:function(data){
               location.reload();
           }
        });
      
    });
 
 $(".btn-submits").click(function(e){
        e.preventDefault();
        
        var formData = {
            'oid'   : $('input[name=oid]').val(),
            'tailor'   : $('select[name=tailor]').val(),
            'process'    : $('input[name=process]').val()
        };
//console.log(formData);
        $.ajax({
           type:'POST',
           url:"{{url('department/job_print')}}",
           data:formData,
           success:function(data){
           location.href = "{{url('department/joblist')}}";
//                    location.reload();
           }
        });
      
    });
</script>
@endsection
