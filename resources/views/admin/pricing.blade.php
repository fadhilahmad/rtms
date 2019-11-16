@extends('layouts.layout')

@section('content')
<style>
.table {
   margin: auto;
   width: 100% !important; 
}
td,th {
text-align: center;
}
.modal-open {
    overflow: scroll;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Pricing</div><BR>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                <div class="card-body">
                    <center><h2>TIER 1 AGENT PRICING</h2></center><br>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">BODY</th>
                                <?php $no=-1; ?>
                                @foreach($sleeve as $sle) 
                                <th scope="col">{{$sle->sl_desc}}/RN</th>
                                <th scope="col">{{$sle->sl_desc}}/COLLAR</th>
                                <?php $no=$no+2;  
                                $sle_id1[] = array('s_id'=>$sle->sl_id,'n_id'=>'2','name'=>$sle->sl_desc."/RN");
                                $sle_id1[] = array('s_id'=>$sle->sl_id,'n_id'=>'1','name'=>$sle->sl_desc."/COLLAR");
                                ?>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                                                                           
                                @foreach($body as $bod)
                                <tr>                                
                                <td class="table-dark">{{$bod->b_desc}}</td>
                                @foreach ($sle_id1 as $ad) 
                                <td class="table-success">
                                    @php
                                        $name = $bod->b_desc." ".$ad['name'];
                                        echo App\Http\Controllers\Admin\OrderController::getPrice($ad['s_id'],$bod['b_id'],$ad['n_id'],6,$name);
                                    @endphp 
                                </td>
                                @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table><br><br>
                        <hr>
                    <center><h2>TIER 2 AGENT PRICING</h2></center><br>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">BODY</th>
                                <?php $no=-1; ?>
                                @foreach($sleeve as $sle) 
                                <th scope="col">{{$sle->sl_desc}}/RN</th>
                                <th scope="col">{{$sle->sl_desc}}/COLLAR</th>
                                <?php $no=$no+2;  
                                $sle_id2[] = array('s_id'=>$sle->sl_id,'n_id'=>'2','name'=>$sle->sl_desc."/RN");
                                $sle_id2[] = array('s_id'=>$sle->sl_id,'n_id'=>'1','name'=>$sle->sl_desc."/COLLAR");
                                ?>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                                                                           
                                @foreach($body as $bod)
                                <tr>                                
                                <td class="table-dark">{{$bod->b_desc}}</td>
                                @foreach ($sle_id2 as $ad) 
                                <td class="table-success">
                                    @php
                                        $name = $bod->b_desc." ".$ad['name'];
                                        echo App\Http\Controllers\Admin\OrderController::getPrice($ad['s_id'],$bod['b_id'],$ad['n_id'],8,$name);
                                    @endphp 
                                </td>
                                @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table><br><br>
                        <hr>
                    <center><h2>TIER 3 AGENT PRICING</h2></center><br>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">BODY</th>
                                <?php $no=-1; ?>
                                @foreach($sleeve as $sle) 
                                <th scope="col">{{$sle->sl_desc}}/RN</th>
                                <th scope="col">{{$sle->sl_desc}}/COLLAR</th>
                                <?php $no=$no+2;  
                                $sle_id3[] = array('s_id'=>$sle->sl_id,'n_id'=>'2','name'=>$sle->sl_desc."/RN");
                                $sle_id3[] = array('s_id'=>$sle->sl_id,'n_id'=>'1','name'=>$sle->sl_desc."/COLLAR");
                                ?>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                                                                           
                                @foreach($body as $bod)
                                <tr>                                
                                <td class="table-dark">{{$bod->b_desc}}</td>
                                @foreach ($sle_id3 as $ad) 
                                <td class="table-success">
                                    @php
                                        $name = $bod->b_desc." ".$ad['name'];
                                        echo App\Http\Controllers\Admin\OrderController::getPrice($ad['s_id'],$bod['b_id'],$ad['n_id'],9,$name);
                                    @endphp 
                                </td>
                                @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table><br><br>
                        <hr>                        
                        <center><h2>END USER PRICING</h2></center><br> 
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">BODY</th>
                                <?php $no=-1; ?>
                                @foreach($sleeve as $sle) 
                                <th scope="col">{{$sle->sl_desc}}/RN</th>
                                <th scope="col">{{$sle->sl_desc}}/COLLAR</th>
                                <?php $no=$no+2;  
                                $info[] = array('s_id'=>$sle->sl_id,'n_id'=>'2','name'=>$sle->sl_desc."/RN");
                                $info[] = array('s_id'=>$sle->sl_id,'n_id'=>'1','name'=>$sle->sl_desc."/COLLAR");
                                ?>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                                                                           
                                @foreach($body as $bod)
                                <tr>                                
                                <td class="table-dark">{{$bod->b_desc}}</td>
                                @foreach ($info as $in) 
                                <td class="table-success">
                                    @php
                                        $name = $bod->b_desc." ".$in['name'];
                                        echo App\Http\Controllers\Admin\OrderController::getPrice($in['s_id'],$bod['b_id'],$in['n_id'],7,$name);
                                    @endphp 
                                </td>
                                @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="priceform" name="priceform" action="{{ route('admin_pricing') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Price Setting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="priceName" name="priceName" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Price</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="price" name="price" required="required" >
                    <input type="hidden" name="sl_id" id="slId">
                    <input type="hidden" name="b_id" id="bId">
                    <input type="hidden" name="n_id" id="nId">
                    <input type="hidden" name="u_type" id="utype">
                    <input type="hidden" name="process" id="process">
                    <input type="hidden" name="p_id" id="pid">
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
$(document).on("click", ".addPrice", function () {
     var name = $(this).data('tittle');
     var pricename = $(this).data('name');
     var bid = $(this).data('bid');
     var nid = $(this).data('nid');
     var slid = $(this).data('slid');
     var utype = $(this).data('utype');
     var process = $(this).data('process');
     
     $(".modal-title").text( name );
     $(".modal-body #priceName").val( pricename );
     $(".modal-body #slId").val( slid );
     $(".modal-body #bId").val( bid );
     $(".modal-body #nId").val( nid );
     $(".modal-body #utype").val( utype );
     $(".modal-body #process").val( process );
     $(".modal-body #price").val( "" );

});

$(document).on("click", ".editPrice", function () {
     var name = $(this).data('tittle');
     var pricename = $(this).data('name');
     var price = $(this).data('price');
     var utype = $(this).data('utype');
     var process = $(this).data('process');
     var pid = $(this).data('pid');
     $(".modal-title").text( name );
     $(".modal-body #priceName").val( pricename );
     $(".modal-body #price").val( price);
     $(".modal-body #utype").val( utype );
     $(".modal-body #process").val( process );
     $(".modal-body #pid").val( pid );
     
     console.log(pid)
});
  
//  function validateForm() {
//    var x = document.forms["priceform"]["price"].value;
//        if (x == "") 
//        {
//        alert("Price must be filled out");
//        return false;
//        }
//        else
//        {
//          document.getElementById("priceform").submit();  
//        }       
//    }
//    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-submit").click(function(e){
        e.preventDefault();

        var x = document.forms["priceform"]["price"].value;
        if (x == "") 
        {
            alert("Price must be filled out");
            return false;
        }
        else{
        var formData = {
            'price'   : $('input[name=price]').val(),
            'sl_id'   : $('input[name=sl_id]').val(),
            'b_id'    : $('input[name=b_id]').val(),
            'n_id'   : $('input[name=n_id]').val(),
            'u_type'   : $('input[name=u_type]').val(),
            'process'    : $('input[name=process]').val(),
            'p_id'    : $('input[name=p_id]').val()
        };

        $.ajax({
           type:'POST',
           url:"{{url('admin/pricing')}}",
           data:formData,
           success:function(data){
              $('#priceModal').modal('hide');
                    location.reload();
           }
        });
      }
    });    
</script>
@endsection


