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
form, form updatenote { display: inline; }
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
                                        <div class="col-sm-3">Remark</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order->note}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Note</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-6">
                                            @if($notes->isempty())
                                            No note 
                                            @endif
                                        </div>
                                        <div class="col-sm-2"><button class="add" data-toggle="modal" data-target="#noteModal" data-title="Add Note" data-oid="{{$order->o_id}}" data-operation="addnote" >Add Note</button></div>
                                    </div><br>
                                    
                                    @if(!$notes->isempty())
                                    <div class="row">
                                        <table class="table table-hover table-bordered">
                                        <thead class="thead-dark">
                                          <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Note</th>
                                            <th scope="col">By</th>                                         
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($notes as $note)
                                            <tr>
                                                <td>{{date('d/m/Y', strtotime($note->created_at))}}</td>
                                                <td class="text-nowrap"> 
                                                    {{$note->note}} &nbsp;
                                                    @if($note->u_id == Auth::id())
                                                    <button class="updatenote" data-toggle="modal" data-target="#noteModal" data-title="Update Note" data-nid="{{$note->note_id}}" data-oid="{{$order->o_id}}" data-note="{{$note->note}}" data-operation="updatenote"><i class="fa fa-edit"></i></button>
                                                        <form action="{{route('update.design')}}" method="POST">{{ csrf_field() }}
                                                            <button  type="submit" onclick="return confirm('Are you sure to delete this note?')" ><i class="fa fa-trash"></i></button>
                                                            <input type="hidden" name="note_id" value=" {{$note->note_id}}">
                                                            <input type="hidden" name="process" value="deletenote">
                                                        </form>
                                                    @endif                                               
                                                </td>
                                                <td>
                                                    @php
                                                    $username = $user->where('u_id',$note->u_id)->pluck('username')->first();
                                                    @endphp
                                                    {{$username}}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                    @endif
                            
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
                                            <th scope="col">Quantity</th>
                                            <th scope="col" colspan="2">Sewed</th>
                                            <th scope="col">Request Reprint</th>
                                            <th scope="col" colspan="2">Delivered</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              <td>{{$unit->un_quantity}}</td>
                                              <td>{{$unit->sewed}}</td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
                                                  x
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('sewed')->first() < $units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('un_quantity')->first())
                                                  <button 
                                                        class="btn btn-primary upd" data-toggle="modal" data-target="#updateModal" data-uid="{{Auth::id()}}" data-name="{{$unit->name}}" data-size="{{$unit->size}}" data-sewed="{{$unit->sewed}}"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}" data-refnum="{{$order->ref_num}}"  data-maxquan="{{$unit->un_quantity}}" data-category="Size">Update
                                                  </button>
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
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','4')->count()>0)
                                                  <input type="checkbox" name="jobdone" value="" disabled="">
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
                                                  Requested 
                                                  @endif
                                              </td>
                                              <td>{{$unit->delivered}}</td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('un_quantity')->first() == $units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('delivered')->first())
                                                  <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('sewed')->first() == $units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('delivered')->first())
                                                  x
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('delivered')->first() < $units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('un_quantity')->first())
                                                  <button 
                                                        class="btn btn-primary deliver" data-toggle="modal" data-target="#deliveryModal" data-uid="{{Auth::id()}}" data-name="{{$unit->name}}" data-size="{{$unit->size}}" data-sewed="{{$unit->delivered}}"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}" data-refnum="{{$order->ref_num}}"  data-maxquan="{{$unit->un_quantity}}" data-category="Size">Update
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
                                            <th scope="col">Quantity</th>
                                            <th scope="col" colspan="2">Sewed</th>
                                            <th scope="col">Request Reprint</th>
                                            <th scope="col" colspan="2">Delivered</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                    
                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                           <tr>
                                              <td>{{$unit->name}}</td>
                                              <td style="text-transform: uppercase;">{{$unit->size}}</td>
                                              <td>{{$unit->un_quantity}}</td>
                                              <td>{{$unit->sewed}}</td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
                                                  x
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('sewed')->first() < $units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('un_quantity')->first())
                                                  <button 
                                                        class="btn btn-primary upd" data-toggle="modal" data-target="#updateModal" data-uid="{{Auth::id()}}" data-name="{{$unit->name}}" data-size="{{$unit->size}}" data-sewed="{{$unit->sewed}}"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}" data-refnum="{{$order->ref_num}}"  data-maxquan="{{$unit->un_quantity}}" data-category="Nameset">Update
                                                  </button>
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
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','4')->count()>0)
                                                  <input type="checkbox" name="jobdone" value="" disabled="">
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->where('un_status','5')->count()>0)
                                                  Requested 
                                                  @endif
                                              </td>
                                              <td>{{$unit->delivered}}</td>
                                              <td>
                                                  @if($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('un_quantity')->first() == $units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('delivered')->first())
                                                  <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('sewed')->first() == $units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('delivered')->first())
                                                  x
                                                  @elseif($units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('delivered')->first() < $units->where('o_id',$spec->o_id)->where('un_id',$unit->un_id)->pluck('un_quantity')->first())
                                                  <button 
                                                        class="btn btn-primary deliver" data-toggle="modal" data-target="#deliveryModal" data-uid="{{Auth::id()}}" data-name="{{$unit->name}}" data-size="{{$unit->size}}" data-sewed="{{$unit->delivered}}"
                                                        data-oid="{{$unit->o_id}}" data-unid="{{$unit->un_id}}" data-refnum="{{$order->ref_num}}"  data-maxquan="{{$unit->un_quantity}}" data-category="Nameset">Update
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
                            $completed =  $units->where('o_id',$spec->o_id)->where('un_status','4')->count()
                            @endphp
                            
                            @endforeach       
                                                      
                             <br><br>
                            @if($no==$completed)
                            <form method="post" action="{{route('update.sew')}}">@csrf
                             <input type="hidden" name="process" value="complete">
                             <input type="hidden" name="o_id" value="{{$order->o_id}}">
                             <center><button type="submit" class="btn btn-primary edit" >Complete Order</button></center>                                         
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
          
             <div class="form-group row reprintNote">
                <label for="description" class="col-sm-4 col-form-label">Reprint Note</label>
                <div class="col-sm-8">
                    <textarea id="reprintnote" name="reprint_note" rows="4" cols="30" ></textarea>
                    <input type="hidden" name="uid" value="{{Auth::id()}}">
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

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="updateForm" name="updateForm">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Update Job</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Order Ref Num</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="refnums" name="refnums" value="" disabled="" >
                </div>
              </div>
          
              <div class="form-group row namediv">
                <label for="description" class="col-sm-4 col-form-label">Name/Number</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="names" name="names" value="" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Size</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="sizes" name="sizes" value="" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Quantity Sewed</label>
                <div class="col-sm-8">
                    <input type="number" min="1" class="form-control" id="quantitys" name="quantitys" >
                    <input type="hidden" id="oids" name="oids">
                    <input type="hidden" id="unids" name="unids">
                    <input type="hidden" id="processs" name="process_res" value="update">
                    <input type="hidden" id="unQuan" name="un_quan">
                    <input type="hidden" id="sewed" name="sewed">
                    <input type="hidden" id="uidtailor" name="u_id">
                </div>
              </div>        
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary updateSew">Confirm</button>
      </div>
     </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="deliveryForm" name="deliveryForm">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Update Delivery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Order Ref Num</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="drefnums" name="drefnums" value="" disabled="" >
                </div>
              </div>
          
              <div class="form-group row namediv">
                <label for="description" class="col-sm-4 col-form-label">Name/Number</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="dnames" name="dnames" value="" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Size</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="dsizes" name="dsizes" value="" disabled="" >
                </div>
              </div>
                   
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Quantity Delivered</label>
                <div class="col-sm-8">
                    <input type="number" min="1" class="form-control" id="dquantitys" name="dquantitys" >
                    <input type="hidden" id="doids" name="doids">
                    <input type="hidden" id="dunids" name="dunids">
                    <input type="hidden" id="dprocesss" name="dprocess_res" value="delivery">
                    <input type="hidden" id="dunQuan" name="dun_quan">
                    <input type="hidden" id="dsewed" name="dsewed">
                    <input type="hidden" id="duidtailor" name="du_id">
                </div>
              </div>        
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary updateDelivery">Confirm</button>
      </div>
     </form>
    </div>
  </div>
