<div id="modalMantenimientoExtras" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form enctype="multipart/form-data" action="{{ route('auth.extras.update') }}" id="registroExtras" method="POST"
            data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroExtras" data-ajax-failure="OnFailureRegistroExtras">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $Entity != null ? 'Modificar' : ' Registrar' }} Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $Entity != null ? $Entity->id : 0 }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="estado">
                                    Estado
                                </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control" name="estado" id="estado" required>
                                            <option value="0" {{ $Entity && $Entity->estado == '0' ? 'selected' : '' }}>Pendiente</option>
                                            <option value="1" {{ $Entity && $Entity->estado == '1' ? 'selected' : '' }}>Aprobado</option>
                                            <option value="2" {{ $Entity && $Entity->estado == '2' ? 'selected' : '' }}>Rechazado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="btn btn-bold btn-pure btn-primary">{{ $Entity != null ? 'Modificar' : ' Registrar' }}
                        </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="{{ asset('auth/js/extras/_Mantenimiento.js') }}"></script>
