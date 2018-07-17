@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<h2>Edit {{$video->title}}</h2>
		<hr>
		<form action="{{route('updateVideo', ['video_id' => $video->id])}}" method="POST" enctype="multipart/form-data" class="col-lg-7">
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
					<input type="text" class="form-control" id="title" name="title" placeholder="Add the video title" value="{{$video->title}}">
				</div>

				<div class="form-group">
					<label for="description">Description</label>
					<textarea name="description" id="description" class="form-control" rows="3" required="required">{{$video->description}}</textarea>
				</div>


				<div class="form-group">
					<label for="image">Thumbnail</label>
                    @if(Storage::disk('images')->has($video->image))
                    <div class="video-image-thumb">
                        <div class="video-image-mask">
                            <img src="{{url('/thumbnail/' . $video->image)}}" class="video-image">
                        </div>
                    </div>
                    @endif
						<input type="file" class="form-control" id="image" name="image">
				</div>

				<div class="form-group">
					<label for="video">Video file</label>
					<div class="row">
					<!-- Video -->
					<video id="video-player" controls>
						<source src="{{ route('fileVideo', ['filename' => $video->video_path])}}">
						Your browser is not compatible with HTML5
					</video>
					</div>
					<input type="file" class="form-control" id="video" name="video">
				</div>				

				<button type="submit" class="btn btn-primary">Edit Video</button>
			</form>	
	</div>
</div>

@endsection