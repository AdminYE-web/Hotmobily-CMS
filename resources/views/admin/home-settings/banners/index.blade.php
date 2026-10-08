@extends('admin.layouts.app')

@section('title', 'Home Setting - Home Banner')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">Home Setting - Home Banner</h1>
                <p class="text-muted mb-0">Manage the desktop and mobile slides shown at the top of the homepage.</p>
            </div>
            <a href="{{ route('admin.home-settings.banners.create') }}" class="btn btn-primary mt-2 mt-md-0">+ Add Home Banner</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                <strong>Homepage slides</strong>
                <span id="home-banner-order-status" class="small text-muted" role="status" aria-live="polite">Drag rows to change their order.</span>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr><th style="width:76px">Order</th><th style="width:160px">Desktop / Mobile</th><th>Link and alt text</th><th style="width:100px">Status</th><th style="width:180px">Actions</th></tr>
                    </thead>
                    <tbody id="home-banner-list" data-reorder-url="{{ route('admin.home-settings.banners.reorder') }}" data-csrf-token="{{ csrf_token() }}">
                        @forelse ($items as $item)
                            <tr data-banner-row data-id="{{ $item->id }}" draggable="true" title="Drag this row to reorder">
                                <td class="text-nowrap"><span class="home-banner-drag-handle" aria-hidden="true">&#8942;</span><span class="ml-2">{{ $loop->iteration }}</span></td>
                                <td>
                                    <img src="{{ $item->desktop_image_url }}" alt="{{ $item->alt_text }}" style="width:125px;height:48px;object-fit:contain;display:block">
                                    <img src="{{ $item->mobile_image_url }}" alt="" style="width:60px;height:48px;object-fit:contain;display:block;margin-top:4px">
                                </td>
                                <td>
                                    <div><strong>{{ $item->alt_text ?: 'Home banner' }}</strong></div>
                                    @if ($item->link_url)
                                        <code class="text-break">{{ $item->link_url }}</code>
                                    @else
                                        <span class="text-muted">No link</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-{{ $item->is_active ? 'success' : 'secondary' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</span></td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.home-settings.banners.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.home-settings.banners.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Remove this Home Banner?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-5">No Home Banners are configured. Add a banner to show a slideshow on the homepage.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #home-banner-list [data-banner-row] { cursor: grab; }
        #home-banner-list [data-banner-row]:active { cursor: grabbing; }
        .home-banner-drag-handle { color: #65717d; font-size: 20px; line-height: 1; user-select: none; }
        [data-banner-row].is-dragging { opacity: .45; }
        [data-banner-row].drop-before td { border-top: 3px solid #007bff; }
        [data-banner-row].drop-after td { border-bottom: 3px solid #007bff; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const list = document.getElementById('home-banner-list');
            const status = document.getElementById('home-banner-order-status');
            if (!list || !status) return;

            let draggedRow = null;
            let originalOrder = [];
            const currentOrder = function () {
                return Array.from(list.querySelectorAll('[data-banner-row]')).map(function (row) { return Number(row.dataset.id); });
            };
            const updateNumbers = function () {
                list.querySelectorAll('[data-banner-row]').forEach(function (row, index) {
                    const number = row.querySelector('td:first-child span.ml-2');
                    if (number) number.textContent = String(index + 1);
                });
            };
            const clearMarks = function () {
                list.querySelectorAll('.drop-before, .drop-after').forEach(function (row) { row.classList.remove('drop-before', 'drop-after'); });
            };

            list.addEventListener('dragstart', function (event) {
                const row = event.target.closest('[data-banner-row]');
                if (!row || event.target.closest('a, button, form, input, select, textarea')) { event.preventDefault(); return; }
                draggedRow = row;
                originalOrder = currentOrder();
                row.classList.add('is-dragging');
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', row.dataset.id);
                status.textContent = 'Release the row to save its new position.';
            });
            list.addEventListener('dragover', function (event) {
                if (!draggedRow) return;
                event.preventDefault();
                const target = event.target.closest('[data-banner-row]');
                if (!target || target === draggedRow) return;
                clearMarks();
                const after = event.clientY > target.getBoundingClientRect().top + target.getBoundingClientRect().height / 2;
                target.classList.add(after ? 'drop-after' : 'drop-before');
                const reference = after ? target.nextElementSibling : target;
                if (reference !== draggedRow) list.insertBefore(draggedRow, reference);
            });
            list.addEventListener('drop', function (event) { if (draggedRow) event.preventDefault(); });
            list.addEventListener('dragend', function () {
                if (draggedRow) draggedRow.classList.remove('is-dragging');
                draggedRow = null;
                clearMarks();
                updateNumbers();
                const order = currentOrder();
                if (order.length && order.some(function (id, index) { return id !== originalOrder[index]; })) saveOrder(order, originalOrder);
                else status.textContent = 'Drag rows to change their order.';
            });

            async function saveOrder(order, previousOrder) {
                status.textContent = 'Saving order...';
                status.classList.remove('text-danger', 'text-success');
                status.classList.add('text-muted');
                try {
                    const response = await fetch(list.dataset.reorderUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': list.dataset.csrfToken },
                        body: JSON.stringify({order: order}),
                    });
                    if (!response.ok) throw new Error('Could not save the Home Banner order. Refresh and try again.');
                    status.textContent = 'Order saved.';
                    status.classList.remove('text-muted', 'text-danger');
                    status.classList.add('text-success');
                } catch (error) {
                    const rows = new Map(Array.from(list.querySelectorAll('[data-banner-row]')).map(function (row) { return [Number(row.dataset.id), row]; }));
                    previousOrder.forEach(function (id) { const row = rows.get(id); if (row) list.appendChild(row); });
                    updateNumbers();
                    status.textContent = error.message || 'Could not save the Home Banner order.';
                    status.classList.remove('text-muted', 'text-success');
                    status.classList.add('text-danger');
                }
            }
        });
    </script>
@endpush
