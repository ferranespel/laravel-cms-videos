<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comment;



class VideoController extends Controller
{
    public function createVideo(){
    	return view('video.createVideo');
    }

    public function saveVideo(Request $request)
    {
    	// Validate form
    	$validateData = $this->validate($request, [
    		'title' => 'required|min:5',
    		'description' => 'required|min:10',
    		'video' => 'required|mimes:mp4'

    	]);

    	$video = new Video();
    	$user = \Auth::user();
    	$video->user_id 	= $user->id;
    	$video->title 		= $request->input('title');
    	$video->description = $request->input('description');

    	// Thumbnail Upload

    	$image = $request->file('image');
    	if($image){

    		$image_path = time().$image->getClientOriginalName();
    		\Storage::disk('images')->put($image_path, \File::get($image));
    		$video->image 	= $image_path;
    	}

    	// Video Upload

    	$video_file = $request->file('video');
    	if($video_file){
    		$video_path = time().$video_file->getClientOriginalName();
    		\Storage::disk('videos')->put($video_path, \File::get($video_file));
    		$video->video_path 	= $video_path;
    	}

    	$video->save();

    	return redirect()->route('home')->with(array(
    		'message' => 'El video se ha subido correctamente.'
    	));
    }

    public function getImage($filename){
    	$file = Storage::disk('images')->get($filename);
    	return new Response($file, 200);

    }

    public function getVideoDetail($video_id){
        $video = Video::find($video_id);
        return view('video.detail', array(
            'video'         => $video
        ));
    }

    public function getVideo($filename){
        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);

    }

    public function delete($video_id){
        $user = \Auth::user();
        $video = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get();

        if($user && $user->id == $video->user_id){
            // Delete comments
            if($comments && count($comments) >= 1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }
            // Delete files
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);
            // Delete register
            $video->delete();
            $message = array('message' => 'Video and related comments have been deleted.');

        }else{
            $message = array('message' => 'Video and related comments not possible to be delete');
        }
        return redirect()->route('home')->with($message);
    }

    public function edit($id){
        $user = \Auth::user();
        $video = Video::findOrFail($id);
        if($user && $user->id == $video->user_id){

            return view('video.edit',  array(
                'video' => $video
            ));
        }else{
            return redirect()->route('home');
        }
    }

    public function update($video_id, Request $request){
        $validate = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'video' => 'mimes:mp4'            
        ]);
        $user = \Auth::user();
        $video = video::findOrFail($video_id);
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description =  $request->input('description');

        // Thumbnail Upload

        $image = $request->file('image');
        if($image){
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
        // Delete Image
            if($video->image){
                Storage::disk('images')->delete($video->image);
            }
        // Update Image path
            $video->image   = $image_path;
        }

        // Video Upload
        $video_file = $request->file('video');
        if($video_file){
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
        // Delete Video
            if($video->video_path){
                Storage::disk('videos')->delete($video->video_path);
            }           
        // Update Video path
            $video->video_path  = $video_path;
        }

        $video->update();

        return redirect()->route('home')->with(['message' => 'Video have been update succefull.']);
    }
    public function search($search = null, $filter = null){
        if(is_null($search)){
            $search = \Request::get('search');
            if(is_null($search)){
                return redirect()->route('home');  
            }
            return redirect()->route('videoSearch', array( 'search' => $search));
        }
        if(is_null($filter) && \Request::get('filter') && !is_null($search)){
            $filter = \Request::get('filter');
            return redirect()->route('videoSearch', array( 'search' => $search, 'filter' => $filter));            
        }

        $column = 'id';
        $order = 'desc';
        if(!is_null($filter)){
            if($filter == 'new'){
                $column = 'id';
                $order = 'desc';
            }
            if($filter == 'old'){
                $column = 'id';
                $order = 'asc';
            }
            if($filter == 'alpha'){
                $column = 'title';
                $order = 'asc';
            }
        } 
        
        $videos = Video::where('title', 'LIKE', '%'. $search . '%')->orderBy($column, $order)->paginate(5);
       
        return view('video.search', array(
            'videos' => $videos,
            'search' => $search
        ));

    }
}


















