document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.getElementById('content-revisions');
    if (!trigger) return;

    const modal = $('#content-revisions-modal');
    const list = document.getElementById('content-revisions-list');
    const message = document.getElementById('content-revisions-message');
    const newer = document.getElementById('content-revisions-newer');
    const older = document.getElementById('content-revisions-older');
    const pageLabel = document.getElementById('content-revisions-page');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const labels = {
        initial_draft: 'Initial draft', initial_published: 'Initial published version',
        draft_saved: 'Draft saved', published: 'Published',
        before_restore: 'Before restore', restored: 'Restored to draft',
    };
    let page = 1;
    let latestVersion = 0;
    let busy = false;

    function showMessage(text, error = false) {
        message.className = error ? 'alert alert-danger' : 'text-muted mb-3';
        message.textContent = text;
    }

    function showVersions(versions) {
        if (!versions) return;
        const summary = ['draft', 'published'].map(type => {
            const current = versions[type];
            const label = type === 'draft' ? 'Saved draft' : 'Published';
            if (!current?.version) return `${label}: ${current?.has_content ? 'Not recorded yet' : 'None'}`;
            const restored = current.restored_from_version ? ` (restored from v${current.restored_from_version})` : '';
            return `${label}: v${current.version}${restored}`;
        }).join(' · ');
        document.getElementById('content-current-versions').textContent = summary;
        document.getElementById('content-revisions-current').textContent = summary;
    }

    async function refreshVersions() {
        try {
            const result = await request(`${trigger.dataset.listUrl}?page=1`);
            showVersions(result.current_versions);
        } catch (error) {
            document.getElementById('content-current-versions').textContent = 'Version unavailable';
        }
    }

    async function request(url, options = {}) {
        const response = await fetch(url, {
            credentials: 'same-origin', ...options,
            headers: { Accept: 'application/json', 'X-CSRF-TOKEN': csrf, ...options.headers },
        });
        const body = await response.json();
        if (!response.ok) throw new Error(body.message || 'Unable to load revision history.');
        return body;
    }

    async function load(requestedPage = 1) {
        if (busy) return;
        busy = true;
        newer.disabled = older.disabled = true;
        list.replaceChildren();
        showMessage('Loading revisions...');
        try {
            const result = await request(`${trigger.dataset.listUrl}?page=${requestedPage}`);
            showVersions(result.current_versions);
            latestVersion = result.latest_version;
            page = result.data.current_page;
            for (const revision of result.data.data) {
                const row = document.createElement('tr');
                const actionLabel = revision.action === 'restored' && revision.restored_from_version
                    ? `Restored to draft (from v${revision.restored_from_version})`
                    : labels[revision.action] || revision.action;
                for (const value of [
                    `v${revision.version}`, actionLabel,
                    revision.created_by || '—', new Date(revision.created_at).toLocaleString(),
                ]) {
                    const cell = document.createElement('td');
                    cell.textContent = value;
                    row.appendChild(cell);
                }
                for (const [type, label, color] of [['draft', 'Current draft', 'primary'], ['published', 'Published', 'success']]) {
                    if (result.current_versions?.[type]?.version === revision.version) {
                        const badge = document.createElement('span');
                        badge.className = `badge badge-${color} ml-2`;
                        badge.textContent = label;
                        row.firstChild.appendChild(badge);
                        row.classList.add('table-active');
                    }
                }
                const actions = document.createElement('td');
                actions.className = 'text-nowrap';
                const preview = document.createElement('a');
                preview.className = 'btn btn-sm btn-outline-primary mr-2';
                preview.href = trigger.dataset.previewUrl.replace('__REVISION__', revision.id);
                preview.target = '_blank';
                preview.rel = 'noopener';
                preview.textContent = 'Preview';
                actions.appendChild(preview);
                if (result.current_versions?.draft?.version !== revision.version) {
                    const restore = document.createElement('button');
                    restore.type = 'button';
                    restore.className = 'btn btn-sm btn-outline-warning';
                    restore.textContent = 'Restore to draft';
                    restore.addEventListener('click', () => restoreRevision(revision));
                    actions.appendChild(restore);
                }
                row.appendChild(actions);
                list.appendChild(row);
            }
            showMessage(result.data.total ? `${result.data.total} saved versions` : 'No revisions recorded yet. Save a draft to start recording history.');
            pageLabel.textContent = `Page ${page} of ${result.data.last_page}`;
            newer.disabled = page <= 1;
            older.disabled = page >= result.data.last_page;
        } catch (error) {
            pageLabel.textContent = '';
            showMessage(error.message, true);
        } finally {
            busy = false;
        }
    }

    async function restoreRevision(revision) {
        if (busy || document.getElementById('save-draft').disabled || document.getElementById('publish-product').disabled) return;
        if (!confirm(`Restore v${revision.version} to draft? Unsaved changes in this editor will be replaced. Published content stays unchanged.`)) return;
        busy = true;
        const buttons = [...list.querySelectorAll('button'), newer, older,
            document.getElementById('save-draft'), document.getElementById('publish-product')];
        const previousDisabled = buttons.map(button => button.disabled);
        buttons.forEach(button => { button.disabled = true; });
        showMessage('Restoring revision...');
        try {
            await request(`${trigger.dataset.listUrl}/${revision.id}/restore`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ expected_version: latestVersion }),
            });
            window.location.reload();
        } catch (error) {
            showMessage(error.message, true);
            buttons.forEach((button, index) => { button.disabled = previousDisabled[index]; });
            busy = false;
        }
    }

    trigger.addEventListener('click', function () {
        modal.modal('show');
        load();
    });
    newer.addEventListener('click', () => load(page - 1));
    older.addEventListener('click', () => load(page + 1));
    document.addEventListener('product-content-version-changed', refreshVersions);
    refreshVersions();
});
