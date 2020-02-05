<div class="modal fade" id="logout-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Deseja realmente sair?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        Selecione "Sair" abaixo se você estiver pronto para terminar sua sessão atual.
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <form action="{{ route('logout') }}" method="POST" id="modal-form">
          @csrf
        </form>

        <button type="submit" class="btn btn-danger btn-shadow" form="modal-form">Sair</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>