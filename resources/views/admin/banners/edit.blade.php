@extends('admin.layouts.app')

@section('title', 'Banner Settings')

@section('content')
    <div class="container-fluid">
        <div class="mb-3">
            <h1 class="h3 mb-1">Banner Settings</h1>
            <p class="text-muted mb-0">Configure the images displayed in the website header.</p>
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

        @php
            $bannerSections = [
                'header' => [
                    'model' => $headerBanner,
                    'title' => 'Header Banner',
                    'description' => 'Main banner shown on the left side of the website header.',
                    'default_image' => asset('img/banner_hm_20250211.webp'),
                    'default_alt' => 'Default header banner',
                    'recommended' => 'Recommended size: 706 × 143 px.',
                    'alt_placeholder' => 'Hotmobily header banner',
                    'link_placeholder' => 'https://hotmobily.jp/',
                    'link_help' => 'Leave blank to keep the default link to the website home page.',
                ],
                'contact' => [
                    'model' => $contactBanner,
                    'title' => 'Contact Banner',
                    'description' => 'Contact and telephone banner shown on the right side of the website header.',
                    'default_image' => asset('img/contact-2025.webp'),
                    'default_alt' => 'Default contact banner',
                    'recommended' => 'Recommended size: 311 × 143 px.',
                    'alt_placeholder' => 'Contact Hotmobily',
                    'link_placeholder' => 'tel:05068655591',
                    'link_help' => 'Leave blank to keep the default telephone link.',
                ],
            ];
        @endphp

        @foreach ($bannerSections as $slot => $settings)
            @php
                $banner = $settings['model'];
            @endphp

            <div class="card shadow-sm mb-4" style="max-width: 980px;">
                <div class="card-header">
                    <strong>{{ $settings['title'] }}</strong>
                </div>

                <div class="card-body">
                    <p class="text-muted">{{ $settings['description'] }}</p>

                    <form
                        method="POST"
                        action="{{ route('admin.banner.update') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="slot" value="{{ $slot }}">

                        <div class="form-group">
                            <label for="{{ $slot }}-image">Banner image</label>
                            <input
                                id="{{ $slot }}-image"
                                type="file"
                                name="image"
                                class="form-control-file"
                                accept="image/jpeg,image/png,image/gif,image/webp,image/avif"
                            >
                            <small class="form-text text-muted">
                                {{ $settings['recommended'] }} JPG, PNG, GIF, WebP, and AVIF are supported (max 10 MB).
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Current image</label>
                            <div class="border rounded bg-light p-2">
                                @if ($banner->image_url)
                                    <img
                                        src="{{ $banner->image_url }}"
                                        alt="{{ $banner->alt_text ?: $settings['default_alt'] }}"
                                        class="img-fluid"
                                        style="max-height: 180px;"
                                    >
                                @else
                                    <img
                                        src="{{ $settings['default_image'] }}"
                                        alt="{{ $settings['default_alt'] }}"
                                        class="img-fluid"
                                        style="max-height: 180px;"
                                    >
                                    <div class="small text-muted mt-2">The default website image is currently being used.</div>
                                @endif
                            </div>
                        </div>

                        @if ($banner->image_path)
                            <div class="form-group form-check">
                                <input type="hidden" name="remove_image" value="0">
                                <input
                                    id="{{ $slot }}-remove-image"
                                    type="checkbox"
                                    name="remove_image"
                                    value="1"
                                    class="form-check-input"
                                >
                                <label for="{{ $slot }}-remove-image" class="form-check-label">Remove the custom image and use the default image.</label>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="{{ $slot }}-alt-text">Alt text</label>
                            <input
                                id="{{ $slot }}-alt-text"
                                type="text"
                                name="alt_text"
                                class="form-control"
                                maxlength="255"
                                value="{{ old('alt_text', $banner->alt_text) }}"
                                placeholder="{{ $settings['alt_placeholder'] }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="{{ $slot }}-link-url">Banner link (optional)</label>
                            <input
                                id="{{ $slot }}-link-url"
                                type="text"
                                name="link_url"
                                class="form-control"
                                maxlength="2000"
                                value="{{ old('link_url', $banner->link_url) }}"
                                placeholder="{{ $settings['link_placeholder'] }}"
                            >
                            <small class="form-text text-muted">{{ $settings['link_help'] }}</small>
                        </div>

                        <div class="form-group form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input
                                id="{{ $slot }}-is-active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="form-check-input"
                                @checked(old('is_active', $banner->exists ? $banner->is_active : true))
                            >
                            <label for="{{ $slot }}-is-active" class="form-check-label">Use this banner on the website.</label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save {{ $settings['title'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
