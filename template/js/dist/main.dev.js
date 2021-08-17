"use strict";

$().ready(function () {
  // validate signup form on keyup and submit
  $("#contactform").validate({
    rules: {
      name: "required",
      phone: "required",
      email: {
        required: true,
        email: true
      },
      photo: {
        required: true,
        extension: "png|jpe?g",
        filesize: 1048576
      }
    },
    messages: {
      name: "Пожалуйста, заполните поле - Ваше имя",
      phone: "Пожалуйста, заполните поле - Ваш телефон",
      email: "Пожалуйста, заполните поле - Ваше e-mail",
      photo: "Файлы должны быть в формате JPG или PNG"
    },
    submitHandler: function submitHandler() {
      var bodyFormData = new FormData(document.getElementById("contactform"));
      axios({
        method: 'post',
        url: '/',
        data: bodyFormData,
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(function (response) {
        $.jGrowl(response.data);
        setInterval(function () {
          window.location.reload(true);
        }, 3000);
      })["catch"](function (error) {
        console.log(error);
      });
    }
  });
});