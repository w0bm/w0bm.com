@extends('profilelayout')
@section('content')
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>User</th>
                <th>Type</th>
                <th>Target</th>
            </tr>
        </thead>
        <tbody>
            @for($i = count($logs) - 1; $i >= 0; $i--)
                <tr>
                    <td><a href="/user/{{ $logs[$i]->user->username }}">{{ $logs[$i]->user->username }}</a></td>
                    <td>{{ $logs[$i]->type . " " . $logs[$i]->target_type  }}</td>
                    <?php if($logs[$i]->target_type == "video") $thumb = str_replace(".webm", "", $logs[$i]->getTarget()->file); ?>
                    <td @if($logs[$i]->target_type == "video") data-thumb="{{ $thumb }}" @endif > @if(isset($thumb)) <a href="/{{ $logs[$i]->target_id }}">{{ $logs[$i]->target_id }}</a> @elseif($logs[$i]->target_type == "user") <a href="/user/{{ $logs[$i]->getTarget()->username }}">{{ $logs[$i]->getTarget()->username }}</a> @elseif($logs[$i]->target_type == "comment") kommentar test lol @endif </td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
