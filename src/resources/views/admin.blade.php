@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
        <input class="search-form__item-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
        <select class="search-form__item-gender" name="gender">
          <option value="" {{ request('gender') === null || request('gender') === '' ? 'selected' : '' }}>性別</option>
          <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>男性</option>
          <option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>女性</option>
          <option value="3" {{ request('gender') === '3' ? 'selected' : '' }}>その他</option>
        </select>
        <select class="search-form__item-category" name="category">
          <option value="" {{ request('category') === null || request('category') === '' ? 'selected' : '' }}>お問い合わせの種類</option>
          @foreach ($categories as $category)
            <option value="{{ $category['id'] }}" {{ request('category') == $category['id'] ? 'selected' : '' }}>{{ $category['content'] }}</option>
          @endforeach
        </select>
        <input class="search-form__item-created-at" type="date" name="created_at" value="{{ request('created_at') }}">
        <button class="search-form__item-button-submit" type="submit">検索</button>
        <button class="search-form__item-button-reset" type="button" onclick="location.href='/admin'">リセット</button>
      </div>
    </form>
  </nav>
  <nav class="admin-nav">
    <button class="admin-nav__export-button" onclick="location.href='/admin/export' + window.location.search">エクスポート</button>
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
          <span class="contact-table__gender">{{ $contact->gender_label }}</span>
          <span class="contact-table__email">{{ $contact['email'] }}</span>
          <span class="contact-table__category">{{ $contact->category->content }}</span>
          <label for="modalToggle" class="modal-open-button">詳細</label>
          <input type="checkbox" id="modalToggle" class="modal-checkbox">
          <div class="modal" id="modal">
            <div class="modal-wrapper">
              <label for="modalToggle" class="close">&times;</label>
              <div class="modal-content">
                <h1>Sample</h1>
                <p>This is a sample modal content. <br><br>
                  You can place any text or HTML content here.<br><br>
                  Modals are useful for displaying information, alerts, or interactive elements without leaving the current page</p>
              </div>
            </div>
          </div>
      </td>
      </tr>
      @endforeach
  </div>
</div>
@endsection