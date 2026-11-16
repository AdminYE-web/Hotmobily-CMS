(() => {
    'use strict';
    const states = new Map(), cache = new Map(), api = '/api/v1/admin/gallery-showcase/pages';
    const esc = value => String(value ?? '').replace(/[&<>"']/g, ch => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[ch]));
    const copy = value => JSON.parse(JSON.stringify(value));
    async function get(url) {
        if (!cache.has(url)) cache.set(url, fetch(url, {credentials:'same-origin',headers:{Accept:'application/json'}}).then(async response => {
            if (!response.ok) throw new Error(`Could not load gallery (${response.status}). Please retry.`);
            return (await response.json()).data;
        }).catch(reason => {cache.delete(url);throw reason;}));
        return cache.get(url);
    }
    function pull(root) {
        const state = states.get(root.dataset.blockId);
        root.querySelectorAll('[data-gs-meta]').forEach(field => {
            state.data[field.dataset.gsMeta] = field.type === 'checkbox' ? field.checked : ['columns','mobile_columns'].includes(field.dataset.gsMeta) ? Number(field.value) : field.value;
        });
        state.data.description = state.editor?.getData() ?? root.querySelector('[data-gs-description]').value;
        root.querySelectorAll('[data-gs-title]').forEach(input => {
            const item = state.data.items.find(item => item.key === input.dataset.gsTitle);
            if (item) item.title = input.value;
        });
        return state.data;
    }
    function status(root, message, error = false) {
        const box = root.querySelector('[data-gs-status]');
        box.textContent = message;box.classList.toggle('gs-error', error);
    }
    function selected(root) {
        const state = states.get(root.dataset.blockId);
        state.sortable?.destroy();
        const list = root.querySelector('[data-gs-selected]');
        list.innerHTML = state.data.items.map((item, index) => {
            const source = state.choices.find(choice => choice.key === item.key);
            return `<div class="gs-selected-row" data-gs-key="${esc(item.key)}"><button type="button" class="btn btn-sm btn-light gs-handle" aria-label="Drag image">☰</button>${source ? `<img src="${esc(source.image_url)}" alt="">` : '<span class="text-danger">Image unavailable</span>'}<input class="form-control" data-gs-title="${esc(item.key)}" value="${esc(item.title)}" maxlength="255" placeholder="Title above image" aria-label="Image title ${index+1}"><button type="button" class="btn btn-sm btn-light" data-gs-action="up" ${index===0?'disabled':''} aria-label="Move up">↑</button><button type="button" class="btn btn-sm btn-light" data-gs-action="down" ${index===state.data.items.length-1?'disabled':''} aria-label="Move down">↓</button><button type="button" class="btn btn-sm btn-outline-danger" data-gs-action="remove">Remove</button></div>`;
        }).join('') || '<p class="text-muted">Select images from the Gallery below.</p>';
        root.querySelector('[data-gs-count]').textContent = `${state.data.items.length} / 200 selected`;
        if (window.Sortable) state.sortable = new Sortable(list, {
            handle:'.gs-handle',draggable:'.gs-selected-row',animation:150,forceFallback:true,fallbackOnBody:true,
            scroll:true,bubbleScroll:true,scrollSensitivity:80,scrollSpeed:14,
            onEnd:() => {
                pull(root);
                const byKey = new Map(state.data.items.map(item=>[item.key,item]));
                state.data.items = [...list.querySelectorAll('[data-gs-key]')].map(row=>byKey.get(row.dataset.gsKey));
                selected(root);root.dispatchEvent(new Event('change',{bubbles:true}));
            },
        });
    }
    function choices(root) {
        const state = states.get(root.dataset.blockId), query = root.querySelector('[data-gs-search]').value.toLocaleLowerCase();
        const tag = root.querySelector('[data-gs-filter]').value, picked = new Set(state.data.items.map(item=>item.key));
        state.visible = state.choices.filter(item => (!tag || item.tags.includes(tag)) && (!query || [item.customer,item.comment,item.image_name,...item.tags].join(' ').toLocaleLowerCase().includes(query)));
        root.querySelector('[data-gs-choices]').innerHTML = state.visible.map(item => `<label class="gs-choice"><input type="checkbox" data-gs-choice="${esc(item.key)}" ${picked.has(item.key)?'checked':''}> <span>${esc(item.customer || '#'+item.gallery_id)}</span><img src="${esc(item.image_url)}" alt="" loading="lazy"><span>${esc(item.tags.join(' · '))}</span></label>`).join('') || '<p class="p-2 text-muted">No matching images.</p>';
    }
    async function load(root) {
        const state = states.get(root.dataset.blockId), pageId = String(state.data.gallery_page_id || '');
        const request = ++state.request;
        state.loading = true;
        root.querySelector('[data-gs-choices]').innerHTML = '';
        status(root,'Loading gallery…');
        try {
            const result = pageId ? await get(`${api}/${encodeURIComponent(pageId)}`) : {items:[]};
            if (!root.isConnected || states.get(root.dataset.blockId)!==state || request!==state.request) return;
            pull(root);state.choices=result.items;
            const tags = [...new Set(state.choices.flatMap(item=>item.tags))];
            root.querySelector('[data-gs-filter]').innerHTML = '<option value="">All tags</option>'+tags.map(tag=>`<option>${esc(tag)}</option>`).join('');
            choices(root);selected(root);
            const missing = state.data.items.filter(item=>!state.choices.some(choice=>choice.key===item.key)).length;
            status(root, missing ? `${missing} selected image(s) are unavailable. They will be skipped on the storefront. Remove or replace them here.` : `${state.choices.length} available images.`, !!missing);
        } catch(reason) {
            if (root.isConnected && request===state.request) { state.choices=[];selected(root);status(root,reason.message,true); }
        } finally { if (request===state.request) state.loading=false; }
    }
    function mount(root) {
        if (root.dataset.gsBound) return;
        root.dataset.gsBound='1';
        const state = states.get(root.dataset.blockId), textarea = root.querySelector('[data-gs-description]');
        if (window.ClassicEditor) ClassicEditor.create(textarea, {
            toolbar:['heading','|','bold','italic','link','|','bulletedList','numberedList','|','undo','redo'],
            link:{defaultProtocol:'https://',addTargetToExternalLinks:true},
        }).then(editor=>{
            if (!root.isConnected || states.get(root.dataset.blockId)!==state) {editor.destroy();return;}
            state.editor=editor;
            editor.model.document.on('change:data',()=>{textarea.value=editor.getData();textarea.dispatchEvent(new Event('input',{bubbles:true}));});
        }).catch(reason=>status(root,'Description editor: '+reason.message,true));
        async function pages() { return get(api).then(pages=>{
            if (!root.isConnected) return;
            const select=root.querySelector('[data-gs-page]'), current=String(state.data.gallery_page_id || '');
            select.innerHTML='<option value="">Choose a Gallery…</option>'+pages.map(page=>`<option value="${page.id}">${esc(page.name)} (${esc(page.public_slug)})</option>`).join('');
            if (current && !pages.some(page=>String(page.id)===current)) select.insertAdjacentHTML('beforeend',`<option value="${esc(current)}">Gallery unavailable</option>`);
            select.value=current;
        }).catch(reason=>status(root,reason.message,true)); }
        pages();
        load(root);
        root.addEventListener('input',event=>{if(event.target.matches('[data-gs-search]')) choices(root);});
        root.addEventListener('change',event=>{
            if (event.target.matches('[data-gs-page]')) {
                const select=event.target, previous=String(state.data.gallery_page_id || '');
                if (select.value===previous) return;
                if (state.data.items.length && !confirm('Changing the Gallery clears the selected images. Continue?')) {select.value=previous;return;}
                pull(root);state.data.gallery_page_id=select.value ? Number(select.value) : null;state.data.items=[];state.choices=[];
                selected(root);load(root);
            } else if (event.target.matches('[data-gs-filter]')) choices(root);
            else if (event.target.matches('[data-gs-choice]')) {
                pull(root);const key=event.target.dataset.gsChoice;
                if (event.target.checked && !state.data.items.some(item=>item.key===key)) {
                    if (state.data.items.length>=200) {event.target.checked=false;status(root,'Maximum 200 images.',true);return;}
                    state.data.items.push({key,title:''});
                } else if (!event.target.checked) state.data.items=state.data.items.filter(item=>item.key!==key);
                selected(root);
            }
        });
        root.addEventListener('click',event=>{
            const button=event.target.closest('[data-gs-action]');if(!button) return;
            const action=button.dataset.gsAction;
            if(action==='retry') {cache.delete(api);cache.delete(`${api}/${state.data.gallery_page_id}`);pages();load(root);return;}
            if(state.loading && ['all','clear'].includes(action))return;
            pull(root);
            const row=button.closest('[data-gs-key]'), index=row ? state.data.items.findIndex(item=>item.key===row.dataset.gsKey) : -1;
            if(action==='all') {
                const added=state.visible.filter(choice=>!state.data.items.some(item=>item.key===choice.key));
                if(state.data.items.length+added.length>200){status(root,'Maximum 200 images. Filter or select fewer images.',true);return;}
                state.data.items.push(...added.map(item=>({key:item.key,title:''})));
            } else if(action==='clear') state.data.items=[];
            else if(action==='remove')state.data.items.splice(index,1);
            else if(action==='up'||action==='down') {
                const next=index+(action==='up'?-1:1);if(index<0||next<0||next>=state.data.items.length)return;
                [state.data.items[index],state.data.items[next]]=[state.data.items[next],state.data.items[index]];
            }
            choices(root);selected(root);root.dispatchEvent(new Event('change',{bubbles:true}));
        });
    }
    window.GalleryShowcaseEditor = {
        render(id, content, defaults) {
            const old=states.get(id);old?.editor?.destroy();old?.sortable?.destroy();
            const data={...copy(defaults),...copy(content)};
            states.set(id,{data,choices:[],visible:[],request:0});
            const select=(key,label,values)=>`<div class="col-md-6 form-group"><label>${label}</label><select class="form-control" data-gs-meta="${key}">${values.map(value=>`<option value="${value}" ${Number(data[key])===value?'selected':''}>${value}</option>`).join('')}</select></div>`;
            return `<div class="gs-editor" data-gs-editor data-block-id="${esc(id)}">
                <div class="form-group"><label>Section title</label><input class="form-control" data-gs-meta="title" maxlength="255" value="${esc(data.title)}"></div>
                <div class="form-group"><label>Description</label><textarea class="form-control" data-gs-description rows="4">${esc(data.description)}</textarea></div>
                <div class="row">${select('columns','Images per row (desktop)',[1,2,3,4])}${select('mobile_columns','Images per row (mobile)',[1,2])}</div>
                <label class="d-block"><input type="checkbox" data-gs-meta="show_tags" ${data.show_tags?'checked':''}> Show the same tag menu as the Gallery page (links to filtered Gallery)</label>
                <label class="d-block"><input type="checkbox" data-gs-meta="show_more" ${data.show_more?'checked':''}> Show link to full Gallery</label>
                <div class="row"><div class="col-md-6 form-group"><label>Gallery link label</label><input class="form-control" data-gs-meta="more_label" maxlength="255" value="${esc(data.more_label)}"></div><div class="col-md-6 form-group"><label>Zoom label</label><input class="form-control" data-gs-meta="zoom_label" maxlength="255" value="${esc(data.zoom_label)}"></div></div>
                <div class="form-group"><label>Gallery</label><select class="form-control" data-gs-page><option value="${esc(data.gallery_page_id||'')}">Loading Galleries…</option></select></div>
                <div data-gs-status role="status" aria-live="polite"></div><button type="button" class="btn btn-sm btn-link" data-gs-action="retry">Reload gallery</button>
                <h6>Selected images <small data-gs-count></small></h6><p class="small text-muted">Drag ☰ or use arrows to reorder. Titles are shown above each image. Images and tags stay linked to the source Gallery.</p>
                <div class="gs-selected" data-gs-selected></div>
                <div class="gs-tools"><input class="form-control" style="flex:1;min-width:140px" data-gs-search placeholder="Search images or tags" aria-label="Search images"><select class="form-control" style="flex:1;min-width:140px" data-gs-filter aria-label="Filter by tag"><option value="">All tags</option></select><button type="button" class="btn btn-sm btn-outline-primary" data-gs-action="all">Select all matching</button><button type="button" class="btn btn-sm btn-outline-secondary" data-gs-action="clear">Clear selection</button></div>
                <div class="gs-choice-grid" data-gs-choices></div></div>`;
        },
        bind(){document.querySelectorAll('[data-gs-editor]').forEach(mount);},
        collect:root=>copy(pull(root)),
    };
})();
