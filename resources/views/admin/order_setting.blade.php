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
.modal-open {
    overflow: scroll;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-gear"></i> Order Setting</div>

                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                        <div style="margin: 0px 50px 0px;"><h2>MATERIAL <a href="" class="popup btn btn-secondary float-right" data-toggle="modal" data-target="#orderModal" data-tittle="Add Material" data-table="material" ><i class="fa fa-plus"></i> New</a></h2></div><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Description</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($material as $mat)
                                  <tr>
                                    <td>{{$mat->m_desc}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Material" data-table="material"
                                            data-id="{{$mat->m_id}}" data-desc="{{$mat->m_desc}}"><i class="fa fa-edit"></i>
                                        </button>                                       
                                    </td>
                                    <td>
                                     <form class="delete" action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this material?')" value="X"><i class="fa fa-trash"></i></button>
                                        <input type="hidden" name="id" value=" {{$mat->m_id}}">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="table" value="material">                                   
                                    </form>                                      
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>                                                                         
                        </div>
                        
                        <div class="col-md-6">
                            <div style="margin: 0px 50px 0px;"><h2>BODY <a href="" class="popup btn btn-secondary float-right" data-toggle="modal" data-target="#orderModal" data-tittle="Add Body Type" data-table="body"><i class="fa fa-plus"></i> Body Type</a></h2></div><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Description</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($body as $bod)
                                  <tr>
                                    <td>{{$bod->b_desc}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Body Type" data-table="body"
                                            data-id="{{$bod->b_id}}" data-desc="{{$bod->b_desc}}"><i class="fa fa-edit"></i>
                                        </button>                                   
                                    </td>
                                    <td>
                                     <form class="delete" action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this body type?')" value="X"><i class="fa fa-trash"></i></button>                         
                                        <input type="hidden" name="id" value=" {{$bod->b_id}}">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="table" value="body">                                   
                                    </form>                                      
                                    </td>                                    
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>                                                                         
                        </div>
                        
                    </div>
                    
                    <hr>
                    <br><br>
                    
                    @if($delivery)
                    <div class="row">
                        <div class="col-md-6">
                            <center><h2>DELIVERY DAY</h2></center><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Minimum Day</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>

                                  <tr>
                                    <td>{{$delivery->min_day}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Delivery Day" data-table="delivery" 
                                            data-id="{{$delivery->ds_id}}" data-desc="{{$delivery->min_day}}"><i class="fa fa-edit"></i> Edit
                                        </button>                                   
                                    </td>
                                  </tr>
                                </tbody>
                            </table>                                                                         
                        </div>
                        @endif
                                           
                        <div class="col-md-6">
                            <center><h2>SLEEVE</h2></center><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col" >Description</th>
                                    <th scope="col" >Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($sleeve as $sle)
                                  <tr>
                                    <td>{{$sle->sl_desc}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Sleeve" data-table="sleeve" 
                                            data-id="{{$sle->sl_id}}" data-desc="{{$sle->sl_desc}}"><i class="fa fa-edit"></i> Edit
                                        </button>                                   
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>                                                                         
                        </div>                       
                    </div>
                    
                    <hr>
                    <br><br>
                    
                    @if($delivery)
                    <div class="row">
                        <div class="col-md-6">
                            <center><h2>BLOCK DELIVERY DAY</h2></center><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Day</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>

                                  <tr>
                                    <td>Sunday</td>
                                    <td>
                                        @php
                                        $check_day = $block_day->where('day',0)->first();
                                        @endphp
                                        @if($check_day->bd_status == '1')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to unblock this day?')"><i class="fa fa-calendar-check-o"></i> Unblock</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="0">
                                        </form>
                                        @endif
                                        @if($check_day['bd_status'] == '0')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to block this day?')" ><i class="fa fa-ban"></i> Block</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="1">
                                        </form>
                                        @endif
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Monday</td>
                                    <td>
                                        @php
                                        $check_day = $block_day->where('day',1)->first();
                                        @endphp
                                        @if($check_day->bd_status == '1')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to unblock this day?')"><i class="fa fa-calendar-check-o"></i> Unblock</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="0">
                                        </form>
                                        @endif
                                        @if($check_day['bd_status'] == '0')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to block this day?')" ><i class="fa fa-ban"></i> Block</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="1">
                                        </form>
                                        @endif
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Tuesday</td>
                                    <td>
                                        @php
                                        $check_day = $block_day->where('day',2)->first();
                                        @endphp
                                        @if($check_day->bd_status == '1')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to unblock this day?')"><i class="fa fa-calendar-check-o"></i> Unblock</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="0">
                                        </form>
                                        @endif
                                        @if($check_day['bd_status'] == '0')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to block this day?')" ><i class="fa fa-ban"></i> Block</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="1">
                                        </form>
                                        @endif
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Wednesday</td>
                                    <td>
                                        @php
                                        $check_day = $block_day->where('day',3)->first();
                                        @endphp
                                        @if($check_day->bd_status == '1')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to unblock this day?')"><i class="fa fa-calendar-check-o"></i> Unblock</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="0">
                                        </form>
                                        @endif
                                        @if($check_day['bd_status'] == '0')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to block this day?')" ><i class="fa fa-ban"></i> Block</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="1">
                                        </form>
                                        @endif
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Thursday</td>
                                    <td>
                                        @php
                                        $check_day = $block_day->where('day',4)->first();
                                        @endphp
                                        @if($check_day->bd_status == '1')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to unblock this day?')"><i class="fa fa-calendar-check-o"></i> Unblock</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="0">
                                        </form>
                                        @endif
                                        @if($check_day['bd_status'] == '0')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to block this day?')" ><i class="fa fa-ban"></i> Block</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="1">
                                        </form>
                                        @endif
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Friday</td>
                                    <td>
                                        @php
                                        $check_day = $block_day->where('day',5)->first();
                                        @endphp
                                        @if($check_day->bd_status == '1')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to unblock this day?')"><i class="fa fa-calendar-check-o"></i> Unblock</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="0">
                                        </form>
                                        @endif
                                        @if($check_day['bd_status'] == '0')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to block this day?')" ><i class="fa fa-ban"></i> Block</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="1">
                                        </form>
                                        @endif
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Saturday</td>
                                    <td>
                                        @php
                                        $check_day = $block_day->where('day',6)->first();
                                        @endphp
                                        @if($check_day->bd_status == '1')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure to unblock this day?')"><i class="fa fa-calendar-check-o"></i> Unblock</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="0">
                                        </form>
                                        @endif
                                        @if($check_day['bd_status'] == '0')
                                        <form action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to block this day?')" ><i class="fa fa-ban"></i> Block</button>                         
                                            <input type="hidden" name="id" value=" {{$check_day->bd_id}}">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="table" value="block_day">
                                            <input type="hidden" name="status" value="1">
                                        </form>
                                        @endif
                                    </td>
                                  </tr>
                                </tbody>
                            </table>                                                                         
                        </div>
                        @endif
                                           
                        <div class="col-md-6">
                        <div style="margin: 0px 50px 0px;"><h2>BLOCK DELIVERY DATE <a href="" class="blockpopup btn btn-secondary float-right" data-toggle="modal" data-target="#blockdateModal" data-tittle="Add Block Date" data-table="block_date" ><i class="fa fa-plus"></i> New</a></h2></div><br>
                            @if(!$block_date->isempty())
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col" >Date</th>
                                    <th scope="col" >Remark</th>
                                    <th scope="col" >Edit</th>
                                    <th scope="col" >Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($block_date as $block)
                                  <tr>
                                    <td>{{$block->date}}</td>
                                    <td>{{$block->remark}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary blockedit" data-toggle="modal" data-target="#blockdateModal" data-tittle="Update Block Date" data-table="block_date" 
                                            data-id="{{$block->bdt_id}}" data-date="{{$block->date}}" data-remark="{{$block->remark}}"><i class="fa fa-edit"></i>
                                        </button>                                   
                                    </td>
                                    <td>
                                        <form class="delete" action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this date?')" ><i class="fa fa-trash"></i></button>                         
                                            <input type="hidden" name="id" value=" {{$block->bdt_id}}">
                                            <input type="hidden" name="type" value="delete">
                                            <input type="hidden" name="table" value="block_date">                                   
                                        </form>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            @else
                            <center>No blocked date</center>
                            @endif
                        </div>                       
                    </div>
                    
                    <hr>
                    <br><br>
                        <div class="col-md-12">
                            <div style="margin: 0px 150px 0px;"><h2>NECK <a href="" class="popup btn btn-secondary float-right" data-toggle="modal" data-target="#orderModal" data-tittle="Add Neck Type" data-table="neck"><i class="fa fa-plus"></i> Neck Type</a></h2></div><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Description</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($neck as $nec)
                                  <tr>
                                    <td>{{$nec->n_desc}}</td>
                                    @php if($nec->n_type==2){$dis = "Roundneck";}elseif($nec->n_type==1){$dis = "Collar";}else{$dis="error";}@endphp
                                    <td>{{$dis}}</td>
                                    <td><img class="" src="{{url('uploads/'.$nec->n_url)}}" width="100" height="100"></td>
                                    <td>
                                        <button 
                                            class="btn btn-primary edit" data-toggle="modal" data-target="#orderModal" data-tittle="Update Neck" data-table="neck" 
                                            data-id="{{$nec->n_id}}" data-necktype="{{$nec->n_type}}" data-desc="{{$nec->n_desc}}"><i class="fa fa-edit"></i>
                                        </button>                                   
                                    </td>
                                    <td>
                                     <form class="delete" action="{{route('order_setting')}}" method="POST">{{ csrf_field() }}
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this neck type?')" value="X"><i class="fa fa-trash"></i></button>
                                        <input type="hidden" name="id" value=" {{$nec->n_id}}">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="table" value="neck">                                   
                                    </form>                                      
                                    </td>                                    
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>                                                                         
                        </div>
                                      
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form enctype="multipart/form-data" method="POST" id="orderform" name="orderform" action="{{ route('order_setting') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Order Setting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Description</label>
                <div class="col-sm-8">
                    <input type="text" min="0" class="form-control" id="description" name="description" required="required" >
                    <input type="hidden" name="id" id="itemId">
                    <input type="hidden" name="type" id="type">
                    <input type="hidden" name="table" id="table">
                </div>
              </div> 

              <div class="form-group row" id="necktype">
                <label for="necktype" class="col-sm-4 col-form-label">Neck Type</label>
                <div class="col-sm-8" id="neck">
                    <input type="radio" id="n1" name="necktype" value="1"> Collar<br>
                    <input type="radio" id="n2" name="necktype" value="2"> Roundneck<br>
                </div>
              </div> 
          
              <div class="form-group row" id="neckdiv">
                <label for="neck_image" class="col-sm-4 col-form-label">Neck Image</label>
                <div class="col-sm-8">
                    <input id="neck_image" type="file" class="form-control" name="neck_image">
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

<div class="modal fade" id="blockdateModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="blockform" name="blockform" action="{{ route('order_setting') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Block Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
              <div class="form-group row">
                <label for="date" class="col-sm-4 col-form-label">Date</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" id="date" name="date" required="required" >
                    <input type="hidden" name="id" id="itemId">
                    <input type="hidden" name="type" id="type">
                    <input type="hidden" name="table" id="table">
                </div>
              </div> 

              <div class="form-group row">
                <label for="remark" class="col-sm-4 col-form-label">Remark</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="remark" name="remark" >
                </div>
              </div>         
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="submitForm()" type="submit" class="btn btn-primary">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on("click", ".popup", function () {
     var name = $(this).data('tittle');
     var table = $(this).data('table');
     $(".modal-title").text( name );
     $(".modal-body #description").val( "" );
     $(".modal-body #type").val( "add" );
     $(".modal-body #table").val( table );
     $(".modal-body #neckdiv").hide();
     $(".modal-body #necktype").hide();
     document.getElementById('description').type = 'text';
     
     if(table=="neck"){
         $(".modal-body #neckdiv").show();
         $(".modal-body #necktype").show();
        radiobtn = document.getElementById("n1");
        radiobtn.checked = true;
     }
//     console.log(table);
});

$(document).on("click", ".blockpopup", function () {
     var name = $(this).data('tittle');
     var table = $(this).data('table');
     $(".modal-title").text( name );
     $(".modal-body #remark").val( "" );
     $(".modal-body #type").val( "add" );
     $(".modal-body #table").val( table );
 
//     console.log(table);
});

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
     $(".modal-body #necktype").hide();
     
     if(table=="neck"){
         var neck = $(this).data('necktype');
         $(".modal-body #necktype").show();
         
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
//     console.log(table);
});

$(document).on("click", ".blockedit", function () {
     var name = $(this).data('tittle');
     var id = $(this).data('id');
     var desc = $(this).data('remark');
     var date = $(this).data('date');
     var table = $(this).data('table');
     $(".modal-title").text( name );
     $(".modal-body #remark").val( desc );
     $(".modal-body #date").val( date );
     $(".modal-body #type").val( "update" );
     $(".modal-body #itemId").val( id );
     $(".modal-body #table").val( table );
});
  
  function validateForm() {
    var x = document.forms["orderform"]["description"].value;
        if (x == "") 
        {
        alert("Description must be filled out");
        return false;
        }
        else
        {
          document.getElementById("orderform").submit();  
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
    
// $.ajaxSetup({
//        headers: {
//            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//        }
//    });
//
//    $(".btn-submit").click(function(e){
//        e.preventDefault();
//
//        var x = document.forms["orderform"]["description"].value;
//        if (x == "") 
//        {
//            alert("Description must be filled out");
//            return false;
//        }
//
//        var formData = {
//            'description'   : $('.modal-body input[name=description]').val(),
//            'id'   : $('.modal-body input[name=id]').val(),
//            'type'    : $('.modal-body input[name=type]').val(),
//            'table'   : $('.modal-body input[name=table]').val(),
//            'necktype'   : $('.modal-body input[name=necktype]').val(),
//            'neck_image'    : $('.modal-body input[name=necktype_image]').val()
//        };
//
//        $.ajax({
//           type:'POST',
//           url:"{{url('admin/order_setting')}}",
//           data:formData,
//           success:function(data){
//              $('#orderModal').modal('hide');
//                    location.reload();
//           }
//        });
//
//    });
</script>
@endsection
