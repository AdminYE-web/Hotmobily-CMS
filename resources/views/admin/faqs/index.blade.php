@extends('admin.layouts.app')

@section('title', 'FAQs')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                FAQs
            </h1>

            <p class="text-muted mb-0">
                Create and manage frequently asked questions.
            </p>
        </div>

        <div>

            <button
                type="button"
                class="btn btn-primary"
                id="btn-add-product"
            >
                + Create Product
            </button>

            <button
                type="button"
                class="btn btn-outline-primary ml-2"
                id="btn-add-faq"
            >
                + Create FAQ
            </button>

        </div>

    </div>


    {{-- Main Card --}}
    <div class="card shadow">

        <div class="card-header py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h6 class="m-0 font-weight-bold text-primary" id="faq-table-title">
                    Product List
                </h6>

                <button
                    type="button"
                    class="btn btn-sm btn-outline-secondary"
                    id="btn-refresh"
                >
                    Refresh
                </button>

            </div>

        </div>


        <div class="card-body">

            {{-- Loading --}}
            <div
                id="faq-loading"
                class="text-center py-4"
            >
                Loading...
            </div>


            {{-- Error --}}
            <div
                id="faq-error"
                class="alert alert-danger d-none"
            ></div>


            {{-- Empty --}}
            <div
                id="faq-empty"
                class="text-center text-muted py-5 d-none"
            >

                No Products found.

                <br>

                <button
                    type="button"
                    class="btn btn-primary mt-3"
                    id="btn-empty-create"
                >
                    Create First Product
                </button>

            </div>


            {{-- Product Table --}}
            <div
                class="table-responsive d-none"
                id="faq-table-wrapper"
            >

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>

                            <th style="width:70px;">
                                No.
                            </th>

                            <th style="width:120px;">
                                Category
                            </th>

                            <th>
                                Product / FAQ Group
                            </th>

                            <th style="width:100px;">
                                FAQ Count
                            </th>

                            <th style="width:110px;">
                                Status
                            </th>

                            <th style="width:160px;">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="faq-list"></tbody>

                </table>

            </div>


            {{-- FAQ Detail Table --}}
            <div
                id="faq-detail-wrapper"
                class="d-none"
            >

                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >

                    <div>

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary mb-2"
                            id="btn-back-to-products"
                        >
                            ← Product List
                        </button>

                        <h5
                            class="mb-0"
                            id="faq-detail-title"
                        ></h5>

                        <small
                            class="text-muted"
                            id="faq-detail-meta"
                        ></small>

                    </div>

                    <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        id="btn-detail-add-faq"
                    >
                        + Add FAQ
                    </button>

                </div>


                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="thead-light">

                            <tr>

                                <th style="width:70px;">
                                    No.
                                </th>

                                <th>
                                    Question
                                </th>

                                <th style="width:90px;">
                                    Order
                                </th>

                                <th style="width:110px;">
                                    Status
                                </th>

                                <th style="width:160px;">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody id="faq-detail-list"></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================ --}}
{{-- Create / Edit Product or FAQ Modal --}}
{{-- ============================================================ --}}

