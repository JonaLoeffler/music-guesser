@extends('layouts/default')

@section('content')
<div id="room">
    <room :room="{{ $room->toJson() }}"></room>
</div>
@endsection
