'use strict';

(function ($) {
	var EventManager = {
		subscribe: function(event, fn) {
			$(this).bind(event, fn);
		},
		publish: function(event, data) {
			$(this).trigger(event, [data]);
		}
	};
	let barcodes = [];
	let sku = ""
	function getProduct(keyword){
		$.ajax({
			method: "POST",
			url: ajaxurl,
			data: {
				"action": "wbp_get_product",
				keyword
			},
			success: (data) => {
				$("input[name='productName']").autocomplete({
					source: data.map(d => ({ id: d.id, value: d.name })),
					select: (evt, ui) => {
						sku = data.find(it => it.id == ui.item.id).sku
					}
				})		
			}
		})
	}

	$(window).load(function () {
		EventManager.subscribe("render", function(event, data) {
			$("#barcodeContainer").html("")
			barcodes.forEach((barcode, index) => {
				const removeBtn_click = (evt) => {
					barcodes = barcodes.filter(b => b.text !== evt.target.dataset.sku)
					EventManager.publish('render')
				}
				let code = $("<canvas></canvas>")[0]
				JsBarcode(code, barcode.text,{
					displayValue: true,
					width:2,
					height:100,
					quite: 10,
					format:barcode.type,
					backgroundColor:"#fff",
					lineColor:"#34495e",
					fontSize: barcode.fontSize
				})
				// let code = $("<div class='barcode'></div>").barcode(barcode.text, barcode.type, {fontSize: barcode.fontSize});
				let row = $("<div class='barcode col-33ptg centerItem'></div>").append(code)
				let removeBtn = $("<button name='removeBtn' data-sku='" + barcode.text + "' class='redBtn'>&times;</button>").on('click', removeBtn_click) 
				row.append(removeBtn)
				$("#barcodeContainer").append(row)
			});
		});
		$("input[name='productName']").on("input", evt => {
			getProduct(evt.target.value)
		});
		$("button[name='generateBtn']").on('click', () => {
			if(sku.length){
				barcodes.push({text: sku, fontSize: $("input[name='textSize']").val(), type: "code128"});
				EventManager.publish("render")
			}
		})
		$("button[name='downloadBtn']").on('click', () => {
			$("#barcodeContainer").find("button").hide()
			domtoimage.toBlob(document.getElementById("barcodeContainer"))
			.then(blob => {
				window.saveAs(blob, 'barcode.png')
				$("#barcodeContainer").find("button").show()
			}).catch(error => {
				console.log(error)
				$("#barcodeContainer").find("button").hide()
			})
		})
	});
})(jQuery);
