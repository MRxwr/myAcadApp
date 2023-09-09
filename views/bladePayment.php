<?php
if( isset($_POST["data"]) && !empty($_POST["data"]) ){
    
}else{
    ?>
	<script>
	window.onload = function() {
		alert("<?php echo direction("Erorr while loading payment data.","حدث خطأ اثناء تحميل بيانات الدفع.") ?>");
		window.location.href = "?v=Home";
	};
	</script>
	<?php
}
?>