<div class="status">{{ $issue['state'] }}</div>
<div class="main">
    <div class="title">{{ $issue['title'] }}</div>
    <div class="info">
        <div class="id">#{{ $issue['id'] }}</div>
        <div class="time">opened {{ $issue['created_from_now'] }}</div>
        <div class="opener">by
            <a href="{{ $issue['user']['html_url'] }}">{{ $issue['user']['login'] }}</a>
        </div>
    </div>
</div>
<div class="comments">{{ $issue['comments'] }}</div>
