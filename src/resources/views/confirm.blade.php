@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')

<div class="todo__content">
    <h2>以下の内容で登録しますか？</h2>

    <form action="/todos" method="POST">
        @csrf
        <p>内容：{{ $inputs['content'] }}</p>
        <input type="hidden" name="content" value="{{ $inputs['content'] }}">

        <p>期限：{{ $inputs['deadline_day'] }}日</p>
        <input type="hidden" name="deadline_day" value="{{ $inputs['deadline_day'] }}">

        <p>優先度：{{ $inputs['priority'] }}</p>
        <input type="hidden" name="priority" value="{{ $inputs['priority'] }}">

        <p>カテゴリ：{{ $category_name }}</p>
        <input type="hidden" name="category_id" value="{{ $inputs['category_id'] }}">

        <div class="create-form__button">
            <button class="save__button-submit" type="submit">確定して保存</button>
            <button class="back__button-submit" type="button" onclick="history.back()">戻って修正</button>
        </div>
    </form>
</div>

@endsection