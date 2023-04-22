
	
	$(document).ready(function() {
		$('#responsive-datatable').dataTable({
				"lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
				"order":[],
				"language": {
									"decimal":        "",
									"emptyTable":     "Nenhum registro encontrado",
									"info":           "Mostrando: _START_ at\u00e9 _END_ de _TOTAL_ registros",
									"infoEmpty":      "Mostrando: 0 de 0 registros",
									"infoFiltered":   "(Filtrados de _MAX_ registros)",
									"infoPostFix":    "",
									"thousands":      ",",
									"lengthMenu":     "_MENU_ resultados por página",
									"loadingRecords": "Carregando...",
									"processing":     "Processando...",
									"search":         "Pesquisar:",
									"zeroRecords":    "Nenhum registro encontrado",
									"paginate": {
																"first":      "Primeiro",
																"last":       "\u00daltimo",
																"next":       "Pr\u00f3ximo",
																"previous":   "Anterior"
															},
				}
				
		});
	});

	$(document).ready(function() {
		$('#responsive-datatable2').dataTable({
				"lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
				"order":[[2, 'asc'], [ 0, 'asc' ]],
				"language": {
									"decimal":        "",
									"emptyTable":     "Nenhum registro encontrado",
									"info":           "Mostrando: _START_ at\u00e9 _END_ de _TOTAL_ registros",
									"infoEmpty":      "Mostrando: 0 de 0 registros",
									"infoFiltered":   "(Filtrados de _MAX_ registros)",
									"infoPostFix":    "",
									"thousands":      ",",
									"lengthMenu":     "_MENU_ resultados por página",
									"loadingRecords": "Carregando...",
									"processing":     "Processando...",
									"search":         "Pesquisar:",
									"zeroRecords":    "Nenhum registro encontrado",
									"paginate": {
																"first":      "Primeiro",
																"last":       "\u00daltimo",
																"next":       "Pr\u00f3ximo",
																"previous":   "Anterior"
															},
				}
				
		});

	});
	
	
	$(document).ready(function() {

		// Default Datatable
		$('#datatable').DataTable();

		//Buttons examples
		var table = $('#datatable-buttons').DataTable({
			lengthChange: false,
			buttons: [ 'excel', 'pdf'],
				"order": [],
				"language": {
									"decimal":        "",
									"emptyTable":     "Nenhum registro encontrado",
									"info":           "Mostrando: _START_ at\u00e9 _END_ de _TOTAL_ registros",
									"infoEmpty":      "Mostrando: 0 de 0 registros",
									"infoFiltered":   "(Filtrados de _MAX_ registros)",
									"infoPostFix":    "",
									"thousands":      ",",
									"lengthMenu":     "_MENU_ resultados por página",
									"loadingRecords": "Carregando...",
									"processing":     "Processando...",
									"search":         "Pesquisar:",
									"zeroRecords":    "Nenhum registro encontrado",
									"paginate": {
																"first":      "Primeiro",
																"last":       "\u00daltimo",
																"next":       "Pr\u00f3ximo",
																"previous":   "Anterior"
															},
				}
			
		});

		table.buttons().container()
		.appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
	} );
	
	

