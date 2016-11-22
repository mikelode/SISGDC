//Evalua el submódulo a cargar (Agregar Personal, Editar Personal, Reportes)
function cargarSubmodulo(id,desde)
{
	$("#modules").load(desde);
	document.getElementById("modules").style.display="block";

	if (id==1)
		//Inicia Agregar Personal
		//initSubModulo1();
	if (id==2)
		//Inicia Editar Personal
		initSubModulo2();
	if (id==3)
		//Inicia Agregar Área
		initSubModulo3();
	if (id==4)
		//Inicia Editar Área
		initSubModulo4();
	if (id==5)
		//Inicia Reportes
		initSubModulo5();
}
//Inicia controles para "Agregar Personal"
function initSubModulo1()
{
	var xmlhttp;

	if (window.XMLHttpRequest)
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	else
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
            rpta = $.parseJSON(xmlhttp.responseText);

            if(rpta.response == '200')
            {
                Cadena1 = rpta.Respuesta.split('%');
                Cadena2 = Cadena1[0].split('$');
                html = "";
                console.log(Cadena2);
                for (i=0 ; i<(Cadena2.length)-1 ; i++)
                {
                    Cadena3 = Cadena2[i].split('|');

                    if(Cadena3[12] == 1)	html  += "<tr id='row-his-"+Cadena3[7]+"' class='bg-info'>";
                    else if(Cadena3[11] == 1) html  += "<tr id='row-his-"+Cadena3[7]+"' class='bg-success'>";

                    html += "<td>"+ (i+1) +"</td>";
                    html += "<td>"+ Cadena3[0] +"</td>";
                    html += "<td>"+ Cadena3[1] +"</td>";
                    html += "<td>"+ Cadena3[2] +"</td>";
                    html += "<td>"+ Cadena3[16] +"</td>";
                    html += "<td>"+ Cadena3[3] +"</td>";
                    html += "<td>"+ Cadena3[17] +"</td>";
                    html += "<td>"+ Cadena3[6] + "</td>";
                    html += "</tr>";
                }

                $('#tblDocEmitidos tbody').append(html);
            }
            else
            {
                alert(rpta.msg);
            }
		}
	}

	xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo1=1");
}

//Inicia controles para "Editar Personal"
function initSubModulo2()
{
	var xmlhttp;

	if (window.XMLHttpRequest)
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	
	else
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
            rpta = $.parseJSON(xmlhttp.responseText);

            if(rpta.response == '200')
            {
                Cadena1 = rpta.Respuesta.split('%');
                Cadena2 = Cadena1[0].split('$');
                html = "";
                console.log(Cadena2);
                for (i=0 ; i<(Cadena2.length)-1 ; i++)
                {
                    Cadena3 = Cadena2[i].split('|');

                    if(Cadena3[12] == 1)	html  += "<tr id='row-his-"+Cadena3[7]+"' class='bg-info'>";
                    else if(Cadena3[11] == 1) html  += "<tr id='row-his-"+Cadena3[7]+"' class='bg-success'>";

                    html += "<td>"+ (i+1) +"</td>";
                    html += "<td>"+ Cadena3[0] +"</td>";
                    html += "<td>"+ Cadena3[1] +"</td>";
                    html += "<td>"+ Cadena3[2] +"</td>";
                    html += "<td>"+ Cadena3[3] +"</td>";
                    html += "<td>"+ Cadena3[4] +"</td>";
                    html += "<td>"+ Cadena3[5] +"</td>";
                    html += "<td>"+ Cadena3[6] + "</td>";
                    html += "</tr>";
                }

                $('#tblDocEmitidos tbody').append(html);
            }
            else
            {
                alert(rpta.msg);
            }
		}
	}

	xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo2=1");
}

//Inicia controles para "Agregar Área"
function initSubModulo3()
{
}

