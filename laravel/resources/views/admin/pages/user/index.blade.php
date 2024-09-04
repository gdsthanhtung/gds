@extends('admin.main')

@php
    use App\Helpers\Template;
    $statusFilter = Template::showButtonFilter($ctrl, $countByStatus, $params);
    $searchArea = Template::showsearchArea($ctrl, $params);
@endphp
@section('content')
    @include($pathViewTemplate . 'page_header',
    [
        'title' => $pageTitle,
        'button' => '<a href="'.route($ctrl."/form").'" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Thêm mới</a>'
    ])

    @include($pathViewTemplate.'notify')

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Bộ lọc</h5>
                        <div class="row">
                            <div class="col"> {!! $statusFilter !!} </div>
                            <div class="col"> {!! $searchArea !!} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Danh sách</h5>
                        @include($pathView.'list')
                </div>
            </div>
        </div>

        @if (count($data) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Phân trang</h5>
                        @include($pathViewTemplate.'pagination', ['title' => 'Phân trang'])
                </div>
            </div>
        </div>

        @endif
    </section>
@endsection
