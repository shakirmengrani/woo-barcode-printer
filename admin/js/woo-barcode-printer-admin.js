
(function ($) {
	'use strict';
	var text = "(empty)";
	var fontSize = 8;
	var _data = [];
	function generateBarcode() {
		$("#barcode").barcode(text, "code128", { output: "css", fontSize })
	}

	function getProduct(keyword){
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data: {
				"action": "wbp_get_product",
				keyword
			},
			success: (data) => {
				_data = data;
				$("input[name='productName']").autocomplete({
					source: data.map(d => ({ id: d.id, value: d.name })),
					select: (evt, ui) => {
						text = _data.find(it => it.id == ui.item.id).sku 
						generateBarcode();
					}
				})		
			}
		})
	}

	$(window).load(function () {
		generateBarcode()
		$("input[name='productName']").on("input", evt => {
			getProduct(evt.target.value)
		});

		$("input[name='textSize']").on("change", evt => {
			fontSize = evt.target.value
			generateBarcode();
		});

		$("button[name='downloadBtn']").on('click', () => {
			domtoimage.toBlob(document.getElementById("barcode"))
			.then(blob => {
				window.saveAs(blob, 'barcode.png');
			})
			.catch(console.log)
		})
	});
})(jQuery);
