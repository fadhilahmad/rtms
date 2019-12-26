@extends ('layouts.layout')
@section ('content')
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
                <div class="card-header">Agent Performance</div>

                <div class="card-body">
                    @if(!$agent->isempty())
                    <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Total Order</th>
                                <th scope="col">Total Unit</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($agent as $agents)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$agents->u_fullname}}</td>
                                <td>{{$agents->username}}</td>
                                @php
                                $total_order = $orders->where('u_id_customer',$agents->u_id)->count();
                                $total_unit = $orders->where('u_id_customer',$agents->u_id)->pluck('quantity_total')->sum();
                                @endphp
                                <td>{{$total_order}}</td>
                                <td>{{$total_unit}}</td>                               
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              {{ $agent->links() }}
                            </tbody>
                          </table>
                    @else
                    No Agent Record
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection