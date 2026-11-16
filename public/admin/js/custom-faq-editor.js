(() => {
    const states = new Map();
    const clone = value => JSON.parse(JSON.stringify(value));
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[c]));
    const uid = () => 'faq_' + [...crypto.getRandomValues(new Uint8Array(12))].map(x=>x.toString(16).padStart(2,'0')).join('');
    let productsRequest;
    let destinations = [
        {url:'/faq',name:'FAQ top'}, {url:'/faq/order',name:'Orders / quotations'},
        {url:'/faq/delivery',name:'Production / shipping'}, {url:'/faq/payment',name:'Payments'},
        {url:'/faq/product',name:'Product FAQ index'},
    ];
    function pull(root) {
        const data=states.get(root.dataset.blockId).data;
        root.querySelectorAll('[data-cf-meta]').forEach(input=>data[input.dataset.cfMeta]=input.value);
        data.items=[...root.querySelectorAll('[data-cf-item-id]')].map(row=>{
            const item={id:row.dataset.cfItemId};
            row.querySelectorAll('[data-cf-field]').forEach(input=>item[input.dataset.cfField]=input.type==='checkbox'?input.checked:input.value);
            return item;
        });
        return data;
    }
    function destinationOptions(url) {
        return '<option value="">Custom URL / choose a FAQ page...</option>'+destinations.map(destination=>`<option value="${esc(destination.url)}" ${url===destination.url?'selected':''}>${esc(destination.name)}</option>`).join('');
    }
    function itemHtml(item,index,total,state,id) {
        const prefix='cf-'+id+'-'+item.id;
        const icon = Object.prototype.hasOwnProperty.call(state.icons,item.icon) ? item.icon : Object.keys(state.icons).find(key=>item.image_url==='/images/custom-faq-icons/'+key+'.svg') || 'question';
        return `<div class="cf-editor-item" data-cf-item-id="${esc(item.id)}">
            <div class="cf-editor-toolbar"><button type="button" class="btn btn-sm btn-outline-secondary cf-item-handle" aria-label="Drag to reorder FAQ link">☰</button>
                <strong>FAQ link ${index+1}</strong>
                <button type="button" class="btn btn-sm btn-light" data-cf-action="up" ${index===0?'disabled':''} aria-label="Move FAQ link up">↑</button>
                <button type="button" class="btn btn-sm btn-light" data-cf-action="down" ${index===total-1?'disabled':''} aria-label="Move FAQ link down">↓</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-cf-action="duplicate">Duplicate</button>
                <button type="button" class="btn btn-sm btn-outline-danger" data-cf-action="remove">Remove</button>
            </div><div class="row">
                <div class="col-md-6 form-group"><label for="${esc(prefix)}-title">Category title</label><input id="${esc(prefix)}-title" class="form-control" data-cf-field="title" value="${esc(item.title)}" maxlength="255"></div>
                <div class="col-md-6 form-group"><label for="${esc(prefix)}-icon">Icon</label><div class="cf-editor-icon-choice"><span class="cf-icon" data-cf-icon-preview>${state.icons[icon].svg}</span><select id="${esc(prefix)}-icon" class="form-control" data-cf-field="icon">${Object.entries(state.icons).map(([key,entry])=>`<option value="${key}" ${icon===key?'selected':''}>${esc(entry.label)}</option>`).join('')}</select></div></div>
                <div class="col-md-6 form-group"><label for="${esc(prefix)}-destination">Existing FAQ page (optional)</label><select id="${esc(prefix)}-destination" class="form-control" data-cf-destination>${destinationOptions(item.url)}</select></div>
                <div class="col-md-6 form-group"><label for="${esc(prefix)}-url">Destination URL</label><input id="${esc(prefix)}-url" class="form-control" data-cf-field="url" value="${esc(item.url)}" maxlength="2048" placeholder="/faq/order or https://..."></div>
                <div class="col-12"><label><input type="checkbox" data-cf-field="new_tab" ${item.new_tab?'checked':''}> Open in a new tab</label></div>
            </div></div>`;
    }
    function contents(id) {
        const state=states.get(id),data=state.data;
        const select=(key,label,values)=>`<div class="col-md-6 form-group"><label>${label}</label><select class="form-control" data-cf-meta="${key}">${values.map(value=>`<option value="${value}" ${Number(data[key])===value?'selected':''}>${value}</option>`).join('')}</select></div>`;
        return `<div class="cf-editor-error" role="alert" hidden></div>
            <div class="form-group"><label for="cf-${esc(id)}-title">Section title (optional)</label><input id="cf-${esc(id)}-title" class="form-control" data-cf-meta="title" value="${esc(data.title)}" maxlength="255"></div>
            <div class="form-group cf-editor-description"><label for="cf-${esc(id)}-description">Description</label><textarea id="cf-${esc(id)}-description" class="form-control" data-cf-meta="description" rows="5" maxlength="50000">${esc(data.description)}</textarea></div>
            <div class="row">${select('columns','Columns (desktop)',[2,3,4])}${select('mobile_columns','Columns (mobile)',[1,2])}</div>
            <p class="small text-muted">Drag ☰ or use the arrows to reorder. Each tile links to a FAQ page.</p>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-cf-action="presets">+ Add 12 sample categories</button>
            <p class="small text-muted mt-2">Samples are added to the list. Choose a destination for any sample with a blank URL before saving.</p>
            <div class="cf-editor-list">${data.items.map((item,index)=>itemHtml(item,index,data.items.length,state,id)).join('')}</div>
            <button type="button" class="btn btn-sm btn-outline-primary" data-cf-action="add">+ Add FAQ link</button>`;
    }
    function error(root,message){const box=root.querySelector('.cf-editor-error');box.textContent=message;box.hidden=false;}
    function mount(root) {
        const id=root.dataset.blockId,state=states.get(id),textarea=root.querySelector('textarea');
        if(window.ClassicEditor&&!state.editorPending&&!state.editor) {
            state.editorPending=true;
            ClassicEditor.create(textarea,{toolbar:['heading','|','bold','italic','link','|','bulletedList','numberedList','blockQuote','|','undo','redo'],link:{defaultProtocol:'https://',addTargetToExternalLinks:true}}).then(editor=>{
                if(states.get(id)!==state||!textarea.isConnected){editor.destroy();return;}
                state.editor=editor;
                editor.model.document.on('change:data',()=>{textarea.value=editor.getData();textarea.dispatchEvent(new Event('input',{bubbles:true}));});
                textarea.value=editor.getData();
            }).catch(reason=>{state.editorPending=false;error(root,'Could not load Description editor: '+reason.message);});
        }
        if(window.Sortable)state.sortable=new Sortable(root.querySelector('.cf-editor-list'),{handle:'.cf-item-handle',draggable:'.cf-editor-item',animation:150,forceFallback:true,fallbackOnBody:true,scroll:true,bubbleScroll:true,scrollSensitivity:80,scrollSpeed:14,onEnd:()=>{pull(root);refresh(root);root.dispatchEvent(new Event('change',{bubbles:true}));}});
    }
    function refresh(root) {
        const state=states.get(root.dataset.blockId),intro=root.querySelector('.cf-editor-description');
        state.sortable?.destroy();intro?.remove();root.innerHTML=contents(root.dataset.blockId);
        if(intro)root.querySelector('.cf-editor-description').replaceWith(intro);
        mount(root);
    }
    function bind(apiBase='/api/v1/admin/products') {
        const roots=[...document.querySelectorAll('[data-cf-editor]:not([data-cf-bound])')];
        if(!roots.length)return;
        if(!productsRequest)productsRequest=fetch(apiBase,{credentials:'same-origin',headers:{Accept:'application/json'}}).then(async response=>{
            if(!response.ok)throw Error('Could not load product FAQ pages. You can still choose a shared FAQ page or enter a URL.');
            const result=await response.json();
            const base=destinations.filter(destination=>!destination.product);
            // The existing FAQ detail route accepts a single slug segment.
            destinations=base.concat((Array.isArray(result.data)?result.data:[]).filter(product=>product.slug&&!product.slug.includes('/')).map(product=>({url:'/faq/product/'+product.slug,name:'Product FAQ: '+product.name,product:true})));
        }).catch(reason=>{productsRequest=null;throw reason;});
        roots.forEach(root=>{
            root.dataset.cfBound='1';mount(root);
            productsRequest.then(()=>{if(root.isConnected)root.querySelectorAll('[data-cf-item-id]').forEach(row=>row.querySelector('[data-cf-destination]').innerHTML=destinationOptions(row.querySelector('[data-cf-field="url"]').value));}).catch(reason=>{if(root.isConnected)error(root,reason.message);});
            root.addEventListener('input',event=>{
                if(event.target.matches('[data-cf-field="url"]')){
                    const row=event.target.closest('[data-cf-item-id]');row.querySelector('[data-cf-destination]').innerHTML=destinationOptions(event.target.value);
                }
            });
            root.addEventListener('change',event=>{
                const input=event.target,row=input.closest('[data-cf-item-id]');
                if(!row)return;
                if(input.matches('[data-cf-field="icon"]'))row.querySelector('[data-cf-icon-preview]').innerHTML=states.get(root.dataset.blockId).icons[input.value].svg;
                if(input.matches('[data-cf-destination]')&&input.value){
                    row.querySelector('[data-cf-field="url"]').value=input.value;
                    const title=row.querySelector('[data-cf-field="title"]');if(!title.value.trim())title.value=input.selectedOptions[0].textContent;
                    root.dispatchEvent(new Event('input',{bubbles:true}));
                }
            });
            root.addEventListener('click',event=>{
                const button=event.target.closest('[data-cf-action]');if(!button||button.disabled)return;
                const state=states.get(root.dataset.blockId),data=pull(root),action=button.dataset.cfAction;
                const itemId=button.closest('[data-cf-item-id]')?.dataset.cfItemId,index=data.items.findIndex(item=>item.id===itemId);
                if(['add','duplicate','presets'].includes(action)) {
                    const count=action==='presets'?state.presets.length:1;
                    if(data.items.length+count>100){error(root,'Maximum 100 FAQ links per component.');return;}
                    if(action==='presets')data.items.push(...clone(state.presets).map(item=>({...item,id:uid(),new_tab:false})));
                    else if(action==='duplicate')data.items.splice(index+1,0,{...clone(data.items[index]),id:uid()});
                    else data.items.push({id:uid(),title:'',icon:'question',url:'',new_tab:false});
                } else if(action==='remove')data.items.splice(index,1);
                else {const next=index+(action==='up'?-1:1);if(next<0||next>=data.items.length)return;[data.items[index],data.items[next]]=[data.items[next],data.items[index]];}
                refresh(root);root.dispatchEvent(new Event('change',{bubbles:true}));
            });
        });
    }
    window.CustomFaqEditor={
        render(id,content,defaults,icons,presets){const old=states.get(id);old?.sortable?.destroy();old?.editor?.destroy();states.set(id,{data:{...clone(defaults),...clone(content)},icons,presets});return `<div class="cf-editor" data-cf-editor data-block-id="${esc(id)}">${contents(id)}</div>`;},
        bind,collect:root=>clone(pull(root)),
    };
})();
