@extends('layouts/default')

@section('content')
    <form action="{{ route('rooms.store') }}" method="post">
        <button type="submit">Create new room</button>
    </form>
@endsection