//Inicia controles para "Editar Área"
function initSubModulo4()
{
	var xmlhttp;

	if (window.XMLHttpRequest)
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	
	else
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			Cadena1 = xmlhttp.responseText.split('%');
			Cadena2 = Cadena1[0].split('$');
			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				var opt1 = document.createElement("option");
				opt1.value = Cadena3[0];
				opt1.text = Cadena3[1];
				document.getElementById("selarea").add(opt1);
			}
		}
	}

	xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo4=1");
}

//Inicia controles para "Reportes"
function initSubModulo5()
{
	var xmlhttp;

	if (window.XMLHttpRequest)
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();

	else
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			Cadena1 = xmlhttp.responseText.split('%');
			Cadena2 = Cadena1[0].split('$');
			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				var opt = document.createElement("option");
				opt.value = Cadena3[0];
				opt.text =  Cadena3[1];
				document.getElementById("selarea").add(opt);
			}
			
			/*opt = document.createElement("option");
			opt.value = 99;
			opt.text = "Todas las Categorías";
			document.getElementById("selcategoria").add(opt);*/
		}
	}

	xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo5=1");
}

//Limita longitud de campo DNI a 8 caracteres
function limitarDNI(obj)
{
	obj.value = obj.value.substring(0,8);
}

//Verifica que el DNI sea válido y además no esté registrado (Agregar Personal)
function validarNewDni(val)
{
	var error=0;
	if (val.length<8)
	{
		error=1;
	}
	else
	{
		var xmlhttp;

		if (window.XMLHttpRequest)
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();

		else
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

		xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("validarNewDni="+val);

		Cadena1 = xmlhttp.responseText.split('$');
		if (Cadena1[0] == 1)
			error=1;
	}
	return error;
}

//Verifica que el DNI sea válido y además no esté registrado (Editar Personal)
function validarEdtDni(val1,val2)
{
	var cadena=val1+"|"+val2+"|";
	var error=0;

	if (val1.length<8)
	{
		error=1;
	}
	else
	{
		var xmlhttp;

		if (window.XMLHttpRequest)
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();

		else
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

		xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("validarEdtDni="+cadena);

		Cadena1 = xmlhttp.responseText.split('$');
		if (Cadena1[0] == 1)
			error=1;
	}
	return error;
}

//Carga datos de personal a editar
function cargarPersonal(obj)
{
	var idPersonal = obj.value;
	if (idPersonal == 0)
	{
		document.getElementById("mod-body2").style.display="none";
		document.getElementById("mod-footer").style.display="none";
	}
	else
	{
		var xmlhttp;

		if (window.XMLHttpRequest)
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();

		else
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{	
				Cadena1 = xmlhttp.responseText.split('$');
				Cadena2 = Cadena1[0].split('|');
				document.getElementById("edtarea").value=Cadena2[0];
				document.getElementById("edtdni").value=Cadena2[1];
				document.getElementById("edtcargo").value=Cadena2[2];
				document.getElementById("edtnombres").value=Cadena2[3];
				document.getElementById("edtactivo").value=Cadena2[4];

				document.getElementById("mod-body2").style.display="block";
				document.getElementById("mod-footer").style.display="block";
			}
		}

		xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("cargarPersonal="+idPersonal);
	}
}

//Carga datos de area a editar
function cargarArea(obj)
{
	var idArea = obj.value;
	if (idArea == 0)
	{
		document.getElementById("mod-body2").style.display="none";
		document.getElementById("mod-footer").style.display="none";
	}
	else
	{
		var xmlhttp;

		if (window.XMLHttpRequest)
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();

		else
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{	
				Cadena1 = xmlhttp.responseText.split('$');
				Cadena2 = Cadena1[0].split('|');
				document.getElementById("edtdescarea").value=Cadena2[0];
				document.getElementById("edtactivo").value=Cadena2[1];

				document.getElementById("mod-body2").style.display="block";
				document.getElementById("mod-footer").style.display="block";
			}
		}

		xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("cargarArea="+idArea);
	}
}

