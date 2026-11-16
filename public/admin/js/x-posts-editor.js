(() => {
    const states=new Map();
    const clone=value=>JSON.parse(JSON.stringify(value));
    const esc=value=>String(value??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const uid=()=>'xpost_'+[...crypto.getRandomValues(new Uint8Array(12))].map(x=>x.toString(16).padStart(2,'0')).join('');
    function pull(root) {
        const data=states.get(root.dataset.blockId).data;
        root.querySelectorAll('[data-xp-meta]').forEach(input=>data[input.dataset.xpMeta]=input.value);
        data.items=[...root.querySelectorAll('[data-xp-item-id]')].map(row=>{
            const item={id:row.dataset.xpItemId};
            row.querySelectorAll('[data-xp-field]').forEach(input=>item[input.dataset.xpField]=input.value);
            return item;
        });
        return data;
    }
    function contents(id) {
        const data=states.get(id).data;
        return `<div class="xp-editor-error" role="alert" hidden></div>
            <div class="form-group"><label for="xp-${esc(id)}-title">Section title (optional)</label><input id="xp-${esc(id)}-title" class="form-control" data-xp-meta="title" value="${esc(data.title)}" maxlength="255"></div>
            <div class="form-group xp-editor-description"><label for="xp-${esc(id)}-description">Description</label><textarea id="xp-${esc(id)}-description" class="form-control" data-xp-meta="description" rows="5" maxlength="50000">${esc(data.description)}</textarea></div>
            <p class="small text-muted">Set columns, theme and conversation display in Layout Builder. Paste public X / Twitter post links below. Drag ☰ or use the arrows to reorder.</p>
            <div class="xp-editor-list">${data.items.map((item,index)=>`<div class="xp-editor-item" data-xp-item-id="${esc(item.id)}">
                <div class="xp-editor-toolbar"><button type="button" class="btn btn-sm btn-outline-secondary xp-item-handle" aria-label="Drag to reorder post">☰</button><strong>Post ${index+1}</strong>
                    <button type="button" class="btn btn-sm btn-light" data-xp-action="up" ${index===0?'disabled':''} aria-label="Move post up">↑</button>
                    <button type="button" class="btn btn-sm btn-light" data-xp-action="down" ${index===data.items.length-1?'disabled':''} aria-label="Move post down">↓</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-xp-action="duplicate">Duplicate</button>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-xp-action="remove">Remove</button>
                </div><div class="form-group"><label for="xp-${esc(id)}-${esc(item.id)}-url">Post URL</label><input id="xp-${esc(id)}-${esc(item.id)}-url" class="form-control" data-xp-field="url" value="${esc(item.url)}" maxlength="2048" placeholder="https://x.com/username/status/123456789"></div>
                <div class="form-group mb-0"><label for="xp-${esc(id)}-${esc(item.id)}-note">Fallback link text (optional)</label><input id="xp-${esc(id)}-${esc(item.id)}-note" class="form-control" data-xp-field="note" value="${esc(item.note)}" maxlength="500"><small class="text-muted">Shown if the embedded post cannot load. Blank uses “Xで投稿を見る”.</small></div>
            </div>`).join('')}</div>
            <button type="button" class="btn btn-sm btn-outline-primary" data-xp-action="add">+ Add X post</button>`;
    }
    function error(root,message){const box=root.querySelector('.xp-editor-error');box.textContent=message;box.hidden=false;}
    function mount(root) {
        const id=root.dataset.blockId,state=states.get(id),textarea=root.querySelector('textarea');
        if(window.ClassicEditor&&!state.editorPending&&!state.editor){
            state.editorPending=true;
            ClassicEditor.create(textarea,{toolbar:['heading','|','bold','italic','link','|','bulletedList','numberedList','blockQuote','|','undo','redo'],link:{defaultProtocol:'https://',addTargetToExternalLinks:true}}).then(editor=>{
                if(states.get(id)!==state||!textarea.isConnected){editor.destroy();return;}
                state.editor=editor;
                editor.model.document.on('change:data',()=>{textarea.value=editor.getData();textarea.dispatchEvent(new Event('input',{bubbles:true}));});
                textarea.value=editor.getData();
            }).catch(reason=>{state.editorPending=false;error(root,'Could not load Description editor: '+reason.message);});
        }
        if(window.Sortable)state.sortable=new Sortable(root.querySelector('.xp-editor-list'),{handle:'.xp-item-handle',draggable:'.xp-editor-item',animation:150,forceFallback:true,fallbackOnBody:true,scroll:true,bubbleScroll:true,scrollSensitivity:80,scrollSpeed:14,onEnd:()=>{pull(root);refresh(root);root.dispatchEvent(new Event('change',{bubbles:true}));}});
    }
    function refresh(root) {
        const state=states.get(root.dataset.blockId),intro=root.querySelector('.xp-editor-description');
        state.sortable?.destroy();intro?.remove();root.innerHTML=contents(root.dataset.blockId);
        if(intro)root.querySelector('.xp-editor-description').replaceWith(intro);
        mount(root);
    }
    function bind(){
        document.querySelectorAll('[data-xp-editor]:not([data-xp-bound])').forEach(root=>{
            root.dataset.xpBound='1';mount(root);
            root.addEventListener('click',event=>{
                const button=event.target.closest('[data-xp-action]');if(!button||button.disabled)return;
                const data=pull(root),action=button.dataset.xpAction,itemId=button.closest('[data-xp-item-id]')?.dataset.xpItemId,index=data.items.findIndex(item=>item.id===itemId);
                if(action==='add'||action==='duplicate'){
                    if(data.items.length>=50){error(root,'Maximum 50 posts per component.');return;}
                    if(action==='duplicate')data.items.splice(index+1,0,{...clone(data.items[index]),id:uid()});
                    else data.items.push({id:uid(),url:'',note:''});
                }else if(action==='remove')data.items.splice(index,1);
                else{const next=index+(action==='up'?-1:1);if(next<0||next>=data.items.length)return;[data.items[index],data.items[next]]=[data.items[next],data.items[index]];}
                refresh(root);root.dispatchEvent(new Event('change',{bubbles:true}));
            });
        });
    }
    window.XPostsEditor={
        render(id,content,defaults){const old=states.get(id);old?.sortable?.destroy();old?.editor?.destroy();states.set(id,{data:{...clone(defaults),...clone(content)}});return `<div class="xp-editor" data-xp-editor data-block-id="${esc(id)}">${contents(id)}</div>`;},
        bind,collect:root=>clone(pull(root)),
    };
})();