</div>

<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="noteform" name="noteform" action="{{route('update.design')}}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="noteTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <div class="form-group row">
                <label for="note" class="col-sm-2 col-form-label">Note</label>
                <div class="col-sm-10">
                    <textarea id="note" name="note" rows="4" cols="40" ></textarea>
                    <input type="hidden" name="uid" value="{{Auth::id()}}">
                    <input type="hidden" name="oid" id="oId">
                    <input type="hidden" name="note_id" id="noteId">
                    <input type="hidden" name="process" id="process">
                </div>
              </div>        
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="validateForm()" type="submit" class="btn btn-primary btn-submit">Save</button>
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

$(document).on("click", ".upd", function () {
     var oid = $(this).data('oid');
     var unid = $(this).data('unid');
     var refnum = $(this).data('refnum');
     var category = $(this).data('category');
     var name = $(this).data('name');
     var size = $(this).data('size');
     var uid = $(this).data('uid');
     var sewed = $(this).data('sewed');
     var maxquan = $(this).data('maxquan');
     var res = size.toUpperCase();
     
     var max = maxquan-sewed;
     
     document.getElementById('quantitys').setAttribute("max", max);

     $(".modal-body #refnums").val( refnum );
     $(".modal-body #oids").val( oid );
     $(".modal-body #unids").val( unid );
     $(".modal-body #names").val( name );
     $(".modal-body #sizes").val( res );
     $(".modal-body #unQuan").val( maxquan );
     $(".modal-body #uidtailor").val( uid );
     $(".modal-body #sewed").val( sewed );
     $(".modal-body #quantitys").val( '1' );
     
     if(category==="Size"){
         $(".modal-body .namediv").hide();
     }
     if(category==="Nameset"){
         $(".modal-body .namediv").show();
     }

});

