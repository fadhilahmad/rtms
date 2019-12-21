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
                <div class="card-header">Manage Stock</div>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                <div class="card-body">
                            <center><h2>MATERIAL</h2></center><br>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Description</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($material as $mat)
                                  <tr>
                                    <td>{{$mat->m_desc}}</td>
                                    <td>{{$mat->m_stock}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary add" data-toggle="modal" data-target="#stockModal" data-tittle="Add Stock" data-operator="add"
                                            data-id="{{$mat->m_id}}" data-oldstock="{{$mat->m_stock}}" data-material="{{$mat->m_desc}}">+
                                        </button>
                                        |
                                        <button 
                                            class="btn btn-danger add" data-toggle="modal" data-target="#stockModal" data-tittle="Reduce Stock" data-operator="minus"
                                            data-id="{{$mat->m_id}}" data-oldstock="{{$mat->m_stock}}" data-material="{{$mat->m_desc}}">-
                                        </button>                                        
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>  
                </div>
            </div>
            <div class="card">
                <div class="card-header">Manage Inventory <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#inventoryModal" >Add Inventory</button></div>
                    @if(session()->has('imessage'))
                        <div class="alert alert-success">
                            {{ session()->get('imessage') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <center><h2>INVENTORY</h2></center><br>
                        @if(!$stocks->isempty())
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($stocks as $stock)
                                  <tr>
                                    <td>{{$stock->item}}</td>
                                    <td>{{$stock->st_quantity}}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary addInventory" data-toggle="modal" data-target="#operationModal" data-tittle="Add Inventory Stock" data-operator="plusinventory"
                                            data-id="{{$stock->st_id}}" data-oldstock="{{$stock->st_quantity}}" data-item="{{$stock->item}}">+
                                        </button>
                                        |
                                        <button 
                                            class="btn btn-danger addInventory" data-toggle="modal" data-target="#operationModal" data-tittle="Reduce Inventory Stock" data-operator="minusinventory"
                                            data-id="{{$stock->st_id}}" data-oldstock="{{$stock->st_quantity}}" data-item="{{$stock->item}}">-
                                        </button>                                        
                                    </td>
                                    <td>
                                        <form action="{{ route('manage_stock') }}" method="POST">{{ csrf_field() }}
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure to delete this inventory?')" ><i class="fa fa-trash"></i></button>
                                            <input type="hidden" name="st_id" value=" {{$stock->st_id}}">
                                            <input type="hidden" name="operator" value="deleteinventory">                                  
                                        </form>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        @else
                        No inventory records
                        @endif
                    </div>
                        
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="stockform" name="stockform" action="{{ route('manage_stock') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Manage Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Material</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="materials" name="materials" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Current Stock</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="oldstock" name="oldstock" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="newstock" class="col-sm-4 col-form-label">Value</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="value" name="value" required="required" >
                    <input type="hidden" name="m_id" id="mid">
                    <input type="hidden" name="oldvalue" id="oldvalue">
                    <input type="hidden" name="operator" id="operator">
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

<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="inventoryform" name="inventoryform" action="{{ route('manage_stock') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" >Add Inventory</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="item" class="col-sm-4 col-form-label">Item</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="item" name="item" >
                    <input type="hidden" name="operator" value="newinventory">
                </div>
              </div>
          
              <div class="form-group row">
                <label for="description" class="col-sm-4 col-form-label">Current Quantity</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="quantity" name="quantity" >
                </div>
              </div>        
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="inventoryForm()" type="submit" class="btn btn-primary">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<div class="modal fade" id="operationModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="operationform" name="operationform" action="{{ route('manage_stock') }}">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="operationTitle">Inventory Operation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="form-group row">
                <label for="item" class="col-sm-4 col-form-label">Item</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="updateItem" name="item" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="quantity" class="col-sm-4 col-form-label">Current Stock</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="inventoryQuantity" name="inventoryQuantity" disabled="" >
                </div>
              </div>
          
              <div class="form-group row">
                <label for="newstock" class="col-sm-4 col-form-label">Value</label>
                <div class="col-sm-8">
                    <input type="number" min="0" class="form-control" id="ivalue" name="value" required="required" >
                    <input type="hidden" name="st_id" id="stid">
                    <input type="hidden" name="oldvalue" id="oldInventoryvalue">
                    <input type="hidden" name="operator" id="operators">
                </div>
              </div>         
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="operationForm()" type="submit" class="btn btn-primary">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on("click", ".add", function () {
     var name = $(this).data('tittle');
     var pricename = $(this).data('name');
     var mid = $(this).data('id');
     var operator = $(this).data('operator');
     var oldstock = $(this).data('oldstock');
     var material = $(this).data('material');
     
     $("#modalTitle").text( name );
     $(".modal-body #priceName").val( pricename );
     $(".modal-body #oldstock").val( oldstock );
     $(".modal-body #oldvalue").val( oldstock );
     $(".modal-body #operator").val( operator );
     $(".modal-body #materials").val( material );
     $(".modal-body #mid").val( mid );
     $(".modal-body #value").val( "" );

});

$(document).on("click", ".addInventory", function () {
     var name = $(this).data('tittle');
     var item = $(this).data('item');
     var stid = $(this).data('id');
     var operator = $(this).data('operator');
     var oldstock = $(this).data('oldstock');
     
     $("#operationTitle").text( name );
     $(".modal-body #inventoryQuantity").val( oldstock );
     $(".modal-body #updateItem").val( item );
     $(".modal-body #oldInventoryvalue").val( oldstock );
     $(".modal-body #stid").val( stid );
     $(".modal-body #operators").val( operator );
     $(".modal-body #ivalue").val( "" );

});
  
  function validateForm() {
    var x = document.forms["stockform"]["value"].value;
        if (x == "") 
        {
        alert("Value must be filled out");
        return false;
        }
        else
        {
          document.getElementById("stockform").submit();  
        }       
    }
    
  function inventoryForm() {
    var x = document.forms["inventoryform"]["item"].value;
    var y = document.forms["inventoryform"]["quantity"].value;
        if (x == "") 
        {
        alert("Item field must be filled out");
        return false;
        }
        if (y == "") 
        {
        alert("Quantity field must be filled out");
        return false;
        }
        else
        {
          document.getElementById("inventoryform").submit();  
        }       
    }
    
  function operationForm() {
    var x = document.forms["operationform"]["value"].value;
        if (x == "") 
        {
        alert("Value field must be filled out");
        return false;
        }
        else
        {
          document.getElementById("operationform").submit();  
        }       
    }
</script>
@endsection
