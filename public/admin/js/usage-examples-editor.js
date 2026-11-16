(() => {
    const states = new Map();
    const clone = value => JSON.parse(JSON.stringify(value));
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[c]));
    const uid = () => 'usage_' + [...crypto.getRandomValues(new Uint8Array(12))].map(x=>x.toString(16).padStart(2,'0')).join('');
    let uploadImage = null;
    const textFields = {title:'Section title (optional)', zoom_label:'Zoom link text'};
    const itemFields = {title:'Example name', alt:'Image Alt Text', date:'Date (optional)', image_url:'Card image URL', zoom_url:'Large image URL (optional)'};
    function pull(root) {
        const state = states.get(root.dataset.blockId);
        root.querySelectorAll('[data-ue-meta]').forEach(input => state.data[input.dataset.ueMeta] = input.type === 'checkbox' ? input.checked : input.value);
        state.data.items = [...root.querySelectorAll('[data-ue-item-id]')].map(row => {
            const item = {id:row.dataset.ueItemId};
            row.querySelectorAll('[data-ue-field]').forEach(input => item[input.dataset.ueField] = input.value);
            return item;
        });
        return state.data;
    }
    function itemHtml(item, index, total, blockId) {
        const inputId = blockId+'-'+item.id;
        return `<div class="ue-editor-item" data-ue-item-id="${esc(item.id)}">
            <div class="ue-editor-toolbar">
                <button type="button" class="btn btn-sm btn-outline-secondary ue-item-handle" aria-label="Drag to reorder example" title="Drag to reorder">☰</button>
                <strong>Example ${index+1}</strong>
                <button type="button" class="btn btn-sm btn-light" data-ue-action="up" ${index===0?'disabled':''} aria-label="Move example up">↑</button>
                <button type="button" class="btn btn-sm btn-light" data-ue-action="down" ${index===total-1?'disabled':''} aria-label="Move example down">↓</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-ue-action="duplicate">Duplicate</button>
                <button type="button" class="btn btn-sm btn-outline-danger" data-ue-action="remove">Remove</button>
            </div>
            <div class="row"><div class="col-md-3">
                <img class="ue-editor-preview" ${item.image_url ? `src="${esc(item.image_url)}"` : 'hidden'} alt="${esc(item.alt || item.title)}">
                <div class="ue-editor-toolbar">
                    <label class="btn btn-sm btn-outline-primary mb-0">Upload card image<input type="file" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" data-ue-upload="image_url" hidden></label>
                    <label class="btn btn-sm btn-outline-secondary mb-0">Upload large image<input type="file" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" data-ue-upload="zoom_url" hidden></label>
                    <small data-ue-upload-status role="status"></small>
                </div>
            </div><div class="col-md-9"><div class="row">
                ${Object.entries(itemFields).map(([key,label])=>`<div class="col-md-6 form-group"><label for="${esc(inputId)}-${key}">${label}</label><input id="${esc(inputId)}-${key}" type="${key==='date'?'date':'text'}" class="form-control form-control-sm" data-ue-field="${key}" value="${esc(item[key])}" maxlength="${key.endsWith('_url')?2048:key==='alt'?500:key==='price'?100:255}"></div>`).join('')}
                <div class="col-12 form-group mb-0"><label for="${esc(inputId)}-description">Description</label><textarea id="${esc(inputId)}-description" class="form-control form-control-sm" data-ue-field="description" rows="3" maxlength="50000">${esc(item.description)}</textarea></div>
            </div></div></div>
        </div>`;
    }
    function contents(id) {
        const data = states.get(id).data;
        const select = (key,label,values) => `<div class="col-md-4 form-group"><label>${label}</label><select class="form-control" data-ue-meta="${key}">${values.map(v=>`<option value="${v}" ${Number(data[key])===v?'selected':''}>${v}</option>`).join('')}</select></div>`;
        return `<div class="ue-editor-error" role="alert" hidden></div>
            <div class="row">${Object.entries(textFields).map(([key,label])=>`<div class="col-md-6 form-group"><label for="ue-${esc(id)}-${key}">${label}</label><input id="ue-${esc(id)}-${key}" class="form-control" data-ue-meta="${key}" value="${esc(data[key])}" maxlength="${key.endsWith('_label')&&key!=='zoom_label'?100:255}"></div>`).join('')}</div>
            <div class="form-group ue-editor-description"><label for="ue-${esc(id)}-description">Description</label><textarea id="ue-${esc(id)}-description" class="form-control" data-ue-meta="description" rows="5" maxlength="50000">${esc(data.description)}</textarea></div>
            <div class="row">${select('columns','Images per row (desktop)',[1,2,3,4])}${select('mobile_columns','Images per row (mobile)',[1,2])}
            </div>
            <p class="small text-muted">Drag ☰ to reorder, or use the arrow buttons. Dates, titles and descriptions appear below each image.</p>
            <div class="ue-editor-list">${data.items.map((item,index)=>itemHtml(item,index,data.items.length,id)).join('')}</div>
            <button type="button" class="btn btn-sm btn-outline-primary" data-ue-action="add">+ Add example</button>`;
    }
    function error(root, message) {
        const box = root.querySelector('.ue-editor-error');
        box.textContent = message;
        box.hidden = false;
    }
    function mount(root) {
        const id = root.dataset.blockId, state = states.get(id);
        state.editors ??= new Map();
        root.querySelectorAll('textarea').forEach(textarea => {
            if (!window.ClassicEditor || state.editors.has(textarea)) return;
            state.editors.set(textarea, null);
            ClassicEditor.create(textarea, {
                toolbar:['heading','|','bold','italic','link','|','bulletedList','numberedList','blockQuote','|','undo','redo'],
                link:{defaultProtocol:'https://',addTargetToExternalLinks:true},
            }).then(editor => {
                if (states.get(id)!==state || !state.editors.has(textarea) || !textarea.isConnected) { editor.destroy(); return; }
                state.editors.set(textarea,editor);
                editor.model.document.on('change:data',()=>{
                    textarea.value=editor.getData();
                    textarea.dispatchEvent(new Event('input',{bubbles:true}));
                });
                textarea.value=editor.getData();
            }).catch(reason=>{state.editors.delete(textarea);error(root,'Could not load Description editor: '+reason.message);});
        });
        if (window.Sortable) state.sortable = new Sortable(root.querySelector('.ue-editor-list'), {
            handle:'.ue-item-handle', draggable:'.ue-editor-item', animation:150,
            forceFallback:true, fallbackOnBody:true, scroll:true, bubbleScroll:true, scrollSensitivity:80, scrollSpeed:14,
            onEnd:()=>{pull(root);refresh(root);root.dispatchEvent(new Event('change',{bubbles:true}));},
        });
    }
    function refresh(root) {
        const state = states.get(root.dataset.blockId);
        const intro=root.querySelector('.ue-editor-description');
        const rows=new Map([...root.querySelectorAll('[data-ue-item-id]')].map(row=>[row.dataset.ueItemId,row]));
        state.sortable?.destroy();
        intro?.remove();
        rows.forEach(row=>row.remove());
        root.innerHTML=contents(root.dataset.blockId);
        if(intro) root.querySelector('.ue-editor-description').replaceWith(intro);
        root.querySelectorAll('[data-ue-item-id]').forEach(row=>{
            const existing=rows.get(row.dataset.ueItemId);
            if(!existing) return;
            existing.querySelector('.ue-editor-toolbar').replaceWith(row.querySelector('.ue-editor-toolbar'));
            row.replaceWith(existing);
        });
        state.editors?.forEach((editor,textarea)=>{
            if(!root.contains(textarea)) { editor?.destroy();state.editors.delete(textarea); }
        });
        mount(root);
    }
    function bind(upload) {
        if (upload) uploadImage = upload;
        document.querySelectorAll('[data-ue-editor]').forEach(root=>{
            if (root.dataset.ueBound) return;
            root.dataset.ueBound='1';
            mount(root);
            root.addEventListener('input',event=>{
                if (event.target.matches('[data-ue-field="image_url"], [data-ue-field="alt"], [data-ue-field="title"]')) {
                    const row=event.target.closest('[data-ue-item-id]'), img=row.querySelector('.ue-editor-preview');
                    const url=row.querySelector('[data-ue-field="image_url"]').value;
                    img.hidden=!url;
                    if (url && img.getAttribute('src')!==url) img.src=url;
                    img.alt=row.querySelector('[data-ue-field="alt"]').value||row.querySelector('[data-ue-field="title"]').value;
                }
            });
            root.addEventListener('change',async event=>{
                const input=event.target;
                if (!input.matches('[data-ue-upload]') || !input.files.length) return;
                const row=input.closest('[data-ue-item-id]'), id=row.dataset.ueItemId, field=input.dataset.ueUpload;
                const status=row.querySelector('[data-ue-upload-status]');
                input.disabled=true;
                status.textContent='Uploading…';
                try {
                    if (!uploadImage) throw new Error('Image upload is unavailable.');
                    const url=await uploadImage(input.files[0]);
                    // Locate by ID again: the item may have moved while uploading.
                    const current=[...root.querySelectorAll('[data-ue-item-id]')].find(el=>el.dataset.ueItemId===id);
                    if (current) {
                        const target=current.querySelector(`[data-ue-field="${field}"]`);
                        target.value=url;
                        target.dispatchEvent(new Event('input',{bubbles:true}));
                        current.querySelector('[data-ue-upload-status]').textContent='Uploaded';
                        pull(root);
                    }
                } catch(reason) {error(root,reason.message);status.textContent='Upload failed';}
                finally {input.disabled=false;input.value='';}
            });
            root.addEventListener('click',event=>{
                const button=event.target.closest('[data-ue-action]');
                if (!button||button.disabled) return;
                const data=pull(root), action=button.dataset.ueAction;
                const itemId=button.closest('[data-ue-item-id]')?.dataset.ueItemId;
                const index=data.items.findIndex(item=>item.id===itemId);
                if (action==='add'||action==='duplicate') {
                    if (data.items.length>=100) {error(root,'Maximum 100 examples per gallery.');return;}
                    const item=action==='duplicate'?{...clone(data.items[index]),id:uid()}:{id:uid(),title:'',alt:'',date:'',image_url:'',zoom_url:'',description:''};
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
    window.UsageExamplesEditor={
        render(id,content,defaults) {
            const old=states.get(id);
            old?.sortable?.destroy();
            old?.editors?.forEach(editor=>editor?.destroy());
            states.set(id,{data:{...clone(defaults),...clone(content)}});
            return `<div class="ue-editor" data-ue-editor data-block-id="${esc(id)}">${contents(id)}</div>`;
        },
        bind,
        collect:root=>clone(pull(root)),
    };
})();
