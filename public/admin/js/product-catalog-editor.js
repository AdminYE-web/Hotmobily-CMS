(() => {
    const states = new Map();
    const clone = value => JSON.parse(JSON.stringify(value));
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[c]));
    const uid = () => 'catalog_' + [...crypto.getRandomValues(new Uint8Array(12))].map(x=>x.toString(16).padStart(2,'0')).join('');
    let uploadImage, productsRequest;
    let products = [];
    const metaFields = {title:'Section title (optional)', empty_label:'Empty category message'};
    const itemFields = {title:'Product title', alt:'Image Alt Text', image_url:'Card image URL', url:'Product link URL', badge:'Badge (optional, e.g. 新商品！)'};
    function pull(root) {
        const data = states.get(root.dataset.blockId).data;
        root.querySelectorAll('[data-pc-meta]').forEach(input => data[input.dataset.pcMeta] = input.type === 'checkbox' ? input.checked : input.value);
        data.categories = [...root.querySelectorAll('[data-pc-category-id]')].map(row=>({id:row.dataset.pcCategoryId, name:row.querySelector('[data-pc-category-name]').value}));
        data.items = [...root.querySelectorAll('[data-pc-item-id]')].map(row=>{
            const item = {id:row.dataset.pcItemId};
            row.querySelectorAll('[data-pc-field]').forEach(input=>item[input.dataset.pcField] = input.value);
            item.product_id = item.product_id ? Number(item.product_id) : null;
            item.category_ids = [...row.querySelectorAll('[data-pc-membership]:checked')].map(input=>input.value);
            return item;
        });
        return data;
    }
    function cardDetails(item) {
        if (Object.prototype.hasOwnProperty.call(item,'details_html')) return item.details_html || '';
        const lines=[];
        if ([item.price_prefix,item.price,item.price_suffix].some(value=>String(value??'').trim())) lines.push(esc(item.price_prefix)+'<span style="color:#ff0000">'+esc(item.price)+'</span>'+esc(item.price_suffix));
        if (item.delivery) lines.push(esc(item.delivery));
        return lines.length ? '<p>'+lines.join('<br>')+'</p>' : '';
    }
    function CatalogTextColor(editor) {
        editor.model.schema.extend('$text',{allowAttributes:'catalogTextColor'});
        editor.conversion.for('downcast').attributeToElement({
            model:'catalogTextColor',
            view:(value,{writer})=>writer.createAttributeElement('span',{style:'color:'+value}),
        });
        editor.conversion.for('upcast').elementToAttribute({
            view:{name:'span',styles:{color:/.+/}},
            model:{key:'catalogTextColor',value:element=>element.getStyle('color')},
        });
    }
    function productOptions(selected) {
        let options = '<option value="">Custom link / select a product...</option>';
        if (selected && !products.some(product=>Number(product.id)===Number(selected))) options += `<option value="${esc(selected)}" selected>Selected product #${esc(selected)}</option>`;
        return options + products.map(product=>`<option value="${esc(product.id)}" ${Number(selected)===Number(product.id)?'selected':''}>${esc(product.name)} (${esc(product.slug)})</option>`).join('');
    }
    function moves(scope,index,total) {
        return `<button type="button" class="btn btn-sm btn-light" data-pc-${scope}-action="up" ${index===0?'disabled':''} aria-label="Move ${scope} up">↑</button>
            <button type="button" class="btn btn-sm btn-light" data-pc-${scope}-action="down" ${index===total-1?'disabled':''} aria-label="Move ${scope} down">↓</button>`;
    }
    function memberships(categories, item) {
        return categories.length ? categories.map(category=>`<label><input type="checkbox" data-pc-membership value="${esc(category.id)}" ${(item.category_ids||[]).includes(category.id)?'checked':''}> ${esc(category.name || 'Unnamed category')}</label>`).join('') : '<small class="text-muted">Add categories above to assign this card.</small>';
    }
    function itemHtml(item,index,total,id,data) {
        return `<div class="pc-editor-item" data-pc-item-id="${esc(item.id)}">
            <div class="pc-editor-toolbar">
                <button type="button" class="btn btn-sm btn-outline-secondary pc-item-handle" aria-label="Drag to reorder product">☰</button>
                <strong>Product ${index+1}</strong>${moves('item',index,total)}
                <button type="button" class="btn btn-sm btn-outline-secondary" data-pc-item-action="duplicate">Duplicate</button>
                <button type="button" class="btn btn-sm btn-outline-danger" data-pc-item-action="remove">Remove</button>
            </div>
            <div class="row"><div class="col-md-3">
                <img class="pc-editor-preview" ${item.image_url?`src="${esc(item.image_url)}"`:'hidden'} alt="${esc(item.alt || item.title)}">
                <label class="btn btn-sm btn-outline-primary">Upload image<input type="file" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" data-pc-upload hidden></label>
                <small data-pc-upload-status role="status"></small>
            </div><div class="col-md-9"><div class="row">
                <div class="col-12 form-group"><label for="pc-${esc(id)}-${esc(item.id)}-product">Choose an existing product (optional)</label>
                    <select id="pc-${esc(id)}-${esc(item.id)}-product" class="form-control" data-pc-field="product_id">${productOptions(item.product_id)}</select>
                    <small class="text-muted">Selecting a product fills its link and an empty title. Image and card description are entered below.</small>
                </div>
                ${Object.entries(itemFields).map(([key,label])=>`<div class="col-md-6 form-group"><label for="pc-${esc(id)}-${esc(item.id)}-${key}">${label}</label><input id="pc-${esc(id)}-${esc(item.id)}-${key}" class="form-control form-control-sm" data-pc-field="${key}" value="${esc(item[key])}" maxlength="${key==='url'||key==='image_url'?2048:key==='alt'||key==='delivery'?500:key==='title'?255:100}"></div>`).join('')}
                <div class="col-12 form-group pc-card-richtext"><label for="pc-${esc(id)}-${esc(item.id)}-details">Description (price / production time)</label><textarea id="pc-${esc(id)}-${esc(item.id)}-details" class="form-control" data-pc-field="details_html" rows="4" maxlength="50000">${esc(cardDetails(item))}</textarea></div>
                <div class="col-12 form-group"><span>Categories (select multiple)</span><div class="pc-editor-memberships">${memberships(data.categories,item)}</div></div>
            </div></div></div>
        </div>`;
    }
    function defaultOptions(data) {
        return '<option value="">All products (no filter)</option>'+data.categories.map(category=>`<option value="${esc(category.id)}" ${data.default_category===category.id?'selected':''}>${esc(category.name||'Unnamed category')}</option>`).join('');
    }
    function contents(id) {
        const data=states.get(id).data;
        const select=(key,label,values)=>`<div class="col-md-4 form-group"><label>${label}</label><select class="form-control" data-pc-meta="${key}">${values.map(v=>`<option value="${v}" ${Number(data[key])===v?'selected':''}>${v}</option>`).join('')}</select></div>`;
        return `<div class="pc-editor-error" role="alert" hidden></div>
            <div class="row">${Object.entries(metaFields).map(([key,label])=>`<div class="col-md-6 form-group"><label for="pc-${esc(id)}-${key}">${label}</label><input id="pc-${esc(id)}-${key}" class="form-control" data-pc-meta="${key}" value="${esc(data[key])}" maxlength="${key==='empty_label'?500:key==='title'?255:100}"></div>`).join('')}</div>
            <div class="form-group pc-editor-description"><label for="pc-${esc(id)}-description">Description</label><textarea id="pc-${esc(id)}-description" class="form-control" data-pc-meta="description" rows="5" maxlength="50000">${esc(data.description)}</textarea></div>
            <div class="row">${select('columns','Columns (desktop)',[2,3,4])}${select('mobile_columns','Columns (mobile)',[1,2])}
                <div class="col-md-4 form-group"><label>Default category</label><select class="form-control" data-pc-meta="default_category">${defaultOptions(data)}</select></div>
            </div>
            <h5 class="mt-3">Filter categories</h5><p class="small text-muted">Drag ☰ or use the arrows to reorder categories and product cards.</p>
            <div class="pc-editor-categories">${data.categories.map((category,index)=>`<div class="pc-editor-category" data-pc-category-id="${esc(category.id)}"><button type="button" class="btn btn-sm btn-outline-secondary pc-category-handle" aria-label="Drag to reorder category">☰</button><input class="form-control form-control-sm" data-pc-category-name value="${esc(category.name)}" maxlength="100" aria-label="Category name">${moves('category',index,data.categories.length)}<button type="button" class="btn btn-sm btn-outline-danger" data-pc-category-action="remove">Remove</button></div>`).join('')}</div>
            <button type="button" class="btn btn-sm btn-outline-primary" data-pc-category-action="add">+ Add category</button>
            <h5 class="mt-4">Product cards</h5><div class="pc-editor-list">${data.items.map((item,index)=>itemHtml(item,index,data.items.length,id,data)).join('')}</div>
            <button type="button" class="btn btn-sm btn-outline-primary" data-pc-item-action="add">+ Add product</button>`;
    }
    function error(root,message) {const box=root.querySelector('.pc-editor-error');box.textContent=message;box.hidden=false;}
    function updateCategories(root) {
        const data=pull(root);
        root.querySelector('[data-pc-meta="default_category"]').innerHTML=defaultOptions(data);
        root.querySelectorAll('[data-pc-item-id]').forEach(row=>row.querySelector('.pc-editor-memberships').innerHTML=memberships(data.categories,data.items.find(item=>item.id===row.dataset.pcItemId)));
    }
    function mount(root) {
        const id=root.dataset.blockId,state=states.get(id);
        state.editors ??= new Map();
        root.querySelectorAll('textarea').forEach(textarea=>{
            if (!window.ClassicEditor || state.editors.has(textarea)) return;
            state.editors.set(textarea,null);
            ClassicEditor.create(textarea,{
                extraPlugins:[CatalogTextColor],
                toolbar:['heading','|','bold','italic','link','|','bulletedList','numberedList','blockQuote','|','undo','redo'],
                link:{defaultProtocol:'https://',addTargetToExternalLinks:true},
            }).then(editor=>{
                if(states.get(id)!==state || !state.editors.has(textarea) || !textarea.isConnected){editor.destroy();return;}
                state.editors.set(textarea,editor);
                editor.model.document.on('change:data',()=>{textarea.value=editor.getData();textarea.dispatchEvent(new Event('input',{bubbles:true}));});
                textarea.value=editor.getData();
                const label=document.createElement('label');
                label.className='pc-editor-color';
                label.append('Text color (select text first)');
                const color=document.createElement('input');
                color.type='color';color.value='#ff0000';color.setAttribute('aria-label','Text color');
                label.append(color);editor.ui.view.element.after(label);
                const applyColor=()=>{
                    editor.model.change(writer=>{
                        const selection=editor.model.document.selection;
                        if(selection.isCollapsed)writer.setSelectionAttribute('catalogTextColor',color.value);
                        else for(const range of selection.getRanges())writer.setAttribute('catalogTextColor',color.value,range);
                    });
                    editor.editing.view.focus();
                };
                color.addEventListener('input',applyColor);
                color.addEventListener('change',applyColor);
            }).catch(reason=>{state.editors.delete(textarea);error(root,'Could not load Description editor: '+reason.message);});
        });
        state.sortables=[];
        if(window.Sortable) for(const [selector,handle,draggable] of [['.pc-editor-categories','.pc-category-handle','.pc-editor-category'],['.pc-editor-list','.pc-item-handle','.pc-editor-item']]) {
            state.sortables.push(new Sortable(root.querySelector(selector),{handle,draggable,animation:150,forceFallback:true,fallbackOnBody:true,scroll:true,bubbleScroll:true,scrollSensitivity:80,scrollSpeed:14,onEnd:()=>{pull(root);refresh(root);root.dispatchEvent(new Event('change',{bubbles:true}));}}));
        }
    }
    function refresh(root) {
        const state=states.get(root.dataset.blockId),intro=root.querySelector('.pc-editor-description');
        const rows=new Map([...root.querySelectorAll('[data-pc-item-id]')].map(row=>[row.dataset.pcItemId,row]));
        state.sortables?.forEach(sortable=>sortable.destroy());
        intro?.remove();rows.forEach(row=>row.remove());root.innerHTML=contents(root.dataset.blockId);
        if(intro)root.querySelector('.pc-editor-description').replaceWith(intro);
        root.querySelectorAll('[data-pc-item-id]').forEach(row=>{
            const existing=rows.get(row.dataset.pcItemId);
            if(!existing)return;
            existing.querySelector('.pc-editor-toolbar').replaceWith(row.querySelector('.pc-editor-toolbar'));
            // Category membership may have changed while preserving the rich text editor.
            existing.querySelector('.pc-editor-memberships').replaceWith(row.querySelector('.pc-editor-memberships'));
            row.replaceWith(existing);
        });
        state.editors?.forEach((editor,textarea)=>{if(!root.contains(textarea)){editor?.destroy();state.editors.delete(textarea);}});
        mount(root);
    }
    function bind(upload,apiBase='/api/v1/admin/products') {
        if(upload)uploadImage=upload;
        const roots=[...document.querySelectorAll('[data-pc-editor]:not([data-pc-bound])')];
        if(!roots.length)return;
        if(!productsRequest)productsRequest=fetch(apiBase,{credentials:'same-origin',headers:{Accept:'application/json'}}).then(async response=>{if(!response.ok)throw Error('Could not load products. You can still enter a custom link.');const result=await response.json();products=Array.isArray(result.data)?result.data:[];return products;}).catch(reason=>{productsRequest=null;throw reason;});
        roots.forEach(root=>{
            root.dataset.pcBound='1';mount(root);
            productsRequest.then(()=>{if(!root.isConnected)return;root.querySelectorAll('[data-pc-field="product_id"]').forEach(select=>select.innerHTML=productOptions(select.value));}).catch(reason=>{if(root.isConnected)error(root,reason.message);});
            root.addEventListener('input',event=>{
                const input=event.target;
                if(input.matches('[data-pc-category-name]'))updateCategories(root);
                if(input.matches('[data-pc-field="image_url"],[data-pc-field="alt"],[data-pc-field="title"]')) {
                    const row=input.closest('[data-pc-item-id]'),image=row.querySelector('.pc-editor-preview'),url=row.querySelector('[data-pc-field="image_url"]').value;
                    image.hidden=!url;if(url&&image.getAttribute('src')!==url)image.src=url;
                    image.alt=row.querySelector('[data-pc-field="alt"]').value||row.querySelector('[data-pc-field="title"]').value;
                }
                if(input.matches('[data-pc-field="url"]'))input.closest('[data-pc-item-id]').querySelector('[data-pc-field="product_id"]').value='';
            });
            root.addEventListener('change',async event=>{
                const input=event.target;
                if(input.matches('[data-pc-field="product_id"]')) {
                    const product=products.find(product=>Number(product.id)===Number(input.value));
                    if(product) {
                        const row=input.closest('[data-pc-item-id]');
                        row.querySelector('[data-pc-field="url"]').value='/products/'+product.slug;
                        const title=row.querySelector('[data-pc-field="title"]');
                        if(!title.value.trim())title.value=product.name;
                    }
                }
                if(!input.matches('[data-pc-upload]')||!input.files.length)return;
                const row=input.closest('[data-pc-item-id]'),itemId=row.dataset.pcItemId;
                input.disabled=true;row.querySelector('[data-pc-upload-status]').textContent='Uploading…';
                try {
                    if(!uploadImage)throw Error('Image upload is unavailable.');
                    const url=await uploadImage(input.files[0]);
                    const current=[...root.querySelectorAll('[data-pc-item-id]')].find(row=>row.dataset.pcItemId===itemId);
                    if(current){const target=current.querySelector('[data-pc-field="image_url"]');target.value=url;target.dispatchEvent(new Event('input',{bubbles:true}));current.querySelector('[data-pc-upload-status]').textContent='Uploaded';pull(root);}
                }catch(reason){error(root,reason.message);}finally{input.disabled=false;input.value='';}
            });
            root.addEventListener('click',event=>{
                const button=event.target.closest('[data-pc-item-action],[data-pc-category-action]');
                if(!button||button.disabled)return;
                const data=pull(root),isCategory=button.hasAttribute('data-pc-category-action'),action=isCategory?button.dataset.pcCategoryAction:button.dataset.pcItemAction;
                const list=isCategory?data.categories:data.items,entryId=isCategory?button.closest('[data-pc-category-id]')?.dataset.pcCategoryId:button.closest('[data-pc-item-id]')?.dataset.pcItemId;
                const index=list.findIndex(entry=>entry.id===entryId);
                if(action==='add'||action==='duplicate') {
                    if(list.length>=(isCategory?50:100)){error(root,isCategory?'Maximum 50 categories.':'Maximum 100 product cards.');return;}
                    const entry=action==='duplicate'?{...clone(list[index]),id:uid()}:isCategory?{id:uid(),name:''}:{id:uid(),product_id:null,title:'',alt:'',image_url:'',url:'',details_html:'',badge:'',category_ids:[]};
                    if(action==='duplicate')list.splice(index+1,0,entry);else list.push(entry);
                } else if(action==='remove') {
                    list.splice(index,1);
                    if(isCategory){data.items.forEach(item=>item.category_ids=item.category_ids.filter(id=>id!==entryId));if(data.default_category===entryId)data.default_category='';}
                } else {
                    const next=index+(action==='up'?-1:1);if(next<0||next>=list.length)return;
                    [list[index],list[next]]=[list[next],list[index]];
                }
                refresh(root);root.dispatchEvent(new Event('change',{bubbles:true}));
            });
        });
    }
    window.ProductCatalogEditor={
        render(id,content,defaults){const old=states.get(id);old?.sortables?.forEach(sortable=>sortable.destroy());old?.editors?.forEach(editor=>editor?.destroy());states.set(id,{data:{...clone(defaults),...clone(content)}});return `<div class="pc-editor" data-pc-editor data-block-id="${esc(id)}">${contents(id)}</div>`;},
        bind,collect:root=>clone(pull(root)),
    };
})();
