<div class="rightbar-overlay"></div>
<!-- JAVASCRIPT -->
<script src="<?=base_url('assets/backend');?>/libs/jquery/jquery.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/metismenu/metisMenu.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/simplebar/simplebar.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/node-waves/waves.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<!-- Required datatable js -->
<script src="<?=base_url('assets/backend');?>/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?=base_url('assets/backend');?>/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/jszip/jszip.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?=base_url('assets/backend');?>/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url('assets/backend');?>/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?=base_url('assets/backend');?>/js/pages/datatables.init.js"></script> 
<script src="<?=base_url('assets/backend');?>/libs/toastr/build/toastr.min.js"></script>
<script type="text/javascript">
	$('.text-lower').keyup(function(){
	    this.value = this.value.toLowerCase();
	});
	$(document).ready(function() {
	  $('.numeric-input').on('input', function() {
	    this.value = this.value.replace(/[^0-9]/g, '');
	  });
	  $('.float-input').on('input', function() {
	      this.value = this.value.replace(/[^0-9.]/g, '');
	    });
	});
</script>