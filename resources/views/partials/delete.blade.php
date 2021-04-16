<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Let op!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Weet je zeker dat je dit item wilt vewijderen?</p>
                <strong>Dit kan <u>niet</u> ongedaan gemaakt worden!</strong>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" href="{{route('destroy.item', $item->id)}}">Verwijderen</a>
                <a class="btn btn-outline-secondary" href="javascript:void(0)" data-dismiss="modal" aria-label="Close">Annuleren</a>
            </div>
        </div>
    </div>
</div>
