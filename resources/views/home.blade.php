@extends ('layouts.layout')
@section ('content')
<div>
    <div class="card-header">Dashboard</div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('error') }}
            </div>
        @endif
        Waiting for admin approval
    </div>
    
</div>
@endsection