<div
    class="modal fade"
    id="faqModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-lg"
        role="document"
    >

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="faq-modal-title"
                >
                    Create FAQ
                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    <span>&times;</span>
                </button>

            </div>


            <div class="modal-body">

                <div
                    id="faq-form-error"
                    class="alert alert-danger d-none"
                ></div>

                <input
                    type="hidden"
                    id="faq-id"
                >

                <input
                    type="hidden"
                    id="faq-entry-type"
                    value="faq"
                >


                {{-- Category --}}
                <div
                    class="form-group"
                    id="faq-category-group"
                >

                    <label>
                        Category
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        id="faq-category"
                        class="form-control"
                    >
                        <option value="product">
                            Product
                        </option>

                        <option value="order">
                            Order
                        </option>

                        <option value="delivery">
                            Delivery
                        </option>

                        <option value="payment">
                            Payment
                        </option>
                    </select>

                    <small
                        id="faq-category-help"
                        class="form-text text-muted"
                    >
                        Product ใช้สำหรับข้อมูลสินค้า ส่วน Order, Delivery และ Payment ใช้สำหรับหมวด FAQ กลาง
                    </small>

                </div>


                {{-- FAQ Product --}}
                <div
                    class="form-group"
                    id="faq-product-group"
                >

                    <label>
                        Product
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        id="faq-product-id"
                        class="form-control"
                    >
                        <option value="">
                            Select a Product
                        </option>
                    </select>

                    <small class="form-text text-muted">
                        Select a Product created from Create Product.
                    </small>

                </div>


                {{-- Material --}}
                <div
                    class="form-group"
                    id="faq-material-group"
                >

                    <label>
                        Material
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="faq-material"
                        class="form-control"
                        placeholder="Example: rubber, acrylic"
                    >

                    <small class="form-text text-muted">
                        Material is required when creating a Product.
                    </small>

                </div>


                {{-- Product Question Name --}}
                <div
                    class="form-group"
                    id="faq-question-name-group"
                >

                    <label>
                        Question Name
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="faq-question-name"
                        class="form-control"
                        maxlength="500"
                        placeholder="Name shown on Product FAQ page"
                    >

                    <small class="form-text text-muted">
                        This is shown in the Product FAQ list.
                    </small>

                </div>


                {{-- Product Link --}}
                <div
                    class="form-group"
                    id="faq-product-link-group"
                >

                    <label>
                        Product Link
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="faq-product-link"
                        class="form-control"
                        maxlength="2000"
                        placeholder="/products/rubberstrap or https://example.com"
                    >

                    <small class="form-text text-muted">
                        Link used by the Product FAQ item.
                    </small>

                </div>


                {{-- Product Link Text --}}
                <div
                    class="form-group"
                    id="faq-product-link-text-group"
                >

                    <label>
                        Product Link Text
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="faq-product-link-text"
                        class="form-control"
                        maxlength="500"
                        placeholder="Text shown for the product link"
                    >

                </div>


                {{-- Question --}}
                <div
                    class="form-group"
                    id="faq-question-group"
                >

                    <label>
                        Question
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="faq-question"
                        class="form-control"
                        rows="3"
                        maxlength="500"
                        placeholder="Enter question"
                    ></textarea>

                </div>


                {{-- Answer --}}
                <div
                    class="form-group"
                    id="faq-answer-group"
                >

                    <label>
                        Answer
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="faq-answer"
                    ></textarea>

                    <small class="form-text text-muted">
                        You can format text and upload images.
                    </small>

                </div>


                <div class="row">

                    {{-- Sort Order --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Sort Order
                            </label>

                            <input
                                type="number"
                                id="faq-sort-order"
                                class="form-control"
                                min="0"
                                value="0"
                            >

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Status
                            </label>

                            <select
                                id="faq-status"
                                class="form-control"
                            >
                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>
                            </select>

                        </div>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

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
                    id="save-faq"
                >
                    Save
                </button>

            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

    #faq-list td {
        vertical-align: middle;
    }

    .faq-product-row {
        cursor: pointer;
    }

    .faq-product-row:hover {
        background: #f8f9fa;
    }

    .faq-product-name {
        font-weight: 600;
    }

    #faq-detail-list td {
        vertical-align: middle;
    }

    .faq-answer-preview {
        max-width: 520px;
        max-height: 80px;
        overflow: hidden;
        white-space: pre-wrap;
    }

    .faq-question {
        font-weight: 600;
    }

    .faq-category {
        text-transform: capitalize;
    }

    .faq-material {
        font-size: 12px;
    }

    .status-badge {
        display: inline-block;

        padding: 5px 10px;

        border-radius: 20px;

        font-size: 12px;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #e9ecef;
        color: #333;
    }

    .ck-editor__editable_inline {
        min-height: 280px;
    }

</style>

@endpush


@push('scripts')

