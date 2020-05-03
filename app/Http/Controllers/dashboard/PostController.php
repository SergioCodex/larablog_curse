<?php

namespace App\Http\Controllers\dashboard;

use App\Tag;
use App\Post;
use App\Category;
use App\PostImage;
use App\Helpers\CustomUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostPost;
use App\Http\Requests\UpdatePostPut;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
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
    public function index(Request $request)
    {


        //$this->sendMail();
        //Storage::get("/storage/logo.png");

        /*DB::transaction(function () {
            
        });

        $personas = [
            ["nombre" => 'Pepe', "edad" => 20],
            ["nombre" => 'Manuela', "edad" => 60],
            ["nombre" => 'Jose', "edad" => 20]
        ];

        //dd($personas);

        $collection1 = collect($personas);
        $collection2 = new Collection($personas);
        $collection3 = Collection::make($personas);

        dd($collection3->filter(function($value, $key){
            return $value['edad'] < 50;
        })->sum('edad'));*/

        $posts = Post::with('category')
            ->orderBy('created_at', request('created_at', 'DESC'));

        if ($request->has('search')) {
            $posts = $posts->where('title', 'like', '%' . request('search') . '%');
        }

        $posts = $posts->paginate(10);

        return view('dashboard.post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $tags = Tag::pluck('id', 'title');
        $categories = Category::pluck('id', 'title');
        $post = new Post();

        return view("dashboard.post.create", compact('post', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostPost $request)
    {
        /*$request->validate([
            'title' => 'required|min:5|max:500',
            'content' => 'required|min:5'
        ]);*/

        //dd($request->validated());

        if ($request->url_clean == "") {
            $urlClean = CustomUrl::urlTitle(CustomUrl::convertAccentedCharacters($request->title), '-', true);
        } else {
            $urlClean = CustomUrl::urlTitle(CustomUrl::convertAccentedCharacters($request->url_clean), '-', true);
        }

        $requestData = $request->validated();

        $requestData['url_clean'] = $urlClean;

        $validator = Validator::make($requestData, StorePostPost::myRules());

        if ($validator->fails()) {
            return redirect('dashboard/post/create')
                ->withErrors($validator)
                ->withInput();
        }

        $post = Post::create($requestData);

        $post->tags()->sync($request->tags_id);

        return back()->with('status', 'Post creado correctamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //$post = Post::findorFail($id);

        return view('dashboard.post.show', ["post" => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //dd($post->tags);
        //$tag = Tag::find(1);
        $tags = Tag::pluck('id', 'title');
        // dd($tag->posts);

        $categories = Category::pluck('id', 'title');
        return view('dashboard.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostPut $request, Post $post)
    {
        //dd($request->validated());

        $post->tags()->sync($request->tags_id);

        $post->update($request->validated());

        return back()->with('status', 'Post actualizado correctamente!');
    }

    public function image(Request $request, Post $post)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,bmp,png|max:10240' //10Mb
        ]); //validaciones

        $filename = time() . "." . $request->image->extension(); //nombre archivo

        //$request->image->move(public_path('images'), $filename); //guardar imagen

        $path = $request->image->store('public/images');

        $path_url = Storage::url($path);

        PostImage::create(['image' => $path_url, 'image_download' => $path, 'post_id' => $post->id]);

        return back()->with('status', 'Imagen cargada correctamente!');
    }

    public function contentImage(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,bmp,png|max:10240' //10Mb
        ]); //validaciones

        $filename = time() . "." . $request->image->extension(); //nombre archivo

        $request->image->move(public_path('images'), $filename); //guardar imagen

        return response()->json(["default" => URL::to("/") . '/images/' . $filename]);
    }

    public function imageDownload(PostImage $image)
    {
        return Storage::disk('local')->download("$image->image_download");
    }

    public function imageDelete(PostImage $image)
    {

        $image->delete();

        Storage::disk('local')->delete("$image->image");
        return back()->with('status', 'Imagen eliminada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('status', 'Post eliminado correctamente!');
    }
}
