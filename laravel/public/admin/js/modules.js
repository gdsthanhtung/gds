$(document).ready(function() {
	let $btnSearch        = $("button#btn-search");
	let $btnClearSearch	  = $("button#btn-clear");

	let $inputSearchField = $("input[name  = searchField]");
	let $inputSearchValue = $("input[name  = searchValue]");

	let $selectFilter     = $("select[name = searchFilter]");
	let $selectChangeAttr = $("select[name =  selectChangeAttr]");
	let $selectChangeAttrAjax = $("select[name =  selectChangeAttrAjax]");

    $.fn.datepicker.defaults.format = "dd-mm-yyyy";

    $('.input-daterange input').each(function() {
        $(this).datepicker('clearDates');
    });

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
