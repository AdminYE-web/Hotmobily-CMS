@extends('admin.layouts.app')

@section('title', 'Product Layout Builder')

@section('content')

<div class="container-fluid">

    {{-- ============================================================
        HEADER
    ============================================================ --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <a href="{{ route('admin.product-layouts.index') }}">
                ← Product Layouts
            </a>

            <h1 class="h3 mt-2 mb-1">
                {{ $productLayout->name }}
            </h1>

            <small class="text-muted">
                Visual Product Layout Builder
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
                id="save-layout-draft"
            >
                Save Draft
            </button>

            <button
                type="button"
                class="btn btn-success"
                id="publish-layout"
            >
                Publish
            </button>

        </div>

    </div>


    <div class="row">

        {{-- ============================================================
            LEFT COMPONENT PANEL
        ============================================================ --}}
        <div class="col-xl-2 col-lg-3 mb-4">

            <div class="card shadow-sm builder-sidebar">

                <div class="card-header">
                    <strong>Components</strong>
                </div>


                <div class="card-body">

                    {{-- ====================================================
                        BASIC
                    ==================================================== --}}
                    <small class="component-category">
                        BASIC
                    </small>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="heading"
                    >
                        <span>H</span>
                        Heading
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="rich_text"
                    >
                        <span>¶</span>
                        Text
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="image"
                    >
                        <span>🖼</span>
                        Image
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="button"
                    >
                        <span>▣</span>
                        Button
                    </button>


                    {{-- NEW --}}
                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="text_link"
                    >
                        <span>🔗</span>
                        Text Link
                    </button>


                    {{-- NEW --}}
                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="custom_table"
                    >
                        <span>▦</span>
                        Custom Table
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="info_card"
                    >
                        <span>▤</span>
                        Info Card
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="accordion"
                    >
                        <span>☰</span>
                        Accordion
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="option_card_grid"
                    >
                        <span>🗂</span>
                        OptionCardGrid
                    </button>


                    <hr>


                    {{-- ====================================================
                        PRODUCT
                    ==================================================== --}}
                    <small class="component-category">
                        PRODUCT
                    </small>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="product_header"
                    >
                        Product Header
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="product_gallery"
                    >
                        Product Gallery
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="product_details"
                    >
                        Product Details
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="template_button"
                    >
                        Template Button
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="price_accordion"
                    >
                        Price
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="shipping_schedule"
                    >
                        Shipping Schedule
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="production_schedule"
                    >
                        Production Schedule
                    </button>


                    <hr>


                    {{-- ====================================================
                        LAYOUT
                    ==================================================== --}}
                    <small class="component-category">
                        LAYOUT
                    </small>


                    <button
                        type="button"
                        class="layout-preset-button add-row"
                        data-widths="12"
                    >
                        <span class="layout-mini one"></span>
                        100%
                    </button>


                    <button
                        type="button"
                        class="layout-preset-button add-row"
                        data-widths="6,6"
                    >
                        <span class="layout-mini two-equal"></span>
                        50% / 50%
                    </button>


                    <button
                        type="button"
                        class="layout-preset-button add-row"
                        data-widths="4,8"
                    >
                        <span class="layout-mini left-small"></span>
                        33% / 66%
                    </button>


                    <button
                        type="button"
                        class="layout-preset-button add-row"
                        data-widths="8,4"
                    >
                        <span class="layout-mini right-small"></span>
                        66% / 33%
                    </button>


                    <button
                        type="button"
                        class="layout-preset-button add-row"
                        data-widths="4,4,4"
                    >
                        <span class="layout-mini three"></span>
                        33% / 33% / 33%
                    </button>


                    <hr>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="divider"
                    >
                        <span>─</span>
                        Divider
                    </button>


                    <button
                        type="button"
                        class="component-button add-block"
                        data-type="spacer"
                    >
                        <span>↕</span>
                        Spacer
                    </button>


                    <div class="alert alert-light border mt-3 mb-0 small">

                        <strong>
                            How to use
                        </strong>

                        <br><br>

                        1. Add a Row

                        <br>

                        2. Click a Column

                        <br>

                        3. Add Components

                        <br>

                        4. Drag Components

                        <br>

                        5. Edit Block ID if needed

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
            PREVIEW
        ============================================================ --}}
        <div class="col-xl-10 col-lg-9">

            <div class="card shadow-sm">

                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div>

                            <strong>
                                Product Page Preview
                            </strong>

                            <span class="text-muted ml-2">
                                Row → Column → Component
                            </span>

                        </div>


                        <div class="btn-group btn-group-sm">

                            <button
                                type="button"
                                class="btn btn-primary preview-device"
                                data-device="desktop"
                            >
                                Desktop
                            </button>

                            <button
                                type="button"
                                class="btn btn-outline-primary preview-device"
                                data-device="tablet"
                            >
                                Tablet
                            </button>

                            <button
                                type="button"
                                class="btn btn-outline-primary preview-device"
                                data-device="mobile"
                            >
                                Mobile
                            </button>

                        </div>

                    </div>

                </div>


                <div class="card-body builder-area">

                    <div
                        id="preview-frame"
                        class="preview-frame preview-desktop"
                    >

                        <div class="preview-browser-bar">

                            <div class="preview-browser-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div class="preview-url">
                                hotmobily.jp/products/example-product
                            </div>

                        </div>


                        <div class="preview-page">

                            <div id="builder-canvas"></div>


                            <div
                                id="builder-empty"
                                class="builder-empty"
                            >

                                <div class="builder-empty-icon">
                                    +
                                </div>

                                <h5>
                                    Empty Product Layout
                                </h5>

                                <p class="text-muted text-center mb-3">
                                    Start by adding a row.
                                </p>

                                <button
                                    type="button"
                                    class="btn btn-primary add-first-row"
                                >
                                    + Add 100% Row
                                </button>

                            </div>


                            <div
                                id="preview-order-form"
                                class="preview-order-form"
                            >

                                <div>

                                    <strong>
                                        🔒 ご注文・見積書作成
                                    </strong>

                                    <div class="text-muted small mt-1">
                                        Order Form
                                    </div>

                                </div>

                                <span class="badge badge-secondary">
                                    SYSTEM
                                </span>

                            </div>


                            <div
                                id="builder-after-order-region"
                                class="builder-after-order-region d-none"
                            >

                                <div class="builder-region-label">
                                    Content after Order Form
                                </div>


                                <div id="builder-after-order-canvas"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ================================================================
    BLOCK SETTINGS MODAL
================================================================ --}}
<div
    class="modal fade"
    id="blockModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="block-modal-title"
                >
                    Block Settings
                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    &times;
                </button>

            </div>


            <div class="modal-body">

                <input
                    type="hidden"
                    id="editing-block-id"
                >


                <div class="form-group">

                    <label>
                        Internal ID
                    </label>

                    <input
                        type="text"
                        id="block-internal-id"
                        class="form-control"
                        readonly
                    >

                    <small class="form-text text-muted">
                        System ID. Product Content uses this ID internally.
                    </small>

                </div>


                <div class="form-group">

                    <label>
                        Block ID
                    </label>

                    <input
                        type="text"
                        id="block-custom-id"
                        class="form-control"
                        maxlength="100"
                        placeholder="Leave empty to use Auto ID"
                    >

                    <small class="form-text text-muted">

                        Optional HTML ID.

                        Example:

                        <code>product-gallery</code>,
                        <code>shipping-info</code>,
                        <code>product-table</code>

                        <br>

                        Leave empty to use the Internal ID automatically.

                    </small>


                    <div class="effective-id-box">

                        Effective ID:

                        <code id="block-effective-id"></code>

                    </div>

                </div>


                <hr>


                <div class="form-group">

                    <label>
                        Content Width
                    </label>

                    <select
                        id="content-width"
                        class="form-control"
                    >

                        <option value="100">
                            100%
                        </option>

                        <option value="75">
                            75%
                        </option>

                        <option value="50">
                            50%
                        </option>

                        <option value="33">
                            33%
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Content Alignment
                    </label>

                    <select
                        id="content-alignment"
                        class="form-control"
                    >

                        <option value="left">
                            Left
                        </option>

                        <option value="center">
                            Center
                        </option>

                        <option value="right">
                            Right
                        </option>

                    </select>

                </div>


                <hr>


                <div id="block-fields"></div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-danger mr-auto"
                    id="delete-block"
                >
                    Delete
                </button>

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="apply-block"
                >
                    Apply
                </button>

            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

/* ============================================================
   Sidebar
============================================================ */

.builder-sidebar {
    position: sticky;
    top: 20px;

    max-height: calc(100vh - 40px);

    overflow-y: auto;
}


.component-category {
    display: block;

    margin-bottom: 8px;

    font-size: 11px;
    font-weight: 700;
    letter-spacing: .6px;

    color: #888;
}


.component-button,
.layout-preset-button {
    width: 100%;

    display: flex;
    align-items: center;

    gap: 9px;

    padding: 9px 10px;
    margin-bottom: 7px;

    background: white;

    border: 1px solid #ddd;
    border-radius: 5px;

    cursor: pointer;

    text-align: left;

    font-size: 13px;

    transition: .15s;
}


.component-button:hover,
.layout-preset-button:hover {
    border-color: #007bff;

    background: #f5f9ff;

    color: #0069d9;
}


/* ============================================================
   Layout Mini
============================================================ */

.layout-mini {
    width: 34px;
    height: 20px;

    display: inline-flex;

    border: 1px solid #adb5bd;

    flex-shrink: 0;
}


.layout-mini.one {
    background: #f5f5f5;
}


.layout-mini.two-equal {
    background:
        linear-gradient(
            to right,
            #f5f5f5 49%,
            #adb5bd 49%,
            #adb5bd 51%,
            #f5f5f5 51%
        );
}


