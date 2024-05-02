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
  var pais = $("#pais-usr-"+idDel).html();


  $("#id-suc-del").html(idDel);
  $("#nom-suc-del").html(nom);
  $("#st-suc-del").html(est);
  $("#dir-suc-del").html(dir);
  $("#pais-suc-del").html(pais);

};

