MantenedorUsuarios = {
  init: function(){
    $(document).ready(function() {

      $('#dataTable').DataTable( {
          language: {
              url: '/nullbase/public/vendor/datatables/Spanish.json'
          }
      } );
    });
    console.log("Cargue el MantenedorUsuarios.js");
  },
  eliminar: function(id){
    iziToast.question({
    timeout: 5000,
    close: false,
    overlay: true,
    displayMode: 'once',
    id: 'question',
    zindex: 999,
    title: 'Eliminar Usuario',
    message: '¿Estás seguro?',
    position: 'center',
    buttons: [
        ['<button><b>SI</b></button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'buttonYES');
        }, true],
        ['<button>NO</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'buttonNO');
        }],
    ],
    onClosing: function(instance, toast, closedBy){
        //console.info('Closing | closedBy: ' + closedBy);
        if (closedBy === 'buttonYES') {
            console.log('Eliminar al usuario ' + id);
            $.ajax({
                dataType: "json",
                cache: false,
                async: true,
                data: {id: id},
                type: "DELETE",
                url:  Base.getBaseUri() ,
                error: function (xhr, textStatus, errorThrown) {
                  iziToast.error({
                    title: 'Error',
                    message: "Problemas con el servidor, contacte a soporte.",
                  });
                },
                success: function (data) {
                    if (data.correcto) {
                      // TODO: En vez de reedireccionar que solo recargue la tabla.
                      location.href = Base.getBaseUri();
                    }else{
                      iziToast.error({
                        title: 'Error',
                        message: "No se pudo eliminar usuario.",
                      });
                    }

                }
            });
        }
    },
    onClosed: function(instance, toast, closedBy){
        //console.info('Closed | closedBy: ' + closedBy);
    }
  });
  },
  agregar : function (btn){
    //console.log('entre al agregar');
    //Base.buttonProccessStart(btn);
    var nombre        = $("#gl_nombre").val();
    var email         = $("#gl_email").val();
    var password      = $("#gl_password").val();
    var tipo_usuario  = $('#gl_tipo_usuario option:selected' ).val();
    var local         = $('#gl_locales option:selected' ).val();

    // console.log('Nombre: '+nombre);
    // console.log('Email: ' +email);
    // console.log('password: ' +password);
    // console.log('Tipo Usuario: ' +tipo_usuario);
    // console.log('Local: ' +local);

    $.ajax({
        dataType: "json",
        cache: false,
        async: true,
        data: {nombre: nombre,
               email : email,
               password: password,
               tipo_usuario:tipo_usuario,
               local:local
              },
        type: "POST",
        url:  Base.getBaseUri(),
        error: function (xhr, textStatus, errorThrown) {
          iziToast.error({
            title: 'Error',
            message: "Problemas con el servidor, contacte a soporte.",
          });
        },
        success: function (data) {
            if (data.correcto){
              location.href = Base.getBaseUri();
            }else{
              xModal.close();
              iziToast.error({
                title: 'Error',
                message: "No se pudo guardar Usuario.",
              });
            }

        }
    });

  },
  editar : function(btn){

  }


}


MantenedorUsuarios.init();
