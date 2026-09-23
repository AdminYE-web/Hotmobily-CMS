@extends('admin.layouts.app')

@section('title', 'Template Downloads')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">Template Downloads</h1>
                <p class="text-muted mb-0">Manage products, blocks, size rows, and downloadable files shown on the public template page.</p>
            </div>
            <div class="d-flex">
                <form method="POST" action="{{ route('admin.template-products.import-legacy') }}" class="mr-2" onsubmit="return confirm('Import products that are not already in the manager?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Import original templates</button>
                </form>
                <a href="{{ route('admin.template-products.create') }}" class="btn btn-success">Add product</a>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>Product</th>
                                <th>Blocks</th>
                                <th>Rows</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($templateProducts as $product)
                                <tr draggable="true" data-product-id="{{ $product->id }}" class="template-product-row">
                                    <td class="template-product-order-cell">
                                        <span class="template-drag-handle" draggable="true" title="Drag to reorder">☷</span>
                                        <span class="template-product-order">{{ $loop->iteration }}</span>
                                    </td>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td>{{ $product->blocks_count }}</td>
                                    <td>{{ $product->rows_count }}</td>
                                    <td>
                                        <span class="badge badge-{{ $product->is_active ? 'success' : 'secondary' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('admin.template-products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="POST" action="{{ route('admin.template-products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Delete this product, all blocks, rows, and uploaded files?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        No managed templates yet. Import the original templates or add a product.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .template-product-row { cursor: grab; }
        .template-product-row.template-dragging { opacity: .45; }
        .template-drag-handle { cursor: grab; color: #6c757d; font-size: 1.2rem; margin-right: .4rem; }
        .template-product-order-cell { white-space: nowrap; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tbody = document.querySelector('.template-product-row')?.closest('tbody');
            if (!tbody) return;

            let draggedRow = null;

            tbody.addEventListener('dragstart', function (event) {
                const handle = event.target.closest('.template-drag-handle');
                if (!handle) {
                    event.preventDefault();
                    return;
                }

                draggedRow = handle.closest('.template-product-row');
                draggedRow.classList.add('template-dragging');
                event.dataTransfer.effectAllowed = 'move';
            });

            tbody.addEventListener('dragover', function (event) {
                if (!draggedRow) return;
                const targetRow = event.target.closest('.template-product-row');
                if (!targetRow || targetRow === draggedRow) return;

                event.preventDefault();
                const insertAfter = event.clientY > targetRow.getBoundingClientRect().top + targetRow.offsetHeight / 2;
                tbody.insertBefore(draggedRow, insertAfter ? targetRow.nextSibling : targetRow);
            });

            tbody.addEventListener('dragend', function () {
                if (!draggedRow) return;

                draggedRow.classList.remove('template-dragging');
                const rows = [...tbody.querySelectorAll('.template-product-row')];
                const order = rows.map(row => Number(row.dataset.productId));
                rows.forEach((row, index) => {
                    row.querySelector('.template-product-order').textContent = index + 1;
                });

                fetch('{{ route('admin.template-products.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ order }),
                }).then(function (response) {
                    if (!response.ok) throw new Error('Unable to save order');
                }).catch(function () {
                    alert('บันทึกลำดับไม่สำเร็จ กรุณาโหลดหน้าใหม่แล้วลองอีกครั้ง');
                    window.location.reload();
                }).finally(function () {
                    draggedRow = null;
                });
            });
        });
    </script>
@endpush
