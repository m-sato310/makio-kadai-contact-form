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
</table>

@endsection