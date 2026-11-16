@extends('admin.layouts.app')

@section('title', 'Option Groups')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Option Groups</h1>
                <p class="text-muted mb-0">Shared option-group definitions. They are not linked to products yet.</p>
            </div>

            <a href="{{ route('admin.option-groups.create') }}" class="btn btn-primary">+ Add Option Group</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @php($hasFilters = $filters['q'] !== '' || $filters['display_type'] !== '' || $filters['status'] !== '')

        <form method="GET" action="{{ route('admin.option-groups.index') }}" class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="form-row align-items-end">
                    <div class="col-md-5 mb-2 mb-md-0">
                        <label for="filter-q" class="small text-muted mb-1">Search</label>
                        <input type="search" id="filter-q" name="q" value="{{ $filters['q'] }}" class="form-control" placeholder="Group code or group name">
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label for="filter-display-type" class="small text-muted mb-1">Display Type</label>
                        <select id="filter-display-type" name="display_type" class="form-control">
                            <option value="">All</option>
                            @foreach ($displayTypes as $value => $label)
                                <option value="{{ $value }}" @selected($filters['display_type'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-2 mb-md-0">
                        <label for="filter-status" class="small text-muted mb-1">Active</label>
                        <select id="filter-status" name="status" class="form-control">
                            <option value="">All</option>
                            <option value="active" @selected($filters['status'] === 'active')>Active</option>
                            <option value="inactive" @selected($filters['status'] === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex">
                        <button type="submit" class="btn btn-primary flex-fill mr-2">Search</button>
                        @if ($hasFilters)
                            <a href="{{ route('admin.option-groups.index') }}" class="btn btn-outline-secondary">Clear</a>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Group list</strong>
                <span class="text-muted small">{{ $optionGroups->total() }} group(s)</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 70px;">No.</th>
                                <th>Group Code</th>
                                <th>Group Name</th>
                                <th>Display Type</th>
                                <th>Main Price</th>
                                <th>Required</th>
                                <th>Order Summary</th>
                                <th>Active</th>
                                {{-- <th>Help Text</th> --}}
                                <th style="width: 110px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($optionGroups as $optionGroup)
                                <tr>
                                    <td>{{ $optionGroups->firstItem() + $loop->index }}</td>
                                    <td><code>{{ $optionGroup->group_code }}</code></td>
                                    <td>{{ $optionGroup->group_name }}</td>
                                    <td>
                                        <span class="badge badge-{{ in_array($optionGroup->display_type, ['image_card', 'image_grid', 'paper_preview'], true) ? 'info' : ($optionGroup->display_type === 'previous_order' ? 'warning' : ($optionGroup->display_type === 'radio_list' ? 'success' : ($optionGroup->display_type === 'button_group' ? 'secondary' : ($optionGroup->display_type === 'switch' ? 'dark' : ($optionGroup->display_type === 'quantity_input' ? 'danger' : 'primary'))))) }}">
                                            {{ match ($optionGroup->display_type) {
                                                'button_group' => 'Button group',
                                                'image_card' => 'Image card',
                                                'image_grid' => 'Image grid',
                                                'paper_preview' => 'Paper preview',
                                                'previous_order' => 'Previous order',
                                                'radio_list' => 'Radio list',
                                                'switch' => 'Switch',
                                                'quantity_input' => 'Quantity input',
                                                default => 'Button',
                                            } }}
                                        </span>
                                    </td>
                                    <td><span class="badge badge-{{ $optionGroup->is_main_price_group ? 'primary' : 'secondary' }}">{{ $optionGroup->is_main_price_group ? 'Yes' : 'No' }}</span></td>
                                    <td><span class="badge badge-{{ $optionGroup->is_required ? 'warning' : 'secondary' }}">{{ $optionGroup->is_required ? 'Yes' : 'No' }}</span></td>
                                    <td><span class="badge badge-{{ $optionGroup->show_in_order_summary ? 'info' : 'secondary' }}">{{ $optionGroup->show_in_order_summary ? 'Show' : 'Hide' }}</span></td>
                                    <td><span class="badge badge-{{ $optionGroup->is_active ? 'success' : 'secondary' }}">{{ $optionGroup->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    {{-- <td>{!! nl2br(e($optionGroup->help_text ?: '-')) !!}</td> --}}
                                    <td><a href="{{ route('admin.option-groups.edit', $optionGroup) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="text-center text-muted py-4">{{ $hasFilters ? 'No groups match your search.' : 'No Option Groups created yet.' }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($optionGroups->hasPages())
            <div class="mt-3">{{ $optionGroups->links('pagination::bootstrap-4') }}</div>
        @endif
    </div>
@endsection
