@if ($data->count() > 0)
    <ul class="list-group">
        @foreach ($data as $service)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $service->service_name }}</span>
                <span class="badge bg-primary">
                    Rp {{ number_format($service->price, 0, ',', '.') }}
                </span>
            </li>
        @endforeach
    </ul>
@else
    <div class="alert alert-warning mb-0">
        Category {{ $name }} belum memiliki service.
    </div>
@endif