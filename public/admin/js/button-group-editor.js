(() => {
    'use strict';
    const states = new Map();
    const clone = value => JSON.parse(JSON.stringify(value));
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const uid = () => 'button-'+Array.from(crypto.getRandomValues(new Uint32Array(3)), n=>n.toString(36)).join('-');
    const accepted = '.pdf,.zip,.rar,.7z,.ai,.psd,.eps,.svg,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.jpg,.jpeg,.png,.webp,.gif';
    function item(state, style='solid') {
        return {...clone(state.appearances[style]),id:uid(),text:'',url:'',target:'_self',link_mode:'link',icon:'none',icon_image_url:'',file_path:'',file_name:'',file_size:0};
    }
    function pull(root) {
        const state=states.get(root.dataset.blockId),data=state.data;
        root.querySelectorAll('[data-bge-meta]').forEach(input=>data[input.dataset.bgeMeta]=Number(input.value));
        data.items=[...root.querySelectorAll('[data-bge-item]')].map(row=>{
            const value={id:row.dataset.bgeItem};
            row.querySelectorAll('[data-bge-field]').forEach(input=>{
                value[input.dataset.bgeField]=input.type==='checkbox'?input.checked:input.type==='number'||input.dataset.bgeField==='file_size'?Number(input.value):input.value;
            });
            return value;
        });
        return data;
    }
    function iconHtml(state,button) {
        return button.icon==='upload' ? button.icon_image_url ? '<img src="'+esc(button.icon_image_url)+'" alt="">' : '' : state.icons[button.icon]?.svg||'';
    }
    function preview(root) {
        const state=states.get(root.dataset.blockId),data=pull(root);
        const css=(key,value)=>`--bg-${key}:${esc(value)};`;
        root.querySelector('[data-bge-preview]').innerHTML=`<div class="store-button-group" style="--bg-columns:${data.columns};--bg-mobile-columns:${data.mobile_columns};--bg-gap:${data.gap}px">${data.items.map(button=>`<span class="store-group-button store-group-button--${esc(button.style)}" style="${css('background',button.background_color)}${css('color',button.text_color)}${css('icon-color',button.icon_color)}${css('icon-size',button.icon_size+'px')}${css('border',button.border_color)}${css('radius',button.border_radius+'px')}${css('font',button.font_size+'px')}${css('padding-x',button.padding_x+'px')}${css('padding-y',button.padding_y+'px')}${css('height',button.min_height+'px')}${css('shadow',button.shadow?'0 3px 10px #0003':'none')}">${iconHtml(state,button)?`<span class="bg-icon">${iconHtml(state,button)}</span>`:''}<span class="bg-label">${esc(button.text||'Button text')}</span></span>`).join('')}</div>`;
    }
    function size(bytes) { return bytes ? ` (${(bytes/1024/1024).toFixed(2)} MB)` : ''; }
    function rows(root) {
        const state=states.get(root.dataset.blockId);
        state.sortable?.destroy();
        const list=root.querySelector('[data-bge-list]');
        list.innerHTML=state.data.items.map((button,index)=>{
            const prefix='bge-'+root.dataset.blockId+'-'+button.id;
            const field=(key,label,type='text',attrs='')=>`<div class="col-md-6 form-group"><label for="${esc(prefix+'-'+key)}">${label}</label><input id="${esc(prefix+'-'+key)}" class="form-control" type="${type}" data-bge-field="${key}" value="${esc(button[key])}" ${attrs}></div>`;
            const select=(key,label,options)=>`<div class="col-md-6 form-group"><label for="${esc(prefix+'-'+key)}">${label}</label><select id="${esc(prefix+'-'+key)}" class="form-control" data-bge-field="${key}">${Object.entries(options).map(([value,text])=>`<option value="${value}" ${button[key]===value?'selected':''}>${esc(text)}</option>`).join('')}</select></div>`;
            const upload=state.uploads.get(button.id)||{},iconUpload=state.uploads.get(button.id+':icon')||{};
            return `<div class="bge-item" data-bge-item="${esc(button.id)}"><div class="bge-tools"><button type="button" class="btn btn-sm btn-light bge-handle" aria-label="Drag button">☰</button><strong>Button ${index+1}</strong><button type="button" class="btn btn-sm btn-light" data-bge-action="up" ${index===0?'disabled':''} aria-label="Move button up">↑</button><button type="button" class="btn btn-sm btn-light" data-bge-action="down" ${index===state.data.items.length-1?'disabled':''} aria-label="Move button down">↓</button><button type="button" class="btn btn-sm btn-outline-secondary" data-bge-action="duplicate">Duplicate</button><button type="button" class="btn btn-sm btn-outline-danger" data-bge-action="remove">Remove</button></div>
                <div class="form-group"><label for="${esc(prefix)}-text">Button text</label><textarea id="${esc(prefix)}-text" class="form-control" data-bge-field="text" maxlength="1000" rows="2" placeholder="Button text (multiple lines supported)">${esc(button.text)}</textarea></div>
                <div class="row">${field('font_size','Button text size (px)','number','min="12" max="48" step="1"')}</div>
                <div class="row">${select('link_mode','Action type',{link:'Link',download:'Download file'})}${select('style','Appearance',{solid:'Solid button',card:'White card with shadow'})}</div>
                <div data-bge-normal ${button.link_mode==='download'?'hidden':''}><div class="row">${field('url','Destination URL','text','maxlength="2000" placeholder="/products/acrylic or https://..."')}${select('target','Open link in',{_self:'Same tab',_blank:'New tab'})}</div></div>
                <div class="form-group" data-bge-download ${button.link_mode==='download'?'':'hidden'}><label for="${esc(prefix)}-upload">Download file</label><input id="${esc(prefix)}-upload" class="form-control-file" type="file" data-bge-upload accept="${accepted}" ${upload.busy?'disabled':''}><small class="d-block text-muted">Maximum file size is 100 MB. Click the file picker to replace the current file. Save and publish to apply it.</small><div class="bge-file-name" data-bge-file-name>${esc(button.file_name)}${size(button.file_size)}</div><button type="button" class="btn btn-sm btn-outline-danger mt-1" data-bge-action="remove-file" ${button.file_path?'':'hidden'} ${upload.busy?'disabled':''}>Remove file</button><div class="bge-status" data-bge-upload-status role="status" aria-live="polite">${esc(upload.message||'')}</div></div>
                ${['file_path','file_name','file_size'].map(key=>`<input type="hidden" data-bge-field="${key}" value="${esc(button[key])}">`).join('')}
                <div class="row">${select('icon','Icon',Object.fromEntries(Object.entries(state.icons).map(([key,value])=>[key,value.label])))}${field('icon_size','Icon size (px)','number','min="12" max="120" step="1"')}<div class="col-12 form-group"><label>Icon preview</label><div class="bge-icon-preview" data-bge-icon-preview>${iconHtml(state,button)||'No icon'}</div></div></div>
                <div class="form-group" data-bge-icon-upload ${button.icon==='upload'?'':'hidden'}><label for="${esc(prefix)}-icon-upload">Icon image</label><input id="${esc(prefix)}-icon-upload" type="file" class="form-control-file" data-bge-icon-file accept=".jpg,.jpeg,.png,.webp,.gif,.svg" ${iconUpload.busy?'disabled':''}><small class="d-block text-muted">PNG, JPG, WebP, GIF or SVG, up to 10 MB. Transparent PNG or SVG is recommended. Uploaded images keep their original colors.</small><img class="bge-uploaded-icon" data-bge-icon-image ${button.icon_image_url?'src="'+esc(button.icon_image_url)+'"':'hidden'} alt="Uploaded icon preview"><button type="button" class="btn btn-sm btn-outline-danger" data-bge-action="remove-icon" ${button.icon_image_url?'':'hidden'} ${iconUpload.busy?'disabled':''}>Remove icon image</button><div class="bge-status" data-bge-icon-status role="status" aria-live="polite">${esc(iconUpload.message||'')}</div></div><input type="hidden" data-bge-field="icon_image_url" value="${esc(button.icon_image_url)}">
                <details><summary>Appearance settings</summary><p class="small text-muted">Selecting an Appearance preset resets these settings. Each button can have its own colors and size.</p><div class="row">${field('background_color','Background color','color')}${field('text_color','Text color','color')}${field('icon_color','Icon color','color')}${field('border_color','Border color','color')}${field('border_radius','Border radius (px)','number','min="0" max="999" step="1"')}${field('padding_x','Horizontal padding (px)','number','min="0" max="80" step="1"')}${field('padding_y','Vertical padding (px)','number','min="0" max="80" step="1"')}${field('min_height','Minimum height (px)','number','min="32" max="300" step="1"')}</div><label><input type="checkbox" data-bge-field="shadow" ${button.shadow?'checked':''}> Show shadow</label></details></div>`;
        }).join('');
        if(window.Sortable)state.sortable=new Sortable(list,{handle:'.bge-handle',draggable:'.bge-item',animation:150,forceFallback:true,fallbackOnBody:true,scroll:true,bubbleScroll:true,scrollSensitivity:80,scrollSpeed:14,onEnd:()=>{pull(root);rows(root);root.dispatchEvent(new Event('change',{bubbles:true}));}});
        preview(root);
    }
    function notify(root) { root.dispatchEvent(new Event('change',{bubbles:true})); }
    window.ButtonGroupEditor={
        render(id,content,defaults,appearances,icons,isCms) {
            states.get(id)?.sortable?.destroy();
            const state={appearances:clone(appearances),icons,data:{...clone(defaults),...clone(content)},uploads:new Map()};
            if(!Array.isArray(content.items)){
                const legacy=item(state);
                Object.assign(legacy,{text:content.text||'',url:content.url||'',icon:isCms?'none':'cart'});
                for(const key of ['background_color','text_color'])if(/^#[0-9a-f]{6}$/i.test(content[key]||''))legacy[key]=content[key];
                if(content.border_radius!==undefined)legacy.border_radius=Math.max(0,Math.min(999,Number(content.border_radius)||0));
                state.data={...clone(defaults),columns:content.text||content.url?1:2,items:content.text||content.url?[legacy]:[]};
            }else state.data.items=content.items.map(button=>({...item(state,button.style==='card'?'card':'solid'),...clone(button)}));
            states.set(id,state);
            const options=(key,label,values)=>`<div class="col-md-4 form-group"><label>${label}</label><select class="form-control" data-bge-meta="${key}">${values.map(n=>`<option value="${n}" ${Number(state.data[key])===n?'selected':''}>${n}</option>`).join('')}</select></div>`;
            return `<div class="button-group-editor" data-bge-editor data-block-id="${esc(id)}"><div class="row">${options('columns','Buttons per row (desktop)',[1,2,3,4])}${options('mobile_columns','Buttons per row (mobile)',[1,2])}<div class="col-md-4 form-group"><label>Gap (px)</label><input class="form-control" type="number" min="0" max="80" step="1" data-bge-meta="gap" value="${esc(state.data.gap)}"></div></div><div class="bge-preview" data-bge-preview></div><div class="bge-error" role="alert"></div><div data-bge-list></div><button type="button" class="btn btn-sm btn-outline-primary" data-bge-action="add">+ Add button</button></div>`;
        },
        bind(apiBase,csrf,uploadImage) {
            document.querySelectorAll('[data-bge-editor]').forEach(root=>{
                if(root.dataset.bgeBound)return;
                root.dataset.bgeBound='1';rows(root);
                root.addEventListener('input',event=>{if(event.target.matches('[data-bge-meta],[data-bge-field]'))preview(root);});
                root.addEventListener('change',event=>{
                    if(event.target.matches('[data-bge-field="style"]')){
                        const data=pull(root),id=event.target.closest('[data-bge-item]').dataset.bgeItem,button=data.items.find(b=>b.id===id);
                        Object.assign(button,states.get(root.dataset.blockId).appearances[button.style]);rows(root);
                    }else if(event.target.matches('[data-bge-field="link_mode"]')){
                        const row=event.target.closest('[data-bge-item]'),download=event.target.value==='download';row.querySelector('[data-bge-normal]').hidden=download;row.querySelector('[data-bge-download]').hidden=!download;
                    }else if(event.target.matches('[data-bge-field="icon"]')){
                        const row=event.target.closest('[data-bge-item]'),state=states.get(root.dataset.blockId);
                        pull(root);row.querySelector('[data-bge-icon-upload]').hidden=event.target.value!=='upload';
                        row.querySelector('[data-bge-icon-preview]').innerHTML=iconHtml(state,state.data.items.find(button=>button.id===row.dataset.bgeItem))||'No icon';
                    }
                    if(event.target.matches('[data-bge-meta],[data-bge-field]'))preview(root);
                });
                root.addEventListener('click',event=>{
                    const action=event.target.closest('[data-bge-action]')?.dataset.bgeAction;if(!action)return;
                    const state=states.get(root.dataset.blockId),data=pull(root),id=event.target.closest('[data-bge-item]')?.dataset.bgeItem,index=data.items.findIndex(b=>b.id===id);
                    if(action==='add'||action==='duplicate'){
                        if(data.items.length>=50){root.querySelector('.bge-error').textContent='Maximum 50 buttons per group.';return;}
                        const value=action==='duplicate'?{...clone(data.items[index]),id:uid()}:item(state);
                        if(action==='duplicate')data.items.splice(index+1,0,value);else data.items.push(value);
                    }else if(action==='remove')data.items.splice(index,1);
                    else if(action==='remove-icon'){Object.assign(data.items[index],{icon:'none',icon_image_url:''});state.uploads.delete(id+':icon');}
                    else if(action==='remove-file'){Object.assign(data.items[index],{file_path:'',file_name:'',file_size:0});state.uploads.delete(id);}
                    else if(action==='up'||action==='down'){
                        const next=index+(action==='up'?-1:1);if(index<0||next<0||next>=data.items.length)return;[data.items[index],data.items[next]]=[data.items[next],data.items[index]];
                    }
                    root.querySelector('.bge-error').textContent='';rows(root);notify(root);
                });
                root.addEventListener('change',async event=>{
                    if(!event.target.matches('[data-bge-icon-file]'))return;
                    const input=event.target,file=input.files[0];if(!file)return;
                    const state=states.get(root.dataset.blockId),id=input.closest('[data-bge-item]').dataset.bgeItem,key=id+':icon';
                    const show=message=>{const row=[...root.querySelectorAll('[data-bge-item]')].find(row=>row.dataset.bgeItem===id);if(row)row.querySelector('[data-bge-icon-status]').textContent=message;};
                    if(file.size>10*1024*1024){show('Maximum icon image size is 10 MB.');input.value='';return;}
                    pull(root);state.uploads.set(key,{busy:true,message:'Uploading icon…'});input.disabled=true;input.closest('[data-bge-item]').querySelector('[data-bge-action="remove-icon"]').disabled=true;show('Uploading icon…');
                    try{
                        if(!uploadImage)throw Error('Image upload is unavailable.');
                        const url=await uploadImage(file);if(!url||typeof url!=='string')throw Error('The upload did not return an image URL.');
                        if(!root.isConnected||states.get(root.dataset.blockId)!==state)return;
                        pull(root);const button=state.data.items.find(button=>button.id===id);if(button)button.icon_image_url=url;
                        state.uploads.set(key,{busy:false,message:'Icon image uploaded.'});rows(root);notify(root);
                    }catch(error){state.uploads.set(key,{busy:false,message:error.message});show(error.message);}
                    finally{const status=state.uploads.get(key);if(status)status.busy=false;input.disabled=false;input.value='';const row=[...root.querySelectorAll('[data-bge-item]')].find(row=>row.dataset.bgeItem===id);if(row)row.querySelector('[data-bge-action="remove-icon"]').disabled=false;}
                });
                root.addEventListener('change',async event=>{
                    if(!event.target.matches('[data-bge-upload]'))return;
                    const file=event.target.files[0];if(!file)return;
                    const input=event.target,state=states.get(root.dataset.blockId),id=input.closest('[data-bge-item]').dataset.bgeItem;
                    const show=message=>{const row=[...root.querySelectorAll('[data-bge-item]')].find(row=>row.dataset.bgeItem===id);if(row)row.querySelector('[data-bge-upload-status]').textContent=message;};
                    if(file.size>100*1024*1024){show('Maximum file size is 100 MB.');input.value='';return;}
                    pull(root);state.uploads.set(id,{busy:true,message:'Uploading…'});input.disabled=true;show('Uploading…');
                    input.closest('[data-bge-item]').querySelector('[data-bge-action="remove-file"]').disabled=true;
                    try{
                        const body=new FormData();body.append('file',file);
                        const response=await fetch(apiBase+'/files',{method:'POST',credentials:'same-origin',headers:{'X-CSRF-TOKEN':csrf,Accept:'application/json'},body});
                        const result=await response.json();
                        if(!response.ok)throw Error(Object.values(result.errors||{}).flat().join(' ')||result.message||'Upload failed.');
                        if(!result.data?.path)throw Error('The upload did not return a file path.');
                        if(!root.isConnected||states.get(root.dataset.blockId)!==state)return;
                        pull(root);const button=state.data.items.find(b=>b.id===id);
                        if(button)Object.assign(button,{file_path:result.data.path,file_name:result.data.original_name||file.name,file_size:file.size});
                        state.uploads.set(id,{busy:false,message:'File uploaded.'});rows(root);notify(root);
                    }catch(error){state.uploads.set(id,{busy:false,message:error.message});show(error.message);}
                    finally{const upload=state.uploads.get(id);if(upload)upload.busy=false;input.disabled=false;input.value='';const row=[...root.querySelectorAll('[data-bge-item]')].find(row=>row.dataset.bgeItem===id);if(row)row.querySelector('[data-bge-action="remove-file"]').disabled=false;}
                });
            });
        },
        collect:root=>clone(pull(root)),
        validate(){
            for(const root of document.querySelectorAll('[data-bge-editor]')){
                const state=states.get(root.dataset.blockId);
                if([...state.uploads.values()].some(upload=>upload.busy))return 'Please wait for button file uploads to finish before saving.';
                const data=pull(root);
                for(let i=0;i<data.items.length;i++){
                    const button=data.items[i];if(!button.text.trim())return `Enter text for button ${i+1}.`;
                    if(button.link_mode==='download'&&!button.file_path)return `Upload a file for button ${i+1} before saving.`;
                    if(button.icon==='upload'&&!button.icon_image_url?.trim())return `Upload an icon image for button ${i+1} before saving.`;
                    if(button.link_mode==='link'&&!button.url.trim())return `Enter a destination URL for button ${i+1}.`;
                }
            }
            return null;
        },
    };
})();
