<?php

namespace App\Http\Controllers\Admin;

use App\Events\UploadedImage;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        //paginados
        $posts = Post::latest('id')
            ->where('user_id', auth()->id())
            ->paginate();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //recuperar categorias
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'category_id' => 'required|exists:categories,id'
        ]);

        //el guard es el tipo de autenticacion web token etc
        $data['user_id'] = auth()->id(); //recuperamos el ide del usario autenticado

        $post = Post::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post',
            'text' => 'Post creado correctamente'
        ]);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Check if user is author of the post
       

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //aplicar gate para edtar el post que le pertenece
       

        //recuperar categorias
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                Rule::requiredIf(function () use ($post) {
                    return !$post->published_at;
                }),
                'string',
                'max:255',
                Rule::unique('posts')->ignore($post->id)
            ],
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'required_if:is_published,1|string',
            'content' => 'required_if:is_published,1|string',
            'tags' => 'array',
            'is_published' => 'boolean',
        ]);

     
        if ($request->hasFile('image')) {
            //para eliminar una imagen si cambia a otroa
            if ($post->image_path) {
                //eliminar la imagen anterior asocaida al post
                Storage::delete($post->image_path);
            }

            $extension = $request->image->extension();
            $namefile = $post->slug . '.' . $extension;

            while (Storage::exists('posts/' . $namefile)) {
                $namefile = str_replace('.' . $extension, '-copia.' . $extension, $namefile);
            }

            $data['image_path'] = Storage::putFileAs('posts', $request->image, $namefile, [
                'visibility' => 'public',
            ]);

            $post->image_path = $data['image_path'];

            // Dispatch el evento como una acción separada
            // No intentes usar su valor de retorno
            event(new UploadedImage($data['image_path']));
            // O alternativamente:
            // UploadedImage::dispatch($data['image_path']);
        
        }

        $post->update($data);

        $tags = [];

        foreach ($request->tags ?? [] as $tag) {
            $tags[] = Tag::firstOrCreate(['name' => $tag]);
        }

        $post->tags()->sync($tags);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post Actualizado',
            'text' => 'Post actualizado correctamente'
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
       

        $post->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post Eliminado',
            'text' => 'Post eliminado correctamente'
        ]);

        return redirect()->route('admin.posts.index');
    }
}
