@extends('base')

@section('content')
    @foreach ($issues as $issue)
        @include('includes.clickable_issue')
    @endforeach
@endsection
