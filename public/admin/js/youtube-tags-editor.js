(() => {
    'use strict';
    const states = new Map();
    const esc = value => String(value ?? '').replace(/[&<>"']/g, ch => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[ch]));
    const clone = value => JSON.parse(JSON.stringify(value));
    const uid = () => 'yt-'+Date.now().toString(36)+'-'+Array.from(crypto.getRandomValues(new Uint32Array(2)), n=>n.toString(36)).join('');
    function pull(root) {
        const state = states.get(root.dataset.blockId);
        state.data.tags_enabled = root.querySelector('[data-yt-enabled]').checked;
        root.querySelectorAll('[data-yt-color]').forEach(input=>{state.data[input.dataset.ytColor]=input.value;});
        state.data.tags = [...root.querySelectorAll('[data-yt-tag-id]')].map(row=>({
            id:row.dataset.ytTagId, label:row.querySelector('[data-yt-label]').value, url:row.querySelector('[data-yt-url]').value,
        }));
        return state.data;
    }
    function renderList(root) {
        const state = states.get(root.dataset.blockId);
        state.sortable?.destroy();
        const list = root.querySelector('[data-yt-list]');
        list.innerHTML = state.data.tags.map((tag,index)=>`<div class="yt-tag-row" data-yt-tag-id="${esc(tag.id)}"><button type="button" class="btn btn-sm btn-light yt-tag-handle" aria-label="Drag tag">☰</button><input class="form-control" data-yt-label maxlength="120" value="${esc(tag.label)}" placeholder="Tag text" aria-label="Tag text ${index+1}"><input class="form-control" data-yt-url maxlength="2000" value="${esc(tag.url)}" placeholder="Optional link URL" aria-label="Tag link ${index+1}"><button type="button" class="btn btn-sm btn-light" data-yt-action="up" ${index===0?'disabled':''} aria-label="Move up">↑</button><button type="button" class="btn btn-sm btn-light" data-yt-action="down" ${index===state.data.tags.length-1?'disabled':''} aria-label="Move down">↓</button><button type="button" class="btn btn-sm btn-outline-danger" data-yt-action="remove">Remove</button></div>`).join('');
        if (window.Sortable) state.sortable = new Sortable(list, {
            handle:'.yt-tag-handle',draggable:'.yt-tag-row',animation:150,forceFallback:true,fallbackOnBody:true,
            scroll:true,bubbleScroll:true,scrollSensitivity:80,scrollSpeed:14,
            onEnd:()=>{pull(root);renderList(root);root.dispatchEvent(new Event('change',{bubbles:true}));},
        });
    }
    window.YoutubeTagsEditor = {
        render(id, content, defaults) {
            states.get(id)?.sortable?.destroy();
            const data={...clone(defaults),...Object.fromEntries(Object.keys(defaults).filter(key=>Object.hasOwn(content,key)).map(key=>[key,clone(content[key])]))};
            states.set(id,{data});
            return `<fieldset class="yt-tags-editor" data-yt-tags-editor data-block-id="${esc(id)}"><legend class="h6 w-auto px-1">Tags below video</legend><label><input type="checkbox" data-yt-enabled ${data.tags_enabled?'checked':''}> Show tags</label><div class="yt-tags-colors"><label>Background color<input type="color" data-yt-color="tag_background_color" value="${esc(data.tag_background_color)}"></label><label>Text color<input type="color" data-yt-color="tag_text_color" value="${esc(data.tag_text_color)}"></label></div><p class="small text-muted">Add up to 50 tags. Drag ☰ or use arrows to reorder. Leave the URL blank for a text-only tag.</p><div class="yt-tags-error" role="alert"></div><div data-yt-list></div><button type="button" class="btn btn-sm btn-outline-primary" data-yt-action="add">+ Add tag</button></fieldset>`;
        },
        bind() {
            document.querySelectorAll('[data-yt-tags-editor]').forEach(root=>{
                if(root.dataset.ytBound)return;
                root.dataset.ytBound='1';renderList(root);
                root.addEventListener('click',event=>{
                    const button=event.target.closest('[data-yt-action]');if(!button)return;
                    const data=pull(root), action=button.dataset.ytAction;
                    const id=button.closest('[data-yt-tag-id]')?.dataset.ytTagId,index=data.tags.findIndex(tag=>tag.id===id);
                    if(action==='add'){
                        if(data.tags.length>=50){root.querySelector('.yt-tags-error').textContent='Maximum 50 tags per video.';return;}
                        data.tags.push({id:uid(),label:'',url:''});
                    }else if(action==='remove')data.tags.splice(index,1);
                    else if(action==='up'||action==='down'){
                        const next=index+(action==='up'?-1:1);if(index<0||next<0||next>=data.tags.length)return;
                        [data.tags[index],data.tags[next]]=[data.tags[next],data.tags[index]];
                    }
                    root.querySelector('.yt-tags-error').textContent='';
                    renderList(root);root.dispatchEvent(new Event('change',{bubbles:true}));
                    if(action==='add')root.querySelector('[data-yt-tag-id]:last-child [data-yt-label]').focus();
                });
            });
        },
        collect:root=>clone(pull(root)),
    };
})();
