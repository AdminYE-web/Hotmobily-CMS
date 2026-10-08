@extends('admin.layouts.app')

@section('title', 'News Management')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div>
                <h1 class="h3 mb-1">News Management</h1>
                <p class="text-muted mb-0">Manage the announcements shown on the website.</p>
            </div>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">+ Create</a>
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

        <div class="table-responsive">
            <table id="news-table" class="table table-bordered table-striped bg-white">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Date Create</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($newsItems as $newsItem)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $newsItem->title }}</td>
                            <td>
                                @if ((int) $newsItem->status === 1)
                                    <strong class="text-success">Active</strong>
                                @else
                                    <strong class="text-danger">In-Active</strong>
                                @endif
                            </td>
                            <td>{{ $newsItem->created_by }}</td>
                            <td>{{ $newsItem->created_at?->format('m/d/Y H:i') }}</td>
                            <td class="text-nowrap">
                                <a
                                    href="{{ route('admin.news.edit', $newsItem) }}"
                                    class="btn btn-warning btn-sm text-white"
                                >Edit</a>
                                <form
                                    method="POST"
                                    action="{{ route('admin.news.destroy', $newsItem) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            if ($.fn.DataTable) {
                $('#news-table').DataTable({
                    order: [],
                    pageLength: 25
                });
            }
        });
    </script>
@endpush