.layout-mini.left-small {
    background:
        linear-gradient(
            to right,
            #f5f5f5 32%,
            #adb5bd 32%,
            #adb5bd 34%,
            #f5f5f5 34%
        );
}


.layout-mini.right-small {
    background:
        linear-gradient(
            to right,
            #f5f5f5 66%,
            #adb5bd 66%,
            #adb5bd 68%,
            #f5f5f5 68%
        );
}


.layout-mini.three {
    background:
        linear-gradient(
            to right,
            #f5f5f5 32%,
            #adb5bd 32%,
            #adb5bd 34%,
            #f5f5f5 34%,
            #f5f5f5 65%,
            #adb5bd 65%,
            #adb5bd 67%,
            #f5f5f5 67%
        );
}


/* ============================================================
   Builder
============================================================ */

.builder-area {
    min-height: 800px;

    padding: 20px;

    overflow-x: auto;

    background: #eef0f3;
}


.preview-frame {
    margin: 0 auto;

    background: white;

    border: 1px solid #ccd1d6;
    border-radius: 8px;

    overflow: hidden;

    transition: width .25s ease;

    box-shadow:
        0 5px 25px rgba(0, 0, 0, .08);
}


.preview-desktop {
    width: 100%;
}


.preview-tablet {
    width: 768px;
    max-width: 100%;
}


.preview-mobile {
    width: 390px;
    max-width: 100%;
}


/* ============================================================
   Fake Browser
============================================================ */

.preview-browser-bar {
    height: 44px;

    display: flex;
    align-items: center;

    padding: 0 14px;

    background: #f1f3f5;

    border-bottom: 1px solid #ddd;
}


.preview-browser-dots {
    display: flex;

    gap: 6px;
}


.preview-browser-dots span {
    width: 10px;
    height: 10px;

    border-radius: 50%;

    background: #adb5bd;
}


.preview-url {
    flex: 1;

    margin-left: 18px;

    padding: 5px 12px;

    background: white;

    border: 1px solid #ddd;
    border-radius: 5px;

    font-size: 11px;

    color: #888;
}


.preview-page {
    min-height: 800px;

    padding: 30px;

    background: white;
}


/* ============================================================
   Row
============================================================ */

.layout-row {
    position: relative;

    display: flex;
    flex-wrap: wrap;

    margin: 0 -7px 16px;

    padding-top: 30px;

    border: 1px dashed transparent;

    transition: .15s;
}


.layout-row:hover {
    border-color: #9ec5fe;

    background: rgba(0, 123, 255, .015);
}


.layout-row-toolbar {
    position: absolute;

    top: 0;
    left: 0;
    right: 0;

    z-index: 100;

    height: 26px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 2px 7px;

    background: rgba(13, 110, 253, .08);

    opacity: 0;

    transition: opacity .15s;
}


.layout-row:hover .layout-row-toolbar {
    opacity: 1;
}


.row-drag-handle {
    cursor: move;

    font-size: 11px;
    font-weight: 700;

    color: #0d6efd;
}


.row-actions {
    display: flex;

    gap: 4px;
}


.row-actions .btn {
    padding: 1px 6px;

    font-size: 9px;
}


.row-placement-control {
    display: flex;
    align-items: center;

    gap: 5px;

    margin-left: auto;
    margin-right: 8px;

    color: #495057;

    font-size: 10px;
    font-weight: 600;
}


.row-placement-control select {
    height: 22px;

    padding: 0 4px;

    border: 1px solid #b8c7dd;
    border-radius: 3px;

    background: #fff;

    font-size: 10px;
}


/* ============================================================
   Column
============================================================ */

.layout-column {
    flex: 0 0 var(--column-width);
    max-width: var(--column-width);

    padding: 0 7px;
}


.column-shell {
    position: relative;

    min-height: 120px;

    padding: 8px;

    background: #fafafa;

    border: 1px dashed #ccc;
    border-radius: 5px;

    transition: .15s;
}


.column-shell:hover {
    border-color: #6ea8fe;
}


.column-shell.selected-column {
    border: 2px solid #0d6efd;

    background: #f6faff;
}


.column-width-label {
    position: absolute;

    top: 3px;
    right: 4px;

    z-index: 20;

    padding: 1px 5px;

    background: rgba(0, 0, 0, .07);

    border-radius: 3px;

    color: #777;

    font-size: 9px;
}


.column-block-list {
    min-height: 70px;

    padding-top: 18px;
}


.column-drop-message {
    padding: 20px 10px;

    text-align: center;

    color: #aaa;

    font-size: 11px;

    pointer-events: none;
}


/* ============================================================
   Block
============================================================ */

.builder-block {
    margin-bottom: 10px;
}


.builder-block-inner {
    position: relative;

    width: 100%;

    padding-top: 31px;

    border: 1px dashed transparent;

    background: white;

    transition: .15s;
}


.builder-block-inner:hover {
    border-color: #007bff;

    box-shadow:
        0 0 0 2px rgba(0, 123, 255, .08);
}


.builder-block-toolbar {
    position: absolute;

    top: 4px;
    left: 4px;
    right: 4px;

    z-index: 50;

    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 4px 6px;

    background: rgba(33, 37, 41, .92);

    color: white;

    border-radius: 4px;

    opacity: 0;

    transition: opacity .15s;
}


.builder-block-inner:hover
.builder-block-toolbar {
    opacity: 1;
}


.block-drag-handle {
    cursor: move;

    display: flex;
    align-items: center;

    gap: 5px;

    font-size: 11px;
    font-weight: 600;
}


.block-effective-id-label {
    max-width: 220px;

    overflow: hidden;

    text-overflow: ellipsis;
    white-space: nowrap;

    padding: 1px 5px;

    border-radius: 3px;

    background: rgba(255, 255, 255, .15);

    color: #dcecff;

    font-family: monospace;

    font-size: 9px;
}


.block-actions {
    display: flex;

    gap: 3px;
}


.block-actions button {
    padding: 1px 5px;

    font-size: 9px;
}


.system-label {
    padding: 2px 4px;

    background: #007bff;

    border-radius: 3px;

    color: white;

    font-size: 8px;
}


/* ============================================================
   Content Position
============================================================ */

.sim-content-position {
    width: 100%;

    display: flex;
}


.sim-content-box {
    min-width: 0;
}


/* ============================================================
   Product Header
============================================================ */

.sim-product-header {
    padding: 8px 0 14px;
}


.sim-product-header h1 {
    margin: 0 0 10px;

    font-size: 25px;

    font-weight: 700;
}


.sim-social {
    display: flex;
    align-items: center;

    gap: 7px;

    color: #777;

    font-size: 11px;
}


/* ============================================================
   Gallery
============================================================ */

.sim-gallery-main {
    aspect-ratio: 1 / 1;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #eee;

    border: 1px solid #ddd;

    color: #aaa;

    font-size: 52px;
}


.sim-gallery-thumbs {
    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 6px;

    margin-top: 6px;
}


.sim-gallery-thumb {
    min-height: 90px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #f2f2f2;

    border: 1px solid #ddd;

    color: #bbb;
}


/* ============================================================
   Product Details
============================================================ */

.sim-product-details {
    padding: 5px 0;
}


.sim-price-box {
    margin-bottom: 3px;

    padding: 7px;

    background: #eee;

    font-size: 18px;
}


.sim-red-heading {
    margin-top: 20px;

    color: #dc3545;

    font-size: 18px;
    font-weight: 700;
}


/* ============================================================
   Image
============================================================ */

.sim-image-placeholder {
    min-height: 180px;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    background: #eee;

    border: 1px solid #ddd;

    color: #aaa;
}


.sim-image-icon {
    font-size: 38px;
}


/* ============================================================
   Text Link
============================================================ */

.sim-text-link {
    display: inline-flex;
    align-items: center;

    gap: 5px;

    color: #007bff;

    font-size: 16px;

    text-decoration: underline;
}


.sim-text-link:hover {
    color: #0056b3;

    text-decoration: underline;
}


/* ============================================================
   Info Card
============================================================ */

.sim-info-card {
    overflow: hidden;

    border: 1px solid #ddd;
    border-radius: 5px;
}


.sim-info-image {
    height: 130px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #eee;

    color: #aaa;

    font-size: 32px;
}


.sim-info-content {
    padding: 12px;
}


/* ============================================================
   Accordion
============================================================ */

.sim-accordion {
    overflow: hidden;

    border: 1px solid #ddd;
    border-radius: 5px;
}


.sim-accordion-header {
    padding: 11px 13px;

    background: #eee;

    font-weight: 700;
}


.sim-accordion-body {
    padding: 12px;

    background: white;
}


.accordion-block-list {
    min-height: 90px;

    padding: 8px;

    border: 1px dashed #bbb;

    border-radius: 4px;

    background: #fafafa;
}


.accordion-block-list.selected-accordion {
    border: 2px solid #6f42c1;

    background: #fbf8ff;
}


.accordion-drop-message {
    padding: 16px;

    text-align: center;

    color: #aaa;

    font-size: 11px;
}


/* ============================================================
   Table
============================================================ */

.sim-table {
    width: 100%;

    border-collapse: collapse;

    text-align: center;
}


.sim-table th,
.sim-table td {
    padding: 8px;

    border: 1px solid #bbb;
}


.sim-table th {
    background: #f1f1f1;

    font-weight: 700;
}


.sim-custom-table-title {
    margin-bottom: 8px;

    font-weight: 700;
}


/* ============================================================
   Option Card Grid
============================================================ */

.sim-option-card-grid {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 6px;
    overflow: hidden;
    background: #fff;
    font-family: inherit;
}

.sim-option-header {
    padding: 8px 12px;
    background: #faf7f5;
    border-bottom: 1px solid #eee;
    font-weight: 700;
    font-size: 12px;
    color: #e67e22;
    display: flex;
    align-items: center;
    gap: 6px;
}

.sim-tab-menu {
    display: flex;
    border-bottom: 1px solid #ddd;
    background: #faf7f5;
}

