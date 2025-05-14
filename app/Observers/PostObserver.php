<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostObserver
{


    //creatin
    //mientra ase crea un modelo

    //create una vez que se creoel objeto

    //ciclo de vida de un mdelo
    public function updating(Post $post){
        if ($post->is_published == 1 && !$post->published_at) {
            $post->published_at= now();
        }//,ientras seconstruye el objet
    }


    public function update()  {
        
    }//una vez que se contruyo el objeto 

    //deleting eliminar las imagenes de post

    //delete

    public function deleting(Post $post){
        if ($post->image_path) {
            Storage::delete($post->image);
        }
    }
}
