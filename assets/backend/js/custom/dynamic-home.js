//******** START CAR PROMOTION ********//
$(function(){
    $(".sort-div").sortable();
});
$('.add-new-brand').click(function(){
    $('#add-new-brand-promotion-modal').modal('show');
});
function add_new_car(brand_id,hcp_id){
    $.ajax({
        type:'GET',
        url:BASE_URL+'admin/dynamic-page/home/fetch-car-list-by-brand',
        data:{'brand_id':brand_id},
        dataType:'json',
        success:function(res){
            if(res.status==1){
                var html='<option value="">-Select Car-</option>';
                $.each(res.data, function (key,val) {
                    html = html+'<option value="'+val.car_id+'">'+val.car_title+' ('+val.car_model+')</option>';
                });
                $('#add-new-car-promotion-modal select[name="car_id"]').html(html);
                $('#add-new-car-promotion-modal input[name="hcp_id"]').val(hcp_id);
                $('#add-new-car-promotion-modal').modal('show');
            }else{
                alert('No car available');
            }
        }
    });
}
$("#add-new-car-promotion-modal .fetch-car-details").submit(function(e) {
    e.preventDefault();
    var actionurl = e.currentTarget.action;
    $.ajax({
        url: actionurl,
        type: 'GET',
        dataType: 'json',
        data: $("#add-new-car-promotion-modal .fetch-car-details").serialize(),
        success: function(res) {
            if(res.status==1){
                $('#add-new-car-promotion-modal .btn-close').click();
                var hcp_id = $('#add-new-car-promotion-modal input[name="hcp_id"]').val();
                var car_input = '<input type="hidden" name="car_id'+hcp_id+'[]" value="'+res.data.car_id+'">';
                var html = '<div class="col-xl-4 col-sm-6 ui-state-default ui-sortable-handle c-p car-list">'+car_input+'<div class="card text-center br-0 border border-primary"><i class="fa fa-trash delete-car-promotion"></i><div class="card-body p-2"><img src="'+BASE_URL+res.data.car_thmb_image_path+res.data.car_thmb_image+'" class="img-fluid"><h5 class="text-info">'+res.data.car_title+'</h5><h6><span class="text-mute">Model:</span> '+res.data.car_model+'</h6></div></div></div>';
                $('#homeBrandCar'+hcp_id+' .accordion-body .row.sort-div').append(html);
                $('#add-new-car-promotion-modal').modal('hide');
                $(".sort-div").sortable();
            }else{
                alert('Car not found!');
                $('#add-new-car-promotion-modal').modal('hide');
            }
        }
    });
});
$(document).on('click', '.delete-car-promotion', function(){
    $(this).parents('.car-list').remove();
});
//******** END CAR PROMOTION ********//


$('.add-new-slider').click(function(){
    $('#add-new-slider-modal').modal('show');
});
$(function() {
    $("form[name='admin-add-new-slider']").validate({
        rules: {
            slider_small_heading: {
                required: true,
            },
        },
        messages: {},
        submitHandler: function(form) {
            form.submit();
        }
    });
    $("form[name='admin-update-slider']").validate({
        rules: {
            slider_small_heading: {
                required: true,
            },
        },
        messages: {},
        submitHandler: function(form) {
            form.submit();
        }
    });
});
$("#slider_preview").on('click', function(event) {
    $('#slider_img').click();
});
slider_img.onchange = evt => {
    const [file] = slider_img.files
    if(file) {
        slider_preview.src = URL.createObjectURL(file)
    }
}
$("#edt_slider_preview").on('click', function(event) {
    $('#edt_slider_img').click();
});
edt_slider_img.onchange = evt => {
    const [file] = edt_slider_img.files
    if(file) {
        edt_slider_preview.src = URL.createObjectURL(file)
    }
}

function delete_hslider(hslider_id) {
    if(confirm("Are you sure to delete?") == true) {
        $('input[name="dlt_hslider_id"]').val(hslider_id);
        $('form[name="delete-existing-slider"]').submit();
    }
}

function edit_hslider(hslider_id, hslider_img_path, hslider_img, hslider_small_heading, hslider_big_heading, hslider_button_name, hslider_button_link) {
    $('form[name="admin-update-slider"] input[name="hslider_id"]').val(hslider_id);
    $('form[name="admin-update-slider"] input[name="slider_small_heading"]').val(hslider_small_heading);
    $('form[name="admin-update-slider"] input[name="slider_big_heading"]').val(hslider_big_heading);
    $('form[name="admin-update-slider"] input[name="slider_button_name"]').val(hslider_button_name);
    $('form[name="admin-update-slider"] input[name="slider_button_link"]').val(hslider_button_link);
    $('#edt_slider_preview').attr('src', BASE_URL + hslider_img_path + hslider_img);
    $('#update-slider-modal').modal('show');
}