//Evalua el submódulo a cargar (Agregar Personal, Editar Personal, Reportes)
function cargarSubmodulo(id,desde)
{
	$("#modules").load(desde);
	document.getElementById("modules").style.display="block";

	if (id==1)
		//Iniciar Agregar Intervención
		initSubModulo1();
	if (id==2)
		//Iniciar Reportes
		initSubModulo2();
}
//Inicia controles para "Agregar Intervención"
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
				opt.text = Cadena3[2];
				document.getElementById("docOfiCreador").add(opt);
			}

            Cadena2 = Cadena1[0].split('$');
            for (i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');
                var opt = document.createElement("option");
                opt.value = Cadena3[0];
                opt.text = Cadena3[2];
                document.getElementById("docOfiEnvio").add(opt);
            }

            Cadena2 = Cadena1[0].split('$');
            for (i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');
                var opt = document.createElement("option");
                opt.value = Cadena3[0];
                opt.text = Cadena3[2];
                document.getElementById("docOfiDestino").add(opt);
            }

            Cadena2 = Cadena1[1].split('$');
            for (i = 0; i<(Cadena2.length)-1; i++)
            {
                Cadena3 = Cadena2[i].split('|');
                var opt = document.createElement("option");
                opt.value = Cadena3[0];
                opt.text = Cadena3[1];
                document.getElementById("docTipo").add(opt);
            }
		}
	}

	xmlhttp.open("POST",".lib/modulo4/linkModulo4.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo1=1");
}

//Inicia controles para "Reportes"
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
                opt.text = Cadena3[2];
                document.getElementById("docOfiCreador").add(opt);
            }

            Cadena2 = Cadena1[1].split('$');
            Cadena3 = Cadena2[0].split('|');
            $('#docOfiCreador').val(Cadena3[1]);
            $('#docOfiCreadorH').val(Cadena3[1]);
		}
	}

	xmlhttp.open("POST",".lib/modulo4/linkModulo4.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("initSubModulo2=1");
}

function buscar_documento(forma)
{
    if(forma == 'documento')
    {
        var url = $('#frmBuscDoc').prop('action');
        var data = $('#frmBuscDoc').serialize() + "&buscardoc=1";

        $.post(url, data, function(response){
            Cadena1 = response.split('%');
            Cadena2 = Cadena1[0].split('$');
            html = "";

            $('#tblResultadoBusqDoc tbody').empty();
            $('#headBuscDoc').show();
            $('#headBuscMov').hide();

            for(i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');
                html  += "<tr id='row-arc-"+Cadena3[13]+"'>";
                html += "<td>"+ (i+1) +"</td>";
                html += "<td>"+ Cadena3[10] +"</td>";
                html += "<td>"+ Cadena3[4] +"</td>";
                html += "<td>"+ Cadena3[8] +"</td>";
                html += "<td>"+ Cadena3[3] +"</td>";
                html += "<td>"+ Cadena3[12] +"</td>";
                html += "<td>"+ Cadena3[1] +"</td>";
                html += "<td><button type='button' class='btn btn-warning' onclick='trazar_seguimiento(\"" + Cadena3[13] + "\")'>Ver</button></td>";
                html += "</tr>";
            }

            $('#tblResultadoBusqDoc tbody').append(html);
        });
    }
    else if(forma == 'movimiento')
    {
        var url = $('#frmBuscMov').prop('action');
        var data = $('#frmBuscMov').serialize() + "&buscarmov=1";

        $.post(url, data, function(response){
            Cadena1 = response.split('%');
            Cadena2 = Cadena1[0].split('$');
            html = "";

            $('#tblResultadoBusqDoc tbody').empty();
            $('#headBuscDoc').hide();
            $('#headBuscMov').show();

            for(i=0 ; i<(Cadena2.length)-1 ; i++)
            {
                Cadena3 = Cadena2[i].split('|');
                html  += "<tr id='row-arc-"+Cadena3[1]+"'>";
                html += "<td>"+ (i+1) +"</td>";
                html += "<td>"+ Cadena3[11] +"</td>";
                html += "<td>"+ Cadena3[5] +"</td>";
                html += "<td>"+ Cadena3[9] +"</td>";
                html += "<td>"+ Cadena3[31] +"</td>";
                html += "<td>"+ Cadena3[15] +"</td>";
                html += "<td>"+ Cadena3[24] +"</td>";
                html += "<td>"+ Cadena3[16] +"</td>";
                html += "<td>"+ Cadena3[8] +"</td>";
                html += "<td><button type='button' class='btn btn-warning' onclick='trazar_seguimiento(\"" + Cadena3[1] + "\")'>Ver</button></td>";
                html += "</tr>";
            }

            $('#tblResultadoBusqDoc tbody').append(html);
        });
    }
}

function trazar_seguimiento(arcid)
{
    var url = '.lib/modulo4/linkModulo4.php';
    var data = {"arcId": arcid, "seguimiento": 1};

    $.getJSON(url, data, function(response){
        if(response.response == 200)
        {
            $('#resultSeguimiento').html(response.Respuesta);
        }
        else if(response.response == 500)
        {
            alert(response.msg);
        }
    });
}

function preview_reporte(formato)
{
    if(formato == 'html')
    {
        $('#docImprimible').prop('disabled',true);
        var url = $('#frmReporteDoc').prop('action');
        var data = $('#frmReporteDoc').serialize() + '&reporte=1';

        $.post(url, data, function(response){
            response = $.parseJSON(response);
            if(response.response == 200)
            {
                $('#vistaPreliminar').html(response.Respuesta);
            }
            else if(response.response == 500)
            {
                alert(response.msg);
            }
        });
    }
    else if(formato == 'pdf')
    {
        $('#docImprimible').prop('disabled',false);
        $('#frmReporteDoc').submit();
    }
    else if(formato == 'xls')
    {
        var tmpElemento = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel';
        var tabla_div = document.getElementById('tblReporteResultado');
        var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
        tmpElemento.href = data_type + ', ' + tabla_html;
        tmpElemento.download = 'reporte_tramite.xls';
        tmpElemento.click();
    }
}