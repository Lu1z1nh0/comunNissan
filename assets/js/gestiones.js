/**** Ini Gestión de Usuarios ****/

//Envia el ID al input Edit
function editUsr(id){
  var idEdit = obtenerNum(id);
  $("#idupd").val(idEdit);


  var nom = $("#nom-usr-"+idEdit).html(); 
  var cor = $("#cor-usr-"+idEdit).html();
  var rol = $("#rol-usr-"+idEdit).html();
  var est = $("#st-usr-"+idEdit).html();
  var cla = $("#cla-usr-"+idEdit).html();

  if(est == "Activo") {
    var esta = 1;
  } else {
    var esta = 2;
  }

  $("#correoupd").val(cor);
  $("#nombreupd").val(nom);
  $("#rolupd option[value="+ rol +"]").attr("selected",true);
  $("#estadoupd option[value="+ esta +"]").attr("selected",true);
  $("#claveupd").val(cla);

};

//Envia el ID al input Del
function delUsr(id){
  var idDel = obtenerNum(id);
  $("#iddel").val(idDel);

  var nom = $("#nom-usr-"+idDel).html(); 
  var cor = $("#cor-usr-"+idDel).html();
  var rol = $("#rol-usr-"+idDel).html();
  var est = $("#st-usr-"+idDel).html();
  var cla = $("#cla-usr-"+idDel).html();

  $("#id-usr-del").html(idDel);
  $("#nom-usr-del").html(nom);
  $("#cor-usr-del").html(cor);
  $("#rol-usr-del").html(rol);
  $("#st-usr-del").html(est);

};

/**** Fin Gestión de Usuarios ****/


/**** Ini Gestión de Citas ****/
//Envia el ID al input Edit
function editCita(id){
  var idEdit = obtenerNum(id);
  $("#idupdcita").val(idEdit);


  var id = $("#id-cita-"+idEdit).html(); 
  var vin = $("#vin-cita-"+idEdit).html(); 
  var placa = $("#pla-cita-"+idEdit).html();
  var nombre = $("#nom-cita-"+idEdit).html();
  var apellido = $("#ape-cita-"+idEdit).html();
  var correo = $("#cor-cita-"+idEdit).html();
  var tel = $("#tel-cita-"+idEdit).html(); 
  var fecha = $("#fec-cita-"+idEdit).html();
  var hora = $("#hor-cita-"+idEdit).html();
  var state = $("#est-cita-"+idEdit).html();
  var suc = $("#suc-cita-"+idEdit).html();

  //console.log(suc);

  $("#idupdcita").val(id);
  $("#citavinupd").val(vin);
  $("#citaplaupd").val(placa);
  $("#citanameupd").val(nombre);
  $("#citaapelupd").val(apellido);
  $("#citacorreoupd").val(correo);
  $("#citatelupd").val(tel);
  $("#citafechaupd").val(fecha);
  $("#citahoraupd").val(hora);
  $('#citasucupd option[value="'+ suc +'"]').attr("selected",true);
  $('#citastateupd option[value="'+ state +'"]').attr("selected",true);
  
};

//Envia el ID al input Del
function delCita(id){
  var idDel = obtenerNum(id);
  $("#iddelcita").val(idDel);

  var id = $("#id-cita-"+idDel).html(); 
  var vin = $("#vin-cita-"+idDel).html(); 
  var placa = $("#pla-cita-"+idDel).html();
  var nombre = $("#nom-cita-"+idDel).html();
  var apellido = $("#ape-cita-"+idDel).html();
  var correo = $("#cor-cita-"+idDel).html();
  var tel = $("#tel-cita-"+idDel).html(); 
  var suc = $("#suc-cita-"+idDel).html(); 
  var fecha = $("#fec-cita-"+idDel).html();
  var hora = $("#hor-cita-"+idDel).html();
  var state = $("#est-cita-"+idDel).html();

  $("#id-cita-del").html(id);
  $("#nom-cita-del").html(nombre + ' ' + apellido);
  $("#cor-cita-del").html(correo);
  $("#tel-cita-del").html(tel);
  $("#fhr-cita-del").html(fecha + ', ' + hora);

};

/**** Fin Gestión de Citas ****/


/**** Ini Gestión de Sucursales ****/

//Envia el ID al input Edit
function editSuc(id){
  var idEdit = obtenerNum(id);
  $("#idSucUpd").val(idEdit);


  var nom = $("#nom-suc-"+idEdit).html(); 
  var est = $("#st-suc-"+idEdit).html();
  var dir = $("#dir-suc-"+idEdit).html();
  var pais = $("#pais-suc-"+idEdit).html();
  

  if(est == "Activa") {
    var esta = 1;
  } else {
    var esta = 2;
  }

  $("#nomSucUpd").val(nom);
  $("#estadoSucUpd option[value="+ esta +"]").attr("selected",true);
  $("#direccionSucUpd").val(dir);
  $("#paisSucUpd").val(pais);

};

//Envia el ID al input Del
function delSuc(id){
  var idDel = obtenerNum(id);
  $("#idSucDel").val(idDel);

  var nom = $("#nom-suc-"+idDel).html(); 
  var est = $("#st-suc-"+idDel).html();
  var dir = $("#dir-suc-"+idDel).html();
  var pais = $("#pais-suc-"+idDel).html();


  $("#id-suc-del").html(idDel);
  $("#nom-suc-del").html(nom);
  $("#st-suc-del").html(est);
  $("#dir-suc-del").html(dir);
  $("#pais-suc-del").html(pais);

};

/**** Fin Gestión de Sucursales ****/


/**** Método general para obtener los ID's ****/
//Obtiene los numeros del ID
function obtenerNum(id) {
  var tmp = id.split("");
  var map = tmp.map(function(current) {
    if (!isNaN(parseInt(current))) {
      return current;
    }
  });

  var numbers = map.filter(function(value) {
    return value != undefined;
  });

  return numbers.join("");
};