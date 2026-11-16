<div class="modal fade" id="content-revisions-modal" tabindex="-1" role="dialog" aria-labelledby="content-revisions-title" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="content-revisions-title">Revision history</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Preview a saved version or restore its content to draft using the current product layout. Publish when ready.</p>
                <p class="text-muted small">History starts with the first save after revisions are enabled. Unsaved changes are not recorded.</p>
                <p id="content-revisions-current" class="font-weight-bold" aria-live="polite"></p>
                <div id="content-revisions-message" role="status" aria-live="polite"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-nowrap">
                        <thead><tr><th>Version</th><th>Action</th><th>Saved by</th><th>Date</th><th>Actions</th></tr></thead>
                        <tbody id="content-revisions-list"></tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="content-revisions-newer" disabled>Newer</button>
                    <span id="content-revisions-page" class="text-muted small"></span>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="content-revisions-older" disabled>Older</button>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('admin/js/product-content-revisions.js') }}?v=4"></script>
@endpush
