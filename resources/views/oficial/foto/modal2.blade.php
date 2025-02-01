<div class="modal fade modal-sllide-in-rigth" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$us->id_users}}">

	<form method="post" action="{{url('/oficial/foto/'.$us->id_users.'/deleteuser')}}">
		{{csrf_field()}}


		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="close">
						<span aria-hidden="true">x</span>
					</button>
					<h4 class="modal-title">Eliminar Usuario</h4>
				</div>
				<div class="modal-body">
					<p>Confirme si desea eliminar al Usuario</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-success">Confirmar</button>
				</div>
			</div>
		</div>
	</form>
</div>