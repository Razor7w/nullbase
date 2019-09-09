var Base = {
  /**
   * Cambia apariencia de btn miestras se realiza una acción o procesamiento
   * @param  {[type]} btn     [description]
   * @param  {[type]} message [description]
   * @return {[type]}         [description]
   */
  buttonProccessStart : function(btn, message='Procesando'){
    var $this = this;
    $this.btnText = $(btn).attr('disabled',true).html();
    $(btn).html('<i class="fa fa-spin fa-spinner"></i>');
  },
  buttonProccessEnd : function(btn){
    var $this = this;
    $(btn).html($this.btnText).attr('disabled',false);
  },
  /**
   * Obtener url base de ejecucion
   * @returns {string}
   */
  getBaseUri : function(){
      var host = window.location.host;
      var protocol = window.location.protocol;
      var url = window.location.pathname;
      url = url.split("index.php");
      if(url[0] !== undefined){
          var base_uri = protocol + "//" + host + url[0];
      }else{
          var base_uri = protocol + "//" + host ;
      }
      return base_uri;
  },
  /**
   * Validar formato de email
   * @param email
   * @returns {boolean}
   */
  validarEmail : function(email){
      if(email === "")
          return false;

      var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email) ? true : false;
  },
  /**
   * Validar string sin espacios en blanco
   * @param string
   * @returns {boolean}
   */
   noWhitespace: function (string){

     if (string === "")
       return false;

     var regex = /\s/;
     return regex.test(string) ? true : false;

   }
}
