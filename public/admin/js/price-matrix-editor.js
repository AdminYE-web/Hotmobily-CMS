(() => {
    const states = new Map();
    const descriptionEditors = new Map();
    const clone = value => JSON.parse(JSON.stringify(value));
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[c]));
    const uid = () => 'opt_' + [...crypto.getRandomValues(new Uint8Array(12))].map(x=>x.toString(16).padStart(2,'0')).join('');
    const meta = {title:'Section title', table_title:'Table title', note:'Note / tax / currency', empty_message:'Empty state message'};
    function prepareDescription(data) {
        if (data.description_format !== 'html') {
            data.description = data.description ? '<p>' + esc(data.description).replace(/\r?\n/g, '<br>') + '</p>' : '';
            data.description_format = 'html';
        }
    }
    function initDescription(root) {
        const id = root.dataset.blockId;
        const textarea = root.querySelector('[data-pm-meta="description"]');
        const previous = descriptionEditors.get(id);
        if (!textarea || previous?.textarea === textarea || !window.ClassicEditor) return;
        previous?.editor?.destroy();
        const entry = {textarea, editor:null};
        descriptionEditors.set(id, entry);
        ClassicEditor.create(textarea, {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo'],
            link: {defaultProtocol:'https://', addTargetToExternalLinks:true},
        }).then(editor => {
            if (descriptionEditors.get(id) !== entry || !textarea.isConnected) {
                editor.destroy();
                return;
            }
            entry.editor = editor;
            editor.setData(textarea.value);
            editor.model.document.on('change:data', () => {
                textarea.value = editor.getData();
                textarea.dispatchEvent(new Event('input', {bubbles:true}));
            });
            textarea.value = editor.getData();
        }).catch(error => {
            descriptionEditors.delete(id);
            console.error('Price Matrix Description CKEditor error:', error);
        });
    }
    function upgrade(data) {
        if (!Array.isArray(data.option_groups)) {
            data.option_groups = [
                {id:'delivery', label:data.delivery_label, options:data.deliveries, default_option:data.default_delivery},
                {id:'print', label:data.print_label, options:data.prints, default_option:data.default_print},
            ];
            data.variants = data.variants.map(v=>({selections:{delivery:v.delivery_id,print:v.print_id},rows:v.rows}));
        }
        data.option_groups.forEach(group=>{
            if (!group.options.some(o=>o.id===group.default_option)) group.default_option=group.options[0].id;
        });
        for (const key of ['deliveries','prints','delivery_label','print_label','default_delivery','default_print']) delete data[key];
        prepareDescription(data);
        return data;
    }
    const matches = (state, variant) => state.data.option_groups.every(g=>variant.selections[g.id]===state.selected[g.id]);
    function activeVariant(state) {
        let variant=state.data.variants.find(v=>matches(state,v));
        if(!variant){
            state.data.variants=state.data.variants.filter(v=>v.rows.length);
            variant={selections:{...state.selected},rows:[]};
            state.data.variants.push(variant);
        }
        return variant;
    }
    function pull(root) {
        const state=states.get(root.dataset.blockId),data=state.data;
        root.querySelectorAll('[data-pm-meta]').forEach(el=>data[el.dataset.pmMeta]=el.value);
        root.querySelectorAll('[data-pm-dimension]').forEach(element=>{
            const group=data.option_groups.find(g=>g.id===element.dataset.pmDimension);
            group.label=element.querySelector('[data-pm-group-label]').value;
            group.options=[...element.querySelectorAll('.pm-option')].map(row=>({id:row.dataset.optionId,label:row.querySelector('[data-pm-label]').value}));
            group.default_option=element.querySelector('input[type=radio]:checked')?.value||group.options[0].id;
        });
        data.sizes=[...root.querySelectorAll('[data-pm-group="sizes"] .pm-option')].map(row=>({id:row.dataset.optionId,label:row.querySelector('[data-pm-label]').value}));
        activeVariant(state).rows=[...root.querySelectorAll('[data-pm-row]')].map(tr=>({
            quantity:tr.querySelector('[data-pm-quantity]').value,
            prices:Object.fromEntries([...tr.querySelectorAll('[data-pm-price]')].map(input=>[input.dataset.pmPrice,input.value===''?null:input.value])),
        }));
        return data;
    }
    const selectOptions=(items,selected)=>items.map(item=>`<option value="${esc(item.id)}" ${item.id===selected?'selected':''}>${esc(item.label)}</option>`).join('');
    function optionRows(id, group, sizes=false) {
        const items=sizes?group:group.options;
        return items.map((item,index)=>`<div class="pm-option" data-option-id="${esc(item.id)}">
            ${sizes?'':`<input type="radio" aria-label="Default ${esc(item.label)}" name="pm-${esc(id)}-${esc(group.id)}" value="${esc(item.id)}" ${group.default_option===item.id?'checked':''}>`}
            <input class="form-control form-control-sm" data-pm-label value="${esc(item.label)}" maxlength="255" aria-label="Option label ${index+1}">
            <button type="button" class="btn btn-sm btn-light" data-pm-action="up-option" title="Move up" ${index===0?'disabled':''}>↑</button>
            <button type="button" class="btn btn-sm btn-light" data-pm-action="down-option" title="Move down" ${index===items.length-1?'disabled':''}>↓</button>
            <button type="button" class="btn btn-sm btn-outline-danger" data-pm-action="remove-option" title="Remove option" ${items.length===1?'disabled':''}>×</button>
        </div>`).join('')+`<button type="button" class="btn btn-sm btn-outline-secondary" data-pm-action="add-option" ${items.length>=20?'disabled':''}>+ Add option</button>`;
    }
    function contents(id) {
        const state=states.get(id),data=state.data,current=activeVariant(state);
        return `<div class="pm-editor-error" role="alert" hidden></div>
            <div class="pm-editor-toolbar"><strong>Price Matrix</strong><button type="button" class="btn btn-sm btn-outline-primary" data-pm-action="preset">Load Acrylic prices</button>
            <small>Reference: <a href="https://hotmobily.jp/products/acrylic/" target="_blank" rel="noopener">Acrylic</a> · captured 2026-10-15. Review prices before publishing.</small></div>
            <div class="row">${Object.entries(meta).map(([key,label])=>`<div class="col-md-6 form-group"><label>${label}</label><input class="form-control" data-pm-meta="${key}" maxlength="2000" value="${esc(data[key])}"></div>`).join('')}</div>
            <div class="form-group pm-description-field"><label for="pm-description-${esc(id)}">Description</label><textarea id="pm-description-${esc(id)}" class="form-control" data-pm-meta="description" rows="6" maxlength="50000">${esc(data.description)}</textarea></div>
            <div class="pm-editor-toolbar"><h5>Option groups</h5><button type="button" class="btn btn-sm btn-outline-primary" data-pm-action="add-group" ${data.option_groups.length>=12?'disabled':''}>+ Add option group</button></div>
            <small class="d-block text-muted">Create groups such as Delivery, Print, or Material. Radio buttons select the storefront defaults. Up to 12 groups and 20 options per group.</small>
            <div class="pm-dimensions">${data.option_groups.map((group,index)=>`<div class="pm-dimension" data-pm-dimension="${esc(group.id)}">
                <label>Group label<input class="form-control" data-pm-group-label value="${esc(group.label)}" maxlength="255"></label>
                <div class="pm-editor-toolbar"><button type="button" class="btn btn-sm btn-light" data-pm-action="up-group" ${index===0?'disabled':''}>Move up</button><button type="button" class="btn btn-sm btn-light" data-pm-action="down-group" ${index===data.option_groups.length-1?'disabled':''}>Move down</button><button type="button" class="btn btn-sm btn-outline-danger" data-pm-action="remove-group">Remove group</button></div>
                ${optionRows(id,group)}
            </div>`).join('')}</div>
            <div data-pm-group="sizes"><h5>Size columns</h5>${optionRows(id,data.sizes,true)}</div>
            <hr><h5>Edit prices for this combination</h5>
            <div class="pm-editor-toolbar">${data.option_groups.map(group=>`<label class="pm-combination-select">${esc(group.label)}<select class="form-control" data-pm-select="${esc(group.id)}" aria-label="Edit ${esc(group.label)}">${selectOptions(group.options,state.selected[group.id])}</select></label>`).join('')}
                ${data.option_groups.length?'':'<span>No option groups. Edit the base price table below.</span>'}
                <label class="pm-combination-select">Copy prices from<select class="form-control" data-pm-copy aria-label="Copy prices from"><option value="">Copy from another combination…</option>${data.variants.map((v,i)=>v===current||!v.rows.length?'':`<option value="${i}">${esc(data.option_groups.map(g=>g.options.find(o=>o.id===v.selections[g.id])?.label).join(' / '))}</option>`).join('')}</select></label><button type="button" class="btn btn-sm btn-outline-secondary" data-pm-action="copy">Copy</button>
            </div>
            <small class="form-text text-muted mb-2">Edit column headings directly in the header row.</small>
            <div class="table-responsive"><table class="table table-bordered mb-2"><thead><tr>
                <th><input class="form-control form-control-sm" data-pm-meta="quantity_label" value="${esc(data.quantity_label)}" maxlength="255" aria-label="Quantity column heading"></th>
                ${data.sizes.map(s=>`<th data-pm-size-header="${esc(s.id)}"><input class="form-control form-control-sm" data-pm-size-label="${esc(s.id)}" value="${esc(s.label)}" maxlength="255" aria-label="Size column heading ${esc(s.label)}"></th>`).join('')}
                <th><input class="form-control form-control-sm" data-pm-meta="actions_label" value="${esc(data.actions_label)}" maxlength="255" aria-label="Actions column heading"></th>
            </tr></thead><tbody>${current.rows.map((row,i)=>`<tr data-pm-row="${i}"><td><input type="number" min="1" max="1000000" step="1" class="form-control form-control-sm" aria-label="Quantity ${i+1}" data-pm-quantity value="${esc(row.quantity)}"></td>
                ${data.sizes.map(s=>`<td><input type="number" min="0" max="999999999.99" step="0.01" class="form-control form-control-sm" aria-label="Price ${i+1} ${esc(s.label)}" data-pm-price="${esc(s.id)}" value="${esc(row.prices[s.id])}"></td>`).join('')}
                <td class="text-nowrap"><button type="button" class="btn btn-sm btn-light" data-pm-action="up-row" ${i===0?'disabled':''} title="Move row up">↑</button><button type="button" class="btn btn-sm btn-light" data-pm-action="down-row" ${i===current.rows.length-1?'disabled':''} title="Move row down">↓</button><button type="button" class="btn btn-sm btn-outline-danger" data-pm-action="remove-row" title="Remove row">×</button></td></tr>`).join('')}</tbody></table></div>
            <button type="button" class="btn btn-sm btn-outline-primary" data-pm-action="add-row">+ Add quantity row</button>
            <small class="form-text text-muted">Enter unit prices. Press Enter to move down in the same column. At the last row, Enter adds a new row. Blank cells display —; 0 is a valid price. Each combination can have different quantities. Up to 500 priced combinations.</small>`;
    }
    function refresh(root) {
        const id=root.dataset.blockId,field=root.querySelector('.pm-description-field'),entry=descriptionEditors.get(id),description=states.get(id).data.description;
        field?.remove();root.innerHTML=contents(id);
        if(field){root.querySelector('.pm-description-field').replaceWith(field);if(entry?.editor){if(entry.editor.getData()!==description)entry.editor.setData(description);}else field.querySelector('textarea').value=description;}
        initDescription(root);
    }
    function resetSelection(state) {state.selected=Object.fromEntries(state.data.option_groups.map(g=>[g.id,g.default_option]));}
    function insertRow(state, index) {
        const rows=activeVariant(state).rows;
        if(rows.length>=100)throw Error('Maximum 100 rows per combination.');
        if(!rows.length&&state.data.variants.filter(v=>v.rows.length).length>=500)throw Error('Maximum 500 priced combinations.');
        rows.splice(index,0,{quantity:'',prices:{}});
    }
    function bind() {
        document.querySelectorAll('[data-pm-editor]').forEach(root=>{
            initDescription(root);if(root.dataset.pmBound)return;root.dataset.pmBound='1';
            root.addEventListener('keydown',event=>{
                if(event.key!=='Enter'||event.isComposing||event.ctrlKey||event.altKey||event.metaKey||event.shiftKey)return;
                if(!event.target.matches('[data-pm-quantity], [data-pm-price]'))return;
                event.preventDefault();
                if(event.repeat)return;
                const state=states.get(root.dataset.blockId);
                const currentRow=event.target.closest('[data-pm-row]');
                const index=Number(currentRow.dataset.pmRow)+1;
                const column=[...currentRow.querySelectorAll('[data-pm-quantity], [data-pm-price]')].indexOf(event.target);
                const nextRow=currentRow.nextElementSibling;
                if(nextRow){
                    nextRow.querySelectorAll('[data-pm-quantity], [data-pm-price]')[column].focus();
                    return;
                }
                try {
                    pull(root);insertRow(state,index);refresh(root);
                    root.querySelectorAll('[data-pm-row]')[index].querySelectorAll('[data-pm-quantity], [data-pm-price]')[column].focus();
                    root.dispatchEvent(new Event('change',{bubbles:true}));
                }catch(error){const box=root.querySelector('.pm-editor-error');box.hidden=false;box.textContent=error.message;}
            });
            root.addEventListener('input',event=>{
                if(event.target.matches('[data-pm-size-label]')){
                    root.querySelectorAll('[data-pm-group="sizes"] [data-option-id]').forEach(row=>{if(row.dataset.optionId===event.target.dataset.pmSizeLabel)row.querySelector('[data-pm-label]').value=event.target.value;});
                }else if(event.target.matches('[data-pm-group="sizes"] [data-pm-label]')){
                    const id=event.target.closest('[data-option-id]').dataset.optionId;
                    root.querySelectorAll('[data-pm-size-label]').forEach(input=>{if(input.dataset.pmSizeLabel===id)input.value=event.target.value;});
                }
            });
            root.addEventListener('change',event=>{
                const state=states.get(root.dataset.blockId);pull(root);
                if(event.target.matches('[data-pm-select]')){state.selected[event.target.dataset.pmSelect]=event.target.value;refresh(root);}
                else if(event.target.matches('[data-pm-label], [data-pm-group-label]'))refresh(root);
            });
            root.addEventListener('click',async event=>{
                const button=event.target.closest('[data-pm-action]');if(!button||button.disabled)return;
                const state=states.get(root.dataset.blockId),data=pull(root),action=button.dataset.pmAction;
                const dimension=button.closest('[data-pm-dimension]'),group=dimension?data.option_groups.find(g=>g.id===dimension.dataset.pmDimension):null;
                const items=group?group.options:data.sizes;
                const option=button.closest('[data-option-id]')?.dataset.optionId,index=items.findIndex(x=>x.id===option),groupIndex=data.option_groups.indexOf(group);
                const rowIndex=Number(button.closest('[data-pm-row]')?.dataset.pmRow),rows=activeVariant(state).rows;
                try {
                    if(action==='preset'){
                        if(data.variants.some(v=>v.rows.length)&&!confirm('Replace this Price Matrix with the Acrylic reference prices?'))return;
                        button.disabled=true;const response=await fetch('/admin/data/acrylic-price-matrix.json',{headers:{Accept:'application/json'}});
                        if(!response.ok)throw Error('Failed to load Acrylic prices.');state.data=upgrade(await response.json());resetSelection(state);
                    }else if(action==='add-group'){
                        if(data.option_groups.length>=12)throw Error('Maximum 12 option groups.');
                        const id=uid(),optionId=uid();data.option_groups.push({id,label:'New group',options:[{id:optionId,label:'New option'}],default_option:optionId});
                        data.variants.forEach(v=>v.selections[id]=optionId);state.selected[id]=optionId;
                    }else if(action==='remove-group'){
                        const keep=state.selected[group.id],label=group.options.find(o=>o.id===keep)?.label;
                        if(!confirm(`Remove this group? Keep prices for "${label}" and discard prices for the other options in this group.`))return;
                        data.variants=data.variants.filter(v=>v.selections[group.id]===keep);data.variants.forEach(v=>delete v.selections[group.id]);
                        data.option_groups.splice(groupIndex,1);delete state.selected[group.id];
                    }else if(action==='up-group'||action==='down-group'){
                        const target=groupIndex+(action==='up-group'?-1:1);[data.option_groups[groupIndex],data.option_groups[target]]=[data.option_groups[target],data.option_groups[groupIndex]];
                    }else if(action==='add-option'){
                        if(items.length>=20)throw Error('Maximum 20 options.');items.push({id:uid(),label:group?'New option':'New size'});
                    }else if(action==='remove-option'){
                        if(items.length<=1)return;if(!confirm('Remove this option and its associated prices?'))return;items.splice(index,1);
                        if(!group)data.variants.forEach(v=>v.rows.forEach(row=>delete row.prices[option]));
                        else{data.variants=data.variants.filter(v=>v.selections[group.id]!==option);if(group.default_option===option)group.default_option=items[0].id;if(state.selected[group.id]===option)state.selected[group.id]=items[0].id;}
                    }else if(action==='up-option'||action==='down-option'){
                        const target=index+(action==='up-option'?-1:1);[items[index],items[target]]=[items[target],items[index]];
                    }else if(action==='add-row'){
                        insertRow(state,rows.length);
                    }else if(action==='remove-row')rows.splice(rowIndex,1);
                    else if(action==='up-row'||action==='down-row'){
                        const target=rowIndex+(action==='up-row'?-1:1);[rows[rowIndex],rows[target]]=[rows[target],rows[rowIndex]];
                    }else if(action==='copy'){
                        const source=root.querySelector('[data-pm-copy]').value;if(source==='')return;
                        if(rows.length&&!confirm('Replace prices in this combination?'))return;
                        if(!rows.length&&data.variants.filter(v=>v.rows.length).length>=500)throw Error('Maximum 500 priced combinations.');
                        activeVariant(state).rows=clone(data.variants[Number(source)].rows);
                    }
                    refresh(root);root.dispatchEvent(new Event('change',{bubbles:true}));
                }catch(error){const box=root.querySelector('.pm-editor-error');box.hidden=false;box.textContent=error.message;button.disabled=false;}
            });
        });
    }
    window.PriceMatrixEditor={
        render(id,content,defaults){
            descriptionEditors.get(id)?.editor?.destroy();descriptionEditors.delete(id);
            const state={data:upgrade({...clone(defaults),...clone(content)})};resetSelection(state);states.set(id,state);
            return `<div class="pm-editor" data-pm-editor data-block-id="${esc(id)}">${contents(id)}</div>`;
        },bind,
        collect(root){const data=clone(pull(root));data.variants=data.variants.filter(v=>v.rows.length);return data;},
    };
})();
