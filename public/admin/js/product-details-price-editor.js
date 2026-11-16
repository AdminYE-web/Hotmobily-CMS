(function () {
    'use strict';
    const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'}[char]));
    const defaults = () => [
        {quantity: '1個', price: '990', suffix: '円～'},
        {quantity: '50個', price: '255', suffix: '円～'},
        {quantity: '300個', price: '188', suffix: '円～'},
    ];
    const shippingEditors = new Map();
    function bindShippingNotes() {
        document.querySelectorAll('[data-shipping-note-editor]').forEach(textarea => {
            const id = textarea.dataset.blockId;
            const previous = shippingEditors.get(id);
            if (previous?.textarea === textarea || !window.ClassicEditor) return;
            previous?.editor?.destroy();
            const entry = {textarea, editor: null};
            shippingEditors.set(id, entry);
            window.ClassicEditor.create(textarea, {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo'],
                link: {defaultProtocol: 'https://', addTargetToExternalLinks: true},
            }).then(editor => {
                if (shippingEditors.get(id) !== entry || !textarea.isConnected) {
                    editor.destroy();
                    return;
                }
                entry.editor = editor;
                editor.model.document.on('change:data', () => {
                    textarea.value = editor.getData();
                    textarea.dispatchEvent(new Event('input', {bubbles: true}));
                });
                textarea.value = editor.getData();
            }).catch(() => {
                shippingEditors.delete(id);
                const error = textarea.parentElement.querySelector('[data-shipping-note-error]');
                error.hidden = false;
            });
        });
    }
    function row(column) {
        return `<tr data-pdp-row>
            <td><input class="form-control" data-pdp-field="quantity" aria-label="Quantity" maxlength="100" value="${esc(column.quantity)}"></td>
            <td><input class="form-control" data-pdp-field="price" aria-label="Price" maxlength="100" value="${esc(column.price)}"></td>
            <td><input class="form-control" data-pdp-field="suffix" aria-label="Suffix" maxlength="100" value="${esc(column.suffix)}"></td>
            <td style="white-space:nowrap"><button type="button" class="btn btn-sm btn-outline-secondary" data-pdp-action="up" aria-label="Move up">↑</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-pdp-action="down" aria-label="Move down">↓</button>
            <button type="button" class="btn btn-sm btn-outline-danger" data-pdp-action="remove" aria-label="Remove column">×</button></td>
        </tr>`;
    }
    function sync(editor) {
        const enabled = editor.querySelector('[data-pdp-enabled]').checked;
        editor.querySelector('[data-pdp-table]').hidden = !enabled;
        editor.parentElement.querySelector('[data-pdp-legacy]').hidden = enabled;
        const rows = [...editor.querySelectorAll('[data-pdp-row]')];
        rows.forEach((item, index) => {
            item.querySelector('[data-pdp-action="up"]').disabled = index === 0;
            item.querySelector('[data-pdp-action="down"]').disabled = index === rows.length - 1;
        });
        editor.querySelector('[data-pdp-action="add"]').disabled = rows.length >= 12;
    }
    window.ProductDetailsPriceEditor = {
        renderShippingNote(blockId, content) {
            const previous = shippingEditors.get(String(blockId));
            previous?.editor?.destroy();
            shippingEditors.delete(String(blockId));
            const value = content.shipping_note_format === 'html'
                ? (content.shipping_note ?? '')
                : (content.shipping_note ? '<p>' + esc(content.shipping_note).replace(/\r?\n/g, '<br>') + '</p>' : '');
            return `<div class="form-group"><label for="shipping-note-${esc(blockId)}">Shipping Note</label>
                <textarea id="shipping-note-${esc(blockId)}" class="form-control product-field" data-shipping-note-editor data-block-id="${esc(blockId)}" data-field="shipping_note" rows="5">${esc(value)}</textarea>
                <input type="hidden" class="product-field" data-block-id="${esc(blockId)}" data-field="shipping_note_format" value="html">
                <small data-shipping-note-error class="text-danger" role="alert" hidden>Could not load Shipping Note editor. Please reload the page.</small>
            </div>`;
        },
        render(blockId, content) {
            const columns = Array.isArray(content.price_table_columns) && content.price_table_columns.length ? content.price_table_columns : defaults();
            return `<div data-pdp-editor data-block-id="${esc(blockId)}" class="mb-3">
                <label><input type="checkbox" data-pdp-enabled ${content.price_table_enabled ? 'checked' : ''}> Show price table</label>
                <div data-pdp-table ${content.price_table_enabled ? '' : 'hidden'}>
                    <label>Price table title</label><input class="form-control mb-2" data-pdp-title maxlength="255" value="${esc(content.price_table_title ?? '製作単価目安（税込）')}">
                    <div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Quantity</th><th>Price</th><th>Suffix</th><th>Actions</th></tr></thead>
                    <tbody>${columns.map(row).join('')}</tbody></table></div>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-pdp-action="add">+ Add column</button>
                    <small class="d-block text-muted mt-1">Each row becomes one price column. Maximum 12 columns.</small>
                </div>
            </div>`;
        },
        bind() {
            bindShippingNotes();
            document.querySelectorAll('[data-pdp-editor]').forEach(editor => {
                sync(editor);
                if (editor.dataset.bound) return;
                editor.dataset.bound = '1';
                editor.addEventListener('change', () => sync(editor));
                editor.addEventListener('click', event => {
                    const button = event.target.closest('[data-pdp-action]');
                    if (!button) return;
                    const action = button.dataset.pdpAction;
                    const item = button.closest('[data-pdp-row]');
                    if (action === 'add' && editor.querySelectorAll('[data-pdp-row]').length < 12) {
                        editor.querySelector('tbody').insertAdjacentHTML('beforeend', row({quantity: '', price: '', suffix: '円～'}));
                    } else if (action === 'remove') item.remove();
                    else if (action === 'up' && item.previousElementSibling) item.previousElementSibling.before(item);
                    else if (action === 'down' && item.nextElementSibling) item.nextElementSibling.after(item);
                    sync(editor);
                    editor.dispatchEvent(new Event('input', {bubbles: true}));
                });
            });
        },
        collect(editor) {
            return {
                price_table_enabled: editor.querySelector('[data-pdp-enabled]').checked,
                price_table_title: editor.querySelector('[data-pdp-title]').value,
                price_table_columns: [...editor.querySelectorAll('[data-pdp-row]')].map(item => Object.fromEntries(
                    [...item.querySelectorAll('[data-pdp-field]')].map(input => [input.dataset.pdpField, input.value])
                )),
            };
        },
    };
})();
