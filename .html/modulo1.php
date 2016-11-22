<?php session_start(); ?>
<script type="text/javascript" src=".js/modulo1.js"></script>
<ul class="nav nav-tabs nav-justified">
	<li role="presentation"><a href="javascript:cargarSubmodulo(1,'.html/modulo1/m1submod1.html')"><span class="glyphicon glyphicon-plus"></span><br>Documento interno</a></li>
    <?php if($_SESSION['oficina'] == 5){ ?>
    <li role="presentation"><a href="javascript:cargarSubmodulo(2,'.html/modulo1/m1submod2.html')"><span class="glyphicon glyphicon-pencil"></span><br>Documento externo</a></li>
    <?php } ?>
	<li role="presentation"><a href="javascript:cargarMenu('.html/main.html')"><span class="glyphicon glyphicon-arrow-left"></span><br>Men&uacute; Principal</a></li>
</ul>
<div id="msjsuccess" class="alert alert-success" role="alert"></div>