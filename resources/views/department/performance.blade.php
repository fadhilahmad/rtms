@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Performance</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                            <div class="panel panel-primary">
                                <div class="panel-heading"></div>                                                                  
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">Order Completed</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$order}}</div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Job Completed</div>
                                        <div class="col-sm-1">:</div>
                                        <div class="col-sm-8">{{$unit}}</div>
                                    </div><br>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
