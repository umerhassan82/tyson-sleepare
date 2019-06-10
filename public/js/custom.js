$(document).ready(function() {

$('.product-btn').click(function(){
	$('#promo-modal').css("display", "block");
	return false;
});

$('.close-popup').click(function(){
	$('#promo-modal').css("display", "none");
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}