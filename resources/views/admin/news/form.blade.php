@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit News' : 'News Create')

@section('content')
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header">{{ $isEditing ? 'News Edit' : 'News Create' }}</div>
            <div class="card-body">
                <form
                    method="POST"
                    action="{{ $isEditing ? route('admin.news.update', $newsItem) : route('admin.news.store') }}"
                >
                    @csrf
                    @if ($isEditing)
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="news-title">Title*</label>
                        <input
                            id="news-title"
                            class="form-control @error('title') is-invalid @enderror"
                            type="text"
                            name="title"
                            maxlength="255"
                            value="{{ old('title', $newsItem->title) }}"
                            required
                        >
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="news-contents">Contents*</label>
                        <textarea
                            id="news-contents"
                            class="form-control @error('contents') is-invalid @enderror"
                            name="contents"
                            rows="14"
                            required
                        >{{ old('contents', $newsItem->description) }}</textarea>
                        @error('contents') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="form-text text-muted">Rich text and image upload are available when the editor script loads. HTML can also be entered directly.</small>
                    </div>

                    <div class="form-group">
                        <label for="published-at">Published Date*</label>
                        <input
                            id="published-at"
                            class="form-control @error('published_at') is-invalid @enderror"
                            type="date"
                            name="published_at"
                            value="{{ old('published_at', $newsItem->published_at?->format('Y-m-d')) }}"
                        >
                        @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="news-category">Category*</label>
                        <select
                            id="news-category"
                            class="form-control @error('category') is-invalid @enderror"
                            name="category"
                            required
                        >
                            <option value="">-Choose-</option>
                            <option value="top" @selected(old('category', $newsItem->category) === 'top')>トップページ</option>
                            <option value="acrylic" @selected(old('category', $newsItem->category) === 'acrylic')>アクリルページ</option>
                        </select>
                        @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="news-status">Status*</label>
                        <select
                            id="news-status"
                            class="form-control @error('status') is-invalid @enderror"
                            name="status"
                            required
                        >
                            <option value="">-Choose-</option>
                            <option value="1" @selected((string) old('status', $newsItem->status) === '1')>-Active-</option>
                            <option value="2" @selected((string) old('status', $newsItem->status) === '2')>-In-Active-</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="meta-title">Meta Title*</label>
                        <input
                            id="meta-title"
                            class="form-control @error('meta_title') is-invalid @enderror"
                            type="text"
                            name="meta_title"
                            maxlength="255"
                            value="{{ old('meta_title', $newsItem->meta_title) }}"
                            required
                        >
                        @error('meta_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="meta-description">Meta Description*</label>
                        <textarea
                            id="meta-description"
                            class="form-control @error('meta_description') is-invalid @enderror"
                            name="meta_description"
                            rows="3"
                            maxlength="1000"
                            required
                        >{{ old('meta_description', $newsItem->meta_description) }}</textarea>
                        @error('meta_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="meta-keyword">Meta Keyword*</label>
                        <input
                            id="meta-keyword"
                            class="form-control @error('meta_keyword') is-invalid @enderror"
                            type="text"
                            name="meta_keyword"
                            maxlength="1000"
                            placeholder="keyword1, keyword2, keyword3, .."
                            value="{{ old('meta_keyword', $newsItem->meta_keyword) }}"
                            required
                        >
                        @error('meta_keyword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary mr-2">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        (function () {
            const textarea = document.getElementById('news-contents');
            if (!textarea || typeof ClassicEditor === 'undefined') return;

            class NewsUploadAdapter {
                constructor(loader) {
                    this.loader = loader;
                }

                upload() {
                    return this.loader.file.then(file => new Promise((resolve, reject) => {
                        const data = new FormData();
                        data.append('upload', file);

                        const xhr = this.xhr = new XMLHttpRequest();
                        xhr.open('POST', @json(route('admin.news.upload-image')), true);
                        xhr.responseType = 'json';
                        xhr.setRequestHeader('Accept', 'application/json');
                        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                        xhr.addEventListener('error', () => reject('Image upload failed.'));
                        xhr.addEventListener('abort', () => reject());
                        xhr.addEventListener('load', () => {
                            const response = xhr.response;
                            if (xhr.status >= 200 && xhr.status < 300 && response && response.url) {
                                resolve({ default: response.url });
                            } else {
                                reject(response?.message || 'Image upload failed.');
                            }
                        });
                        xhr.send(data);
                    }));
                }

                abort() {
                    this.xhr?.abort();
                }
            }

            function newsUploadPlugin(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = loader => new NewsUploadAdapter(loader);
            }

            ClassicEditor.create(textarea, {
                extraPlugins: [newsUploadPlugin],
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', '|',
                    'bulletedList', 'numberedList', 'blockQuote', '|',
                    'imageUpload', 'undo', 'redo'
                ]
            }).catch(error => console.error(error));
        })();
    </script>
@endpush
