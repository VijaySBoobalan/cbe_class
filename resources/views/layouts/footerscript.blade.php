

        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="{{ url('assets/js/vendor/bootstrap/bootstrap.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/jRespond/jRespond.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/d3/d3.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/d3/d3.layout.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/rickshaw/rickshaw.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/sparkline/jquery.sparkline.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/slimscroll/jquery.slimscroll.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/animsition/js/jquery.animsition.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/daterangepicker/moment.min.js') }}"></script>
		
			<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/gcal.min.js"></script>

        <script src="{{ url('assets/js/vendor/daterangepicker/daterangepicker.js') }}"></script>

        <script src="{{ url('assets/js/vendor/screenfull/screenfull.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/mixitup/jquery.mixitup.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/flot/jquery.flot.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/flot-tooltip/jquery.flot.tooltip.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/flot-spline/jquery.flot.spline.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/easypiechart/jquery.easypiechart.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/raphael/raphael-min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/morris/morris.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/owl-carousel/owl.carousel.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/chosen/chosen.jquery.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/summernote/summernote.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/coolclock/coolclock.js') }}"></script>

        <script src="{{ url('assets/js/vendor/coolclock/excanvas.js') }}"></script>

        <script src="{{ url('assets/js/vendor/parsley/parsley.min.js') }}"></script>

        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

        <script src="{{ url('assets/js/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/datatables/extensions/ColVis/js/dataTables.colVis.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/datatables/extensions/dataTables.bootstrap.js') }}"></script>

        <!--/ vendor javascripts -->

        <!-- ============================================
        ============== Custom JavaScripts ===============
        ============================================= -->
        <script src="{{ url('assets/js/main.js') }}"></script>

        <script src="{{ url('assets/js/anytime.min.js') }}"></script>
        <!--/ custom javascripts -->
        <!--/ Page Specific Scripts -->
        <script src="{{ url('assets/js/axios.min.js') }}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
        {{-- <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script> --}}
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
		<script>
    function validatenumber(evt) {
      var theEvent = evt || window.event;

      // Handle paste
      if (theEvent.type === 'paste') {
          key = event.clipboardData.getData('text/plain');
      } else {
      // Handle key press
          var key = theEvent.keyCode || theEvent.which;
          key = String.fromCharCode(key);
      }
      var regex = /[0-9]|\./;
      if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
      }
    }
</script>

@yield('Modal')

@yield('script')
