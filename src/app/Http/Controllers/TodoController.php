<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Category;

class TodoController extends Controller
{
    public function index(){
        $todos = Todo::with('category')->orderBy('deadline_day','asc')->paginate(5);
        $categories = Category::all();
        return view('index',compact('todos','categories'));
    }

    public function store(TodoRequest $request){
        $todo = $request->only(['content','category_id','deadline_day','priority']);
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
        $deadline_day = $request->deadline_day;
        $priority = $request->priority;
        $todos = Todo::with('category')
                ->categorySearch($request->category_id)
                ->keywordSearch($request->content)
                ->deadlineSearch($request->deadline_day)
                ->prioritySearch($request->priority)
                ->paginate(5)
                ->appends($request->only(['category_id','content','deadline_day','priority']));
        $categories = Category::all();
        return view('index', compact('todos', 'categories','deadline_day','priority'));
    }

        public function confirm(TodoRequest $request){
        $inputs = $request->validated();
        $category = \App\Models\Category::find($inputs['category_id']);
        $category_name = $category ? $category->name : '未設定';
        return view('confirm', compact('inputs', 'category_name'));
    }
}
