<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Category;

class TodoController extends Controller
{
    public function index(){
        $todos = Todo::with('category')->get();
        $categories = Category::all();
        return view('index',compact('todos','categories'));
    }

    public function store(TodoRequest $request){
        $todo = $request->only(['content','category_id']);
        Todo::create($todo);
        return redirect('/')->with('message','Todoを作成しました');
    }

    public function update(TodoRequest $request){
        $todo = $request->only(['content']);
        Todo::find($request->id)->update($todo);
        return redirect('/')->with('message','Todoを更新しました');
    }

    public function destroy(Request $request){
        Todo::find($request->id)->delete();
        return redirect('/')->with('message','Todoを削除しました');
    }

    public function search(Request $request){
        $content = $request->input('content');
        $category_id = $request->input('category_id');
        $query = Todo::query();

        if($content){
            $query->where('content','LIKE',"%{$content}%");
        }

        if($category_id) {
            $query->where('category_id', $category_id);
        }
        $todos= $query->get();
        $categories = Category::all();

        return view('index', compact('todos','categories'));
    }
}
