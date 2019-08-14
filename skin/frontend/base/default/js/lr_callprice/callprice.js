Event.observe(window, 'load', function() {
		var iDiv = document.createElement('div');
		iDiv.id = 'output-div';
		iDiv.className = 'output-div';
		document.getElementsByClassName('footer-container')[0].appendChild(iDiv);

	});
function loadCallForPriceForm(reloadurl)
{

    new Ajax.Request(reloadurl, {
		method: 'post',
		parameters: Form.serialize($('product_addtocart_form')),
        onSuccess: function(transport) {
            /*$('output-div').innerHTML = "";
             $('output-div').innerHTML = transport.responseText;
             $('output-div').addClassName('output-div');*/
            var json = transport.responseText.evalJSON();
            var displayString = json.message;
            if(json.success) {
                jQuery('body').append('<div id="output-div"></div>');
                jQuery('#output-div').html('');
                jQuery('#output-div').html(json.request_form);
                jQuery.fancybox({
                    type: 'ajax',
                    width:400,
                    height:300,
                    fitToView: false,
                    content: jQuery('#output-div'),
                    modal: false
                });
            }
        }
	});
}

function submitcallforpriceform(f,submiturl){
        new Ajax.Request(submiturl, {
            method: 'post',
            parameters:Form.serialize($('cp_form')),
            onSuccess: function(transport) {
                var json = transport.responseText.evalJSON();
                var displayString = json.message;
                if(json.success) {
                    jQuery('#messages_product_view').html('<ul class="messages"><li class="success-msg"><ul><li><span>'+displayString+'</span></li></ul></li></ul>');
                    jQuery.fancybox.close();
                }
                else
                {
                    jQuery('#messages_product_view').html('<ul class="messages"><li class="error-msg"><ul><li><span>'+displayString+'</span></li></ul></li></ul>');
                }
            }
        });
}