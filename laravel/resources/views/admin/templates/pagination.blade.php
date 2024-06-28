@php
    $totalItems = $data->total();
    $totalPages = $data->lastPage();
    $perPage = $data->perPage();
@endphp


<div class="x_content">
    <div class="row">
        <div class="col-md-6">
            Số phần tử trên trang: <span class="label label-success label-pagination">{{ $perPage }}</span>
            Tổng số phần tử: <span class="label label-info label-pagination">{{ $totalItems }}</span>
            Tổng số trang: <span class="label label-warning label-pagination">{{ $totalPages }}</span>
        </div>
        <div class="col-md-6">
            {{ $data->appends(request()->input())->links('admin.templates.paginator_backend', ['paginator' => $data]) }}
        </div>
    </div>
</div>
