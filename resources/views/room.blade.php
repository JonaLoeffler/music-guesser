@extends('layouts/default')

@section('content')
<div id="room">
    <room :room="{{ $room->toJson() }}"
        :player="{{ $player->toJson() }}" />
</div>
@endsection
