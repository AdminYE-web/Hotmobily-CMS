(() => {
    const api = '/api/v1/admin/option-group-presets';
    const states = new Map();
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[c]));
    const stateFor = id => {if (!states.has(Number(id))) states.set(Number(id), {name:'', selected:'', status:'', error:false, busy:false}); return states.get(Number(id));};
    let presets = [], pending;
    async function request(url, method = 'GET', body) {
        const response = await fetch(url, {method, credentials:'same-origin', headers:{Accept:'application/json', 'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content || '', ...(body ? {'Content-Type':'application/json'} : {})}, ...(body ? {body:JSON.stringify(body)} : {})});
        const result = await response.json();
        if (!response.ok) throw Error(Object.values(result.errors || {}).flat().join(' ') || result.message || 'Preset request failed.');
        return result.data;
    }
    function options(id, selected) {
        return '<option value="">Choose a saved preset...</option>' + presets.filter(p => Number(p.option_group_id) === Number(id)).map(p => `<option value="${p.id}" ${String(p.id)===selected?'selected':''}>${esc(p.name)}</option>`).join('');
    }
    function refresh(force = false) {
        if (!pending || force) pending = request(api).then(data => {
            presets = data;
            document.querySelectorAll('[data-og-preset]').forEach(panel => {
                const state = stateFor(panel.dataset.ogPreset);
                if (!presets.some(p => String(p.id) === state.selected)) state.selected = '';
                panel.querySelector('[data-og-select]').innerHTML = options(panel.dataset.ogPreset, state.selected);
            });
        }).catch(error => {pending = null; throw error;});
        return pending;
    }
    const nullableNumber = value => value === '' || value == null ? null : Number(value);
    function snapshot(group) {
        return {
            quantity_min: nullableNumber(group.quantity_min), quantity_max: nullableNumber(group.quantity_max),
            options: group.options.map(option => ({
                id:Number(option.id), is_selected:!!option.is_selected, is_default:!!option.is_default, is_active:!!option.is_active,
                quantity_rule:option.quantity_rule || 'no_limit', min_qty:nullableNumber(option.min_qty), max_qty:nullableNumber(option.max_qty), exact_qty:nullableNumber(option.exact_qty),
            })),
        };
    }
    window.OptionGroupPresets = {
        panel(group) {
            const state = stateFor(group.id);
            return `<div class="border rounded p-3 mb-3" data-og-preset="${group.id}" draggable="false">
                <strong>Reusable presets</strong>
                <div class="d-flex flex-wrap mt-2" style="gap:8px"><input class="form-control form-control-sm" style="flex:1;min-width:150px" data-og-name maxlength="150" aria-label="Preset name" placeholder="Preset name" value="${esc(state.name)}">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-og-action="save" ${state.busy?'disabled':''}>Save as preset</button></div>
                <div class="d-flex flex-wrap my-2" style="gap:8px"><select class="form-control form-control-sm" style="flex:1;min-width:150px" data-og-select aria-label="Saved presets">${options(group.id,state.selected)}</select>
                    ${[['load','Load preset','primary'],['update','Update preset','secondary'],['delete','Delete preset','danger']].map(([action,label,color])=>`<button type="button" class="btn btn-sm btn-outline-${color}" data-og-action="${action}" ${state.busy?'disabled':''}>${label}</button>`).join('')}</div>
                <small class="text-muted">Reuse this Option Group's selected options, order, Default / Active settings and quantity rules across products. Loading replaces this block's option configuration. Save Steps &amp; Options to apply it. Other products remain unchanged.</small>
                <div class="small mt-1 ${state.error?'text-danger':''}" data-og-status role="status" aria-live="polite">${esc(state.status)}</div>
            </div>`;
        },
        bind({groups, capture, render}) {
            document.querySelectorAll('[data-og-preset]').forEach(panel => {
                if (panel.dataset.bound) return;
                panel.dataset.bound = '1';
                const id = Number(panel.dataset.ogPreset), state = stateFor(id);
                panel.querySelector('[data-og-name]').addEventListener('input', event => state.name = event.target.value);
                panel.querySelector('[data-og-select]').addEventListener('change', event => state.selected = event.target.value);
                refresh().catch(error => {panel.querySelector('[data-og-status]').textContent = 'Could not load presets: ' + error.message;});
                panel.addEventListener('click', async event => {
                    const button = event.target.closest('[data-og-action]');
                    if (!button || state.busy) return;
                    capture();
                    const group = groups.find(g => Number(g.id) === id);
                    const action = button.dataset.ogAction, selected = presets.find(p => String(p.id) === state.selected && Number(p.option_group_id) === id);
                    let loaded = false;
                    state.busy = true; state.status = ''; state.error = false;
                    panel.querySelectorAll('[data-og-action]').forEach(el => el.disabled = true);
                    try {
                        if (action !== 'save' && !selected) throw Error('Choose a saved preset first.');
                        if (action === 'save' || action === 'update') {
                            if (action === 'save' && !state.name.trim()) throw Error('Enter a preset name.');
                            if (action === 'update' && !confirm(`Update preset "${selected.name}"? Existing products remain unchanged.`)) return;
                            const result = await request(action === 'save' ? api : api+'/'+selected.id, action === 'save' ? 'POST' : 'PUT', {name:state.name.trim() || selected.name, option_group_id:id, content:snapshot(group)});
                            await refresh(true);
                            state.selected = String(result.id); state.name = ''; state.status = 'Preset saved. Available for this Option Group in other products.';
                        } else if (action === 'load') {
                            if (!confirm('Replace this block\'s selected options, order and quantity settings with the preset?')) return;
                            const result = await request(api+'/'+selected.id);
                            if (Number(result.option_group_id) !== id) throw Error('This preset belongs to another Option Group.');
                            const saved = result.content_json;
                            capture();
                            const available = new Map(group.options.map(option => [Number(option.id), option]));
                            if (saved.options.some(option => !available.has(Number(option.id)))) throw Error('Some preset options are no longer available. Update or recreate the preset before loading it. Current settings were kept.');
                            const ordered = saved.options.map(option => ({...available.get(Number(option.id)), ...option}));
                            group.options = ordered.concat(group.options.filter(option => !saved.options.some(item => Number(item.id) === Number(option.id))).map(option => ({...option, is_selected:false, is_default:false})));
                            group.quantity_min = saved.quantity_min; group.quantity_max = saved.quantity_max;
                            loaded = true;
                            state.status = 'Preset loaded. Click Save Steps & Options to apply it.';
                        } else if (action === 'delete') {
                            if (!confirm(`Delete preset "${selected.name}"? Existing product settings remain unchanged.`)) return;
                            await request(api+'/'+selected.id, 'DELETE'); await refresh(true);
                            state.status = 'Preset deleted. Product settings were not changed.';
                        }
                    } catch (error) {state.error = true; state.status = error.message;}
                    finally {if (!loaded) capture(); state.busy = false; render();}
                });
            });
        },
    };
})();
