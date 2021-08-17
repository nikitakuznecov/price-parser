$().ready(function() {

	let form = $("#price-list-form");

	let filesExt = ['csv'];

	form.validate({
		rules: {
			pricelist: {
				required: true,
				extension: "csv"
			}
		},
		messages: {
			photo: {
				required:"Входные данные проверяются",
				extension:"Файл должен быть в формате csv"
			}
		}
	});

	form.submit (function(event) {
		if (form.valid())
		{
			let bodyFormData = new FormData(document.getElementById("price-list-form"));

			axios({
				method: 'post',
				url: '/loading',
				data: bodyFormData,
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			})
				.then(function(response) {
					$.jGrowl(response.data['Message']);
                    $(".table-row").append(response.data['arrResponse']);
                    form[0].reset();
                    console.log(response.data);
				})
				.catch(function(error) {
					console.log(error);
				});
		}
		event.preventDefault(); // stop form from redirecting to java servlet page
	});

	$('input[type=file]').change(function(){
		var parts = $(this).val().split('.');
		if(filesExt.join().search(parts[parts.length - 1]) == -1){
			$.jGrowl("Файл должен быть в формате csv",{ theme: 'red_theme'});
			$(this).val('');
		}
	});

});



