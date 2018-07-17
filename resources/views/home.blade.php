@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            @if(session('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{session('message')}}
                </div>
            @endif
            @include('video.videosList')
        </div>
    </div>
</div>
@endsection
