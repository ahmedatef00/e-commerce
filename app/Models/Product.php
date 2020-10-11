<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
    public function cart(){
        return $this->belongsToMany(Cart::class);
    }

    public static function uploadImage($request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
  
        $imageName = time().'.'.$request->image->extension();  
   
        $request->image->move(public_path('images'), $imageName);
        return back()
        ->with('success','You have successfully upload image.')
        ->with('image',$imageName);

    }
    public function getImageAttribute()
    {
        if (!$this->attributes['image']) {
            return 'https://picsum.photos/200/300';
        }

        return $this->attributes['image'];
    }
}