//Carga el reporte de equipos por área
function cargarReporte()
{
	document.getElementById("mod-body2").style.display="none";
	document.getElementById("mod-footer").style.display="none";

	var idArea = document.getElementById("selarea").value;
	
	if (idArea == 0)
	{
		document.getElementById("mod-body2").style.display="none";
		document.getElementById("mod-footer").style.display="none";
	}
	else
	{
		var xmlhttp;

		if (window.XMLHttpRequest)
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();

		else
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var tabla = document.getElementById("tablareporte");

				var longTabla = tabla.rows.length;

				if(longTabla>1)
					for (i=longTabla-1 ; i>0 ; i--)
						tabla.deleteRow(i);
				
				Cadena1 = xmlhttp.responseText.split('%');
				Cadena2 = Cadena1[0].split('$');

				for (i=0 ; i<(Cadena2.length)-1 ; i++)
				{
					Cadena3 = Cadena2[i].split('|');					
					var fila = document.createElement("tr");
					var col1 = document.createElement("td");
					col1.align = "center";
					var col2 = document.createElement("td");
					col2.align = "center";
					var col3 = document.createElement("td");
					var col4 = document.createElement("td");
					var col5 = document.createElement("td");
					col1.innerHTML = Cadena3[1];
					col2.innerHTML = Cadena3[30];
					col3.innerHTML = "Responsable:<br>"+Cadena3[5]+"<br>"+Cadena3[6]+"<br>Usuario:<br>"+Cadena3[8]+"<br>"+Cadena3[9];
					col4.innerHTML = "Marca: "+Cadena3[10]+"<br>Modelo: "+Cadena3[11];

					if (Cadena3[29]==1)
						col5.innerHTML = "Placa: "+Cadena3[12]+
										"<br>Procesador: "+Cadena3[13]+
										"<br>Nro. N&uacute;cleos: "+Cadena3[14]+
										"<br>Memoria RAM: "+Cadena3[15]+
										"<br>Disco Duro: "+Cadena3[16]+
										"<br>Tarjeta de Video: "+Cadena3[17]+
										"<br>Tarjeta de Red: "+Cadena3[18]+
										"<br>Tarjeta de Sonido: "+Cadena3[19]+
										"<br>Monitor: "+Cadena3[20];
					if (Cadena3[29]==2)
						col5.innerHTML = "Placa: "+Cadena3[12]+
										"<br>Procesador: "+Cadena3[13]+
										"<br>Nro. N&uacute;cleos: "+Cadena3[14]+
										"<br>Memoria RAM: "+Cadena3[15]+
										"<br>Disco Duro: "+Cadena3[16];
					if (Cadena3[29]==3)
						if(Cadena3[22]==1)
							col5.innerHTML = "Velocidad Escaneo: "+Cadena3[21]+
											"<br>Escaneo ADF: S&iacute;";
						else
							col5.innerHTML = "Velocidad Escaneo: "+Cadena3[21]+
											"<br>Escaneo ADF: No";
					if (Cadena3[29]==4)
						if(Cadena3[28]==1)
							col5.innerHTML = "Velocidad Impresi&oacute;n: "+Cadena3[23]+
											"<br>Tipo de Impresora: "+Cadena3[25]+
											"<br>Tipo de Impresi&oacute;n: "+Cadena3[27]+
											"<br>Impresora Multifuncional: S&iacute;";
						else
							col5.innerHTML = "Velocidad Impresi&oacute;n: "+Cadena3[23]+
											"<br>Tipo de Impresora: "+Cadena3[25]+
											"<br>Tipo de Impresi&oacute;n: "+Cadena3[27]+
											"<br>Impresora Multifuncional: No";
					if (Cadena3[29]==5)
						col5.innerHTML = "Placa: "+Cadena3[12]+
										"<br>Procesador: "+Cadena3[13]+
										"<br>Nro. N&uacute;cleos: "+Cadena3[14]+
										"<br>Memoria RAM: "+Cadena3[15]+
										"<br>Disco Duro: "+Cadena3[16]+
										"<br>Tarjeta de Video: "+Cadena3[17]+
										"<br>Tarjeta de Red: "+Cadena3[18]+
										"<br>Tarjeta de Sonido: "+Cadena3[19]+
										"<br>Monitor: "+Cadena3[20];
					if (Cadena3[29]==6)
						col5.innerHTML = "";

					fila.appendChild(col1);
					fila.appendChild(col2);
					fila.appendChild(col3);
					fila.appendChild(col4);
					fila.appendChild(col5);
					tabla.appendChild(fila);
				}

				document.getElementById("mod-body2").style.display="block";
				document.getElementById("mod-footer").style.display="block";
			}
		}

		xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("cargarReporte="+idArea);
	}
}

