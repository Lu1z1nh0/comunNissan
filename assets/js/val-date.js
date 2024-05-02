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
  var suc = $("#suc-cita-"+idEdit).html();

  console.log(suc);

  $("#idupdcita").val(id);
  $("#citavinupd").val(vin);
  $("#citaplaupd").val(placa);
  $("#citanameupd").val(nombre);
  $("#citaapelupd").val(apellido);
  $("#citacorreoupd").val(correo);
  $("#citatelupd").val(tel);
  $("#citafechaupd").val(fecha);
  $("#citahoraupd").val(hora);
  $("#citasucupd option[value="+ suc +"]").attr("selected",true);
  
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

  $("#id-cita-del").html(id);
  $("#nom-cita-del").html(nombre + ' ' + apellido);
  $("#cor-cita-del").html(correo);
  $("#tel-cita-del").html(tel);
  $("#fhr-cita-del").html(fecha + ', ' + hora);

};