.sim-tab-link {
    flex: 1;
    padding: 9px 12px;
    border: none;
    border-right: 1px solid #ddd;
    background: transparent;
    cursor: pointer;
    font-size: 11px;
    font-weight: 700;
    color: #e67e22;
    text-align: center;
    white-space: nowrap;
    transition: all 0.2s;
}

.sim-tab-link:last-child {
    border-right: none;
}

.sim-tab-link.active {
    background: #fff;
    border-top: 3px solid #e67e22;
    border-bottom: 1px solid #fff;
    margin-bottom: -1px;
    color: #d35400;
}

.sim-tab-content {
    padding: 12px;
    background: #fff;
}

.sim-parts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(95px, 1fr));
    gap: 8px;
}

.sim-part-card {
    border: 1px solid #eee;
    border-radius: 4px;
    padding: 6px 4px;
    text-align: center;
    background: #fafafa;
    font-size: 10px;
}

.sim-part-img {
    width: 50px;
    height: 50px;
    object-fit: contain;
    margin: 0 auto 4px;
    display: block;
    background: #fff;
    border-radius: 4px;
}

.sim-part-badge {
    display: inline-block;
    padding: 1px 6px;
    border-radius: 3px;
    background: #eef7ee;
    color: #27ae60;
    font-weight: 700;
    font-size: 10px;
    margin-bottom: 2px;
}

.sim-part-badge.badge-extra {
    background: #fff3e0;
    color: #e67e22;
}

.sim-part-title {
    font-size: 9px;
    line-height: 1.2;
    color: #555;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.sim-features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 10px;
}

.sim-feature-card {
    border: 1px solid #eee;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
}

.sim-feature-card img {
    width: 100%;
    height: 85px;
    object-fit: cover;
    display: block;
    background: #f0f0f0;
}

.sim-feature-card-body {
    padding: 7px 9px;
    font-size: 11px;
}

