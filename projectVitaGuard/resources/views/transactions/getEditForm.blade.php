<h5 class="mb-3">Update Transaksi (Type A)</h5>

<form method="POST" action="{{ route('transactions.update', $data->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label fw-semibold">Member / Pasien</label>
        <select class="form-select" name="user_id" required>
            <option value="" disabled>-- Pilih Member --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $data->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Services</label>
        <div class="border rounded p-3" style="max-height: 180px; overflow-y: auto;">
            @foreach ($services as $service)
                <div class="form-check mb-1">
                    <input class="form-check-input" type="checkbox" name="service_ids[]" value="{{ $service->id }}"
                           id="edit_a_service_{{ $service->id }}" 
                           {{ in_array($service->id, $selectedServiceIds) ? 'checked' : '' }}>
                    <label class="form-check-label" for="edit_a_service_{{ $service->id }}">
                        {{ $service->service_name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Tanggal Transaksi</label>
        <input type="datetime-local" class="form-control" name="tanggal_transaksi"
               value="{{ \Carbon\Carbon::parse($data->tanggal_transaksi)->format('Y-m-d\TH:i') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Status</label>
        <select class="form-select" name="status" required>
            <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ $data->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $data->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>

    <button type="submit" class="btn btn-warning w-100">Update Transaksi</button>
</form>