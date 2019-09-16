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
  }


}


MantenedorUsuarios.init();
