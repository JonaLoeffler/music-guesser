@extends('layouts/default')

@section('content')
<div id="room" data-room="{{ $room }}" data-player="{{ $player }}">
</div>
@endsection

@push('scripts')
<script src="{{ mix('/js/app.js') }}" async></script>
<script src="https://sdk.scdn.co/spotify-player.js" async></script>
@endpush
