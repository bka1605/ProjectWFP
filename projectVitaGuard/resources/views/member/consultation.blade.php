@extends('layouts.frontend')

@section('content')
<div class="container my-4">
    <div class="mb-3">
        <h4 class="fw-bold">Konsultasi dengan {{ $booking->doctor->nama }}</h4>
        <p class="text-muted mb-0">Jadwal: {{ \Carbon\Carbon::parse($booking->jadwal)->format('d M Y H:i') }}</p>
        <span class="badge bg-{{ $booking->status === 'completed' ? 'secondary' : 'success' }}">
            {{ strtoupper($booking->status) }}
        </span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body" id="chatBox" style="height: 400px; overflow-y: auto; background:#f8f9fa;">
            @foreach ($booking->messages as $message)
                @include('consultations.bubble', ['message' => $message, 'user' => auth()->user()])
            @endforeach
        </div>

        @if ($booking->status !== 'completed')
        <div class="card-footer bg-white">
            <form id="formChat" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" id="pesanInput" name="pesan" class="form-control"
                           placeholder="Tulis pesan Anda..." required>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
        @else
        <div class="card-footer bg-white text-muted">
            Konsultasi ini sudah ditutup oleh dokter.
        </div>
        @endif
    </div>

    <a href="{{ route('member.history') }}" class="btn btn-outline-secondary mt-3">Kembali ke Riwayat</a>
</div>
@endsection

@push('script')
<script>
    var bookingId = {{ $booking->id }};

    function scrollChatToBottom() {
        var chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    scrollChatToBottom();

    $('#formChat').on('submit', function(e) {
        e.preventDefault();
        var pesan = $('#pesanInput').val();

        $.ajax({
            type: 'POST',
            url: '{{ route("consultation.send") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'booking_id': bookingId,
                'pesan': pesan
            },
            success: function(data) {
                if (data.status == 'oke') {
                    $('#chatBox').append(data.html);
                    $('#pesanInput').val('');
                    scrollChatToBottom();
                }
            }
        });
    });

    setInterval(function() {
        $.ajax({
            type: 'GET',
            url: '{{ route("consultation.fetch", $booking->id) }}',
            success: function(data) {
                if (data.status == 'oke') {
                    $('#chatBox').html(data.html);
                    scrollChatToBottom();
                }
            }
        });
    }, 5000);
</script>
@endpush
