<h5 class="mb-3">Update Transaksi (Type A)</h5>

<form method="POST" action="{{ route('transactions.update', $data->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label fw-semibold">Member / Pasien <span class="text-danger">*</span></label>
        <select class="form-select" name="user_id" required>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $data->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Services & Quantity <span class="text-danger">*</span></label>
        <small class="text-muted d-block mb-2">Centang service lalu isi jumlahnya.</small>
        <div class="border rounded p-3" style="max-height: 220px; overflow-y: auto;">
            @foreach ($services as $service)
                @php
                    $isChecked = array_key_exists($service->id, $selectedServices);
                    $qty = $isChecked ? $selectedServices[$service->id] : 1;
                @endphp
                <div class="row align-items-center mb-2">
                    <div class="col-7">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_ids[]" value="{{ $service->id }}"
                                id="edit_a_svc_{{ $service->id }}" {{ $isChecked ? 'checked' : '' }}
                                onchange="toggleQtyEditA(this, {{ $service->id }})">
                            <label class="form-check-label" for="edit_a_svc_{{ $service->id }}">
                                {{ $service->service_name }}
                            </label>
                        </div>
                    </div>
                    <div class="col-5">
                        <input type="number" class="form-control form-control-sm" name="quantities[{{ $service->id }}]"
                            id="edit_a_qty_{{ $service->id }}" value="{{ $qty }}" min="1" {{ $isChecked ? '' : 'disabled' }}
                            style="width: 80px;">
                    </div>
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

<script>
    function toggleQtyEditA(checkbox, serviceId) {
        var qtyInput = document.getElementById('edit_a_qty_' + serviceId);
        if (checkbox.checked) {
            qtyInput.disabled = false;
        } else {
            qtyInput.disabled = true;
            qtyInput.value = 1;
        }
    }
</script>