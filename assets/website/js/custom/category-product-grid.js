$('input[name="brand"]').on('change', function(){
   var $boxes = $('input[name="brand"]:checked');
   var html = '';
   $boxes.each(function(brand){
      html = html+'<input type="hidden" name="brands[]" value="'+$(this).val()+'">';
   });
   $('.brand_sort').html(html);
});
$('.custom-book-day').keyup(function(event){
   var booking_cus_day = $(this).val();
   if(booking_cus_day!=''){
      $('.booking-day input[name="booking_day"]').prop("checked",false);
   }else{
      $('.booking-day input[name="booking_day"]').prop("checked",false);
      $('.booking-day input[name=booking_day][value=1]').prop("checked",true);
   }
});
$('.booking-day input[name="booking_day"]').on('change', function(){
   $('.booking-day input[name="booking_day"]').prop("checked",false);
   $(this).prop("checked",true);
   $('input[name="booking_cus_day"]').val('');
});