@extends('admin.layouts.app')

@section('title', 'Home Setting - Home Notification')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">Home Setting - Home Notification</h1>
                <p class="text-muted mb-0">Edit the collapsible notice displayed near the top of the homepage.</p>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.home-settings.notification.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="home-notification-title">Heading <span class="text-danger">*</span></label>
                        <input id="home-notification-title" name="title" type="text" class="form-control" maxlength="100" required value="{{ old('title', $notification->title) }}">
                    </div>

                    <div class="form-group">
                        <label for="home-notification-message">Message</label>
                        <textarea id="home-notification-message" name="message" class="form-control" rows="7">{{ old('message', $notification->message) }}</textarea>
                        <small class="form-text text-muted">Formatting and links are supported. The notice is hidden when the message is empty.</small>
                    </div>

                    <div class="form-check mb-4">
                        <input type="hidden" name="is_active" value="0">
                        <input id="home-notification-active" name="is_active" value="1" type="checkbox" class="form-check-input" @checked((bool) old('is_active', $notification->is_active))>
                        <label for="home-notification-active" class="form-check-label">Show this notification on the homepage</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Save notification</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('home-notification-message');
            if (!textarea || typeof ClassicEditor === 'undefined') return;

            ClassicEditor.create(textarea, {
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', '|',
                    'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo'
                ]
            }).then(function (editor) {
                const form = textarea.closest('form');
                if (form) form.addEventListener('submit', function () { textarea.value = editor.getData(); });
            }).catch(function (error) {
                console.error('Home Notification CKEditor error:', error);
            });
        });
    </script>
@endpush
