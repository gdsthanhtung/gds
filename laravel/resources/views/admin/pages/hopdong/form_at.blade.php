@php
    use App\Helpers\Template;
@endphp

<div class="row">
    <div class="card overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Chức năng</h5>
            <div class="row">
                <div class="col-6">
                    <p>
                        {!! Template::ct01($data['cong_dan_id'], 'NEW', true) . Template::ct01($data['cong_dan_id'], 'GH', true) !!}
                    </p>
                </div>

                <div class="col-6">
                </div>
            </div>
        </div>
    </div>
</div>
