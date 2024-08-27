$(document).ready(function() {
    // START PROCESS LOGIC ADD NHAN KHAU VAO HOP DONG ========================================================================
    let congDanSelectedId = JSON.parse($('#congDanSelectedId').val());
    let congDanSelectedName = JSON.parse($('#congDanSelectedName').val());
    let mqhSelectedId = JSON.parse($('#mqhSelectedId').val());
    let mqhSelectedName = JSON.parse($('#mqhSelectedName').val());

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

});
