<div class="d-flex mb-2 {{ $message->sender_id === $user->id ? 'justify-content-end' : 'justify-content-start' }}">
    <div class="p-2 rounded-3 {{ $message->sender_id === $user->id ? 'bg-primary text-white' : 'bg-light border' }}"
         style="max-width: 70%;">
        <div class="small fw-bold mb-1">
            {{ $message->sender_id === $user->id ? 'Anda' : $message->sender->name }}
        </div>
        <div>{{ $message->pesan }}</div>
        <div class="small {{ $message->sender_id === $user->id ? 'text-white-50' : 'text-muted' }} mt-1">
            {{ $message->created_at->format('d M Y H:i') }}
        </div>
    </div>
</div>
