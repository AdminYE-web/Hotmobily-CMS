@extends('admin.layouts.app')

@section('title', 'Holiday Management')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">
                Holiday Management
            </h1>

            <p class="text-muted mb-0">
                Manage holiday calendar.
            </p>
        </div>

        <button
            type="button"
            class="btn btn-primary"
            id="btn-add-holiday"
        >
            + Add Holiday
        </button>

    </div>


    {{-- Legend --}}
    <div class="card shadow-sm mb-4">

        <div class="card-body py-3">

            <div class="d-flex flex-wrap align-items-center">

                <div class="mr-4">
                    <span class="holiday-color holiday-type1"></span>
                    ① 営業 + 生産休業日
                </div>

                <div class="mr-4">
                    <span class="holiday-color holiday-type2"></span>
                    ② 営業休業日（生産はあり）
                </div>

                <div>
                    <span class="holiday-color holiday-type3"></span>
                    ③ 生産休業日（営業はあり）
                </div>

            </div>

        </div>

    </div>


    {{-- List --}}
    <div class="card shadow">

        <div class="card-header py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h6 class="m-0 font-weight-bold text-primary">
                    Holiday List
                </h6>

                <button
                    type="button"
                    id="btn-refresh"
                    class="btn btn-sm btn-outline-secondary"
                >
                    Refresh
                </button>

            </div>

        </div>


        <div class="card-body">

            {{-- Loading --}}
            <div
                id="holiday-loading"
                class="text-center py-4"
            >
                Loading...
            </div>


            {{-- Error --}}
            <div
                id="holiday-list-error"
                class="alert alert-danger d-none"
            ></div>


            <div
                class="table-responsive d-none"
                id="holiday-table-wrapper"
            >

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>

                            <th style="width: 140px;">
                                Date
                            </th>

                            <th>
                                Holiday Type
                            </th>

                            <th style="width: 160px;">
                                Calendar
                            </th>

                            <th>
                                Title / Note
                            </th>

                            <th style="width: 160px;">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="holiday-list">

                    </tbody>

                </table>

            </div>


            <div
                id="holiday-empty"
                class="text-center text-muted py-5 d-none"
            >
                No holidays found.
            </div>

        </div>

    </div>

</div>



{{-- ============================================================ --}}
{{-- Add / Edit Modal --}}
{{-- ============================================================ --}}

<div
    class="modal fade"
    id="holidayModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>

    <div
        class="modal-dialog"
        role="document"
    >

        <div class="modal-content">


            {{-- Header --}}
            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="holiday-modal-title"
                >
                    Add Holiday
                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>

            </div>


            {{-- Body --}}
            <div class="modal-body">


                {{-- Error --}}
                <div
                    id="holiday-form-error"
                    class="alert alert-danger d-none"
                ></div>


                {{-- Hidden ID --}}
                <input
                    type="hidden"
                    id="holiday-id"
                >


                {{-- Date --}}
                <div class="form-group">

                    <label>
                        Date
                        <span class="text-danger">*</span>
                    </label>


                    <div class="input-group">

                        <input
                            type="text"
                            id="holiday-date"
                            class="form-control"
                            placeholder="YYYY-MM-DD"
                            readonly
                        >


                        <div class="input-group-append">

                            <button
                                type="button"
                                id="open-calendar"
                                class="btn btn-outline-secondary"
                            >
                                📅
                            </button>

                        </div>

                    </div>

                </div>


                {{-- Holiday Type --}}
                <div class="form-group">

                    <label>
                        Holiday Type
                        <span class="text-danger">*</span>
                    </label>


                    <div class="custom-control custom-radio mb-2">

                        <input
                            type="radio"
                            id="holiday-type1"
                            name="holiday_type"
                            value="type1"
                            class="custom-control-input"
                        >

                        <label
                            for="holiday-type1"
                            class="custom-control-label"
                        >
                            <span class="holiday-color holiday-type1"></span>
                            ① 営業 + 生産休業日
                        </label>

                    </div>


                    <div class="custom-control custom-radio mb-2">

                        <input
                            type="radio"
                            id="holiday-type2"
                            name="holiday_type"
                            value="type2"
                            class="custom-control-input"
                        >

                        <label
                            for="holiday-type2"
                            class="custom-control-label"
                        >
                            <span class="holiday-color holiday-type2"></span>
                            ② 営業休業日（生産はあり）
                        </label>

                    </div>


                    <div class="custom-control custom-radio">

                        <input
                            type="radio"
                            id="holiday-type3"
                            name="holiday_type"
                            value="type3"
                            class="custom-control-input"
                        >

                        <label
                            for="holiday-type3"
                            class="custom-control-label"
                        >
                            <span class="holiday-color holiday-type3"></span>
                            ③ 生産休業日（営業はあり）
                        </label>

                    </div>

                </div>


                {{-- Calendar Type --}}
                <div class="form-group">

                    <label>
                        Calendar Type
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        id="calendar-type"
                        class="form-control"
                    >

                        <option value="both">
                            Normal + Cloth
                        </option>

                        <option value="normal">
                            Normal only
                        </option>

                        <option value="cloth">
                            Cloth only
                        </option>

                    </select>

                </div>


                {{-- Title --}}
                <div class="form-group mb-0">

                    <label>
                        Title / Note
                    </label>

                    <input
                        type="text"
                        id="holiday-title"
                        class="form-control"
                        maxlength="255"
                        placeholder="Example: 敬老の日"
                    >

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
                    id="save-holiday"
                    class="btn btn-primary"
                >
                    Save
                </button>

            </div>

        </div>

    </div>

