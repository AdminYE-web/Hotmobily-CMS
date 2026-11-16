(() => {
    const states = new Map();
    const clone = value => JSON.parse(JSON.stringify(value));
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[c]));
    const uid = () => 'attachment_' + [...crypto.getRandomValues(new Uint8Array(12))].map(x=>x.toString(16).padStart(2,'0')).join('');
    let uploadImage = null;
    let presetCsrf = '';
    let presets = [], presetLoad = null;
    const presetApi = '/api/v1/admin/attachment-gallery-presets';
    async function presetRequest(url, method = 'GET', body) {
        const response = await fetch(url, {method, credentials:'same-origin', headers:{Accept:'application/json', 'X-CSRF-TOKEN':presetCsrf, ...(body ? {'Content-Type':'application/json'} : {})}, ...(body ? {body:JSON.stringify(body)} : {})});
        const result = await response.json();
        if (!response.ok) throw Error(Object.values(result.errors || {}).flat().join(' ') || result.message || 'Preset request failed.');
        return result.data;
    }
    function updatePresetSelectors() {
        document.querySelectorAll('[data-ag-editor]').forEach(root => {
            const state = states.get(root.dataset.blockId), select = root.querySelector('[data-ag-preset-select]');
            if (!state || !select) return;
            if (!presets.some(p => String(p.id) === state.presetId)) state.presetId = '';
            select.innerHTML = '<option value="">Choose a saved preset…</option>' + presets.map(p => `<option value="${p.id}">${esc(p.name)}</option>`).join('');
            select.value = state.presetId || '';
        });
    }
    function loadPresets(force = false) {
        if (!presetLoad || force) presetLoad = presetRequest(presetApi).then(data => {presets = data; updatePresetSelectors();}).catch(reason => {presetLoad = null; throw reason;});
        return presetLoad;
    }
    const textFields = {title:'Section title (optional)', more_label:'Show more label', less_label:'Show less label', zoom_label:'Zoom link text'};
    const itemFields = {title:'Attachment name', alt:'Image Alt Text', price:'Price text (blank = +0円)', image_url:'Card image URL', zoom_url:'Large image URL (optional)'};
    function pull(root) {
        const state = states.get(root.dataset.blockId);
        state.presetName = root.querySelector('[data-ag-preset-name]')?.value || '';
        state.presetId = root.querySelector('[data-ag-preset-select]')?.value || '';
        root.querySelectorAll('[data-ag-meta]').forEach(input => state.data[input.dataset.agMeta] = input.type === 'checkbox' ? input.checked : input.value);
        state.data.items = [...root.querySelectorAll('[data-ag-item-id]')].map(row => {
            const item = {id:row.dataset.agItemId};
            row.querySelectorAll('[data-ag-field]').forEach(input => item[input.dataset.agField] = input.value);
            return item;
        });
        return state.data;
    }
    function itemHtml(item, index, total, blockId) {
        const inputId = blockId+'-'+item.id;
        return `<div class="ag-editor-item" data-ag-item-id="${esc(item.id)}">
            <div class="ag-editor-toolbar">
                <button type="button" class="btn btn-sm btn-outline-secondary ag-item-handle" aria-label="Drag to reorder attachment" title="Drag to reorder">☰</button>
                <strong>Attachment ${index+1}</strong>
                <button type="button" class="btn btn-sm btn-light" data-ag-action="up" ${index===0?'disabled':''} aria-label="Move attachment up">↑</button>
                <button type="button" class="btn btn-sm btn-light" data-ag-action="down" ${index===total-1?'disabled':''} aria-label="Move attachment down">↓</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-ag-action="duplicate">Duplicate</button>
                <button type="button" class="btn btn-sm btn-outline-danger" data-ag-action="remove">Remove</button>
            </div>
            <div class="row"><div class="col-md-3">
                <img class="ag-editor-preview" ${item.image_url ? `src="${esc(item.image_url)}"` : 'hidden'} alt="${esc(item.alt || item.title)}">
                <div class="ag-editor-toolbar">
                    <label class="btn btn-sm btn-outline-primary mb-0">Upload card image<input type="file" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" data-ag-upload="image_url" hidden></label>
                    <label class="btn btn-sm btn-outline-secondary mb-0">Upload large image<input type="file" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" data-ag-upload="zoom_url" hidden></label>
                    <small data-ag-upload-status role="status"></small>
                </div>
            </div><div class="col-md-9"><div class="row">
                ${Object.entries(itemFields).map(([key,label])=>`<div class="col-md-6 form-group"><label for="${esc(inputId)}-${key}">${label}</label><input id="${esc(inputId)}-${key}" class="form-control form-control-sm" data-ag-field="${key}" value="${esc(item[key])}" maxlength="${key.endsWith('_url')?2048:key==='alt'?500:key==='price'?100:255}"></div>`).join('')}
                <div class="col-12 form-group mb-0"><label for="${esc(inputId)}-description">Modal details</label><textarea id="${esc(inputId)}-description" class="form-control form-control-sm" data-ag-field="description" rows="3" maxlength="5000">${esc(item.description)}</textarea></div>
            </div></div></div>
        </div>`;
    }
    function contents(id) {
        const data = states.get(id).data;
        const select = (key,label,values) => `<div class="col-md-4 form-group"><label>${label}</label><select class="form-control" data-ag-meta="${key}">${values.map(v=>`<option value="${v}" ${Number(data[key])===v?'selected':''}>${v}</option>`).join('')}</select></div>`;
        return `<div class="ag-editor-error" role="alert" hidden></div>
            <div class="border rounded p-3 mb-3 ag-preset-panel">
                <strong>Reusable presets</strong>
                <div class="ag-editor-toolbar"><input class="form-control" style="flex:1;min-width:180px" data-ag-preset-name maxlength="150" aria-label="Preset name" placeholder="Preset name, e.g. Acrylic attachments" value="${esc(states.get(id).presetName)}">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-ag-preset-action="save">Save as preset</button></div>
                <div class="ag-editor-toolbar"><select class="form-control" style="flex:1;min-width:180px" data-ag-preset-select aria-label="Saved presets"><option value="">Choose a saved preset…</option>${presets.map(p=>`<option value="${p.id}" ${String(p.id)===states.get(id).presetId?'selected':''}>${esc(p.name)}</option>`).join('')}</select>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-ag-preset-action="load">Load preset</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-ag-preset-action="update">Update preset</button>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-ag-preset-action="delete">Delete preset</button></div>
                <small class="text-muted">Presets include images, names, prices, modal details and gallery settings. Loading replaces this gallery. Save and publish the product to apply it. Editing a loaded gallery does not change the preset or other products.</small>
                <div class="small mt-1" data-ag-preset-status role="status" aria-live="polite"></div>
            </div>
            <div class="row">${Object.entries(textFields).map(([key,label])=>`<div class="col-md-6 form-group"><label for="ag-${esc(id)}-${key}">${label}</label><input id="ag-${esc(id)}-${key}" class="form-control" data-ag-meta="${key}" value="${esc(data[key])}" maxlength="${key.endsWith('_label')&&key!=='zoom_label'?100:255}"></div>`).join('')}</div>
            <div class="form-group ag-editor-description"><label for="ag-${esc(id)}-description">Description</label><textarea id="ag-${esc(id)}-description" class="form-control" data-ag-meta="description" rows="5" maxlength="50000">${esc(data.description)}</textarea></div>
            <div class="row">${select('columns','Images per row (desktop)',[2,3,4])}${select('mobile_columns','Images per row (mobile)',[1,2])}
                <div class="col-md-4 form-group"><label>Collapsed height (px)</label><input type="number" class="form-control" min="100" max="2000" step="1" data-ag-meta="collapsed_height" value="${esc(data.collapsed_height)}"></div>
            </div>
            <label class="d-block"><input type="checkbox" data-ag-meta="collapsible" ${data.collapsible?'checked':''}> Collapse long galleries with a Show more button</label>
            <p class="small text-muted">Drag ☰ to reorder, or use the arrow buttons. Names and details appear in the image modal. Prices here are display text.</p>
            <div class="ag-editor-list">${data.items.map((item,index)=>itemHtml(item,index,data.items.length,id)).join('')}</div>
            <button type="button" class="btn btn-sm btn-outline-primary" data-ag-action="add">+ Add attachment</button>`;
    }
    function error(root, message) {
        const box = root.querySelector('.ag-editor-error');
        box.textContent = message;
        box.hidden = false;
    }
    function mount(root) {
        const id = root.dataset.blockId, state = states.get(id);
        const textarea = root.querySelector('[data-ag-meta="description"]');
        if (window.ClassicEditor && !state.editorPending && !state.editor) {
            state.editorPending = true;
            ClassicEditor.create(textarea, {
                toolbar:['heading','|','bold','italic','link','|','bulletedList','numberedList','blockQuote','|','undo','redo'],
                link:{defaultProtocol:'https://',addTargetToExternalLinks:true},
            }).then(editor => {
                if (states.get(id)!==state || !textarea.isConnected) { editor.destroy(); return; }
                state.editor = editor;
                editor.setData(textarea.value);
                editor.model.document.on('change:data',()=>{
                    textarea.value = editor.getData();
                    textarea.dispatchEvent(new Event('input',{bubbles:true}));
                });
                textarea.value = editor.getData();
            }).catch(reason=>{state.editorPending=false;error(root,'Could not load Description editor: '+reason.message);});
        }
        if (window.Sortable) state.sortable = new Sortable(root.querySelector('.ag-editor-list'), {
            handle:'.ag-item-handle', draggable:'.ag-editor-item', animation:150,
            forceFallback:true, fallbackOnBody:true, scroll:true, bubbleScroll:true, scrollSensitivity:80, scrollSpeed:14,
            onEnd:()=>{pull(root);refresh(root);root.dispatchEvent(new Event('change',{bubbles:true}));},
        });
    }
    function refresh(root) {
        const state = states.get(root.dataset.blockId);
        const intro = root.querySelector('.ag-editor-description');
        state.sortable?.destroy();
        intro?.remove();
        root.innerHTML = contents(root.dataset.blockId);
        if (intro) {
            root.querySelector('.ag-editor-description').replaceWith(intro);
            intro.querySelector('textarea').value = state.data.description;
            if (state.editor && state.editor.getData() !== state.data.description) state.editor.setData(state.data.description);
        }
        mount(root);
    }
    function bind(upload, csrf) {
        presetCsrf = csrf || presetCsrf;
        if (upload) uploadImage = upload;
        document.querySelectorAll('[data-ag-editor]').forEach(root=>{
            if (root.dataset.agBound) return;
            root.dataset.agBound='1';
            mount(root);
            loadPresets().catch(reason => error(root, 'Could not load gallery presets: ' + reason.message));
            root.addEventListener('click', async event => {
                const button = event.target.closest('[data-ag-preset-action]');
                if (!button) return;
                const state = states.get(root.dataset.blockId);
                if (state.presetBusy) return;
                const content = clone(pull(root)), action = button.dataset.agPresetAction;
                const name = state.presetName.trim(), selectedId = state.presetId;
                state.presetBusy = true;
                root.querySelectorAll('[data-ag-preset-action]').forEach(el => el.disabled = true);
                root.querySelector('.ag-editor-error').hidden = true;
                root.querySelector('[data-ag-preset-status]').textContent = 'Working…';
                try {
                    await loadPresets();
                    const selected = presets.find(p => String(p.id) === selectedId);
                    if (action !== 'save' && !selected) throw Error('Choose a saved preset first.');
                    if (action === 'save' || action === 'update') {
                        if (action === 'save' && !name) throw Error('Enter a preset name.');
                        if (!content.items.length) throw Error('Add at least one attachment before saving a preset.');
                        if (action === 'update' && !confirm(`Update preset "${selected.name}"? Existing product galleries will remain unchanged.`)) return;
                        const result = await presetRequest(action === 'save' ? presetApi : presetApi + '/' + selectedId, action === 'save' ? 'POST' : 'PUT', {name:name || selected.name, content});
                        state.presetId = String(result.id); state.presetName = '';
                        root.querySelector('[data-ag-preset-name]').value = '';
                        await loadPresets(true);
                        root.querySelector('[data-ag-preset-status]').textContent = 'Preset saved. It is now available in other products.';
                    } else if (action === 'load') {
                        if (content.items.length && !confirm('Replace this gallery with the selected preset? Unsaved gallery changes will be replaced.')) return;
                        const result = await presetRequest(presetApi + '/' + selectedId);
                        state.data = clone(result.content_json);
                        state.data.items.forEach(item => item.id = uid());
                        state.presetName = ''; refresh(root);
                        root.querySelector('[data-ag-preset-status]').textContent = 'Preset loaded. Save and publish the product to apply it.';
                        root.dispatchEvent(new Event('change', {bubbles:true}));
                    } else if (action === 'delete') {
                        if (!confirm(`Delete preset "${selected.name}"? Existing product galleries and images will remain unchanged.`)) return;
                        await presetRequest(presetApi + '/' + selectedId, 'DELETE');
                        await loadPresets(true);
                        root.querySelector('[data-ag-preset-status]').textContent = 'Preset deleted. Product galleries were not changed.';
                    }
                } catch (reason) { error(root, reason.message); root.querySelector('[data-ag-preset-status]').textContent = 'Preset action failed.'; }
                finally { state.presetBusy = false; root.querySelectorAll('[data-ag-preset-action]').forEach(el => el.disabled = false); if (root.querySelector('[data-ag-preset-status]').textContent === 'Working…') root.querySelector('[data-ag-preset-status]').textContent = ''; }
            });
            root.addEventListener('input',event=>{
                if (event.target.matches('[data-ag-field="image_url"], [data-ag-field="alt"], [data-ag-field="title"]')) {
                    const row=event.target.closest('[data-ag-item-id]'), img=row.querySelector('.ag-editor-preview');
                    const url=row.querySelector('[data-ag-field="image_url"]').value;
                    img.hidden=!url;
                    if (url && img.getAttribute('src')!==url) img.src=url;
                    img.alt=row.querySelector('[data-ag-field="alt"]').value||row.querySelector('[data-ag-field="title"]').value;
                }
            });
            root.addEventListener('change',async event=>{
                const input=event.target;
                if (!input.matches('[data-ag-upload]') || !input.files.length) return;
                const row=input.closest('[data-ag-item-id]'), id=row.dataset.agItemId, field=input.dataset.agUpload;
                const status=row.querySelector('[data-ag-upload-status]');
                input.disabled=true;
                status.textContent='Uploading…';
                try {
                    if (!uploadImage) throw new Error('Image upload is unavailable.');
                    const url=await uploadImage(input.files[0]);
                    // Locate by ID again: the item may have moved while uploading.
                    const current=[...root.querySelectorAll('[data-ag-item-id]')].find(el=>el.dataset.agItemId===id);
                    if (current) {
                        const target=current.querySelector(`[data-ag-field="${field}"]`);
                        target.value=url;
                        target.dispatchEvent(new Event('input',{bubbles:true}));
                        current.querySelector('[data-ag-upload-status]').textContent='Uploaded';
                        pull(root);
                    }
                } catch(reason) {error(root,reason.message);status.textContent='Upload failed';}
                finally {input.disabled=false;input.value='';}
            });
            root.addEventListener('click',event=>{
                const button=event.target.closest('[data-ag-action]');
                if (!button||button.disabled) return;
                if (states.get(root.dataset.blockId).presetBusy) return;
                const data=pull(root), action=button.dataset.agAction;
                const itemId=button.closest('[data-ag-item-id]')?.dataset.agItemId;
                const index=data.items.findIndex(item=>item.id===itemId);
                if (action==='add'||action==='duplicate') {
                    if (data.items.length>=100) {error(root,'Maximum 100 attachments per gallery.');return;}
                    const item=action==='duplicate'?{...clone(data.items[index]),id:uid()}:{id:uid(),title:'',alt:'',price:'',image_url:'',zoom_url:'',description:''};
                    if (action==='duplicate') data.items.splice(index+1,0,item);
                    else data.items.push(item);
                } else if (action==='remove') data.items.splice(index,1);
                else if (action==='up'||action==='down') {
                    const next=index+(action==='up'?-1:1);
                    if (next<0||next>=data.items.length) return;
                    [data.items[index],data.items[next]]=[data.items[next],data.items[index]];
                }
                refresh(root);
                root.dispatchEvent(new Event('change',{bubbles:true}));
            });
        });
    }
    window.AttachmentGalleryEditor={
        render(id,content,defaults) {
            const old=states.get(id);
            old?.sortable?.destroy();
            old?.editor?.destroy();
            states.set(id,{data:{...clone(defaults),...clone(content)},presetName:'',presetId:''});
            return `<div class="ag-editor" data-ag-editor data-block-id="${esc(id)}">${contents(id)}</div>`;
        },
        bind,
        collect:root=>clone(pull(root)),
    };
})();
