<h5 class="mb-3">Update Service (Type A)</h5>

<form method="POST" action="{{ route('services.update', $data->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label fw-semibold">Service Name</label>
        <input type="text" class="form-control" name="service_name" value="{{ $data->service_name }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Description</label>
        <textarea class="form-control" name="description" rows="3" required>{{ $data->description }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Availability</label>
        <input type="text" class="form-control" name="availability" value="{{ $data->availability }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Price (Rp)</label>
        <input type="number" class="form-control" name="price" value="{{ $data->price }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Category</label>
        <select class="form-select" name="category_id" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $data->category_id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->category_name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-warning w-100">Update Service</button>
</form>