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
        $todos = Todo::with('category')
                ->categorySearch($request->category_id)
                ->keywordSearch($request->content)
                ->get();
        $categories = Category::all();
        return view('index', compact('todos', 'categories'));
    }
}
