@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Invoice Page</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p><b>Customer Name:</b> </p>
                    <p><b>Invoice Date:</b> </p>
                    <p><b>File Name:</b> </p>
                    <p><b>Category:</b> </p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
