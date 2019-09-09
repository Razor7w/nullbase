Home = {
  init:function(){

  },

  iniciarSesion: function(btn){
    Base.buttonProccessStart(btn);
    var email = $("#email").val();
    var password = $("#password").val();
    var mensaje = "";

    if(true){
      if (!email){
        mensaje+= '- Debe Ingresar el Email. <br>';
        errorEmail = 'Debe Ingresar el Email.';
      }else if(Base.noWhitespace(email)){
        mensaje+= '- El campo Email no debe contener espacios en blanco. <br>';
        errorEmail = 'El campo Email no debe contener espacios en blanco.';
      }else if(!Base.validarEmail(email)){
        mensaje+= '- Error en el formato del Email. <br>';
        errorEmail = 'Error en el formato del Email.';
      }else{errorEmail = "";}
      if (!password){
        mensaje+= '- Debe Ingresar la contraseña. <br>';
        errorPassword= 'Debe Ingresar la contraseña';
      }else{ errorPassword = "";}
    }

    if (mensaje == "") {
      $.ajax({
          dataType: "json",
          cache: false,
          async: true,
          data: {email: email,
                 password:password
                },
          type: "post",
          url:  Base.getBaseUri() + "auth/signin",
          error: function (xhr, textStatus, errorThrown) {
            iziToast.error({
              title: 'Error',
              message: "Problemas con el servidor, contacte a soporte.",
            });
            Base.buttonProccessEnd(btn);
          },
          success: function (data) {

              if (data.correcto) {
                location.href = Base.getBaseUri() + "dashboard";

              }else{
                Home.errorsCamposLogin(data.errorEmail,data.errorPassword,data.mensaje);
                Base.buttonProccessEnd(btn);
              }

          }
      });

    }else{
      Home.errorsCamposLogin(errorEmail,errorPassword,mensaje);
      Base.buttonProccessEnd(btn);
    }

  },
  errorsCamposLogin: function(errorEmail = "", errorPassword = "", mensaje = ""){

      if (errorEmail){
        $('#email').addClass("is-invalid");
        $('#errorEmail').text(errorEmail);
      }else if(errorEmail == ""){
        $('#email').removeClass("is-invalid");
        $('#errorEmail').text("");
      }

      if (errorPassword){
        $('#password').addClass("is-invalid");
        $('#errorPassword').text(errorPassword);
      }else if(errorPassword == ""){
        $('#password').removeClass("is-invalid");
        $('#errorPassword').text("");
      }

      if (mensaje){
        iziToast.error({
          title: 'Error',
          message: mensaje,
        });
      }
  }
}

Home.init();
