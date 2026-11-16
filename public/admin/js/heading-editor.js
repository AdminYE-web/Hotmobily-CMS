(() => {
    'use strict';
    const api='/api/v1/admin/heading-presets',states=new Map();
    const esc=value=>String(value??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const clone=value=>JSON.parse(JSON.stringify(value));
    let presets=[],pending,csrf='';
    async function request(url,method='GET',body){
        const response=await fetch(url,{method,credentials:'same-origin',headers:{Accept:'application/json','X-CSRF-TOKEN':csrf,...(body?{'Content-Type':'application/json'}:{})},...(body?{body:JSON.stringify(body)}:{})});
        const result=await response.json();if(!response.ok)throw Error(Object.values(result.errors||{}).flat().join(' ')||result.message||'Preset request failed.');return result.data;
    }
    function options(){
        document.querySelectorAll('[data-he-presets]').forEach(select=>{
            const current=select.value;
            select.innerHTML='<option value="">Choose a saved style…</option>'+presets.map(p=>`<option value="${p.id}">${esc(p.name)}</option>`).join('');
            select.value=current;
        });
    }
    function refresh(force=false){
        if(!pending||force)pending=request(api).then(data=>{presets=data;options();}).catch(error=>{pending=null;throw error;});
        return pending;
    }
    function pull(root){
        const data={text:root.querySelector('[data-he-text]').value,heading_style:{}};
        const date=root.querySelector('[data-he-date]');if(date)data.updated_date=date.value;
        root.querySelectorAll('[data-he-style]').forEach(input=>data.heading_style[input.dataset.heStyle]=input.type==='checkbox'?input.checked:input.type==='number'?Number(input.value):input.value);
        return data;
    }
    function preview(root){
        const data=pull(root),s=data.heading_style,heading=root.querySelector('[data-he-preview]');
        heading.textContent=data.text||'Heading preview';
        for(const [key,value] of Object.entries({'align':s.alignment,'background':s.background_color,'color':s.text_color,'line-color':s.underline_color,'line-width':(s.show_underline?s.underline_width:0)+'px'}))heading.style.setProperty('--heading-'+key,value);
    }
    function status(root,text,error=false){const box=root.querySelector('[data-he-status]');box.textContent=text;box.classList.toggle('he-error',error);}
    window.HeadingEditor={
        render(id,content,defaults,isCms){
            const style={...clone(defaults),...(content.heading_style||{})};
            if(!content.heading_style&&isCms){style.background_color=/^#[0-9a-f]{6}$/i.test(content.background_color||'')?content.background_color:'#f58214';style.text_color='#ffffff';style.alignment='left';style.show_underline=false;}
            states.set(id,{busy:false});
            const color=(key,label)=>`<div class="col-md-4 form-group"><label for="he-${esc(id)}-${key}">${label}</label><input id="he-${esc(id)}-${key}" type="color" class="form-control" data-he-style="${key}" value="${esc(style[key])}"></div>`;
            return `<div class="heading-editor" data-he-editor data-block-id="${esc(id)}"><div class="form-group"><label for="he-${esc(id)}-text">Heading</label><input id="he-${esc(id)}-text" class="form-control" data-he-text maxlength="1000" value="${esc(content.text||'')}"></div>${isCms?`<div class="form-group"><label>Date</label><input class="form-control" data-he-date maxlength="100" value="${esc(content.updated_date||'')}"></div>`:''}
                <div class="he-preset"><strong>Heading style presets</strong><div class="he-tools"><input class="form-control" data-he-name maxlength="150" aria-label="Preset name" placeholder="Preset name"><button type="button" class="btn btn-sm btn-outline-primary" data-he-action="save">Save as preset</button></div><div class="he-tools"><select class="form-control" data-he-presets aria-label="Saved styles"><option value="">Choose a saved style…</option></select><button type="button" class="btn btn-sm btn-outline-primary" data-he-action="load">Load preset</button><button type="button" class="btn btn-sm btn-outline-secondary" data-he-action="update">Update preset</button><button type="button" class="btn btn-sm btn-outline-danger" data-he-action="delete">Delete preset</button></div><small class="text-muted">Presets save appearance only. Loading preserves the heading text and date. Save and publish the product to apply the loaded style. Editing a loaded copy does not change other products.</small><div class="he-status" data-he-status role="status" aria-live="polite"></div></div>
                <div class="row"><div class="col-md-6 form-group"><label>Text alignment</label><select class="form-control" data-he-style="alignment">${Object.entries({left:'Left',center:'Center',right:'Right'}).map(([key,label])=>`<option value="${key}" ${style.alignment===key?'selected':''}>${label}</option>`).join('')}</select></div><div class="col-md-6 form-group"><label>Underline thickness (px)</label><input type="number" class="form-control" data-he-style="underline_width" min="1" max="12" step="1" value="${esc(style.underline_width)}"></div>${color('background_color','Background color')}${color('text_color','Text color')}${color('underline_color','Underline color')}</div><label><input type="checkbox" data-he-style="show_underline" ${style.show_underline?'checked':''}> Show underline</label><div class="he-preview"><div class="store-heading store-heading--custom" data-he-preview></div></div></div>`;
        },
        bind(token){
            csrf=token;
            document.querySelectorAll('[data-he-editor]').forEach(root=>{
                if(root.dataset.heBound)return;root.dataset.heBound='1';
                const select=root.querySelector('[data-he-presets]');select.innerHTML='<option value="">Choose a saved style…</option>'+presets.map(p=>`<option value="${p.id}">${esc(p.name)}</option>`).join('');
                refresh().catch(error=>status(root,'Could not load presets: '+error.message,true));preview(root);
                root.addEventListener('input',()=>preview(root));root.addEventListener('change',()=>preview(root));
                root.addEventListener('click',async event=>{
                    const action=event.target.closest('[data-he-action]')?.dataset.heAction;if(!action)return;
                    const state=states.get(root.dataset.blockId);if(state.busy)return;
                    const id=select.value,selected=presets.find(p=>String(p.id)===id),name=root.querySelector('[data-he-name]');
                    state.busy=true;root.querySelectorAll('[data-he-action]').forEach(b=>b.disabled=true);status(root,'');
                    try{
                        if(action!=='save'&&!selected)throw Error('Choose a saved style first.');
                        if(action==='save'||action==='update'){
                            if(action==='save'&&!name.value.trim())throw Error('Enter a preset name.');
                            if(action==='update'&&!confirm(`Update preset "${selected.name}"? Existing product content will stay unchanged.`))return;
                            const result=await request(action==='save'?api:api+'/'+id,action==='save'?'POST':'PUT',{name:name.value.trim()||selected.name,content:pull(root).heading_style});
                            await refresh(true);select.value=String(result.id);name.value='';status(root,'Preset saved. Available in other products.');
                        }else if(action==='load'){
                            const result=await request(api+'/'+id);
                            root.querySelectorAll('[data-he-style]').forEach(input=>{const value=result.content_json[input.dataset.heStyle];if(input.type==='checkbox')input.checked=Boolean(value);else input.value=value;});
                            preview(root);root.dispatchEvent(new Event('change',{bubbles:true}));status(root,'Style loaded. Heading text is unchanged. Save and publish to apply it.');
                        }else if(action==='delete'){
                            if(!confirm(`Delete preset "${selected.name}"? Existing product headings will stay unchanged.`))return;
                            await request(api+'/'+id,'DELETE');await refresh(true);status(root,'Preset deleted. Existing headings are unchanged.');
                        }
                    }catch(error){status(root,error.message,true);}finally{state.busy=false;root.querySelectorAll('[data-he-action]').forEach(b=>b.disabled=false);}
                });
            });
        },
        collect:pull,
    };
})();
