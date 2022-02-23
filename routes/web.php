<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return "Hello welcome to about page";
});

Route::get('/contact', function () {
    return "Hello welcome to contact page";
});

Route::get('/view/post/{id}', function ($id) {
    return "This is post number ".$id;
});

Route::get('manage/view/post/assignment', array('as'=>'assignment.view', function () {
    $url=route('assignment.view');
    return $url;
}));

// Route::get('/post/{id}','App\Http\Controllers\PostController@index');

// Route::resource('posts','App\Http\Controllers\PostController');

Route::get('/contact','App\Http\Controllers\PostController@contact');

Route::get('/post/{id}/{name}','App\Http\Controllers\PostController@showPost');


//RAW SQL


Route::get('/insert',function(){
    $myTime=time();
    DB::insert('INSERT INTO posts (title, body) VALUES (?, ?)', ['PHP Laravel New '.$myTime, 'Laravel is the best framework in PHP']);
});

Route::get('/view',function(){
    $results=DB::select('SELECT * FROM posts WHERE id = ?', [1]);

    foreach ($results as $result) {
        echo $result->title;
    }
});

Route::get('/update',function(){
    $results=DB::update('UPDATE posts SET title="updated title" WHERE id=?',[1]);
    echo $results;

});

Route::get('/delete',function(){
    $results=DB::delete('DELETE FROM posts WHERE id=?',[1]);
    echo $results;

});


//ELOQUENT ORM

Route::get('/read',function(){
$post= Post::all();
foreach ($post as $p) {
    echo $p->title.'<br>';
}
});

Route::get('/read/{id}',function($id){
    $post= Post::find($id);
    echo $post->title;
    // foreach ($post as $p) {
    //     echo $p->title;
    // }
    });

Route::get('/find/{id}', function ($id) {
    $posts=Post::where('id',2)->get();
    echo $posts;
});

Route::get('/review/{id}', function ($id) {
    $posts=Post::findOrFail($id)->get();
    echo $posts;
});

Route::get('/save',function(){
    $post=new Post();
    $post->title="ELOQUENT";
    $post->body="WOW ELOQUENT IS TRULY AMAZING";
    $post->save();
});

Route::get('/create',function(){
    Post::create(['title'=>'Sweet Laravel', 'body'=>'Laravel is a verfy powerful framework come on try it guys']);
});


Route::get('/update',function(){
    Post::where('id',2)
    ->update([
        'title'=>'Newly updated title',
        'body'=>'Always up to date'
    ]);
});

Route::get('/delete/{id}',function($id){
    // $post= Post::find($id);
    // $post->delete();

});

Route::get('/soft/delete/{id}', function ($id) {
    $post= Post::find($id);
    $post->delete();

});

Route::get('/view/trash/{id}', function ($id) {
    //$post= Post::withTrashed()->where('id',$id)->get();

    $post= Post::onlyTrashed()->get();
    echo $post;
});

Route::get('/restore/{id}',function($id){
    $post= Post::withTrashed()->where('id',$id);
    $post->restore();

});

Route::get('/delete/permanent/{id}',function($id){
    $post= Post::withTrashed()->where('id',$id);
    $post->forceDelete();

});

Route::get('/user/{id}/post/',function($id){
    return User::find($id)->post();

});
