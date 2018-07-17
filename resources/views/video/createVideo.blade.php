@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<h2>Crear un nuevo video</h2>
		<hr>
		<form action="{{route('saveVideo')}}" method="POST" enctype="multipart/form-data" class="col-lg-7">
		{!! csrf_field() !!}
		@if($errors->any())
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<ul>
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
		@endif
				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="Add the video title" value="{{old('title')}}">
				</div>

				<div class="form-group">
					<label for="description">Description</label>
					<textarea name="description" id="description" class="form-control" rows="3" required="required">{{old('description')}}</textarea>
				</div>


				<div class="form-group">
					<label for="image">Thumbnail</label>
					<input type="file" class="form-control" id="image" name="image">
				</div>

				<div class="form-group">
					<label for="video">Video file</label>
					<input type="file" class="form-control" id="video" name="video">
				</div>				

				<button type="submit" class="btn btn-primary">Upload Video</button>
			</form>	
	</div>
</div>



@endsection