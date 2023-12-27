var quantityArray = [0];
var count_products = 0;
$(document).ready(function (){
	$.post("count_products.php",function(data){
		count_products = data;
		for(i=1;i<=count_products;i++){
		quantityArray[i] = 0;
		}
	});
});
$('.quantity').keyup(function(){
	var total_price = 0;
	var current_id = $(this).attr('id');
	var quantity = $('#'+current_id).val();
	if($.trim(quantity).length == 0){
		quantityArray[current_id] = 0;
		$('#totalPrice'+current_id).html("");
	}
	else{
		if(quantity.match(/^\d+(?:\.\d+)?$/)){
			$.ajax({
				type: 'POST',
				async: false,
				url: 'php/calTotal.php',
				data: 'quantity='+quantity+"&current_id="+current_id,
				success: function(data){
					$('#totalPrice'+current_id).html(data);
					quantityArray[current_id] = parseFloat(data);
				}
			});
		}
		else{
			$('#totalPrice'+current_id).html("Invalid Quantity");
		}
	}
	for(i=1;i<=count_products;i++){
		total_price = parseFloat(total_price + quantityArray[i]);
	}
	$('#txtFinalAmount').val(total_price.toFixed(2));
});