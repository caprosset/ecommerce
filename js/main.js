$(document).ready(function () {
    $('.toggleProducts').on('click', function (oEvent) {
        oEvent.preventDefault();

        var iProductId = $(this).attr('id');
        $('.oldOrders tr[data-product="' + iProductId + '"]').each(function () {
            $(this).fadeToggle('slow');
        });
    })

    $('div.rate').raty({ 
				path: 'lib/images',
				scoreName: 'rate' ,
				cancel      : true,
	  			cancelPlace : 'right'
		});

		$('div.fixedRate').raty({ 
				path: 'lib/images',
				readOnly: true,
				score: function() {
    				return $(this).attr('data-score');
    			}
		});
});