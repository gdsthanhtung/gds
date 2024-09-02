<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Vendor JS Files -->
<script src="{{ asset('admin/asset/nice-admin/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('admin/asset/nice-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/asset/nice-admin/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('admin/asset/nice-admin/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('admin/asset/nice-admin/vendor/quill/quill.js') }}"></script>
<script src="{{ asset('admin/asset/nice-admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('admin/asset/nice-admin/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('admin/asset/nice-admin/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('admin/asset/nice-admin/js/main.js') }}"></script>

<!-- Custom Modules Scripts -->
<script src="{{ asset('admin/js/modules.js') }}"></script>
<script src="{{ asset('admin/js/moment.min.js') }}"></script>

<script src="{{ asset('admin/asset/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('admin/asset/selectpicker/js/bootstrap-multiselect.js') }}"></script>

@if(Route::current()->getName() == 'hopdong/form')
    <script src="{{ asset('admin/js/hopdong.js') }}"></script>
@endif
