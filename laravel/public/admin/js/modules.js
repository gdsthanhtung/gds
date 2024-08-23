$(document).ready(function() {
	let $btnSearch        = $("button#btn-search");
	let $btnClearSearch	  = $("button#btn-clear");

	let $inputSearchField = $("input[name  = searchField]");
	let $inputSearchValue = $("input[name  = searchValue]");

	let $selectFilter     = $("select[name = searchFilter]");
	let $selectChangeAttr = $("select[name =  selectChangeAttr]");
	let $selectChangeAttrAjax = $("select[name =  selectChangeAttrAjax]");

    $.fn.datepicker.defaults.format = "dd-mm-yyyy";
    $('.datepicker').datepicker();

    $('.input-daterange input').each(function() {
        $(this).datepicker();
    });

    // START PROCESS SELECT HOPDONG TO CACL HOADON =========================================================================
    $('#hop_dong_id').on('change', function (event) {
        let hopDongList = JSON.parse($('#hop-dong-list').val());
        let yesNoEnum   = JSON.parse($('#yes-no-enum').val());
        let hoaDonEnum  = JSON.parse($('#hoa-don-enum').val());
        let isCityEnum  = JSON.parse($('#is-city-enum').val());
        let hopdongId   = $(this).val();
        let hd          = hopDongList[hopdongId];

        $('.zero').val(0);
        $('.n-a').html('N/A');

        if(hd !== undefined){
            $('#tien_phong').val(hd['gia_phong']);
            $('#is-city').html(isCityEnum[hd['is_city']]);
            $('#approve-e').html(yesNoEnum[hd['huong_dinh_muc_dien']]);
            $('#approve-w').html(yesNoEnum[hd['huong_dinh_muc_nuoc']]);
            $('#is-city-input').val(hd['is_city']);
            $('#approve-e-input').val(hd['huong_dinh_muc_dien']);
            $('#approve-w-input').val(hd['huong_dinh_muc_nuoc']);
            $('#tien_rac').val(hoaDonEnum['tienRac']);
            $('#tien_net').val(0); if(hd['use_internet'] === 1) $('#tien_net').val(hoaDonEnum['tienNet']);
        }
        processW();
        processE();
        calTongHoaDon();
    })

    $('.chi_so_dien').on('keyup', function (event) {
        processE();
    })

    $('.chi_so_nuoc').on('keyup', function (event) {
        processW();
    })

    function processE(){
        let range   = JSON.parse($('#e-range').val())['detail'];
        let moi     = Number($('#chi_so_dien').val());
        let cu      = Number($('#chi_so_dien_ky_truoc').val());
        let used    = Math.abs(moi-cu);
        if(moi == 0) return;
        if (moi < cu) {
            alert('Chỉ số mới không được nhỏ hơn chỉ số kỳ trước');
            $('#tien_dien').val(0);
            $('#chi-tiet-dien').html('N/A');
            return;
        }

        if(used > 2000) {
            alert('Lượng nước sử dụng quá lớn (hơn 2000 m3), vui lòng kiểm tra lại.');
            return;
        }

        let cost = 0;
        let eCaled = 0;
        let rPrice = [];
        let htmlDetail = '';
        for (let i = 0; i < range.length; i++) {
            let limit = range[i].limit;
            let price = range[i].price;
            let e = used - (limit + eCaled);
            if(e < 0){
                let x = used - eCaled;
                cost += x*price;
                rPrice.push([{'cs': x},{'pr': price},{'cs': x*price}]);
                htmlDetail += '<tr><th scope="row">'+(i+1)+'</th><td>'+x+'</td><td>'+vnd(price)+'</td><td>'+vnd(x*price)+'</td></tr>';
                break;
            }else{
                rPrice.push([{'cs': limit},{'pr': price},{'cs': limit*price}]);
                htmlDetail += '<tr><th scope="row">'+(i+1)+'</th><td>'+limit+'</td><td>'+vnd(price)+'</td><td>'+vnd(limit*price)+'</td></tr>';
                cost += limit*price;
            }
            eCaled += limit;
        }
        //console.log(eCaled, rPrice, cost);
        $('#su_dung_dien').val(used);
        $('#tien_dien').val(cost);

        if(htmlDetail){
            htmlDetail += '<tr><th scope="row">Tổng</th><td colspan="2">'+eCaled+'(kw)</td><td>'+vnd(cost)+'</td></tr>';
        }
        let tableHtml = '<table class="table table-bordered chi-tiet-dien-nuoc"><thead><tr><th scope="col">#</th><th scope="col">Lượng điện (kw)</th><th scope="col">Giá</th><th scope="col">Số tiền</th></tr></thead><tbody>'+htmlDetail+'</tbody></table>'
        $('#chi-tiet-dien').html(tableHtml);
    }

    function processW(){
        let range   = JSON.parse($('#w-range').val())['detail'];
        let moi     = Number($('#chi_so_nuoc').val());
        let cu      = Number($('#chi_so_nuoc_ky_truoc').val());
        let used    = Math.abs(moi-cu);
        if(moi == 0) return;
        if (moi < cu) {
            alert('Chỉ số mới không được nhỏ hơn chỉ số kỳ trước');
            $('#tien_nuoc').val(0);
            $('#chi-tiet-nuoc').html('N/A');
            return;
        }

        let hopDongList = JSON.parse($('#hop-dong-list').val());
        let hopdongId   = $('#hop_dong_id').val();
        let hd          = hopDongList[hopdongId];
        let cost        = 0;
        let htmlDetail  = 'N/A';

        if(hd == undefined){
            $('#chi-tiet-nuoc').html('<span class="text-danger">Chọn Hợp đồng trước...</span>');
            return;
        }else{
            cost = used * range[Number(hd['is_city'])];
            htmlDetail  = '<tr><th scope="row">Tổng</th><td>'+used+'(m3)</td><td>'+range[Number(hd['is_city'])]+'</td><td>'+vnd(cost)+'</td></tr>';;
        }

        $('#su_dung_nuoc').val(used);
        $('#tien_nuoc').val(cost);
        let tableHtml = '<table class="table table-bordered chi-tiet-dien-nuoc"><thead><tr><th scope="col">#</th><th scope="col">Lượng nước (m3)</th><th scope="col">Giá</th><th scope="col">Số tiền</th></tr></thead><tbody>'+htmlDetail+'</tbody></table>'
        $('#chi-tiet-nuoc').html(tableHtml);
    }

    $('.zero').on('keyup', function (event) {
        calTongHoaDon();
    })

    function calTongHoaDon(){
        let tienPhong   = Number($('#tien_phong').val());
        let tienDien    = Number($('#tien_dien').val());
        let tienNuoc    = Number($('#tien_nuoc').val());
        let tienRac     = Number($('#tien_rac').val());
        let tienNet     = Number($('#tien_net').val());
        let tienKhac    = Number($('#tien_khac').val());
        //console.log(tienDien, tienNuoc, tienPhong, tienNet, tienRac, tienKhac);
        let tong = tienDien + tienNuoc + tienPhong + tienNet + tienRac + tienKhac;
        let tc = vnd(tong);
        $('#tc').val(tc);
        $('#tong-cong').val(tong);
    }

    function vnd(data){
        return data.toLocaleString('vi-VN', {style : 'currency', currency : 'VND'});
    }
    // END PROCESS SELECT HOPDONG TO CACL HOADON =========================================================================


    // START MODAL NHAN KHAU IN HOP DONG MODULE LIST =========================================================================
    $('#nhanKhauModal4').on('show.bs.modal', function (event) {
        // Do-something...
    })

    $('#process-cccd-content').on('click', function (event) {
        let congDanContent   = $('#cccd-content').val();
        let arrContent = congDanContent.split("\n");
        console.log(arrContent);
        $('#fullname').val(arrContent[2].substr(11));
        $('#cccd_number').val(arrContent[0].substr(9));
        $('#address').val(arrContent[5].substr(16));

        let cccd_dos = arrContent[6].substr(15).replaceAll('/', '-');
        console.log(cccd_dos);

        $('#cccd_dos').val(cccd_dos);

        let dob = arrContent[4].substr(11).replaceAll('/', '-');
        $('#dob').val(dob);

        let gender = (arrContent[3].substr(11) == 'Nam') ? 'M' : 'W';
        $("#gender option[value='"+gender+"']").attr("selected", true);
    })

    function capitalizeFirstLetter(str) {
        return str[0].toUpperCase() + str.slice(1);
    }
    // END MODAL NHAN KHAU IN HOP DONG MODULE LIST ===========================================================================


    // START PROCESS LOGIC ADD NHAN KHAU VAO HOP DONG ========================================================================
    let congDanSelectedId = JSON.parse($('#congDanSelectedId').val());
    let congDanSelectedName = JSON.parse($('#congDanSelectedName').val());
    let mqhSelectedId = JSON.parse($('#mqhSelectedId').val());
    let mqhSelectedName = JSON.parse($('#mqhSelectedName').val());

    console.log(congDanSelectedId);
    console.log(congDanSelectedName);
    console.log(mqhSelectedId);
    console.log(mqhSelectedName);

    $("#add-cong-dan").click(function(e) {
		let congDanId   = $('#cong_dan_list').val();
		let congDanName = $('#cong_dan_list option:selected').html();
        let mqhId       = $('#mqh_list').val();
        let mqhName     = $('#mqh_list option:selected').html();

        if(!congDanId || !mqhId) {
            alert('Vui lòng chọn Công dân và Mối quan hệ với Chủ hộ!'); return;
        }

        congDanSelectedId.push(congDanId);
        mqhSelectedId.push(mqhId);
        congDanSelectedName.push(congDanName);
        mqhSelectedName.push(mqhName);

        console.log(congDanSelectedId);
        console.log(congDanSelectedName);
        console.log(mqhSelectedId);
        console.log(mqhSelectedName);

        $('[name="cd_id"]').val(congDanSelectedId);
        $('[name="mqh_id"]').val(mqhSelectedId);

        $("#cong_dan_list option[value='"+congDanId+"']").attr("disabled", true);
        $("#cong_dan_list option[value='"+congDanId+"']").addClass('selected-option');

        $('#cong_dan_list').find($('option')).attr('selected',false);
        $('#mqh_list').find($('option')).attr('selected',false);

        rebuildListNKSelected();
	});

	$("#listNK").on("click", "span.remove-cong-dan", function(){
        let congDanId = $(this).attr('cong-dan-id');

        var index = congDanSelectedId.indexOf(congDanId);
        if (index > -1) {
            congDanSelectedId.splice(index, 1);
            mqhSelectedId.splice(index, 1);
            congDanSelectedName.splice(index, 1);
            mqhSelectedName.splice(index, 1);
        }

        $('[name="cd_id"]').val(congDanSelectedId);
        $('[name="mqh_id"]').val(mqhSelectedId);

        $("#cong_dan_list option[value='"+congDanId+"']").attr("disabled", false);
        $("#cong_dan_list option[value='"+congDanId+"']").removeClass('selected-option');

        rebuildListNKSelected();
    });

    function rebuildListNKSelected(){
        let listNK = '';
        if(congDanSelectedId.length == 0){
            listNK = '<div class="alert alert-warning alert-dismissible init-nk-selected">Vui lòng chọn nhân khẩu từ danh sách bên cạnh!</div>';
        }else{
            for (let i = 0; i < congDanSelectedId.length; i++) {
                listNK += '<div class="alert alert-info alert-dismissible init-nk-selected">';
                listNK += '<button type="button" class="close"><span aria-hidden="true" class="remove-cong-dan" cong-dan-id="'+congDanSelectedId[i]+'">&times;</span></button>';
                listNK += congDanSelectedName[i] + ' <strong>' + '(' + mqhSelectedName[i]+') </strong>';
                listNK += '</div>';
            }
        }
        $("#listNK").html(listNK);
    }
    // END PROCESS LOGIC ADD NHAN KHAU VAO HOP DONG ========================================================================

    //Cap nhat val cua hidden input search field/type
	$("a.select-field").click(function(e) {
		e.preventDefault();

		let field 		= $(this).data('field');
		let fieldName 	= $(this).html();
		$("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
    	$inputSearchField.val(field);
	});

	$btnSearch.click(function() {
        let searchField = $inputSearchField.val();
		let searchValue = $inputSearchValue.val();
        if(searchValue.replace(/\s/g, '') == ''){
            alert('Vui lòng nhập thông tin cần tìm kiếm...');
            return;
        }

		var pathname	= window.location.pathname;
		let searchParams= new URLSearchParams(window.location.search);
		params 			= ['page', 'status'];

		let link		= "";
		$.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});
        window.location.href = pathname + "?" + link + 'searchField='+ searchField + '&searchValue=' + searchValue.replace(/\s+/g, '+').toLowerCase();
	});

	$btnClearSearch.click(function() {
		var pathname	= window.location.pathname;
		let searchParams= new URLSearchParams(window.location.search);

		params 			= ['status'];

		let link		= "";
		$.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});

		window.location.href = pathname + "?" + link.slice(0,-1);
	});

	//Event onchange select filter
	$selectFilter.on('change', function () {
		var pathname	= window.location.pathname;
		let searchParams= new URLSearchParams(window.location.search);

		params 			= ['page', 'status', 'searchField', 'searchValue'];

		let link		= "";
		$.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});

		let selectField = $(this).data('field');
		let selectValue = $(this).val();
		window.location.href = pathname + "?" + link.slice(0,-1) + 'selectField='+ selectField + '&selectValue=' + selectValue;
 	});

	// Change attributes with selectbox
	// $selectChangeAttr.on('change', function() {
	// 	let item_id = $(this).data('id');
	// 	let url = $(this).data('url');
	// 	let csrf_token = $("input[name=csrf-token]").val();
	// 	let selectField = $(this).data('field');
	// 	let selectValue = $(this).val();
	//
	// 	$.ajax({
	// 		url : url,
	// 		type : "post",
	// 		dataType: "html",
	// 		headers: {'X-CSRF-TOKEN': csrf_token},
	// 		data : {
	// 			id : item_id,
	// 			field: selectField,
	// 			value: selectValue
	// 		},
	// 		success : function (result){
	// 			if(result == 1)
	// 				alert('Bạn đã cập nhật giá trị thành công!');
	// 			else
	// 				console.log(result)
	//
	// 		}
	// 	});
	// });

	$selectChangeAttr.on('change', function() {
		let selectValue = $(this).val();
		let $url = $(this).data('url');
		window.location.href = $url.replace('value_new', selectValue);
	});

	$selectChangeAttrAjax.on('change', function() {
		let selectValue = $(this).val();
		let $url = $(this).data('url');
		let csrf_token = $("input[name=csrf-token]").val();

		$.ajax({
			url : $url.replace('value_new', selectValue),
			type : "GET",
			dataType: "json",
			headers: {'X-CSRF-TOKEN': csrf_token},
			success : function (result){
				if(result) {
					$.notify({
						message: "Cập nhật giá trị thành công!"
					}, {
						delay: 500,
						allow_dismiss: false
					});
				}else {
					console.log(result)
				}
			}
		});

	});

	//Init datepicker
	// $('.datepicker').datepicker({
	// 	format: 'dd-mm-yyyy',
	// });


	//Confirm button delete item

    $('.btn-delete').on('click', function() {
		if(!confirm('Are you sure?'))
			return false;
	});
});
