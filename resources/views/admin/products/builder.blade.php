@extends('admin.layouts.app')

@section('title', 'Product Page Builder')
@push('styles')

<style>

.builder-components .btn {
    text-align: left;
}


#builder-canvas {
    min-height: 400px;
}


.builder-block {
    margin-bottom: 15px;
}


.builder-block-inner {

    height: 100%;

    border:
        1px solid #d9d9d9;

    border-radius:
        6px;

    background:
        #fff;

    overflow:
        hidden;

}


.builder-block-header {

    background:
        #f8f9fa;

    border-bottom:
        1px solid #ddd;

    padding:
        8px 10px;

    display:
        flex;

    justify-content:
        space-between;

    align-items:
        center;

}


.builder-drag {
    cursor:
        move;

    font-weight:
        bold;
}


.builder-preview {
    padding:
        15px;

    min-height:
        80px;
}


.builder-actions button {
    padding:
        2px 7px;
}


.system-block {

    border-left:
        4px solid #007bff;

}


.sortable-ghost {
    opacity:
        .3;
}

</style>

@endpush
@section('content')

<div class="container-fluid">

    {{-- Header --}}

    <div
        class="d-flex justify-content-between align-items-center mb-3"
    >

        <div>

            <a
                href="{{ route('admin.products.index') }}"
            >
                ← Products
            </a>

            <h1 class="h3 mt-2 mb-0">
                {{ $product->name }}
            </h1>

            <small class="text-muted">
                Page Builder
            </small>

        </div>


        <div>

            <button
                id="save-draft"
                class="btn btn-secondary"
            >
                Save Draft
            </button>

            <button
                id="publish-page"
                class="btn btn-success"
            >
                Publish
            </button>

        </div>

    </div>


    <div class="row">


        {{-- ================================================= --}}
        {{-- Components --}}
        {{-- ================================================= --}}

        <div class="col-md-3">

            <div class="card shadow-sm">

                <div class="card-header">
                    Components
                </div>

                <div class="card-body">

                    <div class="builder-components">

                        <button
                            data-type="heading"
                            class="btn btn-light btn-block add-block"
                        >
                            + Heading
                        </button>


                        <button
                            data-type="rich_text"
                            class="btn btn-light btn-block add-block"
                        >
                            + Text
                        </button>


                        <button
                            data-type="image"
                            class="btn btn-light btn-block add-block"
                        >
                            + Image
                        </button>


                        <button
                            data-type="button"
                            class="btn btn-light btn-block add-block"
                        >
                            + Button
                        </button>


                        <button
                            data-type="info_card"
                            class="btn btn-light btn-block add-block"
                        >
                            + Info Card
                        </button>


                        <button
                            data-type="accordion"
                            class="btn btn-light btn-block add-block"
                        >
                            + Accordion
                        </button>


                        <button
                            data-type="product_gallery"
                            class="btn btn-light btn-block add-block"
                        >
                            + Product Gallery
                        </button>


                        <hr>


                        <small class="text-muted">
                            System Components
                        </small>


                        <button
                            data-type="price_accordion"
                            class="btn btn-outline-primary btn-block add-block mt-2"
                        >
                            + Price
                        </button>


                        <button
                            data-type="shipping_schedule"
                            class="btn btn-outline-primary btn-block add-block"
                        >
                            + Shipping Schedule
                        </button>


                        <button
                            data-type="production_schedule"
                            class="btn btn-outline-primary btn-block add-block"
                        >
                            + Production Schedule
                        </button>


                        <hr>


                        <button
                            data-type="divider"
                            class="btn btn-light btn-block add-block"
                        >
                            + Divider
                        </button>


                        <button
                            data-type="spacer"
                            class="btn btn-light btn-block add-block"
                        >
                            + Spacer
                        </button>

                    </div>

                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- Canvas --}}
        {{-- ================================================= --}}

        <div class="col-md-9">

            <div class="card shadow-sm">

                <div
                    class="card-header d-flex justify-content-between"
                >

                    <span>
                        Page Layout
                    </span>

                    <small class="text-muted">
                        Drag blocks to reorder
                    </small>

                </div>


                <div class="card-body">

                    <div
                        id="builder-canvas"
                        class="row"
                    >
                    </div>


                    <div
                        id="empty-builder"
                        class="text-center text-muted py-5"
                    >
                        Add a component to start building.
                    </div>

                </div>

            </div>


            {{-- Locked Area --}}

            <div class="card mt-4 border-danger">

                <div class="card-header bg-light">

                    🔒 System Area

                </div>

                <div class="card-body text-center">

                    <strong>
                        Order Form
                    </strong>

                    <br>

                    <small class="text-muted">

                        This section is controlled
                        by the system and cannot
                        be moved or edited.

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- Block Editor --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="blockModal"
>

    <div
        class="modal-dialog modal-lg"
    >

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Edit Block
                </h5>

                <button
                    class="close"
                    data-dismiss="modal"
                >
                    &times;
                </button>

            </div>


            <div class="modal-body">

                <input
                    type="hidden"
                    id="block-id"
                >


                <div class="form-group">

                    <label>
                        Width
                    </label>

                    <select
                        id="block-width"
                        class="form-control"
                    >

                        <option value="12">
                            100%
                        </option>

                        <option value="8">
                            66%
                        </option>

                        <option value="6">
                            50%
                        </option>

                        <option value="4">
                            33%
                        </option>

                    </select>

                </div>


                <div id="block-fields">
                </div>

            </div>


            <div class="modal-footer">

                <button
                    id="delete-block"
                    class="btn btn-danger mr-auto"
                >
                    Delete
                </button>

                <button
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    id="save-block"
                    class="btn btn-primary"
                >
                    Apply
                </button>

            </div>

        </div>

    </div>

