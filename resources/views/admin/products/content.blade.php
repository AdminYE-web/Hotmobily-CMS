@extends('admin.layouts.app')

@section('title', 'Product Content')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <a href="{{ route('admin.products.index') }}">
                ← Products
            </a>

            <h1 class="h3 mt-2 mb-1">
                {{ $product->name }}
            </h1>

            <small class="text-muted">
                Product Content Editor
            </small>

        </div>


        <div class="d-flex align-items-center">

            <span
                id="save-status"
                class="text-muted mr-3"
            ></span>

            <button
                type="button"
                class="btn btn-secondary mr-2"
                id="save-draft"
            >
                Save Draft
            </button>

            <button
                type="button"
                class="btn btn-success"
                id="publish-product"
            >
                Publish
            </button>

        </div>

    </div>


    <div
        id="layout-info"
        class="alert alert-info d-none"
    ></div>


    <div
        id="loading"
        class="text-center py-5"
    >
        Loading...
    </div>


    <div
        id="content-editor"
        class="d-none"
    >

        <div class="card shadow-sm">

            <div class="card-header">

                <strong>
                    Product Page Content
                </strong>

            </div>


            <div class="card-body editor-canvas">

                <div id="layout-canvas"></div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

/* ============================================================
   Main
============================================================ */

.editor-canvas {
    background: #eef0f3;
}


/* ============================================================
   Layout
============================================================ */

.editor-row {
    display: flex;
    flex-wrap: wrap;

    margin: 0 -8px 20px;
}


.editor-column {
    flex: 0 0 var(--column-width);
    max-width: var(--column-width);

    padding: 0 8px;
}


.editor-column-inner {
    min-height: 80px;

    padding: 12px;

    background: #fff;

    border: 1px solid #ddd;
    border-radius: 5px;
}


/* ============================================================
   Content Block
============================================================ */

.content-block {
    margin-bottom: 15px;

    padding: 15px;

    background: #fff;

    border: 1px solid #ddd;
    border-radius: 5px;
}


.content-block:last-child {
    margin-bottom: 0;
}


.content-block-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 10px;

    margin-bottom: 15px;
    padding-bottom: 8px;

    border-bottom: 1px solid #eee;
}


.content-block-name {
    font-weight: 700;
}


.content-block-id {
    font-size: 10px;
}


.content-block-toggle {
    display: inline-flex;
    align-items: center;

    gap: 8px;

    min-width: 0;

    padding: 0;

    background: transparent;
    color: inherit;

    border: 0;

    text-align: left;

    cursor: pointer;
}


.content-block-toggle:focus {
    outline: 2px solid rgba(0, 123, 255, .35);
    outline-offset: 3px;
}


.content-block-toggle-icon {
    display: inline-block;

    width: 9px;
    height: 9px;

    flex: 0 0 auto;

    border-right: 2px solid #59636e;
    border-bottom: 2px solid #59636e;

    transform: rotate(45deg);

    transition: transform .2s ease;
}


.content-block.is-collapsed > .content-block-header {
    margin-bottom: 0;
    padding-bottom: 0;

    border-bottom-color: transparent;
}


.content-block.is-collapsed
> .content-block-header
.content-block-toggle-icon {
    transform: rotate(-45deg);
}


.content-block.is-collapsed > .content-block-body {
    display: none;
}


/* ============================================================
   Rich Text Editor
============================================================ */

.rich-text-editor {
    border: 1px solid #ced4da;
    border-radius: 4px;

    overflow: hidden;
}


.rich-text-toolbar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: 5px;

    padding: 7px;

    background: #f5f6f8;

    border-bottom: 1px solid #ced4da;
}


.rich-text-display-size-control {
    padding: 8px;

    background: #f5f6f8;

    border-bottom: 1px solid #ced4da;
}


.rich-text-display-size-control label {
    display: block;

    margin-bottom: 4px;
}


.rich-text-display-size-control select {
    max-width: 240px;
}


.rich-text-toolbar .btn {
    min-width: 32px;

    padding: 3px 8px;
}


.rich-text-toolbar select {
    width: 135px;
    height: 31px;

    padding: 2px 6px;
}


.rich-text-toolbar input[type="color"] {
    width: 38px;
    height: 31px;

    padding: 2px;
}


.rich-text-surface {
    min-height: 170px;
    max-height: 420px;

    overflow-y: auto;

    padding: 12px;

    background: #fff;

    line-height: 1.7;

    outline: 0;
}


.rich-text-surface:focus {
    box-shadow: inset 0 0 0 2px rgba(0, 123, 255, .15);
}


.rich-text-surface-small {
    font-size: 12px;
    line-height: 1.4;
}


/* ============================================================
   System
============================================================ */

.system-component {
    padding: 18px;

    border: 1px dashed #adb5bd;

    background: #f8f9fa;

    color: #6c757d;
}


/* ============================================================
   Accordion
============================================================ */

.accordion-editor {
    padding: 15px;

    background: #f8f9fa;

    border: 1px solid #d5d9dd;
    border-radius: 5px;
}


.accordion-children {
    padding: 10px;

    background: #eef0f3;

    border-radius: 5px;
}


/* ============================================================
   Gallery
============================================================ */

.gallery-list {
    display: flex;
    flex-direction: column;

    gap: 10px;
}


.gallery-image-row {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 10px;

    background: #f8f9fa;

    border: 1px solid #ddd;
    border-radius: 5px;
}


.gallery-image-preview {
    width: 90px;
    height: 90px;

    flex-shrink: 0;

    overflow: hidden;

    background: #eee;

    border: 1px solid #ddd;
    border-radius: 4px;
}


.gallery-image-preview img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;
}


.gallery-image-info {
    flex: 1;

    min-width: 0;
}


.gallery-image-name {
    font-weight: 600;

    word-break: break-all;
}


.gallery-image-url {
    color: #888;

    font-size: 11px;

    word-break: break-all;
}


.gallery-empty {
    margin-top: 10px;

    padding: 30px;

    text-align: center;

    color: #999;

    background: #fafafa;

    border: 2px dashed #ddd;
    border-radius: 5px;
}


.gallery-upload-status {
    font-size: 12px;
}


/* ============================================================
   Info Card Image
============================================================ */

.info-card-image-preview-wrapper {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 10px;

    background: #f8f9fa;

    border: 1px solid #ddd;
    border-radius: 5px;
}


.info-card-image-preview {
    width: 120px;
    height: 90px;

    flex-shrink: 0;

    overflow: hidden;

    background: #eee;

    border: 1px solid #ddd;
    border-radius: 5px;
}


.info-card-image-preview img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}


.info-card-image-detail {
    flex: 1;

    min-width: 0;
}


.info-card-image-name {
    font-weight: 600;

    word-break: break-all;
}


.info-card-image-url {
    color: #888;

    font-size: 11px;

    word-break: break-all;
}


.info-card-image-empty {
    padding: 30px;

    text-align: center;

    color: #999;

    background: #fafafa;

    border: 2px dashed #ddd;
    border-radius: 5px;
}


.info-card-image-status {
    font-size: 12px;
}


/* ============================================================
   Template Button
============================================================ */

.template-file-card {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 12px;

    background: #f8f9fa;

    border: 1px solid #ddd;
    border-radius: 5px;
}


.template-file-icon {
    flex-shrink: 0;

    font-size: 28px;
}


.template-file-detail {
    flex: 1;

    min-width: 0;
}


.template-file-name {
    font-weight: 600;

    word-break: break-all;
}


.template-file-url {
    color: #888;

    font-size: 11px;

    word-break: break-all;
}


.template-file-empty {
    padding: 24px;

    text-align: center;

    color: #999;

    background: #fafafa;

    border: 2px dashed #ddd;
    border-radius: 5px;
}


.template-file-status {
    font-size: 12px;
}


/* ============================================================
   Text Link
============================================================ */

.text-link-editor {
    padding: 15px;

    background: #f8f9fa;

    border: 1px solid #d8dde2;
    border-radius: 6px;
}


.text-link-preview {
    margin-top: 15px;

    padding: 15px;

    background: #fff;

    border: 1px solid #ddd;
    border-radius: 5px;
}


.text-link-preview a {
    color: #007bff;

    text-decoration: underline;

    cursor: pointer;
}

.text-link-preview a:hover {
    color: #0056b3;
    text-decoration: underline;
}


/* ============================================================
   Link URL Input with Block Picker & Jump
============================================================ */

.link-url-group {
    position: relative;
}


.link-url-group .form-text {
    margin-top: 4px;

    font-size: 11px;
    color: #6c757d;
}


.link-url-block-picker {
    display: flex;
    align-items: center;
    gap: 6px;

    margin-top: 6px;
}


.link-url-block-picker select {
    flex: 1;

    font-size: 12px;

    padding: 4px 8px;

    border: 1px solid #ced4da;
    border-radius: 4px;

    background: #fff;

    color: #495057;

    min-width: 0;
}


.link-url-block-picker .btn-sm {
    font-size: 11px;
    padding: 4px 10px;
    white-space: nowrap;
}


@keyframes blockHighlightPulse {
    0% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
        outline: 2px solid #007bff;
    }
    50% {
        box-shadow: 0 0 0 10px rgba(0, 123, 255, 0.25);
        outline: 2px solid #007bff;
        background-color: #f0f7ff;
    }
    100% {
        box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
        outline: 2px solid transparent;
        background-color: transparent;
    }
}


.content-block-highlighted {
    animation: blockHighlightPulse 1.2s ease-in-out 2 !important;
    border-color: #007bff !important;
}


/* ============================================================
   Flexible Table V2
============================================================ */

.flex-table-editor {
    padding: 15px;

    background: #f8f9fa;

    border: 1px solid #d8dde2;
    border-radius: 6px;
}


.flex-table-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 10px;

    margin-bottom: 15px;
}


.flex-table-topbar-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: 6px;
}


.flex-table-row-count-control {
    display: inline-flex;
    align-items: center;

    gap: 5px;
}


.flex-table-row-count-control label {
    margin: 0;

    color: #555;

    font-size: 11px;
}


.flex-table-row-count-input {
    width: 68px;
    height: 31px;

    padding: 3px 7px;

    font-size: 12px;
}


.flex-table-row-editor {
    margin-bottom: 15px;

    padding: 12px;

    background: #fff;

    border: 1px solid #ccd2d8;
    border-radius: 6px;
}


.flex-table-row-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 10px;

    margin-bottom: 12px;
    padding-bottom: 8px;

    border-bottom: 1px solid #eee;
}


.flex-table-row-actions {
    display: flex;
    flex-wrap: wrap;

    gap: 4px;
}


.flex-table-row-actions .btn {
    padding: 2px 7px;

    font-size: 11px;
}


.flex-table-cell-count-control {
    display: inline-flex;
    align-items: center;

    gap: 5px;

    margin-right: 3px;
}


.flex-table-cell-count-control label {
    margin: 0;

    color: #555;

    font-size: 11px;
}


.flex-table-cell-count-input {
    width: 62px;
    height: 27px;

    padding: 2px 6px;

    font-size: 12px;
}


.flex-table-cell-editor {
    margin-bottom: 10px;

    padding: 12px;

    background: #f8f9fa;

    border: 1px solid #ddd;
    border-radius: 5px;
}


.flex-table-cell-editor:last-child {
    margin-bottom: 0;
}


.flex-table-cell-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 10px;

    margin-bottom: 10px;
}


.flex-table-cell-actions {
    display: flex;
    flex-wrap: wrap;

    gap: 4px;
}


.flex-table-cell-actions .btn {
    padding: 2px 7px;

    font-size: 11px;
}


.flex-table-width-ok {
    margin-left: 8px;

    color: #198754;

    font-size: 11px;
    font-weight: 600;
}


.flex-table-width-error {
    margin-left: 8px;

    color: #dc3545;

    font-size: 11px;
    font-weight: 600;
}


.flex-table-row-detail {
    margin-top: 3px;

    color: #777;

    font-size: 10px;
}


.flex-table-row-height {
    display: flex;
    align-items: center;

    gap: 6px;

    margin-top: 7px;
}


.flex-table-row-height label {
    margin: 0;

    color: #555;

    font-size: 11px;
}


.flex-table-row-height input {
    width: 90px;
    height: 30px;

    padding: 3px 7px;
}


.flex-table-row-background {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: 7px;

    margin-top: 7px;
}


.flex-table-row-background label {
    margin: 0;

    color: #555;

    font-size: 11px;
}


.flex-table-row-background input[type="color"] {
    width: 50px;
    height: 30px;

    padding: 2px;
}


.flex-table-empty-row {
    padding: 15px;

    text-align: center;

    color: #888;

    border: 1px dashed #ccc;
    border-radius: 5px;
}


.flex-table-color-control {
    display: flex;
    align-items: center;

    gap: 7px;
}


.flex-table-color-control input[type="color"] {
    width: 50px;
    height: 38px;

    padding: 2px;
}


.flex-table-help {
    margin-top: 10px;

    font-size: 11px;

    color: #777;
}


/* ============================================================
   Flexible Table Preview
============================================================ */

.flex-table-preview {
    margin-top: 20px;

    padding: 15px;

    overflow-x: auto;

    background: #fff;

    border: 1px solid #ddd;
    border-radius: 6px;
}


.flex-table-preview-title {
    margin-bottom: 10px;

    font-size: 16px;
    font-weight: 700;
}


.flex-table-grid {
    display: grid;

    /*
     * 200 Grid Units
     *
     * 1 unit = 0.5%
     */
    grid-template-columns:
        repeat(
            200,
            minmax(0, 1fr)
        );

    grid-auto-rows: auto;

    width: 100%;
    min-width: 650px;

    border-top: 1px solid #ccc;
    border-left: 1px solid #ccc;
}


.flex-table-preview-cell {
    box-sizing: border-box;

    display: flex;

    min-width: 0;

    border-right: 1px solid #ccc;
    border-bottom: 1px solid #ccc;

    overflow-wrap: anywhere;
    white-space: pre-line;
}


.flex-table-preview-cell-inner {
    width: 100%;
}


.flex-table-preview-error {
    margin-bottom: 10px;
}


/* ============================================================
   Shipping Days
============================================================ */

.shipping-days-group .input-group {
    max-width: 360px;
}


.shipping-date-preview .alert {
    border-left: 4px solid #17a2b8;
}


.shipping-preview-date {
    font-size: 16px;
}


.shipping-preview-detail {
    margin-top: 6px;

    font-size: 12px;
}


.shipping-preview-skipped {
    margin-top: 8px;
    padding-top: 8px;

    border-top: 1px solid rgba(0, 0, 0, .08);

    font-size: 11px;
}


.shipping-preview-skipped-item {
    display: inline-block;

    margin: 2px 4px 2px 0;
    padding: 2px 6px;

    border-radius: 10px;

    background: rgba(0, 0, 0, .06);
}


/* ============================================================
   Shipping Schedule
============================================================ */

.shipping-schedule-editor {
    padding: 15px;

    background: #f8f9fa;

    border: 1px solid #d8dde2;
    border-radius: 6px;
}


.shipping-schedule-main {
    padding-bottom: 15px;
    margin-bottom: 15px;

    border-bottom: 1px solid #ddd;
}


.shipping-schedule-items-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-bottom: 12px;
}


.shipping-schedule-item {
    margin-bottom: 12px;

    padding: 14px;

    background: #fff;

    border: 1px solid #d7dce1;
    border-radius: 6px;
}


.shipping-schedule-item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-bottom: 12px;
    padding-bottom: 8px;

    border-bottom: 1px solid #eee;
}


.shipping-schedule-item-actions {
    display: flex;

    gap: 4px;
}


.shipping-schedule-item-actions .btn {
    padding: 2px 7px;

    font-size: 11px;
}


.schedule-live-preview {
    margin-top: 18px;

    padding: 15px;

    background: #fff;

    border: 1px solid #d7dce1;
    border-radius: 6px;
}


.schedule-live-preview-title {
    margin-bottom: 14px;

    color: #ef7a00;

    font-size: 18px;
    font-weight: 600;
}


.schedule-label-row {
    display: flex;
    align-items: center;

    gap: 10px;

    margin-bottom: 6px;
}


.schedule-label-badge {
    min-width: 215px;

    padding: 8px 15px;

    text-align: center;

    font-weight: 700;

    border-radius: 7px;
}


.schedule-theme-blue {
    background: #a8dbef;
}


.schedule-theme-pink {
    background: #ed7cf0;
}


.schedule-theme-cyan {
    background: #75e8e9;
}


.schedule-theme-orange {
    background: #ffc778;
}


.schedule-theme-gray {
    background: #dedede;
}


.schedule-days-label {
    color: #1472bb;

    font-size: 18px;
    font-weight: 700;
}


.schedule-result-table {
    width: 100%;

    margin-top: 14px;

    border-collapse: collapse;

    text-align: center;
}


.schedule-result-table th,
.schedule-result-table td {
    padding: 7px 10px;

    border: 1px solid #333;
}


.schedule-result-start {
    background: #b5dcf8;
}


.schedule-result-end {
    background: #f9c8ca;
}


.schedule-result-date {
    font-size: 20px;

    font-weight: 700;
}


.schedule-stacked-item {
    margin-bottom: 25px;
}


.schedule-footer-note {
    margin-top: 10px;

    white-space: pre-line;

    font-size: 13px;
}


/* ============================================================
   Responsive
============================================================ */

@media (max-width: 767px) {

    .editor-column {
        flex: 0 0 100% !important;
        max-width: 100% !important;

        margin-bottom: 15px;
    }


    .gallery-image-row,
    .info-card-image-preview-wrapper {
        align-items: flex-start;
    }


    .schedule-label-row {
        align-items: flex-start;
        flex-direction: column;
    }


    .schedule-label-badge {
        min-width: 100%;
    }


    .flex-table-topbar,
    .flex-table-row-header,
    .flex-table-cell-header {
        align-items: flex-start;
        flex-direction: column;
    }

}


/* ============================================================
   OptionCardGrid Dynamic Editor
============================================================ */

.option-card-grid-container {
    width: 100%;
}

.option-grid-nav-wrapper {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
}

.option-grid-tab-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.btn-xs {
    padding: 0.15rem 0.45rem;
    font-size: 0.75rem;
    line-height: 1.2;
    border-radius: 0.2rem;
}

.bg-warning-light {
    background-color: #fffdf5;
    border-bottom: 1px solid #ffeeba;
}

.option-part-item-card {
    transition: all 0.2s ease;
}

.option-part-item-card:hover {
    border-color: #cbd5e1 !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
}

.option-card-item-card {
    transition: all 0.2s ease;
}

.option-card-item-card:hover {
    border-color: #cbd5e1 !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
}

</style>

@endpush


