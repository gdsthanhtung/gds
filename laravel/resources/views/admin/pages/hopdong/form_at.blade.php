@php
    use App\Helpers\Template;
@endphp

<div class="row">
    <div class="card overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Chức năng</h5>
            <div class="row">
                <div class="col-12">
                    {!! Template::hdtn($data['id'], 'hdtn',) !!}
                    <hr>
                    {!! Template::ct01($data['cong_dan_id'], 'NEW', true) . Template::ct01($data['cong_dan_id'], 'GH', true) !!}
                </div>
            </div>
        </div>
    </div>
</div>
