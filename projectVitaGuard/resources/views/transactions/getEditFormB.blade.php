<h5 class="mb-3">Update Transaksi (Type B)</h5>

<div class="mb-3">
    <label class="form-label fw-semibold">Member / Pasien</label>
    <select class="form-select" id="cuser_id">
        <option value="" disabled>-- Pilih Member --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ $data->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Services & Quantity</label>
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
                        <input class="form-check-input cservice_checkbox" type="checkbox" value="{{ $service->id }}"
                            id="edit_b_svc_{{ $service->id }}" {{ $isChecked ? 'checked' : '' }}
                            onchange="toggleQtyEditB(this, {{ $service->id }})">
                        <label class="form-check-label" for="edit_b_svc_{{ $service->id }}">
                            {{ $service->service_name }}
                        </label>
                    </div>
                </div>
                <div class="col-5">
                    <input type="number" class="form-control form-control-sm" id="cqty_{{ $service->id }}"
                        value="{{ $qty }}" min="1" {{ $isChecked ? '' : 'disabled' }} style="width: 80px;">
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Tanggal Transaksi</label>
    <input type="datetime-local" class="form-control" id="ctanggal_transaksi"
        value="{{ \Carbon\Carbon::parse($data->tanggal_transaksi)->format('Y-m-d\TH:i') }}">
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Status</label>
    <select class="form-select" id="cstatus">
        <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="completed" {{ $data->status == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ $data->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
</div>

<button type="button" class="btn btn-warning w-100" onclick="saveDataUpdate({{ $data->id }})">
    Simpan Perubahan
</button>

<script>
    function toggleQtyEditB(checkbox, serviceId) {
        var qtyInput = document.getElementById('cqty_' + serviceId);
        if (checkbox.checked) {
            qtyInput.disabled = false;
        } else {
            qtyInput.disabled = true;
            qtyInput.value = 1;
        }
    }
</script>