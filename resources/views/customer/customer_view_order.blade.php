@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="/customer/orderlist" class="btn btn-default">Go Back</a>
            <br>
            <br>
            <div class="card">

                <div class="card-body">

                    <div class="panel-body">
                        {{-- <p>Url: {{$design}}</p> --}}
                        @foreach ($design as $object)
                            <img style="width:80%" src="/orders/mockup/{{ $object->d_url }}">
                            @break
                        @endforeach
                        {{-- ->d_url  ->collar_color  ->name --}}
                        {{-- <p>Collar Color: {{$spec}}</p> --}}
                        {{-- @foreach ($spec as $object)
                            <p>Collar Color: {{ $object->collar_color }} </p>
                        @endforeach --}}
                        {{-- <p>Name Set: {{$unit}}</p> --}}
                        {{-- @foreach ($unit as $object)
                            <p>Name Set: {{ $object->name }} </p>
                        @endforeach --}}


                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