$(document).on("click", ".deliver", function () {
     var oid = $(this).data('oid');
     var unid = $(this).data('unid');
     var refnum = $(this).data('refnum');
     var category = $(this).data('category');
     var name = $(this).data('name');
     var size = $(this).data('size');
     var uid = $(this).data('uid');
     var sewed = $(this).data('sewed');
     var maxquan = $(this).data('maxquan');
     var res = size.toUpperCase();
     
     var max = maxquan-sewed;
     
     document.getElementById('dquantitys').setAttribute("max", max);

     $(".modal-body #drefnums").val( refnum );
     $(".modal-body #doids").val( oid );
     $(".modal-body #dunids").val( unid );
     $(".modal-body #dnames").val( name );
     $(".modal-body #dsizes").val( res );
     $(".modal-body #dunQuan").val( maxquan );
     $(".modal-body #duidtailor").val( uid );
     $(".modal-body #dsewed").val( sewed );
     $(".modal-body #dquantitys").val( '1' );
     
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

    $(".updateSew").click(function(e){
        e.preventDefault();
        
        var quantity = $('input[name=un_quan]').val();
        var sewed = $('input[name=sewed]').val();
        var balance = quantity - sewed;
        var check = $('input[name=quantitys]').val();

        var x = document.forms["updateForm"]["quantitys"].value;
        if (x == "") 
        {
            alert("Quantity value must be filled out");
            return false;
        }
        if(+check > +balance){
            alert("Quantity sewed exceed limit !!!");
            return false;
        }else{
        var formData = {
            'un_id'   : $('input[name=unids]').val(),
            'o_id'   : $('input[name=oids]').val(),
            'quantity'    : $('input[name=quantitys]').val(),
            'u_id'    : $('input[name=u_id]').val(),
            'process'   : $('input[name=process_res]').val()
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
        }
    });
    
    $(".updateDelivery").click(function(e){
        e.preventDefault();
        
        var quantity = $('input[name=dun_quan]').val();
        var sewed = $('input[name=dsewed]').val();
        var balance = quantity - sewed;
        var check = $('input[name=dquantitys]').val();

        var x = document.forms["deliveryForm"]["dquantitys"].value;
        if (x == "") 
        {
            alert("Quantity value must be filled out");
            return false;
        }
        if(+check > +balance){
            alert("Quantity delivered exceed limit !!!");
            return false;
        }else{
        var formData = {
            'un_id'   : $('input[name=dunids]').val(),
            'o_id'   : $('input[name=doids]').val(),
            'quantity'    : $('input[name=dquantitys]').val(),
            'u_id'    : $('input[name=du_id]').val(),
            'process'   : $('input[name=dprocess_res]').val()
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
        }
    });
    
    $(".submits").click(function(e){
        e.preventDefault();
       
       var x = document.forms["form"]["quantity"].value;
       var y = document.forms["form"]["reprint_note"].value;
        if (x == "") 
        {
            alert("Quantity value must be filled out");
            return false;
        }
        if(y == "")
        {
          alert("Reprint note must be filled out");
            return false;
        }else{
        var formData = {
            'un_id'   : $('input[name=unid]').val(),
            'o_id'   : $('input[name=oid]').val(),
            'quantity'    : $('input[name=quantity]').val(),
            'process'   : $('input[name=process_re]').val(),
            'uid' : $('input[name=uid]').val(),
            'reprint_note' : $('textarea[name=reprint_note]').val()
        };
//console.log(formData);
        $.ajax({
           type:'POST',
           url:"{{url('department/job_sew')}}",
           data:formData,
           success:function(data){
               location.reload();
               //location.href = "{{url('department/joblist')}}";
           }
        });
       }
      
    });
    
 $(document).on("click", ".add", function () {
     var name = $(this).data('title');
     var oid = $(this).data('oid');
     var ops = $(this).data('operation');
     
     $("#noteTitle").text( name );
     $(".modal-body #oId").val( oid );
     $(".modal-body #process").val( ops );
     $(".modal-body #note").val("");

}); 

  $(document).on("click", ".updatenote", function () {
     var name = $(this).data('title');
     var oid = $(this).data('oid');
     var ops = $(this).data('operation');
     var note = $(this).data('note');
     var nid = $(this).data('nid');
     
     $("#noteTitle").text( name );
     $(".modal-body #oId").val( oid );
     $(".modal-body #process").val( ops );
     $(".modal-body #note").val( note );
     $(".modal-body #noteId").val( nid );

}); 

function validateForm() {
    var x = document.forms["noteform"]["note"].value;
        if (x == "") 
        {
        alert("Note must be filled out");
        return false;
        }
        else
        {
          document.getElementById("noteform").submit();  
        }       
    }
    
    function validateOrder() {
      document.getElementById("orderform").submit();        
    }   
</script>
@endsection
