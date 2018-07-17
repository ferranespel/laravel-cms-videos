@extends('layouts.app')

@section('content')
	<div class="col-md-11 col-md-offset-1">
		<h2>{{$video->title}}</h2>
		<hr>
		<div class="col-md-8">
			<!-- Video -->
			<video id="video-player" controls>
				<source src="{{ route('fileVideo', ['filename' => $video->video_path])}}">
				Your browser is not compatible with HTML5
			</video>
			<!-- Description -->
			<div class="panel panel-default video-data">
				<div class="panel-heading">
					<div class="panel-title">
						Uploaded by <strong><a href="{{route('channel', ['user_id' => $video->user->id])}}">{{$video->user->name . ' ' . $video->user->surname}}</a>
							{{ \FormatTime::LongTimeFilter($video->created_at)}}</strong>
					</div>
				</div>
				<div class="panel-body">
					{{$video->description}}
				</div>
			</div>
			<!-- Comments -->
			@include('video.comments')
		</div>
	</div>
@endsection