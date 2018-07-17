<hr>
<h4>Comments</h4>
<hr>
@if(session('message'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{session('message')}}
    </div>
@endif
@if(Auth::check())
<form class="col-md-4" action="{{url('/comment')}}" method="POST">
	{!! csrf_field() !!}
	<input type="hidden" name="video_id" value="{{$video->id}}" id="video_id" required>
	<p>
		<textarea name="body" id="body" class="form-control" required></textarea>
	</p>
	<button type="submit" class="btn btn-success">Send Comment</button>
</form>
<div class="clearfix"></div>
<hr>
@endif
@if(isset($video->comments))
	<div id="comments-list">
		@foreach($video->comments as $comment)
			<div class="comment-item col-md-12 pull-left">
				<div class="panel panel-default comment-data">
					<div class="panel-heading">
						<div class="panel-title">
							Uploaded by <strong>{{$comment->user->name . ' ' . $comment->user->surname}} 
								{{ \FormatTime::LongTimeFilter($comment->created_at)}}</strong>
						</div>
					</div>
					<div class="panel-body">
						{{$comment->body}}

						@if( Auth::check() && (Auth::user()->id == $comment->user_id || Auth::user()->id == $video->user_id))

						<div class="pull-right">
							<!-- Botón en HTML (lanza el modal en Bootstrap) -->
							<a href="#victorModal{{$comment->id}}" role="button" class="btn btn-sm btn-primary" data-toggle="modal">Eliminar</a>
							  
							<!-- Modal / Ventana / Overlay en HTML -->
							<div id="victorModal{{$comment->id}}" class="modal fade">
							    <div class="modal-dialog">
							        <div class="modal-content">
							            <div class="modal-header">
							                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							                <h4 class="modal-title">Are you sure to delete the comment?</h4>
							            </div>
							            <div class="modal-body">
							                <p>You sure you want to delete the video comment?</p>
							                <p class="text-warning"><small>{{$comment->body}}</small></p>
							            </div>
							            <div class="modal-footer">
							                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							                <a href="{{url('/delete-comment/' . $comment->id)}}" type="button" class="btn btn-danger">Delete</a>
							            </div>
							        </div>
							    </div>
							</div>
						</div>
						@endif

					</div>
				</div>
			</div>
		@endforeach
	</div>
@endif