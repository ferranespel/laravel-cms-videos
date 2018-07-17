            <div id="videos-list">
                @if(count($videos) >= 1)
                    @foreach($videos as $video)
                        <div class="video-item col-md-10 pull-left panel panel-default">
                        <!--  Video image -->
                            <div class="panel-body">         
                                @if(Storage::disk('images')->has($video->image))
                                <div class="video-image-thumb col-md-3 pull-left">
                                    <div class="video-image-mask">
                                        <img src="{{url('/thumbnail/' . $video->image)}}" class="video-image">
                                    </div>
                                </div>
                                @endif
                                <div class="data">
                                    <h4><a href="{{ route('detailVideo', ['video_id' => $video->id]) }}">{{$video->title}}</a></h4>
                                    <p><a href="{{route('channel', ['user_id' => $video->user->id])}}">{{ $video->user->name . ' ' . $video->user->surname}}</a>{{ \FormatTime::LongTimeFilter($video->created_at)}}</p>
                                </div>
                                <!--  Action buttons -->
                                    <a href="{{ route('detailVideo', ['video_id' => $video->id]) }}" class="btn btn-success">Ver</a>
                                @if(Auth::check() && Auth::user()->id == $video->user->id)
                                    <a href="{{ route('videoEdit', ['video_id' => $video->id]) }}" class="btn btn-warning">Editar</a>
                                    <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                    <a href="#victorModal{{$video->id}}" role="button" class="btn btn-sm btn-primary" data-toggle="modal">Eliminar</a> 
                                    <!-- Modal / Ventana / Overlay en HTML -->
                                    <div id="victorModal{{$video->id}}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Are you sure to delete the comment?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>You sure you want to delete the video comment?</p>
                                                    <p class="text-warning"><small>{{$video->title}}</small></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <a href="{{url('/delete-video/' . $video->id)}}" type="button" class="btn btn-danger">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @else
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>No videos to show</strong>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    {{$videos->links()}}
            </div>