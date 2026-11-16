(() => {
    document.addEventListener('DOMContentLoaded', () => {
        const panel = document.getElementById('bulk-options-panel');
        if (!panel) return;
        const toggle = document.getElementById('toggle-bulk-options');
        const group = document.getElementById('bulk-option-group');
        const files = document.getElementById('bulk-option-images');
        const rows = document.getElementById('bulk-option-rows');
        const queue = document.getElementById('bulk-option-queue');
        const start = document.getElementById('bulk-option-start');
        const stop = document.getElementById('bulk-option-stop');
        const refresh = document.getElementById('bulk-option-refresh');
        const progress = document.getElementById('bulk-option-progress');
        const error = document.getElementById('bulk-option-error');
        const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[c]));
        const truncate = (value, length) => [...value].slice(0, length).join('');
        const uploadKey = () => {
            const bytes = crypto.getRandomValues(new Uint8Array(16));
            bytes[6] = (bytes[6] & 15) | 64;
            bytes[8] = (bytes[8] & 63) | 128;
            const hex = [...bytes].map(value => value.toString(16).padStart(2, '0')).join('');
            return `${hex.slice(0,8)}-${hex.slice(8,12)}-${hex.slice(12,16)}-${hex.slice(16,20)}-${hex.slice(20)}`;
        };
        let items = [], busy = false, stopped = false, createdCount = 0;
        function showError(message) {error.textContent = message; error.hidden = !message;}
        function update() {
            const ready = items.filter(item => !item.invalid && item.state !== 'done').length;
            start.disabled = busy || !ready;
            start.textContent = items.length && items.every(item => item.state === 'done') ? 'Upload complete' : items.some(item => item.state === 'done') ? 'Upload remaining' : 'Upload & Create Options';
            group.disabled = busy || items.some(item => item.state === 'done');
            files.disabled = busy;
            toggle.disabled = busy;
            stop.hidden = !busy;
            stop.disabled = stopped;
            refresh.hidden = !createdCount;
            refresh.disabled = busy;
            queue.hidden = !items.length;
            progress.textContent = items.length ? `${items.filter(item => item.state === 'done').length} / ${items.length} completed; ${items.filter(item => item.state === 'failed' || item.invalid).length} failed${busy ? '; uploading...' : ''}` : '';
            rows.innerHTML = items.map((item, index) => `<tr>
                <td><img src="${esc(item.preview)}" alt="" width="54" height="54" style="object-fit:contain"></td>
                <td style="overflow-wrap:anywhere"><span>${esc(item.file.name)}</span><div class="small text-muted">${esc(truncate(item.name,255))}</div></td>
                <td style="overflow-wrap:anywhere"><code>${esc(item.result?.option_code || truncate(item.name,100))}</code></td>
                <td><span class="${item.state==='done'?'text-success':item.state==='failed'||item.invalid?'text-danger':''}">${esc(item.message || 'Ready')}</span>${item.result ? `<div><a href="${esc(item.result.edit_url)}">Edit option</a></div>` : ''}</td>
                <td>${item.state !== 'done' ? `<button type="button" class="btn btn-sm btn-outline-danger" data-remove="${index}" ${busy?'disabled':''} aria-label="Remove ${esc(item.file.name)}">Remove</button>` : ''}</td>
            </tr>`).join('');
        }
        toggle.addEventListener('click', () => {
            panel.hidden = !panel.hidden;
            toggle.setAttribute('aria-expanded', String(!panel.hidden));
        });
        files.addEventListener('change', () => {
            const selected = [...files.files];
            if (selected.length > 200) {showError('Select no more than 200 images at a time.'); files.value = ''; return;}
            items.forEach(item => URL.revokeObjectURL(item.preview));
            items = selected.map(file => {
                const name = file.name.replace(/^.*[\\/]/, '').replace(/\.[^.]*$/, '').replace(/[\x00-\x1f\x7f]/g, '').trim();
                const invalid = file.size > 5 * 1024 * 1024 ? 'Maximum file size is 5 MB.' : !/\.(jpe?g|png|gif|webp|bmp)$/i.test(file.name) ? 'Unsupported image format.' : !name ? 'The image needs a filename before its extension.' : '';
                return {file, name, preview:URL.createObjectURL(file), uploadId:uploadKey(), state:'ready', invalid, message:invalid};
            });
            showError('');
            update();
        });
        rows.addEventListener('click', event => {
            const button = event.target.closest('[data-remove]');
            if (!button || busy) return;
            const [removed] = items.splice(Number(button.dataset.remove), 1);
            URL.revokeObjectURL(removed.preview);
            update();
        });
        stop.addEventListener('click', () => {stopped = true; stop.disabled = true;});
        refresh.addEventListener('click', () => location.reload());
        start.addEventListener('click', async () => {
            if (busy) return;
            if (!group.value) {showError('Choose an Option Group first.'); group.focus(); return;}
            const groupId = group.value;
            busy = true; stopped = false; showError(''); update();
            try {
                for (const item of items) {
                    if (stopped) break;
                    if (item.invalid || item.state === 'done') continue;
                    item.state = 'uploading'; item.message = 'Uploading...'; update();
                    try {
                        const body = new FormData();
                        body.append('option_group_id', groupId);
                        body.append('upload_id', item.uploadId);
                        body.append('image', item.file);
                        const response = await fetch(panel.dataset.uploadUrl, {method:'POST', credentials:'same-origin', headers:{Accept:'application/json', 'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content || ''}, body});
                        const result = await response.json().catch(() => ({}));
                        if (!response.ok) {
                            if ([401,403,419].includes(response.status) || response.status >= 500 || result.errors?.option_group_id) stopped = true;
                            throw Error(Object.values(result.errors || {}).flat().join(' ') || result.message || 'Upload failed. Try again.');
                        }
                        if (!result.data?.id) throw Error('Upload response was incomplete. Retry this image.');
                        item.result = result.data; item.state = 'done'; item.message = 'Created'; createdCount++;
                    } catch (reason) {
                        item.state = 'failed'; item.message = reason.message;
                    }
                    update();
                }
            } finally {
                busy = false; update();
                if (stopped) showError('Upload stopped. Completed options are saved. Use Upload remaining to continue. If your session expired, refresh the page and sign in again.');
            }
        });
        window.addEventListener('beforeunload', event => {if (busy) {event.preventDefault(); event.returnValue = '';}});
    });
})();