.sim-feature-card-desc {
    color: #555;
    font-size: 10px;
    line-height: 1.35;
    margin-bottom: 4px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.sim-feature-card-link {
    color: #007bff;
    font-size: 10px;
    text-decoration: underline;
}


/* ============================================================
   Spacer
============================================================ */

.sim-spacer {
    width: 100%;

    border: 1px dashed #ddd;

    background:
        repeating-linear-gradient(
            45deg,
            #fafafa,
            #fafafa 10px,
            #f1f1f1 10px,
            #f1f1f1 20px
        );
}


/* ============================================================
   Empty
============================================================ */

.builder-empty {
    min-height: 450px;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    border: 2px dashed #ccc;
    border-radius: 5px;

    background: #fafafa;
}


.builder-empty-icon {
    width: 55px;
    height: 55px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-bottom: 15px;

    border-radius: 50%;

    background: #e9ecef;

    font-size: 30px;
}


/* ============================================================
   Order Form
============================================================ */

.preview-order-form {
    margin-top: 25px;

    padding: 20px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    border: 2px dashed #dc3545;
    border-radius: 5px;

    background: #fff8f8;
}


.builder-after-order-region {
    margin-top: 25px;
}


.builder-region-label {
    margin-bottom: 10px;

    color: #842029;

    font-size: 12px;
    font-weight: 700;
}


/* ============================================================
   Effective ID
============================================================ */

.effective-id-box {
    margin-top: 8px;

    padding: 8px 10px;

    background: #f8f9fa;

    border: 1px solid #ddd;
    border-radius: 4px;

    font-size: 12px;
}


/* ============================================================
   Sortable
============================================================ */

.sortable-ghost {
    opacity: .2;
}


.sortable-chosen {
    opacity: .8;
}


/* ============================================================
   Responsive
============================================================ */

.preview-mobile .preview-page {
    padding: 15px;
}


.preview-mobile .layout-column {
    flex: 0 0 100% !important;
    max-width: 100% !important;

    margin-bottom: 10px;
}


@media (max-width: 991px) {

    .builder-sidebar {
        position: static;

        max-height: none;
    }

}

</style>

@endpush


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | Setup
        |--------------------------------------------------------------------------
        */

        const layoutId =
            {{ $productLayout->id }};


        const csrf =
            document
                .querySelector(
                    'meta[name="csrf-token"]'
                )
                ?.getAttribute(
                    'content'
                );


        const canvas =
            document.getElementById(
                'builder-canvas'
            );


        const afterOrderCanvas =
            document.getElementById(
                'builder-after-order-canvas'
            );


        const afterOrderRegion =
            document.getElementById(
                'builder-after-order-region'
            );


        const modal =
            $('#blockModal');


        let rows =
            [];


        let selectedColumnId =
            null;


        let selectedAccordionId =
            null;


        let editingBlockId =
            null;


        let sortableInstances =
            [];


        /*
        |--------------------------------------------------------------------------
        | Load
        |--------------------------------------------------------------------------
        */

        async function loadLayout()
        {
            try {

                const response =
                    await fetch(
                        `/api/v1/admin/product-layouts/${layoutId}`,
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


                if (!response.ok) {
                    throw result;
                }


                rows =
                    result
                        .data
                        ?.draft_layout_json
                        ?.rows
                    ?? [];


                normalizeRows();


                selectedColumnId =
                    getFirstColumnId();


                render();

            } catch (error) {

                console.error(
                    error
                );


                alert(
                    formatApiError(
                        error
                    )
                );

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Normalize
        |--------------------------------------------------------------------------
        */

        function normalizeRows()
        {
            rows =
                Array.isArray(
                    rows
                )
                    ? rows
                    : [];


            rows.forEach(
                function (row) {

                    row.id ??=
                        generateRowId();


                    row.region =
                        row.region === 'after_order'
                            ? 'after_order'
                            : 'before_order';


                    row.columns ??=
                        [];


                    row.columns.forEach(
                        function (column) {

                            column.id ??=
                                generateColumnId();


                            column.width =
                                safeColumnWidth(
                                    column.width
                                );


                            column.blocks ??=
                                [];


                            column.blocks.forEach(
                                normalizeBlock
                            );

                        }
                    );

                }
            );
        }


        function normalizeBlock(
            block
        )
        {
            block.id ??=
                generateBlockId();


            block.settings = {

                ...defaultSettings(
                    block.type
                ),

                ...(block.settings ?? {}),

            };


            block.settings.custom_id =
                String(
                    block.settings
                        .custom_id
                    ?? ''
                );


            if (
                block.type
                === 'accordion'
            ) {

                block.children ??=
                    [];


                block.children.forEach(
                    normalizeBlock
                );

            } else {

                delete block.children;

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Add Row
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.add-row'
            )
            .forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const widths =
                                String(
                                    this.dataset
                                        .widths
                                )
                                .split(',')
                                .map(Number);


                            addRow(
                                widths
                            );

                        }
                    );

                }
            );


        document
            .querySelector(
                '.add-first-row'
            )
            ?.addEventListener(
                'click',
                function () {

                    addRow(
                        [12]
                    );

                }
            );


        function addRow(
            widths
        )
        {
            const row = {

                id:
                    generateRowId(),


                region:
                    'before_order',

                columns:
                    widths.map(
                        function (width) {

                            return {

                                id:
                                    generateColumnId(),

                                width:
                                    safeColumnWidth(
                                        width
                                    ),

                                blocks:
                                    [],

                            };

                        }
                    ),

            };


            rows.push(
                row
            );


            selectedColumnId =
                row.columns[0]
                    ?.id
                ?? null;


            selectedAccordionId =
                null;


            render();
        }


        /*
        |--------------------------------------------------------------------------
        | Add Block
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.add-block'
            )
            .forEach(
                function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            addBlock(
                                this.dataset
                                    .type
                            );

                        }
                    );

                }
            );


        function addBlock(
            type
        )
        {
            if (
                selectedAccordionId
                &&
                type === 'accordion'
            ) {

                alert(
                    'Accordion cannot be placed inside another Accordion.'
                );


                return;
            }


            if (
                rows.length
                === 0
            ) {

                alert(
                    'Please add a Row first.'
                );


                return;
            }


            if (
                !selectedColumnId
            ) {

                selectedColumnId =
                    getFirstColumnId();

            }


            const column =
                findColumn(
                    selectedColumnId
                );


            if (!column) {

                alert(
                    'Please select a Column.'
                );


                return;
            }


            const block = {

                id:
                    generateBlockId(),

                type:
                    type,

                settings:
                    defaultSettings(
                        type
                    ),

            };


            if (
                type
                === 'accordion'
            ) {

                block.children =
                    [];

            }


            if (
                selectedAccordionId
            ) {

                const accordionLocation =
                    findBlockLocation(
                        selectedAccordionId
                    );


                if (
                    accordionLocation
                    &&
                    accordionLocation.block.type
                    === 'accordion'
                ) {

                    accordionLocation
                        .block
                        .children
                        ??=
                        [];


                    accordionLocation
                        .block
                        .children
                        .push(
                            block
                        );

                } else {

                    column.blocks.push(
                        block
                    );

                }

            } else {

                column.blocks.push(
                    block
                );

            }


            render();


            openEditor(
                block.id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Default Settings
        |--------------------------------------------------------------------------
        */

        function defaultSettings(
            type
        )
        {
            const base = {

                custom_id:
                    '',

                content_width:
                    100,

                alignment:
                    'left',

            };


            switch (type) {

                case 'heading':

                    return {

                        ...base,

                        tag:
                            'h2',

                    };


                case 'image':

                    return {

                        ...base,

                        alignment:
                            'center',

                    };


                case 'accordion':

                    return {

                        ...base,

                        title:
                            'Accordion Title',

                        open_default:
                            true,

                    };


                case 'option_card_grid':

                    return {

                        ...base,

                        title:
                            'アタッチメント・加工・オプション',

                    };


                case 'spacer':

                    return {

                        ...base,

                        height:
                            30,

                    };


                default:

                    return {
                        ...base
                    };

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        function render()
        {
            destroySortables();


            canvas.innerHTML =
                '';


            afterOrderCanvas.innerHTML =
                '';


            const renderRow =
                function (row, targetCanvas) {

                    const rowElement =
                        document.createElement(
                            'div'
                        );


                    rowElement.className =
                        'layout-row';


                    rowElement.dataset.rowId =
                        row.id;


                    rowElement.dataset.region =
                        row.region;


                    rowElement.innerHTML = `

                        <div class="layout-row-toolbar">

                            <div class="row-drag-handle">
                                ☰ ROW
                            </div>


                            <label class="row-placement-control">
                                <span>Place</span>

                                <select
                                    class="row-placement"
                                    data-id="${escapeHtml(
                                        row.id
                                    )}"
                                >
                                    <option
                                        value="before_order"
                                        ${
                                            row.region
                                            === 'before_order'
                                                ? 'selected'
                                                : ''
                                        }
                                    >
                                        Before Order Form
                                    </option>

                                    <option
                                        value="after_order"
                                        ${
                                            row.region
                                            === 'after_order'
                                                ? 'selected'
                                                : ''
                                        }
                                    >
                                        After Order Form
                                    </option>
                                </select>
                            </label>


                            <div class="row-actions">

                                <button
                                    type="button"
                                    class="
                                        btn
                                        btn-sm
                                        btn-light
                                        duplicate-row
                                    "
                                    data-id="${escapeHtml(
                                        row.id
                                    )}"
                                >
                                    Copy Row
                                </button>


                                <button
                                    type="button"
                                    class="
                                        btn
                                        btn-sm
                                        btn-danger
                                        delete-row
                                    "
                                    data-id="${escapeHtml(
                                        row.id
                                    )}"
                                >
                                    Delete Row
                                </button>

                            </div>

                        </div>

                    `;


                    row.columns.forEach(
                        function (column) {

                            const columnElement =
                                document.createElement(
                                    'div'
                                );


                            const widthPercent =
                                (
                                    column.width
                                    /
                                    12
                                    *
                                    100
                                );


                            columnElement.className =
                                'layout-column';


                            columnElement.dataset.columnId =
                                column.id;


                            columnElement
                                .style
                                .setProperty(
                                    '--column-width',
                                    widthPercent + '%'
                                );


                            columnElement.innerHTML = `

                                <div
                                    class="
                                        column-shell
                                        ${
                                            selectedColumnId
                                            ===
                                            column.id

                                            ? 'selected-column'

                                            : ''
                                        }
                                    "
                                    data-column-id="${escapeHtml(
                                        column.id
                                    )}"
                                >

                                    <span class="column-width-label">

                                        ${columnWidthText(
                                            column.width
                                        )}

                                    </span>


                                    <div
                                        class="column-block-list"
                                        data-column-id="${escapeHtml(
                                            column.id
                                        )}"
                                    >

                                        ${column.blocks
                                            .map(
                                                renderBlock
                                            )
                                            .join('')
                                        }

                                    </div>


                                    <div class="column-drop-message">

                                        Click to select

                                        <br>

                                        then add components

                                    </div>

                                </div>

                            `;


                            rowElement.appendChild(
                                columnElement
                            );

                        }
                    );


                    targetCanvas.appendChild(
                        rowElement
                    );

                };


            rows
                .filter(
                    row =>
                        row.region
                        !== 'after_order'
                )
                .forEach(
                    row =>
                        renderRow(
                            row,
                            canvas
                        )
                );


            const afterOrderRows =
                rows.filter(
                    row =>
                        row.region
                        === 'after_order'
                );


            afterOrderRows.forEach(
                row =>
                    renderRow(
                        row,
                        afterOrderCanvas
                    )
            );


            afterOrderRegion.classList.toggle(
                'd-none',
                afterOrderRows.length === 0
            );


            document
                .getElementById(
                    'builder-empty'
                )
                .classList
                .toggle(
                    'd-none',
                    rows.length > 0
                );


            bindColumnSelection();

            bindAccordionSelection();

            bindRowButtons();

            bindBlockButtons();

            initializeSortables();
        }


        /*
        |--------------------------------------------------------------------------
        | Render Block
        |--------------------------------------------------------------------------
        */

        function renderBlock(
            block
        )
        {
            const system =
                isSystemComponent(
                    block.type
                );


            const effectiveId =
                getEffectiveBlockId(
                    block
                );


            return `

                <div
                    class="builder-block"
                    data-block-id="${escapeHtml(
                        block.id
                    )}"
                    data-block-type="${escapeHtml(
                        block.type
                    )}"
                >

                    <div class="builder-block-inner">

                        <div class="builder-block-toolbar">

                            <div class="block-drag-handle">

                                ☰

                                ${escapeHtml(
                                    getBlockName(
                                        block.type
                                    )
                                )}


                                ${
                                    system

                                    ? `
                                        <span class="system-label">
                                            SYSTEM
                                        </span>
                                    `

                                    : ''
                                }


                                <span
                                    class="block-effective-id-label"
                                >
                                    #${escapeHtml(
                                        effectiveId
                                    )}
                                </span>

                            </div>


                            <div class="block-actions">

                                <button
                                    type="button"
                                    class="btn btn-sm btn-light edit-block"
                                    data-id="${escapeHtml(
                                        block.id
                                    )}"
                                >
                                    Edit
                                </button>


                                <button
                                    type="button"
                                    class="btn btn-sm btn-light duplicate-block"
                                    data-id="${escapeHtml(
                                        block.id
                                    )}"
                                >
                                    Copy
                                </button>


                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger delete-component"
                                    data-id="${escapeHtml(
                                        block.id
                                    )}"
                                >
                                    Delete
                                </button>

                            </div>

                        </div>


                        ${previewBlock(
                            block
                        )}

                    </div>

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Content Wrapper
        |--------------------------------------------------------------------------
        */

        function contentWrapper(
            block,
            html
        )
        {
            const alignment =
                safeAlignment(
                    block.settings
                        ?.alignment
                );


            const width =
                safeContentWidth(
                    block.settings
                        ?.content_width
                );


            const effectiveId =
                getEffectiveBlockId(
                    block
                );


            let justify =
                'flex-start';


            if (
                alignment
                === 'center'
            ) {

                justify =
                    'center';

            }


            if (
                alignment
                === 'right'
            ) {

                justify =
                    'flex-end';

            }


            return `

                <div
                    id="${escapeHtml(
                        effectiveId
                    )}"
                    class="sim-content-position"
                    style="
                        justify-content:${justify};
                    "
                >

                    <div
                        class="sim-content-box"
                        style="
                            width:${width}%;
                            text-align:${alignment};
                        "
                    >

                        ${html}

                    </div>

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Preview Blocks
        |--------------------------------------------------------------------------
        */

        function previewBlock(
            block
        )
        {
            switch (
                block.type
            ) {

                case 'product_header':

                    return contentWrapper(
                        block,
                        `

                            <div class="sim-product-header">

                                <h1>
                                    オリジナルラバーストラップ（2026年版）
                                </h1>

                                <div class="sim-social">

                                    <span>
                                        シェアする
                                    </span>

                                    <span>
                                        X
                                    </span>

                                    <span>
                                        Facebook
                                    </span>

                                    <span class="ml-auto">
                                        更新日：2026年8月3日
                                    </span>

                                </div>

                            </div>

                        `
                    );


                case 'product_gallery':

                    return contentWrapper(
                        block,
                        `

                            <div>

                                <div class="sim-gallery-main">
                                    🖼
                                </div>

                                <div class="sim-gallery-thumbs">

                                    <div class="sim-gallery-thumb">
                                        🖼
                                    </div>

                                    <div class="sim-gallery-thumb">
                                        🖼
                                    </div>

                                </div>

                            </div>

                        `
                    );


                case 'product_details':

                    return contentWrapper(
                        block,
                        `

                            <div class="sim-product-details">

                                <div class="sim-price-box">
                                    参考単価：1個480円～
                                </div>

                                <div class="sim-price-box">
                                    100個合計金額：48,000円
                                </div>

                                <div class="sim-price-box">
                                    出荷目安（通常納期）：09月14日(月)
                                </div>

                                <small>
                                    ※出荷目安は本日原稿が確定した場合の日付です。
                                </small>

                                <div class="sim-red-heading">

                                    業界最速・最安級！
                                    自社生産だからできる高品質ラバスト製作

                                </div>

                            </div>

                        `
                    );


                case 'heading':

                    const tag =
                        safeHeadingTag(
                            block.settings
                                ?.tag
                        );


                    return contentWrapper(
                        block,
                        `

                            <${tag}>
                                Heading Title
                            </${tag}>

                        `
                    );


                case 'rich_text':

                    return contentWrapper(
                        block,
                        `

                            <div>
                                商品についての説明文がここに表示されます。
                                <br>
                                Productごとに内容を管理できます。
                            </div>

                        `
                    );


                case 'image':

                    return contentWrapper(
                        block,
                        `

                            <div class="sim-image-placeholder">

                                <div class="sim-image-icon">
                                    🖼
                                </div>

                                <div>
                                    Image
                                </div>

                            </div>

                        `
                    );


                case 'button':

                    return contentWrapper(
                        block,
                        `

                            <button
                                type="button"
                                class="btn btn-primary"
                            >
                                詳細はこちら
                            </button>

                        `
                    );


                case 'template_button':

                    return contentWrapper(
                        block,
                        `

                            <button
                                type="button"
                                class="btn btn-primary"
                            >
                                Download Template
                            </button>

                        `
                    );


                /*
                |--------------------------------------------------------------------------
                | NEW - Text Link
                |--------------------------------------------------------------------------
                */

                case 'text_link':

                    return contentWrapper(
                        block,
                        `

                            <a
                                href="#"
                                class="sim-text-link"
                                onclick="return false;"
                            >

                                <span>
                                    Text Link Example
                                </span>

                                <span>
                                    →
                                </span>

                            </a>

                        `
                    );


                /*
                |--------------------------------------------------------------------------
                | NEW - Custom Table
                |--------------------------------------------------------------------------
                */

                case 'custom_table':

                    return contentWrapper(
                        block,
                        `

                            <div>

                                <div class="sim-custom-table-title">
                                    Custom Table
                                </div>

                                <div class="table-responsive">

                                    <table class="sim-table">

                                        <thead>

                                            <tr>

                                                <th>
                                                    Column 1
                                                </th>

                                                <th>
                                                    Column 2
                                                </th>

                                                <th>
                                                    Column 3
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            <tr>

                                                <td>
                                                    Data 1
                                                </td>

                                                <td>
                                                    Data 2
                                                </td>

                                                <td>
                                                    Data 3
                                                </td>

                                            </tr>


                                            <tr>

                                                <td>
                                                    Data 4
                                                </td>

                                                <td>
                                                    Data 5
                                                </td>

                                                <td>
                                                    Data 6
                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        `
                    );


                case 'info_card':

                    return contentWrapper(
                        block,
                        `

                            <div class="sim-info-card">

                                <div class="sim-info-image">
                                    🖼
                                </div>

                                <div class="sim-info-content">

                                    <strong>
                                        Info Card Title
                                    </strong>

                                    <p class="mt-2 mb-2">
                                        商品の説明がここに表示されます。
                                    </p>

                                    <span class="text-primary">
                                        詳細はこちら
                                    </span>

                                </div>

                            </div>

                        `
                    );


                case 'accordion':

                    return contentWrapper(
                        block,
                        accordionPreview(
                            block
                        )
                    );


                case 'option_card_grid':

                    return contentWrapper(
                        block,
                        optionCardGridPreview(
                            block
                        )
                    );


                case 'price_accordion':

                    return contentWrapper(
                        block,
                        simpleSystemAccordion(
                            '価格・制作料金について',
                            `

                                <table class="sim-table">

                                    <tr>

                                        <th>
                                            数量
                                        </th>

                                        <th>
                                            100
                                        </th>

                                        <th>
                                            200
                                        </th>

                                    </tr>


                                    <tr>

                                        <td>
                                            3mm
                                        </td>

                                        <td>
                                            ¥48,000
                                        </td>

                                        <td>
                                            ¥78,600
                                        </td>

                                    </tr>

                                </table>

                            `
                        )
                    );


                case 'shipping_schedule':

                    return contentWrapper(
                        block,
                        simpleSystemAccordion(
                            '納期について',
                            `

                                <div class="alert alert-light border mb-0">

                                    通常納期

                                    <strong>
                                        10営業日後出荷
                                    </strong>

                                </div>

                            `
                        )
                    );


                case 'production_schedule':

                    return contentWrapper(
                        block,
                        simpleSystemAccordion(
                            '制作について',
                            `

                                <div class="alert alert-light border mb-0">

                                    Production Schedule

                                </div>

                            `
                        )
                    );


                case 'divider':

                    return contentWrapper(
                        block,
                        '<hr>'
                    );


                case 'spacer':

                    return contentWrapper(
                        block,
                        `

                            <div
                                class="sim-spacer"
                                style="
                                    height:
                                    ${safeSpacerHeight(
                                        block.settings
                                            ?.height
                                    )}px;
                                "
                            ></div>

                        `
                    );


                default:

                    return contentWrapper(
                        block,
                        `

                            <div class="alert alert-light border">

                                ${escapeHtml(
                                    block.type
                                )}

                            </div>

                        `
                    );

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Accordion Preview
        |--------------------------------------------------------------------------
        */

        function accordionPreview(
            block
        )
        {
            return `

                <div class="sim-accordion">

                    <div class="sim-accordion-header">

                        ${escapeHtml(
                            block.settings
                                ?.title
                            ?? 'Accordion Title'
                        )}

                    </div>


                    <div class="sim-accordion-body">

                        <div
                            class="
                                accordion-block-list
                                ${
                                    selectedAccordionId
                                    ===
                                    block.id

                                    ? 'selected-accordion'

                                    : ''
                                }
                            "
                            data-accordion-id="${escapeHtml(
                                block.id
                            )}"
                        >

                            ${(
                                block.children
                                ?? []
                            )
                            .map(
                                renderBlock
                            )
                            .join('')}


                            ${
                                (
                                    block.children
                                    ?? []
                                ).length === 0

                                ? `

                                    <div class="accordion-drop-message">

                                        Click here then choose a Component

                                        <br>

                                        or drag Components into this Accordion

                                    </div>

                                `

                                : ''
                            }

                        </div>

                    </div>

                </div>

            `;
        }


        function optionCardGridPreview(
            block
        )
        {
            const blockId =
                escapeHtml(
                    block.id
                );

            const title =
                escapeHtml(
                    block.settings
                        ?.title
                    ?? 'アタッチメント・加工・オプション'
                );

            return `
                <div class="sim-option-card-grid" id="sim-opt-${blockId}">
                    <div class="sim-option-header">
                        <span>🗂</span>
                        <span>${title}</span>
                    </div>

                    <div class="sim-tab-menu">
                        <button
                            type="button"
                            class="sim-tab-link active"
                            data-tab-target="sim-tab1-${blockId}"
                            onclick="
                                const p = this.closest('.sim-option-card-grid');
                                p.querySelectorAll('.sim-tab-link').forEach(b => b.classList.remove('active'));
                                this.classList.add('active');
                                p.querySelectorAll('.sim-tab-content').forEach(c => c.style.display = 'none');
                                p.querySelector('#' + this.dataset.tabTarget).style.display = 'block';
                            "
                        >
                            アタッチメント
                        </button>
                        <button
                            type="button"
                            class="sim-tab-link"
                            data-tab-target="sim-tab2-${blockId}"
                            onclick="
                                const p = this.closest('.sim-option-card-grid');
                                p.querySelectorAll('.sim-tab-link').forEach(b => b.classList.remove('active'));
                                this.classList.add('active');
                                p.querySelectorAll('.sim-tab-content').forEach(c => c.style.display = 'none');
                                p.querySelector('#' + this.dataset.tabTarget).style.display = 'block';
                            "
                        >
                            加工方法
                        </button>
                        <button
                            type="button"
                            class="sim-tab-link"
                            data-tab-target="sim-tab3-${blockId}"
                            onclick="
                                const p = this.closest('.sim-option-card-grid');
                                p.querySelectorAll('.sim-tab-link').forEach(b => b.classList.remove('active'));
                                this.classList.add('active');
                                p.querySelectorAll('.sim-tab-content').forEach(c => c.style.display = 'none');
                                p.querySelector('#' + this.dataset.tabTarget).style.display = 'block';
                            "
                        >
                            オプション
                        </button>
                    </div>

                    <div id="sim-tab1-${blockId}" class="sim-tab-content" style="display: block;">
                        <div class="sim-parts-grid">
                            <div class="sim-part-card">
                                <img src="/products/images/HM_part1.webp" class="sim-part-img" onerror="this.style.opacity=0.3">
                                <div><span class="sim-part-badge">+0円</span></div>
                                <div class="sim-part-title">通常松葉+カニカン</div>
                            </div>
                            <div class="sim-part-card">
                                <img src="/products/images/HM_part2.webp" class="sim-part-img" onerror="this.style.opacity=0.3">
                                <div><span class="sim-part-badge">+0円</span></div>
                                <div class="sim-part-title">ゴム松葉+カニカン</div>
                            </div>
                            <div class="sim-part-card">
                                <img src="/products/images/HM_part14.webp" class="sim-part-img" onerror="this.style.opacity=0.3">
                                <div><span class="sim-part-badge">+0円</span></div>
                                <div class="sim-part-title">ボールチェーン銀</div>
                            </div>
                            <div class="sim-part-card">
                                <img src="/products/images/HM_part3.webp" class="sim-part-img" onerror="this.style.opacity=0.3">
                                <div><span class="sim-part-badge badge-extra">+11円</span></div>
                                <div class="sim-part-title">スマホプラグ</div>
                            </div>
                            <div class="sim-part-card">
                                <img src="/products/images/HM_part9.webp" class="sim-part-img" onerror="this.style.opacity=0.3">
                                <div><span class="sim-part-badge badge-extra">+11円</span></div>
                                <div class="sim-part-title">ボールチェーン黄</div>
                            </div>
                            <div class="sim-part-card">
                                <img src="/products/images/HM_part10.webp" class="sim-part-img" onerror="this.style.opacity=0.3">
                                <div><span class="sim-part-badge badge-extra">+11円</span></div>
                                <div class="sim-part-title">ボールチェーン赤</div>
                            </div>
                        </div>
                    </div>

                    <div id="sim-tab2-${blockId}" class="sim-tab-content" style="display: none;">
                        <div class="sim-features-grid">
                            <div class="sim-feature-card">
                                <img src="/products/images/rubberstrap/v2/rubber_guide02.webp" onerror="this.style.opacity=0.3">
                                <div class="sim-feature-card-body">
                                    <div class="sim-feature-card-desc">キャラクターに最適なぷっくり凹凸タイプやフラットタイプが選べます。</div>
                                    <span class="sim-feature-card-link">詳細はこちら →</span>
                                </div>
                            </div>
                            <div class="sim-feature-card">
                                <img src="/products/images/rubberstrap/v2/rubber_guide07.webp" onerror="this.style.opacity=0.3">
                                <div class="sim-feature-card-body">
                                    <div class="sim-feature-card-desc">曲面加工や貼り合わせ半立体などの特殊加工もご用意！</div>
                                    <span class="sim-feature-card-link">詳細はこちら →</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="sim-tab3-${blockId}" class="sim-tab-content" style="display: none;">
                        <div class="sim-features-grid">
                            <div class="sim-feature-card">
                                <img src="/products/images/rubberstrap/v2/rubber_strap_protect.webp" onerror="this.style.opacity=0.3">
                                <div class="sim-feature-card-body">
                                    <div class="sim-feature-card-desc">業界唯一の汚れ防止加工オプションをご用意！</div>
                                    <span class="sim-feature-card-link">詳細はこちら →</span>
                                </div>
                            </div>
                            <div class="sim-feature-card">
                                <img src="/products/images/rubberstrap/v2/rubberstrap_special.webp" onerror="this.style.opacity=0.3">
                                <div class="sim-feature-card-body">
                                    <div class="sim-feature-card-desc">金銀、蓄光、ラメ、蛍光、半透明素材の5種特殊素材！</div>
                                    <span class="sim-feature-card-link">詳細はこちら →</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }


        function simpleSystemAccordion(
            title,
            body
        )
        {
            return `

                <div class="sim-accordion">

                    <div class="sim-accordion-header">
                        ${escapeHtml(title)}
                    </div>

                    <div class="sim-accordion-body">
                        ${body}
                    </div>

                </div>

            `;
        }


        /*
        |--------------------------------------------------------------------------
        | Column Selection
        |--------------------------------------------------------------------------
        */

        function bindColumnSelection()
        {
            document
                .querySelectorAll(
                    '.column-shell'
                )
                .forEach(
                    function (element) {

                        element.addEventListener(
                            'click',
                            function (event) {

                                if (
                                    event.target.closest(
                                        '.builder-block'
                                    )
                                ) {

                                    return;

                                }


                                selectedColumnId =
                                    this.dataset
                                        .columnId;


                                selectedAccordionId =
                                    null;


                                render();

                            }
                        );

                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Accordion Selection
        |--------------------------------------------------------------------------
        */

        function bindAccordionSelection()
        {
            document
                .querySelectorAll(
                    '.accordion-block-list'
                )
                .forEach(
                    function (element) {

                        element.addEventListener(
                            'click',
                            function (event) {

                                const clickedBlock =
                                    event.target.closest(
                                        '.builder-block'
                                    );


                                /*
                                 * The accordion list is itself rendered
                                 * inside the accordion's .builder-block.
                                 * Allow clicks on that owning block/list,
                                 * but ignore clicks on nested components.
                                 */
                                if (
                                    clickedBlock
                                    &&
                                    clickedBlock.dataset
                                        .blockId
                                    !==
                                    this.dataset
                                        .accordionId
                                ) {

                                    return;

                                }


                                event.stopPropagation();


                                selectedAccordionId =
                                    this.dataset
                                        .accordionId;


                                const location =
                                    findBlockLocation(
                                        selectedAccordionId
                                    );


                                if (
                                    location
                                        ?.column
                                        ?.id
                                ) {

                                    selectedColumnId =
                                        location
                                            .column
                                            .id;

                                }


                                render();

                            }
                        );

                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Row Buttons
        |--------------------------------------------------------------------------
        */

        function bindRowButtons()
        {
            document
                .querySelectorAll(
                    '.row-placement'
                )
                .forEach(
                    function (select) {

                        select.onchange =
                            function (event) {

                                event.stopPropagation();


                                const row =
                                    rows.find(
                                        item =>
                                            item.id
                                            ===
                                            this.dataset
                                                .id
                                    );


                                if (!row) {

                                    return;

                                }


                                row.region =
                                    this.value
                                    === 'after_order'
                                        ? 'after_order'
                                        : 'before_order';


                                render();

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.delete-row'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function (event) {

                                event.stopPropagation();


                                const id =
                                    this.dataset
                                        .id;


                                if (
                                    !confirm(
                                        'Delete this Row?'
                                    )
                                ) {

                                    return;

                                }


                                rows =
                                    rows.filter(
                                        row =>
                                            row.id
                                            !==
                                            id
                                    );


                                selectedColumnId =
                                    getFirstColumnId();


                                selectedAccordionId =
                                    null;


                                render();

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.duplicate-row'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function (event) {

                                event.stopPropagation();


                                const id =
                                    this.dataset
                                        .id;


                                const index =
                                    rows.findIndex(
                                        row =>
                                            row.id
                                            ===
                                            id
                                    );


                                if (
                                    index === -1
                                ) {

                                    return;

                                }


                                const copy =
                                    deepClone(
                                        rows[
                                            index
                                        ]
                                    );


                                regenerateRowIds(
                                    copy
                                );


                                rows.splice(
                                    index + 1,
                                    0,
                                    copy
                                );


                                selectedColumnId =
                                    copy.columns[0]
                                        ?.id
                                    ?? null;


                                selectedAccordionId =
                                    null;


                                render();

                            };

                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Block Buttons
        |--------------------------------------------------------------------------
        */

        function bindBlockButtons()
        {
            document
                .querySelectorAll(
                    '.edit-block'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function (event) {

                                event.stopPropagation();


                                openEditor(
                                    this.dataset
                                        .id
                                );

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.duplicate-block'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function (event) {

                                event.stopPropagation();


                                duplicateBlock(
                                    this.dataset
                                        .id
                                );

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.delete-component'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function (event) {

                                event.stopPropagation();


                                deleteBlock(
                                    this.dataset
                                        .id
                                );

                            };

                    }
                );
        }


        function duplicateBlock(
            id
        )
        {
            const location =
                findBlockLocation(
                    id
                );


            if (!location) {

                return;

            }


            const copy =
                deepClone(
                    location.block
                );


            regenerateBlockIds(
                copy
            );


            location.blocks.splice(
                location.blockIndex + 1,
                0,
                copy
            );


            render();
        }


        /*
        |--------------------------------------------------------------------------
        | Sortable
        |--------------------------------------------------------------------------
        */

        function destroySortables()
        {
            sortableInstances.forEach(
                function (instance) {

                    try {

                        instance.destroy();

                    } catch (error) {

                    }

                }
            );


            sortableInstances =
                [];
        }


        function initializeSortables()
        {
            [
                canvas,
                afterOrderCanvas,
            ]
                .forEach(
                    function (rowCanvas) {

                        sortableInstances.push(

                            new Sortable(
                                rowCanvas,
                                {
                                    animation:
                                        150,

                                    handle:
                                        '.row-drag-handle',

                                    ghostClass:
                                        'sortable-ghost',

                                    onEnd:
                                        function () {

                                            syncStructureFromDom();

                                            render();

                                        },
                                }
                            )

                        );

                    }
                );


            document
                .querySelectorAll(
                    '.column-block-list'
                )
                .forEach(
                    function (list) {

                        sortableInstances.push(

                            new Sortable(
                                list,
                                {
                                    group:
                                        'product-components',

                                    animation:
                                        150,

                                    handle:
                                        '.block-drag-handle',

                                    ghostClass:
                                        'sortable-ghost',

                                    onEnd:
                                        function () {

                                            syncStructureFromDom();

                                            selectedAccordionId =
                                                null;


                                            render();

                                        },
                                }
                            )

                        );

                    }
                );


            document
                .querySelectorAll(
                    '.accordion-block-list'
                )
                .forEach(
                    function (list) {

                        sortableInstances.push(

                            new Sortable(
                                list,
                                {
                                    group:
                                        'product-components',

                                    animation:
                                        150,

                                    handle:
                                        '.block-drag-handle',

                                    ghostClass:
                                        'sortable-ghost',

                                    onEnd:
                                        function () {

                                            syncStructureFromDom();

                                            render();

                                        },
                                }
                            )

                        );

                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Sync DOM
        |--------------------------------------------------------------------------
        */

        function syncStructureFromDom()
        {
            const blockMap =
                new Map();


            rows.forEach(
                function (row) {

                    row.columns.forEach(
                        function (column) {

                            collectBlocksToMap(
                                column.blocks,
                                blockMap
                            );

                        }
                    );

                }
            );


            const rowMap =
                new Map(
                    rows.map(
                        row => [
                            row.id,
                            row
                        ]
                    )
                );


            const newRows =
                [];


            [
                ...Array.from(
                    canvas.children
                ),
                ...Array.from(
                    afterOrderCanvas.children
                ),
            ]
                .filter(
                    element =>
                        element.classList.contains(
                            'layout-row'
                        )
                )
                .forEach(
                    function (rowElement) {

                        const oldRow =
                            rowMap.get(
                                rowElement.dataset
                                    .rowId
                            );


                        if (!oldRow) {

                            return;

                        }


                        const newRow = {

                            id:
                                oldRow.id,


                            region:
                                rowElement.dataset.region
                                === 'after_order'
                                    ? 'after_order'
                                    : 'before_order',

                            columns:
                                [],

                        };


                        Array
                            .from(
                                rowElement.children
                            )
                            .filter(
                                element =>
                                    element.classList.contains(
                                        'layout-column'
                                    )
                            )
                            .forEach(
                                function (columnElement) {

                                    const columnId =
                                        columnElement
                                            .dataset
                                            .columnId;


                                    const oldColumn =
                                        oldRow.columns.find(
                                            column =>
                                                column.id
                                                ===
                                                columnId
                                        );


                                    if (!oldColumn) {

                                        return;

                                    }


                                    const list =
                                        columnElement.querySelector(
                                            ':scope > .column-shell > .column-block-list'
                                        );


                                    newRow.columns.push({

                                        id:
                                            oldColumn.id,

                                        width:
                                            oldColumn.width,

                                        blocks:
                                            readBlockListFromDom(
                                                list,
                                                blockMap
                                            ),

                                    });

                                }
                            );


                        newRows.push(
                            newRow
                        );

                    }
                );


            rows =
                newRows;
        }


        function collectBlocksToMap(
            blocks,
            map
        )
        {
            (
                blocks
                ?? []
            )
            .forEach(
                function (block) {

                    map.set(
                        block.id,
                        block
                    );


                    if (
                        block.type
                        === 'accordion'
                    ) {

                        collectBlocksToMap(
                            block.children
                            ?? [],
                            map
                        );

                    }

                }
            );
        }


        function readBlockListFromDom(
            list,
            blockMap
        )
        {
            if (!list) {

                return [];

            }


            const result =
                [];


            Array
                .from(
                    list.children
                )
                .filter(
                    element =>
                        element.classList.contains(
                            'builder-block'
                        )
                )
                .forEach(
                    function (blockElement) {

                        const block =
                            blockMap.get(
                                blockElement.dataset
                                    .blockId
                            );


                        if (!block) {

                            return;

                        }


                        if (
                            block.type
                            === 'accordion'
                        ) {

                            const accordionList =
                                Array
                                    .from(
                                        blockElement.querySelectorAll(
                                            '.accordion-block-list'
                                        )
                                    )
                                    .find(
                                        element =>
                                            element.dataset
                                                .accordionId
                                            ===
                                            block.id
                                    );


                            block.children =
                                readBlockListFromDom(
                                    accordionList,
                                    blockMap
                                );

                        }


                        result.push(
                            block
                        );

                    }
                );


            return result;
        }


        /*
        |--------------------------------------------------------------------------
        | Editor
        |--------------------------------------------------------------------------
        */

        function openEditor(
            id
        )
        {
            const location =
                findBlockLocation(
                    id
                );


            if (!location) {

                return;

            }


            const block =
                location.block;


            editingBlockId =
                id;


            document
                .getElementById(
                    'editing-block-id'
                )
                .value =
                    id;


            document
                .getElementById(
                    'block-internal-id'
                )
                .value =
                    block.id;


            document
                .getElementById(
                    'block-custom-id'
                )
                .value =
                    block.settings
                        ?.custom_id
                    ?? '';


            document
                .getElementById(
                    'content-width'
                )
                .value =
                    safeContentWidth(
                        block.settings
                            ?.content_width
                    );


            document
                .getElementById(
                    'content-alignment'
                )
                .value =
                    safeAlignment(
                        block.settings
                            ?.alignment
                    );


            document
                .getElementById(
                    'block-modal-title'
                )
                .textContent =
                    getBlockName(
                        block.type
                    )
                    +
                    ' Settings';


            updateEffectiveBlockId(
                block
            );


            document
                .getElementById(
                    'block-custom-id'
                )
                .oninput =
                    function () {

                        updateEffectiveBlockId(
                            block
                        );

                    };


            renderBlockFields(
                block
            );


            modal.modal(
                'show'
            );
        }


        function updateEffectiveBlockId(
            block
        )
        {
            const customId =
                document
                    .getElementById(
                        'block-custom-id'
                    )
                    .value
                    .trim();


            document
                .getElementById(
                    'block-effective-id'
                )
                .textContent =
                    customId
                    ||
                    block.id;
        }


        /*
        |--------------------------------------------------------------------------
        | Specific Block Settings
        |--------------------------------------------------------------------------
        */

        function renderBlockFields(
            block
        )
        {
            const container =
                document.getElementById(
                    'block-fields'
                );


            switch (
                block.type
            ) {

                case 'heading':

                    container.innerHTML = `

                        <div class="form-group">

                            <label>
                                Heading Level
                            </label>

                            <select
                                class="form-control block-setting"
                                data-key="tag"
                            >

                                <option
                                    value="h1"
                                    ${selected(
                                        block.settings?.tag,
                                        'h1'
                                    )}
                                >
                                    H1
                                </option>

                                <option
                                    value="h2"
                                    ${selected(
                                        block.settings?.tag,
                                        'h2'
                                    )}
                                >
                                    H2
                                </option>

                                <option
                                    value="h3"
                                    ${selected(
                                        block.settings?.tag,
                                        'h3'
                                    )}
                                >
                                    H3
                                </option>

                            </select>

                        </div>

                    `;

                    break;


                case 'accordion':

                    container.innerHTML = `

                        <div class="form-group">

                            <label>
                                Default Accordion Title
                            </label>

                            <input
                                type="text"
                                class="form-control block-setting"
                                data-key="title"
                                maxlength="255"
                                value="${escapeHtml(
                                    block.settings
                                        ?.title
                                    ?? 'Accordion Title'
                                )}"
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Default State
                            </label>

                            <select
                                class="form-control block-setting"
                                data-key="open_default"
                            >

                                <option
                                    value="1"
                                    ${
                                        block.settings
                                            ?.open_default
                                        !== false

                                        ? 'selected'
                                        : ''
                                    }
                                >
                                    Open
                                </option>

                                <option
                                    value="0"
                                    ${
                                        block.settings
                                            ?.open_default
                                        === false

                                        ? 'selected'
                                        : ''
                                    }
                                >
                                    Closed
                                </option>

                            </select>

                        </div>

                    `;

                    break;


                case 'spacer':

                    container.innerHTML = `

                        <div class="form-group">

                            <label>
                                Height
                            </label>

                            <div class="input-group">

                                <input
                                    type="number"
                                    min="0"
                                    max="500"
                                    class="form-control block-setting"
                                    data-key="height"
                                    value="${safeSpacerHeight(
                                        block.settings
                                            ?.height
                                    )}"
                                >

                                <div class="input-group-append">

                                    <span class="input-group-text">
                                        px
                                    </span>

                                </div>

                            </div>

                        </div>

                    `;

                    break;


                case 'text_link':

                    container.innerHTML = `

                        <div class="alert alert-light border mb-0">

                            Text และ URL จะกำหนดจาก

                            <strong>
                                Product Content Editor
                            </strong>

                            <br><br>

                            Layout Builder ใช้กำหนดตำแหน่ง,
                            Width, Alignment และ Block ID เท่านั้น

                        </div>

                    `;

                    break;


                case 'custom_table':

                    container.innerHTML = `

                        <div class="alert alert-light border mb-0">

                            Column, Row และข้อมูลของตารางจะกำหนดจาก

                            <strong>
                                Product Content Editor
                            </strong>

                            <br><br>

                            Product แต่ละตัวสามารถมีข้อมูลตารางต่างกันได้

                        </div>

                    `;

                    break;


                case 'option_card_grid':

                    container.innerHTML = `

                        <div class="form-group">

                            <label>
                                Title
                            </label>

                            <input
                                type="text"
                                class="form-control block-setting"
                                data-key="title"
                                maxlength="255"
                                value="${escapeHtml(
                                    block.settings
                                        ?.title
                                    ?? 'アタッチメント・加工・オプション'
                                )}"
                            >

                        </div>

                        <div class="alert alert-light border mb-0">

                            <strong>OptionCardGrid</strong>
                            <br><br>
                            แท็บ (Tabs), รายการอะไหล่/ออปชัน, ราคา, และลิงก์จะกำหนดจาก
                            <strong>Product Content Editor</strong>
                            <br><br>
                            Product แต่ละตัวสามารถปรับแต่งข้อมูลออปชันและการ์ดต่างกันได้

                        </div>

                    `;

                    break;


                default:

                    container.innerHTML = `

                        <div class="alert alert-light border mb-0">

                            Product-specific content is entered
                            from Product Content Editor.

                        </div>

                    `;

                    break;

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Apply
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'apply-block'
            )
            .addEventListener(
                'click',
                function () {

                    const location =
                        findBlockLocation(
                            editingBlockId
                        );


                    if (!location) {

                        return;

                    }


                    const block =
                        location.block;


                    const customId =
                        document
                            .getElementById(
                                'block-custom-id'
                            )
                            .value
                            .trim();


                    if (
                        customId
                        &&
                        !/^[A-Za-z][A-Za-z0-9_-]*$/
                            .test(
                                customId
                            )
                    ) {

                        alert(
                            'Block ID must start with a letter and may contain only letters, numbers, - and _.'
                        );


                        return;

                    }


                    const effectiveId =
                        customId
                        ||
                        block.id;


                    if (
                        isEffectiveIdDuplicate(
                            effectiveId,
                            block.id
                        )
                    ) {

                        alert(
                            `Block ID "${effectiveId}" is already used.`
                        );


                        return;

                    }


                    block.settings.custom_id =
                        customId;


                    block.settings.content_width =
                        Number(
                            document
                                .getElementById(
                                    'content-width'
                                )
                                .value
                        );


                    block.settings.alignment =
                        document
                            .getElementById(
                                'content-alignment'
                            )
                            .value;


                    document
                        .querySelectorAll(
                            '#block-fields .block-setting'
                        )
                        .forEach(
                            function (field) {

                                let value =
                                    field.value;


                                if (
                                    field.type
                                    === 'number'
                                ) {

                                    value =
                                        Number(
                                            value
                                        );

                                }


                                if (
                                    field.dataset.key
                                    === 'open_default'
                                ) {

                                    value =
                                        value
                                        === '1';

                                }


                                block.settings[
                                    field.dataset.key
                                ] =
                                    value;

                            }
                        );


                    modal.modal(
                        'hide'
                    );


                    render();

                }
            );


        /*
        |--------------------------------------------------------------------------
        | IDs
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


            return (
                customId
                ||
                block.id
            );
        }


        function isEffectiveIdDuplicate(
            targetId,
            currentBlockId
        )
        {
            const target =
                String(
                    targetId
                )
                .toLowerCase();


            let duplicate =
                false;


            walkAllBlocks(
                function (block) {

                    if (
                        block.id
                        === currentBlockId
                    ) {

                        return;

                    }


                    if (
                        getEffectiveBlockId(
                            block
                        )
                        .toLowerCase()
                        === target
                    ) {

                        duplicate =
                            true;

                    }

                }
            );


            return duplicate;
        }


        function validateAllEffectiveIds()
        {
            const ids =
                new Set();


            let error =
                null;


            walkAllBlocks(
                function (block) {

                    const id =
                        getEffectiveBlockId(
                            block
                        );


                    const key =
                        id.toLowerCase();


                    if (
                        ids.has(
                            key
                        )
                    ) {

                        error =
                            `Duplicate Block ID: ${id}`;


                        return;

                    }


                    ids.add(
                        key
                    );

                }
            );


            return error;
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Block
        |--------------------------------------------------------------------------
        */

        function deleteBlock(
            id,
            closeModal = false
        )
        {
            const location =
                findBlockLocation(
                    id
                );


            if (!location) {

                return;

            }


            if (
                !confirm(
                    'Delete this component?'
                )
            ) {

                return;

            }


            location.blocks.splice(
                location.blockIndex,
                1
            );


            if (
                selectedAccordionId
                === id
            ) {

                selectedAccordionId =
                    null;

            }


            if (
                closeModal
            ) {

                modal.modal(
                    'hide'
                );

            }


            render();
        }


        document
            .getElementById(
                'delete-block'
            )
            .addEventListener(
                'click',
                function () {

                    deleteBlock(
                        editingBlockId,
                        true
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Preview Device
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.preview-device'
            )
            .forEach(
                function (button) {

                    button.onclick =
                        function () {

                            const device =
                                this.dataset
                                    .device;


                            const frame =
                                document.getElementById(
                                    'preview-frame'
                                );


                            frame.classList.remove(
                                'preview-desktop',
                                'preview-tablet',
                                'preview-mobile'
                            );


                            frame.classList.add(
                                'preview-'
                                +
                                device
                            );


                            document
                                .querySelectorAll(
                                    '.preview-device'
                                )
                                .forEach(
                                    function (item) {

                                        item.classList.remove(
                                            'btn-primary'
                                        );


                                        item.classList.add(
                                            'btn-outline-primary'
                                        );

                                    }
                                );


                            this.classList.remove(
                                'btn-outline-primary'
                            );


                            this.classList.add(
                                'btn-primary'
                            );

                        };

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'save-layout-draft'
            )
            .addEventListener(
                'click',
                function () {

                    saveDraft(
                        true
                    );

                }
            );


        async function saveDraft(
            showMessage = true
        )
        {
            syncStructureFromDom();


            const idError =
                validateAllEffectiveIds();


            if (
                idError
            ) {

                alert(
                    idError
                );


                return false;

            }


            const button =
                document.getElementById(
                    'save-layout-draft'
                );


            try {

                button.disabled =
                    true;


                setStatus(
                    'Saving...'
                );


                const response =
                    await fetch(
                        `/api/v1/admin/product-layouts/${layoutId}/layout`,
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

                                    rows:
                                        rows,

                                }),
                        }
                    );


                const result =
                    await response.json();


                if (!response.ok) {

                    throw result;

                }


                setStatus(
                    'Draft saved'
                );


                if (
                    showMessage
                ) {

                    alert(
                        'Layout draft saved.'
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
                    formatApiError(
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
                'publish-layout'
            )
            .addEventListener(
                'click',
                async function () {

                    if (
                        countBlocks()
                        === 0
                    ) {

                        alert(
                            'Please add at least one component.'
                        );


                        return;

                    }


                    const saved =
                        await saveDraft(
                            false
                        );


                    if (!saved) {

                        return;

                    }


                    if (
                        !confirm(
                            'Publish this layout?'
                        )
                    ) {

                        return;

                    }


                    const button =
                        this;


                    try {

                        button.disabled =
                            true;


                        setStatus(
                            'Publishing...'
                        );


                        const response =
                            await fetch(
                                `/api/v1/admin/product-layouts/${layoutId}/publish`,
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


                        if (!response.ok) {

                            throw result;

                        }


                        setStatus(
                            'Published'
                        );


                        alert(
                            'Layout published successfully.'
                        );

                    } catch (error) {

                        console.error(
                            error
                        );


                        setStatus(
                            'Publish failed'
                        );


                        alert(
                            formatApiError(
                                error
                            )
                        );

                    } finally {

                        button.disabled =
                            false;

                    }

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Find Column
        |--------------------------------------------------------------------------
        */

        function findColumn(
            id
        )
        {
            for (
                const row
                of rows
            ) {

                const column =
                    row.columns.find(
                        item =>
                            item.id
                            === id
                    );


                if (column) {

                    return column;

                }

            }


            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Find Block
        |--------------------------------------------------------------------------
        */

        function findBlockLocation(
            id
        )
        {
            function search(
                blocks
            )
            {
                for (
                    let index = 0;
                    index < blocks.length;
                    index++
                ) {

                    const block =
                        blocks[
                            index
                        ];


                    if (
                        block.id
                        === id
                    ) {

                        return {

                            block:
                                block,

                            blockIndex:
                                index,

                            blocks:
                                blocks,

                        };

                    }


                    if (
                        block.type
                        === 'accordion'
                    ) {

                        const nested =
                            search(
                                block.children
                                ?? []
                            );


                        if (nested) {

                            return nested;

                        }

                    }

                }


                return null;
            }


            for (
                const row
                of rows
            ) {

                for (
                    const column
                    of row.columns
                ) {

                    const result =
                        search(
                            column.blocks
                        );


                    if (result) {

                        return {

                            ...result,

                            row:
                                row,

                            column:
                                column,

                        };

                    }

                }

            }


            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Walk Blocks
        |--------------------------------------------------------------------------
        */

        function walkAllBlocks(
            callback
        )
        {
            function walk(
                blocks
            )
            {
                (
                    blocks
                    ?? []
                )
                .forEach(
                    function (block) {

                        callback(
                            block
                        );


                        if (
                            block.type
                            === 'accordion'
                        ) {

                            walk(
                                block.children
                                ?? []
                            );

                        }

                    }
                );
            }


            rows.forEach(
                function (row) {

                    row.columns.forEach(
                        function (column) {

                            walk(
                                column.blocks
                            );

                        }
                    );

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Regenerate IDs
        |--------------------------------------------------------------------------
        */

        function regenerateRowIds(
            row
        )
        {
            row.id =
                generateRowId();


            row.columns.forEach(
                function (column) {

                    column.id =
                        generateColumnId();


                    column.blocks.forEach(
                        regenerateBlockIds
                    );

                }
            );
        }


        function regenerateBlockIds(
            block
        )
        {
            block.id =
                generateBlockId();


            block.settings ??=
                defaultSettings(
                    block.type
                );


            block.settings.custom_id =
                '';


            if (
                block.type
                === 'accordion'
            ) {

                (
                    block.children
                    ?? []
                )
                .forEach(
                    regenerateBlockIds
                );

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Helpers
        |--------------------------------------------------------------------------
        */

        function getFirstColumnId()
        {
            return (
                rows[0]
                    ?.columns[0]
                    ?.id
                ?? null
            );
        }


        function countBlocks()
        {
            let total =
                0;


            walkAllBlocks(
                function () {

                    total++;

                }
            );


            return total;
        }


        function columnWidthText(
            width
        )
        {
            const map = {

                12:
                    '100%',

                8:
                    '66%',

                6:
                    '50%',

                4:
                    '33%',

            };


            return (
                map[
                    width
                ]
                ?? width
            );
        }


        function safeColumnWidth(
            value
        )
        {
            const number =
                Number(
                    value
                );


            return [
                4,
                6,
                8,
                12,
            ].includes(
                number
            )
                ? number
                : 12;
        }


        function safeContentWidth(
            value
        )
        {
            const number =
                Number(
                    value
                );


            return [
                33,
                50,
                75,
                100,
            ].includes(
                number
            )
                ? number
                : 100;
        }


        function safeAlignment(
            value
        )
        {
            return [
                'left',
                'center',
                'right',
            ].includes(
                value
            )
                ? value
                : 'left';
        }


        function safeHeadingTag(
            value
        )
        {
            return [
                'h1',
                'h2',
                'h3',
            ].includes(
                value
            )
                ? value
                : 'h2';
        }


        function safeSpacerHeight(
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
                    30;

            }


            return Math.min(
                500,
                Math.max(
                    0,
                    number
                )
            );
        }


        function selected(
            current,
            value
        )
        {
            return (
                current
                === value
            )
                ? 'selected'
                : '';
        }


        function isSystemComponent(
            type
        )
        {
            return [

                'product_header',
                'product_gallery',
                'product_details',
                'template_button',
                'price_accordion',
                'shipping_schedule',
                'production_schedule',

            ].includes(
                type
            );
        }


        function getBlockName(
            type
        )
        {
            const names = {

                heading:
                    'Heading',

                rich_text:
                    'Text',

                image:
                    'Image',

                button:
                    'Button',

                /*
                 * NEW
                 */
                text_link:
                    'Text Link',

                /*
                 * NEW
                 */
                custom_table:
                    'Custom Table',

                info_card:
                    'Info Card',

                accordion:
                    'Accordion',

                option_card_grid:
                    'OptionCardGrid',

                product_header:
                    'Product Header',

                product_gallery:
                    'Product Gallery',

                product_details:
                    'Product Details',

                template_button:
                    'Template Button',

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
                ?? type
            );
        }


        function generateRowId()
        {
            return (
                'row_'
                +
                Date.now()
                +
                '_'
                +
                randomString()
            );
        }


        function generateColumnId()
        {
            return (
                'column_'
                +
                Date.now()
                +
                '_'
                +
                randomString()
            );
        }


        function generateBlockId()
        {
            return (
                'block_'
                +
                Date.now()
                +
                '_'
                +
                randomString()
            );
        }


        function randomString()
        {
            return Math
                .random()
                .toString(36)
                .substring(
                    2,
                    9
                );
        }


        function deepClone(
            value
        )
        {
            return JSON.parse(
                JSON.stringify(
                    value
                )
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


        function formatApiError(
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
                ?? 'An error occurred.'
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

        loadLayout();

    }
);

</script>

@endpush
