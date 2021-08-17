$().ready(function() {

	let form = $("#price-list-form");

	let controls = $(".control");

	let lastThree = $("#lastThree");

	let middlePrice = $("#middlePrice");

	let periodPrice = $("#periodPrice");

	let reset = $("#reset");

	let filesExt = ['csv'];

	reset.attr('disabled',true);

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
			document.body.classList.remove('loaded');
			axios({
				method: 'post',
				url: '/loading',
				data: bodyFormData,
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			})
				.then(function(response) {
					document.body.classList.add('loaded');
					$.jGrowl(response.data['Message']);
                    $(".table-row").append(response.data['arrResponse']);
                    form[0].reset();
					reset.attr('disabled',false);
				})
				.catch(function(error) {
					console.log(error);
					document.body.classList.add('loaded');
				});
		}
		event.preventDefault(); // stop form from redirecting to java servlet page
	});


	middlePrice.click (function(event) {
		document.body.classList.remove('loaded');
		controls.attr('disabled',true);
		axios({
			method: 'post',
			url: '/middlePrice'
		})
			.then(function(response) {
				document.body.classList.add('loaded');
				$.jGrowl(response.data['Message']);
				$(".table-row").append(response.data['arrResponse']);
				reset.attr('disabled',false);
			})
			.catch(function(error) {
				console.log(error);
				document.body.classList.add('loaded');
			});

		event.preventDefault(); // stop form from redirecting to java servlet page
	});

	lastThree.click (function(event) {
		document.body.classList.remove('loaded');
		controls.attr('disabled',true);
		axios({
			method: 'post',
			url: '/lastThree'
		})
			.then(function(response) {
				document.body.classList.add('loaded');
				$.jGrowl(response.data['Message']);
				$(".table-row").append(response.data['arrResponse']);
				reset.attr('disabled',false);
			})
			.catch(function(error) {
				console.log(error);
				document.body.classList.add('loaded');
			});

		event.preventDefault(); // stop form from redirecting to java servlet page
	});

	periodPrice.click (function(event) {
		document.body.classList.remove('loaded');
		controls.attr('disabled',true);
		axios({
			method: 'post',
			url: '/periodPrice'
		})
			.then(function(response) {
				document.body.classList.add('loaded');
				$.jGrowl(response.data['Message']);
				$(".table-row").append(response.data['arrResponse']);
				reset.attr('disabled',false);
			})
			.catch(function(error) {
				console.log(error);
				document.body.classList.add('loaded');
			});

		event.preventDefault(); // stop form from redirecting to java servlet page
	});

	reset.click (function(event) {
		document.body.classList.remove('loaded');
		$(this).attr('disabled',true);
		axios({
			method: 'post',
			url: '/reset'
		})
			.then(function(response) {
				document.body.classList.add('loaded');
				$(".table-row").html(response.data['arrResponse']);
				$.jGrowl(response.data['Message']);
				controls.attr('disabled',false);
			})
			.catch(function(error) {
				console.log(error);
				document.body.classList.add('loaded');
			});

		event.preventDefault(); // stop form from redirecting to java servlet page
	});

	$('input[type=file]').change(function(){
		var parts = $(this).val().split('.');
		if(filesExt.join().search(parts[parts.length - 1]) == -1){
			$.jGrowl("Файл должен быть в формате csv",{ theme: 'red_theme'});
			$(this).val('');
		}
	});

	window.onload = function () {
		document.body.classList.add('loaded_hiding');
		window.setTimeout(function () {
			document.body.classList.add('loaded');
			document.body.classList.remove('loaded_hiding');
		}, 500);
	}

});



