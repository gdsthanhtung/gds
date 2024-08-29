<script src={{ asset("admin/js/jquery/dist/jquery.min.js");}}></script>
<!-- Bootstrap -->
<script src={{ asset("admin/asset/bootstrap/dist/js/bootstrap.min.js");}}></script>
<!-- FastClick -->
<script src={{ asset("admin/js/fastclick/lib/fastclick.js");}}></script>
<!-- NProgress -->
<script src={{ asset("admin/asset/nprogress/nprogress.js");}}></script>
<!-- bootstrap-progressbar -->
<script src={{ asset("admin/asset/bootstrap-progressbar/bootstrap-progressbar.min.js");}}></script>
<!-- iCheck -->
<script src={{ asset("admin/asset/iCheck/icheck.min.js");}}></script>
<!-- Custom Theme Scripts -->
<script src={{ asset("admin/js/custom.min.js");}}></script>
<!-- Custom Modules Scripts -->
<script src={{ asset("admin/js/modules.js");}}></script>
<script src={{ asset("admin/js/moment.min.js");}}></script>

<script src={{ asset("admin/asset/datepicker/js/bootstrap-datepicker.min.js");}}></script>
<script src={{ asset("admin/asset/selectpicker/js/bootstrap-multiselect.js");}}></script>

@if(Route::current()->getName() == 'hopdong/form')
    <script src={{ asset("admin/js/hopdong.js");}}></script>
@endif
