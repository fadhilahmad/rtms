@extends('layouts.layout')

@section('content')
<div  class="container-scroll">
    <div class ="card">
        <div class="card-header" id="cardheader"><img src="{{URL::to('/')}}/img/order_form.png" id="imglogo"></div>  
            <div class="card-body">   
                <form class="form-horizontal">
                    <div class="scroll_page" id="allcolumn">
                        <!-- first column -->
                        <div class="col-8 scroll_page--box" id="firstcolumn" name="col8div1">
                            <!-- date & ref.num field -->
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2 padding-0" name="colsm1lbl">Date</label>
                                <div class="col-sm-4 padding-0" name="colsm2div">
                                    : <input id="date" name="date" type="email" value="{{ date('d/m/Y', strtotime($orders->created_at)) }}" disabled="">
                                </div>
                                <label class="col-sm-1 padding-0" name="colsm1lblref">Ref Num</label>
                                <div class="col-sm-5 padding-0" name="colsm2divref">
                                    : <input id="refnum" name="refnum"  type="text" value="{{ $orders->ref_num }}" disabled="" >
                                </div>
                            </div>
                            <!-- customer field -->
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" style="" name="colsm1lbl">Customer</label>
                                <div class="col-sm-10">
                                : <input id="customer"  name="customer" type="text" value="{{ $orders->u_fullname }}" disabled="">
                                </div>
                            </div>
                            <!-- file name field -->
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl">File Name</label>
                                <div class="col-sm-10">
                                : <input id="file_name" name="file_name" type="text" value="{{ $orders->file_name }}" disabled="">
                                </div>
                            </div>
                            <!-- material checkbox -->
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl">Material</label>
                                <div class="col-sm-10">
                                : <input id="material" name="material" type="text" value="{{ $orders->m_desc }}" disabled="">
                                </div>
                            </div>
                            <!-- sleeve checkbox -->                                
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl">Sleeve</label>                                   
                                    <div class="col-sm-10">                                            
                                        : 
                                        @foreach ($specs as $spec)                                                    
                                                    <input id="checkboxCustom" type="checkbox" value="" checked disabled>
                                                    <label for="checkboxCustom">{{ $spec->sl_desc }}</label>                                                   
                                        @endforeach                                          
                                    </div>                                                                                                                
                            </div>
                                <!-- collar no field -->                                
                                <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl">Collar No</label>
                                <div class="col-sm-10">
                                    : 
                                    <?php $no = 1 ?>
                                    @foreach ($specs as $spec) 
                                    {{ $spec->n_id }} <?php if(count($specs) != $no) echo ','; $no++ ?>
                                    @endforeach                                             
                                </div>
                            </div>
                            <!-- delivery date field -->                                
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl">Delivery Date</label>
                                <div class="col-sm-10">
                                : <input id="delivery_date" name="delivery_date" type="text" value="{{ date('d/m/Y', strtotime($orders->delivery_date)) }}" disabled="">
                                </div>
                            </div>
                            <!-- Person in charge field -->                                
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl">Person in charge</label>
                                <div class="col-sm-10">
                                : <input id="pic" name="pic" type="text" value="{{ $pic->u_fullname }}" disabled="">
                                </div>
                            </div>
                            <!-- collar colour field -->                                
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl">Collar Colour</label>
                                <div class="col-sm-10">
                                :
                                    <?php $clno = 1; ?>
                                    @foreach ($specs as $spec)
                                        @if($spec->collar_color != "") 
                                            {{$spec->collar_color}} ,
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <!-- jpeg mockup field -->                                                            
                            <!-- <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl">JPEG Mockup </label>
                                <div class="col-sm-10">
                                    <img class="imgmockup" src="{{url('orders/mockup/'.$design->d_url)}}" width="70%">
                                </div>
                            </div> -->
                            <!-- remarks field -->        
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl">Remarks</label> :
                                <div class="col-sm-6">
                                    <textarea rows="4" cols="50" value="" disabled=""> {{ $orders->note }}                               
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group row" name="rowformdiv">
                                <label class="col-sm-2" name="colsm1lbl"></label>
                                <div class="col-sm-8">
                                    @if(!$notes->isempty())
                                    <table class="table table-bordered" id="tbldate">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($notes as $note)
                                            <tr>
                                                <td>{{ $note->created_at }}</td>
                                                <td>{{ $note->note }}</td>
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                    <div class="row offset-sm-4" style="margin-top:50px;">
                                        <input class="col-4" type="text" value="Total" name="col4inputtot" id="totquan" disabled/>
                                        <input class="col-3" type="text" name="col3inputquan" id="totval"  value="{{ $orders->quantity_total }}" disabled/> <p>PCS</p>
                                    </div>
                                 </div>
                            </div>
                           
                        
                        </div>
                        <!-- Second column  name="col10div2" -->
                        <div class="col-10 scroll_page--box" id="secondcolumn" name="col10div2">
                            <div class="row">
                                <div class="col">
                                    <img class="imgcollar" src="{{url('img/collar-type.jpeg')}}">
                                </div>
                                <div class="col">
                                    <div class="text-big-red">
                                        <h1 class="h1class">{{ $orders->m_desc }}</h1>
                                    </div>
                                </div>
                                <div class="form-group col-5" name="mockupimg" id="rowimgmockup">
                                    <label class="labelimgmockup">JPEG Mockup :</label>
                                    <div>
                                        <img class="imgmockup" src="{{url('orders/mockup/'.$design->d_url)}}" width="100%">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="form-group col-3" name="rowformdiv">
                                    
                                    @foreach($specs as $spec)
                                    @if($spec->category=="Size")
                                    <strong>{{$spec->b_desc}} {{$spec->sl_desc}} <span id="idspan">{{$spec->n_desc}}</span></strong>
                                    <div style="display:flex;">
                                        <table class="table table-bordered" id="tblsize">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Designed</th>
                                                    <th scope="col">Printed</th>
                                                    <th scope="col">Sewed</th>
                                                    <th scope="col">Delivered</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                                <tr>                                     
                                                    <td scope="row" style="text-transform: uppercase;">{{$unit->size}}</td>
                                                    <td>{{$unit->un_quantity}}</td>
                                                    <td>                                                                                                         
                                                        @if($unit->un_status != 0)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif 
                                                    </td>
                                                    <td>
                                                        @if($unit->un_status != 0 && $unit->un_status != 1)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif
                                                    </td>
                                                    <td>                                                                                                         
                                                        @if($unit->un_status != 0 && $unit->un_status != 1 && $unit->un_status != 2 && $unit->un_status != 5)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif 
                                                    </td> 
                                                    <td>                                                                                                         
                                                        @if($unit->un_status != 0 && $unit->un_status != 1 && $unit->un_status != 2 && $unit->un_status != 3 && $unit->un_status != 5)
                                                        <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                        @else
                                                        <input type="checkbox" name="jobdone" value="" disabled="">
                                                        @endif 
                                                    </td>                                            
                                                </tr>
                                                @endforeach 
                                                <tr>
                                                    <th scope="row">Total</th>
                                                    <td style="background-color:#0051ff; color:white">{{$units->where('s_id',$spec->s_id)->where('o_id',$spec->o_id)->sum('un_quantity')}}</td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <BR><BR>
                                    @elseif($spec->category="Nameset")
                                    
                                    <div class="form-group col-3" name="rowformdiv">
                                        <strong>{{$spec->b_desc}} {{$spec->sl_desc}} <span id="idspan">{{$spec->n_desc}}</span></strong>
                                        <div class="row">
                                            <table class="table table-bordered" id="tblnameset">
                                                <thead  style="background-color:yellow; color:black">
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Size</th>
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">Designed</th>
                                                        <th scope="col">Printed</th>
                                                        <th scope="col">Sewed</th>
                                                        <th scope="col">Delivered</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($units->where('o_id',$spec->o_id)->where('s_id',$spec->s_id) as $unit)
                                                    <tr>                                              
                                                        <td>{{$unit->name}}</td>
                                                        <td scope="row" style="text-transform: uppercase;">{{$unit->size}}</td>
                                                        <td>{{$unit->un_quantity}}</td>
                                                        <td>                                                                                                         
                                                            @if($unit->un_status != 0)
                                                            <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                            @else
                                                            <input type="checkbox" name="jobdone" value="" disabled="">
                                                            @endif 
                                                        </td>
                                                        <td>
                                                            @if($unit->un_status != 0 && $unit->un_status != 1)
                                                            <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                            @else
                                                            <input type="checkbox" name="jobdone" value="" disabled="">
                                                            @endif
                                                        </td>   
                                                        <td>                                                                                                         
                                                            @if($unit->un_status != 0 && $unit->un_status != 1 && $unit->un_status != 2 && $unit->un_status != 5)
                                                            <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                            @else
                                                            <input type="checkbox" name="jobdone" value="" disabled="">
                                                            @endif 
                                                        </td> 
                                                        <td>                                                                                                         
                                                            @if($unit->un_status != 0 && $unit->un_status != 1 && $unit->un_status != 2 && $unit->un_status != 3 && $unit->un_status != 5)
                                                            <input type="checkbox" name="jobdone" value="" checked="" disabled="">
                                                            @else
                                                            <input type="checkbox" name="jobdone" value="" disabled="">
                                                            @endif 
                                                        </td>                                          
                                                    </tr>
                                                    @endforeach 
                                                    <tr>
                                                        <td></td>
                                                        <th scope="row">Total</th>
                                                        <td style="background-color:#0051ff; color:white">{{$units->where('s_id',$spec->s_id)->where('o_id',$spec->o_id)->sum('un_quantity')}}</td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <BR><BR>
                                    </div>                                  
                                    @endif
                                    @endforeach
                                    
                                </div>
                            </div>
                            <div class="form-group row">       
                                <div class="col-sm-8 offset-sm-3">
                                    <div class="col-md-2"><button class="print" onclick="printFunction()"><i class="fa fa-print"></i></button></div>                                                         
                                </div>
                            </div>
                        </div>              
                    </div>
                </form>
            </div>  
        </div>        
    </div>  
