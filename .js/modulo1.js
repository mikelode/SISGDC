//Evalua el submódulo a cargar (Agregar Equipo, Editar Equipo, Reportes)
function cargarSubmodulo(id,desde)
{
	$("#modules").load(desde);
	document.getElementById("modules").style.display="block";

	if (id==1)
		//Inicia Agregar Equipo
		initSubModulo1();
	if (id==2)
		//Inicia Editar Equipo
		initSubModulo2();
	if (id==3)
		//Inicia Asignar Software
		initSubModulo3();
	if (id==11)
		//Inicia Remover Software
		initSubModulo11();
	if (id==12)
		//Inicia Reportes
		initSubModulo12();
}

//Inicia controles para "Agregar Equipo"
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
			Cadena1 = xmlhttp.responseText.split('%');
			Cadena2 = Cadena1[0].split('$');
			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				var opt = document.createElement("option");
				opt.value = Cadena3[0];
				opt.text = Cadena3[1];
				document.getElementById("docTipo").add(opt);
			}

			Cadena2 = Cadena1[1].split('$');
			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				document.getElementById("docRemId").value = Cadena3[2];
				document.getElementById("docRemNombres").value = Cadena3[3];
				document.getElementById("docRemPaterno").value = Cadena3[4];
				document.getElementById("docRemMaterno").value = Cadena3[5];
			}

			Cadena2 = Cadena1[2].split('$');
			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				var opt = document.createElement("option");
				opt.value = Cadena3[0];
				opt.text = Cadena3[1];
				document.getElementById("docEnvioDestino").add(opt);
			}

			Cadena2 = Cadena1[3].split('$');
			if(Cadena2.length > 1)
			{
				for (i=0 ; i<(Cadena2[i].length)-1 ; i++)
				{
					Cadena3 = Cadena2[i].split('|');
					document.getElementById("docId").value = Cadena3[0];
					document.getElementById("docRemId").value = Cadena3[1];
					document.getElementById("docRemNombres").value = Cadena3[2];
					document.getElementById("docRemPaterno").value = Cadena3[3];
					document.getElementById("docRemMaterno").value = Cadena3[4];
					document.getElementById("docAsunto").value = Cadena3[5];
					document.getElementById("docTipo").value = Cadena3[6];
					document.getElementById("docFolios").value = Cadena3[7];
					document.getElementById("docFecha").value = Cadena3[8];
					document.getElementById("docEnvioExp").innerHTML = Cadena3[0];
					document.getElementById("hdocEnvioExp").value = Cadena3[9];
					document.getElementById("docCtrlPersonal").value = Cadena3[11];
					document.getElementById("docReferencia").value = Cadena3[12];
                    document.getElementById("docNumero").value = Cadena3[13];

					if(Cadena3[10] == 'Registrado')
					{
						$('#operacionEnviar').show();
						$('#btnEditarDoc').show();
						$('#btnEliminarDoc').show();
					}

				}
			}

			Cadena2 = Cadena1[4].split('$');
			for(i=0 ; i<(Cadena2[i].length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				document.getElementById("docEnvioOrigen").innerHTML = Cadena3[4];
				document.getElementById("hdocEnvioOrigen").value = Cadena3[2];
			}

            var fecha = new Date();
            $('#periodoTramite').val(fecha.getFullYear());
		}
	};

	xmlhttp.open("POST",".lib/modulo1/linkModulo1.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo1=1");
}

