@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">View image from designer</div>

                <div class="card-body">

                        @foreach ($designs as $design)
                            <img style="width:80%" src="/orders/draft/{{ $design->d_url }}">
                            @break
                        @endforeach
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
