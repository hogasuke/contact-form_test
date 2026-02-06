@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
@endsection

@section('content')
  <div class="confirm__content">
    <div class="confirm__heading">
      <h2>confirm</h2>
    </div>
    <div class="confirm-table">
      <table class="confirm-table__inner">
        <tr class="confirm-table__row">
          <th class="confirm-table__header">お名前</th>
          <td class="confirm-table__text">
            {{ $contact['last_name'] }}　{{ $contact['first_name'] }}
          </td>
        </tr>
        <tr class="confirm-table__row">
          <th class="confirm-table__header">性別</th>
          <td class="confirm-table__text">
            {{ $contact['gender'] }}
          </td>
        </tr>
        <tr class="confirm-table__row">
          <th class="confirm-table__header">メールアドレス</th>
          <td class="confirm-table__text">
            {{ $contact['email'] }}
          </td>
        </tr>
        <tr class="confirm-table__row">
          <th class="confirm-table__header">電話番号</th>
          <td class="confirm-table__text">
            {{ $contact['tel1'] }}-{{ $contact['tel2'] }}-{{ $contact['tel3'] }}
          </td>
        </tr>
        <tr class="confirm-table__row">
          <th class="confirm-table__header">住所</th>
          <td class="confirm-table__text">
            {{ $contact['address'] }}
          </td>
        </tr>
        <tr class="confirm-table__row">
          <th class="confirm-table__header">建物名</th>
          <td class="confirm-table__text">
            {{ $contact['building'] }}
          </td>
        </tr>
        <tr class="confirm-table__row">
          <th class="confirm-table__header">お問い合わせの種類</th>
          <td class="confirm-table__text">
            {{ $category['content'] }}
          </td>
        </tr>
        <tr class="confirm-table__row">
          <th class="confirm-table__header">お問い合わせ内容</th>
          <td class="confirm-table__text">
            {{ $contact['detail'] }}
          </td>
        </tr>
      </table>
    </div>
    <div class="form__button">
      <form class="form" action="/thanks" method="post">
        @csrf
        @foreach ($contact as $key => $value)
          <input type="hidden" name="{{ $key }}" value="{{ $value }}" readonly />
        @endforeach
        <button class="form__button-submit" type="submit">送信</button>
      </form>
      <form class="form" action="/back" method="post">
        @csrf
        @foreach ($contact as $key => $value)
          <input type="hidden" name="{{ $key }}" value="{{ $value }}" readonly />
        @endforeach
        <button class="form__button-back" type="submit">修正</button>
      </form>
    </div>
  </div>
@endsection