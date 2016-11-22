window.onload= function()
{
	$.post('.lib/linkIndex.php', {sesion: 'check'}, function(response){
		console.log(response);
		if(response != 'salir')
		{
			NroReg = response.split('|');

			if (NroReg[0]==1)
			{
                var btnUsuario = "<div class='btn-group'>" +
                                "<button style='width: 134px' type='button' id='iduser' class='btn btn-default btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
                                "<span class='glyphicon glyphicon-user'></span> " + NroReg[2].toUpperCase() + "<span class='caret'></span></button>" +
                                "<ul class='dropdown-menu' style='color: black;'>" +
                                "<li><a href='#' data-toggle='modal' data-target='#modalChangePass'>Cambiar contrseña</a></li>" +
                                "</ul></div>";

				document.getElementById("user").innerHTML = btnUsuario;
				document.getElementById("close").innerHTML = "<button type='button' id='cerrar' class='btn btn-danger' onclick='salir()'><span class='glyphicon glyphicon-log-out'></span> Cerrar Sesión</button>";
				document.getElementById("headofi").innerHTML = "<h3>" + NroReg[5] + "</h3>";
				cargarMenu('.html/' + NroReg[6]);
				cargarInit();
				cargarTimeStamp();
			}
		}
		else
		{
			document.getElementById("usuario").focus();
			cargarInit();
			cargarTimeStamp();
		}
	});
};

function cargarInit()
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
			Respuesta = xmlhttp.responseText.split('|');
			document.getElementById("cliente").innerHTML = Respuesta[0];
			document.getElementById("sistema").innerHTML = Respuesta[1] + " - " + Respuesta[2];
			document.getElementById("foot1").innerHTML = Respuesta[0] + " - " + Respuesta[1];
			document.getElementById("foot2").innerHTML = "Resolución mínima recomendada: 1024 x 768";
			//document.getElementById("foot3").innerHTML = "Programación y Diseño: " + Respuesta[3];
			document.getElementById("foot4").innerHTML = "Prohibida su reproducción total o parcial";
			document.getElementById("foot5").innerHTML = "Todos los Derechos Reservados © 2016";
		}
	};

	xmlhttp.open("POST",".lib/linkIndex.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("init=1");
}

function cargarTimeStamp()
{
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var dias = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var dia = new Date().getDate();
	var hora = new Date().getHours();
	var minuto = new Date().getMinutes();
	var segundo = new Date().getSeconds();

	if (dia<10)
		dia = "0" + dia;
	if (hora<10)
		hora = "0" + hora;
	if (minuto<10)
		minuto = "0" + minuto;
	if (segundo<10)
		segundo = "0" + segundo;
	
	var f = new Date();
	var timeStamp = dias[f.getDay()] + ", " + dia + " de " + meses[f.getMonth()] + " de " + f.getFullYear() + " - " + hora + ":" + minuto + ":" + segundo;
	document.getElementById("timestamp").innerHTML = timeStamp;
	setTimeout("cargarTimeStamp()",1000);
}

function cargarMenu(desde)
{
	$("#main").load(desde);
	document.getElementById("modules").style.display="none";
}


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
                var btnUsuario = "<div class='btn-group'>" +
                    "<button style='width: 134px' type='button' id='iduser' class='btn btn-default btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
                    "<span class='glyphicon glyphicon-user'></span> " + NroReg[2].toUpperCase() + "<span class='caret'></span></button>" +
                    "<ul class='dropdown-menu' style='color: black;'>" +
                    "<li><a href='#' data-toggle='modal' data-target='#modalChangePass'>Cambiar contrseña</a></li>" +
                    "</ul></div>";

				document.getElementById("user").innerHTML = btnUsuario;
				document.getElementById("close").innerHTML = "<button type='button' id='cerrar' class='btn btn-danger' onclick='salir()'><span class='glyphicon glyphicon-log-out'></span> Cerrar Sesión</button>";
				document.getElementById("headofi").innerHTML = "<h3>" + NroReg[5] + "</h3>";
				cargarMenu('.html/'+NroReg[6]);
			}
			else
				document.getElementById("mensaje").style.display="block";
		}
	};

	xmlhttp.open("POST",".lib/linkIndex.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("ingresar="+cadena);
}

function salir()
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
		//if (xmlhttp.readyState==4 && xmlhttp.status==200)
		location.href = 'index.html';
	};

	xmlhttp.open("POST",".lib/linkIndex.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("salir=1");
}

