@php
    $color = match($status) {
        'completed' => 'bg-success',
        'accepted'  => 'bg-primary',
        'rejected'  => 'bg-danger',
        default     => 'bg-warning',
    };
@endphp

<span class="badge {{ $color }} rounded-pill px-3 py-2">
    {{ ucfirst($status) }}
</span>