@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br>
            <br>
            <div class="card">

                <div class="card-body">

                    <div class="panel-body">
                        @foreach ($designs as $design)
                            <img style="width:100%" src="{{URL::to('/')}}/orders/mockup/{{ $design->d_url }}">
                            @break
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
