<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/vendor.min.js"></script>
<script src="js/elephant.min.js"></script> 
<script src="js/demo.min.js"></script>




<script>
$(document).ready(function(){
	
	function blink_text() {
    $('.blink').fadeOut(500);
    $('.blink').fadeIn(500);
}
setInterval(blink_text, 1000);
	
});
</script>