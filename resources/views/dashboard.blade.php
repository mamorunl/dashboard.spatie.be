@extends('layouts/master')

@section('content')

    @javascript(compact('pusherKey'))

    <current-time grid="d1" dateformat="ddd DD/MM"></current-time>

    <google-calendar grid="d2:d3"></google-calendar>

    <last-fm grid="b1:c1"></last-fm>

    <trello grid="a2:a3"></trello>

    <rain-forecast grid="c2"></rain-forecast>

    <internet-connection grid="b2"></internet-connection>

    <rss grid="b3:c3"></rss>

    <nest grid="a1"></nest>

    <audio src="http://stream.radiocontinu.nl/radiocontinu" autoplay="true"></audio>

@endsection