//Inicia controles para "Editar Equipo"
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
			Cadena1 = xmlhttp.responseText.split('%');
			Cadena2 = Cadena1[0].split('$');
			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				var opt = document.createElement("option");
				opt.value = Cadena3[0];
				opt.text = Cadena3[1];
				document.getElementById("docTipo").add(opt);
			}

			Cadena2 = Cadena1[1].split('$');
			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				var opt = document.createElement("option");
				opt.value = Cadena3[0];
				opt.text = Cadena3[1];
				document.getElementById("docEnvioDestino").add(opt);
			}

			Cadena2 = Cadena1[2].split('$');

			if(Cadena2.length > 1)
			{
				for (i=0 ; i<(Cadena2[i].length)-1 ; i++)
				{
					Cadena3 = Cadena2[i].split('|');

					document.getElementById("docId").value = Cadena3[0];

					if(Cadena3[10] == 'Persona')
					{
						$('#personaRem').show();
						document.getElementById("docTipoRem").value = 'prs';
						document.getElementById("docRemId").value = Cadena3[1];
						document.getElementById("docRemNombres").value = Cadena3[2];
						document.getElementById("docRemPaterno").value = Cadena3[3];
						document.getElementById("docRemMaterno").value = Cadena3[4];
					}
					else
					{
						$('#otroRem').show();
						document.getElementById("docTipoRem").value = 'ist';
						document.getElementById("docRemOtroId").value = Cadena3[1];
						document.getElementById("docRemOtroDesc").value = Cadena3[11]
					}

					document.getElementById("docAsunto").value = Cadena3[5];
					document.getElementById("docTipo").value = Cadena3[6];
					document.getElementById("docFolios").value = Cadena3[7];
					document.getElementById("docFecha").value = Cadena3[8];
					document.getElementById("docEnvioExp").innerHTML = Cadena3[0];
					document.getElementById("hdocEnvioExp").value = Cadena3[9];
					document.getElementById("docCtrlPersonal").value = Cadena3[13];
					document.getElementById("docFechaRecepcion").value = Cadena3[15];
					$('#docPrioridad').rating('update',Cadena3[14]);
					document.getElementById("docReferencia").value = Cadena3[16];
                    document.getElementById("docNumero").value = Cadena3[17];

					if(Cadena3[12] == 'Registrado')
					{
						$('#operacionEnviar').show();
						$('#btnEditarDoc').show();
						$('#btnEliminarDoc').show();
					}
					else
					{
						$('#operacionEnviar').hide();
						$('#btnEditarDoc').hide();
						$('#btnEliminarDoc').hide();
					}
				}
			}

			Cadena2 = Cadena1[3].split('$');
			for(i=0 ; i<(Cadena2[i].length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				document.getElementById("docEnvioOrigen").innerHTML = Cadena3[4];
				document.getElementById("hdocEnvioOrigen").value = Cadena3[2];
			}

            var fecha = new Date();
            $('#periodoTramite').val(fecha.getFullYear());
		}
	};

	xmlhttp.open("POST",".lib/modulo1/linkModulo1.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo2=1");
}

function initSubModulo11()
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
				opt.text = Cadena3[1];
				document.getElementById("usrOficina").add(opt);
			}
		}
	}

	xmlhttp.open("POST",".lib/modulo1/linkModulo1-admin.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo11=1");
}

function initSubModulo12()
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
            var html = '';

            for (i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');

                html += "<tr id='row-usr-"+ Cadena3[0] +"' >";
                html += "<td>" + (i+1) + "</td>";
                html += "<td>" + Cadena3[9] + "</td>";
                html += "<td>" + Cadena3[6] + "</td>";
                html += "<td>" + Cadena3[7] + "</td>";
                html += "<td>" + Cadena3[8] + "</td>";
                html += "<td>" + Cadena3[10] + "</td>";
                html += "<td>" + Cadena3[1] + "</td>";
                html += "<td><a href='javascript:void(0)' onclick='usrrestorepass(this)'> Restaurar </a></td>";
                html += "<td><a href='#' class='usrEstado' data-type='select' data-value='" + Cadena3[4] + "' data-pk='" + Cadena3[0] + "' data-url='.lib/modulo1/linkModulo1-admin.php?changeState=1' data-title='Cambiar Estado'>" + Cadena3[11] + "</a></td>";
                html += "<td><a href='#' data-ofid='" + Cadena3[5] + "' data-usrid='" + Cadena3[0] + "' data-toggle='modal' data-target='#modalEditarUsuario' onclick='mostrar_modal_editar(this)'>Editar</a> - " +
                        "<a href='javascript:void(0)' class='text-danger' onclick='usrdelete(this)'>Eliminar</a></td>";
                html += "</tr>";
            }

            $('#tblUsrRegistrados tbody').append(html);

            $('.usrEstado').editable({
                source:[
                    {value: 0, text: 'Desactivado'},
                    {value: 1, text: 'Activado'}
                ],
                showbuttons: false,
                success: function(response){
                    var res = $.parseJSON(response);
                    if(res.Respuesta == 200)
                    {
                        alert(res.msg);
                    }
                    else
                    {
                        alert(res.msg);
                        cargarSubmodulo(12,'.html/modulo1-admin/m1submod2.html');
                    }
                }
            });

            Cadena2 = Cadena1[1].split('$');
            for (i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');
                var opt = document.createElement("option");
                opt.value = Cadena3[0];
                opt.text = Cadena3[1];
                document.getElementById("usrOficina").add(opt);
            }
        }
    }

    xmlhttp.open("POST",".lib/modulo1/linkModulo1-admin.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("initSubModulo12=1");
}

