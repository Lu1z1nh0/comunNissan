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



