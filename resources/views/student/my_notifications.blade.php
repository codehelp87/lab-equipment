@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h5><a href="/home"> << Home </a></h5>
            <hr>
            <h5>My Notifications</h5>
             @if (Auth::user()->notifications->count() > 0)
              <div class="table-responsive">
            <table class="table table-hover table-striped notifications">
                <tbody>
                    @foreach(Auth::user()->notifications as $notification)
                    <tr>
                        <td><a href="#" class="read-notification" id="{{ $notification->notification->id }}">{{ $notification->notification->title }}</a></td>
                        <td class="text-right">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->notification->created_at)->format('Y/m/d') }}</td>
                    </tr>
                    <tr id="view-content{{ $notification->notification->id }}" style="display: none;">
                        <td colspan="2">{{ $notification->notification->content }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @else
            <h4>Notifications not available for display</h4>
            @endif
        </div>
    </div>
</div>
@endsection