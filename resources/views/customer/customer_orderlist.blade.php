@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Order List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel-body">

                        @if(count($orders) > 0)

                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Cloth Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Delivery Date</th>
                                    <th scope="col">Design</th>
                                    <th scope="col">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; ?>
                                    @foreach($ordersdraft as $singleorderrow)
                                        <tr>

                                            
                                            <th scope="row"><?php echo $no; ?></th>
                                            <td>{{$singleorderrow->file_name}}</td>
                                            <td>{{$singleorderrow->quantity_total}}</td>
                                            <td>{{$singleorderrow->category}}</td>
                                            <td>{{$singleorderrow->note}}</td>
                                            <td>{{$singleorderrow->delivery_date}}</td>
                                            <td>
                                                @if($singleorderrow->o_status!=1)
                                                    <a href="/customer/vieworder/{{$singleorderrow->o_id}}">View Design</a>
                                                 @endif
                                                 @if($singleorderrow->o_status==1)
                                                    <a href="/customer/viewdesign/{{$singleorderrow->o_id}}">View Design</a>
                                                 @endif 
                                            </td>
                                            <td>
                                                @if($singleorderrow->o_status==1)
                                                    Waiting for design
                                                 @endif
                                                 @if($singleorderrow->o_status==2)
                                                    Order Confirm
                                                 @endif
                                                 @if($singleorderrow->o_status==3)
                                                    Design Confirm
                                                 @endif
                                                 @if($singleorderrow->o_status==4)
                                                    Printing
                                                 @endif
                                                 @if($singleorderrow->o_status==5)
                                                    Waiting for Tailor
                                                 @endif
                                                 @if($singleorderrow->o_status==6)
                                                    Sewing
                                                 @endif
                                                 @if($singleorderrow->o_status==7)
                                                    Deliver
                                                 @endif
                                                 @if($singleorderrow->o_status==8)
                                                    Reprint
                                                 @endif
                                                 @if($singleorderrow->o_status==9)
                                                    Completed
                                                 @endif
                                                 @if($singleorderrow->o_status==10)
                                                    Customer Request Design
                                                 @endif
                                                 @if($singleorderrow->o_status==0)
                                                    Draft
                                                 @endif    
                                            </td>
                                        </tr>
                                        <?php $no++; ?>
                                  @endforeach
                                  
                                </tbody>
                            </table>
                            
                        @else
                            <p>No order found</p>
                        @endif
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                    <div class="card-header">Pending List</div>
    
                    <div class="card-body">
    
                        <div class="panel-body">
    
                            @if(count($orderspending) > 0)
    
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                      <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Cloth Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Designer Note</th>
                                        <th scope="col">Design</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; ?>
                                        @foreach($orderspending as $singleorderpendingrow)
                                            <tr>
                                                
                                                <th scope="row"><?php echo $no; ?></th>
                                                <td>{{$singleorderpendingrow->file_name}}</td>
                                                <td>{{$singleorderpendingrow->quantity_total}}</td>
                                                <td>{{$singleorderpendingrow->category}}</td>
                                                <td>{{$singleorderpendingrow->designer_note}}</td>
                                                <td><a href="/customer/viewdesign/{{$singleorderpendingrow->o_id}}">View Design</a></td>
                                                <td>
                                                    
                                                    {!!Form::open( array( 'route'=>'customer.orderlist', $singleorderpendingrow->o_id, 'method' => 'POST') )!!}
                                                        <input type="hidden" name="orderid" value="{{$singleorderpendingrow->o_id}}">
                                                        <input type="submit" style="display: inline-block;" name="confirmbutton" value="Confirm" class="btn btn-primary">
                                            
                                                    {!!Form::close()!!}
                                                    <button 
                                                        class="btn btn-primary edit" data-toggle="modal" style="display: inline-block;" data-target="#Modal" data-tittle="Request" 
                                                        data-oid="{{$singleorderpendingrow->o_id}}" data-uid="{{$singleorderpendingrow->u_id_designer}}">Request
                                                    </button> 

                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                      @endforeach
                                      
                                    </tbody>
                                </table>
                                
                            @else
                                <p>No pending order</p>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <form enctype="multipart/form-data" method="POST" id="designform" name="designform" action="{{ route('customer.orderlist') }}">
                  @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Request Redesign</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                            <div class="form-group row">
                            <label for="note" class="col-sm-4 col-form-label">Note</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="note" name="note" >
                                <input type="hidden" name="u_id" id="uid">
                                <input type="hidden" name="o_id" id="oid">
                            </div>
                            </div> 
            
                            <div class="form-group row" id="neckdiv">
                            <label for="design" class="col-sm-4 col-form-label">Mockup</label>
                            <div class="col-sm-8">
                                <input id="design" type="file" class="form-control" name="design">
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

<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
$(document).on("click", ".edit", function () {
     var name = $(this).data('tittle');
     var oid = $(this).data('oid');
     var uid = $(this).data('uid');
     $(".modal-title").text( name );
     $(".modal-body #oid").val( oid );
     $(".modal-body #uid").val( uid );
     $(".modal-body #note").val( "" );

});

  function validateForm() {
    var x = document.forms["designform"]["design"].value;
        // if (x == "") 
        // {
        // //alert("Please insert image");
        // //return false;
        // }
        // else
        // {
        //   document.getElementById("designform").submit();  
        // }
        document.getElementById("designform").submit();         
    }
</script>

@endsection

<style>
    form {    
        display: inline;
    }
</style>