</div>

@endsection



{{-- ============================================================ --}}
{{-- Styles --}}
{{-- ============================================================ --}}

@push('styles')

{{-- Flatpickr --}}
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
>


<style>

    .holiday-color {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 3px;
        margin-right: 6px;
        vertical-align: middle;
    }


    .holiday-type1 {
        background-color: #dc3545;
    }


    .holiday-type2 {
        background-color: #ffc107;
    }


    .holiday-type3 {
        background-color: #28a745;
    }


    .holiday-type-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 8px;
        border-radius: 4px;
        font-size: 13px;
    }


    .calendar-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        background: #f1f3f5;
        border: 1px solid #dee2e6;
        font-size: 13px;
    }


    /*
     * Flatpickr ให้อยู่เหนือ Bootstrap Modal
     */
    .flatpickr-calendar {
        z-index: 99999 !important;
    }


    #holiday-list td {
        vertical-align: middle;
    }

</style>

@endpush



{{-- ============================================================ --}}
{{-- Scripts --}}
{{-- ============================================================ --}}

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const modal =
            $('#holidayModal');


        const list =
            document.getElementById(
                'holiday-list'
            );


        const tableWrapper =
            document.getElementById(
                'holiday-table-wrapper'
            );


        const loading =
            document.getElementById(
                'holiday-loading'
            );


        const empty =
            document.getElementById(
                'holiday-empty'
            );


        const listError =
            document.getElementById(
                'holiday-list-error'
            );


        const formError =
            document.getElementById(
                'holiday-form-error'
            );


        const idInput =
            document.getElementById(
                'holiday-id'
            );


        const dateInput =
            document.getElementById(
                'holiday-date'
            );


        const calendarTypeInput =
            document.getElementById(
                'calendar-type'
            );


        const titleInput =
            document.getElementById(
                'holiday-title'
            );


        const saveButton =
            document.getElementById(
                'save-holiday'
            );


        const modalTitle =
            document.getElementById(
                'holiday-modal-title'
            );


        /*
        |--------------------------------------------------------------------------
        | CSRF
        |--------------------------------------------------------------------------
        */

        const csrfToken =
            document
                .querySelector(
                    'meta[name="csrf-token"]'
                )
                ?.getAttribute(
                    'content'
                );


        /*
        |--------------------------------------------------------------------------
        | Local Holiday Data
        |--------------------------------------------------------------------------
        */

        let holidayData = [];


        /*
        |--------------------------------------------------------------------------
        | Date Picker
        |--------------------------------------------------------------------------
        */

        const datePicker =
            flatpickr(
                dateInput,
                {

                    dateFormat:
                        'Y-m-d',

                    allowInput:
                        false,

                    disableMobile:
                        true,

                }
            );


        /*
         * ปุ่ม 📅
         */
        document
            .getElementById(
                'open-calendar'
            )
            .addEventListener(
                'click',
                function () {

                    datePicker.open();

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Load Holiday List
        |--------------------------------------------------------------------------
        */

        async function loadHolidays()
        {

            loading.classList.remove(
                'd-none'
            );

            tableWrapper.classList.add(
                'd-none'
            );

            empty.classList.add(
                'd-none'
            );

            listError.classList.add(
                'd-none'
            );


            try {

                const response =
                    await fetch(
                        '/api/v1/holidays',
                        {

                            method:
                                'GET',

                            headers: {

                                'Accept':
                                    'application/json'

                            }

                        }
                    );


                if (!response.ok) {

                    throw new Error(
                        'Failed to load holidays.'
                    );

                }


                const result =
                    await response.json();


                holidayData =
                    result.data ?? [];


                renderHolidayList();

            } catch (error) {

                console.error(
                    error
                );


                listError.textContent =
                    error.message;


                listError.classList.remove(
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
        | Render List
        |--------------------------------------------------------------------------
        */

        function renderHolidayList()
        {

            list.innerHTML =
                '';


            /*
             * ไม่มีข้อมูล
             */
            if (
                holidayData.length === 0
            ) {

                empty.classList.remove(
                    'd-none'
                );

                tableWrapper.classList.add(
                    'd-none'
                );

                return;

            }


            /*
             * Sort วันที่
             */
            holidayData.sort(
                function (a, b) {

                    return a.date.localeCompare(
                        b.date
                    );

                }
            );


            holidayData.forEach(
                function (holiday) {

                    const row =
                        document.createElement(
                            'tr'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Date
                    |--------------------------------------------------------------------------
                    */

                    const dateCell =
                        document.createElement(
                            'td'
                        );


                    dateCell.textContent =
                        holiday.date;


                    /*
                    |--------------------------------------------------------------------------
                    | Holiday Type
                    |--------------------------------------------------------------------------
                    */

                    const typeCell =
                        document.createElement(
                            'td'
                        );


                    const color =
                        document.createElement(
                            'span'
                        );


                    color.className =
                        'holiday-color holiday-'
                        + holiday.type;


                    typeCell.appendChild(
                        color
                    );


                    typeCell.appendChild(
                        document.createTextNode(
                            getHolidayTypeName(
                                holiday.type
                            )
                        )
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Calendar Type
                    |--------------------------------------------------------------------------
                    */

                    const calendarCell =
                        document.createElement(
                            'td'
                        );


                    const calendarBadge =
                        document.createElement(
                            'span'
                        );


                    calendarBadge.className =
                        'calendar-badge';


                    calendarBadge.textContent =
                        getCalendarTypeName(
                            holiday.calendar_type
                        );


                    calendarCell.appendChild(
                        calendarBadge
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Title
                    |--------------------------------------------------------------------------
                    */

                    const titleCell =
                        document.createElement(
                            'td'
                        );


                    titleCell.textContent =
                        holiday.title || '-';


                    /*
                    |--------------------------------------------------------------------------
                    | Actions
                    |--------------------------------------------------------------------------
                    */

                    const actionCell =
                        document.createElement(
                            'td'
                        );


                    const editButton =
                        document.createElement(
                            'button'
                        );


                    editButton.type =
                        'button';


                    editButton.className =
                        'btn btn-sm btn-warning mr-1';


                    editButton.textContent =
                        'Edit';


                    editButton.addEventListener(
                        'click',
                        function () {

                            openEditModal(
                                holiday.id
                            );

                        }
                    );


                    const deleteButton =
                        document.createElement(
                            'button'
                        );


                    deleteButton.type =
                        'button';


                    deleteButton.className =
                        'btn btn-sm btn-danger';


                    deleteButton.textContent =
                        'Delete';


                    deleteButton.addEventListener(
                        'click',
                        function () {

                            deleteHoliday(
                                holiday.id
                            );

                        }
                    );


                    actionCell.appendChild(
                        editButton
                    );


                    actionCell.appendChild(
                        deleteButton
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Add Cells
                    |--------------------------------------------------------------------------
                    */

                    row.appendChild(
                        dateCell
                    );

                    row.appendChild(
                        typeCell
                    );

                    row.appendChild(
                        calendarCell
                    );

                    row.appendChild(
                        titleCell
                    );

                    row.appendChild(
                        actionCell
                    );


                    list.appendChild(
                        row
                    );

                }
            );


            tableWrapper.classList.remove(
                'd-none'
            );


            empty.classList.add(
                'd-none'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Holiday Type Label
        |--------------------------------------------------------------------------
        */

        function getHolidayTypeName(
            type
        ) {

            switch (type) {

                case 'type1':

                    return '① 営業 + 生産休業日';


                case 'type2':

                    return '② 営業休業日（生産はあり）';


                case 'type3':

                    return '③ 生産休業日（営業はあり）';


                default:

                    return type;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Calendar Type Label
        |--------------------------------------------------------------------------
        */

        function getCalendarTypeName(
            type
        ) {

            switch (type) {

                case 'normal':

                    return 'Normal';


                case 'cloth':

                    return 'Cloth';


                case 'both':

                    return 'Normal + Cloth';


                default:

                    return type;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Add Button
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'btn-add-holiday'
            )
            .addEventListener(
                'click',
                function () {

                    openCreateModal();

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Refresh
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'btn-refresh'
            )
            .addEventListener(
                'click',
                function () {

                    loadHolidays();

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Open Create
        |--------------------------------------------------------------------------
        */

        function openCreateModal()
        {

            resetForm();


            modalTitle.textContent =
                'Add Holiday';


            /*
             * Default = both
             */
            calendarTypeInput.value =
                'both';


            modal.modal(
                'show'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Open Edit
        |--------------------------------------------------------------------------
        */

        function openEditModal(
            id
        ) {

            resetForm();


            const holiday =
                holidayData.find(
                    item =>
                        String(item.id)
                        === String(id)
                );


            if (!holiday) {

                alert(
                    'Holiday not found.'
                );

                return;

            }


            modalTitle.textContent =
                'Edit Holiday';


            idInput.value =
                holiday.id;


            datePicker.setDate(
                holiday.date,
                true
            );


            calendarTypeInput.value =
                holiday.calendar_type;


            titleInput.value =
                holiday.title ?? '';


            const radio =
                document.querySelector(
                    'input[name="holiday_type"]'
                    + '[value="'
                    + holiday.type
                    + '"]'
                );


            if (radio) {

                radio.checked =
                    true;

            }


            modal.modal(
                'show'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Reset Form
        |--------------------------------------------------------------------------
        */

        function resetForm()
        {

            idInput.value =
                '';


            datePicker.clear();


            titleInput.value =
                '';


            calendarTypeInput.value =
                'both';


            document
                .querySelectorAll(
                    'input[name="holiday_type"]'
                )
                .forEach(
                    function (radio) {

                        radio.checked =
                            false;

                    }
                );


            clearFormError();

        }


        /*
        |--------------------------------------------------------------------------
        | Selected Holiday Type
        |--------------------------------------------------------------------------
        */

        function getSelectedHolidayType()
        {

            const selected =
                document.querySelector(
                    'input[name="holiday_type"]:checked'
                );


            return selected
                ? selected.value
                : null;

        }


        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        saveButton.addEventListener(
            'click',
            async function () {

                clearFormError();


                const id =
                    idInput.value;


                const date =
                    dateInput.value;


                const holidayType =
                    getSelectedHolidayType();


                /*
                 * Validation
                 */
                if (!date) {

                    showFormError(
                        'Please select a date.'
                    );

                    return;

                }


                if (!holidayType) {

                    showFormError(
                        'Please select Holiday Type.'
                    );

                    return;

                }


                const payload = {

                    holiday_date:
                        date,

                    holiday_type:
                        holidayType,

                    calendar_type:
                        calendarTypeInput.value,

                    title:
                        titleInput.value.trim()
                        || null

                };


                const url =
                    id
                    ? '/api/v1/holidays/' + id
                    : '/api/v1/holidays';


                const method =
                    id
                    ? 'PUT'
                    : 'POST';


                try {

                    saveButton.disabled =
                        true;


                    saveButton.textContent =
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
                                        csrfToken

                                },

                                body:
                                    JSON.stringify(
                                        payload
                                    )

                            }
                        );


                    const result =
                        await response.json();


                    if (!response.ok) {

                        throw result;

                    }


                    /*
                     * Close
                     */
                    modal.modal(
                        'hide'
                    );


                    /*
                     * Reload List
                     */
                    await loadHolidays();


                } catch (error) {

                    console.error(
                        error
                    );


                    showApiError(
                        error
                    );

                } finally {

                    saveButton.disabled =
                        false;


                    saveButton.textContent =
                        'Save';

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        async function deleteHoliday(
            id
        ) {

            if (
                !confirm(
                    'Delete this holiday?'
                )
            ) {

                return;

            }


            try {

                const response =
                    await fetch(
                        '/api/v1/holidays/' + id,
                        {

                            method:
                                'DELETE',

                            credentials:
                                'same-origin',

                            headers: {

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken

                            }

                        }
                    );


                const result =
                    await response.json();


                if (!response.ok) {

                    throw result;

                }


                await loadHolidays();


            } catch (error) {

                console.error(
                    error
                );


                alert(
                    error.message
                    || 'Delete failed.'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Errors
        |--------------------------------------------------------------------------
        */

        function clearFormError()
        {

            formError.innerHTML =
                '';


            formError.classList.add(
                'd-none'
            );

        }


        function showFormError(
            message
        ) {

            formError.textContent =
                message;


            formError.classList.remove(
                'd-none'
            );

        }


        function showApiError(
            error
        ) {

            if (error.errors) {

                const messages =
                    Object.values(
                        error.errors
                    ).flat();


                formError.innerHTML =
                    messages.join(
                        '<br>'
                    );

            } else {

                formError.textContent =
                    error.message
                    || 'An error occurred.';

            }


            formError.classList.remove(
                'd-none'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Initial Load
        |--------------------------------------------------------------------------
        */

        loadHolidays();

    }
);

</script>

@endpush