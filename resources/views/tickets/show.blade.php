@extends('layouts.app')

@section('title', $ticket->ticket_number . ' · AddustDesk')
@section('page-title', $ticket->ticket_number)
@section('page-subtitle', $ticket->title)

@section('content')

    <div class="space-y-6">

        @include('tickets.partials.header')

        @include('tickets.partials.actions')

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

    </div>

@endsection