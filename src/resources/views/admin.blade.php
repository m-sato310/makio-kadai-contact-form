@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('link')
<form action="/logout" method="post">
    @csrf
    <input type="submit" value="logout">
</form>
@endsection

@section('content')
<h2>Admin</h2>
<form action="/search" method="get">
    @csrf
    <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
    <select name="gender" value="{{ request('gender') }}">
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
    </select>
</form>

<!-- フォームのデータ一覧の表示 -->
<table>
    <tr>
        <th>お名前</th>
        <th>性別</th>
        <th>メールアドレス</th>
        <th>お問い合わせの種類</th>
        <th></th>
    </tr>
    @foreach($contacts as $contact)
    <tr>
        <td>{{ $contact->last_name }}{{ $contact->first_name }}</td>
        <td>
            @if ($contact->gender == 1)
            男性
            @elseif($contact->gender == 2)
            女性
            @else
            その他
            @endif
        </td>
        <td>{{ $contact->email }}</td>
        <td>{{ $contact->category->content }}</td>
        <td>
            <a href="#{{ $contact->id }}">詳細</a>
        </td>
    </tr>
    @endforeach
</table>

@endsection