{{-- CKEditor 5 --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Variables
    |--------------------------------------------------------------------------
    */

    let faqs = [];

    let answerEditor = null;

    const modal =
        $('#faqModal');


    const csrf =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute('content');


    const loading =
        document.getElementById(
            'faq-loading'
        );


    const errorBox =
        document.getElementById(
            'faq-error'
        );


    const emptyBox =
        document.getElementById(
            'faq-empty'
        );


    const tableWrapper =
        document.getElementById(
            'faq-table-wrapper'
        );


    const tableTitle =
        document.getElementById(
            'faq-table-title'
        );


    const list =
        document.getElementById(
            'faq-list'
        );


    const detailWrapper =
        document.getElementById(
            'faq-detail-wrapper'
        );


    const detailTitle =
        document.getElementById(
            'faq-detail-title'
        );


    const detailMeta =
        document.getElementById(
            'faq-detail-meta'
        );


    const detailList =
        document.getElementById(
            'faq-detail-list'
        );


    let activeProductId = null;


    /*
    |--------------------------------------------------------------------------
    | CKEditor Upload Adapter
    |--------------------------------------------------------------------------
    */

    class FaqUploadAdapter {

        constructor(loader) {
            this.loader = loader;

            this.controller =
                new AbortController();
        }


        upload()
        {
            return this.loader.file
                .then(file => {

                    const formData =
                        new FormData();

                    formData.append(
                        'upload',
                        file
                    );


                    return fetch(
                        '/api/v1/admin/faqs/upload-image',
                        {
                            method: 'POST',

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

                            signal:
                                this.controller.signal,
                        }
                    );

                })
                .then(async response => {

                    const result =
                        await response.json();


                    if (!response.ok) {
                        throw result;
                    }


                    return {
                        default:
                            result.url,
                    };

                });
        }


        abort()
        {
            this.controller.abort();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Initialize CKEditor
    |--------------------------------------------------------------------------
    */

    ClassicEditor
        .create(
            document.querySelector(
                '#faq-answer'
            ),
            {
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    '|',
                    'undo',
                    'redo',
                ],
            }
        )
        .then(editor => {

            answerEditor =
                editor;


            editor.plugins
                .get('FileRepository')
                .createUploadAdapter =
                    loader =>
                        new FaqUploadAdapter(
                            loader
                        );


            loadFaqs();

        })
        .catch(error => {

            console.error(
                'CKEditor error:',
                error
            );

        });


    /*
    |--------------------------------------------------------------------------
    | Category / Material
    |--------------------------------------------------------------------------
    */

    const categorySelect =
        document.getElementById(
            'faq-category'
        );


    let currentEntryType = 'faq';


    let showCategoryForFaq = false;


    const entryTypeInput =
        document.getElementById(
            'faq-entry-type'
        );


    const categoryGroup =
        document.getElementById(
            'faq-category-group'
        );


    const productGroup =
        document.getElementById(
            'faq-product-group'
        );


    const productSelect =
        document.getElementById(
            'faq-product-id'
        );


    const questionGroup =
        document.getElementById(
            'faq-question-group'
        );


    const answerGroup =
        document.getElementById(
            'faq-answer-group'
        );


    categorySelect
        .addEventListener(
            'change',
            toggleMaterial
        );


    function toggleMaterial()
    {
        const materialGroup =
            document.getElementById(
                'faq-material-group'
            );


        const materialInput =
            document.getElementById(
                'faq-material'
            );


        const questionNameGroup =
            document.getElementById(
                'faq-question-name-group'
            );


        const questionNameInput =
            document.getElementById(
                'faq-question-name'
            );


        const productLinkGroup =
            document.getElementById(
                'faq-product-link-group'
            );


        const productLinkInput =
            document.getElementById(
                'faq-product-link'
            );


        const productLinkTextGroup =
            document.getElementById(
                'faq-product-link-text-group'
            );


        const productLinkTextInput =
            document.getElementById(
                'faq-product-link-text'
            );


        const isProductEntry =
            currentEntryType ===
            'product';


        const isProductCategory =
            categorySelect.value ===
            'product';


        if (isProductEntry) {

            categorySelect.disabled = false;

            categoryGroup
                .classList
                .remove('d-none');

            productGroup
                .classList
                .add('d-none');

            productSelect.value = '';

            questionGroup
                .classList
                .add('d-none');

            answerGroup
                .classList
                .add('d-none');

            if (isProductCategory) {

                materialGroup
                    .classList
                    .remove('d-none');

                questionNameGroup
                    .classList
                    .remove('d-none');

                productLinkGroup
                    .classList
                    .remove('d-none');

                productLinkTextGroup
                    .classList
                    .remove('d-none');

            } else {

                materialGroup
                    .classList
                    .add('d-none');

                questionNameGroup
                    .classList
                    .add('d-none');

                productLinkGroup
                    .classList
                    .add('d-none');

                productLinkTextGroup
                    .classList
                    .add('d-none');

                materialInput.value = '';
                questionNameInput.value = '';
                productLinkInput.value = '';
                productLinkTextInput.value = '';

            }

        } else {

            const shouldShowFaqCategory =
                showCategoryForFaq;


            if (shouldShowFaqCategory) {

                categorySelect.disabled = false;

                categoryGroup
                    .classList
                    .remove('d-none');

            } else {

                categorySelect.value = 'product';
                categorySelect.disabled = true;

                categoryGroup
                    .classList
                    .add('d-none');

            }

            questionGroup
                .classList
                .remove('d-none');

            answerGroup
                .classList
                .remove('d-none');

            materialGroup
                .classList
                .add('d-none');

            materialInput.value = '';

            if (
                categorySelect.value ===
                'product'
            ) {

                productGroup
                    .classList
                    .remove('d-none');

            } else {

                productGroup
                    .classList
                    .add('d-none');

                productSelect.value = '';

            }

            questionNameGroup
                .classList
                .add('d-none');

            questionNameInput.value = '';

            productLinkGroup
                .classList
                .add('d-none');

            productLinkTextGroup
                .classList
                .add('d-none');

            productLinkInput.value = '';

            productLinkTextInput.value = '';

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Load FAQs
    |--------------------------------------------------------------------------
    */

    async function loadFaqs()
    {
        loading
            .classList
            .remove('d-none');


        errorBox
            .classList
            .add('d-none');


        emptyBox
            .classList
            .add('d-none');


        tableWrapper
            .classList
            .add('d-none');


        try {

            const response =
                await fetch(
                    '/api/v1/admin/faqs',
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


            faqs =
                result.data ?? [];


            populateProductOptions();


            renderFaqs();

        } catch (error) {

            console.error(error);


            errorBox.textContent =
                error.message ??
                'Failed to load FAQs.';


            errorBox
                .classList
                .remove('d-none');

        } finally {

            loading
                .classList
                .add('d-none');

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Product Options
    |--------------------------------------------------------------------------
    */

    function populateProductOptions()
    {
        const selectedProductId =
            productSelect.value;


        productSelect.innerHTML = '';


        const placeholder =
            document.createElement('option');


        placeholder.value = '';

        placeholder.textContent =
            'Select a Product';


        productSelect.appendChild(
            placeholder
        );


        faqs
            .filter(
                faq => faq.entry_type === 'product'
                    && faq.category === 'product'
            )
            .forEach(function (product, index) {

                const option =
                    document.createElement('option');


                const productName =
                    product.question_name
                    || product.material
                    || `Product ${index + 1}`;


                const materialText =
                    product.material
                        ? ` (${product.material})`
                        : '';


                option.value =
                    product.id;


                option.textContent =
                    `${productName}${materialText}`;


                productSelect.appendChild(
                    option
                );

            });


        productSelect.value =
            selectedProductId;
    }


    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    function renderFaqs()
    {
        activeProductId = null;

        tableTitle.textContent =
            'Product List';

        detailWrapper
            .classList
            .add('d-none');

        list.innerHTML = '';

        const products =
            faqs.filter(
                faq => faq.entry_type === 'product'
            );


        if (products.length === 0) {

            tableWrapper
                .classList
                .add('d-none');

            emptyBox
                .classList
                .remove('d-none');

            return;
        }


        tableWrapper
            .classList
            .remove('d-none');


        products.forEach(function (product, index) {

            const faqCount =
                getFaqsForProduct(product).length;

            const statusClass =
                product.is_active
                    ? 'status-active'
                    : 'status-inactive';

            const statusText =
                product.is_active
                    ? 'Active'
                    : 'Inactive';

            const tr =
                document.createElement('tr');

            tr.className =
                'faq-product-row';

            tr.dataset.id =
                product.id;

            tr.tabIndex =
                0;

            tr.innerHTML = `

                <td>
                    ${index + 1}
                </td>


                <td>
                    <span class="faq-category">
                        ${escapeHtml(categoryLabel(product.category))}
                    </span>
                </td>


                <td>
                    <div class="faq-product-name">
                        ${escapeHtml(productDisplayName(product))}
                    </div>

                    ${
                        product.category === 'product'
                            ? `<small class="text-muted">${escapeHtml(product.material || '')}</small>`
                            : ''
                    }
                </td>


                <td>
                    ${faqCount}
                </td>


                <td>

                    <span
                        class="
                            status-badge
                            ${statusClass}
                        "
                    >
                        ${statusText}
                    </span>

                </td>


                <td>

                    <button
                        type="button"
                        class="btn btn-sm btn-primary btn-view-faq"
                        data-id="${product.id}"
                    >
                        View FAQs
                    </button>


                    <button
                        type="button"
                        class="btn btn-sm btn-warning btn-edit"
                        data-id="${product.id}"
                    >
                        Edit
                    </button>


                    <button
                        type="button"
                        class="btn btn-sm btn-danger btn-delete"
                        data-id="${product.id}"
                    >
                        Delete
                    </button>

                </td>

            `;

            list.appendChild(tr);

        });


        bindTableButtons();
    }


    function categoryLabel(category)
    {
        return {
            product: 'Product',
            order: 'Order',
            delivery: 'Delivery',
            payment: 'Payment',
        }[category]
            || category
            || '-';
    }


    function productDisplayName(product)
    {
        if (product.category === 'product') {
            return product.question_name
                || product.material
                || 'Product';
        }

        return `${categoryLabel(product.category)} FAQ`;
    }


    function findProduct(id)
    {
        return faqs.find(
            item =>
                item.entry_type === 'product'
                && String(item.id) === String(id)
        );
    }


    function getFaqsForProduct(product)
    {
        return faqs.filter(function (faq) {

            if (faq.entry_type !== 'faq') {
                return false;
            }

            if (product.category === 'product') {
                return String(faq.product_id || '')
                    === String(product.id);
            }

            return faq.category === product.category
                && (
                    !faq.product_id
                    || String(faq.product_id)
                        === String(product.id)
                );
        });
    }


    function openProductFaqs(id)
    {
        const product =
            findProduct(id);

        if (!product) {
            return;
        }

        activeProductId =
            String(product.id);

        const productFaqs =
            getFaqsForProduct(product);

        tableWrapper
            .classList
            .add('d-none');

        emptyBox
            .classList
            .add('d-none');

        detailWrapper
            .classList
            .remove('d-none');

        tableTitle.textContent =
            'FAQ List';

        detailTitle.textContent =
            productDisplayName(product);

        detailMeta.textContent =
            categoryLabel(product.category);

        detailList.innerHTML = '';

        if (productFaqs.length === 0) {

            detailList.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        No FAQs found for this item.
                    </td>
                </tr>
            `;

            return;
        }

        productFaqs.forEach(function (faq, index) {

            const statusClass =
                faq.is_active
                    ? 'status-active'
                    : 'status-inactive';

            const statusText =
                faq.is_active
                    ? 'Active'
                    : 'Inactive';

            const tr =
                document.createElement('tr');

            tr.innerHTML = `

                <td>
                    ${index + 1}
                </td>


                <td>
                    <div class="faq-question">
                        ${escapeHtml(faq.question || '-')}
                    </div>

                    <div class="faq-answer-preview text-muted">
                        ${escapeHtml(stripHtml(faq.answer || ''))}
                    </div>
                </td>


                <td>
                    ${faq.sort_order ?? 0}
                </td>


                <td>
                    <span class="status-badge ${statusClass}">
                        ${statusText}
                    </span>
                </td>


                <td>

                    <button
                        type="button"
                        class="btn btn-sm btn-warning btn-edit"
                        data-id="${faq.id}"
                    >
                        Edit
                    </button>


                    <button
                        type="button"
                        class="btn btn-sm btn-danger btn-delete"
                        data-id="${faq.id}"
                    >
                        Delete
                    </button>

                </td>

            `;

            detailList.appendChild(tr);

        });

        bindTableButtons();
    }


    function stripHtml(value)
    {
        const element =
            document.createElement('div');

        element.innerHTML =
            String(value ?? '');

        return element.textContent
            || element.innerText
            || '';
    }


    /*
    |--------------------------------------------------------------------------
    | Add
    |--------------------------------------------------------------------------
    */

    document
        .getElementById(
            'btn-add-product'
        )
        .addEventListener(
            'click',
            function () {

                openCreateModal('product');

            }
        );


    document
        .getElementById(
            'btn-add-faq'
        )
        .addEventListener(
            'click',
            function () {

                openCreateModal('faq');

            }
        );


    document
        .getElementById(
            'btn-empty-create'
        )
        .addEventListener(
            'click',
            function () {

                openCreateModal('product');

            }
        );


    document
        .getElementById(
            'btn-refresh'
        )
        .addEventListener(
            'click',
            loadFaqs
        );


    document
        .getElementById(
            'btn-back-to-products'
        )
        .addEventListener(
            'click',
            renderFaqs
        );


    document
        .getElementById(
            'btn-detail-add-faq'
        )
        .addEventListener(
            'click',
            openCreateFaqForActiveProduct
        );


    function openCreateModal(entryType = 'faq')
    {
        resetForm(entryType);


        document
            .getElementById(
                'faq-modal-title'
            )
            .textContent =
                entryType === 'product'
                    ? 'Create Product'
                    : 'Create FAQ';


        modal.modal('show');
    }


    function openCreateFaqForActiveProduct()
    {
        const product =
            findProduct(activeProductId);

        if (!product) {
            openCreateModal('faq');

            return;
        }

        resetForm('faq');

        categorySelect.value =
            product.category;

        showCategoryForFaq =
            true;

        toggleMaterial();

        if (product.category === 'product') {
            productSelect.value =
                product.id;
        }

        document
            .getElementById(
                'faq-modal-title'
            )
            .textContent =
                'Create FAQ';

        modal.modal('show');
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    function openEditModal(id)
    {
        const faq =
            faqs.find(
                item =>
                    String(item.id) ===
                    String(id)
            );


        if (!faq) {
            return;
        }


        const entryType =
            faq.entry_type === 'product'
                ? 'product'
                : 'faq';


        resetForm(entryType);


        document
            .getElementById(
                'faq-modal-title'
            )
            .textContent =
                entryType === 'product'
                    ? 'Edit Product'
                    : 'Edit FAQ';


        document
            .getElementById(
                'faq-id'
            )
            .value =
                faq.id;


        document
            .getElementById(
                'faq-category'
            )
            .value =
                faq.category;


        showCategoryForFaq =
            entryType === 'faq'
            && faq.category !== 'product';


        document
            .getElementById(
                'faq-product-id'
            )
            .value =
                faq.product_id ?? '';


        document
            .getElementById(
                'faq-material'
            )
            .value =
                faq.material ?? '';


        document
            .getElementById(
                'faq-question-name'
            )
            .value =
                faq.question_name ?? '';


        document
            .getElementById(
                'faq-product-link'
            )
            .value =
                faq.product_link ?? '';


        document
            .getElementById(
                'faq-product-link-text'
            )
            .value =
                faq.product_link_text ?? '';


        document
            .getElementById(
                'faq-question'
            )
            .value =
                faq.question ?? '';


        document
            .getElementById(
                'faq-sort-order'
            )
            .value =
                faq.sort_order ?? 0;


        document
            .getElementById(
                'faq-status'
            )
            .value =
                faq.is_active
                    ? '1'
                    : '0';


        if (answerEditor) {

            answerEditor.setData(
                faq.answer ?? ''
            );

        }


        toggleMaterial();


        modal.modal('show');
    }


    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    document
        .getElementById(
            'save-faq'
        )
        .addEventListener(
            'click',
            async function () {

                clearFormError();


                const id =
                    document
                        .getElementById(
                            'faq-id'
                        )
                        .value;


                const category =
                    document
                        .getElementById(
                            'faq-category'
                        )
                        .value;


                const isProductMetaEntry =
                    currentEntryType === 'product'
                    && category === 'product';


                const payload = {

                    entry_type:
                        currentEntryType,

                    category:
                        category,

                    product_id:
                        currentEntryType === 'faq'
                        && category === 'product'
                            ? document
                                .getElementById(
                                    'faq-product-id'
                                )
                                .value
                            : null,

                    material:
                        isProductMetaEntry
                            ? document
                                .getElementById(
                                    'faq-material'
                                )
                                .value
                                .trim()
                            : null,

                    question_name:
                        isProductMetaEntry
                            ? document
                                .getElementById(
                                    'faq-question-name'
                                )
                                .value
                                .trim()
                            : null,

                    product_link:
                        isProductMetaEntry
                            ? document
                                .getElementById(
                                    'faq-product-link'
                                )
                                .value
                                .trim()
                            : null,

                    product_link_text:
                        isProductMetaEntry
                            ? document
                                .getElementById(
                                    'faq-product-link-text'
                                )
                                .value
                                .trim()
                            : null,

                    question:
                        currentEntryType === 'faq'
                            ? document
                                .getElementById(
                                    'faq-question'
                                )
                                .value
                                .trim()
                            : '',

                    answer:
                        currentEntryType === 'faq' && answerEditor
                            ? answerEditor
                                .getData()
                                .trim()
                            : '',

                    sort_order:
                        Number(
                            document
                                .getElementById(
                                    'faq-sort-order'
                                )
                                .value
                                || 0
                        ),

                    is_active:
                        document
                            .getElementById(
                                'faq-status'
                            )
                            .value === '1',

                };


                if (
                    currentEntryType ===
                    'product' &&
                    category === 'product' &&
                    !payload.material
                ) {

                    showFormError(
                        'Material is required for Product.'
                    );

                    return;
                }


                if (
                    currentEntryType ===
                    'faq' &&
                    payload.category === 'product' &&
                    !payload.product_id
                ) {

                    showFormError(
                        'Please select a Product.'
                    );

                    return;
                }


                if (
                    currentEntryType ===
                    'product' &&
                    category === 'product' &&
                    !payload.question_name
                ) {

                    showFormError(
                        'Question Name is required for Product.'
                    );

                    return;
                }


                if (
                    currentEntryType ===
                    'product' &&
                    category === 'product' &&
                    !payload.product_link
                ) {

                    showFormError(
                        'Product Link is required for Product.'
                    );

                    return;
                }


                if (
                    currentEntryType ===
                    'product' &&
                    category === 'product' &&
                    !payload.product_link_text
                ) {

                    showFormError(
                        'Product Link Text is required for Product.'
                    );

                    return;
                }


                if (
                    currentEntryType ===
                    'faq' &&
                    !payload.question
                ) {

                    showFormError(
                        'Question is required.'
                    );

                    return;
                }


                if (
                    currentEntryType ===
                    'faq' &&
                    !payload.answer
                ) {

                    showFormError(
                        'Answer is required.'
                    );

                    return;
                }


                const url =
                    id
                        ? `/api/v1/admin/faqs/${id}`
                        : '/api/v1/admin/faqs';


                const method =
                    id
                        ? 'PUT'
                        : 'POST';


                const button =
                    this;


                const previousActiveProductId =
                    activeProductId;


                try {

                    button.disabled =
                        true;


                    button.textContent =
                        'Saving...';


                    const response =
                        await fetch(
                            url,
                            {
                                method:
                                    method,

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
                                    JSON.stringify(
                                        payload
                                    ),
                            }
                        );


                    const result =
                        await response.json();


                    if (!response.ok) {
                        throw result;
                    }


                    modal.modal('hide');


                    await loadFaqs();

                    if (previousActiveProductId !== null) {
                        openProductFaqs(previousActiveProductId);
                    }

                } catch (error) {

                    console.error(error);

                    showApiError(error);

                } finally {

                    button.disabled =
                        false;


                    button.textContent =
                        'Save';

                }

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    async function deleteFaq(id)
    {
        const faq =
            faqs.find(
                item =>
                    String(item.id) ===
                    String(id)
            );


        if (!faq) {
            return;
        }


        if (
            !confirm(
                `Delete ${
                    faq.entry_type === 'product'
                        ? 'Product'
                        : 'FAQ'
                } "${
                    faq.entry_type === 'product'
                        ? (faq.question_name || 'Product')
                        : (faq.question || 'FAQ')
                }"?`
            )
        ) {
            return;
        }


        const previousActiveProductId =
            activeProductId;


        try {

            const response =
                await fetch(
                    `/api/v1/admin/faqs/${id}`,
                    {
                        method:
                            'DELETE',

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


            await loadFaqs();

            if (previousActiveProductId !== null) {
                openProductFaqs(previousActiveProductId);
            }

        } catch (error) {

            alert(
                error.message ??
                'Delete failed.'
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Bind
    |--------------------------------------------------------------------------
    */

    function bindTableButtons()
    {
        document
            .querySelectorAll(
                '.faq-product-row'
            )
            .forEach(function (row) {

                row.onclick =
                    function () {

                        openProductFaqs(
                            this.dataset.id
                        );

                    };

                row.onkeydown =
                    function (event) {

                        if (
                            event.key === 'Enter'
                            || event.key === ' '
                        ) {
                            event.preventDefault();

                            openProductFaqs(
                                this.dataset.id
                            );
                        }

                    };

            });


        document
            .querySelectorAll(
                '.btn-view-faq'
            )
            .forEach(function (button) {

                button.onclick =
                    function (event) {

                        event.stopPropagation();

                        openProductFaqs(
                            this.dataset.id
                        );

                    };

            });


        document
            .querySelectorAll(
                '.btn-edit'
            )
            .forEach(function (button) {

                button.onclick =
                    function (event) {

                        event.stopPropagation();

                        openEditModal(
                            this.dataset.id
                        );

                    };

            });


        document
            .querySelectorAll(
                '.btn-delete'
            )
            .forEach(function (button) {

                button.onclick =
                    function (event) {

                        event.stopPropagation();

                        deleteFaq(
                            this.dataset.id
                        );

                    };

            });
    }


    /*
    |--------------------------------------------------------------------------
    | Reset
    |--------------------------------------------------------------------------
    */

    function resetForm(entryType = 'faq')
    {
        currentEntryType =
            entryType === 'product'
                ? 'product'
                : 'faq';


        showCategoryForFaq =
            currentEntryType ===
            'faq';


        entryTypeInput.value =
            currentEntryType;


        document
            .getElementById(
                'faq-id'
            )
            .value = '';


        document
            .getElementById(
                'faq-category'
            )
            .value =
                'product';


        document
            .getElementById(
                'faq-product-id'
            )
            .value = '';


        document
            .getElementById(
                'faq-material'
            )
            .value = '';


        document
            .getElementById(
                'faq-question-name'
            )
            .value = '';


        document
            .getElementById(
                'faq-product-link'
            )
            .value = '';


        document
            .getElementById(
                'faq-product-link-text'
            )
            .value = '';


        document
            .getElementById(
                'faq-question'
            )
            .value = '';


        document
            .getElementById(
                'faq-sort-order'
            )
            .value =
                0;


        document
            .getElementById(
                'faq-status'
            )
            .value =
                '1';


        if (answerEditor) {

            answerEditor.setData('');

        }


        toggleMaterial();

        clearFormError();
    }


    /*
    |--------------------------------------------------------------------------
    | Errors
    |--------------------------------------------------------------------------
    */

    function clearFormError()
    {
        const box =
            document.getElementById(
                'faq-form-error'
            );


        box.innerHTML = '';

        box.classList.add(
            'd-none'
        );
    }


    function showFormError(message)
    {
        const box =
            document.getElementById(
                'faq-form-error'
            );


        box.textContent =
            message;


        box.classList.remove(
            'd-none'
        );
    }


    function showApiError(error)
    {
        const box =
            document.getElementById(
                'faq-form-error'
            );


        if (error.errors) {

            box.innerHTML =
                Object
                    .values(
                        error.errors
                    )
                    .flat()
                    .join('<br>');

        } else {

            box.textContent =
                error.message ??
                'An error occurred.';

        }


        box.classList.remove(
            'd-none'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value)
    {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

});

</script>

@endpush
