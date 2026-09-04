@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')

<div class="container-fluid">

    {{-- ============================================================
        Header
    ============================================================ --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="h3 mb-1">
                Products
            </h1>

            <p class="text-muted mb-0">
                Manage products, assign layouts and edit product content.
            </p>

        </div>


        <button
            type="button"
            class="btn btn-primary"
            id="btn-add-product"
        >
            + Add Product
        </button>

    </div>


    {{-- ============================================================
        Product List
    ============================================================ --}}
    <div class="card shadow-sm">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <strong>
                    Product List
                </strong>


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
                id="product-loading"
                class="text-center py-5"
            >
                Loading...
            </div>


            {{-- Error --}}
            <div
                id="product-error"
                class="alert alert-danger d-none"
            ></div>


            {{-- Empty --}}
            <div
                id="product-empty"
                class="text-center py-5 text-muted d-none"
            >

                <div class="mb-3">
                    No products found.
                </div>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="btn-empty-create"
                >
                    + Create First Product
                </button>

            </div>


            {{-- Table --}}
            <div
                id="product-table-wrapper"
                class="table-responsive d-none"
            >

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>

                            <th style="width:70px;">
                                ID
                            </th>

                            <th>
                                Product
                            </th>

                            <th style="width:160px;">
                                Product Code
                            </th>

                            <th style="width:220px;">
                                Layout
                            </th>

                            <th style="width:130px;">
                                Status
                            </th>

                            <th style="width:170px;">
                                Published
                            </th>

                            <th style="width:300px;">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="product-list"></tbody>

                </table>

            </div>

        </div>

    </div>

</div>



{{-- ================================================================
    Create / Edit Product Modal
================================================================ --}}
<div
    class="modal fade"
    id="productModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-lg"
        role="document"
    >

        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="product-modal-title"
                >
                    Add Product
                </h5>


                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >
                    <span>
                        &times;
                    </span>
                </button>

            </div>


            {{-- Body --}}
            <div class="modal-body">

                {{-- Error --}}
                <div
                    id="product-form-error"
                    class="alert alert-danger d-none"
                ></div>


                {{-- Product ID --}}
                <input
                    type="hidden"
                    id="product-id"
                >


                <div class="row">

                    {{-- Product Name --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Product Name

                                <span class="text-danger">
                                    *
                                </span>
                            </label>


                            <input
                                type="text"
                                id="product-name"
                                class="form-control"
                                maxlength="255"
                                placeholder="Rubber Strap"
                            >

                        </div>

                    </div>


                    {{-- Product Code --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Product Code
                            </label>


                            <input
                                type="text"
                                id="product-code"
                                class="form-control"
                                maxlength="100"
                                placeholder="RS001"
                            >

                        </div>

                    </div>

                </div>



                <div class="row">

                    {{-- Slug --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Slug

                                <span class="text-danger">
                                    *
                                </span>
                            </label>


                           <input
    type="text"
    id="product-slug"
    class="form-control"
    maxlength="255"
    placeholder="acrylic/figure"
>

<small class="form-text text-muted">

    Product URL path after /products/

    <br>

    Example:
    <code>rubberstrap</code>
    →
    <code>/products/rubberstrap</code>

    <br>

    Example:
    <code>acrylic/figure</code>
    →
    <code>/products/acrylic/figure</code>

</small>

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label>
                                Status
                            </label>


                            <select
                                id="product-status"
                                class="form-control"
                            >

                                <option value="draft">
                                    Draft
                                </option>

                                <option value="active">
                                    Active
                                </option>

                                <option value="inactive">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                </div>



                {{-- ====================================================
                    Product Layout
                ==================================================== --}}
                <div class="form-group">

                    <label>
                        Product Layout
                    </label>


                    <select
                        id="product-layout-id"
                        class="form-control"
                    >

                        <option value="">
                            -- Select Layout --
                        </option>

                    </select>


                    <small class="form-text text-muted">

                        Select the layout that will be used
                        for this product page.

                    </small>

                </div>


                {{-- Layout Preview Info --}}
                <div
                    id="selected-layout-info"
                    class="layout-info-box d-none"
                >

                    <div class="d-flex justify-content-between">

                        <div>

                            <strong id="selected-layout-name"></strong>

                            <div
                                id="selected-layout-description"
                                class="text-muted small mt-1"
                            ></div>

                        </div>


                        <div>

                            <span
                                id="selected-layout-status"
                                class="badge badge-secondary"
                            ></span>

                        </div>

                    </div>


                    <div class="mt-3">

                        <a
                            href="#"
                            target="_blank"
                            id="selected-layout-builder"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Open Layout Builder
                        </a>

                    </div>

                </div>


                {{-- Warning --}}
                <div
                    id="layout-change-warning"
                    class="alert alert-warning mt-3 d-none"
                >

                    <strong>
                        Layout changed
                    </strong>

                    <br>

                    Existing product content will remain saved,
                    but content belonging to blocks that do not exist
                    in the new layout will not be displayed.

                </div>

            </div>


            {{-- Footer --}}
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
                    id="save-product"
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

/* ============================================================
   Product Table
============================================================ */

#product-list td {
    vertical-align: middle;
}


.product-name {
    font-weight: 600;
}


.product-slug {
    margin-top: 3px;

    color: #888;

    font-size: 12px;
}


.product-code {
    font-family: monospace;
}


/* ============================================================
   Status
============================================================ */

.product-status {

    display: inline-block;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 11px;

    font-weight: 600;
}


.status-draft {

    background: #e9ecef;

    color: #495057;
}


.status-active {

    background: #d4edda;

    color: #155724;
}


.status-inactive {

    background: #f8d7da;

    color: #721c24;
}


/* ============================================================
   Layout
============================================================ */

.layout-name {

    font-weight: 600;
}


.layout-status {

    display: inline-block;

    margin-top: 3px;

    padding: 2px 6px;

    border-radius: 10px;

    font-size: 10px;
}


.layout-published {

    background: #d4edda;

    color: #155724;
}


.layout-draft {

    background: #fff3cd;

    color: #856404;
}


.layout-none {

    color: #999;

    font-style: italic;
}


/* ============================================================
   Layout Select Info
============================================================ */

.layout-info-box {

    padding: 15px;

    background: #f8f9fa;

    border: 1px solid #ddd;

    border-radius: 5px;
}


/* ============================================================
   Action
============================================================ */

.product-actions {

    display: flex;

    flex-wrap: wrap;

    gap: 5px;
}


.product-actions .btn {

    white-space: nowrap;
}


/* ============================================================
   Content button
============================================================ */

.btn-content {

    min-width: 78px;
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
        | Setup
        |--------------------------------------------------------------------------
        */

        const modal =
            $('#productModal');


        const csrf =
            document
                .querySelector(
                    'meta[name="csrf-token"]'
                )
                ?.getAttribute(
                    'content'
                );


        let products = [];

        let productLayouts = [];

        let editingProduct = null;

        let originalLayoutId = null;



        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const loading =
            document.getElementById(
                'product-loading'
            );


        const errorBox =
            document.getElementById(
                'product-error'
            );


        const emptyBox =
            document.getElementById(
                'product-empty'
            );


        const tableWrapper =
            document.getElementById(
                'product-table-wrapper'
            );


        const productList =
            document.getElementById(
                'product-list'
            );


        const layoutSelect =
            document.getElementById(
                'product-layout-id'
            );



        /*
        |--------------------------------------------------------------------------
        | Start
        |--------------------------------------------------------------------------
        */

        initialize();


        async function initialize()
        {
            /*
             * Load Layout ก่อน
             * เพราะ Product modal ต้องใช้
             */
            await loadProductLayouts();


            /*
             * แล้วค่อย Product
             */
            await loadProducts();
        }



        /*
        |--------------------------------------------------------------------------
        | Load Product Layouts
        |--------------------------------------------------------------------------
        */

        async function loadProductLayouts()
        {
            try {

                const response =
                    await fetch(
                        '/api/v1/admin/product-layouts',
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


                productLayouts =
                    result.data
                    ?? [];


                renderLayoutOptions();

            } catch (error) {

                console.error(
                    'Unable to load layouts:',
                    error
                );


                productLayouts =
                    [];

            }
        }



        /*
        |--------------------------------------------------------------------------
        | Render Layout Options
        |--------------------------------------------------------------------------
        */

        function renderLayoutOptions()
        {
            layoutSelect.innerHTML = `

                <option value="">
                    -- Select Layout --
                </option>

            `;


            productLayouts.forEach(
                function (layout) {

                    const option =
                        document.createElement(
                            'option'
                        );


                    option.value =
                        layout.id;


                    option.textContent =
                        layout.name
                        +
                        ' ['
                        +
                        layout.status
                        +
                        ']';


                    layoutSelect.appendChild(
                        option
                    );

                }
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Load Products
        |--------------------------------------------------------------------------
        */

        async function loadProducts()
        {
            loading.classList.remove(
                'd-none'
            );


            errorBox.classList.add(
                'd-none'
            );


            emptyBox.classList.add(
                'd-none'
            );


            tableWrapper.classList.add(
                'd-none'
            );


            try {

                const response =
                    await fetch(
                        '/api/v1/admin/products',
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


                products =
                    result.data
                    ?? [];


                renderProducts();

            } catch (error) {

                console.error(
                    error
                );


                errorBox.textContent =
                    formatApiError(
                        error
                    );


                errorBox.classList.remove(
                    'd-none'
                );

            } finally {

                loading.classList.add(
                    'd-none'
                );

            }
        }



        /*
        |--------------------------------------------------------------------------
        | Render Products
        |--------------------------------------------------------------------------
        */

        function renderProducts()
        {
            productList.innerHTML =
                '';


            if (
                products.length === 0
            ) {

                emptyBox.classList.remove(
                    'd-none'
                );


                return;

            }


            tableWrapper.classList.remove(
                'd-none'
            );


            products.forEach(
                function (product) {

                    const tr =
                        document.createElement(
                            'tr'
                        );


                    const layout =
                        product.layout
                        ?? null;


                    const layoutHtml =
                        getLayoutHtml(
                            layout
                        );


                    const statusHtml =
                        getProductStatusHtml(
                            product.status
                        );


                    const published =
                        product.page
                            ?.published_at

                            ? formatDateTime(
                                product
                                    .page
                                    .published_at
                            )

                            : '-';


                    /*
                     * Content button
                     */
                    let contentButton = '';


                    if (
                        product.product_layout_id
                    ) {

                        contentButton = `

                            <a
                                href="/admin/products/${product.id}/content"
                                class="
                                    btn
                                    btn-sm
                                    btn-primary
                                    btn-content
                                "
                            >
                                Content
                            </a>

                        `;

                    } else {

                        contentButton = `

                            <button
                                type="button"
                                class="
                                    btn
                                    btn-sm
                                    btn-secondary
                                    btn-content
                                "
                                disabled
                                title="Select a Product Layout first"
                            >
                                Content
                            </button>

                        `;

                    }


                    tr.innerHTML = `

                        <td>

                            ${product.id}

                        </td>


                        <td>

                            <div class="product-name">

                                ${escapeHtml(
                                    product.name
                                )}

                            </div>


                            <div class="product-slug">

                               /products/${escapeHtml(
    product.slug
)}

                            </div>

                        </td>


                        <td>

                            <span class="product-code">

                                ${escapeHtml(
                                    product.product_code
                                    ?? '-'
                                )}

                            </span>

                        </td>


                        <td>

                            ${layoutHtml}

                        </td>


                        <td>

                            ${statusHtml}

                        </td>


                        <td>

                            ${published}

                        </td>


                        <td>

                            <div class="product-actions">

                                ${contentButton}


                                <button
                                    type="button"
                                    class="
                                        btn
                                        btn-sm
                                        btn-warning
                                        edit-product
                                    "
                                    data-id="${product.id}"
                                >
                                    Edit
                                </button>


                                <a
                                    href="/api/v1/products/${encodeProductPath(product.slug)}/page"
                                    target="_blank"
                                    class="
                                        btn
                                        btn-sm
                                        btn-outline-secondary
                                    "
                                >
                                    API
                                </a>


                                <button
                                    type="button"
                                    class="
                                        btn
                                        btn-sm
                                        btn-danger
                                        delete-product
                                    "
                                    data-id="${product.id}"
                                >
                                    Delete
                                </button>

                            </div>

                        </td>

                    `;


                    productList.appendChild(
                        tr
                    );

                }
            );


            bindProductButtons();
        }


function encodeProductPath(
    slug
) {
    return String(
        slug
        ?? ''
    )
        .split('/')
        .map(
            segment =>
                encodeURIComponent(
                    segment
                )
        )
        .join('/');
}
        /*
        |--------------------------------------------------------------------------
        | Layout Display
        |--------------------------------------------------------------------------
        */

        function getLayoutHtml(layout)
        {
            if (!layout) {

                return `

                    <span class="layout-none">
                        No Layout
                    </span>

                `;

            }


            const statusClass =
                layout.status === 'published'

                    ? 'layout-published'

                    : 'layout-draft';


            return `

                <div class="layout-name">

                    ${escapeHtml(
                        layout.name
                    )}

                </div>


                <span
                    class="
                        layout-status
                        ${statusClass}
                    "
                >

                    ${escapeHtml(
                        layout.status
                    )}

                </span>

            `;
        }



        /*
        |--------------------------------------------------------------------------
        | Product Status
        |--------------------------------------------------------------------------
        */

        function getProductStatusHtml(status)
        {
            let className =
                'status-draft';


            if (
                status === 'active'
            ) {

                className =
                    'status-active';

            }


            if (
                status === 'inactive'
            ) {

                className =
                    'status-inactive';

            }


            return `

                <span
                    class="
                        product-status
                        ${className}
                    "
                >

                    ${escapeHtml(
                        status
                    )}

                </span>

            `;
        }



        /*
        |--------------------------------------------------------------------------
        | Add Product Button
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'btn-add-product'
            )
            .addEventListener(
                'click',
                openCreateModal
            );


        document
            .getElementById(
                'btn-empty-create'
            )
            .addEventListener(
                'click',
                openCreateModal
            );


        document
            .getElementById(
                'btn-refresh'
            )
            .addEventListener(
                'click',
                async function () {

                    await loadProductLayouts();

                    await loadProducts();

                }
            );



        /*
        |--------------------------------------------------------------------------
        | Create Modal
        |--------------------------------------------------------------------------
        */

        function openCreateModal()
        {
            resetProductForm();


            editingProduct =
                null;


            originalLayoutId =
                null;


            document
                .getElementById(
                    'product-modal-title'
                )
                .textContent =
                    'Add Product';


            modal.modal(
                'show'
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Edit Product
        |--------------------------------------------------------------------------
        */

        async function openEditModal(id)
        {
            clearFormError();


            try {

                const response =
                    await fetch(
                        `/api/v1/admin/products/${id}`,
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


                const product =
                    result.data;


                editingProduct =
                    product;


                originalLayoutId =
                    product.product_layout_id
                    ?? null;


                document
                    .getElementById(
                        'product-modal-title'
                    )
                    .textContent =
                        'Edit Product';


                document
                    .getElementById(
                        'product-id'
                    )
                    .value =
                        product.id;


                document
                    .getElementById(
                        'product-name'
                    )
                    .value =
                        product.name
                        ?? '';


                document
                    .getElementById(
                        'product-slug'
                    )
                    .value =
                        product.slug
                        ?? '';


                document
                    .getElementById(
                        'product-code'
                    )
                    .value =
                        product.product_code
                        ?? '';


                document
                    .getElementById(
                        'product-status'
                    )
                    .value =
                        product.status
                        ?? 'draft';


                layoutSelect.value =
                    product.product_layout_id
                    ?? '';


                updateSelectedLayoutInfo();


                checkLayoutChanged();


                modal.modal(
                    'show'
                );

            } catch (error) {

                alert(
                    formatApiError(
                        error
                    )
                );

            }
        }



        /*
        |--------------------------------------------------------------------------
        | Layout Change
        |--------------------------------------------------------------------------
        */

        layoutSelect.addEventListener(
            'change',
            function () {

                updateSelectedLayoutInfo();

                checkLayoutChanged();

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Selected Layout Info
        |--------------------------------------------------------------------------
        */

        function updateSelectedLayoutInfo()
        {
            const value =
                layoutSelect.value;


            const info =
                document.getElementById(
                    'selected-layout-info'
                );


            if (!value) {

                info.classList.add(
                    'd-none'
                );


                return;

            }


            const layout =
                productLayouts.find(
                    item =>
                        String(item.id)
                        ===
                        String(value)
                );


            if (!layout) {

                info.classList.add(
                    'd-none'
                );


                return;

            }


            document
                .getElementById(
                    'selected-layout-name'
                )
                .textContent =
                    layout.name;


            document
                .getElementById(
                    'selected-layout-description'
                )
                .textContent =
                    layout.description
                    ?? '';


            const status =
                document.getElementById(
                    'selected-layout-status'
                );


            status.textContent =
                layout.status;


            status.className =
                layout.status === 'published'

                    ? 'badge badge-success'

                    : 'badge badge-warning';


            document
                .getElementById(
                    'selected-layout-builder'
                )
                .href =
                    `/admin/product-layouts/${layout.id}/builder`;


            info.classList.remove(
                'd-none'
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Layout Changed Warning
        |--------------------------------------------------------------------------
        */

        function checkLayoutChanged()
        {
            const warning =
                document.getElementById(
                    'layout-change-warning'
                );


            if (
                !editingProduct
            ) {

                warning.classList.add(
                    'd-none'
                );


                return;

            }


            const newLayoutId =
                layoutSelect.value

                    ? Number(
                        layoutSelect.value
                    )

                    : null;


            const oldLayoutId =
                originalLayoutId

                    ? Number(
                        originalLayoutId
                    )

                    : null;


            warning.classList.toggle(

                'd-none',

                newLayoutId
                ===
                oldLayoutId

            );
        }



        /*
        |--------------------------------------------------------------------------
        | Auto Slug
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'product-name'
            )
            .addEventListener(
                'input',
                function () {

                    /*
                     * Auto slug เฉพาะตอน Create
                     */
                    if (
                        editingProduct
                    ) {

                        return;

                    }


                    const slug =
                        makeSlug(
                            this.value
                        );


                    document
                        .getElementById(
                            'product-slug'
                        )
                        .value =
                            slug;

                }
            );



        /*
        |--------------------------------------------------------------------------
        | Save Product
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'save-product'
            )
            .addEventListener(
                'click',
                async function () {

                    clearFormError();


                    const id =
                        document
                            .getElementById(
                                'product-id'
                            )
                            .value;


                    const layoutValue =
                        layoutSelect.value;


                    const payload = {

                        name:
                            document
                                .getElementById(
                                    'product-name'
                                )
                                .value
                                .trim(),

                        slug:
                            document
                                .getElementById(
                                    'product-slug'
                                )
                                .value
                                .trim(),

                        product_code:
                            document
                                .getElementById(
                                    'product-code'
                                )
                                .value
                                .trim()
                            || null,

                        product_layout_id:
                            layoutValue
                                ? Number(
                                    layoutValue
                                )
                                : null,

                        status:
                            document
                                .getElementById(
                                    'product-status'
                                )
                                .value,

                    };


                    /*
                     * Basic validation
                     */
                    if (!payload.name) {

                        showFormError(
                            'Product Name is required.'
                        );


                        return;

                    }


                    if (!payload.slug) {

                        showFormError(
                            'Slug is required.'
                        );


                        return;

                    }


                    /*
                     * Endpoint
                     */
                    const url =
                        id

                            ? `/api/v1/admin/products/${id}`

                            : '/api/v1/admin/products';


                    const method =
                        id

                            ? 'PUT'

                            : 'POST';


                    const button =
                        this;


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


                        modal.modal(
                            'hide'
                        );


                        /*
                         * Reload
                         */
                        await loadProducts();


                        /*
                         * ถ้า Create และมี Layout
                         * สามารถถามว่าจะเข้า Content เลยไหม
                         */
                        if (
                            !id
                            &&
                            payload.product_layout_id
                            &&
                            result.data
                                ?.id
                        ) {

                            const goContent =
                                confirm(
                                    'Product created successfully.\n\nOpen Product Content Editor now?'
                                );


                            if (
                                goContent
                            ) {

                                window.location.href =
                                    `/admin/products/${result.data.id}/content`;

                            }

                        }

                    } catch (error) {

                        console.error(
                            error
                        );


                        showApiFormError(
                            error
                        );

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
        | Delete Product
        |--------------------------------------------------------------------------
        */

        async function deleteProduct(id)
        {
            const product =
                products.find(
                    item =>
                        String(item.id)
                        ===
                        String(id)
                );


            if (!product) {

                return;

            }


            if (
                !confirm(
                    `Delete product "${product.name}"?\n\nProduct content will also be deleted.`
                )
            ) {

                return;

            }


            try {

                const response =
                    await fetch(
                        `/api/v1/admin/products/${id}`,
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


                await loadProducts();

            } catch (error) {

                alert(
                    formatApiError(
                        error
                    )
                );

            }
        }



        /*
        |--------------------------------------------------------------------------
        | Bind Table Buttons
        |--------------------------------------------------------------------------
        */

        function bindProductButtons()
        {
            document
                .querySelectorAll(
                    '.edit-product'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                openEditModal(
                                    this.dataset.id
                                );

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.delete-product'
                )
                .forEach(
                    function (button) {

                        button.onclick =
                            function () {

                                deleteProduct(
                                    this.dataset.id
                                );

                            };

                    }
                );
        }



        /*
        |--------------------------------------------------------------------------
        | Reset
        |--------------------------------------------------------------------------
        */

        function resetProductForm()
        {
            editingProduct =
                null;


            originalLayoutId =
                null;


            document
                .getElementById(
                    'product-id'
                )
                .value =
                    '';


            document
                .getElementById(
                    'product-name'
                )
                .value =
                    '';


            document
                .getElementById(
                    'product-slug'
                )
                .value =
                    '';


            document
                .getElementById(
                    'product-code'
                )
                .value =
                    '';


            document
                .getElementById(
                    'product-status'
                )
                .value =
                    'draft';


            layoutSelect.value =
                '';


            document
                .getElementById(
                    'selected-layout-info'
                )
                .classList
                .add(
                    'd-none'
                );


            document
                .getElementById(
                    'layout-change-warning'
                )
                .classList
                .add(
                    'd-none'
                );


            clearFormError();
        }



        /*
        |--------------------------------------------------------------------------
        | Error
        |--------------------------------------------------------------------------
        */

        function clearFormError()
        {
            const box =
                document.getElementById(
                    'product-form-error'
                );


            box.innerHTML =
                '';


            box.classList.add(
                'd-none'
            );
        }


        function showFormError(message)
        {
            const box =
                document.getElementById(
                    'product-form-error'
                );


            box.textContent =
                message;


            box.classList.remove(
                'd-none'
            );
        }


        function showApiFormError(error)
        {
            const box =
                document.getElementById(
                    'product-form-error'
                );


            if (
                error.errors
            ) {

                box.innerHTML =
                    Object
                        .values(
                            error.errors
                        )
                        .flat()
                        .map(
                            escapeHtml
                        )
                        .join(
                            '<br>'
                        );

            } else {

                box.textContent =
                    error.message
                    ?? 'An error occurred.';

            }


            box.classList.remove(
                'd-none'
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Helpers
        |--------------------------------------------------------------------------
        */

        function makeSlug(value)
        {
            return String(
                value
                ?? ''
            )
                .trim()
                .toLowerCase()
                .replace(
                    /[^a-z0-9]+/g,
                    '-'
                )
                .replace(
                    /^-+|-+$/g,
                    ''
                );
        }


        function formatDateTime(value)
        {
            if (!value) {

                return '-';

            }


            const date =
                new Date(
                    value
                );


            if (
                Number.isNaN(
                    date.getTime()
                )
            ) {

                return value;

            }


            return date
                .toLocaleString();
        }


        function formatApiError(error)
        {
            if (
                error.errors
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
                error.message
                ??
                'An error occurred.'
            );
        }


        function escapeHtml(value)
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

    }
);

</script>

@endpush