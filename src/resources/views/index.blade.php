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
    <form class="create-form" action="/confirm" method="POST">
        @csrf
        <div class="create-form__item is-main">
            <label for="content" class="create-form__label">Todo内容</label>
            <input class="create-form__item-input @error('content') is-invalid @enderror" type="text" name="content" value="{{ old('content') }}">
        </div>

        {{-- 期限 --}}
        <div class="mb-3">
            <label for="deadline_day" class="form-label">期限（日）</label>
            <select name="deadline_day" id="deadline_day" class="form-select">
                <option value="" selected disabled>日を選択してね</option>
                @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}" {{ old('deadline_day') == $i ? 'selected' : ''}}>{{ $i }}日</option>
                @endfor
            </select>
            @error('deadline_day')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 優先度 --}}
        <div class="mb-3">
            <label class="form-label d-block">優先度：</label>
            @foreach(['高','中','低'] as $p)
            <div class="form-check form-check-inline">
                <input class="form-check-input @error('priority') is-invalid @enderror" type="radio" name="priority" id="priority_{{ $p }}" value="{{ $p }}" {{ old('priority') == $p ? 'checked' : ''}}>
                <label class="form-check-label" for="priority_{{ $p }}">{{ $p }}</label>
            </div>
            @endforeach
            @error('priority')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
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

    <hr class="section-divider">

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
                    <option value="{{ $category->id }}" {{ ($category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="search-form__item">
            <select class="search-form__item-select" name="deadline_day">
                <option value="">日を選択</option>
                @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}" {{ ($deadline_day ?? '') == $i ? 'selected' : '' }}>
                        {{ $i }}日
                    </option>
                @endfor
            </select>
        </div>

        <div class="search-form__item">
            <select class="search-form__item-select" name="priority">
                <option value="">優先度</option>
                <option value="高" {{ ($priority ?? '') == '高' ? 'selected' : '' }}>高</option>
        <option value="中" {{ ($priority ?? '') == '中' ? 'selected' : '' }}>中</option>
        <option value="低" {{ ($priority ?? '') == '低' ? 'selected' : '' }}>低</option>
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
                <th class="todo-table__header">期限</th>
                <th class="todo-table__header">優先度</th>
                <th class="todo-table__header"></th>
                <th class="todo-table__header"></th>
            </tr>

            @foreach($todos as $todo)
            <tr class="todo-table__row">
                <form class="update-form" action="/todos/update/" method="post">
                    @method('PATCH')
                    @csrf
                    <td class="todo-table__item">
                        <input class="update-form__item-input" type="text" name="content" value="{{ $todo->content }}">
                        <input type="hidden" name="id" value="{{ $todo['id'] }}">
                    </td>

                    {{-- カテゴリ --}}
                    <td class="todo-table__item">
                        <span class="category-tag">{{ $todo->category->name ?? '未設定' }}</span>
                        <input type="hidden" name="category_id" value="{{ $todo->category_id }}">
                    </td>

                    {{-- 期限 --}}
                    <td class="todo-table__item">
                        <span class="deadline-tag">{{ $todo->deadline_day }}日</span>
                        <input type="hidden" name="deadline_day" value="{{ $todo->deadline_day }}">
                    </td>

                    {{-- 優先度 --}}
                    <td class="todo-table__item">
                        <span class="priority-tag">{{ $todo->priority }}</span>
                        <input type="hidden" name="priority" value="{{ $todo->priority }}">
                    </td>

                    {{-- 更新ボタン --}}
                    <td class="todo-table__item">
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

        <div class="todo-pagination">
            {{ $todos->links() }}
        </div>
    </div>
</div>
@endsection
