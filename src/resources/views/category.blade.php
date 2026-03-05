@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')

{{-- OK --}}
@if(session('message'))
<div class="category__alert">
    <div class="category__alert--success">
        {{ session('message') }}
    </div>
</div>
@endif

{{-- NG --}}
@if($errors->any())
    <div class="category__alert--danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="category__content">

    {{-- 入力枠 --}}
    <form class="create-form" action="/categories" method="POST">
        @csrf
        <div class="create-form__item">
            <input class="create-form__item-input" type="text" name="name">
        </div>

    {{-- 作成ボタン --}}
        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">作成</button>
        </div>
    </form>

    <div class="category-table">
        <table class="category-table__inner">
            <tr class="category-table__row">
                <th class="category-table__header">category</th>
                <th class="todo-table__header"></th>
                <th class="todo-table__header"></th>
            </tr>

            @foreach($categories as $category)
            <tr class="category-table__row">
                <td class="category-table__item">
                    <form class="update-form" action="/categories/update/" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="update-form__inner">
                            <input class="update-form__item-input" type="text" name="name" value="{{ $category->name }}">
                            <input type="hidden" name="id" value="{{ $category->id }}">
                            <button class="update-form__button-submit">更新</button>
                        </div>
                    </form>
                </td>
                <td class="category-table__item">
                    <form class="delete-form" action="/categories/delete" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        <button class="delete-form__button-submit">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
