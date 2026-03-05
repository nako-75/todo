@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')

{{-- OK --}}
@if(session('message'))
<div class="todo__alert">
    <div class="todo__alert--success">
        {{ session('message') }}
    </div>
</div>
@endif

{{-- NG --}}
@if($errors->any())
    <div class="todo__alert--danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="todo__content">
    <div class="section__title">
        <h2>新規作成</h2>
    </div>

    {{-- 入力枠 --}}
    <form class="create-form" action="/todos" method="POST">
        @csrf
        <div class="create-form__item">
            <input class="create-form__item-input" type="text" name="content">
        </div>

    {{-- カテゴリ選択枠 --}}
        <div class="create-form__item">
            <select class="create-form__item-select" name="category_id">
                <option value="">カテゴリ</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

    {{-- 作成ボタン --}}
        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">作成</button>
        </div>
    </form>

    <div class="section__title">
        <h2>Todo検索</h2>
    </div>

    {{-- 入力枠 --}}
    <form class="search-form" action="/todos/search" method="get">
        @csrf
        <div class="search-form__item">
            <input class="search-form__item-input" type="text" name="content">
        </div>

    {{-- カテゴリ選択枠 --}}
        <div class="search-form__item">
            <select class="search-form__item-select" name="category_id">
                <option value="">カテゴリ</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

    {{-- 作成ボタン --}}
        <div class="search-form__button">
            <button class="search-form__button-submit" type="submit">検索</button>
        </div>
    </form>

    {{-- リスト --}}
    <div class="todo-table">
        <table class="todo-table__inner">
            <tr class="todo-table__row">
                <th class="todo-table__header">Todo</th>
                <th class="todo-table__header">カテゴリ</th>
                <th class="todo-table__header"></th>
                <th class="todo-table__header"></th>
            </tr>

            @foreach($todos as $todo)
            <tr class="todo-table__row">
                    <td class="todo-table__item">
                        <input class="update-form__item-input" type="text" name="content" value="{{ $todo->content }}">
                        <input type="hidden" name="id" value="{{ $todo['id'] }}">
                    </td>

                    {{-- カテゴリ --}}
                    <td class="todo-table__item">
                        <span class="category-tag">{{ $todo->category->name ?? '未設定' }}</span>
                        <input type="hidden" name="category_id" value="{{ $todo->category_id }}">
                    </td>

                    {{-- 更新ボタン --}}
                    <td class="todo-table__item">
                        <form class="update-form" action="/todos/update/" method="post">
                        @method('PATCH')
                        @csrf
                        <button class="update-form__button-submit" type="submit">更新</button>
                        </form>
                    </td>

                    {{-- 削除ボタン --}}
                <td class="todo-table__item">
                    <form class="delete-form" action="/todos/delete" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" value="{{ $todo['id'] }}">
                        <button class="delete-form__button-submit">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
