@extends('admin.layouts.app')

@section('title', 'Product Layouts')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Product Layouts
            </h1>

            <p class="text-muted mb-0">
                Create and manage reusable product layouts.
            </p>
        </div>

        <button
            type="button"
            class="btn btn-primary"
            id="btn-add-layout"
        >
            + Create Layout
        </button>

    </div>


    {{-- Main Card --}}
    <div class="card shadow">

        <div class="card-header py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h6 class="m-0 font-weight-bold text-primary">
                    Layout List
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
                id="layout-loading"
                class="text-center py-4"
            >
                Loading...
            </div>


            {{-- Error --}}
            <div
                id="layout-error"
                class="alert alert-danger d-none"
            ></div>


            {{-- Empty --}}
            <div
                id="layout-empty"
                class="text-center text-muted py-5 d-none"
            >

                No layouts found.

                <br>

                <button
                    type="button"
                    class="btn btn-primary mt-3"
                    id="btn-empty-create"
                >
                    Create First Layout
                </button>

            </div>


            {{-- Table --}}
            <div
                class="table-responsive d-none"
                id="layout-table-wrapper"
            >

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>

                            <th style="width:70px;">
                                ID
                            </th>

                            <th>
                                Layout Name
                            </th>

                            <th>
                                Slug
                            </th>

                            <th style="width:120px;">
                                Products
                            </th>

                            <th style="width:130px;">
                                Status
                            </th>

                            <th style="width:170px;">
                                Published
                            </th>

                            <th style="width:260px;">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="layout-list"></tbody>

                </table>

            </div>

        </div>

    </div>

</div>



{{-- ============================================================ --}}
{{-- Create / Edit Layout Modal --}}
{{-- ============================================================ --}}

