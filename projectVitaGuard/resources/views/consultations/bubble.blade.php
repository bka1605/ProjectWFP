@php
    $isOwn = $message->sender_id === $user->id;
@endphp

<div class="d-flex mb-2 {{ $isOwn ? 'justify-content-end' : 'justify-content-start' }}">
    <div class="p-2 px-3 rounded-pill {{ $isOwn ? 'bg-primary text-white' : 'bg-light text-dark' }}"
        style="max-width: 70%;">
        {{ $message->pesan }}
        <div class="small {{ $isOwn ? 'text-white-50' : 'text-muted' }}" style="font-size: 0.7rem;">
            {{ $message->created_at->format('H:i') }}
        </div>
    </div>
</div>