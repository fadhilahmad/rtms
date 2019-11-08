@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Pricing</div><BR>
                
                <div class="card-body">
                    <center><h2>AGENT PRICING</h2></center><br>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">BODY</th>
                                <?php $no=-1; ?>
                                @foreach($sleeve as $sle) 
                                <th scope="col">{{$sle->sl_desc}}/RN</th>
                                <th scope="col">{{$sle->sl_desc}}/COLLAR</th>
                                <?php $no=$no+2;  
                                $sle_id[] = array('s_id'=>$sle->sl_id,'n_id'=>'1');
                                $sle_id[] = array('s_id'=>$sle->sl_id,'n_id'=>'2');
                                ?>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                                                                           
                                @foreach($body as $bod)
                                <tr>                                
                                <td class="table-dark">{{$bod->b_desc}}</td>
                                @foreach ($sle_id as $ad) 
                                <td class="table-success">
                                    @php  
                                        echo App\Http\Controllers\Admin\OrderController::getPrice($ad['s_id'],$bod['b_id'],$ad['n_id'],6);
                                    @endphp
                                </td>
                                @endforeach
                                </tr>
                                @endforeach
<!--                                  ($i = 0; $i <= $no; $i++)    echo $ad['s_id']."/".$bod['b_id']."/".$ad['n_id'];                                            -->
                            </tbody>
                        </table><br><br>
                        <hr>
                        <center><h2>END USER PRICING</h2></center><br> 
                        <table class="table table-hover">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">BODY</th>
                                <?php $no=-1; ?>
                                @foreach($sleeve as $sle) 
                                <th scope="col">{{$sle->sl_desc}}/RN</th>
                                <th scope="col">{{$sle->sl_desc}}/COLLAR</th>
                                <?php $no=$no+2;  ?>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                                                                           
                                @foreach($body as $bod)
                                <tr>                                
                                <td class="table-dark">{{$bod->b_desc}}</td>
                                @for ($i = 0; $i <= $no; $i++)
                                <td class="table-success">1</td>
                                @endfor
                                </tr>
                                @endforeach
                                                                                 
                            </tbody>
                        </table>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


