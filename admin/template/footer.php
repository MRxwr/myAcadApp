					<!-- /Bordered Table -->
				
					</div>
				<!-- /Row -->
			</div>
			
			<!-- Footer -->

<footer class="footer container-fluid pl-30 pr-30">
	<div class="row">
		<div class="col-sm-12">
			<p>2020 &copy; Create-KW - E-Commerce System</p>
		</div>
	</div>
</footer>

<!-- jQuery -->
<script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- ChartJS JavaScript -->
<script src="../vendors/chart.js/Chart.min.js"></script>
<script src="dist/js/chartjs-data.js"></script>

<script>
	// Get the canvas element
var ctx = document.getElementById('myPieChart').getContext('2d');

// Define your data
var data = {
  labels: ['Label 1', 'Label 2', 'Label 3'],
  datasets: [{
    data: [30, 40, 30], // Your data values
    backgroundColor: ['red', 'blue', 'green'], // Colors for each slice
  }]
};

// Define your options
var options = {
  // You can customize various chart options here
  responsive: true,
  maintainAspectRatio: false,
};

// Create the pie chart
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: data,
  options: options,
});
</script>

<!-- Data table JavaScript -->
<script src="dist/js/dataTables-data.js"></script>
<script src="../vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="../vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/bower_components/jszip/dist/jszip.min.js"></script>
<script src="../vendors/bower_components/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/bower_components/pdfmake/build/vfs_fonts.js"></script>
<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="dist/js/export-table-data.js"></script>

<!-- Slimscroll JavaScript -->
<script src="dist/js/jquery.slimscroll.js"></script>

<!-- Owl JavaScript -->
<script src="../vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>

<!-- Sweet-Alert  -->
<script src="../vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
<script src="dist/js/sweetalert-data.js"></script>
	
<!-- Switchery JavaScript -->
<script src="../vendors/bower_components/switchery/dist/switchery.min.js"></script>

<!-- Fancy Dropdown JS -->
<script src="dist/js/dropdown-bootstrap-extended.js"></script>

<!-- Tinymce JavaScript -->
<script src="../vendors/bower_components/tinymce/tinymce.min.js"></script>
					
<!-- Tinymce Wysuhtml5 Init JavaScript -->
<script src="dist/js/tinymce-data.js"></script>

<!-- Init JavaScript -->
<script src="dist/js/init.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

			<!-- /Footer -->
			
			</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
</body>

</html>