//variables admitidas

var tel = new Array(4,4)
var dui = new Array(8,1)
var nit = new Array(4,6,3,1)

function mascara(d,sep,pat,nums){

if(d.valant != d.value){
	val = d.value
	largo = val.length
	val = val.split(sep)
	val2 = ''
	for(r=0;r<val.length;r++){
		val2 += val[r]	
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),"g")
				val2 = val2.replace(letra,"\n")
			}
		}
	}
	val = ''
	val3 = new Array()
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s])
		val2 = val2.substr(pat[s])
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q]
		}
		else{
			if(val3[q] != ""){
				val += sep + val3[q]
				}
		}
	}
	d.value = val
	d.valant = val
	}
}

//¡Asi se usa!
//onkeyup="mascara(this,'-',telefono,true)"


//validaciones para solo letras o solo numeros

//onkeypress="return validarLetras(event)"
function validarLetras(e,solicitar){
  // Admitir solo letras
  tecla = (document.all) ? e.keyCode : e.which;
  
  if (tecla==8) return true;
  patron =/[\D\s]/;
  te = String.fromCharCode(tecla);
  if (!patron.test(te)) return false;
  // No amitir espacios iniciales ni digitos (0-9)
}

//onkeypress="return validarNum(event)"
function validarNum(e,solicitar){
  // Admitir solo letras
  tecla = (document.all) ? e.keyCode : e.which;
  
  if (tecla==8) return true;
  patron =/[\D\s]/;
  te = String.fromCharCode(tecla);
  if (patron.test(te)) return false;
  // No amitir espacios iniciales ni letras o otro caracteres diferentes de (0-9)
}