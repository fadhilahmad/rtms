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
                                @foreach($user as $des)
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
                                <td>
                                    @php $id=$des->u_id;  
                                     $job_design = $unit->where('u_id_designer',$id)->whereIn('un_status',['1','2','3','4','5'])->count();
                                     $design_order = $order->where('u_id_designer',$id)->where('o_status','9')->count();
                                    @endphp
                                    {{$design_order}}</td>
                                <td>{{$job_design}}</td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
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
                                <td>
                                    @php $id=$pri->u_id;  
                                     $job_print = $unit->where('u_id_print',$id)->whereIn('un_status',['2','3','4'])->count();
                                     $print_order = $order->where('u_id_print',$id)->where('o_status','9')->count();
                                    @endphp
                                    {{$print_order}}</td>
                                <td>{{$job_print}}</td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
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
                                <td>
                                    @php $id=$tai->u_id;  
                                     $job_tailor = $unit->where('u_id_taylor',$id)->whereIn('un_status',['3','4'])->count();
                                     $tailor_order = $order->where('u_id_taylor',$id)->where('o_status','9')->count();
                                    @endphp
                                    {{$tailor_order}}</td>
                                <td>{{$job_tailor}}</td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                            </tbody>
                          </table>
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection
