$('#pointspossible').on('input', function() {
  calculate();
});
$('#pointsgiven').on('input', function() {
 calculate();
});
function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
function calculate() {
    var a = $('#pointspossible').val().replace(/ +/g, "");
    var b = $('#pointsgiven').val().replace(/ +/g, "");
    var perc = "0";
    if (a.length > 0 && b.length > 0) {
        if (isNumeric(a) && isNumeric(b)) {
            perc = a-(a / 100 * b);
        }
    }    
    // console.log(a,b);
    $('#pointsperc').val(perc);
}
$('input[name="uimg"]').on('change', function(e) {
    var fileName = $(this).val().split('\\').pop();
    var fileExtension = fileName.split('.').pop();
    $('input[name="invoice_file_extension"]').val(fileExtension);
    if(fileExtension == 'pdf'){
        $('#imagepreview').css('display','none');
        $('#pdfViewer').css('display','block');
         var file = e.target.files[0];
         var reader = new FileReader();
         reader.onload = function(e) {
           var pdfViewer = $('#pdfViewer');
           pdfViewer.empty(); // Clear previous content
           // Create an <embed> element to display the PDF file
           var embedElement = $('<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="100%">');
           pdfViewer.append(embedElement);
         };
         reader.readAsDataURL(file);
    }
    else{
        $('#imagepreview').css('display','block');
        $('#pdfViewer').css('display','none');
        var fileInput = $(this)[0];
        var thumbnailImage = $('#thummb_image');
        if (fileInput.files && fileInput.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            thumbnailImage.attr('src', e.target.result);
          };
          reader.readAsDataURL(fileInput.files[0]);
        }
    }
    $('#pdfviewmodal').modal('show');
  });
$('select[name="retired"]').change(function(){
    if($(this).val() == 'Yes'){
        $('input[name="retired_date"]').removeAttr('readonly');
        $('#retired_date_field_null').css('display','none');
        $('#retired_date_field_date').css('display','block');
    }
    else{
        $('input[name="retired_date"]').prop('readonly', true).val('');
        $('#retired_date_field_null').css('display','block').prop('readonly', true);
        $('#retired_date_field_date').css('display','none');
    }
});
$('input[name="generate_serial_number"]').change(function(){
    if ($(this).prop('checked')) {
      var hiddenSrNumber = $('input[name="hiddenSrNumber"]').val(); 
      $('input[name="serial_no"]').val(hiddenSrNumber);
    } else {
      $('input[name="serial_no"]').val('');
    }
});
function fetch_sub_category(main_category_id){
    if(main_category_id != ''){
        $('#ajax-loader').append("<div class='page-loader-overlay'></div><div class='page-loader'></div>");
        $.ajax({
            type: 'GET',
            url: BASE_URL+'admin/product/fetch-sub-category',
            data: {'main_category_id' : main_category_id},
            dataType: 'json',
            success: function(result){
                $('.page-loader-overlay, .page-loader').fadeOut(100, function() {
                    $(this).remove();
                });
                console.log(result);
                $('select[name="scid"]').html(result.sub_cat_design);
                if(result.cat_has_barcode == 'Y'){
                    $('input[name="barcode"]').val(result.TheBarcode).removeAttr('disabled').prop('readonly', true);
                }
                else{
                    $('input[name="barcode"]').val('').prop('disabled', true).prop('placeholder', 'THIS FIELD IS DISABLED FOR THIS CATEGORY');
                }
                if(result.cat_has_closing_asset_value == 'Y'){
                    $('input[name="closing_value"]').val('').removeAttr('disabled').prop('readonly', true).prop('placeholder', 'This field is auto generated');
                }
                else{
                    $('input[name="closing_value"]').val('').prop('disabled', true).prop('placeholder', 'THIS FIELD IS DISABLED FOR THIS CATEGORY');
                }
                if(result.cat_has_depriciation == 'Y'){
                    $('input[name="depriciation"]').val('').removeAttr('disabled').removeAttr('readonly').removeClass('disabled-field').prop('placeholder', '%');
                }
                else{
                    $('input[name="depriciation"]').val('').prop('disabled', true).addClass('disabled-field').prop('placeholder', 'THIS FIELD IS DISABLED FOR THIS CATEGORY');
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
}
 $(function() {
    $("form[name='insert-form']").validate({
      rules: {
        cid: {
          required: true,
        },
        scid: {
          required: true,
        },
        pname: {
          required: true,
        },
        pqty: {
          required: true,
        },
        original_cost: {
          required: true,
        },
        serial_no: {
          required: true,
        },
      },
      messages: {
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  });