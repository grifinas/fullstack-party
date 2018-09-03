@extends('base')

@section('content')
    <div class="issue">
        @include('includes.issue')
    </div>
    <div class="issue-comments">
        @if (is_array($issue['comments_content']))
            @foreach ($issue['comments_content'] as $comment)
                <div class="comment">
                    <div class="user">{{ $comment['user']['login'] }}</div>
                    <div class="body">{{ $comment['body'] }}</div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
