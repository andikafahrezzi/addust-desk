@props(['status'])

@php
    $map = [
        'OPEN'        => ['label' => 'Open',        'class' => 'bg-status-open/10 text-status-open'],
        'IN_PROGRESS' => ['label' => 'In Progress',  'class' => 'bg-status-progress/10 text-status-progress'],
        'RESOLVED'    => ['label' => 'Resolved',     'class' => 'bg-status-resolved/10 text-status-resolved'],
        'CLOSED'      => ['label' => 'Closed',       'class' => 'bg-status-closed/10 text-status-closed'],
        'REOPENED'    => ['label' => 'Reopened',     'class' => 'bg-status-reopened/10 text-status-reopened'],
    ];

    $item = $map[$status] ?? ['label' => $status, 'class' => 'bg-slate-100 text-slate-600'];
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $item['class'] }}">
    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
    {{ $item['label'] }}
</span>