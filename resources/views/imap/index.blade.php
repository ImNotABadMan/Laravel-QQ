@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="text-center"><h2>Mailboxes</h2></div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="/compose" class="btn btn-primary btn-block">Compose</a>
                    <ul class="folders list-group" >
                        @foreach($mailboxes as $mailbox)
                            <li class="list-group-item">
                                <a href="{{ route('imap', ['box' => strtolower($mailbox), 'type' => request('type', 'qq')]) }}">
                                    <i class="glyphicon glyphicon-inbox">{{ $mailbox }}</i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="text-center"><h2>Webmail - Demo - {{ $currentMailbox }}</h2></div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($list as $message)
                            <li class="list-group-item list-group-item-action">
                                <a href="/read/{{ $message->getMessageNo() }}">
                                    <div class="header">
                                        <span class="form">
                                            {{ $message->getFrom() }}
                                            <span class="text-right float-md-right">
                                                {{ $message->getDate()->format('F jS, Y h:i A') }}
                                            </span>
                                            <br />
                                        </span>
                                        {{ $message->getSubject() }}
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="text-center">
                {{ $list->render() }}
            </div>
        </div>
    </div>
@endsection

