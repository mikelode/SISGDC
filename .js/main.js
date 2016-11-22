function cargarModulo(desde)
{
	$("#main").load(desde);
}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function limpiar()
{
	document.getElementById("mensaje").style.display="none";
	document.getElementById("usuario").value="";
	document.getElementById("password").value="";
	document.getElementById("usuario").focus();
}

function ingresar()
{
	var anio = new Date().getFullYear();
	var mes = new Date().getMonth()+1;
	var dia = new Date().getDate();
	var hora = new Date().getHours();
	var minuto = new Date().getMinutes();
	var segundo = new Date().getSeconds();

	if (mes<10)
		mes = "0"+mes;
	if (dia<10)
		dia = "0"+dia;
	if (hora<10)
		hora = "0"+hora;
	if (minuto<10)
		minuto = "0"+minuto;
	if (segundo<10)
		segundo = "0"+segundo;
		
	var timeStamp = anio+"-"+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo;

	var cadena = document.getElementById("usuario").value + "|" + document.getElementById("password").value + "|" + timeStamp + "|";
	var xmlhttp;

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			NroReg = xmlhttp.responseText.split('|');
			
			if (NroReg[0]==1)
			{
				document.getElementById("user").innerHTML = "<button type='button' id='iduser' class='btn btn-danger' readonly><span class='glyphicon glyphicon-user'></span>  " + NroReg[2] + "</button>";
				document.getElementById("close").innerHTML = "<button type='button' id='cerrar' class='btn btn-warning'><span class='glyphicon glyphicon-user'></span>  Cerrar Sesión</button>";
				cargarMenu('.html/main.html');
			}
			else
				document.getElementById("mensaje").style.display="block";
		}
	}

	xmlhttp.open("POST",".lib/linkIndex.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("ingresar="+cadena);
}