function validar_formulario(form, origen)
{
    var respuesta = new Object();
    var elementos = new Array();
    respuesta.valido = true;
    respuesta.elemento = elementos;
    console.log(form);

    form.find('div.error-message').hide();

    if(origen == 'interno')
    {
        var docTipo = form.find('select#docTipo').val();
        var docFecha = form.find('input#docFecha').val();
        var remNombre = form.find('input#docRemNombres').val();
        var remPat = form.find('input#docRemPaterno').val();
        var remMat = form.find('input#docRemMaterno').val();
        var docAsunto = form.find('textarea#docAsunto').val();

        if(docTipo == 'NA')
        {
            respuesta.valido = false;
            elementos.push(form.find('select#docTipo').prop('id'));
        }
        if(docFecha.trim() == '')
        {
            respuesta.valido = false;
            elementos.push(form.find('input#docFecha').prop('id'));
        }
        if(remNombre.trim() == '')
        {
            respuesta.valido = false;
            elementos.push(form.find('input#docRemNombres').prop('id'));
        }
        if(remPat.trim() == '')
        {
            respuesta.valido = false;
            elementos.push(form.find('input#docRemPaterno').prop('id'));
        }
        if(remMat.trim() == '')
        {
            respuesta.valido = false;
            elementos.push(form.find('input#docRemMaterno').prop('id'));
        }
        if(docAsunto.trim() == '')
        {
            respuesta.valido = false;
            elementos.push(form.find('textarea#docAsunto').prop('id'));
        }

        for(i=0; i<elementos.length; i++)
        {
            respuesta.elemento[i] = elementos[i];
        }

    }
    else if(origen == 'externo')
    {
        var docTipo = form.find('select#docTipo').val();
        var docFecha = form.find('input#docFecha').val();
        var docTipoRem = form.find('select#docTipoRem').val();
        var docAsunto = form.find('textarea#docAsunto').val();
        var docFolios = form.find('input#docFolios').val();
        var docFechaRecepcion = form.find('input#docFechaRecepcion').val();

        if(docTipo == 'NA')
        {
            respuesta.valido = false;
            elementos.push(form.find('select#docTipo').prop('id'));
        }
        if(docFecha.trim() == '')
        {
            respuesta.valido = false;
            elementos.push(form.find('input#docFecha').prop('id'));
        }
        if(docTipoRem == 'NA')
        {
            respuesta.valido = false;
            elementos.push(form.find('select#docTipoRem').prop('id'));
        }
        if(docAsunto.trim() == '')
        {
            respuesta.valido = false;
            elementos.push(form.find('textarea#docAsunto').prop('id'));
        }
        if(docFolios.trim() == '' || docFolios.trim() == 0)
        {
            respuesta.valido = false;
            elementos.push(form.find('input#docFolios').prop('id'));
        }
        if(docFechaRecepcion.trim() == '')
        {
            respuesta.valido = false;
            elementos.push(form.find('input#docFechaRecepcion').prop('id'));
        }

        for(i=0; i < elementos.length; i++)
        {
            respuesta.elemento[i] = elementos[i];
        }
    }

    return JSON.stringify(respuesta);
}

function guardar_password(frm)
{
    var url = frm.prop('action');
    var data = frm.serialize() + '&password=1';

    var cp = $('#curPass').val();
    cp = cp.trim();
    var p1 = $('#newPass').val();
    p1 = p1.trim();
    var p2 = $('#repPass').val();
    p2 = p2.trim();

    if(cp == '')
    {
        alert('Debe ingresar su contraseña actual');
        return;
    }
    if(p1 == '')
    {
        alert('Debe ingresar su nueva contraseña');
        return;
    }
    if(p2 == '')
    {
        alert('Debe repetir la nueva contraseña ingresada anteriormente');
        return;
    }
    if(p1 !== p2)
    {
        alert('Ingrese valores iguales en Contraseña Nueva y Repita Contraseña Nueva');
        return;
    }

    $.post(url,data,function(response){
        response = $.parseJSON(response);
        if(response.Respuesta == 200)
        {
            alert(response.msg);
            $(':input',frm)
                .not(':button')
                .val('');

            $('#modalChangePass').modal('hide');
        }
        else
        {
            alert(response.msg);
        }
    });
}