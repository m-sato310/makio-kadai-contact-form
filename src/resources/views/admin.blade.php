@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('link')
<form action="/logout" method="post">
    @csrf
    <input class="header__link" type="submit" value="logout">
</form>
@endsection

@section('content')

<div class="admin">
    <h2 class="admin__heading content__heading">Admin</h2>
    <div class="admin__inner">
        <!-- 検索フォーム -->
        <form class="search-form" action="/search" method="get">
            @csrf
            <input class="search-form__keyword-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
            <div class="search-form__gender">
                <select class="search-form__gender-select" name="gender" value="{{ request('gender') }}">
                    <option disabled selected>性別</option>
                    <option value="1" @if( request('gender')==1 ) selected @endif>男性</option>
                    <option value="2" @if( request('gender')==2 ) selected @endif>女性</option>
                    <option value="3" @if( request('gender')==3 ) selected @endif>その他</option>
                </select>
            </div>
            <div class="search-form__category">
                <select class="search-form__category-select" name="category_id" id="">
                    <option disabled selected>お問い合わせの種類</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if( request('category_id')==$category->id ) selected @endif>{{ $category->content }}</option>
                    @endforeach
                </select>
            </div>
            <input class="search-form__date" type="date" name="date" value="{{ request('date') }}">
            <div class="search-form__actions">
                <input class="search-form__search-btn btn" type="submit" value="検索">
                <input class="search-form__reset-btn btn" type="submit" value="リセット" name="reset">
            </div>
        </form>

        <!-- エクスポートフォーム -->
        <div class="export-form">
            <form action="{{ '/export?'.http_build_query(request()->query()) }}" method="post">
                @csrf
                <input class="export_btn btn" type="submit" value="エクスポート">
            </form>
            {{-- {{ $contacts->appends(request()->query())->links('vender.pagination.custom') }} --}}
            {{ $contacts->links() }}
            <style>
                svg.w-5.h-5 {
                    /*paginateメソッドの矢印の大きさ調整のために追加*/
                    width: 30px;
                    height: 30px;
                }
            </style>
        </div>

        <!-- データの一覧表示 -->
        <table class="admin__table">
            <tr class="admin__row">
                <th class="admin__label">お名前</th>
                <th class="admin__label">性別</th>
                <th class="admin__label">メールアドレス</th>
                <th class="admin__label">お問い合わせの種類</th>
                <th class="admin__label"></th>
            </tr>
            @foreach($contacts as $contact)
            <tr class="admin__row">
                <td class="admin-data">{{ $contact->last_name }}{{ $contact->first_name }}</td>
                <td class="admin-data">
                    @if ($contact->gender == 1)
                    男性
                    @elseif($contact->gender == 2)
                    女性
                    @else
                    その他
                    @endif
                </td>
                <td class="admin-data">{{ $contact->email }}</td>
                <td class="admin-data">{{ $contact->category->content }}</td>
                <td class="admin-data">
                    <a href="#{{ $contact->id }}">詳細</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

</div>
@endsection