@extends('layouts/default')

@section('content')
<div class="container mx-auto flex justify-center pt-5">
    <form action="{{ route('rooms.store') }}" method="post">
        @csrf
        <button type="submit"
            class="btn btn-primary p-4 text-bold"
            aria-expanded="false">
            {{ __('Create new room') }}
        </button>
    </form>
</div>
@endsection
