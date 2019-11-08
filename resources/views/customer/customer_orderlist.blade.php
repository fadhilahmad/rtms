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
                        
                            {{-- @foreach($orders as $singleorderrow)
                                <p>Cloth Name: {{$singleorderrow->file_name}}</p>
                            @endforeach
                            @foreach ($spec as $singlespecrow)
                                <p>Collar Color: {{ $singlespecrow->collar_color }} </p>
                            @endforeach
                            @foreach ($unit as $singleunitrow)
                                <p>Size: {{ $singleunitrow->size }} </p>
                            @endforeach
                            @foreach ($design as $singledesignrow)
                                <img src="/orders/mockup/{{ $singledesignrow->d_url }}">
                                <p>Url: {{ $singledesignrow->d_url }} </p>
                                @break
                            @endforeach --}}

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
                                            <td><a href="/customer/vieworder/{{$singleorderrow->o_id}}">View Design</a></td>
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
                                                <td>{{$singleorderpendingrow->note}}</td>
                                                <td><a href="/customer/vieworder/{{$singleorderpendingrow->o_id}}">View Design</a></td>
                                                <td>
                                                    
                                                    {!!Form::open( array( 'route'=>'customer.orderlist', $singleorderpendingrow->o_id, 'method' => 'POST') )!!}
                                                        <input type="hidden" name="orderid" value="{{$singleorderpendingrow->o_id}}">
                                                        <input type="submit" name="requestbutton" value="Request" class="btn btn-primary">
                                                        <input type="submit" name="confirmbutton" value="Confirm" class="btn btn-primary">
                                            
                                                    {!!Form::close()!!}

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
@endsection
