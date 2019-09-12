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


}


MantenedorUsuarios.init();
