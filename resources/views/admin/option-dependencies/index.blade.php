@extends('admin.layouts.app')

@section('title', 'Option Dependencies')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Option Dependencies</h1>
                <p class="text-muted mb-0">Control an Option or Option Group when a Trigger Option is selected.</p>
            </div>

            <a href="{{ route('admin.option-dependencies.create') }}" class="btn btn-primary">+ Add Option Dependency</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Dependency list</strong>
                <span class="text-muted small">{{ $dependencies->total() }} dependency(s)</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 70px;">No.</th>
                                <th>Trigger Option</th>
                                <th>Target Type</th>
                                <th>Target</th>
                                <th>Action</th>
                                <th>Active</th>
                                <th style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dependencies as $dependency)
                                @php
                                    $target = $dependency->target_type === 'group'
                                        ? $dependency->targetGroup
                                        : $dependency->targetOption;
                                @endphp
                                <tr>
                                    <td>{{ $dependencies->firstItem() + $loop->index }}</td>
                                    <td>
                                        {{ $dependency->triggerOption?->option_name ?? '-' }}
                                        <div class="small text-muted"><code>{{ $dependency->triggerOption?->optionGroup?->group_code }}</code> / <code>{{ $dependency->triggerOption?->option_code }}</code></div>
                                    </td>
                                    <td><span class="badge badge-{{ $dependency->target_type === 'group' ? 'info' : 'primary' }}">{{ $dependency->target_type === 'group' ? 'Group' : 'Option' }}</span></td>
                                    <td>
                                        {{ $dependency->target_type === 'group' ? $target?->group_name : $target?->option_name }}
                                        <div class="small text-muted"><code>{{ $dependency->target_type === 'group' ? $target?->group_code : $target?->option_code }}</code></div>
                                    </td>
                                    <td><span class="badge badge-secondary text-uppercase">{{ $dependency->action_type }}</span></td>
                                    <td><span class="badge badge-{{ $dependency->is_active ? 'success' : 'secondary' }}">{{ $dependency->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    <td><a href="{{ route('admin.option-dependencies.edit', $dependency) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">No Option Dependencies created yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($dependencies->hasPages())
            <div class="mt-3">{{ $dependencies->links() }}</div>
        @endif
    </div>
@endsection
