<?php

namespace App\Http\Controllers\dashboard;

use App\Post;
use App\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'rol.admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postComments = PostComment::orderBy('created_at', 'desc')->paginate(5);

        return view('dashboard.post-comment.index', ['postComments' => $postComments]);
    }

    public function post(Post $post)
    {

        $posts = Post::all();

        $postComments = PostComment::orderBy('created_at', 'desc')
            ->where('post_id', '=', $post->id)
            ->paginate(10);

        return view('dashboard.post-comment.post', ['postComments' => $postComments, 'posts' => $posts, 'postSelected' => $post]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PostComment $postComment)
    {
        //$postComment = PostComment::findorFail($id);

        return view('dashboard.post-comment.show', ["postComment" => $postComment]);
    }


    public function jshow(PostComment $postComment)
    {
        return response()->json($postComment);
    }

    public function process(PostComment $postComment)
    {
        if($postComment->approved == '0') $postComment->approved = '1';
        else $postComment->approved = '0';

        $postComment->save();

        return response()->json($postComment->approved);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostComment $postComment)
    {
        $postComment->delete();
        return back()->with('status', 'Comentario eliminado correctamente!');
    }
}
