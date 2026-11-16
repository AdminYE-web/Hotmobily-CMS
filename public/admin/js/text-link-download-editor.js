(() => {
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[c]));
    window.TextLinkDownloadEditor = {
        render(id, content) {
            return `<div class="form-group"><label>Link type</label>
                <select class="form-control product-field" data-field="link_mode" data-block-id="${esc(id)}" data-tld-mode>
                    <option value="link" ${content.link_mode !== 'download' ? 'selected' : ''}>Normal link</option>
                    <option value="download" ${content.link_mode === 'download' ? 'selected' : ''}>File download button</option>
                </select></div>
                <div data-tld-upload class="form-group" ${content.link_mode === 'download' ? '' : 'hidden'}>
                    <label>Download file</label><input type="file" class="form-control-file" data-tld-file accept=".pdf,.zip,.rar,.7z,.ai,.psd,.eps,.svg,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.jpg,.jpeg,.png,.webp,.gif">
                    <small class="d-block text-muted">Upload a file up to 100 MB. Visitors download this file when they click the button.</small>
                    <div class="mt-2" data-tld-current>${esc(content.file_name || '')}</div>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-1" data-tld-remove ${content.file_path ? '' : 'hidden'}>Remove file</button>
                    <div class="small mt-1" data-tld-status role="status" aria-live="polite"></div>
                    <input type="hidden" class="product-field" data-field="file_path" data-block-id="${esc(id)}" value="${esc(content.file_path)}">
                    <input type="hidden" class="product-field" data-field="file_name" data-block-id="${esc(id)}" value="${esc(content.file_name)}">
                </div>
                <div class="row">
                    <div class="col-md-6 form-group"><label>Top spacing (px)</label><input type="number" min="0" max="200" step="1" class="form-control product-field" data-field="spacing_top" data-block-id="${esc(id)}" value="${esc(content.spacing_top ?? 0)}"></div>
                    <div class="col-md-6 form-group"><label>Bottom spacing (px)</label><input type="number" min="0" max="200" step="1" class="form-control product-field" data-field="spacing_bottom" data-block-id="${esc(id)}" value="${esc(content.spacing_bottom ?? 0)}"></div>
                </div>
                <div class="form-group"><label><input type="checkbox" class="product-field" data-field="underline" data-block-id="${esc(id)}" ${content.underline === false || content.underline === 0 ? '' : 'checked'}> Show underline</label></div>`;
        },
        bind(apiBase, csrf) {
            document.querySelectorAll('.text-link-editor').forEach(root => {
                if (root.dataset.downloadBound) return;
                root.dataset.downloadBound = '1';
                const mode = root.querySelector('[data-tld-mode]');
                if (!mode) return;
                const path = root.querySelector('[data-field="file_path"]'), name = root.querySelector('[data-field="file_name"]');
                const current = root.querySelector('[data-tld-current]'), status = root.querySelector('[data-tld-status]'), remove = root.querySelector('[data-tld-remove]');
                const sync = () => {
                    const download = mode.value === 'download';
                    root.querySelector('[data-tld-upload]').hidden = !download;
                    root.querySelectorAll('[data-tld-normal]').forEach(el => el.hidden = download);
                };
                mode.addEventListener('change', sync); sync();
                const applyAppearance = () => {
                    const preview = root.querySelector('.text-link-preview a');
                    const pixels = field => Math.max(0, Math.min(200, Number(root.querySelector(`[data-field="${field}"]`).value) || 0)) + 'px';
                    preview.style.display = 'inline-block';
                    preview.style.marginTop = pixels('spacing_top');
                    preview.style.marginBottom = pixels('spacing_bottom');
                    preview.style.setProperty('text-decoration', root.querySelector('[data-field="underline"]').checked ? 'underline' : 'none', 'important');
                };
                root.querySelectorAll('[data-field="spacing_top"], [data-field="spacing_bottom"], [data-field="underline"]').forEach(input => input.addEventListener('input', applyAppearance));
                applyAppearance();
                remove.addEventListener('click', () => {
                    path.value = ''; name.value = ''; current.textContent = ''; remove.hidden = true;
                    root.querySelector('[data-tld-file]').value = '';
                    status.textContent = 'File removed. Upload a file before saving in download mode.';
                    path.dispatchEvent(new Event('input', {bubbles:true}));
                });
                root.querySelector('[data-tld-file]').addEventListener('change', async event => {
                    const input = event.target, file = input.files[0]; if (!file) return;
                    if (file.size > 100 * 1024 * 1024) { status.textContent = 'Maximum file size is 100 MB.'; input.value = ''; return; }
                    input.disabled = true; remove.disabled = true; status.textContent = 'Uploading...';
                    try {
                        const body = new FormData(); body.append('file', file);
                        const response = await fetch(apiBase + '/files', {method:'POST', headers:{'X-CSRF-TOKEN':csrf, Accept:'application/json'}, body});
                        const result = await response.json();
                        if (!response.ok) throw Error(Object.values(result.errors || {}).flat().join(' ') || result.message || 'Upload failed.');
                        if (!result.data?.path) throw Error('The upload did not return a file path.');
                        path.value = result.data.path; name.value = result.data.original_name || file.name;
                        current.textContent = name.value; remove.hidden = false; status.textContent = 'File uploaded.';
                        path.dispatchEvent(new Event('input', {bubbles:true}));
                    } catch (error) { status.textContent = error.message; }
                    finally { input.disabled = false; remove.disabled = false; input.value = ''; }
                });
            });
        },
    };
})();
