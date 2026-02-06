@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
@endsection

@section('content')
<div class="thanks__content">
  <div class="thanks__heading">
    <h2>お問い合わせありがとうございました</h2>
  </div>
</div>

<div class="home__button">
  <a href="{{ url('/') }}" class="home__button-submit" type="submit">HOME</a>
</div>

@endsection