</div>
<style type="text/css" media="print">

 @page { size: landscape;  }

</style>

<style type="text/css">

    .h1class {
        font-size: 70px;
        padding-left: 0px;
        /* font-size: 38pt; */
        /* margin-top:-60%; */
        position:absolute;
    }
    #rowimgmockup {
        /* width: 400px;
        height: 330px; */
        /* width: 100%; */
        position:relative;
        margin-top:20%;
    }
    .imgcollar {
        width:30vw; 
        margin: 0px auto; 
        margin-bottom:20px;
    }
    #idspan {
        color: red; 
        font-size:25px; 
        text-transform: uppercase;
    }
    #totquan{
        background-color:yellow;
    } 
    #totval{
        background-color:red; 
        color:white;
    } 
    #tblsize {
        margin: 0px auto; 
        margin-top:20px; 
        text-align: center;
    } 
    #tblnameset {
        margin: 0px auto; 
        margin-top:20px; 
        text-align: center;
    }
    /* .totset{
        background-color:blue; 
        color:white
    } */
    #cardheader {
        /* color: white; */
        background-color: white;
        padding:0px;
    }
    #imglogo {
        width:100%; 
        /* float:right; */
    }
    #tbldate {
        margin: 0px auto; 
        margin-top:20px;
    }
    /* #theaddate {
        background-color:yellow; 
        color:black;
    } */
    thead {
        background-color:yellow; 
        color:black;
    }
    #customer {
        width: 85.7%; 
        text-align:center;
    }
    #file_name {
        width: 85.7%; 
        text-align:center;
    }
    #date { 
        text-align:center;
    }
    #refnum { 
        text-align:center;
    }
    #material { 
        text-align:center;
    }
    #delivery_date { 
        text-align:center;
    }
    #pic { 
        text-align:center;
    }

    #allcolumn {
        position:relative;
        height:100vh;
    } 
    /* #firstcolumn {
        position: relative;
    } 
    */
    #secondcolumn {
        position: absolute;
    }  
    /* #allcolumn {
        position:relative;
        overflow-y: hidden;
    }  */
    /* .form-horizontal {
        position:relative;
        overflow-y: visible;
    }  */
    /* 
    .form-horizontal::-webkit-scrollbar {
        display: none;
    } */
    /* #firstcolumn {
        position:relative;
    }  */
    /* #secondcolumn {
        position: absolute;
    } */
    

    @media print {

        html, body {
            height: auto;
            font-size: 6pt;
            /* column-gap: 1rem; */
        }
        #rowimgmockup {
            /* width: 400px;
            height: 330px; */
            /* width: 100%; */
            position: fixed;
            margin-top:10%;
        }
        .labelimgmockup {
            padding-left:40%;
        }
        .imgmockup {
            /* width: 400px;
            height: 330px; */
            /* width: 100%; */
            padding-left:40%;
            position: fixed:
        }
        .imgcollar {
            width:25vw; 
            margin: 0px auto; 
            margin-bottom:20px;
        }
        .print{
            display: none;
        }
        .h1class {
            padding-left: 0px;
            font-size: 38pt;
            margin-top:-60%;
            position:absolute;
        }
        input[type="checkbox"]{
            width: 7px; /*Desired width*/
            height: 7px; /*Desired height*/
        }
        #idspan {
            color: red; 
            font-size:10px; 
            text-transform: uppercase;
        }
        #totquan{
            background-color:yellow; !important;
            -webkit-print-color-adjust: exact; 
        } 
        #totval{
            background-color:red;  !important;
            -webkit-print-color-adjust: exact; 
            color:white;
        }  
        #tblsize {
            margin: 0px auto; 
            margin-top:5px; 
            text-align: center;
        }  
        #tblnameset {
            margin: 0px auto; 
            margin-top:5px; 
            text-align: center;
        }
        /* .totset{
            background-color:blue; !important;
            color: white;
            -webkit-print-color-adjust: exact; 
        } */
        #allcolumn {
            position:initial;
            height:80vh;
        } 
        #firstcolumn {
            position:relative;
        } 
        #secondcolumn {
            position:absolute;
        } 
        #cardheader {
            /* color: white; */
            background-color: white;
            -webkit-print-color-adjust: exact;
            padding:0px;
            margin-bottom:10px;

        }
        #imglogo {
            width:100%; 
            height:7vh;
            /* float:right; */
        }
        #tbldate {
            margin: 0px auto; 
            margin-top:10px;
            -webkit-print-color-adjust: exact;
        }
        /* #theaddate {
            background-color:yellow !important;
            color:black;
            -webkit-print-color-adjust: exact;
        } */
        .table th {
            background-color:yellow !important; 
            color:black !important;
            -webkit-print-color-adjust: exact;
        }
        #customer {
            width: 96%; 
            text-align:center;
        }
        #file_name {
            width: 96%; 
            text-align:center;
        }
        #date { 
            text-align:center;
        }
        #refnum { 
            text-align:center;
        }
        #material { 
            text-align:center;
        }
        #delivery_date { 
            text-align:center;
        }
        #pic { 
            text-align:center;
        }

   }
   
   </style>

<script type="text/javascript">
function printFunction() {

    $('#allcolumn div[name="col8div1"]').removeClass('col-8').addClass('col-4');
    $('#firstcolumn label[name="colsm1lbldate"]').removeClass('col-sm-2').addClass('col-sm-1');
    $('#firstcolumn div[name="colsm2divdate"]').removeClass('col-sm-4').addClass('col-sm-1');
    $('#firstcolumn label[name="colsm1lblref"]').removeClass('col-sm-1').addClass('col-sm-1');
    $('#firstcolumn div[name="colsm2divref"]').removeClass('col-sm-5').addClass('col-sm-1');
    $('#secondcolumn div[name="mockupimg"]').removeClass('col-5').addClass('col-8');

    $('#allcolumn div[name="col10div2"]').removeClass('col-10').addClass('col-6');
    
    //$('#allcolumn div[name="rowformdiv"]').removeClass('form-group');

    window.print(); 
}       
</script>
@endsection

