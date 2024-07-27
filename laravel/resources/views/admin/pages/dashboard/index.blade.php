@extends('admin.main')

@section('content')
    <div class="right_col" role="main">
        <div class="page-header zvn-page-header clearfix">
            <div class="zvn-page-header-title">
                <h3>Dashboard</h3>
            </div>
        </div>

        <!--box-lists-->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @include($pathViewTemplate.'notify')
            </div>
        </div>
        <!--end-box-lists-->
    </div>
@endsection
