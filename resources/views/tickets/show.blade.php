@extends('layouts.app')

@section('content')

@include('tickets.partials.header')

@include('tickets.partials.timeline')

@include('tickets.partials.conversation')

@include(
    'tickets.partials.composer',
    [
        'ticket' => $ticket,
        'messageStoreRoute' => $messageStoreRoute,
        'canReply' => $canReply,
    ]
)

@endsection