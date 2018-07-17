@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
        	<div class="col-md-4">
				<h2>Busqueda: {{$search}}</h2>
        	</div>
			<div class="col-md-8">
				<form class="col-md-3 pull-right" action="{{url('/buscar/'. $search)}}" method="get">
					<label for="filter">Order</label>
					<select name="filter" id="filter" class="form-control">
						<option value="new">New first</option>
						<option value="old">Old first</option>
						<option value="alpha">From A to Z</option>
					</select>
					<button type="submit" class="btn btn-primary">Order</button>
				</form>
			</div>
			<div class="clearfix"></div>
            @include('video.videosList')
        </div>
    </div>
</div>
@endsection