@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | Config
        |--------------------------------------------------------------------------
        |
        | Custom Table ใช้ 200 grid units
        |
        | 200 units = 100%
        | 1 unit    = 0.5%
        |
        */

        const FLEX_TABLE_TOTAL_UNITS =
            200;


        const productId =
            {{ $product->id }};


        const csrf =
            document
                .querySelector(
                    'meta[name="csrf-token"]'
                )
                ?.getAttribute(
                    'content'
                );


        let layout =
            null;


        let contents =
            {};


        const collapsedContentBlockIds =
            new Set();


        let shippingHolidays =
            new Map();


        let shippingHolidayLoadPromise =
            null;


        /*
        |--------------------------------------------------------------------------
        | Load Editor
        |--------------------------------------------------------------------------
        */

        async function loadEditor()
        {
            try {

                const response =
                    await fetch(
                        `/api/v1/admin/products/${productId}/page`,
                        {
                            credentials:
                                'same-origin',

                            headers: {
                                'Accept':
                                    'application/json',
                            },
                        }
                    );


                const result =
                    await response.json();


                if (
                    !response.ok
                ) {

                    throw result;

                }


                layout =
                    result
                        .data
                        .product_layout
                        .layout;


                contents =
                    result
                        .data
                        .content
                        ?.blocks
                    ?? {};


                collapseAllContentBlocks(
                    layout
                );


                const info =
                    document.getElementById(
                        'layout-info'
                    );


                info.innerHTML = `

                    Layout:

                    <strong>

                        ${escapeHtml(
                            result
                                .data
                                .product_layout
                                .name
                        )}

                    </strong>

                    &nbsp;

                    <span
                        class="
                            badge
                            ${
                                result
                                    .data
                                    .product_layout
                                    .status
                                === 'published'

                                ? 'badge-success'

                                : 'badge-warning'
                            }
                        "
                    >

                        ${escapeHtml(
                            result
                                .data
                                .product_layout
                                .status
                        )}

                    </span>

                `;


                info.classList.remove(
                    'd-none'
                );


                renderLayout();


                document
                    .getElementById(
                        'loading'
                    )
                    .classList
                    .add(
                        'd-none'
                    );


                document
                    .getElementById(
                        'content-editor'
                    )
                    .classList
                    .remove(
                        'd-none'
                    );

            } catch (error) {

                console.error(
                    error
                );


                document
                    .getElementById(
                        'loading'
                    )
                    .innerHTML = `

                        <div class="alert alert-danger">

                            ${escapeHtml(
                                formatError(
                                    error
                                )
                            )}

                        </div>

                    `;

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Render Layout
        |--------------------------------------------------------------------------
        */

        function collapseAllContentBlocks(
            layoutData
        )
        {
            collapsedContentBlockIds.clear();


            const addBlocks =
                function (blocks) {

                    (
                        Array.isArray(
                            blocks
                        )
                            ? blocks
                            : []
                    )
                    .forEach(
                        function (block) {

                            if (
                                !block
                                ||
                                typeof block
                                !== 'object'
                            ) {

                                return;

                            }


                            if (
                                block.id
                                !== undefined
                                &&
                                block.id
                                !== null
                            ) {

                                collapsedContentBlockIds.add(
                                    String(
                                        block.id
                                    )
                                );

                            }


                            addBlocks(
                                block.children
                            );

                        }
                    );

                };


            (
                layoutData?.rows
                ?? []
            )
            .forEach(
                function (row) {

                    (
                        row?.columns
                        ?? []
                    )
                    .forEach(
                        function (column) {

                            addBlocks(
                                column?.blocks
                            );

                        }
                    );

                }
            );
        }

        function renderLayout()
        {
            const canvas =
                document.getElementById(
                    'layout-canvas'
                );


            canvas.innerHTML =
                '';


            (
                layout?.rows
                ?? []
            )
            .forEach(
                function (row) {

                    const rowElement =
                        document.createElement(
                            'div'
                        );


                    rowElement.className =
                        'editor-row';


                    (
                        row.columns
                        ?? []
                    )
                    .forEach(
                        function (column) {

                            const columnElement =
                                document.createElement(
                                    'div'
                                );


                            columnElement.className =
                                'editor-column';


                            const width =
                                (
                                    Number(
                                        column.width
                                    )
                                    /
                                    12
                                    *
                                    100
                                );


                            columnElement
                                .style
                                .setProperty(
                                    '--column-width',
                                    width + '%'
                                );


                            columnElement.innerHTML = `

                                <div class="editor-column-inner">

                                    ${(
                                        column.blocks
                                        ?? []
                                    )
                                    .map(
                                        renderBlockEditor
                                    )
                                    .join('')}

                                </div>

                            `;


                            rowElement.appendChild(
                                columnElement
                            );

                        }
                    );


                    canvas.appendChild(
                        rowElement
                    );

                }
            );


            bindGalleryButtons();

            bindInfoCardImageUploaders();

            bindTemplateFileUploaders();

            bindTextLinkEditors();

            bindLinkUrlPickers();

            bindFlexibleTableEditors();

            bindShippingDays();

            bindShippingScheduleEditors();

            bindOptionCardGridEditors();

            bindSingleImageUploaders();

            bindRichTextEditors();

            bindContentBlockAccordions();
        }


        /*
        |--------------------------------------------------------------------------
        | Render Block
        |--------------------------------------------------------------------------
        */

        function renderBlockEditor(
            block
        )
        {
            const blockContent =
                contents[
                    block.id
                ]
                ?? {};


            let fields =
                '';


            const isCollapsed =
                collapsedContentBlockIds.has(
                    String(
                        block.id
                    )
                );


            switch (
                block.type
            ) {

                case 'product_header':

                    fields = `

                        ${textInput(
                            block.id,
                            'title',
                            'Product Title',
                            blockContent.title
                            ?? ''
                        )}


                        ${textInput(
                            block.id,
                            'updated_date',
                            'Updated Date',
                            blockContent.updated_date
                            ?? ''
                        )}


                        <div class="form-check">

                            <input
                                type="checkbox"
                                class="
                                    form-check-input
                                    product-field
                                "
                                data-block-id="${block.id}"
                                data-field="show_share"
                                ${
                                    blockContent.show_share
                                    ? 'checked'
                                    : ''
                                }
                            >

                            <label class="form-check-label">
                                Show Share Buttons
                            </label>

                        </div>

                    `;

                    break;


                case 'product_gallery':

                    fields =
                        galleryEditor(
                            block,
                            blockContent
                        );

                    break;


                case 'product_details':

                    fields = `

                        ${textInput(
                            block.id,
                            'reference_price',
                            'Reference Price',
                            blockContent.reference_price
                            ?? ''
                        )}


                        ${textInput(
                            block.id,
                            'total_price',
                            'Total Price',
                            blockContent.total_price
                            ?? ''
                        )}


                        ${shippingDaysInput(
                            block.id,
                            blockContent.shipping_days
                            ?? ''
                        )}


                        ${textareaInput(
                            block.id,
                            'shipping_note',
                            'Shipping Note',
                            blockContent.shipping_note
                            ?? '',
                            3
                        )}


                        ${textareaInput(
                            block.id,
                            'highlight_title',
                            'Highlight Title',
                            blockContent.highlight_title
                            ?? '',
                            3
                        )}

                    `;

                    break;


                case 'template_button':

                    fields = `

                        ${textInput(
                            block.id,
                            'text',
                            'Button Text',
                            blockContent.text
                            ?? ''
                        )}


                        ${templateFileUploader(
                            block.id,
                            blockContent.template_url
                            ?? '',
                            blockContent.template_name
                            ?? ''
                        )}

                    `;

                    break;


                case 'heading':

                    fields =
                        textInput(
                            block.id,
                            'text',
                            'Heading',
                            blockContent.text
                            ?? ''
                        );

                    break;


                case 'rich_text':

                    fields =
                        richTextEditor(
                            block.id,
                            blockContent.content
                            ?? '',
                            blockContent.content_format
                            ?? 'plain',
                            blockContent.text_size
                            ?? 'normal'
                        );

                    break;


                case 'image':

                    fields = `

                        ${imageUploaderInput(
                            block.id,
                            'url',
                            'Image URL / Path',
                            blockContent.url
                            ?? ''
                        )}


                        ${textInput(
                            block.id,
                            'alt',
                            'Alt Text',
                            blockContent.alt
                            ?? ''
                        )}

                    `;

                    break;


                case 'button':

                    fields = `

                        ${textInput(
                            block.id,
                            'text',
                            'Button Text',
                            blockContent.text
                            ?? ''
                        )}


                        ${linkUrlInput(
                            block.id,
                            'url',
                            'Button URL',
                            blockContent.url
                            ?? ''
                        )}

                    `;

                    break;


                case 'text_link':

                    fields =
                        textLinkEditor(
                            block,
                            blockContent
                        );

                    break;


                case 'custom_table':

                    fields =
                        flexibleTableEditor(
                            block,
                            blockContent
                        );

                    break;


                case 'info_card':

                    fields = `

                        ${textInput(
                            block.id,
                            'title',
                            'Title',
                            blockContent.title
                            ?? ''
                        )}


                        ${infoCardImageUploader(
                            block.id,
                            blockContent.image_url
                            ?? ''
                        )}


                        ${textareaInput(
                            block.id,
                            'description',
                            'Description',
                            blockContent.description
                            ?? '',
                            5
                        )}


                        ${textInput(
                            block.id,
                            'link_text',
                            'Link Text',
                            blockContent.link_text
                            ?? ''
                        )}


                        ${linkUrlInput(
                            block.id,
                            'link_url',
                            'Link URL',
                            blockContent.link_url
                            ?? ''
                        )}

                    `;

                    break;


                case 'accordion':

                    return accordionEditor(
                        block,
                        blockContent
                    );


                case 'option_card_grid':

                    fields =
                        optionCardGridEditor(
                            block,
                            blockContent
                        );

                    break;


                case 'shipping_schedule':

                    fields =
                        shippingScheduleEditor(
                            block,
                            blockContent
                        );

                    break;


                case 'price_accordion':

                    fields =
                        systemMessage(
                            'Price data will be generated by the system.'
                        );

                    break;


                case 'production_schedule':

                    fields =
                        systemMessage(
                            'Production schedule will be generated automatically.'
                        );

                    break;


                case 'divider':

                    fields =
                        systemMessage(
                            'Divider does not require content.'
                        );

                    break;


                case 'spacer':

                    fields =
                        systemMessage(
                            'Spacer does not require content.'
                        );

                    break;


                default:

                    fields =
                        systemMessage(
                            `Unknown component: ${block.type}`
                        );

                    break;
            }


            return `

                <div
                    class="content-block ${isCollapsed ? 'is-collapsed' : ''}"
                    data-block-id="${block.id}"
                >

                    <div class="content-block-header">

                        <button
                            type="button"
                            class="content-block-toggle"
                            aria-expanded="${isCollapsed ? 'false' : 'true'}"
                            title="Expand or collapse this block"
                        >

                            <span
                                class="content-block-toggle-icon"
                                aria-hidden="true"
                            ></span>


                            <span class="content-block-name">

                                ${escapeHtml(
                                    getBlockName(
                                        block.type
                                    )
                                )}

                            </span>

                        </button>


                        <span
                            class="
                                badge
                                badge-light
                                content-block-id
                            "
                        >

                            #${escapeHtml(
                                getEffectiveBlockId(
                                    block
                                )
                            )}

                        </span>

                    </div>


                    <div class="content-block-body">

                        ${fields}

                    </div>

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Accordion
        |--------------------------------------------------------------------------
        */

        function accordionEditor(
            block,
            content
        )
        {
            const title =
                content.title
                ??
                block.settings
                    ?.title
                ??
                'Accordion Title';


            const isCollapsed =
                collapsedContentBlockIds.has(
                    String(
                        block.id
                    )
                );


            return `

                <div
                    class="
                        content-block
                        accordion-editor
                        ${isCollapsed ? 'is-collapsed' : ''}
                    "
                    data-block-id="${block.id}"
                >

                    <div class="content-block-header">

                        <button
                            type="button"
                            class="content-block-toggle"
                            aria-expanded="${isCollapsed ? 'false' : 'true'}"
                            title="Expand or collapse this block"
                        >

                            <span
                                class="content-block-toggle-icon"
                                aria-hidden="true"
                            ></span>


                            <span class="content-block-name">
                                Accordion
                            </span>

                        </button>


                        <span
                            class="
                                badge
                                badge-light
                                content-block-id
                            "
                        >

                            #${escapeHtml(
                                getEffectiveBlockId(
                                    block
                                )
                            )}

                        </span>

                    </div>


                    <div class="content-block-body">

                        ${textInput(
                            block.id,
                            'title',
                            'Accordion Title',
                            title
                        )}


                    <label>
                        Accordion Content
                    </label>


                        <div class="accordion-children">

                        ${
                            (
                                block.children
                                ?? []
                            ).length

                            ? (
                                block.children
                                ?? []
                            )
                            .map(
                                renderBlockEditor
                            )
                            .join('')

                            : `

                                <div class="text-muted text-center py-3">

                                    This Accordion has no child components.

                                </div>

                            `
                        }

                        </div>

                    </div>

                </div>

            `;
        }


        function bindContentBlockAccordions()
        {
            document
                .querySelectorAll(
                    '.content-block-toggle'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const block =
                                    this.closest(
                                        '.content-block'
                                    );


                                if (
                                    !block
                                ) {

                                    return;

                                }


                                const blockId =
                                    String(
                                        block.dataset
                                            .blockId
                                        ?? ''
                                    );


                                const isCollapsed =
                                    block.classList.toggle(
                                        'is-collapsed'
                                    );


                                this.setAttribute(
                                    'aria-expanded',
                                    isCollapsed
                                        ? 'false'
                                        : 'true'
                                );


                                if (
                                    blockId
                                ) {

                                    if (
                                        isCollapsed
                                    ) {

                                        collapsedContentBlockIds.add(
                                            blockId
                                        );

                                    } else {

                                        collapsedContentBlockIds.delete(
                                            blockId
                                        );

                                    }

                                }

                            };

                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | OptionCardGrid Dynamic Tab & Content Manager
        |--------------------------------------------------------------------------
        */

        const optionCardGridStore = new Map();

        let optionTabCounter = 1;
        function generateOptionTabId()
        {
            return 'tab_' + Date.now() + '_' + (optionTabCounter++);
        }

        function normalizeOptionCardGridContent(content)
        {
            const defaultTabs = [
                {
                    id: 'tab_attachment',
                    title: 'アタッチメント',
                    type: 'parts',
                    banner_image_url: '/products/images/accessories.webp',
                    banner_link_url: '/products/rubberkeyholder/#part_keyholder',
                    items: [
                        { image_url: '/products/images/HM_part1.webp', title: '通常松葉+カニカン', price: '+0円', zoom_url: '/products/images/HM_part1.webp' },
                        { image_url: '/products/images/HM_part2.webp', title: 'ゴム松葉+カニカン', price: '+0円', zoom_url: '/products/images/HM_part2.webp' },
                        { image_url: '/products/images/HM_part14.webp', title: 'ボールチェーンシルバー', price: '+0円', zoom_url: '/products/images/HM_part14.webp' },
                        { image_url: '/products/images/HM_part3.webp', title: '通常松葉+カニカン+スマホプラグ', price: '+11円', zoom_url: '/products/images/HM_part3.webp' },
                        { image_url: '/products/images/HM_part9.webp', title: 'ボールチェーン黄色', price: '+11円', zoom_url: '/products/images/HM_part9.webp' },
                        { image_url: '/products/images/HM_part10.webp', title: 'ボールチェーン赤色', price: '+11円', zoom_url: '/products/images/HM_part10.webp' },
                        { image_url: '/products/images/HM_part11.webp', title: 'ボールチェーン青色', price: '+11円', zoom_url: '/products/images/HM_part11.webp' },
                        { image_url: '/products/images/HM_part12.webp', title: 'ボールチェーンピンク色', price: '+11円', zoom_url: '/products/images/HM_part12.webp' },
                        { image_url: '/products/images/HM_part13.webp', title: 'ボールチェーン緑色', price: '+11円', zoom_url: '/products/images/HM_part13.webp' }
                    ]
                },
                {
                    id: 'tab_processing',
                    title: '加工方法',
                    type: 'cards',
                    items: [
                        {
                            image_url: '/products/images/rubberstrap/v2/rubber_guide02.webp',
                            title: 'ぷっくり凹凸タイプ・フラットタイプ',
                            description: 'あなたのデザインを最高のラバーキーホルダーに！キャラクターに最適な「ぷっくり凹凸タイプ」や、ドット絵・ロゴ向きの「フラットタイプ」が選べます。',
                            link_text: '詳細はこちら',
                            link_url: '/lp/rubber-guide-structure.php'
                        },
                        {
                            image_url: '/products/images/rubberstrap/v2/rubber_guide07.webp',
                            title: '特殊加工',
                            description: '曲面加工や貼り合わせ半立体、貫通穴（中抜き）加工などの特殊加工もご用意！デザインをより活かす特別なラバーストラップを製作できます。',
                            link_text: '詳細はこちら',
                            link_url: '/lp/rubber-guide-structure.php?sec=special_processing'
                        }
                    ]
                },
                {
                    id: 'tab_options',
                    title: 'オプション',
                    type: 'cards',
                    items: [
                        {
                            image_url: '/products/images/rubberstrap/v2/rubber_strap_protect.webp',
                            title: '汚れ防止加工オプション',
                            description: '業界唯一の汚れ防止加工オプションをご用意！あなたの大切なラバーストラップをキレイに保ちます。',
                            link_text: '詳細はこちら',
                            link_url: 'https://hotmobily.jp/faq/details/rubberstrap/q4'
                        },
                        {
                            image_url: '/products/images/rubberstrap/v2/rubberstrap_special.webp',
                            title: '特殊素材',
                            description: '金銀、蓄光、ラメ、蛍光、半透明素材の5種の特殊素材をご用意！',
                            link_text: '詳細はこちら',
                            link_url: '/lp/rubber-guide-special.php'
                        },
                        {
                            image_url: '/products/images/rubberstrap/v2/rubber_guide11.webp',
                            title: 'データ作成代行サービス',
                            description: '入稿データをご自身で作成するのが難しい方は、データ作成代行サービスをぜひご利用ください。',
                            link_text: '詳細はこちら',
                            link_url: '/lp/rubber-guide-data.php'
                        },
                        {
                            image_url: '/products/images/rubberstrap/v2/daishi_rubberstrap.webp',
                            title: '台紙封入サービス',
                            description: '台紙封入サービスをご用意しております。当店のテンプレートデザイン、またはお客様のオリジナルデザインの台紙を封入します。',
                            link_text: '詳細はこちら',
                            link_url: 'https://hotmobily.jp/products/daishi.html'
                        }
                    ]
                }
            ];

            let tabs = null;
            if (Array.isArray(content.tabs) && content.tabs.length > 0) {
                tabs = content.tabs.map((tab, idx) => ({
                    id: tab.id || ('tab_' + idx),
                    title: String(tab.title ?? ('Tab ' + (idx + 1))),
                    type: tab.type === 'parts' ? 'parts' : 'cards',
                    banner_image_url: String(tab.banner_image_url ?? ''),
                    banner_link_url: String(tab.banner_link_url ?? ''),
                    items: Array.isArray(tab.items) ? tab.items.map(item => ({
                        image_url: String(item.image_url ?? ''),
                        title: String(item.title ?? ''),
                        price: String(item.price ?? ''),
                        zoom_url: String(item.zoom_url ?? ''),
                        description: String(item.description ?? ''),
                        link_text: String(item.link_text ?? ''),
                        link_url: String(item.link_url ?? '')
                    })) : []
                }));
            } else {
                tabs = JSON.parse(JSON.stringify(defaultTabs));
            }

            return {
                title: String(content.title ?? 'アタッチメント・加工・オプション'),
                intro: String(content.intro ?? '当店ラバーストラップのアタッチメント・加工・オプションのご紹介です。'),
                activeTabIndex: 0,
                tabs: tabs
            };
        }

        async function uploadSingleImageFile(file)
        {
            validateImageFile(file);

            const formData = new FormData();
            formData.append('image', file);

            const response = await fetch(
                `/api/v1/admin/products/${productId}/images`,
                {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: formData,
                }
            );

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result?.message || 'Upload failed');
            }

            return result?.data?.url || result?.url;
        }

        function optionCardGridEditor(block, content)
        {
            const data = normalizeOptionCardGridContent(content);
            optionCardGridStore.set(block.id, data);

            return `
                <div class="option-card-grid-container" data-option-grid-block="${block.id}">
                    ${renderOptionCardGridInner(block.id, data)}
                </div>
            `;
        }

        function renderOptionCardGridInner(blockId, data)
        {
            const activeIndex = Math.min(Math.max(0, data.activeTabIndex || 0), Math.max(0, data.tabs.length - 1));
            data.activeTabIndex = activeIndex;
            const activeTab = data.tabs[activeIndex] || null;

            return `
                <div class="card mb-3 border-0 bg-transparent">
                    <div class="form-group mb-2">
                        <label class="font-weight-bold text-dark">Section Title (หัวข้อ Component)</label>
                        <input type="text" class="form-control option-grid-title-field" data-block-id="${blockId}" value="${escapeHtml(data.title)}" placeholder="アタッチメント・加工・オプション">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Intro Description (คำบรรยายสั้น)</label>
                        <textarea class="form-control option-grid-intro-field" data-block-id="${blockId}" rows="2" placeholder="当店ラバーストラップのアタッチメント・加工・オプションのご紹介です。">${escapeHtml(data.intro)}</textarea>
                    </div>

                    <!-- Tabs Management Bar -->
                    <div class="option-grid-nav-wrapper p-3 bg-white rounded border shadow-sm mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="font-weight-bold mb-0 text-dark">
                                <i class="fas fa-folder-open text-warning mr-1"></i> Tabs List (${data.tabs.length} Tabs)
                            </label>
                            <button type="button" class="btn btn-sm btn-success font-weight-bold btn-add-option-tab" data-block-id="${blockId}">
                                <i class="fas fa-plus mr-1"></i> + Add Tab (เพิ่มแท็บ)
                            </button>
                        </div>

                        <div class="option-grid-tab-pills">
                            ${data.tabs.map((tab, idx) => `
                                <button type="button" class="btn btn-sm ${idx === activeIndex ? 'btn-warning shadow-sm font-weight-bold' : 'btn-outline-secondary'} btn-switch-option-tab" data-block-id="${blockId}" data-tab-index="${idx}">
                                    <span class="mr-1">${idx + 1}. ${escapeHtml(tab.title || 'Untitled')}</span>
                                    <span class="badge ${tab.type === 'parts' ? 'badge-success' : 'badge-primary'}">${tab.type === 'parts' ? 'ตัวสินค้า (Parts)' : 'Card Info'}</span>
                                    <span class="badge badge-light border ml-1">${(tab.items || []).length}</span>
                                </button>
                            `).join('')}
                        </div>
                    </div>

                    <!-- Active Tab Settings & Items -->
                    ${activeTab ? renderActiveTabPanel(blockId, activeTab, activeIndex, data.tabs.length) : '<div class="alert alert-info">No tabs created. Click "+ Add Tab" to get started.</div>'}
                </div>
            `;
        }

        function renderActiveTabPanel(blockId, tab, tabIndex, totalTabs)
        {
            const isParts = tab.type === 'parts';

            return `
                <div class="card shadow-sm border-warning">
                    <div class="card-header bg-warning-light py-2 px-3 d-flex justify-content-between align-items-center flex-wrap" style="gap: 8px;">
                        <div class="d-flex align-items-center flex-wrap" style="gap: 8px; flex: 1; min-width: 260px;">
                            <span class="badge badge-dark">Tab #${tabIndex + 1}</span>
                            <div class="input-group input-group-sm" style="max-width: 250px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">ชื่อ Tab:</span>
                                </div>
                                <input type="text" class="form-control option-tab-title-edit" data-block-id="${blockId}" data-tab-index="${tabIndex}" value="${escapeHtml(tab.title)}" placeholder="Tab Title">
                            </div>

                            <div class="input-group input-group-sm" style="max-width: 290px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Type:</span>
                                </div>
                                <select class="form-control option-tab-type-edit" data-block-id="${blockId}" data-tab-index="${tabIndex}">
                                    <option value="parts" ${isParts ? 'selected' : ''}>📦 ตัวสินค้า / Parts Grid (ภาพ, ราคา, ภาพขยาย)</option>
                                    <option value="cards" ${!isParts ? 'selected' : ''}>🗂️ Card Info / การ์ดข้อมูล (ภาพ, คำบรรยาย, ลิงก์)</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex align-items-center" style="gap: 4px;">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-move-tab" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-direction="up" ${tabIndex === 0 ? 'disabled' : ''} title="ย้ายขึ้น">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-move-tab" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-direction="down" ${tabIndex === totalTabs - 1 ? 'disabled' : ''} title="ย้ายลง">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-tab" data-block-id="${blockId}" data-tab-index="${tabIndex}" ${totalTabs <= 1 ? 'disabled' : ''} title="ลบแท็บนี้">
                                <i class="fas fa-trash-alt mr-1"></i> ลบ Tab
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-3 bg-white">
                        ${isParts
                            ? renderPartsTabEditor(blockId, tab, tabIndex)
                            : renderCardsTabEditor(blockId, tab, tabIndex)
                        }
                    </div>
                </div>
            `;
        }

        function renderPartsTabEditor(blockId, tab, tabIndex)
        {
            const items = tab.items || [];

            return `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 font-weight-bold text-success">
                        <i class="fas fa-cubes mr-1"></i> รายการพาร์ทสินค้า / Parts Items (${items.length} รายการ)
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-success font-weight-bold btn-add-part-item" data-block-id="${blockId}" data-tab-index="${tabIndex}">
                        <i class="fas fa-plus mr-1"></i> + เพิ่มพาร์ทสินค้า (+ Add Part)
                    </button>
                </div>

                <div class="row option-parts-grid-admin">
                    ${items.map((item, itemIdx) => `
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card h-100 border shadow-none bg-light option-part-item-card">
                                <div class="card-body p-2 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge badge-secondary">#${itemIdx + 1}</span>
                                        <button type="button" class="btn btn-xs btn-outline-danger btn-delete-part-item" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" title="ลบพาร์ท">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="text-center mb-2 bg-white p-1 border rounded" style="height: 70px; display: flex; align-items: center; justify-content: center;">
                                        <img src="${escapeHtml(item.image_url || '/products/images/HM_part1.webp')}" class="img-fluid part-img-preview" style="max-height: 60px; object-fit: contain;" onerror="this.src='/products/images/HM_part1.webp'">
                                    </div>

                                    <div class="form-group mb-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="small text-muted mb-0 font-weight-bold">Image URL / Path:</label>
                                            <span class="small font-weight-bold part-upload-status" style="font-size: 11px;"></span>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control form-control-sm part-field-image" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" value="${escapeHtml(item.image_url)}" placeholder="/products/images/HM_part1.webp">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-primary btn-upload-part-img" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" title="อัพโหลดรูปภาพ">
                                                    <i class="fas fa-upload mr-1"></i> อัพภาพ
                                                </button>
                                            </div>
                                        </div>
                                        <input type="file" class="d-none part-file-input" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" accept="image/jpeg,image/png,image/webp,image/gif">
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small text-muted mb-0 font-weight-bold">ชื่อสินค้า (Title):</label>
                                        <input type="text" class="form-control form-control-sm part-field-title" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" value="${escapeHtml(item.title)}" placeholder="通常松葉+カニカン">
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small text-muted mb-0 font-weight-bold">ราคา (Price badge):</label>
                                        <input type="text" class="form-control form-control-sm part-field-price" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" value="${escapeHtml(item.price)}" placeholder="+0円 or +11円">
                                    </div>

                                    <div class="form-group mb-0 mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="small text-muted mb-0 font-weight-bold">Zoom URL (รูปภาพตอนขยาย):</label>
                                            <span class="small font-weight-bold part-zoom-upload-status" style="font-size: 11px;"></span>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control form-control-sm part-field-zoom" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" value="${escapeHtml(item.zoom_url || item.image_url)}" placeholder="(เว้นว่างจะใช้รูปหลัก)">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary btn-upload-zoom-img" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" title="อัพโหลดรูปขยาย">
                                                    <i class="fas fa-upload mr-1"></i> อัพภาพ
                                                </button>
                                            </div>
                                        </div>
                                        <input type="file" class="d-none part-zoom-file-input" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" accept="image/jpeg,image/png,image/webp,image/gif">
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>

                <!-- Bottom Banner Section for Parts Tab -->
                <div class="card mt-3 border-secondary bg-white">
                    <div class="card-header py-1 px-3 bg-light d-flex justify-content-between align-items-center">
                        <small class="font-weight-bold text-muted">
                            <i class="fas fa-image mr-1"></i> แบนเนอร์ด้านล่างแท็บ (Bottom Banner - Optional)
                        </small>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="small font-weight-bold text-muted mb-0">Banner Image URL:</label>
                                    <span class="small font-weight-bold banner-upload-status" style="font-size: 11px;"></span>
                                </div>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm part-banner-image-input" data-block-id="${blockId}" data-tab-index="${tabIndex}" value="${escapeHtml(tab.banner_image_url)}" placeholder="/products/images/accessories.webp">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-primary btn-upload-banner-img" data-block-id="${blockId}" data-tab-index="${tabIndex}" title="อัพโหลดแบนเนอร์">
                                            <i class="fas fa-upload mr-1"></i> อัพภาพ
                                        </button>
                                    </div>
                                </div>
                                <input type="file" class="d-none banner-file-input" data-block-id="${blockId}" data-tab-index="${tabIndex}" accept="image/jpeg,image/png,image/webp,image/gif">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="small font-weight-bold text-muted">Banner Link URL:</label>
                                <input type="text" class="form-control form-control-sm part-banner-link-input" data-block-id="${blockId}" data-tab-index="${tabIndex}" value="${escapeHtml(tab.banner_link_url)}" placeholder="/products/rubberkeyholder/#part_keyholder">
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function renderCardsTabEditor(blockId, tab, tabIndex)
        {
            const items = tab.items || [];

            return `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 font-weight-bold text-primary">
                        <i class="fas fa-id-card mr-1"></i> รายการการ์ดข้อมูล / Card Info Items (${items.length} รายการ)
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold btn-add-card-item" data-block-id="${blockId}" data-tab-index="${tabIndex}">
                        <i class="fas fa-plus mr-1"></i> + เพิ่มการ์ดข้อมูล (+ Add Card)
                    </button>
                </div>

                <div class="option-cards-list-admin">
                    ${items.map((item, itemIdx) => `
                        <div class="card mb-3 border shadow-none bg-light option-card-item-card">
                            <div class="card-header py-1 px-3 bg-white d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold small text-dark">
                                    <i class="fas fa-file-alt mr-1 text-primary"></i> Card #${itemIdx + 1} ${item.title ? '— ' + escapeHtml(item.title) : ''}
                                </span>
                                <button type="button" class="btn btn-xs btn-outline-danger btn-delete-card-item" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" title="ลบการ์ดนี้">
                                    <i class="fas fa-times mr-1"></i> ลบการ์ด
                                </button>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-md-4 text-center mb-2">
                                        <div class="bg-white p-2 border rounded mb-2" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                            <img src="${escapeHtml(item.image_url || '/products/images/rubberstrap/v2/rubber_guide02.webp')}" class="img-fluid rounded card-img-preview" style="max-height: 110px; object-fit: contain;" onerror="this.src='/products/images/rubberstrap/v2/rubber_guide02.webp'">
                                        </div>
                                        <div class="form-group mb-0 text-left">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <label class="small text-muted font-weight-bold mb-0">Card Image URL:</label>
                                                <span class="small font-weight-bold card-upload-status" style="font-size: 11px;"></span>
                                            </div>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control form-control-sm card-field-image" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" value="${escapeHtml(item.image_url)}" placeholder="/products/images/rubberstrap/v2/rubber_guide02.webp">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-primary btn-upload-card-img" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" title="อัพโหลดรูปภาพการ์ด">
                                                        <i class="fas fa-upload mr-1"></i> อัพภาพ
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="file" class="d-none card-file-input" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" accept="image/jpeg,image/png,image/webp,image/gif">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group mb-2">
                                            <label class="small text-muted font-weight-bold mb-1">หัวข้อการ์ด (Card Title):</label>
                                            <input type="text" class="form-control form-control-sm card-field-title" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" value="${escapeHtml(item.title)}" placeholder="ぷっくり凹凸タイプ・フラットタイプ">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="small text-muted font-weight-bold mb-1">คำบรรยาย (Description):</label>
                                            <textarea class="form-control form-control-sm card-field-desc" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" rows="3" placeholder="ข้อความอธิบายคุณสมบัติหรือรายละเอียด...">${escapeHtml(item.description)}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5 mb-2">
                                                <label class="small text-muted font-weight-bold mb-1">ข้อความปุ่มลิงก์ (Link Text):</label>
                                                <input type="text" class="form-control form-control-sm card-field-link-text" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" value="${escapeHtml(item.link_text || '詳細はこちら')}" placeholder="詳細はこちら">
                                            </div>
                                            <div class="col-md-7 mb-2">
                                                <label class="small text-muted font-weight-bold mb-1">Link URL (URL หรือ #block-id):</label>
                                                <input type="text" class="form-control form-control-sm card-field-link-url" data-block-id="${blockId}" data-tab-index="${tabIndex}" data-item-index="${itemIdx}" value="${escapeHtml(item.link_url)}" placeholder="/lp/... or #block-id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        function rerenderOptionCardGrid(blockId)
        {
            const container = document.querySelector(`.option-card-grid-container[data-option-grid-block="${blockId}"]`);
            if (!container) return;
            const data = optionCardGridStore.get(blockId);
            container.innerHTML = renderOptionCardGridInner(blockId, data);
            bindOptionCardGridEvents(container, blockId);
            bindLinkUrlPickers();
        }

        function bindOptionCardGridEvents(container, blockId)
        {
            const data = optionCardGridStore.get(blockId);
            if (!data) return;

            // Section title & intro sync
            const titleInput = container.querySelector(`.option-grid-title-field[data-block-id="${blockId}"]`);
            if (titleInput) {
                titleInput.addEventListener('input', function () {
                    data.title = this.value;
                });
            }

            const introInput = container.querySelector(`.option-grid-intro-field[data-block-id="${blockId}"]`);
            if (introInput) {
                introInput.addEventListener('input', function () {
                    data.intro = this.value;
                });
            }

            // Switch tab
            container.querySelectorAll('.btn-switch-option-tab').forEach(btn => {
                btn.addEventListener('click', function () {
                    const idx = Number(this.dataset.tabIndex);
                    data.activeTabIndex = idx;
                    rerenderOptionCardGrid(blockId);
                });
            });

            // Add Tab
            const addTabBtn = container.querySelector('.btn-add-option-tab');
            if (addTabBtn) {
                addTabBtn.addEventListener('click', function () {
                    const newIdx = data.tabs.length + 1;
                    data.tabs.push({
                        id: generateOptionTabId(),
                        title: 'Tab ' + newIdx,
                        type: 'cards',
                        banner_image_url: '',
                        banner_link_url: '',
                        items: [
                            {
                                image_url: '',
                                title: 'Card 1',
                                description: '',
                                link_text: '詳細はこちら',
                                link_url: ''
                            }
                        ]
                    });
                    data.activeTabIndex = data.tabs.length - 1;
                    rerenderOptionCardGrid(blockId);
                });
            }

            // Delete Tab
            const delTabBtn = container.querySelector('.btn-delete-tab');
            if (delTabBtn) {
                delTabBtn.addEventListener('click', function () {
                    const idx = Number(this.dataset.tabIndex);
                    if (data.tabs.length <= 1) return;
                    if (!confirm(`ต้องการลบ Tab "${data.tabs[idx]?.title || ''}" ใช่หรือไม่?`)) return;

                    data.tabs.splice(idx, 1);
                    data.activeTabIndex = Math.max(0, idx - 1);
                    rerenderOptionCardGrid(blockId);
                });
            }

            // Move Tab
            container.querySelectorAll('.btn-move-tab').forEach(btn => {
                btn.addEventListener('click', function () {
                    const idx = Number(this.dataset.tabIndex);
                    const dir = this.dataset.direction;
                    const targetIdx = dir === 'up' ? idx - 1 : idx + 1;
                    if (targetIdx < 0 || targetIdx >= data.tabs.length) return;

                    const temp = data.tabs[idx];
                    data.tabs[idx] = data.tabs[targetIdx];
                    data.tabs[targetIdx] = temp;
                    data.activeTabIndex = targetIdx;
                    rerenderOptionCardGrid(blockId);
                });
            });

            // Tab Title Edit
            const tabTitleInput = container.querySelector('.option-tab-title-edit');
            if (tabTitleInput) {
                tabTitleInput.addEventListener('input', function () {
                    const idx = Number(this.dataset.tabIndex);
                    if (data.tabs[idx]) {
                        data.tabs[idx].title = this.value;
                    }
                });
            }

            // Tab Type Edit
            const tabTypeSelect = container.querySelector('.option-tab-type-edit');
            if (tabTypeSelect) {
                tabTypeSelect.addEventListener('change', function () {
                    const idx = Number(this.dataset.tabIndex);
                    const newType = this.value;
                    if (data.tabs[idx]) {
                        data.tabs[idx].type = newType;
                        if (newType === 'parts' && (!data.tabs[idx].items || data.tabs[idx].items.length === 0)) {
                            data.tabs[idx].items = [{ image_url: '', title: '', price: '+0円', zoom_url: '' }];
                        } else if (newType === 'cards' && (!data.tabs[idx].items || data.tabs[idx].items.length === 0)) {
                            data.tabs[idx].items = [{ image_url: '', title: '', description: '', link_text: '詳細はこちら', link_url: '' }];
                        }
                    }
                    rerenderOptionCardGrid(blockId);
                });
            }

            // Add Part Item
            const addPartBtn = container.querySelector('.btn-add-part-item');
            if (addPartBtn) {
                addPartBtn.addEventListener('click', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    if (!data.tabs[tabIdx].items) data.tabs[tabIdx].items = [];
                    data.tabs[tabIdx].items.push({
                        image_url: '',
                        title: '',
                        price: '+0円',
                        zoom_url: ''
                    });
                    rerenderOptionCardGrid(blockId);
                });
            }

            // Delete Part Item
            container.querySelectorAll('.btn-delete-part-item').forEach(btn => {
                btn.addEventListener('click', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items) {
                        data.tabs[tabIdx].items.splice(itemIdx, 1);
                        rerenderOptionCardGrid(blockId);
                    }
                });
            });

            // Part Item Fields
            container.querySelectorAll('.part-field-image').forEach(input => {
                input.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                        data.tabs[tabIdx].items[itemIdx].image_url = this.value;
                        const card = this.closest('.option-part-item-card');
                        const img = card?.querySelector('.part-img-preview');
                        if (img) img.src = this.value || '/products/images/HM_part1.webp';
                    }
                });
            });

            container.querySelectorAll('.part-field-title').forEach(input => {
                input.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                        data.tabs[tabIdx].items[itemIdx].title = this.value;
                    }
                });
            });

            container.querySelectorAll('.part-field-price').forEach(input => {
                input.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                        data.tabs[tabIdx].items[itemIdx].price = this.value;
                    }
                });
            });

            container.querySelectorAll('.part-field-zoom').forEach(input => {
                input.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                        data.tabs[tabIdx].items[itemIdx].zoom_url = this.value;
                    }
                });
            });

            // Banner inputs
            const bannerImgInput = container.querySelector('.part-banner-image-input');
            if (bannerImgInput) {
                bannerImgInput.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    if (data.tabs[tabIdx]) {
                        data.tabs[tabIdx].banner_image_url = this.value;
                    }
                });
            }

            const bannerLinkInput = container.querySelector('.part-banner-link-input');
            if (bannerLinkInput) {
                bannerLinkInput.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    if (data.tabs[tabIdx]) {
                        data.tabs[tabIdx].banner_link_url = this.value;
                    }
                });
            }

            // Add Card Item
            const addCardBtn = container.querySelector('.btn-add-card-item');
            if (addCardBtn) {
                addCardBtn.addEventListener('click', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    if (!data.tabs[tabIdx].items) data.tabs[tabIdx].items = [];
                    data.tabs[tabIdx].items.push({
                        image_url: '',
                        title: '',
                        description: '',
                        link_text: '詳細はこちら',
                        link_url: ''
                    });
                    rerenderOptionCardGrid(blockId);
                });
            }

            // Delete Card Item
            container.querySelectorAll('.btn-delete-card-item').forEach(btn => {
                btn.addEventListener('click', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items) {
                        data.tabs[tabIdx].items.splice(itemIdx, 1);
                        rerenderOptionCardGrid(blockId);
                    }
                });
            });

            // Card Item Fields
            container.querySelectorAll('.card-field-image').forEach(input => {
                input.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                        data.tabs[tabIdx].items[itemIdx].image_url = this.value;
                        const card = this.closest('.option-card-item-card');
                        const img = card?.querySelector('.card-img-preview');
                        if (img) img.src = this.value || '/products/images/rubberstrap/v2/rubber_guide02.webp';
                    }
                });
            });

            container.querySelectorAll('.card-field-title').forEach(input => {
                input.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                        data.tabs[tabIdx].items[itemIdx].title = this.value;
                    }
                });
            });

            container.querySelectorAll('.card-field-desc').forEach(input => {
                input.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                        data.tabs[tabIdx].items[itemIdx].description = this.value;
                    }
                });
            });

            container.querySelectorAll('.card-field-link-text').forEach(input => {
                input.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                        data.tabs[tabIdx].items[itemIdx].link_text = this.value;
                    }
                });
            });

            container.querySelectorAll('.card-field-link-url').forEach(input => {
                input.addEventListener('input', function () {
                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                        data.tabs[tabIdx].items[itemIdx].link_url = this.value;
                    }
                });
            });

            // Upload Part Image
            container.querySelectorAll('.btn-upload-part-img').forEach(btn => {
                btn.addEventListener('click', function () {
                    const tabIdx = this.dataset.tabIndex;
                    const itemIdx = this.dataset.itemIndex;
                    const fileInput = container.querySelector(`.part-file-input[data-tab-index="${tabIdx}"][data-item-index="${itemIdx}"]`);
                    fileInput?.click();
                });
            });

            container.querySelectorAll('.part-file-input').forEach(input => {
                input.addEventListener('change', async function () {
                    const file = this.files?.[0];
                    if (!file) return;

                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    const card = this.closest('.option-part-item-card');
                    const status = card?.querySelector('.part-upload-status');
                    const btn = card?.querySelector('.btn-upload-part-img');

                    try {
                        if (status) {
                            status.className = 'small font-weight-bold part-upload-status text-warning';
                            status.textContent = '⏳ กำลังอัพโหลด...';
                        }
                        if (btn) btn.disabled = true;

                        const url = await uploadSingleImageFile(file);

                        if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                            data.tabs[tabIdx].items[itemIdx].image_url = url;
                            if (!data.tabs[tabIdx].items[itemIdx].zoom_url) {
                                data.tabs[tabIdx].items[itemIdx].zoom_url = url;
                                const zoomInput = card?.querySelector('.part-field-zoom');
                                if (zoomInput) zoomInput.value = url;
                            }
                        }

                        const textInput = card?.querySelector('.part-field-image');
                        if (textInput) textInput.value = url;

                        const img = card?.querySelector('.part-img-preview');
                        if (img) img.src = url;

                        if (status) {
                            status.className = 'small font-weight-bold part-upload-status text-success';
                            status.textContent = '✓ สำเร็จ';
                            setTimeout(() => { if (status && status.textContent === '✓ สำเร็จ') status.textContent = ''; }, 3000);
                        }
                    } catch (err) {
                        alert(err?.message || 'Upload failed');
                        if (status) {
                            status.className = 'small font-weight-bold part-upload-status text-danger';
                            status.textContent = '❌ ล้มเหลว';
                        }
                    } finally {
                        if (btn) btn.disabled = false;
                        this.value = '';
                    }
                });
            });

            // Upload Zoom Image
            container.querySelectorAll('.btn-upload-zoom-img').forEach(btn => {
                btn.addEventListener('click', function () {
                    const tabIdx = this.dataset.tabIndex;
                    const itemIdx = this.dataset.itemIndex;
                    const fileInput = container.querySelector(`.part-zoom-file-input[data-tab-index="${tabIdx}"][data-item-index="${itemIdx}"]`);
                    fileInput?.click();
                });
            });

            container.querySelectorAll('.part-zoom-file-input').forEach(input => {
                input.addEventListener('change', async function () {
                    const file = this.files?.[0];
                    if (!file) return;

                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    const card = this.closest('.option-part-item-card');
                    const status = card?.querySelector('.part-zoom-upload-status');
                    const btn = card?.querySelector('.btn-upload-zoom-img');

                    try {
                        if (status) {
                            status.className = 'small font-weight-bold part-zoom-upload-status text-warning';
                            status.textContent = '⏳ กำลังอัพโหลด...';
                        }
                        if (btn) btn.disabled = true;

                        const url = await uploadSingleImageFile(file);

                        if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                            data.tabs[tabIdx].items[itemIdx].zoom_url = url;
                        }

                        const zoomInput = card?.querySelector('.part-field-zoom');
                        if (zoomInput) zoomInput.value = url;

                        if (status) {
                            status.className = 'small font-weight-bold part-zoom-upload-status text-success';
                            status.textContent = '✓ สำเร็จ';
                            setTimeout(() => { if (status && status.textContent === '✓ สำเร็จ') status.textContent = ''; }, 3000);
                        }
                    } catch (err) {
                        alert(err?.message || 'Upload failed');
                        if (status) {
                            status.className = 'small font-weight-bold part-zoom-upload-status text-danger';
                            status.textContent = '❌ ล้มเหลว';
                        }
                    } finally {
                        if (btn) btn.disabled = false;
                        this.value = '';
                    }
                });
            });

            // Upload Banner Image
            container.querySelectorAll('.btn-upload-banner-img').forEach(btn => {
                btn.addEventListener('click', function () {
                    const tabIdx = this.dataset.tabIndex;
                    const fileInput = container.querySelector(`.banner-file-input[data-tab-index="${tabIdx}"]`);
                    fileInput?.click();
                });
            });

            container.querySelectorAll('.banner-file-input').forEach(input => {
                input.addEventListener('change', async function () {
                    const file = this.files?.[0];
                    if (!file) return;

                    const tabIdx = Number(this.dataset.tabIndex);
                    const parent = this.closest('.col-md-6') || this.parentElement;
                    const status = parent?.querySelector('.banner-upload-status');
                    const btn = parent?.querySelector('.btn-upload-banner-img');

                    try {
                        if (status) {
                            status.className = 'small font-weight-bold banner-upload-status text-warning';
                            status.textContent = '⏳ กำลังอัพโหลด...';
                        }
                        if (btn) btn.disabled = true;

                        const url = await uploadSingleImageFile(file);

                        if (data.tabs[tabIdx]) {
                            data.tabs[tabIdx].banner_image_url = url;
                        }

                        const bannerInput = container.querySelector('.part-banner-image-input');
                        if (bannerInput) bannerInput.value = url;

                        if (status) {
                            status.className = 'small font-weight-bold banner-upload-status text-success';
                            status.textContent = '✓ สำเร็จ';
                            setTimeout(() => { if (status && status.textContent === '✓ สำเร็จ') status.textContent = ''; }, 3000);
                        }
                    } catch (err) {
                        alert(err?.message || 'Upload failed');
                        if (status) {
                            status.className = 'small font-weight-bold banner-upload-status text-danger';
                            status.textContent = '❌ ล้มเหลว';
                        }
                    } finally {
                        if (btn) btn.disabled = false;
                        this.value = '';
                    }
                });
            });

            // Upload Card Image
            container.querySelectorAll('.btn-upload-card-img').forEach(btn => {
                btn.addEventListener('click', function () {
                    const tabIdx = this.dataset.tabIndex;
                    const itemIdx = this.dataset.itemIndex;
                    const fileInput = container.querySelector(`.card-file-input[data-tab-index="${tabIdx}"][data-item-index="${itemIdx}"]`);
                    fileInput?.click();
                });
            });

            container.querySelectorAll('.card-file-input').forEach(input => {
                input.addEventListener('change', async function () {
                    const file = this.files?.[0];
                    if (!file) return;

                    const tabIdx = Number(this.dataset.tabIndex);
                    const itemIdx = Number(this.dataset.itemIndex);
                    const card = this.closest('.option-card-item-card');
                    const status = card?.querySelector('.card-upload-status');
                    const btn = card?.querySelector('.btn-upload-card-img');

                    try {
                        if (status) {
                            status.className = 'small font-weight-bold card-upload-status text-warning';
                            status.textContent = '⏳ กำลังอัพโหลด...';
                        }
                        if (btn) btn.disabled = true;

                        const url = await uploadSingleImageFile(file);

                        if (data.tabs[tabIdx]?.items?.[itemIdx]) {
                            data.tabs[tabIdx].items[itemIdx].image_url = url;
                        }

                        const textInput = card?.querySelector('.card-field-image');
                        if (textInput) textInput.value = url;

                        const img = card?.querySelector('.card-img-preview');
                        if (img) img.src = url;

                        if (status) {
                            status.className = 'small font-weight-bold card-upload-status text-success';
                            status.textContent = '✓ สำเร็จ';
                            setTimeout(() => { if (status && status.textContent === '✓ สำเร็จ') status.textContent = ''; }, 3000);
                        }
                    } catch (err) {
                        alert(err?.message || 'Upload failed');
                        if (status) {
                            status.className = 'small font-weight-bold card-upload-status text-danger';
                            status.textContent = '❌ ล้มเหลว';
                        }
                    } finally {
                        if (btn) btn.disabled = false;
                        this.value = '';
                    }
                });
            });
        }

        function bindOptionCardGridEditors()
        {
            document
                .querySelectorAll(
                    '.option-card-grid-container'
                )
                .forEach(
                    function (container) {

                        const blockId =
                            container.dataset
                                .optionGridBlock;

                        if (blockId) {
                            bindOptionCardGridEvents(container, blockId);
                        }

                    }
                );
        }

        function collectOptionCardGridData(blockId)
        {
            const data = optionCardGridStore.get(blockId) ?? normalizeOptionCardGridContent({});

            const titleInput = document.querySelector(`.option-grid-title-field[data-block-id="${blockId}"]`);
            if (titleInput) {
                data.title = titleInput.value;
            }

            const introInput = document.querySelector(`.option-grid-intro-field[data-block-id="${blockId}"]`);
            if (introInput) {
                data.intro = introInput.value;
            }

            return {
                title: data.title,
                intro: data.intro,
                tabs: data.tabs
            };
        }


        /*
        |--------------------------------------------------------------------------
        | Text Link
        |--------------------------------------------------------------------------
        */

        function textLinkEditor(
            block,
            content
        )
        {
            const target =
                [
                    '_self',
                    '_blank',
                ].includes(
                    content.target
                )
                    ? content.target
                    : '_self';


            const textColor =
                normalizeHexColor(
                    content.text_color,
                    '#111111'
                );


            return `

                <div
                    class="text-link-editor"
                    data-text-link-block="${block.id}"
                >

                    ${textInput(
                        block.id,
                        'text',
                        'Link Text',
                        content.text
                        ?? ''
                    )}


                    ${linkUrlInput(
                        block.id,
                        'url',
                        'Link URL',
                        content.url
                        ?? ''
                    )}


                    <div class="form-group">

                        <label>
                            Text Color
                        </label>


                        <div class="flex-table-color-control">

                            <input
                                type="color"
                                class="
                                    form-control
                                    product-field
                                    text-link-color-input
                                "
                                data-block-id="${block.id}"
                                data-field="text_color"
                                value="${textColor}"
                            >

                            <code class="text-link-color-value">
                                ${textColor}
                            </code>

                        </div>

                    </div>


                    <div class="form-group mb-0">

                        <label>
                            Open Link
                        </label>


                        <select
                            class="
                                form-control
                                product-field
                            "
                            data-block-id="${block.id}"
                            data-field="target"
                        >

                            <option
                                value="_self"
                                ${
                                    target === '_self'
                                    ? 'selected'
                                    : ''
                                }
                            >
                                Same Window
                            </option>

                            <option
                                value="_blank"
                                ${
                                    target === '_blank'
                                    ? 'selected'
                                    : ''
                                }
                            >
                                New Tab
                            </option>

                        </select>

                    </div>


                    <div class="text-link-preview">

                        <small class="text-muted d-block mb-1">
                            Preview
                        </small>


                        <a href="#">

                            ${escapeHtml(
                                content.text
                                || 'Text Link Example'
                            )}

                        </a>

                    </div>

                </div>

            `;
        }


        function bindTextLinkEditors()
        {
            document
                .querySelectorAll(
                    '.text-link-editor'
                )
                .forEach(
                    function (editor) {

                        const blockId =
                            editor.dataset
                                .textLinkBlock;


                        const input =
                            editor.querySelector(
                                `[data-block-id="${blockId}"][data-field="text"]`
                            );


                        const preview =
                            editor.querySelector(
                                '.text-link-preview a'
                            );


                        const colorInput =
                            editor.querySelector(
                                `[data-block-id="${blockId}"][data-field="text_color"]`
                            );


                        const colorValue =
                            editor.querySelector(
                                '.text-link-color-value'
                            );


                        if (
                            !input
                            ||
                            !preview
                        ) {

                            return;

                        }


                        input.addEventListener(
                            'input',
                            function () {

                                preview.textContent =
                                    input.value
                                    ||
                                    'Text Link Example';

                            }
                        );


                        const applyTextColor =
                            function () {

                                const color =
                                    normalizeHexColor(
                                        colorInput
                                            ?.value,
                                        '#111111'
                                    );


                                preview.style.color =
                                    color;


                                if (
                                    colorValue
                                ) {

                                    colorValue.textContent =
                                        color;

                                }

                            };


                        applyTextColor();


                        if (
                            colorInput
                        ) {

                            colorInput.addEventListener(
                                'input',
                                applyTextColor
                            );

                        }


                        preview.addEventListener(
                            'click',
                            function (event) {

                                event.preventDefault();

                                const urlInput =
                                    editor.querySelector(
                                        `[data-block-id="${blockId}"][data-field="url"]`
                                    );

                                if (
                                    urlInput
                                    &&
                                    urlInput.value
                                ) {

                                    scrollToBlock(
                                        urlInput.value
                                    );

                                }

                            }
                        );

                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Flexible Custom Table V2
        |--------------------------------------------------------------------------
        |
        | รองรับ:
        |
        | - จำนวน Cell ต่อ Row ไม่เท่ากัน
        | - Width %
        | - Row Span
        | - Background Color
        | - Text Color
        | - Text Align
        | - Vertical Align
        | - Bold
        | - Padding
        |
        */

        function flexibleTableEditor(
            block,
            content
        )
        {
            const data =
                normalizeFlexibleTableContent(
                    content
                );


            return `

                <div
                    class="flex-table-editor"
                    data-flex-table-block="${block.id}"
                >

                    ${renderFlexibleTableInner(
                        block.id,
                        data
                    )}

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Normalize Table
        |--------------------------------------------------------------------------
        */

        function normalizeFlexibleTableContent(
            content
        )
        {
            /*
             * Flexible Table V2
             */
            if (
                Array.isArray(
                    content.rows
                )
                &&
                content.rows.some(
                    row =>
                        row
                        &&
                        typeof row === 'object'
                        &&
                        !Array.isArray(
                            row
                        )
                        &&
                        Array.isArray(
                            row.cells
                        )
                )
            ) {

                return {

                    title:
                        String(
                            content.title
                            ?? ''
                        ),

                    rows:
                        content.rows.map(
                            normalizeFlexibleTableRow
                        ),

                };

            }


            /*
             * Compatibility กับ Custom Table เก่า
             *
             * {
             *   headers: [],
             *   rows: [[], []]
             * }
             */
            const headers =
                Array.isArray(
                    content.headers
                )
                    ? content.headers
                    : [];


            const oldRows =
                Array.isArray(
                    content.rows
                )
                    ? content.rows.filter(
                        Array.isArray
                    )
                    : [];


            const rows =
                [];


            if (
                headers.length
            ) {

                rows.push(
                    makeFlexibleRowFromValues(
                        headers,
                        true
                    )
                );

            }


            oldRows.forEach(
                function (row) {

                    rows.push(
                        makeFlexibleRowFromValues(
                            row,
                            false
                        )
                    );

                }
            );


            /*
             * New empty table
             */
            if (
                rows.length === 0
            ) {

                rows.push({

                    id:
                        generateFlexRowId(),

                    height:
                        0,

                    background_color:
                        '',

                    cells: [

                        defaultFlexibleCell(
                            50
                        ),

                        defaultFlexibleCell(
                            50
                        ),

                    ],

                });

            }


            return {

                title:
                    String(
                        content.title
                        ?? ''
                    ),

                rows:
                    rows,

            };
        }


        function normalizeFlexibleTableRow(
            row
        )
        {
            return {

                id:
                    String(
                        row?.id
                        ||
                        generateFlexRowId()
                    ),

                height:
                    normalizeFlexRowHeight(
                        row?.height
                        ?? 0
                    ),

                background_color:
                    normalizeOptionalHexColor(
                        row?.background_color
                        ?? ''
                    ),

                cells:
                    Array.isArray(
                        row?.cells
                    )
                        ? row.cells.map(
                            normalizeFlexibleTableCell
                        )
                        : [],

            };
        }


        function normalizeFlexibleTableCell(
            cell
        )
        {
            return {

                id:
                    String(
                        cell?.id
                        ||
                        generateFlexCellId()
                    ),

                content:
                    String(
                        cell?.content
                        ?? ''
                    ),

                width:
                    normalizeFlexWidth(
                        cell?.width
                        ?? 100
                    ),

                rowspan:
                    normalizeFlexRowspan(
                        cell?.rowspan
                        ?? 1
                    ),

                background_color:
                    normalizeHexColor(
                        cell?.background_color,
                        '#ffffff'
                    ),

                text_color:
                    normalizeHexColor(
                        cell?.text_color,
                        '#000000'
                    ),

                align:
                    [
                        'left',
                        'center',
                        'right',
                    ].includes(
                        cell?.align
                    )
                        ? cell.align
                        : 'center',

                vertical_align:
                    [
                        'top',
                        'middle',
                        'bottom',
                    ].includes(
                        cell?.vertical_align
                    )
                        ? cell.vertical_align
                        : 'middle',

                bold:
                    Boolean(
                        cell?.bold
                    ),

                padding:
                    normalizeFlexPadding(
                        cell?.padding
                        ?? 8
                    ),

            };
        }


        function defaultFlexibleCell(
            width = 100
        )
        {
            return {

                id:
                    generateFlexCellId(),

                content:
                    '',

                width:
                    normalizeFlexWidth(
                        width
                    ),

                rowspan:
                    1,

                background_color:
                    '#ffffff',

                text_color:
                    '#000000',

                align:
                    'center',

                vertical_align:
                    'middle',

                bold:
                    false,

                padding:
                    8,

            };
        }


        /*
        |--------------------------------------------------------------------------
        | Convert old table
        |--------------------------------------------------------------------------
        */

        function makeFlexibleRowFromValues(
            values,
            isHeader
        )
        {
            const safeValues =
                values.length
                    ? values
                    : [''];


            const widths =
                distributeWidthUnits(
                    FLEX_TABLE_TOTAL_UNITS,
                    safeValues.length
                );


            return {

                id:
                    generateFlexRowId(),

                height:
                    0,

                background_color:
                    '',

                cells:
                    safeValues.map(
                        function (
                            value,
                            index
                        ) {

                            return {

                                ...defaultFlexibleCell(
                                    unitsToPercent(
                                        widths[
                                            index
                                        ]
                                    )
                                ),

                                content:
                                    String(
                                        value
                                        ?? ''
                                    ),

                                background_color:
                                    isHeader
                                    ? '#d9e7f3'
                                    : '#ffffff',

                                bold:
                                    isHeader,

                            };

                        }
                    ),

            };
        }


        /*
        |--------------------------------------------------------------------------
        | Render Table Editor
        |--------------------------------------------------------------------------
        */

        function renderFlexibleTableInner(
            blockId,
            data
        )
        {
            const tableLayout =
                buildFlexibleTableLayout(
                    data
                );


            return `

                <div class="form-group">

                    <label>
                        Table Title
                    </label>

                    <input
                        type="text"
                        class="
                            form-control
                            flex-table-title
                        "
                        value="${escapeHtml(
                            data.title
                        )}"
                        placeholder="Optional table title"
                    >

                </div>


                <div class="flex-table-topbar">

                    <div>

                        <strong>
                            Flexible Table
                        </strong>

                        <div class="text-muted small">

                            แต่ละแถวกำหนด Cell / Width / Row Span /
                            สี / Alignment ได้อิสระ

                        </div>

                    </div>


                    <div class="flex-table-topbar-actions">

                        <div class="flex-table-row-count-control">

                            <label>
                                Rows
                            </label>


                            <input
                                type="number"
                                class="form-control flex-table-row-count-input"
                                min="1"
                                max="100"
                                step="1"
                                value="${data.rows.length}"
                                data-block-id="${blockId}"
                                title="Set the number of rows in this table"
                            >

                        </div>


                        <button
                            type="button"
                            class="
                                btn
                                btn-sm
                                btn-outline-primary
                                flex-table-add-row
                            "
                            data-block-id="${blockId}"
                        >
                            + Add Row
                        </button>

                    </div>

                </div>


                <div class="flex-table-rows">

                    ${data.rows
                        .map(
                            function (
                                row,
                                rowIndex
                            ) {

                                return renderFlexibleTableRowEditor(

                                    blockId,

                                    row,

                                    rowIndex,

                                    data.rows.length,

                                    tableLayout
                                        .rowMeta[
                                            rowIndex
                                        ]

                                );

                            }
                        )
                        .join('')
                    }

                </div>


                <div class="flex-table-help">

                    Width ของ Cell ในแถว

                    +

                    Width ที่ถูก Row Span จากแถวก่อนหน้า

                    ต้องรวมเป็น

                    <strong>
                        100%
                    </strong>

                </div>


                <div
                    class="flex-table-preview"
                    data-flex-table-preview="${blockId}"
                ></div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Render Row Editor
        |--------------------------------------------------------------------------
        */

        function renderFlexibleTableRowEditor(
            blockId,
            row,
            rowIndex,
            rowTotal,
            meta
        )
        {
            const inherited =
                meta?.inheritedWidth
                ?? 0;


            const own =
                meta?.ownWidth
                ?? calculateOwnFlexibleRowWidth(
                    row
                );


            const coverage =
                meta?.coverageWidth
                ?? own;


            const valid =
                Boolean(
                    meta?.valid
                );


            return `

                <div
                    class="flex-table-row-editor"
                    data-flex-row-id="${escapeHtml(
                        row.id
                    )}"
                >

                    <input
                        type="hidden"
                        class="flex-row-id"
                        value="${escapeHtml(
                            row.id
                        )}"
                    >


                    <div class="flex-table-row-header">

                        <div>

                            <strong>
                                Row #${rowIndex + 1}
                            </strong>


                            <span
                                class="
                                    ${
                                        valid
                                        ? 'flex-table-width-ok'
                                        : 'flex-table-width-error'
                                    }
                                    flex-table-row-width-status
                                "
                            >

                                ${formatFlexibleRowStatus(
                                    inherited,
                                    own,
                                    coverage,
                                    valid
                                )}

                            </span>


                            <div class="flex-table-row-detail">

                                ${
                                    inherited > 0

                                    ? `Row Span from above: ${formatPercentNumber(
                                        inherited
                                    )}%`

                                    : 'No Row Span from above'
                                }

                            </div>


                            <div class="flex-table-row-height">

                                <label>
                                    Row Height (px)
                                </label>


                                <input
                                    type="number"
                                    class="form-control flex-row-height-input"
                                    min="0"
                                    max="1000"
                                    step="1"
                                    value="${escapeHtml(
                                        normalizeFlexRowHeight(
                                            row.height
                                            ?? 0
                                        )
                                    )}"
                                    title="Use 0 for automatic height"
                                >


                                <small class="text-muted">
                                    0 = Auto
                                </small>

                            </div>


                            <div class="flex-table-row-background">

                                <label>
                                    <input
                                        type="checkbox"
                                        class="flex-row-background-enabled"
                                        ${
                                            normalizeOptionalHexColor(
                                                row.background_color
                                                ?? ''
                                            )
                                            ? 'checked'
                                            : ''
                                        }
                                    >

                                    Apply Background to Entire Row
                                </label>


                                <input
                                    type="color"
                                    class="form-control flex-row-background-input"
                                    value="${escapeHtml(
                                        normalizeOptionalHexColor(
                                            row.background_color
                                            ?? ''
                                        )
                                        || '#ffffff'
                                    )}"
                                    title="Row background color"
                                >

                            </div>

                        </div>


                        <div class="flex-table-row-actions">

                            <div class="flex-table-cell-count-control">

                                <label>
                                    Cells
                                </label>


                                <input
                                    type="number"
                                    class="form-control flex-table-cell-count-input"
                                    min="0"
                                    max="30"
                                    step="1"
                                    value="${row.cells.length}"
                                    data-block-id="${blockId}"
                                    data-row-index="${rowIndex}"
                                    title="Set the number of cells in this row"
                                >

                            </div>

                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-primary
                                    flex-table-add-cell
                                "
                                data-block-id="${blockId}"
                                data-row-index="${rowIndex}"
                            >
                                + Cell
                            </button>


                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-secondary
                                    flex-table-move-row-up
                                "
                                data-block-id="${blockId}"
                                data-row-index="${rowIndex}"
                                ${
                                    rowIndex === 0
                                    ? 'disabled'
                                    : ''
                                }
                            >
                                ↑
                            </button>


                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-secondary
                                    flex-table-move-row-down
                                "
                                data-block-id="${blockId}"
                                data-row-index="${rowIndex}"
                                ${
                                    rowIndex === rowTotal - 1
                                    ? 'disabled'
                                    : ''
                                }
                            >
                                ↓
                            </button>


                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-danger
                                    flex-table-delete-row
                                "
                                data-block-id="${blockId}"
                                data-row-index="${rowIndex}"
                            >
                                Delete Row
                            </button>

                        </div>

                    </div>


                    <div class="flex-table-cells">

                        ${
                            row.cells.length

                            ? row.cells
                                .map(
                                    function (
                                        cell,
                                        cellIndex
                                    ) {

                                        return renderFlexibleTableCellEditor(

                                            blockId,

                                            cell,

                                            rowIndex,

                                            cellIndex,

                                            row.cells.length

                                        );

                                    }
                                )
                                .join('')

                            : `

                                <div class="flex-table-empty-row">

                                    No new cells in this Row.

                                    <br>

                                    This is valid when Row Span from
                                    previous rows fills 100%.

                                </div>

                            `
                        }

                    </div>

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Render Cell Editor
        |--------------------------------------------------------------------------
        */

        function renderFlexibleTableCellEditor(
            blockId,
            cell,
            rowIndex,
            cellIndex,
            cellTotal
        )
        {
            return `

                <div class="flex-table-cell-editor">

                    <input
                        type="hidden"
                        class="flex-cell-id"
                        value="${escapeHtml(
                            cell.id
                        )}"
                    >


                    <div class="flex-table-cell-header">

                        <strong>
                            Cell #${cellIndex + 1}
                        </strong>


                        <div class="flex-table-cell-actions">

                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-secondary
                                    flex-table-move-cell-left
                                "
                                data-block-id="${blockId}"
                                data-row-index="${rowIndex}"
                                data-cell-index="${cellIndex}"
                                ${
                                    cellIndex === 0
                                    ? 'disabled'
                                    : ''
                                }
                            >
                                ←
                            </button>


                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-secondary
                                    flex-table-move-cell-right
                                "
                                data-block-id="${blockId}"
                                data-row-index="${rowIndex}"
                                data-cell-index="${cellIndex}"
                                ${
                                    cellIndex === cellTotal - 1
                                    ? 'disabled'
                                    : ''
                                }
                            >
                                →
                            </button>


                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-danger
                                    flex-table-delete-cell
                                "
                                data-block-id="${blockId}"
                                data-row-index="${rowIndex}"
                                data-cell-index="${cellIndex}"
                            >
                                Delete Cell
                            </button>

                        </div>

                    </div>


                    <div class="form-group">

                        <label>
                            Content
                        </label>

                        <textarea
                            class="
                                form-control
                                flex-cell-field
                            "
                            data-field="content"
                            rows="2"
                        >${escapeHtml(
                            cell.content
                        )}</textarea>

                    </div>


                    <div class="row">

                        <div class="col-lg-3 col-md-6">

                            <div class="form-group">

                                <label>
                                    Width (%)
                                </label>

                                <input
                                    type="number"
                                    class="
                                        form-control
                                        flex-cell-field
                                    "
                                    data-field="width"
                                    min="0.5"
                                    max="100"
                                    step="0.5"
                                    value="${escapeHtml(
                                        cell.width
                                    )}"
                                >

                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="form-group">

                                <label>
                                    Row Span
                                </label>

                                <div class="input-group">

                                    <input
                                        type="number"
                                        class="
                                            form-control
                                            flex-cell-field
                                        "
                                        data-field="rowspan"
                                        min="1"
                                        max="20"
                                        step="1"
                                        value="${escapeHtml(
                                            cell.rowspan
                                        )}"
                                    >


                                    <div class="input-group-append">

                                        <span class="input-group-text">
                                            rows
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="form-group">

                                <label>
                                    Background
                                </label>

                                <div class="flex-table-color-control">

                                    <input
                                        type="color"
                                        class="
                                            form-control
                                            flex-cell-field
                                        "
                                        data-field="background_color"
                                        value="${escapeHtml(
                                            cell.background_color
                                        )}"
                                    >

                                    <code>
                                        ${escapeHtml(
                                            cell.background_color
                                        )}
                                    </code>

                                </div>

                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="form-group">

                                <label>
                                    Text Color
                                </label>

                                <div class="flex-table-color-control">

                                    <input
                                        type="color"
                                        class="
                                            form-control
                                            flex-cell-field
                                        "
                                        data-field="text_color"
                                        value="${escapeHtml(
                                            cell.text_color
                                        )}"
                                    >

                                    <code>
                                        ${escapeHtml(
                                            cell.text_color
                                        )}
                                    </code>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-lg-3 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>
                                    Text Align
                                </label>

                                <select
                                    class="
                                        form-control
                                        flex-cell-field
                                    "
                                    data-field="align"
                                >

                                    ${flexSelectOption(
                                        'left',
                                        'Left',
                                        cell.align
                                    )}

                                    ${flexSelectOption(
                                        'center',
                                        'Center',
                                        cell.align
                                    )}

                                    ${flexSelectOption(
                                        'right',
                                        'Right',
                                        cell.align
                                    )}

                                </select>

                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>
                                    Vertical Align
                                </label>

                                <select
                                    class="
                                        form-control
                                        flex-cell-field
                                    "
                                    data-field="vertical_align"
                                >

                                    ${flexSelectOption(
                                        'top',
                                        'Top',
                                        cell.vertical_align
                                    )}

                                    ${flexSelectOption(
                                        'middle',
                                        'Middle',
                                        cell.vertical_align
                                    )}

                                    ${flexSelectOption(
                                        'bottom',
                                        'Bottom',
                                        cell.vertical_align
                                    )}

                                </select>

                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label>
                                    Padding (px)
                                </label>

                                <input
                                    type="number"
                                    class="
                                        form-control
                                        flex-cell-field
                                    "
                                    data-field="padding"
                                    min="0"
                                    max="50"
                                    step="1"
                                    value="${escapeHtml(
                                        cell.padding
                                    )}"
                                >

                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="form-group mb-0">

                                <label class="d-block">
                                    Font
                                </label>


                                <div class="form-check mt-2">

                                    <input
                                        type="checkbox"
                                        class="
                                            form-check-input
                                            flex-cell-field
                                        "
                                        data-field="bold"
                                        ${
                                            cell.bold
                                            ? 'checked'
                                            : ''
                                        }
                                    >

                                    <label class="form-check-label">
                                        Bold
                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            `;
        }


        function flexSelectOption(
            value,
            label,
            current
        )
        {
            return `

                <option
                    value="${value}"
                    ${
                        value === current
                        ? 'selected'
                        : ''
                    }
                >
                    ${label}
                </option>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Build Table Grid Layout
        |--------------------------------------------------------------------------
        |
        | ตัวนี้คือหัวใจของ rowspan
        |
        | ตัวอย่าง:
        |
        | Row 1
        | 100%
        |
        | Row 2
        | 20% rowspan=2
        | 80%
        |
        | Row 3
        | inherited 20%
        | + 40%
        | + 40%
        |
        | = 100%
        |
        */

        function buildFlexibleTableLayout(
            data
        )
        {
            const placements =
                [];


            const rowMeta =
                [];


            /*
             * Cell จากแถวก่อน
             * ที่ยัง span ลงมาถึงแถวปัจจุบัน
             */
            const spans =
                [];


            const totalRows =
                data.rows.length;


            data.rows.forEach(
                function (
                    row,
                    rowIndex
                ) {

                    const inheritedSpans =
                        spans.filter(
                            span =>
                                span.startRow
                                <
                                rowIndex
                                &&
                                span.endRow
                                >=
                                rowIndex
                        );


                    const inheritedRanges =
                        inheritedSpans.map(
                            span => ({

                                start:
                                    span.start,

                                end:
                                    span.end,

                            })
                        );


                    const inheritedUnits =
                        sumOccupiedUnits(
                            inheritedRanges
                        );


                    const occupied =
                        inheritedRanges.map(
                            range => ({
                                ...range
                            })
                        );


                    let ownUnits =
                        0;


                    const errors =
                        [];


                    row.cells.forEach(
                        function (
                            cell,
                            cellIndex
                        ) {

                            const widthUnits =
                                percentToGridUnits(
                                    cell.width
                                );


                            const rowspan =
                                normalizeFlexRowspan(
                                    cell.rowspan
                                );


                            ownUnits +=
                                widthUnits;


                            /*
                             * Rowspan ห้ามเกินจำนวน Row
                             */
                            if (
                                rowIndex
                                +
                                rowspan
                                >
                                totalRows
                            ) {

                                errors.push(
                                    `Cell #${cellIndex + 1} Row Span exceeds the last row.`
                                );

                            }


                            const start =
                                findFirstFreeGridPosition(

                                    occupied,

                                    widthUnits

                                );


                            if (
                                start === null
                            ) {

                                errors.push(
                                    `Cell #${cellIndex + 1} cannot fit because of Row Span from previous rows.`
                                );

                                return;

                            }


                            const end =
                                start
                                +
                                widthUnits;


                            occupied.push({

                                start:
                                    start,

                                end:
                                    end,

                            });


                            placements.push({

                                rowIndex:
                                    rowIndex,

                                cellIndex:
                                    cellIndex,

                                cell:
                                    cell,

                                startUnit:
                                    start,

                                widthUnits:
                                    widthUnits,

                                rowspan:
                                    rowspan,

                            });


                            if (
                                rowspan > 1
                            ) {

                                spans.push({

                                    start:
                                        start,

                                    end:
                                        end,

                                    startRow:
                                        rowIndex,

                                    endRow:
                                        rowIndex
                                        +
                                        rowspan
                                        -
                                        1,

                                });

                            }

                        }
                    );


                    const coverageUnits =
                        sumOccupiedUnits(
                            occupied
                        );


                    if (
                        coverageUnits
                        !==
                        FLEX_TABLE_TOTAL_UNITS
                    ) {

                        errors.push(
                            `Row coverage is ${unitsToPercent(
                                coverageUnits
                            )}%. It must be 100%.`
                        );

                    }


                    rowMeta.push({

                        inheritedWidth:
                            unitsToPercent(
                                inheritedUnits
                            ),

                        ownWidth:
                            unitsToPercent(
                                ownUnits
                            ),

                        coverageWidth:
                            unitsToPercent(
                                coverageUnits
                            ),

                        valid:
                            errors.length === 0,

                        errors:
                            errors,

                    });

                }
            );


            return {

                placements:
                    placements,

                rowMeta:
                    rowMeta,

                valid:
                    rowMeta.every(
                        meta =>
                            meta.valid
                    ),

            };
        }


        /*
        |--------------------------------------------------------------------------
        | Find Free Space
        |--------------------------------------------------------------------------
        */

        function findFirstFreeGridPosition(
            occupied,
            widthUnits
        )
        {
            if (
                widthUnits <= 0
                ||
                widthUnits
                >
                FLEX_TABLE_TOTAL_UNITS
            ) {

                return null;

            }


            const ranges =
                occupied
                    .map(
                        range => ({
                            ...range
                        })
                    )
                    .sort(
                        (
                            a,
                            b
                        ) =>
                            a.start
                            -
                            b.start
                    );


            let candidate =
                0;


            for (
                const range
                of ranges
            ) {

                if (
                    candidate
                    +
                    widthUnits
                    <=
                    range.start
                ) {

                    return candidate;

                }


                candidate =
                    Math.max(
                        candidate,
                        range.end
                    );

            }


            if (
                candidate
                +
                widthUnits
                <=
                FLEX_TABLE_TOTAL_UNITS
            ) {

                return candidate;

            }


            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Sum Occupied
        |--------------------------------------------------------------------------
        */

        function sumOccupiedUnits(
            ranges
        )
        {
            if (
                !ranges.length
            ) {

                return 0;

            }


            const sorted =
                ranges
                    .map(
                        range => ({
                            ...range
                        })
                    )
                    .sort(
                        (
                            a,
                            b
                        ) =>
                            a.start
                            -
                            b.start
                    );


            let total =
                0;


            let currentStart =
                sorted[0].start;


            let currentEnd =
                sorted[0].end;


            for (
                let index = 1;
                index < sorted.length;
                index++
            ) {

                const range =
                    sorted[
                        index
                    ];


                if (
                    range.start
                    <=
                    currentEnd
                ) {

                    currentEnd =
                        Math.max(
                            currentEnd,
                            range.end
                        );

                    continue;

                }


                total +=
                    currentEnd
                    -
                    currentStart;


                currentStart =
                    range.start;


                currentEnd =
                    range.end;

            }


            total +=
                currentEnd
                -
                currentStart;


            return total;
        }


        /*
        |--------------------------------------------------------------------------
        | Bind Flexible Table
        |--------------------------------------------------------------------------
        */

        function bindFlexibleTableEditors()
        {
            /*
             * Set Row Count
             */
            document
                .querySelectorAll(
                    '.flex-table-row-count-input'
                )
                .forEach(
                    function (input) {

                        const applyRowCount =
                            function () {

                                resizeFlexibleTableRows(

                                    input.dataset
                                        .blockId,

                                    input.value,

                                    input

                                );

                            };


                        input.onchange =
                            applyRowCount;


                        input.onkeydown =
                            function (event) {

                                if (
                                    event.key
                                    === 'Enter'
                                ) {

                                    event.preventDefault();

                                    applyRowCount();

                                }

                            };

                    }
                );


            /*
             * Add Row
             */
            document
                .querySelectorAll(
                    '.flex-table-add-row'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const blockId =
                                    this.dataset
                                        .blockId;


                                const data =
                                    collectFlexibleTableData(
                                        blockId
                                    );


                                if (
                                    data.rows.length
                                    >= 100
                                ) {

                                    alert(
                                        'A table can contain up to 100 Rows.'
                                    );

                                    return;

                                }


                                data.rows.push({

                                    id:
                                        generateFlexRowId(),

                                    height:
                                        0,

                                    background_color:
                                        '',

                                    cells:
                                        [],

                                });


                                /*
                                 * ดูก่อนว่า Rowspan จากด้านบนกินกี่ %
                                 */
                                const layoutInfo =
                                    buildFlexibleTableLayout(
                                        data
                                    );


                                const rowIndex =
                                    data.rows.length - 1;


                                const inherited =
                                    layoutInfo
                                        .rowMeta[
                                            rowIndex
                                        ]
                                        ?.inheritedWidth
                                    ?? 0;


                                const available =
                                    100
                                    -
                                    inherited;


                                /*
                                 * ถ้ายังมีพื้นที่
                                 * สร้าง Cell ให้เติมพื้นที่ที่เหลือ
                                 */
                                if (
                                    available > 0
                                ) {

                                    data
                                        .rows[
                                            rowIndex
                                        ]
                                        .cells
                                        .push(
                                            defaultFlexibleCell(
                                                available
                                            )
                                        );

                                }


                                rerenderFlexibleTable(
                                    blockId,
                                    data
                                );

                            };

                    }
                );


            /*
             * Set Cell Count
             */
            document
                .querySelectorAll(
                    '.flex-table-cell-count-input'
                )
                .forEach(
                    function (input) {

                        const applyCellCount =
                            function () {

                                resizeFlexibleTableRowCells(

                                    input.dataset
                                        .blockId,

                                    Number(
                                        input.dataset
                                            .rowIndex
                                    ),

                                    input.value,

                                    input

                                );

                            };


                        input.onchange =
                            applyCellCount;


                        input.onkeydown =
                            function (event) {

                                if (
                                    event.key
                                    === 'Enter'
                                ) {

                                    event.preventDefault();

                                    applyCellCount();

                                }

                            };

                    }
                );


            /*
             * Add Cell
             */
            document
                .querySelectorAll(
                    '.flex-table-add-cell'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const blockId =
                                    this.dataset
                                        .blockId;


                                const rowIndex =
                                    Number(
                                        this.dataset
                                            .rowIndex
                                    );


                                const data =
                                    collectFlexibleTableData(
                                        blockId
                                    );


                                const row =
                                    data.rows[
                                        rowIndex
                                    ];


                                if (
                                    !row
                                ) {

                                    return;

                                }


                                if (
                                    row.cells.length
                                    >= 30
                                ) {

                                    alert(
                                        'A Row can contain up to 30 Cells.'
                                    );

                                    return;

                                }


                                const layoutInfo =
                                    buildFlexibleTableLayout(
                                        data
                                    );


                                const inherited =
                                    layoutInfo
                                        .rowMeta[
                                            rowIndex
                                        ]
                                        ?.inheritedWidth
                                    ?? 0;


                                const available =
                                    Math.max(
                                        0,
                                        100
                                        -
                                        inherited
                                    );


                                if (
                                    available <= 0
                                ) {

                                    alert(
                                        'This Row is already fully occupied by Row Span from previous rows.'
                                    );

                                    return;

                                }


                                const cellCount =
                                    row.cells.length
                                    +
                                    1;


                                const widths =
                                    distributeWidthUnits(

                                        percentToGridUnits(
                                            available
                                        ),

                                        cellCount

                                    );


                                row.cells.forEach(
                                    function (
                                        cell,
                                        index
                                    ) {

                                        cell.width =
                                            unitsToPercent(
                                                widths[
                                                    index
                                                ]
                                            );

                                    }
                                );


                                row.cells.push(
                                    defaultFlexibleCell(
                                        unitsToPercent(
                                            widths[
                                                cellCount - 1
                                            ]
                                        )
                                    )
                                );


                                rerenderFlexibleTable(
                                    blockId,
                                    data
                                );

                            };

                    }
                );


            /*
             * Delete Row
             */
            document
                .querySelectorAll(
                    '.flex-table-delete-row'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                if (
                                    !confirm(
                                        'Delete this Row?'
                                    )
                                ) {

                                    return;

                                }


                                const blockId =
                                    this.dataset
                                        .blockId;


                                const data =
                                    collectFlexibleTableData(
                                        blockId
                                    );


                                data.rows.splice(

                                    Number(
                                        this.dataset
                                            .rowIndex
                                    ),

                                    1

                                );


                                rerenderFlexibleTable(
                                    blockId,
                                    data
                                );

                            };

                    }
                );


            /*
             * Delete Cell
             */
            document
                .querySelectorAll(
                    '.flex-table-delete-cell'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const blockId =
                                    this.dataset
                                        .blockId;


                                const rowIndex =
                                    Number(
                                        this.dataset
                                            .rowIndex
                                    );


                                const cellIndex =
                                    Number(
                                        this.dataset
                                            .cellIndex
                                    );


                                const data =
                                    collectFlexibleTableData(
                                        blockId
                                    );


                                const row =
                                    data.rows[
                                        rowIndex
                                    ];


                                if (
                                    !row
                                ) {

                                    return;

                                }


                                row.cells.splice(
                                    cellIndex,
                                    1
                                );


                                /*
                                 * หา available width
                                 * ที่ไม่โดน rowspan จากด้านบน
                                 */
                                const layoutInfo =
                                    buildFlexibleTableLayout(
                                        data
                                    );


                                const inherited =
                                    layoutInfo
                                        .rowMeta[
                                            rowIndex
                                        ]
                                        ?.inheritedWidth
                                    ?? 0;


                                const available =
                                    Math.max(
                                        0,
                                        100
                                        -
                                        inherited
                                    );


                                if (
                                    row.cells.length > 0
                                ) {

                                    const widths =
                                        distributeWidthUnits(

                                            percentToGridUnits(
                                                available
                                            ),

                                            row.cells.length

                                        );


                                    row.cells.forEach(
                                        function (
                                            cell,
                                            index
                                        ) {

                                            cell.width =
                                                unitsToPercent(
                                                    widths[
                                                        index
                                                    ]
                                                );

                                        }
                                    );

                                }


                                rerenderFlexibleTable(
                                    blockId,
                                    data
                                );

                            };

                    }
                );


            bindFlexMoveButtons(

                '.flex-table-move-row-up',

                -1,

                'row'

            );


            bindFlexMoveButtons(

                '.flex-table-move-row-down',

                1,

                'row'

            );


            bindFlexMoveButtons(

                '.flex-table-move-cell-left',

                -1,

                'cell'

            );


            bindFlexMoveButtons(

                '.flex-table-move-cell-right',

                1,

                'cell'

            );


            /*
             * Live Preview
             */
            document
                .querySelectorAll(
                    '.flex-table-editor input, .flex-table-editor textarea, .flex-table-editor select'
                )
                .forEach(
                    function (field) {

                        if (
                            field.dataset
                                .flexBound
                            === '1'
                        ) {

                            return;

                        }


                        field.dataset
                            .flexBound =
                                '1';


                        const refresh =
                            function () {

                                if (
                                    field.classList.contains(
                                        'flex-row-background-input'
                                    )
                                ) {

                                    const rowEditor =
                                        field.closest(
                                            '.flex-table-row-editor'
                                        );


                                    const enabled =
                                        rowEditor
                                            ?.querySelector(
                                                '.flex-row-background-enabled'
                                            );


                                    if (
                                        enabled
                                    ) {

                                        enabled.checked =
                                            true;

                                    }

                                }

                                const editor =
                                    field.closest(
                                        '.flex-table-editor'
                                    );


                                if (
                                    editor
                                ) {

                                    updateFlexibleTableLiveState(
                                        editor.dataset
                                            .flexTableBlock
                                    );

                                }

                            };


                        field.addEventListener(
                            'input',
                            refresh
                        );


                        field.addEventListener(
                            'change',
                            refresh
                        );

                    }
                );


            document
                .querySelectorAll(
                    '.flex-table-editor'
                )
                .forEach(
                    function (editor) {

                        updateFlexibleTableLiveState(
                            editor.dataset
                                .flexTableBlock
                        );

                    }
                );
        }


        function resizeFlexibleTableRows(
            blockId,
            requestedCount,
            input
        )
        {
            const data =
                collectFlexibleTableData(
                    blockId
                );


            const currentCount =
                data.rows.length;


            const desiredCount =
                Math.min(
                    100,
                    Math.max(
                        1,
                        Math.round(
                            Number(
                                requestedCount
                            )
                            || 1
                        )
                    )
                );


            if (
                desiredCount
                === currentCount
            ) {

                if (
                    input
                ) {

                    input.value =
                        currentCount;

                }


                return;

            }


            if (
                desiredCount
                < currentCount
                &&
                !window.confirm(
                    `Reduce this table from ${currentCount} to ${desiredCount} rows? Removed row content cannot be restored after saving.`
                )
            ) {

                if (
                    input
                ) {

                    input.value =
                        currentCount;

                }


                return;

            }


            if (
                desiredCount
                < currentCount
            ) {

                data.rows =
                    data.rows.slice(
                        0,
                        desiredCount
                    );


                data.rows.forEach(
                    function (
                        row,
                        rowIndex
                    ) {

                        const remainingRows =
                            desiredCount
                            - rowIndex;


                        row.cells.forEach(
                            function (cell) {

                                cell.rowspan =
                                    Math.min(
                                        normalizeFlexRowspan(
                                            cell.rowspan
                                        ),
                                        remainingRows
                                    );

                            }
                        );

                    }
                );

            }


            while (
                data.rows.length
                < desiredCount
            ) {

                data.rows.push({

                    id:
                        generateFlexRowId(),

                    height:
                        0,

                    background_color:
                        '',

                    cells:
                        [],

                });


                const rowIndex =
                    data.rows.length
                    - 1;


                const layoutInfo =
                    buildFlexibleTableLayout(
                        data
                    );


                const inherited =
                    layoutInfo
                        .rowMeta[
                            rowIndex
                        ]
                        ?.inheritedWidth
                    ?? 0;


                const available =
                    Math.max(
                        0,
                        100
                        - inherited
                    );


                if (
                    available > 0
                ) {

                    data.rows[
                        rowIndex
                    ]
                    .cells
                    .push(
                        defaultFlexibleCell(
                            available
                        )
                    );

                }

            }


            rerenderFlexibleTable(
                blockId,
                data
            );
        }

        function resizeFlexibleTableRowCells(
            blockId,
            rowIndex,
            requestedCount,
            input
        )
        {
            const data =
                collectFlexibleTableData(
                    blockId
                );


            const row =
                data.rows[
                    rowIndex
                ];


            if (
                !row
            ) {

                return;

            }


            const currentCount =
                row.cells.length;


            const desiredCount =
                Math.min(
                    30,
                    Math.max(
                        0,
                        Math.round(
                            Number(
                                requestedCount
                            )
                            || 0
                        )
                    )
                );


            if (
                desiredCount
                === currentCount
            ) {

                if (
                    input
                ) {

                    input.value =
                        currentCount;

                }


                return;

            }


            if (
                desiredCount
                < currentCount
                &&
                !window.confirm(
                    `Reduce this row from ${currentCount} to ${desiredCount} cells? Removed cell content cannot be restored after saving.`
                )
            ) {

                if (
                    input
                ) {

                    input.value =
                        currentCount;

                }


                return;

            }


            const layoutInfo =
                buildFlexibleTableLayout(
                    data
                );


            const inherited =
                layoutInfo
                    .rowMeta[
                        rowIndex
                    ]
                    ?.inheritedWidth
                ?? 0;


            const available =
                Math.max(
                    0,
                    100
                    - inherited
                );


            if (
                desiredCount > 0
                &&
                available <= 0
            ) {

                alert(
                    'This Row is already fully occupied by Row Span from previous rows.'
                );


                if (
                    input
                ) {

                    input.value =
                        currentCount;

                }


                return;

            }


            row.cells =
                row.cells.slice(
                    0,
                    desiredCount
                );


            while (
                row.cells.length
                < desiredCount
            ) {

                row.cells.push(
                    defaultFlexibleCell(
                        100
                    )
                );

            }


            if (
                desiredCount > 0
            ) {

                const widths =
                    distributeWidthUnits(

                        percentToGridUnits(
                            available
                        ),

                        desiredCount

                    );


                row.cells.forEach(
                    function (
                        cell,
                        index
                    ) {

                        cell.width =
                            unitsToPercent(
                                widths[
                                    index
                                ]
                            );

                    }
                );

            }


            rerenderFlexibleTable(
                blockId,
                data
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Move
        |--------------------------------------------------------------------------
        */

        function bindFlexMoveButtons(
            selector,
            direction,
            type
        )
        {
            document
                .querySelectorAll(
                    selector
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const blockId =
                                    this.dataset
                                        .blockId;


                                const rowIndex =
                                    Number(
                                        this.dataset
                                            .rowIndex
                                    );


                                const data =
                                    collectFlexibleTableData(
                                        blockId
                                    );


                                if (
                                    type === 'row'
                                ) {

                                    const newIndex =
                                        rowIndex
                                        +
                                        direction;


                                    if (
                                        newIndex < 0
                                        ||
                                        newIndex >= data.rows.length
                                    ) {

                                        return;

                                    }


                                    [
                                        data.rows[
                                            rowIndex
                                        ],
                                        data.rows[
                                            newIndex
                                        ]
                                    ] = [
                                        data.rows[
                                            newIndex
                                        ],
                                        data.rows[
                                            rowIndex
                                        ]
                                    ];

                                } else {

                                    const row =
                                        data.rows[
                                            rowIndex
                                        ];


                                    if (
                                        !row
                                    ) {

                                        return;

                                    }


                                    const cellIndex =
                                        Number(
                                            this.dataset
                                                .cellIndex
                                        );


                                    const newIndex =
                                        cellIndex
                                        +
                                        direction;


                                    if (
                                        newIndex < 0
                                        ||
                                        newIndex >= row.cells.length
                                    ) {

                                        return;

                                    }


                                    [
                                        row.cells[
                                            cellIndex
                                        ],
                                        row.cells[
                                            newIndex
                                        ]
                                    ] = [
                                        row.cells[
                                            newIndex
                                        ],
                                        row.cells[
                                            cellIndex
                                        ]
                                    ];

                                }


                                rerenderFlexibleTable(
                                    blockId,
                                    data
                                );

                            };

                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Collect Table Data
        |--------------------------------------------------------------------------
        */

        function collectFlexibleTableData(
            blockId
        )
        {
            const editor =
                document.querySelector(
                    `[data-flex-table-block="${blockId}"]`
                );


            const result = {

                title:
                    '',

                rows:
                    [],

            };


            if (
                !editor
            ) {

                return result;

            }


            result.title =
                editor
                    .querySelector(
                        '.flex-table-title'
                    )
                    ?.value
                ?? '';


            editor
                .querySelectorAll(
                    '.flex-table-row-editor'
                )
                .forEach(
                    function (rowElement) {

                        const row = {

                            id:
                                rowElement
                                    .querySelector(
                                        '.flex-row-id'
                                    )
                                    ?.value
                                ||
                                generateFlexRowId(),

                            height:
                                normalizeFlexRowHeight(
                                    rowElement
                                        .querySelector(
                                            '.flex-row-height-input'
                                        )
                                        ?.value
                                    ?? 0
                                ),

                            background_color:
                                rowElement
                                    .querySelector(
                                        '.flex-row-background-enabled'
                                    )
                                    ?.checked
                                    ? normalizeHexColor(
                                        rowElement
                                            .querySelector(
                                                '.flex-row-background-input'
                                            )
                                            ?.value,
                                        '#ffffff'
                                    )
                                    : '',

                            cells:
                                [],

                        };


                        rowElement
                            .querySelectorAll(
                                '.flex-table-cell-editor'
                            )
                            .forEach(
                                function (cellElement) {

                                    const cell =
                                        defaultFlexibleCell(
                                            100
                                        );


                                    cell.id =
                                        cellElement
                                            .querySelector(
                                                '.flex-cell-id'
                                            )
                                            ?.value
                                        ||
                                        generateFlexCellId();


                                    cellElement
                                        .querySelectorAll(
                                            '.flex-cell-field'
                                        )
                                        .forEach(
                                            function (field) {

                                                const key =
                                                    field.dataset
                                                        .field;


                                                if (
                                                    !key
                                                ) {

                                                    return;

                                                }


                                                let value;


                                                if (
                                                    field.type
                                                    === 'checkbox'
                                                ) {

                                                    value =
                                                        field.checked;

                                                } else {

                                                    value =
                                                        field.value;

                                                }


                                                switch (
                                                    key
                                                ) {

                                                    case 'width':

                                                        value =
                                                            normalizeFlexWidth(
                                                                value
                                                            );

                                                        break;


                                                    case 'rowspan':

                                                        value =
                                                            normalizeFlexRowspan(
                                                                value
                                                            );

                                                        break;


                                                    case 'padding':

                                                        value =
                                                            normalizeFlexPadding(
                                                                value
                                                            );

                                                        break;


                                                    case 'background_color':

                                                        value =
                                                            normalizeHexColor(
                                                                value,
                                                                '#ffffff'
                                                            );

                                                        break;


                                                    case 'text_color':

                                                        value =
                                                            normalizeHexColor(
                                                                value,
                                                                '#000000'
                                                            );

                                                        break;

                                                }


                                                cell[
                                                    key
                                                ] =
                                                    value;

                                            }
                                        );


                                    row.cells.push(
                                        normalizeFlexibleTableCell(
                                            cell
                                        )
                                    );

                                }
                            );


                        result.rows.push(
                            row
                        );

                    }
                );


            return result;
        }


        /*
        |--------------------------------------------------------------------------
        | Rerender Table
        |--------------------------------------------------------------------------
        */

        function rerenderFlexibleTable(
            blockId,
            data
        )
        {
            const editor =
                document.querySelector(
                    `[data-flex-table-block="${blockId}"]`
                );


            if (
                !editor
            ) {

                return;

            }


            editor.innerHTML =
                renderFlexibleTableInner(
                    blockId,
                    data
                );


            bindFlexibleTableEditors();
        }


        /*
        |--------------------------------------------------------------------------
        | Live Table State
        |--------------------------------------------------------------------------
        */

        function updateFlexibleTableLiveState(
            blockId
        )
        {
            const editor =
                document.querySelector(
                    `[data-flex-table-block="${blockId}"]`
                );


            if (
                !editor
            ) {

                return;

            }


            const data =
                collectFlexibleTableData(
                    blockId
                );


            const tableLayout =
                buildFlexibleTableLayout(
                    data
                );


            editor
                .querySelectorAll(
                    '.flex-table-row-editor'
                )
                .forEach(
                    function (
                        rowElement,
                        rowIndex
                    ) {

                        const meta =
                            tableLayout
                                .rowMeta[
                                    rowIndex
                                ];


                        const status =
                            rowElement.querySelector(
                                '.flex-table-row-width-status'
                            );


                        const detail =
                            rowElement.querySelector(
                                '.flex-table-row-detail'
                            );


                        if (
                            !meta
                            ||
                            !status
                        ) {

                            return;

                        }


                        status.className =
                            `${
                                meta.valid
                                ? 'flex-table-width-ok'
                                : 'flex-table-width-error'
                            } flex-table-row-width-status`;


                        status.textContent =
                            formatFlexibleRowStatus(

                                meta.inheritedWidth,

                                meta.ownWidth,

                                meta.coverageWidth,

                                meta.valid

                            );


                        if (
                            detail
                        ) {

                            detail.textContent =
                                meta.inheritedWidth > 0

                                ? `Row Span from above: ${formatPercentNumber(
                                    meta.inheritedWidth
                                )}%`

                                : 'No Row Span from above';

                        }

                    }
                );


            /*
             * Update color code
             */
            editor
                .querySelectorAll(
                    '.flex-table-color-control'
                )
                .forEach(
                    function (control) {

                        const input =
                            control.querySelector(
                                'input[type="color"]'
                            );


                        const code =
                            control.querySelector(
                                'code'
                            );


                        if (
                            input
                            &&
                            code
                        ) {

                            code.textContent =
                                input.value;

                        }

                    }
                );


            renderFlexibleTablePreview(
                blockId,
                data,
                tableLayout
            );
        }


        function formatFlexibleRowStatus(
            inherited,
            own,
            coverage,
            valid
        )
        {
            if (
                inherited > 0
            ) {

                return (

                    `${formatPercentNumber(
                        own
                    )}% + Row Span ${formatPercentNumber(
                        inherited
                    )}% = ${formatPercentNumber(
                        coverage
                    )}% ${valid ? '✓' : '⚠'}`

                );

            }


            return (

                `Width: ${formatPercentNumber(
                    coverage
                )}% ${valid ? '✓' : '⚠'}`

            );
        }


        /*
        |--------------------------------------------------------------------------
        | Table Preview
        |--------------------------------------------------------------------------
        */

        function renderFlexibleTablePreview(
            blockId,
            data,
            tableLayout = null
        )
        {
            const preview =
                document.querySelector(
                    `[data-flex-table-preview="${blockId}"]`
                );


            if (
                !preview
            ) {

                return;

            }


            if (
                !data.rows.length
            ) {

                preview.innerHTML = `

                    <div class="text-muted text-center">

                        No rows.

                    </div>

                `;

                return;

            }


            tableLayout ??=
                buildFlexibleTableLayout(
                    data
                );


            const errorMessages =
                [];


            tableLayout
                .rowMeta
                .forEach(
                    function (
                        meta,
                        rowIndex
                    ) {

                        meta.errors.forEach(
                            function (error) {

                                errorMessages.push(
                                    `Row #${rowIndex + 1}: ${error}`
                                );

                            }
                        );

                    }
                );


            preview.innerHTML = `

                ${
                    errorMessages.length

                    ? `

                        <div
                            class="
                                alert
                                alert-warning
                                flex-table-preview-error
                            "
                        >

                            ${errorMessages
                                .map(
                                    error => `

                                        <div>
                                            ${escapeHtml(
                                                error
                                            )}
                                        </div>

                                    `
                                )
                                .join('')
                            }

                        </div>

                    `

                    : ''
                }


                ${
                    data.title

                    ? `

                        <div class="flex-table-preview-title">

                            ${escapeHtml(
                                data.title
                            )}

                        </div>

                    `

                    : ''
                }


                <div
                    class="flex-table-grid"
                    style="grid-template-rows: ${data.rows
                        .map(
                            row => {

                                const height =
                                    normalizeFlexRowHeight(
                                        row.height
                                        ?? 0
                                    );


                                return height > 0
                                    ? `minmax(${height}px, auto)`
                                    : 'auto';

                            }
                        )
                        .join(' ')};"
                >

                    ${tableLayout
                        .placements
                        .map(
                            function (placement) {

                                const cell =
                                    placement.cell;


                                return `

                                    <div
                                        class="flex-table-preview-cell"
                                        style="
                                            grid-column:
                                                ${placement.startUnit + 1}
                                                /
                                                span
                                                ${placement.widthUnits};

                                            grid-row:
                                                ${placement.rowIndex + 1}
                                                /
                                                span
                                                ${placement.rowspan};

                                            background:
                                                ${escapeHtml(
                                                    data.rows[
                                                        placement.rowIndex
                                                    ]?.background_color
                                                    ||
                                                    cell.background_color
                                                )};

                                            color:
                                                ${escapeHtml(
                                                    cell.text_color
                                                )};

                                            text-align:
                                                ${escapeHtml(
                                                    cell.align
                                                )};

                                            align-items:
                                                ${flexVerticalCss(
                                                    cell.vertical_align
                                                )};

                                            justify-content:
                                                ${flexHorizontalCss(
                                                    cell.align
                                                )};

                                            padding:
                                                ${normalizeFlexPadding(
                                                    cell.padding
                                                )}px;

                                            font-weight:
                                                ${cell.bold ? '700' : '400'};
                                        "
                                    >

                                        <div class="flex-table-preview-cell-inner">

                                            ${formatMultiline(
                                                cell.content
                                            )}

                                        </div>

                                    </div>

                                `;

                            }
                        )
                        .join('')
                    }

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Table
        |--------------------------------------------------------------------------
        */

        function validateFlexibleTables()
        {
            let error =
                null;


            document
                .querySelectorAll(
                    '.flex-table-editor'
                )
                .forEach(
                    function (editor) {

                        if (
                            error
                        ) {

                            return;

                        }


                        const blockId =
                            editor.dataset
                                .flexTableBlock;


                        const data =
                            collectFlexibleTableData(
                                blockId
                            );


                        if (
                            !data.rows.length
                        ) {

                            error =
                                `Custom Table ${blockId} must have at least one Row.`;

                            return;

                        }


                        const tableLayout =
                            buildFlexibleTableLayout(
                                data
                            );


                        tableLayout
                            .rowMeta
                            .forEach(
                                function (
                                    meta,
                                    rowIndex
                                ) {

                                    if (
                                        error
                                        ||
                                        meta.valid
                                    ) {

                                        return;

                                    }


                                    error =
                                        `Custom Table Row #${rowIndex + 1}: ${meta.errors.join(' ')}`;

                                }
                            );

                    }
                );


            return error;
        }


        /*
        |--------------------------------------------------------------------------
        | Width Helpers
        |--------------------------------------------------------------------------
        */

        function percentToGridUnits(
            value
        )
        {
            const width =
                normalizeFlexWidth(
                    value
                );


            return Math.max(

                1,

                Math.min(

                    FLEX_TABLE_TOTAL_UNITS,

                    Math.round(
                        width
                        *
                        2
                    )

                )

            );
        }


        function unitsToPercent(
            units
        )
        {
            return (
                Number(
                    units
                )
                /
                2
            );
        }


        function distributeWidthUnits(
            totalUnits,
            count
        )
        {
            if (
                count <= 0
            ) {

                return [];

            }


            const base =
                Math.floor(
                    totalUnits
                    /
                    count
                );


            let remainder =
                totalUnits
                -
                (
                    base
                    *
                    count
                );


            const result =
                new Array(
                    count
                )
                .fill(
                    base
                );


            let index =
                0;


            while (
                remainder > 0
            ) {

                result[
                    index
                ]++;


                remainder--;


                index =
                    (
                        index
                        +
                        1
                    )
                    %
                    count;

            }


            return result;
        }


        function calculateOwnFlexibleRowWidth(
            row
        )
        {
            return (
                row.cells
                ?? []
            )
            .reduce(
                function (
                    total,
                    cell
                ) {

                    return total
                        +
                        Number(
                            cell.width
                            ?? 0
                        );

                },
                0
            );
        }


        function normalizeFlexWidth(
            value
        )
        {
            let number =
                Number(
                    value
                );


            if (
                !Number.isFinite(
                    number
                )
            ) {

                number =
                    100;

            }


            /*
             * 0.5% step
             */
            number =
                Math.round(
                    number
                    *
                    2
                )
                /
                2;


            return Math.min(

                100,

                Math.max(
                    0.5,
                    number
                )

            );
        }


        function normalizeFlexRowspan(
            value
        )
        {
            let number =
                Number(
                    value
                );


            if (
                !Number.isFinite(
                    number
                )
            ) {

                number =
                    1;

            }


            return Math.min(

                20,

                Math.max(
                    1,
                    Math.round(
                        number
                    )
                )

            );
        }


        function normalizeFlexPadding(
            value
        )
        {
            let number =
                Number(
                    value
                );


            if (
                !Number.isFinite(
                    number
                )
            ) {

                number =
                    8;

            }


            return Math.min(

                50,

                Math.max(
                    0,
                    Math.round(
                        number
                    )
                )

            );
        }


        function normalizeFlexRowHeight(
            value
        )
        {
            let number =
                Number(
                    value
                );


            if (
                !Number.isFinite(
                    number
                )
            ) {

                number =
                    0;

            }


            return Math.min(

                1000,

                Math.max(
                    0,
                    Math.round(
                        number
                    )
                )

            );
        }


        function normalizeHexColor(
            value,
            fallback
        )
        {
            const color =
                String(
                    value
                    ?? ''
                )
                .trim();


            return /^#[0-9A-Fa-f]{6}$/.test(
                color
            )
                ? color.toLowerCase()
                : fallback;
        }


        function normalizeOptionalHexColor(
            value
        )
        {
            const color =
                String(
                    value
                    ?? ''
                )
                .trim()
                .toLowerCase();


            return /^#[0-9a-f]{6}$/.test(
                color
            )
                ? color
                : '';
        }


        function flexVerticalCss(
            value
        )
        {
            if (
                value === 'top'
            ) {

                return 'flex-start';

            }


            if (
                value === 'bottom'
            ) {

                return 'flex-end';

            }


            return 'center';
        }


        function flexHorizontalCss(
            value
        )
        {
            if (
                value === 'left'
            ) {

                return 'flex-start';

            }


            if (
                value === 'right'
            ) {

                return 'flex-end';

            }


            return 'center';
        }


        function formatPercentNumber(
            value
        )
        {
            const number =
                Number(
                    value
                );


            if (
                !Number.isFinite(
                    number
                )
            ) {

                return '0';

            }


            return Number.isInteger(
                number
            )
                ? String(
                    number
                )
                : number
                    .toFixed(
                        1
                    )
                    .replace(
                        /\.0$/,
                        ''
                    );
        }


        function generateFlexRowId()
        {
            return (

                'table_row_'

                +
                Date.now()

                +
                '_'

                +
                Math
                    .random()
                    .toString(36)
                    .substring(
                        2,
                        9
                    )

            );
        }


        function generateFlexCellId()
        {
            return (

                'table_cell_'

                +
                Date.now()

                +
                '_'

                +
                Math
                    .random()
                    .toString(36)
                    .substring(
                        2,
                        9
                    )

            );
        }


        /*
        |--------------------------------------------------------------------------
        | Gallery
        |--------------------------------------------------------------------------
        */

        function galleryEditor(
            block,
            content
        )
        {
            const images =
                Array.isArray(
                    content.images
                )
                    ? content.images
                    : [];


            return `

                <div class="form-group mb-0">

                    <label>
                        Product Images
                    </label>


                    <div
                        class="gallery-list"
                        data-block-id="${block.id}"
                    >

                        ${images
                            .map(
                                image =>
                                    galleryImageRow(
                                        block.id,
                                        image
                                    )
                            )
                            .join('')
                        }

                    </div>


                    <div
                        class="
                            gallery-empty
                            ${
                                images.length
                                ? 'd-none'
                                : ''
                            }
                        "
                        data-empty-block="${block.id}"
                    >

                        🖼

                        <br>

                        No images uploaded

                    </div>


                    <div class="mt-3">

                        <input
                            type="file"
                            id="gallery-upload-${block.id}"
                            class="
                                gallery-file-input
                                d-none
                            "
                            data-block-id="${block.id}"
                            accept="
                                image/jpeg,
                                image/png,
                                image/webp,
                                image/gif
                            "
                            multiple
                        >


                        <button
                            type="button"
                            class="
                                btn
                                btn-sm
                                btn-outline-primary
                                upload-gallery-images
                            "
                            data-block-id="${block.id}"
                        >
                            + Upload Images
                        </button>


                        <span
                            class="
                                gallery-upload-status
                                ml-2
                                text-muted
                            "
                            data-status-block="${block.id}"
                        ></span>

                    </div>

                </div>

            `;
        }


        function galleryImageRow(
            blockId,
            url
        )
        {
            return `

                <div class="gallery-image-row">

                    <div class="gallery-image-preview">

                        <img
                            src="${escapeHtml(
                                url
                            )}"
                            alt=""
                        >

                    </div>


                    <div class="gallery-image-info">

                        <div class="gallery-image-name">

                            ${escapeHtml(
                                getFileNameFromUrl(
                                    url
                                )
                            )}

                        </div>


                        <div class="gallery-image-url">

                            ${escapeHtml(
                                url
                            )}

                        </div>


                        <input
                            type="hidden"
                            class="gallery-image"
                            value="${escapeHtml(
                                url
                            )}"
                        >

                    </div>


                    <button
                        type="button"
                        class="
                            btn
                            btn-sm
                            btn-outline-danger
                            remove-gallery-image
                        "
                    >
                        ×
                    </button>

                </div>

            `;
        }


        function bindGalleryButtons()
        {
            document
                .querySelectorAll(
                    '.upload-gallery-images'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                document
                                    .getElementById(
                                        `gallery-upload-${this.dataset.blockId}`
                                    )
                                    ?.click();

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.gallery-file-input'
                )
                .forEach(
                    function (input) {

                        input.onchange =
                            async function () {

                                const files =
                                    Array.from(
                                        this.files
                                        ?? []
                                    );


                                if (
                                    files.length
                                ) {

                                    await uploadGalleryImages(
                                        this.dataset
                                            .blockId,
                                        files
                                    );

                                }


                                this.value =
                                    '';

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.remove-gallery-image'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const row =
                                    this.closest(
                                        '.gallery-image-row'
                                    );


                                const list =
                                    row.closest(
                                        '.gallery-list'
                                    );


                                const blockId =
                                    list.dataset
                                        .blockId;


                                row.remove();


                                updateGalleryEmptyState(
                                    blockId
                                );

                            };

                    }
                );
        }


        async function uploadGalleryImages(
            blockId,
            files
        )
        {
            const list =
                document.querySelector(
                    `.gallery-list[data-block-id="${blockId}"]`
                );


            const status =
                document.querySelector(
                    `[data-status-block="${blockId}"]`
                );


            try {

                let completed =
                    0;


                for (
                    const file
                    of files
                ) {

                    validateImageFile(
                        file
                    );


                    if (
                        status
                    ) {

                        status.textContent =
                            `Uploading ${completed}/${files.length}...`;

                    }


                    const formData =
                        new FormData();


                    formData.append(
                        'image',
                        file
                    );


                    const response =
                        await fetch(
                            `/api/v1/admin/products/${productId}/images`,
                            {
                                method:
                                    'POST',

                                credentials:
                                    'same-origin',

                                headers: {

                                    'Accept':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        csrf,

                                },

                                body:
                                    formData,
                            }
                        );


                    const result =
                        await response.json();


                    if (
                        !response.ok
                    ) {

                        throw result;

                    }


                    list.insertAdjacentHTML(

                        'beforeend',

                        galleryImageRow(
                            blockId,
                            result.data.url
                        )

                    );


                    completed++;

                }


                updateGalleryEmptyState(
                    blockId
                );


                bindGalleryButtons();


                if (
                    status
                ) {

                    status.textContent =
                        `${completed} image(s) uploaded.`;

                }

            } catch (error) {

                console.error(
                    error
                );


                if (
                    status
                ) {

                    status.textContent =
                        'Upload failed';

                }


                alert(
                    formatError(
                        error
                    )
                );

            }
        }


        function updateGalleryEmptyState(
            blockId
        )
        {
            const list =
                document.querySelector(
                    `.gallery-list[data-block-id="${blockId}"]`
                );


            const empty =
                document.querySelector(
                    `[data-empty-block="${blockId}"]`
                );


            if (
                !list
                ||
                !empty
            ) {

                return;

            }


            empty.classList.toggle(

                'd-none',

                list.querySelectorAll(
                    '.gallery-image-row'
                ).length > 0

            );
        }


        /*
        |--------------------------------------------------------------------------
        | Template File
        |--------------------------------------------------------------------------
        */

        function templateFileUploader(
            blockId,
            url,
            originalName
        )
        {
            const hasFile =
                String(
                    url
                    ?? ''
                )
                .trim()
                !== '';


            const fileName =
                String(
                    originalName
                    ?? ''
                )
                .trim()
                ||
                getFileNameFromUrl(
                    url
                );


            return `

                <div
                    class="form-group template-file-uploader"
                    data-template-file-block="${blockId}"
                >

                    <label>
                        Template File
                    </label>


                    <input
                        type="hidden"
                        class="product-field template-file-url-value"
                        data-block-id="${blockId}"
                        data-field="template_url"
                        value="${escapeHtml(
                            url
                        )}"
                    >


                    <input
                        type="hidden"
                        class="product-field template-file-name-value"
                        data-block-id="${blockId}"
                        data-field="template_name"
                        value="${escapeHtml(
                            fileName
                        )}"
                    >


                    <div
                        class="template-file-card ${hasFile ? '' : 'd-none'}"
                    >

                        <div class="template-file-icon">
                            &#128196;
                        </div>


                        <div class="template-file-detail">

                            <div class="template-file-name">
                                ${escapeHtml(
                                    fileName
                                )}
                            </div>

                            <div class="template-file-url">
                                ${escapeHtml(
                                    url
                                )}
                            </div>

                        </div>


                        <button
                            type="button"
                            class="btn btn-sm btn-outline-danger remove-template-file"
                        >
                            &times;
                        </button>

                    </div>


                    <div
                        class="template-file-empty ${hasFile ? 'd-none' : ''}"
                    >
                        No template file uploaded
                    </div>


                    <input
                        type="file"
                        class="d-none template-file-input"
                        data-block-id="${blockId}"
                        accept=".pdf,.zip,.ai,.psd,.eps,.svg,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                    >


                    <div class="mt-2">

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-primary upload-template-file"
                            data-block-id="${blockId}"
                        >
                            ${hasFile ? 'Change Template' : '+ Upload Template'}
                        </button>


                        <span class="ml-2 text-muted template-file-status"></span>

                    </div>


                    <small class="form-text text-muted">
                        PDF, ZIP, AI, PSD, EPS, SVG or Microsoft Office file (maximum 50 MB)
                    </small>

                </div>

            `;
        }


        function bindTemplateFileUploaders()
        {
            document
                .querySelectorAll(
                    '.upload-template-file'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                document
                                    .querySelector(
                                        `[data-template-file-block="${this.dataset.blockId}"] .template-file-input`
                                    )
                                    ?.click();

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.template-file-input'
                )
                .forEach(
                    function (input) {

                        input.onchange =
                            async function () {

                                const file =
                                    this.files?.[0];


                                if (
                                    file
                                ) {

                                    await uploadTemplateFile(
                                        this.dataset.blockId,
                                        file
                                    );

                                }


                                this.value =
                                    '';

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.remove-template-file'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const uploader =
                                    this.closest(
                                        '.template-file-uploader'
                                    );


                                uploader
                                    .querySelector(
                                        '.template-file-url-value'
                                    )
                                    .value =
                                        '';


                                uploader
                                    .querySelector(
                                        '.template-file-name-value'
                                    )
                                    .value =
                                        '';


                                uploader
                                    .querySelector(
                                        '.template-file-card'
                                    )
                                    ?.classList
                                    .add(
                                        'd-none'
                                    );


                                uploader
                                    .querySelector(
                                        '.template-file-empty'
                                    )
                                    ?.classList
                                    .remove(
                                        'd-none'
                                    );


                                uploader
                                    .querySelector(
                                        '.upload-template-file'
                                    )
                                    .textContent =
                                        '+ Upload Template';


                                uploader
                                    .querySelector(
                                        '.template-file-status'
                                    )
                                    .textContent =
                                        '';

                            };

                    }
                );
        }


        async function uploadTemplateFile(
            blockId,
            file
        )
        {
            const uploader =
                document.querySelector(
                    `[data-template-file-block="${blockId}"]`
                );


            const status =
                uploader.querySelector(
                    '.template-file-status'
                );


            try {

                validateTemplateFile(
                    file
                );

                status.textContent =
                    'Uploading...';


                const formData =
                    new FormData();


                formData.append(
                    'template',
                    file
                );


                const response =
                    await fetch(
                        `/api/v1/admin/products/${productId}/templates`,
                        {
                            method:
                                'POST',

                            credentials:
                                'same-origin',

                            headers: {

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrf,

                            },

                            body:
                                formData,
                        }
                    );


                const result =
                    await response.json();


                if (
                    !response.ok
                ) {

                    throw result;

                }


                const templateUrl =
                    result.data.url;


                const templateName =
                    result.data.original_name
                    ||
                    getFileNameFromUrl(
                        templateUrl
                    );


                uploader
                    .querySelector(
                        '.template-file-url-value'
                    )
                    .value =
                        templateUrl;


                uploader
                    .querySelector(
                        '.template-file-name-value'
                    )
                    .value =
                        templateName;


                uploader
                    .querySelector(
                        '.template-file-name'
                    )
                    .textContent =
                        templateName;


                uploader
                    .querySelector(
                        '.template-file-url'
                    )
                    .textContent =
                        templateUrl;


                uploader
                    .querySelector(
                        '.template-file-card'
                    )
                    ?.classList
                    .remove(
                        'd-none'
                    );


                uploader
                    .querySelector(
                        '.template-file-empty'
                    )
                    ?.classList
                    .add(
                        'd-none'
                    );


                uploader
                    .querySelector(
                        '.upload-template-file'
                    )
                    .textContent =
                        'Change Template';


                status.textContent =
                    'Uploaded';

            } catch (error) {

                console.error(
                    error
                );


                status.textContent =
                    'Upload failed';


                alert(
                    formatError(
                        error
                    )
                );

            }
        }


        function validateTemplateFile(
            file
        )
        {
            const allowedExtensions = [

                'pdf',
                'zip',
                'ai',
                'psd',
                'eps',
                'svg',
                'doc',
                'docx',
                'xls',
                'xlsx',
                'ppt',
                'pptx',

            ];


            const extension =
                String(
                    file.name
                    .split('.')
                    .pop()
                    ?? ''
                )
                .toLowerCase();


            if (
                !allowedExtensions.includes(
                    extension
                )
            ) {

                throw new Error(
                    `${file.name}: Unsupported template file type.`
                );

            }


            if (
                file.size
                >
                50
                *
                1024
                *
                1024
            ) {

                throw new Error(
                    `${file.name}: File size exceeds 50 MB.`
                );

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Info Card Image
        |--------------------------------------------------------------------------
        */

        function infoCardImageUploader(
            blockId,
            url
        )
        {
            const hasImage =
                String(
                    url
                    ?? ''
                )
                .trim()
                !== '';


            return `

                <div
                    class="
                        form-group
                        info-card-image-uploader
                    "
                    data-info-card-image-block="${blockId}"
                >

                    <label>
                        Image
                    </label>


                    <input
                        type="hidden"
                        class="
                            product-field
                            info-card-image-value
                        "
                        data-block-id="${blockId}"
                        data-field="image_url"
                        value="${escapeHtml(
                            url
                        )}"
                    >


                    <div
                        class="
                            info-card-image-preview-wrapper
                            ${
                                hasImage
                                ? ''
                                : 'd-none'
                            }
                        "
                    >

                        <div class="info-card-image-preview">

                            <img
                                src="${escapeHtml(
                                    url
                                )}"
                                alt=""
                            >

                        </div>


                        <div class="info-card-image-detail">

                            <div class="info-card-image-name">

                                ${
                                    hasImage

                                    ? escapeHtml(
                                        getFileNameFromUrl(
                                            url
                                        )
                                    )

                                    : ''
                                }

                            </div>


                            <div class="info-card-image-url">

                                ${escapeHtml(
                                    url
                                )}

                            </div>

                        </div>


                        <button
                            type="button"
                            class="
                                btn
                                btn-sm
                                btn-outline-danger
                                remove-info-card-image
                            "
                        >
                            ×
                        </button>

                    </div>


                    <div
                        class="
                            info-card-image-empty
                            ${
                                hasImage
                                ? 'd-none'
                                : ''
                            }
                        "
                    >

                        🖼

                        <br>

                        No image uploaded

                    </div>


                    <input
                        type="file"
                        class="
                            d-none
                            info-card-image-file
                        "
                        data-block-id="${blockId}"
                        accept="
                            image/jpeg,
                            image/png,
                            image/webp,
                            image/gif
                        "
                    >


                    <div class="mt-2">

                        <button
                            type="button"
                            class="
                                btn
                                btn-sm
                                btn-outline-primary
                                upload-info-card-image
                            "
                            data-block-id="${blockId}"
                        >

                            ${
                                hasImage
                                ? 'Change Image'
                                : '+ Upload Image'
                            }

                        </button>


                        <span
                            class="
                                ml-2
                                text-muted
                                info-card-image-status
                            "
                        ></span>

                    </div>

                </div>

            `;
        }


        function bindInfoCardImageUploaders()
        {
            document
                .querySelectorAll(
                    '.upload-info-card-image'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                document
                                    .querySelector(
                                        `[data-info-card-image-block="${this.dataset.blockId}"] .info-card-image-file`
                                    )
                                    ?.click();

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.info-card-image-file'
                )
                .forEach(
                    function (input) {

                        input.onchange =
                            async function () {

                                const file =
                                    this.files?.[0];


                                if (
                                    file
                                ) {

                                    await uploadInfoCardImage(
                                        this.dataset
                                            .blockId,
                                        file
                                    );

                                }


                                this.value =
                                    '';

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.remove-info-card-image'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const uploader =
                                    this.closest(
                                        '.info-card-image-uploader'
                                    );


                                uploader
                                    .querySelector(
                                        '.info-card-image-value'
                                    )
                                    .value =
                                        '';


                                uploader
                                    .querySelector(
                                        '.info-card-image-preview-wrapper'
                                    )
                                    ?.classList
                                    .add(
                                        'd-none'
                                    );


                                uploader
                                    .querySelector(
                                        '.info-card-image-empty'
                                    )
                                    ?.classList
                                    .remove(
                                        'd-none'
                                    );


                                uploader
                                    .querySelector(
                                        '.upload-info-card-image'
                                    )
                                    .textContent =
                                        '+ Upload Image';

                            };

                    }
                );
        }


        async function uploadInfoCardImage(
            blockId,
            file
        )
        {
            validateImageFile(
                file
            );


            const uploader =
                document.querySelector(
                    `[data-info-card-image-block="${blockId}"]`
                );


            const status =
                uploader.querySelector(
                    '.info-card-image-status'
                );


            try {

                status.textContent =
                    'Uploading...';


                const formData =
                    new FormData();


                formData.append(
                    'image',
                    file
                );


                const response =
                    await fetch(
                        `/api/v1/admin/products/${productId}/images`,
                        {
                            method:
                                'POST',

                            credentials:
                                'same-origin',

                            headers: {

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrf,

                            },

                            body:
                                formData,
                        }
                    );


                const result =
                    await response.json();


                if (
                    !response.ok
                ) {

                    throw result;

                }


                const imageUrl =
                    result.data.url;


                uploader
                    .querySelector(
                        '.info-card-image-value'
                    )
                    .value =
                        imageUrl;


                uploader
                    .querySelector(
                        '.info-card-image-preview img'
                    )
                    .src =
                        imageUrl;


                uploader
                    .querySelector(
                        '.info-card-image-name'
                    )
                    .textContent =
                        getFileNameFromUrl(
                            imageUrl
                        );


                uploader
                    .querySelector(
                        '.info-card-image-url'
                    )
                    .textContent =
                        imageUrl;


                uploader
                    .querySelector(
                        '.info-card-image-preview-wrapper'
                    )
                    ?.classList
                    .remove(
                        'd-none'
                    );


                uploader
                    .querySelector(
                        '.info-card-image-empty'
                    )
                    ?.classList
                    .add(
                        'd-none'
                    );


                uploader
                    .querySelector(
                        '.upload-info-card-image'
                    )
                    .textContent =
                        'Change Image';


                status.textContent =
                    'Uploaded';

            } catch (error) {

                console.error(
                    error
                );


                status.textContent =
                    'Upload failed';


                alert(
                    formatError(
                        error
                    )
                );

            }
        }


        function validateImageFile(
            file
        )
        {
            const allowed = [

                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',

            ];


            if (
                !allowed.includes(
                    file.type
                )
            ) {

                throw new Error(
                    `${file.name}: Unsupported image type.`
                );

            }


            if (
                file.size
                >
                10
                *
                1024
                *
                1024
            ) {

                throw new Error(
                    `${file.name}: File size exceeds 10 MB.`
                );

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Product Detail Shipping Days
        |--------------------------------------------------------------------------
        */

        function shippingDaysInput(
            blockId,
            value
        )
        {
            return `

                <div
                    class="
                        form-group
                        shipping-days-group
                    "
                >

                    <label>
                        Shipping Days
                    </label>


                    <div class="input-group">

                        <input
                            type="number"
                            min="0"
                            max="365"
                            step="1"
                            class="
                                form-control
                                product-field
                                shipping-days-input
                            "
                            data-block-id="${blockId}"
                            data-field="shipping_days"
                            value="${escapeHtml(
                                value
                            )}"
                        >


                        <div class="input-group-append">

                            <span class="input-group-text">
                                days
                            </span>

                        </div>

                    </div>


                    <small class="form-text text-muted">

                        ระบบจะข้าม Holiday type1, type2 และ type3

                    </small>


                    <div
                        class="
                            shipping-date-preview
                            mt-2
                            d-none
                        "
                        data-shipping-preview="${blockId}"
                    >

                        <div class="alert alert-info mb-0">

                            <div>

                                Estimated Shipping Date:

                                <strong
                                    class="shipping-preview-date"
                                    data-shipping-date="${blockId}"
                                >
                                    -
                                </strong>

                            </div>


                            <div
                                class="shipping-preview-detail"
                                data-shipping-detail="${blockId}"
                            ></div>


                            <div
                                class="
                                    shipping-preview-skipped
                                    d-none
                                "
                                data-shipping-skipped="${blockId}"
                            ></div>

                        </div>

                    </div>

                </div>

            `;
        }


        function bindShippingDays()
        {
            document
                .querySelectorAll(
                    '.shipping-days-input'
                )
                .forEach(
                    function (input) {

                        if (
                            input.dataset
                                .shippingBound
                            === '1'
                        ) {

                            return;

                        }


                        input.dataset
                            .shippingBound =
                                '1';


                        input.addEventListener(
                            'input',
                            function () {

                                updateProductShippingPreview(
                                    input
                                );

                            }
                        );


                        if (
                            String(
                                input.value
                                ?? ''
                            )
                            .trim()
                            !== ''
                        ) {

                            updateProductShippingPreview(
                                input
                            );

                        }

                    }
                );
        }


        async function updateProductShippingPreview(
            input
        )
        {
            const blockId =
                input.dataset
                    .blockId;


            const preview =
                document.querySelector(
                    `[data-shipping-preview="${blockId}"]`
                );


            const dateElement =
                document.querySelector(
                    `[data-shipping-date="${blockId}"]`
                );


            const detail =
                document.querySelector(
                    `[data-shipping-detail="${blockId}"]`
                );


            const skippedElement =
                document.querySelector(
                    `[data-shipping-skipped="${blockId}"]`
                );


            const raw =
                String(
                    input.value
                    ?? ''
                )
                .trim();


            if (
                raw === ''
            ) {

                preview
                    ?.classList
                    .add(
                        'd-none'
                    );

                return;

            }


            const days =
                Number(
                    raw
                );


            preview
                ?.classList
                .remove(
                    'd-none'
                );


            if (
                !Number.isInteger(
                    days
                )
                ||
                days < 0
                ||
                days > 365
            ) {

                dateElement.textContent =
                    'Invalid';


                detail.textContent =
                    'Shipping Days must be between 0 and 365.';


                return;

            }


            try {

                dateElement.textContent =
                    'Calculating...';


                await loadShippingHolidays();


                const result =
                    calculateShippingDate(
                        days
                    );


                dateElement.textContent =
                    formatDisplayDateKey(
                        result.date
                    );


                detail.textContent =
                    `${days} shipping day(s), ${result.skipped.length} holiday(s) skipped.`;


                renderSkippedShippingDays(
                    skippedElement,
                    result.skipped
                );

            } catch (error) {

                dateElement.textContent =
                    'Unable to calculate';


                detail.textContent =
                    formatError(
                        error
                    );

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Shipping Schedule
        |--------------------------------------------------------------------------
        */

        function shippingScheduleEditor(
            block,
            content
        )
        {
            const data =
                normalizeShippingScheduleContent(
                    content
                );


            return `

                <div
                    class="shipping-schedule-editor"
                    data-shipping-schedule-block="${block.id}"
                >

                    ${renderShippingScheduleInner(
                        block.id,
                        data
                    )}

                </div>

            `;
        }


        function normalizeShippingScheduleContent(
            content
        )
        {
            const schedules =
                Array.isArray(
                    content.schedules
                )
                    ? content.schedules
                    : [];


            return {

                title:
                    content.title
                    ?? '',

                display_type:
                    [
                        'stacked',
                        'grouped',
                    ].includes(
                        content.display_type
                    )
                        ? content.display_type
                        : 'stacked',

                intro_text:
                    content.intro_text
                    ??
                    '今、この製品を製作開始した場合の出荷日を表示中',

                start_label:
                    content.start_label
                    ??
                    '原稿確定日',

                shipping_label:
                    content.shipping_label
                    ??
                    '出荷予定',

                footer_note:
                    content.footer_note
                    ?? '',

                schedules:
                    schedules.map(
                        function (
                            schedule,
                            index
                        ) {

                            return {

                                id:
                                    schedule.id
                                    ??
                                    generateScheduleId(),

                                label:
                                    schedule.label
                                    ??
                                    `Schedule ${index + 1}`,

                                days:
                                    schedule.days
                                    ?? 0,

                                theme:
                                    normalizeScheduleTheme(
                                        schedule.theme
                                    ),

                            };

                        }
                    ),

            };
        }


        function renderShippingScheduleInner(
            blockId,
            data
        )
        {
            return `

                <div class="shipping-schedule-main">

                    <div class="form-group">

                        <label>
                            Section Title
                        </label>

                        <input
                            type="text"
                            class="
                                form-control
                                shipping-schedule-main-field
                            "
                            data-field="title"
                            value="${escapeHtml(
                                data.title
                            )}"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Display Style
                        </label>

                        <select
                            class="
                                form-control
                                shipping-schedule-main-field
                            "
                            data-field="display_type"
                        >

                            <option
                                value="stacked"
                                ${
                                    data.display_type === 'stacked'
                                    ? 'selected'
                                    : ''
                                }
                            >
                                Stacked
                            </option>

                            <option
                                value="grouped"
                                ${
                                    data.display_type === 'grouped'
                                    ? 'selected'
                                    : ''
                                }
                            >
                                Grouped
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Table Message
                        </label>

                        <input
                            type="text"
                            class="
                                form-control
                                shipping-schedule-main-field
                            "
                            data-field="intro_text"
                            value="${escapeHtml(
                                data.intro_text
                            )}"
                        >

                    </div>


                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Start Date Label
                                </label>

                                <input
                                    type="text"
                                    class="
                                        form-control
                                        shipping-schedule-main-field
                                    "
                                    data-field="start_label"
                                    value="${escapeHtml(
                                        data.start_label
                                    )}"
                                >

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Shipping Date Label
                                </label>

                                <input
                                    type="text"
                                    class="
                                        form-control
                                        shipping-schedule-main-field
                                    "
                                    data-field="shipping_label"
                                    value="${escapeHtml(
                                        data.shipping_label
                                    )}"
                                >

                            </div>

                        </div>

                    </div>


                    <div class="form-group">

                        <label>
                            Footer Note
                        </label>

                        <textarea
                            class="
                                form-control
                                shipping-schedule-main-field
                            "
                            rows="3"
                            data-field="footer_note"
                        >${escapeHtml(
                            data.footer_note
                        )}</textarea>

                    </div>

                </div>


                <div class="shipping-schedule-items-header">

                    <strong>
                        Schedule Items
                    </strong>


                    <button
                        type="button"
                        class="
                            btn
                            btn-sm
                            btn-outline-primary
                            add-shipping-schedule
                        "
                        data-block-id="${blockId}"
                    >
                        + Add Schedule
                    </button>

                </div>


                <div class="shipping-schedule-items">

                    ${data.schedules
                        .map(
                            function (
                                schedule,
                                index
                            ) {

                                return renderShippingScheduleItem(

                                    blockId,

                                    schedule,

                                    index,

                                    data.schedules.length

                                );

                            }
                        )
                        .join('')
                    }

                </div>


                <div
                    class="schedule-live-preview"
                    data-schedule-preview="${blockId}"
                ></div>

            `;
        }


        function renderShippingScheduleItem(
            blockId,
            schedule,
            index,
            total
        )
        {
            return `

                <div class="shipping-schedule-item">

                    <div class="shipping-schedule-item-header">

                        <strong>
                            Schedule #${index + 1}
                        </strong>


                        <div class="shipping-schedule-item-actions">

                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-secondary
                                    move-schedule-up
                                "
                                data-block-id="${blockId}"
                                data-index="${index}"
                                ${
                                    index === 0
                                    ? 'disabled'
                                    : ''
                                }
                            >
                                ↑
                            </button>


                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-secondary
                                    move-schedule-down
                                "
                                data-block-id="${blockId}"
                                data-index="${index}"
                                ${
                                    index === total - 1
                                    ? 'disabled'
                                    : ''
                                }
                            >
                                ↓
                            </button>


                            <button
                                type="button"
                                class="
                                    btn
                                    btn-outline-danger
                                    delete-shipping-schedule
                                "
                                data-block-id="${blockId}"
                                data-index="${index}"
                            >
                                Delete
                            </button>

                        </div>

                    </div>


                    <input
                        type="hidden"
                        class="schedule-item-field"
                        data-field="id"
                        value="${escapeHtml(
                            schedule.id
                        )}"
                    >


                    <div class="form-group">

                        <label>
                            Label
                        </label>

                        <input
                            type="text"
                            class="
                                form-control
                                schedule-item-field
                            "
                            data-field="label"
                            value="${escapeHtml(
                                schedule.label
                            )}"
                        >

                    </div>


                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Shipping Days
                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    max="365"
                                    class="
                                        form-control
                                        schedule-item-field
                                    "
                                    data-field="days"
                                    value="${escapeHtml(
                                        schedule.days
                                    )}"
                                >

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Theme
                                </label>

                                <select
                                    class="
                                        form-control
                                        schedule-item-field
                                    "
                                    data-field="theme"
                                >

                                    ${[
                                        'blue',
                                        'pink',
                                        'cyan',
                                        'orange',
                                        'gray',
                                    ]
                                    .map(
                                        value => `

                                            <option
                                                value="${value}"
                                                ${
                                                    schedule.theme === value
                                                    ? 'selected'
                                                    : ''
                                                }
                                            >
                                                ${value}
                                            </option>

                                        `
                                    )
                                    .join('')
                                    }

                                </select>

                            </div>

                        </div>

                    </div>

                </div>

            `;
        }


        function bindShippingScheduleEditors()
        {
            document
                .querySelectorAll(
                    '.add-shipping-schedule'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const blockId =
                                    this.dataset
                                        .blockId;


                                const data =
                                    collectShippingScheduleData(
                                        blockId
                                    );


                                data.schedules.push({

                                    id:
                                        generateScheduleId(),

                                    label:
                                        '通常納期',

                                    days:
                                        10,

                                    theme:
                                        'blue',

                                });


                                rerenderShippingSchedule(
                                    blockId,
                                    data
                                );

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.delete-shipping-schedule'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const blockId =
                                    this.dataset
                                        .blockId;


                                const data =
                                    collectShippingScheduleData(
                                        blockId
                                    );


                                data.schedules.splice(

                                    Number(
                                        this.dataset.index
                                    ),

                                    1

                                );


                                rerenderShippingSchedule(
                                    blockId,
                                    data
                                );

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.move-schedule-up'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const blockId =
                                    this.dataset
                                        .blockId;


                                const index =
                                    Number(
                                        this.dataset.index
                                    );


                                if (
                                    index <= 0
                                ) {

                                    return;

                                }


                                const data =
                                    collectShippingScheduleData(
                                        blockId
                                    );


                                [
                                    data.schedules[
                                        index - 1
                                    ],
                                    data.schedules[
                                        index
                                    ]
                                ] = [
                                    data.schedules[
                                        index
                                    ],
                                    data.schedules[
                                        index - 1
                                    ]
                                ];


                                rerenderShippingSchedule(
                                    blockId,
                                    data
                                );

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.move-schedule-down'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                const blockId =
                                    this.dataset
                                        .blockId;


                                const index =
                                    Number(
                                        this.dataset.index
                                    );


                                const data =
                                    collectShippingScheduleData(
                                        blockId
                                    );


                                if (
                                    index >=
                                    data.schedules.length - 1
                                ) {

                                    return;

                                }


                                [
                                    data.schedules[
                                        index
                                    ],
                                    data.schedules[
                                        index + 1
                                    ]
                                ] = [
                                    data.schedules[
                                        index + 1
                                    ],
                                    data.schedules[
                                        index
                                    ]
                                ];


                                rerenderShippingSchedule(
                                    blockId,
                                    data
                                );

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.shipping-schedule-editor input, .shipping-schedule-editor select, .shipping-schedule-editor textarea'
                )
                .forEach(
                    function (field) {

                        if (
                            field.dataset
                                .scheduleBound
                            === '1'
                        ) {

                            return;

                        }


                        field.dataset
                            .scheduleBound =
                                '1';


                        const refresh =
                            function () {

                                const editor =
                                    field.closest(
                                        '.shipping-schedule-editor'
                                    );


                                if (
                                    editor
                                ) {

                                    updateShippingSchedulePreview(
                                        editor.dataset
                                            .shippingScheduleBlock
                                    );

                                }

                            };


                        field.addEventListener(
                            'input',
                            refresh
                        );


                        field.addEventListener(
                            'change',
                            refresh
                        );

                    }
                );


            document
                .querySelectorAll(
                    '.shipping-schedule-editor'
                )
                .forEach(
                    function (editor) {

                        updateShippingSchedulePreview(
                            editor.dataset
                                .shippingScheduleBlock
                        );

                    }
                );
        }


        function collectShippingScheduleData(
            blockId
        )
        {
            const editor =
                document.querySelector(
                    `[data-shipping-schedule-block="${blockId}"]`
                );


            const result = {

                title:
                    '',

                display_type:
                    'stacked',

                intro_text:
                    '',

                start_label:
                    '',

                shipping_label:
                    '',

                footer_note:
                    '',

                schedules:
                    [],

            };


            if (
                !editor
            ) {

                return result;

            }


            editor
                .querySelectorAll(
                    '.shipping-schedule-main-field'
                )
                .forEach(
                    function (field) {

                        result[
                            field.dataset.field
                        ] =
                            field.value;

                    }
                );


            editor
                .querySelectorAll(
                    '.shipping-schedule-item'
                )
                .forEach(
                    function (item) {

                        const schedule =
                            {};


                        item
                            .querySelectorAll(
                                '.schedule-item-field'
                            )
                            .forEach(
                                function (field) {

                                    schedule[
                                        field.dataset.field
                                    ] =
                                        field.dataset.field === 'days'

                                        ? Number(
                                            field.value
                                        )

                                        : field.value;

                                }
                            );


                        result.schedules.push(
                            schedule
                        );

                    }
                );


            return result;
        }


        function rerenderShippingSchedule(
            blockId,
            data
        )
        {
            const editor =
                document.querySelector(
                    `[data-shipping-schedule-block="${blockId}"]`
                );


            if (
                !editor
            ) {

                return;

            }


            editor.innerHTML =
                renderShippingScheduleInner(
                    blockId,
                    data
                );


            bindShippingScheduleEditors();
        }


        async function updateShippingSchedulePreview(
            blockId
        )
        {
            const preview =
                document.querySelector(
                    `[data-schedule-preview="${blockId}"]`
                );


            if (
                !preview
            ) {

                return;

            }


            const data =
                collectShippingScheduleData(
                    blockId
                );


            if (
                !data.schedules.length
            ) {

                preview.innerHTML = `

                    <div class="text-muted text-center">
                        Add Schedule Items
                    </div>

                `;

                return;

            }


            try {

                await loadShippingHolidays();


                const schedules =
                    data.schedules.map(
                        function (schedule) {

                            return {

                                ...schedule,

                                calculation:
                                    calculateShippingDate(
                                        Number(
                                            schedule.days
                                        )
                                    ),

                            };

                        }
                    );


                preview.innerHTML =
                    data.display_type === 'grouped'

                    ? renderGroupedSchedulePreview(
                        data,
                        schedules
                    )

                    : renderStackedSchedulePreview(
                        data,
                        schedules
                    );

            } catch (error) {

                preview.innerHTML = `

                    <div class="alert alert-danger">

                        ${escapeHtml(
                            formatError(
                                error
                            )
                        )}

                    </div>

                `;

            }
        }


        function renderGroupedSchedulePreview(
            data,
            schedules
        )
        {
            const startDate =
                formatTokyoNowDisplay();


            return `

                ${
                    data.title

                    ? `

                        <div class="schedule-live-preview-title">

                            ${escapeHtml(
                                data.title
                            )}

                        </div>

                    `

                    : ''
                }


                ${schedules
                    .map(
                        schedule => `

                            <div class="schedule-label-row">

                                <div
                                    class="
                                        schedule-label-badge
                                        schedule-theme-${normalizeScheduleTheme(
                                            schedule.theme
                                        )}
                                    "
                                >

                                    ${escapeHtml(
                                        schedule.label
                                    )}

                                </div>


                                <div class="schedule-days-label">

                                    ${escapeHtml(
                                        schedule.days
                                    )}営業日後出荷

                                </div>

                            </div>

                        `
                    )
                    .join('')
                }


                <table class="schedule-result-table">

                    <tr>

                        <th
                            colspan="2"
                            style="background:#fff"
                        >

                            ${escapeHtml(
                                data.intro_text
                            )}

                        </th>

                    </tr>


                    <tr>

                        <th class="schedule-result-start">

                            ${escapeHtml(
                                data.start_label
                            )}

                        </th>

                        <th class="schedule-result-end">

                            ${escapeHtml(
                                data.shipping_label
                            )}

                        </th>

                    </tr>


                    ${schedules
                        .map(
                            (
                                schedule,
                                index
                            ) => `

                                <tr>

                                    ${
                                        index === 0

                                        ? `

                                            <td
                                                class="schedule-result-start"
                                                rowspan="${schedules.length}"
                                            >

                                                <span class="schedule-result-date">

                                                    ${escapeHtml(
                                                        startDate
                                                    )}

                                                </span>

                                            </td>

                                        `

                                        : ''
                                    }


                                    <td class="schedule-result-end">

                                        <strong>

                                            ${escapeHtml(
                                                schedule.label
                                            )}

                                        </strong>

                                        <br>

                                        <span class="schedule-result-date">

                                            ${escapeHtml(
                                                formatDisplayDateKey(
                                                    schedule.calculation.date
                                                )
                                            )}

                                        </span>

                                    </td>

                                </tr>

                            `
                        )
                        .join('')
                    }

                </table>


                <div class="schedule-footer-note">

                    ${escapeHtml(
                        data.footer_note
                    )}

                </div>

            `;
        }


        function renderStackedSchedulePreview(
            data,
            schedules
        )
        {
            const startDate =
                formatTokyoNowDisplay();


            return `

                ${
                    data.title

                    ? `

                        <div class="schedule-live-preview-title">

                            ${escapeHtml(
                                data.title
                            )}

                        </div>

                    `

                    : ''
                }


                ${schedules
                    .map(
                        schedule => `

                            <div class="schedule-stacked-item">

                                <div class="schedule-label-row">

                                    <div
                                        class="
                                            schedule-label-badge
                                            schedule-theme-${normalizeScheduleTheme(
                                                schedule.theme
                                            )}
                                        "
                                    >

                                        ${escapeHtml(
                                            schedule.label
                                        )}

                                    </div>


                                    <div class="schedule-days-label">

                                        ${escapeHtml(
                                            schedule.days
                                        )}営業日後出荷

                                    </div>

                                </div>


                                <table class="schedule-result-table">

                                    <tr>

                                        <th
                                            colspan="2"
                                            style="background:#fff"
                                        >

                                            ${escapeHtml(
                                                data.intro_text
                                            )}

                                        </th>

                                    </tr>


                                    <tr>

                                        <th class="schedule-result-start">

                                            ${escapeHtml(
                                                data.start_label
                                            )}

                                        </th>

                                        <th class="schedule-result-end">

                                            ${escapeHtml(
                                                data.shipping_label
                                            )}

                                        </th>

                                    </tr>


                                    <tr>

                                        <td class="schedule-result-start">

                                            <span class="schedule-result-date">

                                                ${escapeHtml(
                                                    startDate
                                                )}

                                            </span>

                                        </td>


                                        <td class="schedule-result-end">

                                            <span class="schedule-result-date">

                                                ${escapeHtml(
                                                    formatDisplayDateKey(
                                                        schedule.calculation.date
                                                    )
                                                )}

                                            </span>

                                        </td>

                                    </tr>

                                </table>

                            </div>

                        `
                    )
                    .join('')
                }


                <div class="schedule-footer-note">

                    ${escapeHtml(
                        data.footer_note
                    )}

                </div>

            `;
        }


        function generateScheduleId()
        {
            return (

                'schedule_'

                +
                Date.now()

                +
                '_'

                +
                Math
                    .random()
                    .toString(36)
                    .substring(
                        2,
                        9
                    )

            );
        }


        function normalizeScheduleTheme(
            value
        )
        {
            return [
                'blue',
                'pink',
                'cyan',
                'orange',
                'gray',
            ].includes(
                value
            )
                ? value
                : 'blue';
        }


        /*
        |--------------------------------------------------------------------------
        | Holidays
        |--------------------------------------------------------------------------
        */

        async function loadShippingHolidays()
        {
            if (
                shippingHolidayLoadPromise
            ) {

                return shippingHolidayLoadPromise;

            }


            shippingHolidayLoadPromise =
                (
                    async function () {

                        const from =
                            getTokyoTodayKey();


                        const to =
                            addDaysToDateKey(
                                from,
                                730
                            );


                        const response =
                            await fetch(

                                `/api/v1/holidays?from=${encodeURIComponent(
                                    from
                                )}&to=${encodeURIComponent(
                                    to
                                )}&calendar_type=normal`,

                                {
                                    credentials:
                                        'same-origin',

                                    headers: {
                                        'Accept':
                                            'application/json',
                                    },
                                }

                            );


                        const result =
                            await response.json();


                        if (
                            !response.ok
                        ) {

                            throw result;

                        }


                        const map =
                            new Map();


                        extractHolidayArray(
                            result
                        )
                        .forEach(
                            function (holiday) {

                                const type =
                                    holiday.holiday_type
                                    ??
                                    holiday.type;


                                const date =
                                    String(
                                        holiday.holiday_date
                                        ??
                                        holiday.date
                                        ??
                                        ''
                                    )
                                    .substring(
                                        0,
                                        10
                                    );


                                if (
                                    !date
                                    ||
                                    ![
                                        'type1',
                                        'type2',
                                        'type3',
                                    ].includes(
                                        type
                                    )
                                ) {

                                    return;

                                }


                                if (
                                    !map.has(
                                        date
                                    )
                                ) {

                                    map.set(
                                        date,
                                        []
                                    );

                                }


                                map
                                    .get(
                                        date
                                    )
                                    .push({

                                        type:
                                            type,

                                        title:
                                            holiday.title
                                            ?? '',

                                    });

                            }
                        );


                        shippingHolidays =
                            map;


                        return map;

                    }
                )();


            return shippingHolidayLoadPromise;
        }


        function extractHolidayArray(
            result
        )
        {
            if (
                Array.isArray(
                    result
                )
            ) {

                return result;

            }


            if (
                Array.isArray(
                    result?.data
                )
            ) {

                return result.data;

            }


            if (
                Array.isArray(
                    result?.data?.holidays
                )
            ) {

                return result.data.holidays;

            }


            if (
                Array.isArray(
                    result?.holidays
                )
            ) {

                return result.holidays;

            }


            return [];
        }


        function calculateShippingDate(
            shippingDays
        )
        {
            const days =
                Number(
                    shippingDays
                );


            let date =
                getTokyoTodayKey();


            let count =
                0;


            let safety =
                0;


            const skipped =
                [];


            if (
                !Number.isFinite(
                    days
                )
                ||
                days <= 0
            ) {

                return {

                    date:
                        date,

                    skipped:
                        skipped,

                };

            }


            while (
                count < days
            ) {

                date =
                    addDaysToDateKey(
                        date,
                        1
                    );


                safety++;


                if (
                    safety > 1500
                ) {

                    throw new Error(
                        'Shipping calculation exceeded safety limit.'
                    );

                }


                const holidays =
                    shippingHolidays.get(
                        date
                    )
                    ?? [];


                if (
                    holidays.length
                ) {

                    skipped.push({

                        date:
                            date,

                        holidays:
                            holidays,

                    });


                    continue;

                }


                count++;

            }


            return {

                date:
                    date,

                skipped:
                    skipped,

            };
        }


        function renderSkippedShippingDays(
            element,
            items
        )
        {
            if (
                !element
            ) {

                return;

            }


            if (
                !items.length
            ) {

                element.classList.add(
                    'd-none'
                );


                element.innerHTML =
                    '';


                return;

            }


            element.innerHTML = `

                <strong>
                    Skipped Holiday:
                </strong>

                <div class="mt-1">

                    ${items
                        .slice(
                            0,
                            20
                        )
                        .map(
                            item => `

                                <span class="shipping-preview-skipped-item">

                                    ${escapeHtml(
                                        formatDisplayDateKey(
                                            item.date
                                        )
                                    )}

                                </span>

                            `
                        )
                        .join('')
                    }

                </div>

            `;


            element.classList.remove(
                'd-none'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Date Helpers
        |--------------------------------------------------------------------------
        */

        function getTokyoTodayKey()
        {
            const parts =
                new Intl.DateTimeFormat(
                    'en-CA',
                    {
                        timeZone:
                            'Asia/Tokyo',

                        year:
                            'numeric',

                        month:
                            '2-digit',

                        day:
                            '2-digit',
                    }
                )
                .formatToParts(
                    new Date()
                );


            const values =
                {};


            parts.forEach(
                function (part) {

                    values[
                        part.type
                    ] =
                        part.value;

                }
            );


            return `${values.year}-${values.month}-${values.day}`;
        }


        function formatTokyoNowDisplay()
        {
            return new Intl.DateTimeFormat(
                'ja-JP',
                {
                    timeZone:
                        'Asia/Tokyo',

                    month:
                        '2-digit',

                    day:
                        '2-digit',

                    weekday:
                        'short',

                    hour:
                        '2-digit',

                    minute:
                        '2-digit',

                    hour12:
                        false,
                }
            )
            .format(
                new Date()
            );
        }


        function dateKeyToUtcDate(
            dateKey
        )
        {
            const [
                year,
                month,
                day
            ] =
                String(
                    dateKey
                )
                .split('-')
                .map(
                    Number
                );


            return new Date(
                Date.UTC(
                    year,
                    month - 1,
                    day,
                    12
                )
            );
        }


        function utcDateToDateKey(
            date
        )
        {
            return (

                date.getUTCFullYear()

                +
                '-'

                +
                String(
                    date.getUTCMonth() + 1
                )
                .padStart(
                    2,
                    '0'
                )

                +
                '-'

                +
                String(
                    date.getUTCDate()
                )
                .padStart(
                    2,
                    '0'
                )

            );
        }


        function addDaysToDateKey(
            dateKey,
            days
        )
        {
            const date =
                dateKeyToUtcDate(
                    dateKey
                );


            date.setUTCDate(
                date.getUTCDate()
                +
                Number(
                    days
                )
            );


            return utcDateToDateKey(
                date
            );
        }


        function formatDisplayDateKey(
            dateKey
        )
        {
            const date =
                dateKeyToUtcDate(
                    dateKey
                );


            const weekdays = [

                '日',
                '月',
                '火',
                '水',
                '木',
                '金',
                '土',

            ];


            const month =
                String(
                    date.getUTCMonth() + 1
                )
                .padStart(
                    2,
                    '0'
                );


            const day =
                String(
                    date.getUTCDate()
                )
                .padStart(
                    2,
                    '0'
                );


            return (

                `${month}月${day}日(${weekdays[
                    date.getUTCDay()
                ]})`

            );
        }


        /*
        |--------------------------------------------------------------------------
        | Inputs
        |--------------------------------------------------------------------------
        */

        function textInput(
            blockId,
            field,
            label,
            value
        )
        {
            return `

                <div class="form-group">

                    <label>
                        ${escapeHtml(
                            label
                        )}
                    </label>

                    <input
                        type="text"
                        class="
                            form-control
                            product-field
                        "
                        data-block-id="${blockId}"
                        data-field="${field}"
                        value="${escapeHtml(
                            value
                        )}"
                    >

                </div>

            `;
        }

        function imageUploaderInput(
            blockId,
            field,
            label,
            value
        )
        {
            const hasImg =
                String(value ?? '').trim() !== '';

            return `
                <div class="form-group single-image-uploader-wrapper" data-image-uploader-block="${blockId}">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="mb-0 font-weight-bold">
                            ${escapeHtml(label)}
                        </label>
                        <span class="small font-weight-bold single-image-upload-status" style="font-size: 11px;"></span>
                    </div>

                    <div class="single-image-preview-box mb-2 p-1 border rounded bg-light text-center ${hasImg ? '' : 'd-none'}" style="max-height: 120px;">
                        <img src="${escapeHtml(value)}" class="img-fluid single-image-preview" style="max-height: 110px; object-fit: contain;">
                    </div>

                    <div class="input-group input-group-sm">
                        <input
                            type="text"
                            class="
                                form-control
                                product-field
                                single-image-input-value
                            "
                            data-block-id="${blockId}"
                            data-field="${field}"
                            value="${escapeHtml(value)}"
                            placeholder="/products/images/... or https://..."
                        >
                        <div class="input-group-append">
                            <button
                                type="button"
                                class="btn btn-outline-primary btn-upload-single-image"
                                data-block-id="${blockId}"
                                title="อัพโหลดรูปภาพ"
                            >
                                <i class="fas fa-upload mr-1"></i> อัพภาพ
                            </button>
                        </div>
                    </div>

                    <input
                        type="file"
                        class="d-none single-image-file-input"
                        data-block-id="${blockId}"
                        accept="image/jpeg,image/png,image/webp,image/gif"
                    >
                </div>
            `;
        }

        function bindSingleImageUploaders()
        {
            document
                .querySelectorAll('.btn-upload-single-image')
                .forEach(function (btn) {
                    btn.onclick = function () {
                        const wrapper = this.closest('.single-image-uploader-wrapper');
                        wrapper?.querySelector('.single-image-file-input')?.click();
                    };
                });

            document
                .querySelectorAll('.single-image-file-input')
                .forEach(function (input) {
                    input.onchange = async function () {
                        const file = this.files?.[0];
                        if (!file) return;

                        const wrapper = this.closest('.single-image-uploader-wrapper');
                        const status = wrapper?.querySelector('.single-image-upload-status');
                        const btn = wrapper?.querySelector('.btn-upload-single-image');

                        try {
                            if (status) {
                                status.className = 'small font-weight-bold single-image-upload-status text-warning';
                                status.textContent = '⏳ กำลังอัพโหลด...';
                            }
                            if (btn) btn.disabled = true;

                            const url = await uploadSingleImageFile(file);

                            const textInput = wrapper?.querySelector('.single-image-input-value');
                            if (textInput) {
                                textInput.value = url;
                                textInput.dispatchEvent(new Event('input', { bubbles: true }));
                            }

                            const previewBox = wrapper?.querySelector('.single-image-preview-box');
                            const img = wrapper?.querySelector('.single-image-preview');
                            if (previewBox && img) {
                                img.src = url;
                                previewBox.classList.remove('d-none');
                            }

                            if (status) {
                                status.className = 'small font-weight-bold single-image-upload-status text-success';
                                status.textContent = '✓ สำเร็จ';
                                setTimeout(function () {
                                    if (status && status.textContent === '✓ สำเร็จ') status.textContent = '';
                                }, 3000);
                            }
                        } catch (err) {
                            alert(err?.message || 'Upload failed');
                            if (status) {
                                status.className = 'small font-weight-bold single-image-upload-status text-danger';
                                status.textContent = '❌ ล้มเหลว';
                            }
                        } finally {
                            if (btn) btn.disabled = false;
                            this.value = '';
                        }
                    };
                });
        }


        function textareaInput(
            blockId,
            field,
            label,
            value,
            rows = 3
        )
        {
            return `

                <div class="form-group">

                    <label>
                        ${escapeHtml(
                            label
                        )}
                    </label>

                    <textarea
                        class="
                            form-control
                            product-field
                        "
                        rows="${rows}"
                        data-block-id="${blockId}"
                        data-field="${field}"
                    >${escapeHtml(
                        value
                    )}</textarea>

                </div>

            `;
        }


        function richTextEditor(
            blockId,
            value,
            contentFormat = 'plain',
            textSize = 'normal'
        )
        {
            const normalizedTextSize =
                [
                    'normal',
                    'small',
                ].includes(
                    textSize
                )
                    ? textSize
                    : 'normal';


            return `

                <div class="form-group rich-text-editor-group">

                    <label>
                        Content
                    </label>


                    <div
                        class="rich-text-editor"
                        data-rich-text-editor="${escapeHtml(
                            blockId
                        )}"
                        data-content-format="${
                            contentFormat === 'html'
                                ? 'html'
                                : 'plain'
                        }"
                    >

                        <div class="rich-text-display-size-control">

                            <label>
                                Text Size
                            </label>


                            <select
                                class="
                                    form-control
                                    product-field
                                    rich-text-display-size
                                "
                                data-block-id="${escapeHtml(
                                    blockId
                                )}"
                                data-field="text_size"
                            >

                                <option
                                    value="normal"
                                    ${
                                        normalizedTextSize
                                        ===
                                        'normal'
                                            ? 'selected'
                                            : ''
                                    }
                                >
                                    Normal (Default)
                                </option>


                                <option
                                    value="small"
                                    ${
                                        normalizedTextSize
                                        ===
                                        'small'
                                            ? 'selected'
                                            : ''
                                    }
                                >
                                    Small
                                </option>

                            </select>

                        </div>

                        <div class="rich-text-toolbar">

                            <button
                                type="button"
                                class="btn btn-sm btn-light rich-text-command"
                                data-command="bold"
                                title="Bold"
                            >
                                <strong>B</strong>
                            </button>


                            <button
                                type="button"
                                class="btn btn-sm btn-light rich-text-command"
                                data-command="italic"
                                title="Italic"
                            >
                                <em>I</em>
                            </button>


                            <button
                                type="button"
                                class="btn btn-sm btn-light rich-text-command"
                                data-command="underline"
                                title="Underline"
                            >
                                <u>U</u>
                            </button>


                            <select
                                class="form-control form-control-sm rich-text-font"
                                title="Font"
                            >
                                <option value="">
                                    Font
                                </option>
                                <option value="Arial">
                                    Arial
                                </option>
                                <option value="Noto Sans JP">
                                    Noto Sans JP
                                </option>
                                <option value="serif">
                                    Serif
                                </option>
                                <option value="sans-serif">
                                    Sans Serif
                                </option>
                            </select>


                            <select
                                class="form-control form-control-sm rich-text-size"
                                title="Font size"
                            >
                                <option value="">
                                    Size
                                </option>
                                <option value="1">10px</option>
                                <option value="2">13px</option>
                                <option value="3">16px</option>
                                <option value="4">18px</option>
                                <option value="5">24px</option>
                                <option value="6">32px</option>
                                <option value="7">48px</option>
                            </select>


                            <label class="mb-0 small" title="Text color">
                                Color

                                <input
                                    type="color"
                                    class="rich-text-color"
                                    value="#000000"
                                >
                            </label>


                            <button
                                type="button"
                                class="btn btn-sm btn-outline-secondary rich-text-command"
                                data-command="removeFormat"
                                title="Clear formatting"
                            >
                                Clear
                            </button>

                        </div>


                        <div
                            class="rich-text-surface ${
                                normalizedTextSize
                                ===
                                'small'
                                    ? 'rich-text-surface-small'
                                    : ''
                            }"
                            contenteditable="true"
                            role="textbox"
                            aria-multiline="true"
                            spellcheck="true"
                        ></div>


                        <textarea
                            hidden
                            class="product-field rich-text-value"
                            data-block-id="${escapeHtml(
                                blockId
                            )}"
                            data-field="content"
                        >${escapeHtml(
                            value
                        )}</textarea>


                        <input
                            type="hidden"
                            class="product-field"
                            data-block-id="${escapeHtml(
                                blockId
                            )}"
                            data-field="content_format"
                            value="html"
                        >

                    </div>

                </div>

            `;
        }


        function sanitizeRichTextEditorHtml(
            html
        )
        {
            const template =
                document.createElement(
                    'template'
                );


            template.innerHTML =
                String(
                    html
                    ?? ''
                );


            const allowedTags =
                new Set([
                    'B',
                    'STRONG',
                    'I',
                    'EM',
                    'U',
                    'BR',
                    'P',
                    'DIV',
                    'UL',
                    'OL',
                    'LI',
                    'FONT',
                ]);


            Array
                .from(
                    template.content
                        .querySelectorAll('*')
                )
                .forEach(
                    function (element) {

                        if (
                            [
                                'SCRIPT',
                                'STYLE',
                                'IFRAME',
                                'OBJECT',
                            ]
                            .includes(
                                element.tagName
                            )
                        ) {

                            element.remove();

                            return;

                        }


                        if (
                            !allowedTags.has(
                                element.tagName
                            )
                        ) {

                            element.replaceWith(
                                ...element.childNodes
                            );

                            return;

                        }


                        const fontColor =
                            element.tagName === 'FONT'
                                ? element.getAttribute('color')
                                : null;


                        const fontSize =
                            element.tagName === 'FONT'
                                ? element.getAttribute('size')
                                : null;


                        const fontFace =
                            element.tagName === 'FONT'
                                ? element.getAttribute('face')
                                : null;


                        Array
                            .from(
                                element.attributes
                            )
                            .forEach(
                                attribute =>
                                    element.removeAttribute(
                                        attribute.name
                                    )
                            );


                        if (
                            fontColor
                            &&
                            /^#[0-9a-fA-F]{6}$/.test(
                                fontColor
                            )
                        ) {

                            element.setAttribute(
                                'color',
                                fontColor.toLowerCase()
                            );

                        }


                        if (
                            fontSize
                            &&
                            /^[1-7]$/.test(
                                fontSize
                            )
                        ) {

                            element.setAttribute(
                                'size',
                                fontSize
                            );

                        }


                        if (
                            [
                                'Arial',
                                'Noto Sans JP',
                                'serif',
                                'sans-serif',
                            ]
                            .includes(
                                fontFace
                            )
                        ) {

                            element.setAttribute(
                                'face',
                                fontFace
                            );

                        }

                    }
                );


            return template.innerHTML;
        }


        function bindRichTextEditors()
        {
            document
                .querySelectorAll(
                    '[data-rich-text-editor]'
                )
                .forEach(
                    function (wrapper) {

                        const editor =
                            wrapper.querySelector(
                                '.rich-text-surface'
                            );


                        const valueField =
                            wrapper.querySelector(
                                '.rich-text-value'
                            );


                        if (
                            !editor
                            ||
                            !valueField
                        ) {

                            return;

                        }


                        const initialValue =
                            valueField.value;


                        editor.innerHTML =
                            wrapper.dataset
                                .contentFormat
                            === 'html'
                                ? sanitizeRichTextEditorHtml(
                                    initialValue
                                )
                                : escapeHtml(
                                    initialValue
                                )
                                .replace(
                                    /\r?\n/g,
                                    '<br>'
                                );


                        const displaySize =
                            wrapper.querySelector(
                                '.rich-text-display-size'
                            );


                        const applyDisplaySize =
                            function () {

                                editor.classList.toggle(
                                    'rich-text-surface-small',
                                    displaySize
                                        ?.value
                                    ===
                                    'small'
                                );

                            };


                        applyDisplaySize();


                        displaySize?.addEventListener(
                            'change',
                            applyDisplaySize
                        );


                        const sync =
                            function () {

                                valueField.value =
                                    sanitizeRichTextEditorHtml(
                                        editor.innerHTML
                                    );

                            };


                        let savedRange =
                            null;


                        const saveSelection =
                            function () {

                                const selection =
                                    window.getSelection();


                                if (
                                    selection
                                    &&
                                    selection.rangeCount > 0
                                    &&
                                    editor.contains(
                                        selection.anchorNode
                                    )
                                ) {

                                    savedRange =
                                        selection
                                            .getRangeAt(0)
                                            .cloneRange();

                                }

                            };


                        const restoreSelection =
                            function () {

                                if (
                                    !savedRange
                                ) {

                                    return;

                                }


                                const selection =
                                    window.getSelection();


                                selection.removeAllRanges();
                                selection.addRange(
                                    savedRange
                                );

                            };


                        const runCommand =
                            function (
                                command,
                                commandValue = null
                            ) {

                                restoreSelection();
                                editor.focus();


                                document.execCommand(
                                    command,
                                    false,
                                    commandValue
                                );


                                saveSelection();
                                sync();

                            };


                        editor.addEventListener(
                            'input',
                            sync
                        );


                        editor.addEventListener(
                            'mouseup',
                            saveSelection
                        );


                        editor.addEventListener(
                            'keyup',
                            saveSelection
                        );


                        wrapper
                            .querySelectorAll(
                                '.rich-text-command'
                            )
                            .forEach(
                                function (button) {

                                    button.addEventListener(
                                        'mousedown',
                                        function (event) {
                                            event.preventDefault();
                                        }
                                    );


                                    button.addEventListener(
                                        'click',
                                        function () {

                                            runCommand(
                                                this.dataset
                                                    .command
                                            );

                                        }
                                    );

                                }
                            );


                        const font =
                            wrapper.querySelector(
                                '.rich-text-font'
                            );


                        font?.addEventListener(
                            'mousedown',
                            saveSelection
                        );


                        font?.addEventListener(
                            'change',
                            function () {

                                if (
                                    this.value
                                ) {

                                    runCommand(
                                        'fontName',
                                        this.value
                                    );

                                }


                                this.value =
                                    '';

                            }
                        );


                        const size =
                            wrapper.querySelector(
                                '.rich-text-size'
                            );


                        size?.addEventListener(
                            'mousedown',
                            saveSelection
                        );


                        size?.addEventListener(
                            'change',
                            function () {

                                if (
                                    this.value
                                ) {

                                    runCommand(
                                        'fontSize',
                                        this.value
                                    );

                                }


                                this.value =
                                    '';

                            }
                        );


                        const color =
                            wrapper.querySelector(
                                '.rich-text-color'
                            );


                        color?.addEventListener(
                            'mousedown',
                            saveSelection
                        );


                        color?.addEventListener(
                            'input',
                            function () {

                                runCommand(
                                    'foreColor',
                                    this.value
                                );

                            }
                        );


                        sync();

                    }
                );
        }


        function systemMessage(
            message
        )
        {
            return `

                <div class="system-component">

                    🔒

                    ${escapeHtml(
                        message
                    )}

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Collect Content
        |--------------------------------------------------------------------------
        */

        function collectContent()
        {
            const result =
                {};


            /*
             * Normal Fields
             */
            document
                .querySelectorAll(
                    '.product-field'
                )
                .forEach(
                    function (field) {

                        const blockId =
                            field.dataset
                                .blockId;


                        const key =
                            field.dataset
                                .field;


                        if (
                            !blockId
                            ||
                            !key
                        ) {

                            return;

                        }


                        result[
                            blockId
                        ] ??=
                            {};


                        result[
                            blockId
                        ][
                            key
                        ] =
                            field.type === 'checkbox'

                            ? field.checked

                            : field.value;

                    }
                );


            /*
             * Gallery
             */
            document
                .querySelectorAll(
                    '.gallery-list'
                )
                .forEach(
                    function (list) {

                        const blockId =
                            list.dataset
                                .blockId;


                        result[
                            blockId
                        ] ??=
                            {};


                        result[
                            blockId
                        ].images =
                            Array
                                .from(
                                    list.querySelectorAll(
                                        '.gallery-image'
                                    )
                                )
                                .map(
                                    input =>
                                        input.value
                                            .trim()
                                )
                                .filter(
                                    Boolean
                                );

                    }
                );


            /*
             * Shipping Schedule
             */
            document
                .querySelectorAll(
                    '.shipping-schedule-editor'
                )
                .forEach(
                    function (editor) {

                        const blockId =
                            editor.dataset
                                .shippingScheduleBlock;


                        result[
                            blockId
                        ] =
                            collectShippingScheduleData(
                                blockId
                            );

                    }
                );


            /*
             * Flexible Custom Table V2
             */
            document
                .querySelectorAll(
                    '.flex-table-editor'
                )
                .forEach(
                    function (editor) {

                        const blockId =
                            editor.dataset
                                .flexTableBlock;


                        result[
                            blockId
                        ] =
                            collectFlexibleTableData(
                                blockId
                            );

                    }
                );


            /*
             * OptionCardGrid
             */
            document
                .querySelectorAll(
                    '.option-card-grid-container'
                )
                .forEach(
                    function (container) {

                        const blockId =
                            container.dataset
                                .optionGridBlock;

                        if (blockId) {
                            result[
                                blockId
                            ] =
                                collectOptionCardGridData(
                                    blockId
                                );
                        }

                    }
                );


            return result;
        }


        /*
        |--------------------------------------------------------------------------
        | Save Draft
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'save-draft'
            )
            .onclick =
                function () {

                    saveDraft(
                        true
                    );

                };


        async function saveDraft(
            showMessage = true
        )
        {
            const tableError =
                validateFlexibleTables();


            if (
                tableError
            ) {

                alert(
                    tableError
                );


                setStatus(
                    'Table error'
                );


                return false;

            }


            const button =
                document.getElementById(
                    'save-draft'
                );


            try {

                button.disabled =
                    true;


                setStatus(
                    'Saving...'
                );


                const content =
                    collectContent();


                const response =
                    await fetch(
                        `/api/v1/admin/products/${productId}/page`,
                        {
                            method:
                                'PUT',

                            credentials:
                                'same-origin',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrf,

                            },

                            body:
                                JSON.stringify({

                                    blocks:
                                        content,

                                }),
                        }
                    );


                const result =
                    await response.json();


                if (
                    !response.ok
                ) {

                    throw result;

                }


                contents =
                    result
                        .data
                        ?.draft_content_json
                        ?.blocks
                    ??
                    content;


                setStatus(
                    'Draft saved'
                );


                if (
                    showMessage
                ) {

                    alert(
                        'Product content saved.'
                    );

                }


                return true;

            } catch (error) {

                console.error(
                    error
                );


                setStatus(
                    'Save failed'
                );


                alert(
                    formatError(
                        error
                    )
                );


                return false;

            } finally {

                button.disabled =
                    false;

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Publish
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'publish-product'
            )
            .onclick =
                async function () {

                    const saved =
                        await saveDraft(
                            false
                        );


                    if (
                        !saved
                    ) {

                        return;

                    }


                    if (
                        !confirm(
                            'Publish this Product Page?'
                        )
                    ) {

                        return;

                    }


                    try {

                        this.disabled =
                            true;


                        setStatus(
                            'Publishing...'
                        );


                        const response =
                            await fetch(
                                `/api/v1/admin/products/${productId}/page/publish`,
                                {
                                    method:
                                        'POST',

                                    credentials:
                                        'same-origin',

                                    headers: {

                                        'Accept':
                                            'application/json',

                                        'X-CSRF-TOKEN':
                                            csrf,

                                    },
                                }
                            );


                        const result =
                            await response.json();


                        if (
                            !response.ok
                        ) {

                            throw result;

                        }


                        setStatus(
                            'Published'
                        );


                        alert(
                            'Product Page published successfully.'
                        );

                    } catch (error) {

                        console.error(
                            error
                        );


                        setStatus(
                            'Publish failed'
                        );


                        alert(
                            formatError(
                                error
                            )
                        );

                    } finally {

                        this.disabled =
                            false;

                    }

                };


        /*
        |--------------------------------------------------------------------------
        | Helpers
        |--------------------------------------------------------------------------
        */

        function getEffectiveBlockId(
            block
        )
        {
            const customId =
                String(
                    block.settings
                        ?.custom_id
                    ?? ''
                )
                .trim();

            const effectiveId =
                customId !== ''
                    ? customId
                    : block.id;

            return String(effectiveId)
                .replace(
                    /[^A-Za-z0-9\-_:.]/g,
                    '-'
                );
        }


        function getAllBlockIds()
        {
            const ids = [];


            function collectBlocks(
                blocks
            )
            {
                (
                    blocks
                    ?? []
                )
                .forEach(
                    function (block) {

                        const blockContent =
                            contents[block.id]
                            ?? {};

                        let label = '';

                        if (blockContent.title) {
                            label = blockContent.title;
                        } else if (blockContent.text) {
                            label = blockContent.text;
                        } else if (blockContent.heading) {
                            label = blockContent.heading;
                        } else if (block.settings?.title) {
                            label = block.settings.title;
                        }

                        if (label && label.length > 25) {
                            label = label.substring(0, 25) + '...';
                        }

                        ids.push({

                            id:
                                getEffectiveBlockId(
                                    block
                                ),

                            rawId:
                                block.id,

                            type:
                                getBlockName(
                                    block.type
                                ),

                            label:
                                label,

                        });


                        if (
                            block.children
                        ) {

                            collectBlocks(
                                block.children
                            );

                        }

                    }
                );
            }


            (
                layout?.rows
                ?? []
            )
            .forEach(
                function (row) {

                    (
                        row.columns
                        ?? []
                    )
                    .forEach(
                        function (column) {

                            collectBlocks(
                                column.blocks
                            );

                        }
                    );

                }
            );


            return ids;
        }


        function linkUrlInput(
            blockId,
            field,
            label,
            value
        )
        {
            const allBlocks =
                getAllBlockIds();

            const currentValue =
                String(value ?? '').trim();


            const options =
                allBlocks
                    .map(
                        function (b) {

                            const optVal =
                                '#' + b.id;

                            const isSelected =
                                currentValue === optVal
                                ||
                                currentValue === b.id;

                            const labelText =
                                b.label
                                ? ` ("${escapeHtml(b.label)}")`
                                : '';

                            return `
                                <option
                                    value="${escapeHtml(optVal)}"
                                    data-raw-id="${escapeHtml(b.rawId)}"
                                    ${isSelected ? 'selected' : ''}
                                >
                                    ${escapeHtml(optVal)} — ${escapeHtml(b.type)}${labelText}
                                </option>
                            `;

                        }
                    )
                    .join('');


            return `

                <div class="form-group link-url-group">

                    <label>
                        ${escapeHtml(
                            label
                        )}
                    </label>

                    <div class="input-group">

                        <input
                            type="text"
                            class="
                                form-control
                                product-field
                            "
                            data-block-id="${blockId}"
                            data-field="${field}"
                            value="${escapeHtml(
                                value ?? ''
                            )}"
                            placeholder="https://... or #block-id"
                        >

                        <div class="input-group-append">

                            <button
                                type="button"
                                class="btn btn-outline-info"
                                data-link-jump-for="${blockId}"
                                data-link-jump-field="${field}"
                                title="Jump to this block in editor or test link"
                            >
                                <i class="fas fa-external-link-alt"></i> Go to Block
                            </button>

                        </div>

                    </div>

                    <div class="link-url-block-picker">

                        <select
                            data-link-picker-for="${blockId}"
                            data-link-picker-field="${field}"
                        >

                            <option value="">
                                — Select Block ID —
                            </option>

                            ${options}

                        </select>

                        <button
                            type="button"
                            class="btn btn-outline-primary btn-sm"
                            data-link-picker-apply="${blockId}"
                            data-link-picker-apply-field="${field}"
                            title="Insert selected block ID into URL field"
                        >
                            Select
                        </button>

                    </div>

                    <small class="form-text">
                        Enter a URL (e.g. <code>https://...</code>) or select a Block ID (e.g. <code>#block-id</code>) to link to a section.
                    </small>

                </div>

            `;
        }


        function scrollToBlock(
            targetIdOrUrl
        )
        {
            if (
                !targetIdOrUrl
            ) {

                alert(
                    'Please enter or select a URL or Block ID.'
                );

                return;

            }

            const str =
                String(targetIdOrUrl).trim();

            if (
                str.startsWith('http://')
                ||
                str.startsWith('https://')
            ) {

                window.open(str, '_blank');

                return;

            }

            const cleanId =
                str.replace(/^#/, '').trim();

            if (
                !cleanId
            ) {

                return;

            }

            // Look for block element in canvas
            let targetEl =
                document.querySelector(
                    `.content-block[data-block-id="${CSS.escape(cleanId)}"]`
                );

            if (
                !targetEl
            ) {

                const allBlocks =
                    getAllBlockIds();

                const found =
                    allBlocks.find(
                        function (b) {

                            return b.id === cleanId
                                || b.rawId === cleanId;

                        }
                    );

                if (
                    found
                ) {

                    targetEl =
                        document.querySelector(
                            `.content-block[data-block-id="${CSS.escape(found.rawId)}"]`
                        );

                }

            }

            if (
                targetEl
            ) {

                targetEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                });

                targetEl.classList.remove(
                    'content-block-highlighted'
                );

                void targetEl.offsetWidth;

                targetEl.classList.add(
                    'content-block-highlighted'
                );

                setTimeout(
                    function () {

                        targetEl.classList.remove(
                            'content-block-highlighted'
                        );

                    },
                    2500
                );

            } else {

                alert(
                    `Block "#${cleanId}" was not found on this page.`
                );

            }
        }


        function bindLinkUrlPickers()
        {
            // Apply button click
            document
                .querySelectorAll(
                    '[data-link-picker-apply]'
                )
                .forEach(
                    function (btn) {

                        btn.addEventListener(
                            'click',
                            function () {

                                const blockId =
                                    this.dataset
                                        .linkPickerApply;

                                const field =
                                    this.dataset
                                        .linkPickerApplyField;

                                const select =
                                    document.querySelector(
                                        `[data-link-picker-for="${blockId}"][data-link-picker-field="${field}"]`
                                    );

                                const input =
                                    document.querySelector(
                                        `[data-block-id="${blockId}"][data-field="${field}"]`
                                    );

                                if (
                                    !select
                                    ||
                                    !input
                                    ||
                                    !select.value
                                ) {

                                    return;

                                }

                                input.value =
                                    select.value;

                                input.dispatchEvent(
                                    new Event(
                                        'input',
                                        {
                                            bubbles: true,
                                        }
                                    )
                                );

                            }
                        );

                    }
                );

            // Select change auto-apply
            document
                .querySelectorAll(
                    '[data-link-picker-for]'
                )
                .forEach(
                    function (select) {

                        select.addEventListener(
                            'change',
                            function () {

                                const blockId =
                                    this.dataset
                                        .linkPickerFor;

                                const field =
                                    this.dataset
                                        .linkPickerField;

                                const input =
                                    document.querySelector(
                                        `[data-block-id="${blockId}"][data-field="${field}"]`
                                    );

                                if (
                                    !input
                                    ||
                                    !this.value
                                ) {

                                    return;

                                }

                                input.value =
                                    this.value;

                                input.dispatchEvent(
                                    new Event(
                                        'input',
                                        {
                                            bubbles: true,
                                        }
                                    )
                                );

                            }
                        );

                    }
                );

            // Go to block / Jump button click
            document
                .querySelectorAll(
                    '[data-link-jump-for]'
                )
                .forEach(
                    function (btn) {

                        btn.addEventListener(
                            'click',
                            function () {

                                const blockId =
                                    this.dataset
                                        .linkJumpFor;

                                const field =
                                    this.dataset
                                        .linkJumpField;

                                const input =
                                    document.querySelector(
                                        `[data-block-id="${blockId}"][data-field="${field}"]`
                                    );

                                const val =
                                    input
                                    ? input.value
                                    : '';

                                scrollToBlock(
                                    val
                                );

                            }
                        );

                    }
                );
        }


        function getBlockName(
            type
        )
        {
            const names = {

                product_header:
                    'Product Header',

                product_gallery:
                    'Product Gallery',

                product_details:
                    'Product Details',

                template_button:
                    'Template Button',

                heading:
                    'Heading',

                rich_text:
                    'Text',

                image:
                    'Image',

                button:
                    'Button',

                text_link:
                    'Text Link',

                custom_table:
                    'Custom Table',

                info_card:
                    'Info Card',

                accordion:
                    'Accordion',

                option_card_grid:
                    'OptionCardGrid',

                price_accordion:
                    'Price',

                shipping_schedule:
                    'Shipping Schedule',

                production_schedule:
                    'Production Schedule',

                divider:
                    'Divider',

                spacer:
                    'Spacer',

            };


            return (
                names[
                    type
                ]
                ??
                type
            );
        }


        function getFileNameFromUrl(
            url
        )
        {
            try {

                return (

                    decodeURIComponent(
                        String(
                            url
                            ?? ''
                        )
                        .split('?')[0]
                        .split('/')
                        .pop()
                    )

                    ||

                    'Image'

                );

            } catch (error) {

                return 'Image';

            }
        }


        function formatMultiline(
            value
        )
        {
            return escapeHtml(
                value
            )
            .replaceAll(
                '\n',
                '<br>'
            );
        }


        function setStatus(
            message
        )
        {
            document
                .getElementById(
                    'save-status'
                )
                .textContent =
                    message;
        }


        function formatError(
            error
        )
        {
            if (
                error?.errors
            ) {

                return Object
                    .values(
                        error.errors
                    )
                    .flat()
                    .join(
                        '\n'
                    );

            }


            return (
                error?.message
                ??
                'An error occurred.'
            );
        }


        function escapeHtml(
            value
        )
        {
            return String(
                value
                ?? ''
            )
            .replaceAll(
                '&',
                '&amp;'
            )
            .replaceAll(
                '<',
                '&lt;'
            )
            .replaceAll(
                '>',
                '&gt;'
            )
            .replaceAll(
                '"',
                '&quot;'
            )
            .replaceAll(
                "'",
                '&#039;'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Start
        |--------------------------------------------------------------------------
        */

        loadEditor();

    }
);

</script>

@endpush
