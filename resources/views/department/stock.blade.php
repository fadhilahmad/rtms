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
<!--                                        <button 
                                            class="btn btn-primary add" data-toggle="modal" data-target="#stockModal" data-tittle="Add Stock" data-operator="add"
                                            data-id="{{--$mat->m_id--}}" data-oldstock="{{--$mat->m_stock--}}" data-material="{{--$mat->m_desc--}}">+
                                        </button>
                                        |-->
                                        <button 
                                            class="btn btn-primary add" data-toggle="modal" data-target="#stockModal" data-tittle="Reduce Stock" data-operator="minus"
                                            data-id="{{$mat->m_id}}" data-oldstock="{{$mat->m_stock}}" data-material="{{$mat->m_desc}}">Update Stock
                                        </button>                                        
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

<div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form method="POST" id="stockform" name="stockform" action="{{ route('department.updatestock') }}">
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
                <label for="newstock" class="col-sm-4 col-form-label">Amount Used</label>
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

<script type="text/javascript">
$(document).on("click", ".add", function () {
     var name = $(this).data('tittle');
     var pricename = $(this).data('name');
     var mid = $(this).data('id');
     var operator = $(this).data('operator');
     var oldstock = $(this).data('oldstock');
     var material = $(this).data('material');
     
     $(".modal-title").text( name );
     $(".modal-body #priceName").val( pricename );
     $(".modal-body #oldstock").val( oldstock );
     $(".modal-body #oldvalue").val( oldstock );
     $(".modal-body #operator").val( operator );
     $(".modal-body #materials").val( material );
     $(".modal-body #mid").val( mid );
     $(".modal-body #value").val( "" );

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
</script>
@endsection
