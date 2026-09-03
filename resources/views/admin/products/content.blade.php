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

    pointer-events: none;
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

    grid-auto-rows:
        minmax(
            48px,
            auto
        );

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

            bindFlexibleTableEditors();

            bindShippingDays();

            bindShippingScheduleEditors();
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
                        textareaInput(
                            block.id,
                            'content',
                            'Content',
                            blockContent.content
                            ?? '',
                            6
                        );

                    break;


                case 'image':

                    fields = `

                        ${textInput(
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


                        ${textInput(
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


                        ${textInput(
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
                    class="content-block"
                    data-block-id="${block.id}"
                >

                    <div class="content-block-header">

                        <span class="content-block-name">

                            ${escapeHtml(
                                getBlockName(
                                    block.type
                                )
                            )}

                        </span>


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


                    ${fields}

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


            return `

                <div
                    class="
                        content-block
                        accordion-editor
                    "
                    data-block-id="${block.id}"
                >

                    <div class="content-block-header">

                        <span class="content-block-name">
                            Accordion
                        </span>


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

            `;
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


                    ${textInput(
                        block.id,
                        'url',
                        'Link URL',
                        content.url
                        ?? ''
                    )}


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

                        </div>


                        <div class="flex-table-row-actions">

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


                                data.rows.push({

                                    id:
                                        generateFlexRowId(),

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


                <div class="flex-table-grid">

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
            return (

                String(
                    block.settings
                        ?.custom_id
                    ?? ''
                )
                .trim()

                ||

                block.id

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
