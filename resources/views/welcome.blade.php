@extends('layouts/default')

@section('content')
<form action="{{ route('rooms.store') }}" method="post">
    @csrf
    <button type="submit">{{ __('Create new room') }}</button>
</form>
@endsection
