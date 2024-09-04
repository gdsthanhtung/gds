@php
    $totalItems = $data->total();
    $totalPages = $data->lastPage();
    $perPage = $data->perPage();
@endphp

<div class="x_content">
    <div class="row">
        <div class="col-md-6">
            Số phần tử trên trang: <span class="badge bg-success">{{ $perPage }}</span>
            Tổng số phần tử: <span class="badge bg-warning">{{ $totalItems }}</span>
            Tổng số trang: <span class="badge bg-info">{{ $totalPages }}</span>
        </div>
        <div class="col-md-6">
            {{ $data->appends(request()->input())->links('admin.templates.paginator_backend', ['paginator' => $data]) }}
        </div>
    </div>
</div>