</div>

@endsection
@push('scripts')

<script
    src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"
></script>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const productId =
            {{ $product->id }};


        const csrf =
            document
                .querySelector(
                    'meta[name="csrf-token"]'
                )
                .content;


        let blocks = [];

        let editingBlockId =
            null;


        const canvas =
            document.getElementById(
                'builder-canvas'
            );


        const modal =
            $('#blockModal');


        /*
        |--------------------------------------------------------------------------
        | Drag Drop
        |--------------------------------------------------------------------------
        */

        new Sortable(
            canvas,
            {

                animation:
                    150,

                handle:
                    '.builder-drag',

                ghostClass:
                    'sortable-ghost',

                onEnd:
                    syncOrder,

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Load
        |--------------------------------------------------------------------------
        */

        async function loadPage()
        {

            const response =
                await fetch(

                    `/api/v1/admin/products/${productId}/page`,

                    {

                        credentials:
                            'same-origin',

                        headers: {

                            'Accept':
                                'application/json'

                        }

                    }

                );


            const result =
                await response.json();


            blocks =
                result
                    .data
                    ?.page
                    ?.draft_layout_json
                    ?.blocks
                ?? [];


            render();

        }


        /*
        |--------------------------------------------------------------------------
        | Add
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.add-block'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        function () {

                            const type =
                                this.dataset.type;


                            const block = {

                                id:
                                    generateId(),

                                type:
                                    type,

                                width:
                                    12,

                                data:
                                    defaultData(
                                        type
                                    ),

                            };


                            blocks.push(
                                block
                            );


                            render();


                            openEditor(
                                block.id
                            );

                        }
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Default Data
        |--------------------------------------------------------------------------
        */

        function defaultData(type)
        {

            switch (type) {

                case 'heading':

                    return {
                        text:
                            'Heading'
                    };


                case 'rich_text':

                    return {
                        content:
                            'Enter text here.'
                    };


                case 'image':

                    return {

                        url:
                            '',

                        alt:
                            '',

                        link:
                            '',

                    };


                case 'button':

                    return {

                        text:
                            'Button',

                        url:
                            '#',

                    };


                case 'info_card':

                    return {

                        title:
                            'Info Card',

                        image:
                            '',

                        description:
                            '',

                        link_text:
                            '',

                        link_url:
                            '',

                    };


                case 'accordion':

                    return {

                        title:
                            'Accordion',

                        content:
                            '',

                    };


                case 'product_gallery':

                    return {

                        images:
                            [],

                    };


                case 'price_accordion':

                    return {

                        title:
                            '価格・制作料金について',

                    };


                case 'shipping_schedule':

                    return {

                        title:
                            '出荷目安・納期について',

                    };


                case 'production_schedule':

                    return {

                        title:
                            '製作日数',

                    };


                case 'spacer':

                    return {

                        height:
                            30,

                    };


                default:

                    return {};

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        function render()
        {

            canvas.innerHTML =
                '';


            blocks.forEach(
                block => {

                    const wrapper =
                        document.createElement(
                            'div'
                        );


                    wrapper.className =
                        `col-md-${block.width} builder-block`;


                    wrapper.dataset.id =
                        block.id;


                    const system =
                        isSystemBlock(
                            block.type
                        );


                    wrapper.innerHTML = `

                        <div
                            class="
                                builder-block-inner
                                ${system ? 'system-block' : ''}
                            "
                        >

                            <div
                                class="builder-block-header"
                            >

                                <span
                                    class="builder-drag"
                                >
                                    ☰
                                    ${getBlockName(
                                        block.type
                                    )}
                                </span>


                                <div
                                    class="builder-actions"
                                >

                                    <button
                                        type="button"
                                        class="
                                            btn
                                            btn-sm
                                            btn-outline-primary
                                            edit-block
                                        "
                                        data-id="${block.id}"
                                    >
                                        Edit
                                    </button>


                                    <button
                                        type="button"
                                        class="
                                            btn
                                            btn-sm
                                            btn-outline-secondary
                                            duplicate-block
                                        "
                                        data-id="${block.id}"
                                    >
                                        Copy
                                    </button>

                                </div>

                            </div>


                            <div
                                class="builder-preview"
                            >

                                ${previewBlock(
                                    block
                                )}

                            </div>

                        </div>

                    `;


                    canvas.appendChild(
                        wrapper
                    );

                }
            );


            document
                .getElementById(
                    'empty-builder'
                )
                .classList
                .toggle(
                    'd-none',
                    blocks.length > 0
                );


            bindBlockButtons();

        }


        /*
        |--------------------------------------------------------------------------
        | Preview
        |--------------------------------------------------------------------------
        */

        function previewBlock(
            block
        )
        {

            const data =
                block.data;


            switch (
                block.type
            ) {

                case 'heading':

                    return `
                        <h3>
                            ${escapeHtml(
                                data.text
                            )}
                        </h3>
                    `;


                case 'rich_text':

                    return `
                        <p>
                            ${escapeHtml(
                                data.content
                            )}
                        </p>
                    `;


                case 'image':

                    return data.url

                        ? `
                            <img
                                src="${escapeHtml(data.url)}"
                                style="
                                    max-width:100%;
                                    max-height:180px;
                                "
                            >
                        `

                        : `
                            <div
                                class="text-muted"
                            >
                                No image
                            </div>
                        `;


                case 'button':

                    return `
                        <button
                            class="btn btn-primary"
                        >
                            ${escapeHtml(
                                data.text
                            )}
                        </button>
                    `;


                case 'info_card':

                    return `

                        <strong>
                            ${escapeHtml(
                                data.title
                            )}
                        </strong>

                        <p class="mb-0 mt-2">
                            ${escapeHtml(
                                data.description
                            )}
                        </p>

                    `;


                case 'accordion':

                    return `
                        <strong>
                            ▾
                            ${escapeHtml(
                                data.title
                            )}
                        </strong>
                    `;


                case 'product_gallery':

                    return `
                        🖼 Product Gallery
                        (${data.images?.length ?? 0} images)
                    `;


                case 'price_accordion':

                case 'shipping_schedule':

                case 'production_schedule':

                    return `

                        <div
                            class="
                                alert
                                alert-primary
                                mb-0
                            "
                        >
                            System Component
                            <br>

                            <strong>
                                ${escapeHtml(
                                    data.title
                                )}
                            </strong>
                        </div>

                    `;


                case 'divider':

                    return `
                        <hr>
                    `;


                case 'spacer':

                    return `
                        <div
                            style="
                                height:
                                    ${data.height ?? 30}px;
                                background:#f7f7f7;
                            "
                        >
                        </div>
                    `;


                default:

                    return '';
            }

        }


        /*
        |--------------------------------------------------------------------------
        | Edit
        |--------------------------------------------------------------------------
        */

        function openEditor(
            id
        ) {

            editingBlockId =
                id;


            const block =
                blocks.find(
                    item =>
                        item.id === id
                );


            if (!block) {
                return;
            }


            document
                .getElementById(
                    'block-id'
                )
                .value =
                    id;


            document
                .getElementById(
                    'block-width'
                )
                .value =
                    block.width;


            renderFields(
                block
            );


            modal.modal(
                'show'
            );
        }


        function renderFields(
            block
        ) {

            const fields =
                document.getElementById(
                    'block-fields'
                );


            const data =
                block.data;


            switch (
                block.type
            ) {

                case 'heading':

                    fields.innerHTML =
                        textInput(
                            'Text',
                            'text',
                            data.text
                        );

                    break;


                case 'rich_text':

                    fields.innerHTML =
                        textareaInput(
                            'Content',
                            'content',
                            data.content
                        );

                    break;


                case 'image':

                    fields.innerHTML =

                        textInput(
                            'Image URL / Path',
                            'url',
                            data.url
                        )

                        +

                        textInput(
                            'Alt',
                            'alt',
                            data.alt
                        )

                        +

                        textInput(
                            'Link URL',
                            'link',
                            data.link
                        );

                    break;


                case 'button':

                    fields.innerHTML =

                        textInput(
                            'Button Text',
                            'text',
                            data.text
                        )

                        +

                        textInput(
                            'URL',
                            'url',
                            data.url
                        );

                    break;


                case 'info_card':

                    fields.innerHTML =

                        textInput(
                            'Title',
                            'title',
                            data.title
                        )

                        +

                        textInput(
                            'Image',
                            'image',
                            data.image
                        )

                        +

                        textareaInput(
                            'Description',
                            'description',
                            data.description
                        )

                        +

                        textInput(
                            'Link Text',
                            'link_text',
                            data.link_text
                        )

                        +

                        textInput(
                            'Link URL',
                            'link_url',
                            data.link_url
                        );

                    break;


                case 'accordion':

                    fields.innerHTML =

                        textInput(
                            'Title',
                            'title',
                            data.title
                        )

                        +

                        textareaInput(
                            'Content',
                            'content',
                            data.content
                        );

                    break;


                case 'product_gallery':

                    fields.innerHTML = `

                        <div class="form-group">

                            <label>
                                Images
                                (one URL per line)
                            </label>

                            <textarea
                                class="form-control block-field"
                                data-key="images_text"
                                rows="8"
                            >${escapeHtml(
                                (data.images ?? [])
                                    .join('\n')
                            )}</textarea>

                        </div>

                    `;

                    break;


                case 'price_accordion':

                case 'shipping_schedule':

                case 'production_schedule':

                    fields.innerHTML =
                        textInput(
                            'Title',
                            'title',
                            data.title
                        );

                    break;


                case 'spacer':

                    fields.innerHTML = `

                        <div class="form-group">

                            <label>
                                Height
                            </label>

                            <input
                                type="number"
                                class="
                                    form-control
                                    block-field
                                "
                                data-key="height"
                                value="${
                                    data.height ?? 30
                                }"
                            >

                        </div>

                    `;

                    break;


                default:

                    fields.innerHTML =
                        '<p>No settings.</p>';
            }

        }


        /*
        |--------------------------------------------------------------------------
        | Apply Block
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'save-block'
            )
            .addEventListener(
                'click',
                function () {

                    const block =
                        blocks.find(
                            item =>
                                item.id
                                === editingBlockId
                        );


                    if (!block) {
                        return;
                    }


                    block.width =
                        Number(
                            document
                                .getElementById(
                                    'block-width'
                                )
                                .value
                        );


                    document
                        .querySelectorAll(
                            '#block-fields .block-field'
                        )
                        .forEach(
                            field => {

                                const key =
                                    field.dataset.key;


                                if (
                                    key
                                    === 'images_text'
                                ) {

                                    block.data.images =
                                        field.value
                                            .split('\n')
                                            .map(
                                                item =>
                                                    item.trim()
                                            )
                                            .filter(
                                                Boolean
                                            );

                                    return;
                                }


                                if (
                                    field.type
                                    === 'number'
                                ) {

                                    block.data[key] =
                                        Number(
                                            field.value
                                        );

                                } else {

                                    block.data[key] =
                                        field.value;

                                }

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
        | Delete
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'delete-block'
            )
            .addEventListener(
                'click',
                function () {

                    blocks =
                        blocks.filter(
                            block =>
                                block.id
                                !== editingBlockId
                        );


                    modal.modal(
                        'hide'
                    );


                    render();

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Buttons
        |--------------------------------------------------------------------------
        */

        function bindBlockButtons()
        {

            document
                .querySelectorAll(
                    '.edit-block'
                )
                .forEach(
                    button => {

                        button.onclick =
                            function () {

                                openEditor(
                                    this.dataset.id
                                );

                            };

                    }
                );


            document
                .querySelectorAll(
                    '.duplicate-block'
                )
                .forEach(
                    button => {

                        button.onclick =
                            function () {

                                const original =
                                    blocks.find(
                                        item =>
                                            item.id
                                            === this.dataset.id
                                    );


                                if (!original) {
                                    return;
                                }


                                const copy =
                                    JSON.parse(
                                        JSON.stringify(
                                            original
                                        )
                                    );


                                copy.id =
                                    generateId();


                                const index =
                                    blocks.findIndex(
                                        item =>
                                            item.id
                                            === original.id
                                    );


                                blocks.splice(
                                    index + 1,
                                    0,
                                    copy
                                );


                                render();

                            };

                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Sync Drag Order
        |--------------------------------------------------------------------------
        */

        function syncOrder()
        {

            const ids =
                Array
                    .from(
                        canvas.children
                    )
                    .map(
                        element =>
                            element.dataset.id
                    );


            blocks =
                ids.map(
                    id =>
                        blocks.find(
                            block =>
                                block.id
                                === id
                        )
                );

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
            .addEventListener(
                'click',
                async function () {

                    syncOrder();


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
                                            blocks

                                    }),

                            }

                        );


                    const result =
                        await response.json();


                    if (!response.ok) {

                        alert(
                            result.message
                            ?? 'Save failed'
                        );

                        return;
                    }


                    alert(
                        'Draft saved.'
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Publish
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'publish-page'
            )
            .addEventListener(
                'click',
                async function () {

                    /*
                     * Save first
                     */
                    document
                        .getElementById(
                            'save-draft'
                        )
                        .click();


                    if (
                        !confirm(
                            'Publish this page?'
                        )
                    ) {
                        return;
                    }


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


                    if (!response.ok) {

                        alert(
                            result.message
                            ?? 'Publish failed'
                        );

                        return;
                    }


                    alert(
                        'Published.'
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Helpers
        |--------------------------------------------------------------------------
        */

        function isSystemBlock(type)
        {

            return [

                'price_accordion',

                'shipping_schedule',

                'production_schedule',

            ].includes(
                type
            );

        }


        function getBlockName(type)
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

                info_card:
                    'Info Card',

                accordion:
                    'Accordion',

                product_gallery:
                    'Product Gallery',

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


            return names[type]
                ?? type;
        }


        function generateId()
        {

            return 'block_'
                + Date.now()
                + '_'
                + Math
                    .random()
                    .toString(36)
                    .substring(2, 7);

        }


        function textInput(
            label,
            key,
            value
        ) {

            return `

                <div class="form-group">

                    <label>
                        ${label}
                    </label>

                    <input
                        type="text"
                        class="
                            form-control
                            block-field
                        "
                        data-key="${key}"
                        value="${escapeHtml(
                            value ?? ''
                        )}"
                    >

                </div>

            `;

        }


        function textareaInput(
            label,
            key,
            value
        ) {

            return `

                <div class="form-group">

                    <label>
                        ${label}
                    </label>

                    <textarea
                        class="
                            form-control
                            block-field
                        "
                        data-key="${key}"
                        rows="6"
                    >${escapeHtml(
                        value ?? ''
                    )}</textarea>

                </div>

            `;

        }


        function escapeHtml(value)
        {

            return String(
                value ?? ''
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

        loadPage();

    }
);

</script>

@endpush