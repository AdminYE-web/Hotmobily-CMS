(() => {
    'use strict';
    const states=new Map();
    const copy=value=>JSON.parse(JSON.stringify(value));
    const esc=value=>String(value??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const uid=()=> 'callout-'+Array.from(crypto.getRandomValues(new Uint32Array(2)),n=>n.toString(36)).join('-');
    const percent=value=>Math.round(Math.max(0,Math.min(100,Number(value)||0))*100)/100;
    const labelX=value=>Math.round(Math.max(-100,Math.min(100,Number(value)||0))*100)/100;
    const lineStart=(item,d)=>(item.side==='left'?0:100)+labelX(item.label_x)*(100-d.image_width)/d.image_width;
    let uploadImage,sanitize=value=>esc(value);
    const safeUrl=value=>{const url=String(value||'').trim();return !/[\x00-\x20\\]/.test(url)&&((url.startsWith('/')&&!url.startsWith('//'))||/^#[A-Za-z][A-Za-z0-9_-]*$/.test(url)||/^https?:\/\//i.test(url))?url:'';};
    function error(root,message){root.querySelector('[data-pa-status]').textContent=message;}
    function pull(root){
        const state=states.get(root.dataset.blockId),data=state.data;
        for(const [textarea,entry] of state.rich)if(textarea.isConnected&&entry.editor)textarea.value=entry.editor.getData();
        root.querySelectorAll('[data-pa-meta]').forEach(input=>data[input.dataset.paMeta]=input.type==='checkbox'?input.checked:input.type==='number'?Number(input.value):input.value);
        data.items=[...root.querySelectorAll('[data-pa-item]')].map(row=>{
            const item={id:row.dataset.paItem};
            row.querySelectorAll('[data-pa-field]').forEach(input=>item[input.dataset.paField]=input.type==='number'?Number(input.value):input.value);
            return item;
        });
        return data;
    }
    function focusItem(root,id){
        const state=states.get(root.dataset.blockId);state.activeId=id;
        const row=[...root.querySelectorAll('[data-pa-item]')].find(row=>row.dataset.paItem===id);
        if(!row)return;row.open=true;row.scrollIntoView({block:'center',behavior:'smooth'});row.querySelector('[data-pa-field="title"]').focus({preventScroll:true});
        root.querySelectorAll('[data-pa-item]').forEach(el=>el.classList.toggle('is-active',el===row));
    }
    function fit(root){
        if(!root.isConnected)return;
        const state=states.get(root.dataset.blockId),width=state.mode==='mobile'?375:770;
        const viewport=root.querySelector('[data-pa-preview-scroll]'),frame=root.querySelector('[data-pa-frame]'),canvas=root.querySelector('[data-pa-canvas]');
        canvas.style.width=width+'px';
        const scale=Math.min(1,Math.max(1,viewport.clientWidth)/width);
        canvas.style.transform=`scale(${scale})`;frame.style.width=width*scale+'px';frame.style.height=canvas.offsetHeight*scale+'px';
    }
    function preview(root){
        const state=states.get(root.dataset.blockId),d=pull(root);
        const sideHtml=side=>{
            const items=d.items.filter(item=>item.side===side),image=safeUrl((state.mode==='mobile'&&d[side+'_mobile_image'])||d[side+'_image']);
            return `<div class="pa-side pa-side--${side}"><div class="pa-text" ${side==='right'?'style="grid-column:2;grid-row:1"':''}>${items.map(item=>`<div class="pa-callout ${state.activeId===item.id?'is-active':''}" data-pa-select="${esc(item.id)}" tabindex="0" role="button" aria-label="Move text: ${esc(item.title||'Callout')}" style="left:${labelX(item.label_x)}%;top:${percent(item.label_y)}%"><h4>${item.url?`<a href="${esc(safeUrl(item.url))}">${esc(item.title||'Callout title')}</a>`:esc(item.title||'Callout title')}</h4><div class="pa-description">${sanitize(item.description||'')}</div></div>`).join('')}</div><div class="pa-image" data-pa-image-side="${side}" ${side==='right'?'style="grid-column:1;grid-row:1"':''}>${image?`<img src="${esc(image)}" alt="${esc(d[side+'_alt'])}">`:`<div class="pa-placeholder">Upload ${side} image</div>`}<svg class="pa-lines" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">${items.map(item=>`<line data-pa-line="${esc(item.id)}" x1="${lineStart(item,d)}" y1="${percent(item.label_y)}" x2="${percent(item.x)}" y2="${percent(item.y)}"/>`).join('')}</svg>${items.map(item=>`<button type="button" class="pa-point" data-pa-pin="${esc(item.id)}" style="left:${percent(item.x)}%;top:${percent(item.y)}%" aria-label="Move point: ${esc(item.title||'Callout')}" title="Drag to move. Arrow keys move 1%; Shift + arrow moves 5%."></button>`).join('')}</div></div>`;
        };
        const image=key=>safeUrl(d[key])?`<img src="${esc(safeUrl(d[key]))}" alt="">`:'<div></div>';
        root.querySelector('[data-pa-canvas]').innerHTML=`<section class="product-anatomy ${d.pulse?'pa-pulse':''}" style="--pa-image-width:${d.image_width}%;--pa-line:${esc(d.line_color)};--pa-point:${esc(d.point_color)}">${d.title?`<h3 class="pa-title">${esc(d.title)}</h3>`:''}<div class="pa-main">${sideHtml('left')}${sideHtml('right')}</div>${d.details_enabled?`<div class="pa-details">${image('detail_left_image')}<div class="pa-detail-copy"><h4>${esc(d.detail_title)}</h4><div class="pa-description">${sanitize(d.detail_description)}</div></div>${image('detail_right_image')}</div>`:''}</section>`;
        root.querySelectorAll('[data-pa-canvas] img').forEach(img=>img.addEventListener('load',()=>fit(root),{once:true}));
        requestAnimationFrame(()=>fit(root));
    }
    function mountRich(root){
        const state=states.get(root.dataset.blockId);
        root.querySelectorAll('[data-pa-rich]').forEach(textarea=>{
            if(!window.ClassicEditor||state.rich.has(textarea))return;
            const entry={};state.rich.set(textarea,entry);
            ClassicEditor.create(textarea,{toolbar:['bold','italic','link','|','bulletedList','numberedList','|','undo','redo'],link:{defaultProtocol:'https://',addTargetToExternalLinks:true}}).then(editor=>{
                if(!textarea.isConnected||state.rich.get(textarea)!==entry){editor.destroy();return;}
                entry.editor=editor;editor.model.document.on('change:data',()=>{textarea.value=editor.getData();textarea.dispatchEvent(new Event('input',{bubbles:true}));});
            }).catch(reason=>error(root,'Could not load text editor: '+reason.message));
        });
    }
    function form(root){
        const state=states.get(root.dataset.blockId),d=state.data;
        for(const entry of state.rich.values())entry.editor?.destroy();state.rich.clear();
        const field=(key,label,type='text',attrs='')=>`<div class="form-group"><label for="pa-${esc(root.dataset.blockId)}-${key}">${label}</label><input id="pa-${esc(root.dataset.blockId)}-${key}" class="form-control" type="${type}" data-pa-meta="${key}" value="${esc(d[key])}" ${attrs}></div>`;
        const rich=(key,label)=>`<div class="form-group"><label>${label}</label><textarea class="form-control" rows="3" data-pa-rich data-pa-meta="${key}">${esc(d[key])}</textarea></div>`;
        const image=(key,label)=>`<div class="pa-image-editor"><label>${label}</label><div class="input-group"><input class="form-control" data-pa-meta="${key}" value="${esc(d[key])}" maxlength="2000" placeholder="Image URL"><div class="input-group-append"><label class="btn btn-outline-primary mb-0">Upload<input type="file" data-pa-upload="${key}" accept=".png,.jpg,.jpeg,.webp,.gif,.svg" hidden ${state.uploads.has(key)?'disabled':''}></label><button type="button" class="btn btn-outline-danger" data-pa-clear="${key}">Clear</button></div></div><img data-pa-thumbnail="${key}" ${d[key]?`src="${esc(safeUrl(d[key]))}"`:'hidden'} alt=""><small class="d-block text-muted">PNG, JPG, WebP, GIF or SVG, up to 10 MB. Matching portrait images work best for the main diagram.</small></div>`;
        const itemHtml=(item,index)=>`<details class="pa-callout-editor" data-pa-item="${esc(item.id)}" ${state.activeId===item.id?'open':''}><summary>${index+1}. ${esc(item.title||'Callout')} (${item.side})</summary><div class="form-group mt-2"><label>Title</label><input class="form-control" data-pa-field="title" maxlength="255" value="${esc(item.title)}"></div><div class="form-group"><label>Description</label><textarea class="form-control" data-pa-field="description" data-pa-rich rows="3">${esc(item.description)}</textarea></div><div class="form-group"><label>Title link (optional)</label><input class="form-control" data-pa-field="url" maxlength="2000" value="${esc(item.url)}" placeholder="#part_keyholder or /page"></div><div class="form-group"><label>Side / image</label><select class="form-control" data-pa-field="side"><option value="left" ${item.side==='left'?'selected':''}>Left</option><option value="right" ${item.side==='right'?'selected':''}>Right</option></select></div><div class="row">${[['x','Point X (%)'],['y','Point Y (%)'],['label_x','Text position X (%)'],['label_y','Text position Y (%)']].map(([key,label])=>`<div class="col-md-6 form-group"><label>${label}</label><input class="form-control" type="number" min="${key==='label_x'?-100:0}" max="100" step="0.1" data-pa-field="${key}" value="${esc(item[key]??0)}"></div>`).join('')}</div><div class="pa-controls"><button type="button" class="btn btn-sm btn-outline-secondary" data-pa-action="duplicate">Duplicate</button><button type="button" class="btn btn-sm btn-outline-danger" data-pa-action="remove">Remove callout</button></div></details>`;
        root.querySelector('[data-pa-form]').innerHTML=`${field('title','Section title (optional)','text','maxlength="255"')}
            <details open><summary>Product images</summary>${image('left_image','Left image')}${image('right_image','Right image')}<details><summary>Mobile images and image descriptions</summary>${image('left_mobile_image','Left image (mobile, optional)')}${image('right_mobile_image','Right image (mobile, optional)')}${field('left_alt','Left image description','text','maxlength="500"')}${field('right_alt','Right image description','text','maxlength="500"')}</details></details>
            <div class="form-group mt-3"><label>Image width within each side (%)</label><input class="form-control" type="number" min="35" max="75" step="1" data-pa-meta="image_width" value="${d.image_width}"><small class="text-muted">The remaining width is used for text. Default: 55% image, 45% text.</small></div><div class="row"><div class="col-6">${field('line_color','Line color','color')}</div><div class="col-6">${field('point_color','Point color','color')}</div></div><label class="d-block"><input type="checkbox" data-pa-meta="pulse" ${d.pulse?'checked':''}> Animate point halos</label>
            <h6 class="mt-3">Callouts</h6><p class="small text-muted">Drag text or an orange point in the preview to position it. Click without dragging to edit. Text position X is an offset within the text column; Y is the vertical position.</p><div data-pa-items>${d.items.map(itemHtml).join('')}</div><div class="pa-controls"><button type="button" class="btn btn-sm btn-outline-primary" data-pa-action="add-left">+ Left callout</button><button type="button" class="btn btn-sm btn-outline-primary" data-pa-action="add-right">+ Right callout</button></div>
            <hr><label class="d-block"><input type="checkbox" data-pa-meta="details_enabled" ${d.details_enabled?'checked':''}> Show lower detail / comparison row</label><div data-pa-details ${d.details_enabled?'':'hidden'}>${image('detail_left_image','Lower left image')}${field('detail_title','Detail title','text','maxlength="255"')}${rich('detail_description','Detail description')}${image('detail_right_image','Lower right image')}</div>`;
        mountRich(root);preview(root);
    }
    window.ProductAnatomyEditor={
        render(id,content,defaults,example){
            const old=states.get(id);old?.observer?.disconnect();for(const entry of old?.rich?.values()||[])entry.editor?.destroy();
            states.set(id,{data:{...copy(defaults),...copy(content),items:(content.items||defaults.items||[]).map(item=>({label_x:0,...copy(item)}))},example:copy(example),rich:new Map(),uploads:new Set(),mode:'desktop',activeId:null});
            return `<div class="pa-editor" data-pa-editor data-block-id="${esc(id)}"><div class="pa-controls"><button type="button" class="btn btn-sm btn-outline-secondary" data-pa-action="example">Load rubber keyholder example</button><span class="pa-editor-error small" data-pa-status role="status" aria-live="polite"></span></div><div class="pa-editor-workspace"><div class="pa-editor-form" data-pa-form></div><aside class="pa-preview-panel"><div class="pa-preview-toolbar"><strong>Live Preview</strong><button type="button" class="btn btn-sm btn-primary" data-pa-mode="desktop" aria-pressed="true">Desktop</button><button type="button" class="btn btn-sm btn-outline-primary" data-pa-mode="mobile" aria-pressed="false">Mobile</button></div><p class="pa-preview-hint">Drag text or orange points. Arrow keys move 1%; Shift + arrow moves 5%. Click text to edit. Changes are previewed before saving.</p><div class="pa-preview-scroll" data-pa-preview-scroll><div class="pa-preview-frame" data-pa-frame><div class="pa-preview-canvas" data-pa-canvas></div></div></div></aside></div></div>`;
        },
        bind(upload,sanitizeHtml){
            uploadImage=upload;if(sanitizeHtml)sanitize=sanitizeHtml;
            document.querySelectorAll('[data-pa-editor]').forEach(root=>{
                if(root.dataset.paBound)return;root.dataset.paBound='1';const state=states.get(root.dataset.blockId);form(root);
                state.observer=new ResizeObserver(()=>requestAnimationFrame(()=>fit(root)));state.observer.observe(root.querySelector('[data-pa-preview-scroll]'));state.observer.observe(root.querySelector('[data-pa-canvas]'));
                root.addEventListener('input',event=>{if(event.target.matches('[data-pa-meta],[data-pa-field]')){
                    const key=event.target.dataset.paMeta,thumbnail=key?root.querySelector(`[data-pa-thumbnail="${key}"]`):null;
                    if(thumbnail){const url=safeUrl(event.target.value);thumbnail.hidden=!url;if(url)thumbnail.src=url;else thumbnail.removeAttribute('src');}
                    preview(root);
                }});
                root.addEventListener('change',event=>{if(event.target.matches('[data-pa-meta],[data-pa-field]')){if(event.target.dataset.paMeta==='details_enabled')root.querySelector('[data-pa-details]').hidden=!event.target.checked;preview(root);}});
                root.addEventListener('click',event=>{
                    const mode=event.target.closest('[data-pa-mode]');if(mode){state.mode=mode.dataset.paMode;root.querySelectorAll('[data-pa-mode]').forEach(b=>{const active=b===mode;b.setAttribute('aria-pressed',String(active));b.classList.toggle('btn-primary',active);b.classList.toggle('btn-outline-primary',!active);});preview(root);return;}
                    const label=event.target.closest('[data-pa-select]');if(label){event.preventDefault();if(!state.suppressLabelClick)focusItem(root,label.dataset.paSelect);return;}
                    if(event.target.closest('[data-pa-canvas] a'))event.preventDefault();
                    const clear=event.target.closest('[data-pa-clear]');if(clear){if(state.uploads.has(clear.dataset.paClear)){error(root,'Wait for the image upload to finish.');return;}pull(root);state.data[clear.dataset.paClear]='';form(root);root.dispatchEvent(new Event('change',{bubbles:true}));return;}
                    const action=event.target.closest('[data-pa-action]')?.dataset.paAction;if(!action)return;pull(root);
                    if(action==='example'){
                        if(state.uploads.size){error(root,'Wait for image uploads to finish.');return;}
                        if((state.data.items.length||state.data.left_image||state.data.right_image)&&!confirm('Replace this anatomy component with the rubber keyholder example?'))return;
                        state.data=copy(state.example);state.activeId=null;
                    }else if(action==='add-left'||action==='add-right'||action==='duplicate'){
                        if(state.data.items.length>=20){error(root,'Maximum 20 callouts.');return;}
                        const source=state.data.items.find(item=>item.id===event.target.closest('[data-pa-item]')?.dataset.paItem);
                        const side=action==='add-right'?'right':'left',count=state.data.items.filter(item=>item.side===side).length;
                        const item=action==='duplicate'?{...copy(source),id:uid()}:{id:uid(),side,title:'',description:'',url:'',x:50,y:Math.min(90,20+count*25),label_x:0,label_y:Math.min(90,20+count*25)};
                        state.data.items.push(item);state.activeId=item.id;
                    }else if(action==='remove'){const id=event.target.closest('[data-pa-item]').dataset.paItem;state.data.items=state.data.items.filter(item=>item.id!==id);state.activeId=null;}
                    error(root,'');form(root);root.dispatchEvent(new Event('change',{bubbles:true}));
                });
                root.addEventListener('change',async event=>{
                    const input=event.target;if(!input.matches('[data-pa-upload]'))return;const file=input.files[0];if(!file)return;
                    const key=input.dataset.paUpload;state.uploads.add(key);input.disabled=true;error(root,'Uploading image…');
                    try{
                        if(!uploadImage)throw Error('Image upload is unavailable.');const url=await uploadImage(file);if(!url)throw Error('The upload did not return an image URL.');
                        if(!root.isConnected||states.get(root.dataset.blockId)!==state)return;
                        const field=root.querySelector(`[data-pa-meta="${key}"]`);field.value=url;field.dispatchEvent(new Event('input',{bubbles:true}));error(root,'Image uploaded.');
                    }catch(reason){error(root,reason.message);}finally{state.uploads.delete(key);input.disabled=false;input.value='';root.querySelectorAll(`[data-pa-upload="${key}"]`).forEach(el=>el.disabled=false);}
                });
                const updatePosition=(item,kind)=>{
                    const row=[...root.querySelectorAll('[data-pa-item]')].find(el=>el.dataset.paItem===item.id);
                    for(const key of kind==='text'?['label_x','label_y']:['x','y'])row.querySelector('[data-pa-field="'+key+'"]').value=item[key];
                    const line=[...root.querySelectorAll('[data-pa-line]')].find(el=>el.dataset.paLine===item.id);
                    if(kind==='text'){
                        const label=[...root.querySelectorAll('[data-pa-select]')].find(el=>el.dataset.paSelect===item.id);
                        label.style.left=item.label_x+'%';label.style.top=item.label_y+'%';
                        line.setAttribute('x1',lineStart(item,state.data));line.setAttribute('y1',item.label_y);
                    }else{
                        const pin=[...root.querySelectorAll('[data-pa-pin]')].find(el=>el.dataset.paPin===item.id);
                        pin.style.left=item.x+'%';pin.style.top=item.y+'%';line.setAttribute('x2',item.x);line.setAttribute('y2',item.y);
                    }
                };
                root.addEventListener('pointerdown',event=>{
                    const target=event.target.closest('[data-pa-pin],[data-pa-select]');if(!target||event.button!==0)return;event.preventDefault();pull(root);
                    const kind=target.hasAttribute('data-pa-select')?'text':'point',id=target.dataset.paSelect||target.dataset.paPin;
                    const item=state.data.items.find(item=>item.id===id);state.activeId=id;
                    const canvas=kind==='text'?target.closest('.pa-text'):target.closest('[data-pa-image-side]');
                    state.drag={target,item,kind,rect:canvas.getBoundingClientRect(),startX:event.clientX,startY:event.clientY,initialX:labelX(item.label_x),initialY:percent(item.label_y),moved:false};target.setPointerCapture(event.pointerId);
                });
                root.addEventListener('pointermove',event=>{
                    const drag=state.drag;if(!drag)return;const rect=drag.rect;if(!rect.width||!rect.height)return;
                    drag.moved ||= Math.abs(event.clientX-drag.startX)+Math.abs(event.clientY-drag.startY)>3;
                    if(!drag.moved)return;
                    if(drag.kind==='text'){
                        drag.item.label_x=labelX(drag.initialX+(event.clientX-drag.startX)/rect.width*100);
                        drag.item.label_y=percent(drag.initialY+(event.clientY-drag.startY)/rect.height*100);
                    }else{
                        drag.item.x=percent((event.clientX-rect.left)/rect.width*100);drag.item.y=percent((event.clientY-rect.top)/rect.height*100);
                    }
                    updatePosition(drag.item,drag.kind);root.dispatchEvent(new Event('input',{bubbles:true}));
                });
                const end=event=>{const drag=state.drag;if(!drag)return;state.drag=null;try{drag.target.releasePointerCapture(event.pointerId);}catch{}
                    state.suppressLabelClick=drag.moved;setTimeout(()=>state.suppressLabelClick=false,0);
                    preview(root);root.dispatchEvent(new Event('change',{bubbles:true}));if(!drag.moved)focusItem(root,drag.item.id);
                };
                root.addEventListener('pointerup',end);root.addEventListener('pointercancel',end);
                root.addEventListener('keydown',event=>{
                    const target=event.target.closest('[data-pa-pin],[data-pa-select]');if(!target)return;
                    const kind=target.hasAttribute('data-pa-select')?'text':'point',id=target.dataset.paSelect||target.dataset.paPin;
                    if(event.key==='Enter'||event.key===' '){event.preventDefault();focusItem(root,id);return;}
                    if(!['ArrowLeft','ArrowRight','ArrowUp','ArrowDown'].includes(event.key))return;event.preventDefault();pull(root);
                    const item=state.data.items.find(item=>item.id===id),step=event.shiftKey?5:1,x=kind==='text'?'label_x':'x',y=kind==='text'?'label_y':'y',clamp=kind==='text'?labelX:percent;
                    if(event.key==='ArrowLeft')item[x]=clamp(item[x]-step);if(event.key==='ArrowRight')item[x]=clamp(item[x]+step);if(event.key==='ArrowUp')item[y]=percent(item[y]-step);if(event.key==='ArrowDown')item[y]=percent(item[y]+step);
                    updatePosition(item,kind);root.dispatchEvent(new Event('change',{bubbles:true}));
                });
            });
        },
        collect:root=>copy(pull(root)),
        validate(){return [...document.querySelectorAll('[data-pa-editor]')].some(root=>states.get(root.dataset.blockId)?.uploads.size)?'Please wait for Product Anatomy image uploads to finish before saving.':null;},
    };
})();