function mostrar_modal_editar(btn)
{
    var usrId = $(btn).data('usrid');
    var row = $(btn).closest('tr');
    var usrDni = row.find('td:eq(1)').text();
    var usrNmb = row.find('td:eq(2)').text();
    var usrPat = row.find('td:eq(3)').text();
    var usrMat = row.find('td:eq(4)').text();
    var usrOfi = $(btn).data('ofid');

    var modal = $('#modalEditarUsuario');
    modal.find('.modal-body input#usrId').val(usrId);
    modal.find('.modal-body input#usrDni').val(usrDni);
    modal.find('.modal-body input#usrNombres').val(usrNmb);
    modal.find('.modal-body input#usrPaterno').val(usrPat);
    modal.find('.modal-body input#usrMaterno').val(usrMat);
    modal.find('.modal-body select#usrOficina').val(usrOfi);
}

function grabar_edicion_usuario()
{
    var url = $('#frmEditarUsuario').prop('action');
    var data = $('#frmEditarUsuario').serialize() + '&usreditar=1';

    $.post(url, data, function(response){
        var res = $.parseJSON(response);
        if(res.Respuesta == 200)
        {
            alert(res.msg);
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            cargarSubmodulo(12,'.html/modulo1-admin/m1submod2.html');
        }
        else
        {
            alert(res.msg);
        }
    });
}

function usrdelete(btn)
{
    var idRow = $(btn).closest('tr').attr('id');
    var url = '.lib/modulo1/linkModulo1-admin.php';

    var verificar = confirm('¿Esta seguro de eliminar la cuenta de usuario seleccionada?');
    if(!verificar) return;

    $.getJSON(url, {usrdelete: 1, row: idRow}, function(response){
        if(response.Respuesta == 200)
        {
            alert(response.msg);
            cargarSubmodulo(12,'.html/modulo1-admin/m1submod2.html');
        }
        else
        {
            alert(response.msg);
        }
    });

}

function usrrestorepass(btn)
{
    var idRow = $(btn).closest('tr').attr('id');
    var url = '.lib/modulo1/linkModulo1-admin.php';

    var verificar = confirm('¿Está seguro de restaurar la constraseña para el usuario seleccionado?');
    if(!verificar) return;

    $.getJSON(url, {restorepass: 1, row: idRow}, function(response){
        if(response.Respuesta == 200)
        {
            alert(response.msg);
        }
        else
        {
            alert(response.msg);
        }
    });
}

