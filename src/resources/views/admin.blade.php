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
    <form class="search-form" action="/admin/search" method="get">
      @csrf
      <div class="search-form__item">
        <input class="search-form__item-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください">
        <select class="search-form__item-gender" name="gender">
          <option value="">性別</option>
          <option value="1" @selected(request('gender')=='1')>男性</option>
          <option value="2" @selected(request('gender')=='2')>女性</option>
          <option value="3" @selected(request('gender')=='3')>その他</option>
        </select>
        <select class="search-form__item-category" name="category">
          <option value="" selected>お問い合わせの種類</option>
          @foreach ($categories as $category)
            <option value="{{ $category['id'] }}" @selected(request('category') == $category['id'])>{{ $category['content'] }}</option>
          @endforeach
        </select>
        <input type="date">
        <button class="search-form__item-button-submit" type="submit">検索</button>
        <button class="search-form__item-button-reset" type="button" onclick="location.href='/admin'">リセット</button>
      </div>
    </form>
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
          <span class="contact-table__name">{{ $contact['last_name'] }}　{{ $contact['first_name'] }}</span>
          <span class="contact-table__gender">{{ $contact['gender'] }}</span>
          <span class="contact-table__email">{{ $contact['email'] }}</span>
          <span class="contact-table__category">{{ $contact['category_id'] }}</span>
          <span class="contact-table__detail"></span>
      </td>
      </tr>
      @endforeach
  </div>
</div>
@endsection