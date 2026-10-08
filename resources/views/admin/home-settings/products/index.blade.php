@extends('admin.layouts.app')

@section('title', 'Home Setting - Product')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">Home Setting — Product</h1>
                <p class="text-muted mb-0">Manage the product cards on the homepage. As soon as cards are configured, this ordered list replaces the old hard-coded product cards.</p>
            </div>
            <a href="{{ route('admin.home-settings.products.create') }}" class="btn btn-primary mt-2 mt-md-0">+ Add Product card</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                <strong>Homepage Product cards</strong>
                <span id="home-product-order-status" class="small text-muted" role="status" aria-live="polite">Drag rows to change their order.</span>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light"><tr><th style="width:76px">Order</th><th style="width:110px">Image</th><th>Card title</th><th>Product link</th><th style="width:190px">Actions</th></tr></thead>
                    <tbody id="home-product-list" data-reorder-url="{{ route('admin.home-settings.products.reorder') }}" data-csrf-token="{{ csrf_token() }}">
                        @forelse ($items as $item)
                            <tr data-menu-item-row data-id="{{ $item->id }}" draggable="true" title="Drag this row to reorder">
                                <td class="text-nowrap"><span class="home-product-drag-handle" aria-hidden="true">⠿</span><span class="ml-2">{{ $loop->iteration }}</span></td>
                                <td><img src="{{ Storage::disk('public')->url($item->image_path) }}" alt="{{ $item->name }}" style="width:90px;height:68px;object-fit:contain"></td>
                                <td><strong>{{ $item->name }}</strong><div class="small text-muted">Product: {{ $item->product?->name ?? 'Missing Product' }}</div></td>
                                <td>
                                    @if ($item->product)
                                        <code>/products/{{ trim($item->product->slug, '/') }}</code>
                                        <span class="badge badge-{{ $item->product->status === 'active' ? 'success' : 'secondary' }}">{{ $item->product->status }}</span>
                                    @else
                                        <span class="text-danger">Linked Product no longer exists</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.home-settings.products.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.home-settings.products.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Remove this homepage Product card?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-5">No Home Product cards are configured. The existing homepage Product cards remain visible.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #home-product-list [data-menu-item-row] { cursor: grab; }
        #home-product-list [data-menu-item-row]:active { cursor: grabbing; }
        .home-product-drag-handle { color: #65717d; font-size: 20px; line-height: 1; user-select: none; }
        [data-menu-item-row].is-dragging { opacity: .45; }
        [data-menu-item-row].drop-before td { border-top: 3px solid #007bff; }
        [data-menu-item-row].drop-after td { border-bottom: 3px solid #007bff; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const list = document.getElementById('home-product-list');
            const status = document.getElementById('home-product-order-status');
            if (!list || !status) return;
            let draggedRow = null;
            let originalOrder = [];
            const currentOrder = function () { return Array.from(list.querySelectorAll('[data-menu-item-row]')).map(function (row) { return Number(row.dataset.id); }); };
            const updateNumbers = function () { list.querySelectorAll('[data-menu-item-row]').forEach(function (row, index) { const number = row.querySelector('td:first-child span.ml-2'); if (number) number.textContent = String(index + 1); }); };
            const clearMarks = function () { list.querySelectorAll('.drop-before, .drop-after').forEach(function (row) { row.classList.remove('drop-before', 'drop-after'); }); };

            list.addEventListener('dragstart', function (event) {
                const row = event.target.closest('[data-menu-item-row]');
                if (!row || event.target.closest('a, button, form, input, select, textarea')) { event.preventDefault(); return; }
                draggedRow = row; originalOrder = currentOrder(); row.classList.add('is-dragging');
                event.dataTransfer.effectAllowed = 'move'; event.dataTransfer.setData('text/plain', row.dataset.id);
                status.textContent = 'Release the row to save its new position.';
            });
            list.addEventListener('dragover', function (event) {
                if (!draggedRow) return;
                event.preventDefault();
                const target = event.target.closest('[data-menu-item-row]');
                if (!target || target === draggedRow) return;
                clearMarks();
                const bounds = target.getBoundingClientRect();
                const after = event.clientY > bounds.top + bounds.height / 2;
                target.classList.add(after ? 'drop-after' : 'drop-before');
                const reference = after ? target.nextElementSibling : target;
                if (reference !== draggedRow) list.insertBefore(draggedRow, reference);
            });
            list.addEventListener('drop', function (event) { if (draggedRow) event.preventDefault(); });
            list.addEventListener('dragend', function () {
                if (draggedRow) draggedRow.classList.remove('is-dragging');
                draggedRow = null; clearMarks(); updateNumbers();
                const order = currentOrder();
                if (order.length && order.some(function (id, index) { return id !== originalOrder[index]; })) saveOrder(order, originalOrder);
                else status.textContent = 'Drag rows to change their order.';
            });

            async function saveOrder(order, previousOrder) {
                status.textContent = 'Saving order...'; status.classList.remove('text-danger', 'text-success'); status.classList.add('text-muted');
                try {
                    const response = await fetch(list.dataset.reorderUrl, {
                        method: 'POST', credentials: 'same-origin',
                        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': list.dataset.csrfToken },
                        body: JSON.stringify({order: order}),
                    });
                    if (!response.ok) throw new Error('Could not save the Home Product order. Refresh and try again.');
                    status.textContent = 'Order saved.'; status.classList.remove('text-muted', 'text-danger'); status.classList.add('text-success');
                } catch (error) {
                    const rows = new Map(Array.from(list.querySelectorAll('[data-menu-item-row]')).map(function (row) { return [Number(row.dataset.id), row]; }));
                    previousOrder.forEach(function (id) { const row = rows.get(id); if (row) list.appendChild(row); });
                    updateNumbers(); status.textContent = error.message || 'Could not save the Home Product order.';
                    status.classList.remove('text-muted', 'text-success'); status.classList.add('text-danger');
                }
            }
        });
    </script>
@endpush