//Imprime el reporte generado
function imprimirReporte()
{
	document.getElementById("head3").style.display="none";
	document.getElementById("main").style.display="none";
	document.getElementById("mod-header").style.display="none";
	document.getElementById("mod-body1").style.display="none";
	document.getElementById("mod-bodyreport-label").className="mod-bodyreport-label-print";
	document.getElementById("tablareporte").className="mod-tablereporte-print";
	document.getElementById("mod-footer").style.display="none";
	document.getElementById("footer").style.display="none";
	document.getElementById("cuerpo").style.width="100%";

	if (window.print)
	{
        window.print();
    }
	else
	{
        alert("La función de impresion no esta soportada por su navegador");
    }

	document.getElementById("head3").style.display="block";
	document.getElementById("main").style.display="block";
	document.getElementById("mod-header").style.display="block";
	document.getElementById("mod-body1").style.display="block";
	document.getElementById("mod-bodyreport-label").className="mod-bodyreport-label";
	document.getElementById("tablareporte").className="mod-tablereporte";	
	document.getElementById("mod-footer").style.display="block";
	document.getElementById("footer").style.display="block";
	//document.getElementById("cuerpo").style.width="75%";
}

//Valida datos de personal antes de agregar en BD
function validarSubMod1()
{
	var ctr1 = document.getElementById("newarea").value;
	var ctr2 = document.getElementById("newdni").value;
	var ctr3 = document.getElementById("newcargo").value.trim();
	var ctr4 = document.getElementById("newnombres").value.trim();
	var ctr5 = "1";

	document.getElementById("msjarea").style.display="none";
	document.getElementById("msjdni").style.display="none";
	document.getElementById("msjcargo").style.display="none";
	document.getElementById("msjnombres").style.display="none";
	
	var error=0;

	if (ctr1==0)
	{
		document.getElementById("msjarea").style.display="block";
		error=1;
	}
	if (validarNewDni(ctr2))
	{
		document.getElementById("msjdni").style.display="block";
		error=1;
	}
	if (ctr3==0)
	{
		document.getElementById("msjcargo").style.display="block";
		error=1;
	}
	if (ctr4==0)
	{
		document.getElementById("msjnombres").style.display="block";
		error=1;
	}

	if (!error)
	{
		var cadena=ctr1+"|"+ctr2+"|"+ctr3+"|"+ctr4+"|"+ctr5+"|";
		//alert("Add: "+cadena);
		agregarPersonal(cadena);
	}
}

//Valida datos de personal antes de editar en BD
function validarSubMod2()
{
	var ctr1 = document.getElementById("edtarea").value;
	var ctr2 = document.getElementById("edtdni").value;
	var ctr3 = document.getElementById("edtcargo").value.trim();
	var ctr4 = document.getElementById("edtnombres").value.trim();
	var ctr5 = document.getElementById("edtactivo").value;
	var ctr6 = document.getElementById("selpersonal").value;

	document.getElementById("msjarea").style.display="none";
	document.getElementById("msjdni").style.display="none";
	document.getElementById("msjcargo").style.display="none";
	document.getElementById("msjnombres").style.display="none";
	document.getElementById("msjactivo").style.display="none";

	var error=0;

	if (ctr1==0)
	{
		document.getElementById("msjarea").style.display="block";
		error=1;
	}
	if (validarEdtDni(ctr2,ctr6))
	{
		document.getElementById("msjdni").style.display="block";
		error=1;
	}
	if (ctr3==0)
	{
		document.getElementById("msjcargo").style.display="block";
		error=1;
	}
	if (ctr4==0)
	{
		document.getElementById("msjnombres").style.display="block";
		error=1;
	}
	if (ctr5==0)
	{
		document.getElementById("msjactivo").style.display="block";
		error=1;
	}

	if (!error)
	{
		var cadena=ctr1+"|"+ctr2+"|"+ctr3+"|"+ctr4+"|"+ctr5+"|"+ctr6+"|";
		//alert("Edit: "+cadena);
		editarPersonal(cadena);
	}
}

