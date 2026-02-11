@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('button')
  <form action="/logout" method="post">
    @csrf
    <button type="submit" class="header-nav__item--button">logout</button>
  </form>
@endsection

@section('content')
<div class="contact-form__content">
  <div class="contact-form__heading">
    <h2>Admin</h2>
  </div>
  <nav class="admin-nav">
    <ul>
      <input class="admin-nav__keyword" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください">
      <select class="admin-nav__gender" name="gender">
        <option value="" selected>性別</option>
        <option value="1">男性</option>
        <option value="2">女性</option>
        <option value="3">その他</option>
      </select>
      <select class="admin-nav__category" name="category">
        <option value="" selected>お問い合わせの種類</option>
        <option value="1">男性</option>
        <option value="2">女性</option>
        <option value="3">その他</option>
      </select>
      <input type="date"></input>
      <button class="admin-nav__button" type="submit">検索</button>
      <button class="admin-nav__button--reset" type="submit">リセット</button>
    </ul>
  </nav>
</div>
{{ $contacts->links() }}
@endsection