<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Models\Video;
use App\Models\Comment;
use App\Models\Favorite;

use App\Models\VideoStream;

class ApiController extends Controller
{
    public function watch($id, $string) {
        $videosDir = storage_path("app/videos/$id");
        if (file_exists($filePath = $videosDir."/".$string . '.webm')) {
            $stream = new VideoStream($filePath);
            return response()->stream(function() use ($stream) {
                $stream->start();
            });
        }
        return response("File doesn't exists", 404);
    }

    public function avatar($id, $string) {
        $path = storage_path("app/avatars/$id/$string.jpg");

        if (!File::exists($path)) {
            return;
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);
        return $response;

    }

    public function thumbnail($id, $public_id, $index) {
        $path = storage_path("app/videos/$id");
        if (File::exists($path)) {
            $array = File::files($path);
            $array = array_slice($array, 2);
            $file = File::get($array[$index]);
            $type = File::mimeType($array[$index]);
            $response = Response::make($file, 200);
            $response->header('Content-Type', $type);
            return $response;
        }

    }

    public function getComments($id) {
        $video = Video::findOrFail($id);
        $comments = $video->comments()->orderBy('id', 'desc')->get();
        return $comments;
    }

    public function postComments($id, Request $request) {
       
        if (Auth::check()) {
            Comment::create([
                'user_name' => Auth::user()->name,
                'video_id' => $id,
                'content' => $request->get('content')
            ]);

            return [
                'status' => 'success',
                'message' => 'Comment successfully created'
            ];
        }
        else {
            return [
                'status' => 'error',
                'message' => 'Need login'
            ];
        }
    }

    

    public function postFavorite($id, Request $request) {
        if ($request->ajax()) {
            if (Auth::guest()) {
                return 'You must to be loged';
            }
            else {
                $favorite = Favorite::where('user_id', Auth::id())->where('video_id', $id)->first();

                if (is_null($favorite)) {
                    Favorite::create([
                        'user_id' => Auth::id(),
                        'video_id' => $id
                    ]);
                    return 'This video is in your favorites';
                }
                else {
                    return 'This video is already in your favorites';
                }
            }
        }
    }

    public function download($id, $public_id) {
        if (Auth::guest()) {
            return redirect()->back()->with('error', 'You must to be logged to download the file');
        }
        else {
            $title = Video::findOrFail($id)->title;
            $path = storage_path("app/videos/$id/$public_id.webm");
            return response()->download($path, "$title.webm");
        }
    }

    public function related($id){
        $video = Video::findOrFail($id);
        $tags = [];
        foreach ($video->tags as $tag) {
            array_push($tags, $tag->name);
        }
        $videos = Video::withAnyTag($tags)->get();
        foreach ($videos as $video) {
            $video->username = $video->user;
        }
        return $videos;
    }
    public function test() {
        Comment::create([
            'user_name' => 'toto',
            'video_id' => 1,
            'content' => 'lorem ipsim'
        ]);
        
        return 'e';
    }
}