function nuevo_documento(origen)
{
	var estado = $('#btnNuevoDoc').html();

	if(estado == "Nuevo")
	{
		$('#btnNuevoDoc').html('Cancelar');
		$('#btnNuevoDoc').prop('class','btn btn-warning');
		$('#btnEditarDoc').hide();
		$('#btnEliminarDoc').hide();

		$('#operacionEnviar').hide();

		if(origen == 'externo')
		{
			$('#personaRem').hide();
			$('#otroRem').hide();
			$('#docTipoRem').prop('disabled',false).val('NA');
			/*$('#docRemId').prop('readonly', false);
			$('#docRemNombres').prop('readonly', false);
			$('#docRemPaterno').prop('readonly', false);
			$('#docRemMaterno').prop('readonly', false);*/
			$('#docFechaRecepcion').prop('readonly',false).val('');
			$('#docPrioridad').rating('refresh',{readonly: false});
			$('#docPrioridad').rating('clear');
		}
        else
        {
            $.getJSON('.lib/modulo1/linkModulo1.php?getjefe=1',function(response){
                $('#docRemId').prop('readonly', true).val(response.jdni);
                $('#docRemNombres').prop('readonly', true).val(response.jnombres);
                $('#docRemPaterno').prop('readonly', true).val(response.jpaterno);
                $('#docRemMaterno').prop('readonly', true).val(response.jmaterno);
            });
        }

		$('#docId').val('');
		$('#docTipo').prop('disabled', false).val('NA');
		$('#docCtrlPersonal').prop('readonly', false).val('');
		$('#docFecha').prop('readonly', false).val('');
		$('#docReferencia').prop('readonly', false).val('');
        $('#docNumero').prop('readonly', false).val('');
		$('#docAsunto').prop('readonly', false).val('');
		$('#docFolios').prop('readonly', false).val('');

		$('#btnGuardarDoc').show();
	}
	else
	{
		if(origen == 'externo')
			cargarSubmodulo(2,'.html/modulo1/m1submod2.html');
		else if(origen == 'interno')
			cargarSubmodulo(1,'.html/modulo1/m1submod1.html');

	}

}

function guardar_documento(origen)
{
	var data = $('#frmRegDoc').serialize() + '&save=1&origen=' + origen;
	var url = $('#frmRegDoc').prop('action');
    var form = $('#frmRegDoc');

    var verificar = validar_formulario(form, origen);
    verificar = $.parseJSON(verificar);

    if(!verificar.valido)
    {
        $.each(verificar.elemento,function(i,elem){
            var grupo = $('#' + elem).closest('div.form-group');
            var mensaje = grupo.find('div.error-message').show();
        });

        return;
    }

	$.post(url, data, function(response){
        var res = $.parseJSON(response);
		if(res.Respuesta == 200)
		{
            alert(res.msg);
			if(origen == 'interno')
				cargarSubmodulo(1,'.html/modulo1/m1submod1.html');
			else
				cargarSubmodulo(2,'.html/modulo1/m1submod2.html');
		}
		else
		{
			alert(res.msg);
		}
	});
}

function editar_documento(origen)
{
	var estado = $('#btnEditarDoc').html();

	if(estado == "Editar")
	{
		$('#btnEditarDoc').html('Cancelar');
		$('#btnEditarDoc').prop('class','btn btn-warning');

		$('#operacionEnviar').hide();

		if(origen == 'externo')
		{
			var tipo = $('#docTipoRem').val();
			$('#docTipoRem').prop('disabled',false);

			if(tipo == 'prs')
			{
				$('#personaRem :input').prop('readonly', false);
			}
			else
			{
				$('#otroRem :input').prop('readonly', false);
			}

            $('#docFechaRecepcion').prop('readonly', false);
            $('#docPrioridad').rating('refresh',{readonly: false});
		}

		$('#docAsunto').prop('readonly', false);
		$('#docTipo').prop('disabled', false);
        $('#docCtrlPersonal').prop('readonly',false);
        $('#docReferencia').prop('readonly', false);
        $('#docNumero').prop('readonly', false);
		$('#docFolios').prop('readonly', false);
		$('#docFecha').prop('readonly', false);

		$('#btnGuardarEdicionDoc').show();
	}
	else
	{
		if(origen == 'interno')
			cargarSubmodulo(1,'.html/modulo1/m1submod1.html');
		else
			cargarSubmodulo(2,'.html/modulo1/m1submod2.html');
	}
}

function terminar_edicion_documento(origen)
{
	var data = $('#frmRegDoc').serialize() + '&edit=1&origen=' + origen;
	var url = $('#frmRegDoc').prop('action');

	$.post(url, data, function(response){
		var res = $.parseJSON(response);
        //console.log(res.msg);
		if(res.Respuesta == 200)
		{
			pantallazo_documento(res.cadena);
			$('#btnEditarDoc').html('Editar');
			$('#btnEditarDoc').prop('class','btn btn-info');
			$('#btnGuardarEdicionDoc').hide();
            $('#operacionEnviar').show();
		}
		else
		{
			alert(res.msg);
		}
	});
}

function mostrar_documento(pos, origen)
{
	//xmlhttp.open("POST",".lib/modulo1/linkModulo1.php",true);
	var actual = $('#docId').val();
	var url = '.lib/modulo1/linkModulo1.php';
	var data = {'posicion': pos, 'docId': actual, 'origen': origen};

	if(actual == '') return;
	if($('#btnEditarDoc').html() == 'Cancelar') return;

	$.post(url, data, function(response){
		pantallazo_documento(response);
        $('#modalEncontrarDocumento').modal('hide');
        //$('body').removeClass('modal-open');
        //$('.modal-backdrop').remove();
	});
}

function pantallazo_documento(cadena)
{
	Cadena1 = cadena.split('%');
	Cadena2 = Cadena1[0].split('$');
	if(Cadena2.length > 1)
	{
		for (i=0 ; i<(Cadena2[i].length)-1 ; i++)
		{
			Cadena3 = Cadena2[i].split('|');
			$('#docId').prop('readonly',true).val(Cadena3[0]);

			if(Cadena3[10] == 'Persona')
			{
				$('#personaRem').show();
				$('#otroRem').hide();
				$('#otroRem :input').val('');

				$('#docTipoRem').prop('disabled',true).val('prs');
				$('#docRemId').prop('readonly',true).val(Cadena3[1]);
				$('#docRemNombres').prop('readonly',true).val(Cadena3[2]);
				$('#docRemPaterno').prop('readonly',true).val(Cadena3[3]);
				$('#docRemMaterno').prop('readonly',true).val(Cadena3[4]);
			}
			else
			{
				$('#otroRem').show();
				$('#personaRem').hide();
				$('#personaRem :input').val('');

				$('#docTipoRem').prop('disabled',true).val('ist');
				$('#docRemOtroId').prop('readonly',true).val(Cadena3[1]);
				$('#docRemOtroDesc').prop('readonly',true).val(Cadena3[11]);
			}

			$('#docAsunto').prop('readonly',true).val(Cadena3[5]);
			$('#docTipo').prop('disabled',true).val(Cadena3[6]);
			$('#docFolios').prop('readonly',true).val(Cadena3[7]);
			$('#docFecha').prop('readonly',true).val(Cadena3[8]);
			$("#docEnvioExp").html(Cadena3[9]);
			$("#hdocEnvioExp").val(Cadena3[9]);

			$('#docCtrlPersonal').prop('readonly',true).val(Cadena3[13]);
			$('#docPrioridad').rating('refresh',{readonly: true});
			$('#docPrioridad').rating('update',Cadena3[14]);
			$('#docFechaRecepcion').prop('readonly', true).val(Cadena3[15]);
			$('#docReferencia').prop('readonly',true).val(Cadena3[16]);
            $('#docNumero').prop('readonly',true).val(Cadena3[17]);

			if(Cadena3[12] == 'Registrado')
			{
				$('#operacionEnviar').show();
				$('#btnEditarDoc').show();
				$('#btnEliminarDoc').show();
			}
			else
			{
				$('#operacionEnviar').hide();
				$('#btnEditarDoc').hide();
				$('#btnEliminarDoc').hide();
			}
		}
	}

	Cadena2 = Cadena1[1].split('$');
	for(i=0 ; i<(Cadena2[i].length)-1 ; i++)
	{
		Cadena3 = Cadena2[i].split('|');
		$("#docEnvioOrigen").html(Cadena3[4]);
		$("#hdocEnvioOrigen").val(Cadena3[2]);
	}
}

function eliminar_documento(origen)
{
    var confirma = confirm('¿Está seguro de eliminar el documento seleccionado?');
    if(!confirma) return;

    var data = $('#frmRegDoc').serialize() + '&delete=1&origen=' + origen;
    var url = $('#frmRegDoc').prop('action');

    $.post(url, data, function(response){
        var res = $.parseJSON(response);
        if(res.Respuesta == 200)
        {
            alert(res.msg);
        }
        else
        {
            alert(res.msg);
        }

        if(origen == 'interno')
            cargarSubmodulo(1,'.html/modulo1/m1submod1.html');
        else
            cargarSubmodulo(2,'.html/modulo1/m1submod2.html');
    });
}

function actualizar_tiporem()
{
	var tiporem = $('#docTipoRem').val();

	if(tiporem == 'NA')
	{
		$('#personaRem').hide();
		$('#otroRem').hide();
	}
	else if(tiporem == 'prs')
	{
		$('#personaRem').show();
		$('#personaRem :input').prop('readonly',false).val('');
		$('#otroRem').hide();
		$('#otroRem :input').prop('readonly',true);
	}
	else
	{
		$('#personaRem').hide();
		$('#personaRem :input').prop('readonly',true);
		$('#otroRem').show();
		$('#otroRem :input').prop('readonly',false).val('');
	}
}

function enviar_documento(origen)
{
	var url = $('#frmEnvDoc').prop('action');
	var data = $('#frmEnvDoc').serialize() + '&send=1';

	$.post(url, data, function(response){
		var res = $.parseJSON(response);
		if(res.Respuesta == '200')
		{
            alert(res.msg);
			$('#modalOperacionEnviar').modal('hide');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
			if(origen == 'interno')
				cargarSubmodulo(1,'.html/modulo1/m1submod1.html');
			else
				cargarSubmodulo(2,'.html/modulo1/m1submod2.html');
		}
		else
		{
			alert(res.msg);
		}

	});

}

function abrir_modal_envio(btn)
{
	$('#modalOperacionEnviar').show();
}

function guardar_usuario()
{
    var url = $('#frmRegUsuario').prop('action');
    var data = $('#frmRegUsuario').serialize() + '&newusr=1';

    $.post(url, data, function(response){
        var res = $.parseJSON(response);
        if(res.Respuesta == 200)
        {
            alert(res.msg);
            cargarSubmodulo(12,'.html/modulo1-admin/m1submod2.html');
        }
        else
        {
            alert(res.msg);
        }
    });
}

function ejecutar_teclado(e, origen)
{
    var propInput = $('#docId').prop('readonly');
    if(e.which == 13)
    {
        var docId = $('#docId').val();

        if(docId == '')
            return;
        if(propInput)
            return;

        mostrar_documento(docId,origen);

        /*$('btnIngresarDoc').data('estado','desactivado');
        $('btnIngresarDoc').removeClass().addClass('glyphicon glyphicon-hand-left');
        $('#docId').prop('readonly',true);*/
    }
    else if(e.which == 113)
    {
        if(!propInput)
            return;

        $('#modalEncontrarDocumento').modal('show');
    }
}

function encontrar_documento(origen, frm)
{
    var url = frm.prop('action');
    var data = frm.serialize() + '&origen=' + origen + '&encdoc=1';

    $.post(url, data, function(response){
        var response = $.parseJSON(response);
        if(response.Respuesta == 200 )
        {
            $('#tbl-resultado-encontrar').html(response.resultado);
        }
        else if(response.Respuesta == 500)
        {
            alert(response.msg);
        }
    });
}

function modo_buscar(btn)
{
    var estado = $(btn).data('estado');
    $(btn).find('span').toggleClass('glyphicon glyphicon-hand-left').toggleClass('glyphicon glyphicon-remove');

    if(estado == 'desactivado')
    {
        $(btn).data('estado','activado');
        $('#docId').prop('readonly',false).val('');
        $('#btnNuevoDoc').hide();
        $('#btnEditarDoc').hide();
        $('#btnEliminarDoc').hide();
        $('#operacionEnviar').hide();
    }
    else
    {
        $(btn).data('estado','desactivado');
        $('#docId').prop('readonly',true);
        cargarSubmodulo(1,'.html/modulo1/m1submod1.html');
    }
}

function habilitar_busqueda(tipo)
{
    if(tipo == 'fecha')
    {
        $('form.frm-busqueda-rapida').hide();
        $('form#frmEncontrarDocFechas').show();
    }
    else if(tipo == 'asunto')
    {
        $('form.frm-busqueda-rapida').hide();
        $('form#frmEncontrarDocAsunto').show();
    }
    else if(tipo == 'codigo')
    {
        $('form.frm-busqueda-rapida').hide();
        $('form#frmEncontrarDocCodigo').show();
    }
    else if(tipo == 'remitente-persona')
    {
        $('form.frm-busqueda-rapida').hide();
        $('form#frmEncontrarDocRemitP').show();
    }
}