//Valida datos de área antes de agregar en BD
function validarSubMod3()
{
	var ctr1 = document.getElementById("newdescarea").value.trim();
	var ctr2 = "1";

	document.getElementById("msjdescarea").style.display="none";
	
	var error=0;

	if (ctr1==0)
	{
		document.getElementById("msjdescarea").style.display="block";
		error=1;
	}

	if (!error)
	{
		var cadena=ctr1+"|"+ctr2+"|";
		//alert("Add: "+cadena);
		agregarArea(cadena);
	}
}

//Valida datos de area antes de editar en BD
function validarSubMod4()
{
	var ctr1 = document.getElementById("edtdescarea").value.trim();
	var ctr2 = document.getElementById("edtactivo").value;
	var ctr3 = document.getElementById("selarea").value;

	document.getElementById("msjdescarea").style.display="none";
	document.getElementById("msjactivo").style.display="none";

	var error=0;

	if (ctr1==0)
	{
		document.getElementById("msjdescarea").style.display="block";
		error=1;
	}
	if (ctr2==0)
	{
		document.getElementById("msjactivo").style.display="block";
		error=1;
	}

	if (!error)
	{
		var cadena=ctr1+"|"+ctr2+"|"+ctr3+"|";
		//alert("Edit: "+cadena);
		editarArea(cadena);
	}
}

//Agrega datos de nuevo personal en BD
function agregarPersonal(cadena)
{
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
			Respuesta = xmlhttp.responseText;
			document.body.scrollTop = 0;
			document.getElementById("msjsuccess").innerHTML=Respuesta;
			cargarSubmodulo(1,".html/modulo3/m3submod1.html");
			document.getElementById("msjsuccess").style.display="block";
			setTimeout ("document.getElementById('msjsuccess').style.display='none';", 2000);
		}
	}

	xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("agregarPersonal="+cadena);
}

//Edita datos de personal en BD
function editarPersonal(cadena)
{
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
			Respuesta = xmlhttp.responseText;
			document.body.scrollTop = 0;
			document.getElementById("msjsuccess").innerHTML=Respuesta;
			cargarSubmodulo(2,".html/modulo3/m3submod2.html");
			document.getElementById("msjsuccess").style.display="block";
			setTimeout ("document.getElementById('msjsuccess').style.display='none';", 2000);
		}
	}

	xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("editarPersonal="+cadena);
}

//Agrega datos de nueva área en BD
function agregarArea(cadena)
{
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
			Respuesta = xmlhttp.responseText;
			document.body.scrollTop = 0;
			document.getElementById("msjsuccess").innerHTML=Respuesta;
			cargarSubmodulo(3,".html/modulo3/m3submod3.html");
			document.getElementById("msjsuccess").style.display="block";
			setTimeout ("document.getElementById('msjsuccess').style.display='none';", 2000);
		}
	}

	xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("agregarArea="+cadena);
}

//Edita datos de área en BD
function editarArea(cadena)
{
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
			Respuesta = xmlhttp.responseText;
			document.body.scrollTop = 0;
			document.getElementById("msjsuccess").innerHTML=Respuesta;
			cargarSubmodulo(4,".html/modulo3/m3submod4.html");
			document.getElementById("msjsuccess").style.display="block";
			setTimeout ("document.getElementById('msjsuccess').style.display='none';", 2000);
		}
	}

	xmlhttp.open("POST",".lib/modulo3/linkModulo3.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("editarArea="+cadena);
}