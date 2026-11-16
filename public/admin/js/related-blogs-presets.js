(() => {
    const api = '/api/v1/admin/related-blogs-presets';
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[c]));
    let presets = [], pending, csrf = '';
    async function request(url, method = 'GET', body) {
        const response = await fetch(url, {method, credentials:'same-origin', headers:{Accept:'application/json', 'X-CSRF-TOKEN':csrf, ...(body ? {'Content-Type':'application/json'} : {})}, ...(body ? {body:JSON.stringify(body)} : {})});
        const result = await response.json();
        if (!response.ok) throw Error(Object.values(result.errors || {}).flat().join(' ') || result.message || 'Preset request failed.');
        return result.data;
    }
    function refresh(force = false) {
        if (!pending || force) pending = request(api).then(data => {
            presets = data;
            document.querySelectorAll('[data-rb-preset-select]').forEach(select => {
                const value = select.value;
                select.innerHTML = '<option value="">Choose a saved preset...</option>' + presets.map(p => `<option value="${esc(p.id)}">${esc(p.name)}</option>`).join('');
                select.value = presets.some(p => String(p.id) === value) ? value : '';
            });
        }).catch(error => {pending = null; throw error;});
        return pending;
    }
    function collect(root) {
        return {
            title: root.querySelector('.related-blogs-title').value.trim(),
            articles: [...root.querySelectorAll('.related-blog-article')].map(row => ({
                title: row.querySelector('.related-blog-article-title').value.trim(),
                underline: row.querySelector('.related-blog-underline')?.checked ?? false,
                url: row.querySelector('.related-blog-url').value.trim(),
                image_url: row.querySelector('.single-image-input-value').value.trim(),
            })).filter(item => item.title || item.url || item.image_url),
        };
    }
    window.RelatedBlogsPresets = {bind(options) {
        csrf = options.csrf;
        document.querySelectorAll('.related-blogs-editor').forEach(root => {
            if (root.dataset.rbPresetsBound) return;
            root.dataset.rbPresetsBound = '1';
            root.insertAdjacentHTML('afterbegin', `<div class="border rounded p-3 mb-3">
                <strong>Reusable presets</strong>
                <div class="d-flex flex-wrap align-items-center mt-2" style="gap:8px">
                    <input class="form-control" style="flex:1;min-width:160px" data-rb-preset-name maxlength="150" aria-label="Preset name" placeholder="Preset name, e.g. Acrylic related articles">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-rb-preset-action="save">Save as preset</button>
                </div>
                <div class="d-flex flex-wrap align-items-center my-2" style="gap:8px">
                    <select class="form-control" style="flex:1;min-width:160px" data-rb-preset-select aria-label="Saved presets"><option value="">Choose a saved preset...</option></select>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-rb-preset-action="load">Load preset</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-rb-preset-action="update">Update preset</button>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-rb-preset-action="delete">Delete preset</button>
                </div>
                <small class="text-muted">Presets include the accordion title, article images, titles and links. Loading replaces this component. Save and publish the product to apply it. Editing a loaded copy does not change other products.</small>
                <div class="small mt-1" data-rb-preset-status role="status" aria-live="polite"></div>
            </div>`);
            const select = root.querySelector('[data-rb-preset-select]');
            const status = root.querySelector('[data-rb-preset-status]');
            const name = root.querySelector('[data-rb-preset-name]');
            // Populate even when the shared request has already completed.
            select.insertAdjacentHTML('beforeend', presets.map(p => `<option value="${esc(p.id)}">${esc(p.name)}</option>`).join(''));
            refresh().catch(error => {status.textContent = 'Could not load presets: ' + error.message;});
            let busy = false;
            root.addEventListener('click', async event => {
                const button = event.target.closest('[data-rb-preset-action]');
                if (!button || busy) return;
                const action = button.dataset.rbPresetAction;
                const id = select.value;
                const selected = presets.find(p => String(p.id) === id);
                const content = collect(root);
                busy = true;
                root.querySelectorAll('[data-rb-preset-action]').forEach(el => el.disabled = true);
                status.classList.remove('text-danger');
                status.textContent = '';
                try {
                    if (action !== 'save' && !selected) throw Error('Choose a saved preset first.');
                    if (action === 'save' || action === 'update') {
                        if (action === 'save' && !name.value.trim()) throw Error('Enter a preset name.');
                        if (!content.articles.length) throw Error('Add at least one article before saving a preset.');
                        if (action === 'update' && !confirm(`Update preset "${selected.name}"? Existing product content will remain unchanged.`)) return;
                        const result = await request(action === 'save' ? api : api + '/' + id, action === 'save' ? 'POST' : 'PUT', {name:name.value.trim() || selected.name, content});
                        await refresh(true);
                        select.value = String(result.id);
                        name.value = '';
                        status.textContent = 'Preset saved. It is now available in other products.';
                    } else if (action === 'load') {
                        if (!confirm('Replace this Related Blogs component with the selected preset? Unsaved changes will be replaced.')) return;
                        const result = await request(api + '/' + id);
                        root.querySelector('.related-blogs-title').value = result.content_json.title || '';
                        root.querySelector('.related-blogs-list').innerHTML = result.content_json.articles.map(options.renderArticle).join('');
                        options.bindUploads();
                        name.value = '';
                        root.dispatchEvent(new Event('change', {bubbles:true}));
                        status.textContent = 'Preset loaded. Save and publish the product to apply it.';
                    } else if (action === 'delete') {
                        if (!confirm(`Delete preset "${selected.name}"? Existing product content and images will remain unchanged.`)) return;
                        await request(api + '/' + id, 'DELETE');
                        await refresh(true);
                        status.textContent = 'Preset deleted. Product content was not changed.';
                    }
                } catch (error) {
                    status.classList.add('text-danger');
                    status.textContent = error.message;
                } finally {
                    busy = false;
                    root.querySelectorAll('[data-rb-preset-action]').forEach(el => el.disabled = false);
                }
            });
        });
    }};
})();
