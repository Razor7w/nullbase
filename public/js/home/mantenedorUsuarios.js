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
  eliminar: function(){
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
            console.warn("Eliminar Usuario");

        }, true],
        ['<button>NO</button>', function (instance, toast) {

            instance.hide({ transitionOut: 'fadeOut' }, toast, 'buttonNO');
            console.warn("No se elimino el usuario");

        }],
    ],
    onClosing: function(instance, toast, closedBy){
        console.info('Closing | closedBy: ' + closedBy);
    },
    onClosed: function(instance, toast, closedBy){
        console.info('Closed | closedBy: ' + closedBy);
    }
  });
  }


}


MantenedorUsuarios.init();
