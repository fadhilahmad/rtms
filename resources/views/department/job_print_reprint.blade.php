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
                <div class="card-header">Job Reprint Sheet</div>

                <div class="card-body">
                            @foreach($reprint as $re)
                            <div class="panel panel-primary">
                                <div class="panel-heading"></div>                                                                  
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">Ref Num</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$re->ref_num}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">File name</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$re->file_name}}</div>
                                    </div><br>                                   
                                    <div class="row">
                                        <div class="col-sm-3">Note</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$re->note}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Design Link</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8"><a href="{{$re->design_link}}" target="_blank">Google Drive Link</a></div>
                                    </div><br>
                            
                            @php $no=0; @endphp
                            @foreach($specs as $spec)
                            @if($spec->category=="Size")
                            <div class="panel panel-primary">
                                <br><br><div class="panel-heading"><center><h2 style="text-transform: uppercase;">{{$spec->b_desc}} {{$spec->sl_desc}} {{$spec->n_desc}}</h2></center></div><br><br>                                                                  
                                <div class="panel-body">
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                          <tr>
                                            <th scope="col">Size</th>
                                            <th scope="col">Reprint Quantity</th>
                                            <th scope="col">Note</th>
                                            <th scope="col">Printed</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              @php $quan = $print->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->last()   @endphp
                                              <td>{{$quan['r_quantity']}}</td>
                                              <td>{{$notes->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('note')->first()}}</td>
                                              <td>                                                  
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
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
                            
                            @elseif($spec->category=="Nameset")
                            <div class="panel panel-primary">
                                <br><br><div class="panel-heading"><center><h2 style="text-transform: uppercase;">{{$spec->b_desc}} {{$spec->sl_desc}} {{$spec->n_desc}}</h2></center></div><br><br>                                                                  
                                <div class="panel-body">
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                          <tr>
                                            <th scope="col">Name/Number</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Reprint Quantity</th>
                                            <th scope="col">Printed</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>
                                              <td>{{$unit->name}}</td>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              @php $quan = $print->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->last()   @endphp
                                              <td>{{$quan['r_quantity']}}</td>
                                              <td>
                                                  
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
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
                            @endif
                            @php
                            $completed =  $units->where('o_id',$spec->o_id)->where('un_status','<>','5')->count()
                            @endphp
                            @endforeach       
                                                                                 
                             <br><br>
                            @if($no==$completed)
                            
                            <form method="post" action="{{route('print_reprint')}}">@csrf
                             <input type="hidden" name="process" value="complete">
                             <input type="hidden" name="o_id" value="{{$re->o_id}}">
                             <center><button type="submit" class="btn btn-primary edit" >Complete Reprint</button></center>                             
                            @endif                                              
                                </div>                                
                            </div>
                         @endforeach
                </div>
            </div>
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
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
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
           url:"{{url('department/job_reprint_print')}}",
           data:formData,
           success:function(data){
               location.reload();
           }
        });
      
    });
 
 $(".btn-submits").click(function(e){
        e.preventDefault();
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
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
