@extends('admin.layouts.app')

@section('title', 'User Manual Menu Setting')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">User Manual Menu Setting</h1>
                <p class="text-muted mb-0">The fixed ご利用ガイド link to /guide/ stays first. Add Custom Pages below it and drag to reorder.</p>
            </div>
            <a href="{{ route('admin.user-manual-menu.create') }}" class="btn btn-primary mt-2 mt-md-0">+ Add menu item</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                <strong>User Manual links (after ご利用ガイド)</strong>
                <span id="user-manual-menu-order-status" class="small text-muted" role="status" aria-live="polite">Drag rows to change their order.</span>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:76px">Order</th>
                            <th>Menu title</th>
                            <th>Custom Page</th>
                            <th style="width:240px">Actions</th>
                        </tr>
                    </thead>
                    <tbody
                        id="user-manual-menu-list"
                        data-reorder-url="{{ route('admin.user-manual-menu.reorder') }}"
                        data-csrf-token="{{ csrf_token() }}"
                    >
                        @forelse ($items as $item)
                            @php($page = $item->customPage)
                            <tr data-menu-item-row data-id="{{ $item->id }}" draggable="true" title="Drag this row to reorder">
                                <td class="text-nowrap">
                                    <span class="user-manual-menu-drag-handle" aria-hidden="true">⠿</span>
                                    <span class="ml-2">{{ $loop->iteration }}</span>
                                </td>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td>
                                    @if ($page)
                                        <div>{{ $page->name }}</div>
                                        <div class="small text-muted">
                                            <code>/{{ trim($page->slug, '/') }}</code>
                                            <span class="badge badge-{{ $page->status === 'active' ? 'success' : 'secondary' }}">{{ $page->status }}</span>
                                        </div>
                                    @else
                                        <span class="text-danger">Linked Custom Page no longer exists</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.user-manual-menu.edit', $item) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.user-manual-menu.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Remove this User Manual menu item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr data-empty-row>
                                <td colspan="4" class="text-center text-muted py-5">
                                    No Custom Pages added yet. The fixed ご利用ガイド link will remain in the storefront menu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #user-manual-menu-list [data-menu-item-row] { cursor: grab; }
        #user-manual-menu-list [data-menu-item-row]:active { cursor: grabbing; }
        .user-manual-menu-drag-handle { color: #65717d; font-size: 20px; line-height: 1; user-select: none; }
        [data-menu-item-row].is-dragging { opacity: .45; }
        [data-menu-item-row].drop-before td { border-top: 3px solid #007bff; }
        [data-menu-item-row].drop-after td { border-bottom: 3px solid #007bff; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const list = document.getElementById('user-manual-menu-list');
            const status = document.getElementById('user-manual-menu-order-status');
            if (!list || !status) return;

            let draggedRow = null;
            let originalOrder = [];

            function currentOrder() {
                return Array.from(list.querySelectorAll('[data-menu-item-row]'))
                    .map(function (row) { return Number(row.dataset.id); });
            }

            function updateRowNumbers() {
                list.querySelectorAll('[data-menu-item-row]').forEach(function (row, index) {
                    const number = row.querySelector('td:first-child span.ml-2');
                    if (number) number.textContent = String(index + 1);
                });
            }

            function clearDropMarks() {
                list.querySelectorAll('.drop-before, .drop-after').forEach(function (row) {
                    row.classList.remove('drop-before', 'drop-after');
                });
            }

            list.addEventListener('dragstart', function (event) {
                const row = event.target.closest('[data-menu-item-row]');
                if (!row || event.target.closest('a, button, form, input, select, textarea')) {
                    event.preventDefault();
                    return;
                }

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

                const target = event.target.closest('[data-menu-item-row]');
                if (!target || target === draggedRow) return;

                clearDropMarks();
                const bounds = target.getBoundingClientRect();
                const insertAfter = event.clientY > bounds.top + bounds.height / 2;
                target.classList.add(insertAfter ? 'drop-after' : 'drop-before');
                const reference = insertAfter ? target.nextElementSibling : target;
                if (reference !== draggedRow) list.insertBefore(draggedRow, reference);
            });

            list.addEventListener('drop', function (event) {
                if (draggedRow) event.preventDefault();
            });

            list.addEventListener('dragend', function () {
                if (draggedRow) draggedRow.classList.remove('is-dragging');
                draggedRow = null;
                clearDropMarks();
                updateRowNumbers();

                const order = currentOrder();
                if (order.length && order.some(function (id, index) { return id !== originalOrder[index]; })) {
                    saveOrder(order, originalOrder);
                } else {
                    status.textContent = 'Drag rows to change their order.';
                }
            });

            async function saveOrder(order, previousOrder) {
                if (order.length === 0) return;
                status.textContent = 'Saving order...';
                status.classList.remove('text-danger', 'text-success');
                status.classList.add('text-muted');

                try {
                    const response = await fetch(list.dataset.reorderUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': list.dataset.csrfToken,
                        },
                        body: JSON.stringify({order: order}),
                    });

                    if (!response.ok) throw new Error('Could not save the User Manual menu order. Refresh and try again.');
                    status.textContent = 'Order saved.';
                    status.classList.remove('text-muted', 'text-danger');
                    status.classList.add('text-success');
                } catch (error) {
                    const rowsById = new Map(Array.from(list.querySelectorAll('[data-menu-item-row]')).map(function (row) {
                        return [Number(row.dataset.id), row];
                    }));
                    previousOrder.forEach(function (id) {
                        const row = rowsById.get(id);
                        if (row) list.appendChild(row);
                    });
                    updateRowNumbers();
                    status.textContent = error.message || 'Could not save the User Manual menu order.';
                    status.classList.remove('text-muted', 'text-success');
                    status.classList.add('text-danger');
                }
            }
        });
    </script>
@endpush
