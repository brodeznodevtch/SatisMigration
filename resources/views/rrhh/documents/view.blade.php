<div class="modal-header">
    <h4 class="modal-title" id="formModal">@lang('rrhh.file') | 
        @if ($document->date_expiration == null || $document->date_expiration >= Carbon::now()->format('Y-m-d'))
        <span class="badge" style="background: #449D44">Vigente</span>
        @else
        <span class="badge" style="background: #C9302C">Expirado</span>
        @endif
		<button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="closeModalView()">
			<span aria-hidden="true">&times;</span>
		</button>
	</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            @if ($ext == 'pdf')
                <style>
                    .pdfobject-container {
                        width: 87rem; 
                        height: 40rem; 
                        border: 1rem solid rgba(0,0,0,.1); 
                    }
                </style>

                <div id="pdf">

                </div>
                <script>
                    PDFObject.embed("{{ asset($route) }}", "#pdf");
                </script>
            @else
                <img src="{{ asset($route) }}" class="img-responsive">
            @endif
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <ul>
                <li><strong>{{ __('rrhh.document_type') }}:</strong> {{ $type->value }}</li>
                @if ($document->date_expedition != null)
                <li><strong>{{ __('rrhh.date_expedition') }}:</strong> {{ @format_date($document->date_expedition) }}</li>
                @endif
                @if ($document->date_expiration != null && $type->date_required == 1)
                <li><strong>{{ __('rrhh.date_expiration') }}:</strong> {{ @format_date($document->date_expiration) }}</li>
                @endif
                @if ($document->state_id != null)
                <li><strong>{{ __('rrhh.state_expedition') }}:</strong> {{ $state->name }}</li>
                @endif
                @if ($document->city_id != null)
                <li><strong>{{ __('rrhh.city_expedition') }}:</strong> {{ $city->name }}</li>
                @endif
                @if ($document->number != null)
                <li><strong>{{ __('rrhh.number') }}:</strong> {{ $document->number }}</li>
                @endif
            </ul>
        </div>
    </div>
</div>
<script>
    function closeModalView(){
		$('#modal_edit_action').modal({backdrop: 'static'});
		$('#modal_show').modal( 'hide' ).data( 'bs.modal', null );
	}
</script>