<div
    class="modal fade"
    id="layoutModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>

    <div
        class="modal-dialog"
        role="document"
    >

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="layout-modal-title"
                >
                    Create Layout
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


            <div class="modal-body">

                <div
                    id="layout-form-error"
                    class="alert alert-danger d-none"
                ></div>


                <input
                    type="hidden"
                    id="layout-id"
                >


                {{-- Name --}}
                <div class="form-group">

                    <label>
                        Layout Name
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="layout-name"
                        class="form-control"
                        placeholder="Product Default"
                    >

                </div>


                {{-- Slug --}}
                <div class="form-group">

                    <label>
                        Slug
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="layout-slug"
                        class="form-control"
                        placeholder="product-default"
                    >

                    <small class="form-text text-muted">
                        Example: product-default
                    </small>

                </div>


                {{-- Description --}}
                <div class="form-group mb-0">

                    <label>
                        Description
                    </label>

                    <textarea
                        id="layout-description"
                        class="form-control"
                        rows="4"
                        maxlength="500"
                        placeholder="Default layout for product pages"
                    ></textarea>

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
                    id="save-layout"
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

    #layout-list td {
        vertical-align: middle;
    }

    .layout-name {
        font-weight: 600;
    }

    .layout-description {
        font-size: 12px;
        color: #777;
        margin-top: 3px;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .status-draft {
        background: #e9ecef;
        color: #333;
    }

    .status-published {
        background: #d4edda;
        color: #155724;
    }

</style>

@endpush



@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Variables
    |--------------------------------------------------------------------------
    */

    let layouts = [];


    const modal =
        $('#layoutModal');


    const csrf =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute('content');


    const loading =
        document.getElementById(
            'layout-loading'
        );


    const errorBox =
        document.getElementById(
            'layout-error'
        );


    const emptyBox =
        document.getElementById(
            'layout-empty'
        );


    const tableWrapper =
        document.getElementById(
            'layout-table-wrapper'
        );


    const list =
        document.getElementById(
            'layout-list'
        );


    /*
    |--------------------------------------------------------------------------
    | Load Layouts
    |--------------------------------------------------------------------------
    */

    async function loadLayouts()
    {
        loading.classList.remove('d-none');
        errorBox.classList.add('d-none');
        emptyBox.classList.add('d-none');
        tableWrapper.classList.add('d-none');


        try {

            const response =
                await fetch(
                    '/api/v1/admin/product-layouts',
                    {
                        credentials: 'same-origin',

                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                );


            const result =
                await response.json();


            if (!response.ok) {
                throw result;
            }


            layouts =
                result.data ?? [];


            renderLayouts();

        } catch (error) {

            console.error(error);

            errorBox.textContent =
                error.message
                ?? 'Failed to load layouts.';

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
    | Render
    |--------------------------------------------------------------------------
    */

    function renderLayouts()
    {
        list.innerHTML = '';


        if (layouts.length === 0) {

            emptyBox.classList.remove(
                'd-none'
            );

            return;
        }


        tableWrapper.classList.remove(
            'd-none'
        );


        layouts.forEach(function (layout) {

            const tr =
                document.createElement('tr');


            const publishedDate =
                layout.published_at
                    ? formatDateTime(
                        layout.published_at
                    )
                    : '-';


            const statusClass =
                layout.status === 'published'
                    ? 'status-published'
                    : 'status-draft';


            tr.innerHTML = `

                <td>
                    ${layout.id}
                </td>


                <td>

                    <div class="layout-name">
                        ${escapeHtml(layout.name)}
                    </div>

                    <div class="layout-description">
                        ${escapeHtml(
                            layout.description ?? ''
                        )}
                    </div>

                </td>


                <td>
                    ${escapeHtml(layout.slug)}
                </td>


                <td>
                    ${layout.products_count ?? 0}
                </td>


                <td>

                    <span
                        class="
                            status-badge
                            ${statusClass}
                        "
                    >
                        ${escapeHtml(layout.status)}
                    </span>

                </td>


                <td>
                    ${publishedDate}
                </td>


                <td>

                    <a
                        href="/admin/product-layouts/${layout.id}/builder"
                        class="btn btn-sm btn-primary"
                    >
                        Builder
                    </a>


                    <button
                        type="button"
                        class="btn btn-sm btn-warning btn-edit"
                        data-id="${layout.id}"
                    >
                        Edit
                    </button>


                    <button
                        type="button"
                        class="btn btn-sm btn-danger btn-delete"
                        data-id="${layout.id}"
                    >
                        Delete
                    </button>

                </td>

            `;


            list.appendChild(tr);

        });


        bindTableButtons();
    }


    /*
    |--------------------------------------------------------------------------
    | Buttons
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('btn-add-layout')
        .addEventListener(
            'click',
            openCreateModal
        );


    document
        .getElementById('btn-empty-create')
        .addEventListener(
            'click',
            openCreateModal
        );


    document
        .getElementById('btn-refresh')
        .addEventListener(
            'click',
            loadLayouts
        );


    /*
    |--------------------------------------------------------------------------
    | Create Modal
    |--------------------------------------------------------------------------
    */

    function openCreateModal()
    {
        resetForm();


        document
            .getElementById(
                'layout-modal-title'
            )
            .textContent =
                'Create Layout';


        modal.modal('show');
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Modal
    |--------------------------------------------------------------------------
    */

    function openEditModal(id)
    {
        const layout =
            layouts.find(
                item =>
                    String(item.id)
                    === String(id)
            );


        if (!layout) {
            return;
        }


        resetForm();


        document
            .getElementById(
                'layout-modal-title'
            )
            .textContent =
                'Edit Layout';


        document
            .getElementById(
                'layout-id'
            )
            .value =
                layout.id;


        document
            .getElementById(
                'layout-name'
            )
            .value =
                layout.name;


        document
            .getElementById(
                'layout-slug'
            )
            .value =
                layout.slug;


        document
            .getElementById(
                'layout-description'
            )
            .value =
                layout.description ?? '';


        modal.modal('show');
    }


    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    document
        .getElementById(
            'save-layout'
        )
        .addEventListener(
            'click',
            async function () {

                clearFormError();


                const id =
                    document
                        .getElementById(
                            'layout-id'
                        )
                        .value;


                const payload = {

                    name:
                        document
                            .getElementById(
                                'layout-name'
                            )
                            .value
                            .trim(),

                    slug:
                        document
                            .getElementById(
                                'layout-slug'
                            )
                            .value
                            .trim(),

                    description:
                        document
                            .getElementById(
                                'layout-description'
                            )
                            .value
                            .trim()
                        || null,

                };


                if (!payload.name) {

                    showFormError(
                        'Layout Name is required.'
                    );

                    return;
                }


                if (!payload.slug) {

                    showFormError(
                        'Slug is required.'
                    );

                    return;
                }


                const url =
                    id
                        ? `/api/v1/admin/product-layouts/${id}`
                        : '/api/v1/admin/product-layouts';


                const method =
                    id
                        ? 'PUT'
                        : 'POST';


                const button =
                    this;


                try {

                    button.disabled = true;

                    button.textContent =
                        'Saving...';


                    const response =
                        await fetch(
                            url,
                            {
                                method: method,

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


                    await loadLayouts();

                } catch (error) {

                    console.error(error);

                    showApiError(error);

                } finally {

                    button.disabled = false;

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

    async function deleteLayout(id)
    {
        const layout =
            layouts.find(
                item =>
                    String(item.id)
                    === String(id)
            );


        if (!layout) {
            return;
        }


        if (
            !confirm(
                `Delete layout "${layout.name}"?`
            )
        ) {
            return;
        }


        try {

            const response =
                await fetch(
                    `/api/v1/admin/product-layouts/${id}`,
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

                        }
                    }
                );


            const result =
                await response.json();


            if (!response.ok) {
                throw result;
            }


            await loadLayouts();

        } catch (error) {

            alert(
                error.message
                ?? 'Delete failed.'
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
                '.btn-edit'
            )
            .forEach(function (button) {

                button.onclick =
                    function () {

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
                    function () {

                        deleteLayout(
                            this.dataset.id
                        );

                    };

            });
    }


    /*
    |--------------------------------------------------------------------------
    | Form
    |--------------------------------------------------------------------------
    */

    function resetForm()
    {
        document
            .getElementById(
                'layout-id'
            )
            .value = '';


        document
            .getElementById(
                'layout-name'
            )
            .value = '';


        document
            .getElementById(
                'layout-slug'
            )
            .value = '';


        document
            .getElementById(
                'layout-description'
            )
            .value = '';


        clearFormError();
    }


    function clearFormError()
    {
        const box =
            document.getElementById(
                'layout-form-error'
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
                'layout-form-error'
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
                'layout-form-error'
            );


        if (error.errors) {

            box.innerHTML =
                Object
                    .values(error.errors)
                    .flat()
                    .join('<br>');

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


    function formatDateTime(value)
    {
        const date =
            new Date(value);


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


    /*
    |--------------------------------------------------------------------------
    | Start
    |--------------------------------------------------------------------------
    */

    loadLayouts();

});

</script>

@endpush