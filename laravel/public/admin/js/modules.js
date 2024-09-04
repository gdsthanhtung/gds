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


    // START PROCESS VIEW CCCD ON MODAL =========================================================================
    $('#cccdModal').on('show.bs.modal', function (event) {
        let button      = $(event.relatedTarget); // Button that triggered the modal
        let cccdfront   = JSON.parse(button.data('cccdfront'));
        let cccdrear    = JSON.parse(button.data('cccdrear'));

        let modal = $(this);
        modal.find('#modal-cccd-front').html(cccdfront);
        modal.find('#modal-cccd-rear').html(cccdrear);
      })
    // END PROCESS VIEW CCCD ON MODAL =========================================================================

    // START PROCESS SELECT HOPDONG TO CACL HOADON =========================================================================
    $('#hop_dong_id').on('change', function (e) {
        e.preventDefault();
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
            $('#is-city').html(isCityEnum[0]+': '+hd['is_city_0']+' | '+isCityEnum[1]+': '+hd['is_city_1']);
            $('#approve-e').html(yesNoEnum[hd['huong_dinh_muc_dien']]);
            $('#approve-w').html(yesNoEnum[hd['huong_dinh_muc_nuoc']]);
            $('#is-city-input').val(JSON.stringify([hd['is_city_0'], hd['is_city_1']]));
            $('#approve-e-input').val(hd['huong_dinh_muc_dien']);
            $('#approve-w-input').val(hd['huong_dinh_muc_nuoc']);
            $('#tien_rac').val(hoaDonEnum['tienRac']);
            $('#tien_net').val(0); if(hd['use_internet'] === 1) $('#tien_net').val(hoaDonEnum['tienNet']);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "prev-invoice",
                data : {'id': hopdongId, 'type': 'json'},
                type : 'GET',
                dataType : 'json',
                success : function(result){
                    if($.isEmptyObject(result) == false){
                        $('#chi_so_dien_ky_truoc').val(result.chi_so_dien);
                        $('#chi_so_nuoc_ky_truoc').val(result.chi_so_nuoc);
                        let ghiChu = (result.ghi_chu) ? ' | <span class="text-danger">'+result.ghi_chu+'</span>' : '';
                        let tuNgay = moment(result.tu_ngay).format('DD/MM/YYYY');
                        let denNgay = moment(result.den_ngay).format('DD/MM/YYYY');
                        $('#prev-invoice').html("Kỳ: "+tuNgay+' - '+denNgay+ghiChu);

                    }else{
                        $('#chi_so_dien_ky_truoc').val(Number(hd['chi_so_dien']));
                        $('#chi_so_nuoc_ky_truoc').val(Number(hd['chi_so_nuoc']));
                        $('#prev-invoice').html('-');
                    }
                }
            });
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
            //alert('Chỉ số mới không được nhỏ hơn chỉ số kỳ trước');
            $('#tien_dien').val(0);
            $('#chi-tiet-dien').html('N/A');
            return;
        }

        if(used > 2000) {
            //alert('Lượng điện sử dụng quá lớn (hơn 2000kw), vui lòng kiểm tra lại.');
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
                eCaled += x;
                break;
            }else{
                rPrice.push([{'cs': limit},{'pr': price},{'cs': limit*price}]);
                htmlDetail += '<tr><th scope="row">'+(i+1)+'</th><td>'+limit+'</td><td>'+vnd(price)+'</td><td>'+vnd(limit*price)+'</td></tr>';
                cost += limit*price;
                eCaled += limit;
            }
        }
        //console.log(eCaled, rPrice, cost);
        $('#su_dung_dien').val(used);
        $('#tien_dien').val(cost);

        if(htmlDetail){
            htmlDetail += '<tr><th scope="row">Tổng</th><td colspan="2">'+eCaled+'(kw)</td><td>'+vnd(cost)+'</td></tr>';
        }
        let tableHtml = '<table class="table table-bordered chi-tiet-dien-nuoc"><thead><tr><th scope="col">#</th><th scope="col">Lượng điện (kw)</th><th scope="col">Giá</th><th scope="col">Số tiền</th></tr></thead><tbody>'+htmlDetail+'</tbody></table>'
        $('#chi-tiet-dien').html(tableHtml);
        $('#tien-dien-detail-input').val(JSON.stringify(tableHtml));
    }

    function processW(){
        let range   = JSON.parse($('#w-range').val())['detail'];
        let moi     = Number($('#chi_so_nuoc').val());
        let cu      = Number($('#chi_so_nuoc_ky_truoc').val());
        let used    = Math.abs(moi-cu);
        if (moi < cu || moi == 0) {
            //alert('Chỉ số mới không được nhỏ hơn chỉ số kỳ trước');
            $('#tien_nuoc').val(0);
            $('#chi-tiet-nuoc').html('N/A');
            return;
        }

        let hopDongList = JSON.parse($('#hop-dong-list').val());
        let hopdongId   = $('#hop_dong_id').val();
        let hd          = hopDongList[hopdongId];
        let cost        = 0;
        let htmlDetail  = '';
        let huong_dinh_muc_nuoc = hd['huong_dinh_muc_nuoc'];
        let params      = {};
        let isCity0 = 0; //So nhan khau tinh
        let isCity1 = 0; //So nhan khau thanh pho

        let rangePrice  = [0,0];
        let rangeM3     = [0,0];
        let limitTotalM3 =  0;
        let over = 0;
        let overCost = overPrice = 0;

        if(hd == undefined){
            $('#chi-tiet-nuoc').html('<span class="text-danger">Chọn Hợp đồng trước...</span>');
            return;
        }else{
            isCity0 = hd['is_city_0']; //So nhan khau tinh
            isCity1 = hd['is_city_1']; //So nhan khau thanh pho

            rangePrice  = range['price'];
            rangeM3     = range['limitM3'];
            limitTotalM3 =  (isCity0*rangeM3[0]) + isCity1*rangeM3[1];
            over = used - limitTotalM3;
            overCost = overPrice = 0;
            if(huong_dinh_muc_nuoc == 0){
                rangePrice[0] = rangePrice[1];
            }

            if(over >= 0){
                m3ForPerson0 = (rangeM3[0]*isCity0);
                m3ForPerson1 = (rangeM3[1]*isCity1);
                overPrice = rangePrice[1];
                overCost = over * overPrice;
                if(over == 0){
                    over = overCost = overPrice = 0;
                }
            }else{
                over = overCost = overPrice = 0;
                limitM3Persion0 = (isCity0*rangeM3[0]);
                x = used - limitM3Persion0;
                if(x >= 0){
                    m3ForPerson0 = limitM3Persion0;
                    m3ForPerson1 = x;
                }else{
                    m3ForPerson0 = used;
                    m3ForPerson1 = 0;
                }
            }

            costForPerson0 = m3ForPerson0*rangePrice[0];
            costForPerson1 = m3ForPerson1*rangePrice[1];
            cost = costForPerson0 + costForPerson1 + overCost;
            htmlDetail  += '<tr><th scope="row">Tỉnh</th>           <td>'+isCity0+'</td><td>'+rangeM3[0]+'</td><td>'+m3ForPerson0+'</td><td>'+vnd(rangePrice[0])+'</td><td>'+vnd(costForPerson0)+'</td></tr>';
            htmlDetail  += '<tr><th scope="row">Thành phố</th>      <td>'+isCity1+'</td><td>'+rangeM3[1]+'</td><td>'+m3ForPerson1+'</td><td>'+vnd(rangePrice[1])+'</td><td>'+vnd(costForPerson1)+'</td></tr>';
            htmlDetail  += '<tr><th scope="row">Vượt h.mức</th>   <td>-</td><td>-</td><td>'+over+'</td><td>'+vnd(overPrice)+'</td><td>'+vnd(overCost)+'</td></tr>';
            htmlDetail  += '<tr><th scope="row">Tổng</th>           <td>'+(isCity0+isCity1)+'</td><td>-</td><td>'+used+'</td><td>-</td><td>'+vnd(cost)+'</td></tr>';


        }

        params.isCity0           = isCity0;
        params.isCity1           = isCity1;
        params.rangePrice        = rangePrice;
        params.rangeM3           = rangeM3;
        params.limitTotalM3      = limitTotalM3;
        params.over              = over;
        params.overCost          = overCost;
        params.overPrice         = overPrice;
        params.m3ForPerson0      = m3ForPerson0;
        params.m3ForPerson1      = m3ForPerson1;
        params.costForPerson0    = costForPerson0;
        params.costForPerson1    = costForPerson1;
        params.cost              = cost;
        params.used              = used;

        $('#su_dung_nuoc').val(used);
        $('#tien_nuoc').val(cost);
        let tableHtml = '<table class="table table-bordered chi-tiet-dien-nuoc"><thead><tr><th scope="col"></th><th scope="col">Nhân khẩu</th><th scope="col">Hạn mức(m&sup3;)</th><th scope="col">Sử dụng(m&sup3;)</th><th scope="col">Giá</th><th scope="col">Số tiền</th></tr></thead><tbody>'+htmlDetail+'</tbody></table>'
        $('#chi-tiet-nuoc').html(tableHtml);

        const detail = {};
        detail.param = params;
        detail.html = tableHtml;
        $('#tien-nuoc-detail-input').val(JSON.stringify(detail));
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

        $('#cccd_dos').val(cccd_dos);

        let dob = arrContent[4].substr(11).replaceAll('/', '-');
        $('#dob').val(dob);

        let gender = (arrContent[3].substr(11) == 'Nam') ? 'M' : 'W';
        $("#gender option[value='"+gender+"']").attr("selected", true);

        $('#modalCongDanQuickAdd').modal('toggle');

    })

    function capitalizeFirstLetter(str) {
        return str[0].toUpperCase() + str.slice(1);
    }
    // END MODAL NHAN KHAU IN HOP DONG MODULE LIST ===========================================================================

    //Cap nhat val cua hidden input search field/type
	$("a.select-field").click(function(e) {
		e.preventDefault();

		let field 		= $(this).data('field');
		let fieldName 	= $(this).html();
		$("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
    	$inputSearchField.val(field);
	});

	$btnSearch.on('click', function () {
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
