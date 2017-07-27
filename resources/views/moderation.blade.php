@extends('profilelayout')
@section('content')
    <div class="page-header">
        <h3>Moderation Log</h3>
    </div>
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>User</th>
                <th>Type</th>
                <th>Target</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td><a href="/user/{{ $log->user->username }}">{{ $log->user->username }}</a></td>
                    <td>{{ $log->type . " " . $log->target_type  }}</td>
                    <?php if($log->target_type == "video") $thumb = str_replace(".webm", "", $log->getTarget()->file); ?>
                    <td @if($log->target_type == "video") data-thumb="{{ $thumb }}" @endif > @if(isset($thumb)) <a href="/{{ $log->target_id }}">{{ $log->target_id }}</a> @elseif($log->target_type == "user") <a href="/user/{{ $log->getTarget()->username }}">{{ $log->getTarget()->username }}</a> @elseif($log->target_type == "comment") kommentar test lol @endif </td>
                    <td>{{ $log->reason or 'No Reason given' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
