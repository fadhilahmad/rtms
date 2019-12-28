@extends ('layouts.layout')
@section ('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Customer Setting</div>

                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tier Setting</div>

                <div class="card-body">
                    @if(!$tiers->isempty())
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tier Name</th>
                                <th scope="col">Customer Type</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach($tiers as $tier)
                              <tr>
                                <th scope="row">{{$no}}</th>
                                <td>{{$tier->tier_name}}</td>
                                <td>{{$tier->u_type}}</td>
                              </tr>
                              @php $no++; @endphp
                              @endforeach
                            </tbody>
                        </table>
                    @else
                    No record
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection