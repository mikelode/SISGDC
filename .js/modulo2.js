//Evalua el submódulo a cargar (Agregar Software, Editar Software, Reportes)
function cargarSubmodulo(id,desde)
{
	$("#modules").load(desde);
	document.getElementById("modules").style.display="block";

	if (id==1)
		//Inicia Agregar Software
		initSubModulo1();
	if (id==2)
		//Inicia Editar Software
		initSubModulo2();
    if (id==11)
        //Tipo de Documentos
        initSubModulo11();
    if (id==12)
        //Oficinas y Jefes
        initSubModulo12();
    if (id==13)
        //Seguimiento Documentario
        initSubModulo13();
}
//Inicia controles para "Agregar Software"
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
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			Cadena1 = xmlhttp.responseText.split('%');
			Cadena2 = Cadena1[0].split('$');
			html = "";

			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				html  += "<tr id='row-his-"+Cadena3[0]+"'>";
				html += "<td>"+ (i+1) +"</td>";
				html += "<td>"+ Cadena3[2] +"</td>";
				html += "<td>"+ Cadena3[11] +"</td>";
				html += "<td>"+ Cadena3[10] +"</td>";
				html += "<td>"+ Cadena3[12] +"</td>";
				html += "<td>"+ construir_botones(Cadena3[5], Cadena3[4], Cadena3[3], Cadena3[0]) +"</td>";
				html += "</tr>";
			}

			$('#tblDocPorProcesar tbody').append(html);

			Cadena2 = Cadena1[1].split('$');
			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				var opt = document.createElement("option");
				opt.value = Cadena3[0];
				opt.text = Cadena3[1];
				document.getElementById("docEnvioDestino").add(opt);
			}

            Cadena2 = Cadena1[1].split('$');
            for (i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');
                var opt = document.createElement("option");
                opt.value = Cadena3[0];
                opt.text = Cadena3[1];
                document.getElementById("docEnvioDestinoCD").add(opt);
            }

			Cadena2 = Cadena1[2].split('$');
			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');
				var opt = document.createElement("option");
				opt.value = Cadena3[0];
				opt.text = Cadena3[1];
				document.getElementById("docTipoDerivarCD").add(opt);
			}

		}
	};

	xmlhttp.open("POST",".lib/modulo2/linkModulo2.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo1=1");
}

//Inicia controles para "Editar Software"
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
			html = "";

			for (i=0 ; i<(Cadena2.length)-1 ; i++)
			{
				Cadena3 = Cadena2[i].split('|');

				if(Cadena3[4] == 1)	html  += "<tr id='row-his-"+Cadena3[0]+"' class='bg-info'>";
				else if(Cadena3[3] == 1) html  += "<tr id='row-his-"+Cadena3[0]+"' class='bg-success'>";

				html += "<td>"+ (i+1) +"</td>";
                html += "<td>"+ Cadena3[17] +"</td>";
				html += "<td>"+ Cadena3[10] +"</td>";
				html += "<td>"+ Cadena3[2] +"</td>";
				html += "<td>"+ Cadena3[11] +"</td>";
				html += "<td>"+ construir_estados(Cadena3[5], Cadena3[4], Cadena3[3], Cadena3[0]) +"</td>";
                if(Cadena3[4] == 1) // si se ha derivado
                {
                    html += "<td>"+ Cadena3[14] +"</td>";
                    html += "<td>"+ Cadena3[16] +"</td>";
                }
                else if(Cadena3[3] == 1) // si se ha atendido
                {
                    html += "<td>"+ Cadena3[13] +"</td>";
                    html += "<td>"+ Cadena3[15] +"</td>";
                }
                html += "<td>"+ Cadena3[12] +"</td>";
				html += "</tr>";
			}

			$('#tblDocProcesados tbody').append(html);
		}
	}

	xmlhttp.open("POST",".lib/modulo2/linkModulo2.php",true);
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
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            Cadena1 = xmlhttp.responseText.split('%');
            Cadena2 = Cadena1[0].split('$');
            var html = '';

            for (i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');

                html += "<tr id='row-tip-"+ Cadena3[0] +"' >";
                html += "<td>" + (i+1) + "</td>";
                html += "<td>" + Cadena3[1] + "</td>";
                html += "<td><a href='#' data-tipo='"+Cadena3[0]+"' data-toggle='modal' data-target='#modalEditarTipodoc' onclick='mostrar_modal_editar_tipodoc(this)'> Editar </a> - " +
                        "<a href='javascript:void(0)' class='text-danger'> Eliminar </a></td>";
                html += "</tr>";
            }

            $('#tblTipoDocumentos tbody').append(html);
        }
    }

    xmlhttp.open("POST",".lib/modulo2/linkModulo2-admin.php",true);
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
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            Cadena1 = xmlhttp.responseText.split('%');

            Cadena2 = Cadena1[0].split('$');
            var html = '';

            for (i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');

                html += "<tr id='row-" + Cadena3[0] + "-" + Cadena3[4] + "' >";
                html += "<td>" + (i+1) + "</td>";
                html += "<td>" + Cadena3[2] + "</td>";
                html += "<td>" + Cadena3[5] + "</td>";
                html += "<td>" + Cadena3[6] + "</td>";
                html += "<td>" + Cadena3[7] + "</td>";
                html += "<td>" + Cadena3[8] + "</td>";
                html += "<td><a href='#' data-toggle='modal' data-target='#modalEditarOfijefe' onclick='mostrar_modal_editar_oficina(this)'> Editar </a></td>";
                html += "</tr>";
            }

            $('#tblOficinasJefes tbody').append(html);

            Cadena2 = Cadena1[1].split('$');
            for (i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');
                var opt = document.createElement("option");
                opt.value = Cadena3[0];
                opt.text = Cadena3[2] + ' ' + Cadena3[3] + ' ' + Cadena3[4];
                document.getElementById("ofiJefe").add(opt);
            }

            Cadena2 = Cadena1[1].split('$');
            for (i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');
                var opt = document.createElement("option");
                opt.value = Cadena3[0];
                opt.text = Cadena3[2] + ' ' + Cadena3[3] + ' ' + Cadena3[4];
                document.getElementById("ofiNuevoJefe").add(opt);
            }
        }
    }

    xmlhttp.open("POST",".lib/modulo2/linkModulo2-admin.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("initSubModulo12=1");
}

function initSubModulo13()
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
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var fecha = new Date();
            $('#periodoTramite').val(fecha.getFullYear());
        }
    };

    xmlhttp.open("POST",".lib/modulo2/linkModulo2-admin.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("initSubModulo13=1");
}

function mostrar_modal_editar_tipodoc(btn)
{
    var tdocId = $(btn).data('tipo');
    var row = $(btn).closest('tr');
    var tdocDesc = row.find('td:eq(1)').text();

    var modal = $('#modalEditarTipodoc');
    modal.find('.modal-body input#tipodocId').val(tdocId);
    modal.find('.modal-body input#tipodocDescE').val(tdocDesc);
}

function grabar_nuevo_cambio(target)
{
    if(target == 'dockind')
    {
        var url = $('#frmNuevoTipodoc').prop('action');
        var data = $('#frmNuevoTipodoc').serialize() + '&newtdoc=1';
    }
    else if(target == 'boss')
    {
        var url = $('#frmNuevoJefe').prop('action');
        var data = $('#frmNuevoJefe').serialize() + '&newjef=1';
    }
    else if(target == 'office')
    {
        var url = $('#frmNuevaOficina').prop('action');
        var data = $('#frmNuevaOficina').serialize() + '&newofi=1';
    }

    $.post(url, data, function(response){
        var res = $.parseJSON(response);
        if(res.Respuesta == 200)
        {
            alert(res.msg);
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            if(target == 'dockind')
                cargarSubmodulo(11,'.html/modulo2-admin/m2submod1.html');
            else
                cargarSubmodulo(12,'.html/modulo2-admin/m2submod2.html');
        }
        else
        {
            alert(res.msg);
        }
    });
}

function grabar_edicion_tipodoc()
{
    var url = $('#frmEditarTipodoc').prop('action');
    var data = $('#frmEditarTipodoc').serialize() + '&edittdoc=1';

    $.post(url, data, function(response){
        var res = $.parseJSON(response);
        if(res.Respuesta == 200)
        {
            alert(res.msg);
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            cargarSubmodulo(11,'.html/modulo2-admin/m2submod1.html');
        }
        else
        {
            alert(res.msg);
        }
    });
}

function grabar_edicion_ofijefe()
{
    var url = $('#frmEditarOfijefe').prop('action');
    var data = $('#frmEditarOfijefe').serialize() + '&editofijef=1';

    $.post(url, data, function(response){
        var res = $.parseJSON(response);
        if(res.Respuesta == 200)
        {
            alert(res.msg);
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            cargarSubmodulo(12,'.html/modulo2-admin/m2submod2.html');
        }
        else
        {
            alert(res.msg);
        }
    });
}

function mostrar_modal_editar_oficina(btn)
{
    var row = $(btn).closest('tr');
    var idRow = $(btn).closest('tr').attr('id');//ofi-jefe
    idRow = idRow.split('-');
    var idOfi = idRow[1];
    var idJef = idRow[2];
    var ofiDesc = row.find('td:eq(1)').text();
    var jefActual = row.find('td:eq(2)').text() + '-' + row.find('td:eq(3)').text() + ' ' + row.find('td:eq(4)').text() + ' ' + row.find('td:eq(5)').text();

    var modal = $('#modalEditarOfijefe');
    modal.find('.modal-body input#ofiId').val(idOfi);
    modal.find('.modal-body input#jefId').val(idJef);
    modal.find('.modal-body input#ofiDescE').val(ofiDesc);
    modal.find('.modal-body input#ofiJefeActual').val(jefActual);
}

function construir_botones(flagR, flagD, flagA, hisid)
{
	if(flagR == 0)
	{
		html = "<button data-hisid='" + hisid + "' data-toggle='modal' data-target='modalOperacionRecibir' onclick='mostrar_modal(this,\"R\")' class='btn btn-danger btn-xs' id='btnOpcRecibir' style='display: block;'>Recibir</button>";
		html += "<div class='btn-group' style='display: none;'>" +
				"<button class='btn btn-info btn-xs dropdown-toggle' data-toggle='dropdown' aria-expanded='false' id='btnOpcDerivar'>Derivar <span class='caret'></span></button>" +
				"<ul class='dropdown-menu' role='menu'><li>Simple</li><li>Mediante documento</li></ul>" +
				"</div>";
		html += "<button data-hisid='" + hisid + "' data-toggle='modal' data-target='modalOperacionAtender' onclick='mostrar_modal(this,\"A\")' class='btn btn-success btn-xs' id='btnOpcAtender' style='display: none;'>Atender</button>";
	}
	else
	{
		html = "<button data-hisid='" + hisid + "' data-toggle='modal' data-target='modalOperacionRecibir' onclick='mostrar_modal(this,\"R\")' class='btn btn-danger btn-xs' id='btnOpcRecibir' style='display: none;'>Recibir</button>";
		//html += "<button data-hisid='" + hisid + "' data-toggle='modal' data-target='modalOperacionDerivar' onclick='mostrar_modal(this,\"D\")' class='btn btn-info btn-xs' id='btnOpcDerivar' style='display: block;'>Derivar</button>";
		html += "<div class='btn-group' style='float: left;'>" +
				"<button class='btn btn-info btn-xs dropdown-toggle' data-toggle='dropdown' aria-expanded='false' id='btnOpcDerivar'>Derivar <span class='caret'></span></button>" +
				"<ul class='dropdown-menu' role='menu'>" +
				"<li><a href='#' data-hisid='"+ hisid +"' data-toggle='modal' data-target='modalOperacionDerivar' onclick='mostrar_modal(this,\"D\")'>Simple</a></li>" +
				"<li><a href='#' data-hisid='"+ hisid +"' data-toggle='modal' data-target='modalOperacionDervivarCD' onclick='mostrar_modal(this,\"DcD\")'>Mediante documento</a></li>" +
				"</ul></div>";
		html += "<button data-hisid='" + hisid + "' data-toggle='modal' data-target='modalOperacionAtender' onclick='mostrar_modal(this,\"A\")' class='btn btn-success btn-xs' id='btnOpcAtender' style='display: block;'>Atender</button>";
	}

	return html;
}

function construir_estados(flagR, flagD, flagA, hisid)
{
	if(flagD == 1)
	{
		html = "<h4 style='margin: 3px;'><span class='label label-info'>DERIVADO</span></h4>";
	}

	if(flagA == 1)
	{
		html = "<h4 style='margin: 3px;'><span class='label label-success'>ATENDIDO</span></h4>";
	}

	return html;
}

function mostrar_modal(btn, op)
{
	var hisid = $(btn).data('hisid');
	var row = $(btn).parents('tr');
	var doc = row.find('td:eq(3)').text();

	if(op == 'R')
	{
		var modal = $('#modalOperacionRecibir');
		modal.find('.modal-body input#docHisIdR').val(hisid);
		modal.find('.modal-body input#docRecibir').val(doc);
		$('#modalOperacionRecibir').modal('show');
	}
	else if(op == 'D')
	{
		var modal = $('#modalOperacionDerivar');
		modal.find('.modal-body input#docHisIdD').val(hisid);
		modal.find('.modal-body input#docDerivar').val(doc);
		$('#modalOperacionDerivar').modal('show');
	}
	else if(op == 'DcD')
	{
		var modal = $('#modalOperacionDerivarCD');
		modal.find('.modal-body input#docHisIdDCD').val(hisid);
		modal.find('.modal-body input#docDerivarCD').val(doc);
		$('#modalOperacionDerivarCD').modal('show');
	}
	else
	{
		var modal = $('#modalOperacionAtender');
		modal.find('.modal-body input#docHisIdA').val(hisid);
		modal.find('.modal-body input#docAtender').val(doc);
		$('#modalOperacionAtender').modal('show');
	}


}

function actualizar_estado(btn,e)
{
	e.preventDefault();
	var row = $(btn).parents('tr');
	var id = row.prop('id');

	var url = '.lib/modulo2/linkModulo2.php';
	var data = {'rowHis': id, 'recibir': 1};

	$.post(url, data, function(response){

	});

	//alert(row.find('td:eq(0)').text());
}

function grabarAtencion()
{
	var url = $('#frmGrabarAtencion').prop('action');
	var data = $('#frmGrabarAtencion').serialize() + '&atender=1';

	$.post(url, data, function(response){
		var res = $.parseJSON(response);
		if(res.Respuesta == '200')
		{
			$('#modalOperacionAtender').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            cargarSubmodulo(1,'.html/modulo2/m2submod1.html');
			alert(res.msg);
		}
		else
		{
			alert(res.msg);
		}
	});
}

function grabarRecepcion()
{
	var url = $('#frmGrabarRecepcion').prop('action');
	var data = $('#frmGrabarRecepcion').serialize() + '&recibir=1';

	$.post(url, data, function(response){
		var res = $.parseJSON(response);
		if(res.Respuesta == '200')
		{
			$('#modalOperacionRecibir').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            cargarSubmodulo(1,'.html/modulo2/m2submod1.html');
			alert(res.msg);
		}
		else
		{
			alert(res.msg);
		}
	});
}

function grabarDerivacion(tipo)
{
    var url = $('#frmGrabarDerivacion').prop('action');
    var data = '';

    if(tipo == 'simple')
        data = $('#frmGrabarDerivacion').serialize() + '&derivarSimple=1';
    else
        data = $('#frmGrabarDerivacionCD').serialize() + '&derivarCompuesta=1';

	$.post(url, data, function(response){
		var res = $.parseJSON(response);
		if(res.Respuesta == '200')
		{
            if(tipo == 'simple')
			    $('#modalOperacionDerivar').modal('hide');
            else
                $('#modalOperacionDerivarCD').modal('hide');

            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            cargarSubmodulo(1,'.html/modulo2/m2submod1.html');
			alert(res.msg);
		}
		else
		{
			alert(res.msg);
		}
	});
}

function cargar_seguimiento()
{
    var idExp = $('#docIdSeguimiento').val();
    if($.trim(idExp) == '') return;

    var url = '.lib/modulo2/linkModulo2-admin.php';
    var data = {'idExp': idExp, 'cargarSeguimiento': 1}

    $.post(url,data,function(response){
        response = $.parseJSON(response);
        if(response.response == 200)
        {
            $('#resultSeguimientoCorrecion').html(response.Respuesta);
        }
        else if(response.response == 500)
        {
            alert(response.msg);
        }
    });
}