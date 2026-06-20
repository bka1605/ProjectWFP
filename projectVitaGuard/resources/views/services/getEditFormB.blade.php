<h5 class="mb-3">Update Service (Type B)</h5>

<div class="mb-3">
    <label for="cservice_name" class="form-label fw-semibold">Service Name</label>
    <input type="text" class="form-control" id="cservice_name" value="{{ $data->service_name }}">
</div>
<div class="mb-3">
    <label for="cdescription" class="form-label fw-semibold">Description</label>
    <textarea class="form-control" id="cdescription" rows="3">{{ $data->description }}</textarea>
</div>
<div class="mb-3">
    <label for="cavailability" class="form-label fw-semibold">Availability</label>
    <input type="text" class="form-control" id="cavailability" value="{{ $data->availability }}">
</div>
<div class="mb-3">
    <label for="cprice" class="form-label fw-semibold">Price (Rp)</label>
    <input type="number" class="form-control" id="cprice" value="{{ $data->price }}">
</div>
<div class="mb-3">
    <label for="ccategory_id" class="form-label fw-semibold">Category</label>
    <select class="form-select" id="ccategory_id">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $data->category_id == $cat->id ? 'selected' : '' }}>
                {{ $cat->category_name }}
            </option>
        @endforeach
    </select>
</div>

<button type="button" class="btn btn-warning w-100" onclick="saveDataUpdate({{ $data->id }})">
    Simpan Perubahan
</button>