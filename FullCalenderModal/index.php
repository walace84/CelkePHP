<?php

session_start();

include_once("conexao.php");
$result_events = "SELECT id, title, color, start, end FROM events";
$resultado_events = mysqli_query($conn, $result_events);
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset='utf-8' />
			<link href='css/fullcalendar.min.css' rel='stylesheet' />
			<link href='css/bootstrap.min.css' rel='stylesheet' />
			<link href='css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
			<link href='css/personalizado.css' rel='stylesheet' />
			<script src='js/moment.min.js'></script>
			<script src='js/jquery.min.js'></script>
			<script src='js/bootstrap.min.js'></script>
			<script src='js/fullcalendar.min.js'></script>
			<script src='locale/pt-br.js'></script>
		<script>
			$(document).ready(function() {
				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					defaultDate: Date(),
					navLinks: true, // can click day/week names to navigate views
					editable: true,
					eventLimit: true, // allow "more" link when too many events
					eventClick: function(event) {

						$('#visualizar #id').text(event.id);
						$('#visualizar #id').val(event.id);
						$('#visualizar #title').text(event.title);
						$('#visualizar #title').val(event.title);
						$('#visualizar #start').val(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #start').text(event.start.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').val(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #end').text(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #color').val(event.color);
						$('#visualizar').modal('show');
						return false;

					},
				
					selectable: true, 	// Liberar o bloco do dia
					selectHelper: true, // destaca a hora do dia atual
					select: function(start, end){
						$('#cadastrar #start').val(moment(start).format('DD/MM/YYYY HH:mm:ss'));
						$('#cadastrar #end').val(moment(end).format('DD/MM/YYYY HH:mm:ss'));
						$('#cadastrar').modal('show');
					},
					events: [
						<?php
							while($row_events = mysqli_fetch_array($resultado_events)){
								?>
								{
								id: '<?php echo $row_events['id']; ?>',
								title: '<?php echo $row_events['title']; ?>',
								start: '<?php echo $row_events['start']; ?>',
								end: '<?php echo $row_events['end']; ?>',
								color: '<?php echo $row_events['color']; ?>',
								},<?php
							}
						?>
					]
				});
			});

			// Mascara para o campo data e hora
			function DataHora(evento, objeto){
				var keypress=(window.event)?event.keyCode:evento.which;
				campo = eval (objeto);
				if (campo.value == '00/00/0000 00:00:00'){
					campo.value=""
				}
			 
				caracteres = '0123456789';
				separacao1 = '/';
				separacao2 = ' ';
				separacao3 = ':';
				conjunto1 = 2;
				conjunto2 = 5;
				conjunto3 = 10;
				conjunto4 = 13;
				conjunto5 = 16;
				if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (19)){
					if (campo.value.length == conjunto1 )
					campo.value = campo.value + separacao1;
					else if (campo.value.length == conjunto2)
					campo.value = campo.value + separacao1;
					else if (campo.value.length == conjunto3)
					campo.value = campo.value + separacao2;
					else if (campo.value.length == conjunto4)
					campo.value = campo.value + separacao3;
					else if (campo.value.length == conjunto5)
					campo.value = campo.value + separacao3;
				}else{
					event.returnValue = false;
				}
			}

		</script>
	</head>
	<body>

		<!-- RETORNO DA MSG DE ERRO -->
		<div class="container">
			<div class="page-header">
				<h1 class='text-center'>Agenda</h1>
			</div>
			<?php
				if(isset($_SESSION['msg'])){
					echo $_SESSION['msg'];
					unset($_SESSION['msg']);
				}
			?>
		
			<div id='calendar'></div>
		</div>

		<!-- MOSTRA OS EVENTOS NO MODAL -->
		<div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop='static'>
			<div class="modal-dialog" role="document">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center">Dados do Evento</h4>
					</div>

					<div class="modal-body">

						<div class='visualizar'>
							<dl class='dl-horizontal'>
								<dt>ID</dt>
								<dd id='id'></dd>
								<dt>Nome do Evento</dt>
								<dd id='title'></dd>
								<dt>Inicio do Evento</dt>
								<dd id='start'></dd>
								<dt>Fim do Evento</dt>
								<dd id='end'></dd>
							</dl>

							<button class='btn btn-warning btn-cancela-vis'> Editar</button>
						</div>
						<!-- fim do visualizar -->
					</div>
					<!-- FORMULÁRIO DE EDIÇÃO -->
					<div class='form'>

						<form class="form-horizontal" method='POST' action='edit_evento.php'>

							<div class="form-group">
								<label for="titulo" class="col-sm-2 control-label">Titulo</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name='title' id='title'>
								</div>
							</div>

							<div class="form-group">
								<label for="cor" class="col-sm-2 control-label">Cor</label>
								<div class="col-sm-10">
									<select name="color" class="form-control" id="color">
										<option value="">Selecione</option>			
										<option style="color:#0000FF;" value="#0000FF">Azul</option>
										<option style="color:#228B22;" value="#228B22">Verde</option>
										<option style="color:#8B0000;" value="#8B0000">Vermelho</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="data" class="col-sm-2 control-label">Data Inicio</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name='start' id='start' onKeyPress="DataHora(event,this)">
								</div>
							</div>

							<div class="form-group">
								<label for="dataFinal" class="col-sm-2 control-label">Data Final</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name='end' id='end' onKeyPress="DataHora(event,this)">
								</div>
							</div>

							<!-- compo oculto que carrega o id para salvar os dados -->
							<input type="hidden" class="form-control" name='id' id='id'>

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="button" class='btn btn-primary btn-cancela-vis'> cancelar</button>
									<button type="submit" class="btn btn-success">Salvar</button>
								</div>
							</div>
						</form>

					</div>

				</div>
			</div>
		</div>

		<!-- FORMULÁRIO DE CADASTRO DE EVENTO -->
		<div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop='static'>
			<div class="modal-dialog" role="document">
				<div class="modal-content">

					<div class="modal-body">
						<form class="form-horizontal" method='POST' action='cad-evento.php'>

							<div class="form-group">
								<label for="titulo" class="col-sm-2 control-label">Titulo</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name='title'>
								</div>
							</div>

							<div class="form-group">
								<label for="cor" class="col-sm-2 control-label">Cor</label>
								<div class="col-sm-10">
									<select name="color" class="form-control" id="color">
										<option value="">Selecione</option>			
										<option style="color:#0000FF;" value="#0000FF">Azul</option>
										<option style="color:#228B22;" value="#228B22">Verde</option>
										<option style="color:#8B0000;" value="#8B0000">Vermelho</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="data" class="col-sm-2 control-label">Data Inicio</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name='start' id='start' onKeyPress="DataHora(event,this)">
								</div>
							</div>

							<div class="form-group">
								<label for="dataFinal" class="col-sm-2 control-label">Data Final</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name='end' id='end' onKeyPress="DataHora(event,this)">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-success">Cadastrar</button>
								</div>
							</div>
						</form>
					</div>
			
				</div>
			</div>
		</div>

		<!-- Ocultar o botão de editar -->
		<script>
			$('.btn-cancela-vis').on('click', function(){
				$('.form').slideToggle();
				$('.visualizar').slideToggle();
			});

			$('.btn-cancela-edit').on('click', function(){
				$('.visualizar').slideToggle();
				$('.form').slideToggle();
			});
		</script>

	</body>
</html>
