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
  <nav class="admin-nav">
    <button class="admin-nav__export-button" type="submit">エクスポート</button>
    <div class="admin-nav__pagination">{{ $contacts->links() }}</div>
  </nav>
  <div class="contact-table">
    <table class="contact-table__inner">
      <tr class="contact-table__row">
        <th class="contact-table__header">
          <span class="contact-table__header-span">お名前</span>
          <span class="contact-table__header-span">性別</span>
          <span class="contact-table__header-span">メールアドレス</span>
          <span class="contact-table__header-span">お問い合わせの種類</span>
        </th>
      </tr>
      @foreach ($contacts as $contact)
      <tr class="contact-table__row">
        <td class="contact-table__item">
          <form class="update-form" action="/contacts/update" method="post">
            @method('PATCH')
            @csrf
            <div class="update-form__item">
              <span class="update-form__item-input">{{ $contact['last_name'] }}　{{ $contact['first_name'] }}</span>
              <span class="update-form__item-input">{{ $contact['gender'] }}</span>
              <span class="update-form__item-input">{{ $contact['email'] }}</span>
              <span class="update-form__item-input">{{ $contact['category_id'] }}</span>
            </div>
            <div>
              <button class="contact-table__item-button" type="submit">詳細</button>
          </form>
        </td>
      </tr>
      @endforeach
  </div>
</div>
@endsection