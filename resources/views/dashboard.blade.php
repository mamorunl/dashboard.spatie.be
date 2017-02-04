@extends('layouts/master')

@section('content')

    @javascript(compact('pusherKey'))

    <current-time grid="a1" dateformat="ddd DD/MM"></current-time>

    <google-calendar grid="d2:d3"></google-calendar>

    <last-fm grid="b1:c1"></last-fm>

    <trello grid="a2:a3"></trello>

    <packagist-statistics grid="b3"></packagist-statistics>

    <rain-forecast grid="c2"></rain-forecast>

    <internet-connection grid="b2"></internet-connection>

    <github-file file-name="l5-rss" grid="c3"></github-file>

    <cleaning grid="d1"></cleaning>

@endsection