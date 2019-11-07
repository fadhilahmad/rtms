@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Designer Performance</div>

                <div class="card-body">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">Order Completed</th>
                                <th scope="col">Design Completed</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($design as $des)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$des->u_fullname}}</td> 
                                <td>
                                        @if($des->u_type==3)
                                           Designer
                                        @endif
                                        @if($des->u_type==4)
                                           Tailor
                                        @endif
                                        @if($des->u_type==5)
                                           Printing
                                        @endif                                
                                </td>
                                <td>{{$des->quantity_total}}</td>
                                <td>{{$des->quantity_total}}</td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              {{ $design->links() }}
                            </tbody>
                          </table>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">Printing Performance</div>

                <div class="card-body">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">Order Completed</th>
                                <th scope="col">Print Completed</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($print as $pri)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$pri->u_fullname}}</td> 
                                <td>
                                        @if($pri->u_type==3)
                                           Designer
                                        @endif
                                        @if($pri->u_type==4)
                                           Tailor
                                        @endif
                                        @if($pri->u_type==5)
                                           Printing
                                        @endif                                
                                </td>
                                <td>{{$pri->quantity_total}}</td>
                                <td>{{$pri->quantity_total}}</td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              {{ $print->links() }}
                            </tbody>
                          </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Tailor Performance</div>

                <div class="card-body">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">Order Completed</th>
                                <th scope="col">Unit Completed</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($tailor as $tai)
                              <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td>{{$tai->u_fullname}}</td> 
                                <td>
                                        @if($tai->u_type==3)
                                           Designer
                                        @endif
                                        @if($tai->u_type==4)
                                           Tailor
                                        @endif
                                        @if($tai->u_type==5)
                                           Printing
                                        @endif                                
                                </td>
                                <td>{{$tai->quantity_total}}</td>
                                <td>{{$tai->quantity_total}}</td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              {{ $tailor->links() }}
                            </tbody>
                          </table>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection
