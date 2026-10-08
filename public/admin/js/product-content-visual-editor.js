(() => {
    'use strict';
    const colors = {product_header: '#8054ef', product_gallery: '#f72e86', product_details: '#3489ff', image: '#ef526d', info_card: '#ef526d', shipping_schedule: '#2676ff', production_schedule: '#2676ff', faq: '#8531ef', text_link: '#8531ef'};
    window.ProductContentVisualEditor = {
        init(config) {
            const root = document.getElementById('visual-editor');
            if (!root) return;
            document.body.classList.add('ve-page');
            const workspace = document.getElementById('ve-workspace');
            const sidebar = document.getElementById('ve-sidebar');
            const frame = document.getElementById('ve-frame');
            const list = document.getElementById('ve-section-list');
            const status = document.getElementById('ve-status');
            const canvasCard = root.nextElementSibling;
            const toggle = document.getElementById('ve-toggle');
            const back = document.getElementById('ve-back');
            const refresh = document.getElementById('ve-refresh');
            const sectionsToggle = document.getElementById('ve-sections-toggle');
            const shellCheckbox = document.getElementById('ve-show-shell');
            const configureFrame = () => frame.contentWindow?.postMessage({type: 'visual-editor:configure', sections, selectedKey, showShell: shellCheckbox.checked}, window.location.origin);
            let enabled = false, selectedKey = null, sections = [], loading = false;
            let baseline = null;
            const snapshot = () => JSON.stringify(config.collectContent());
            const setStatus = message => { status.textContent = message; };
            const collectSections = () => {
                sections = [];
                const visit = block => {
                    if (!block || block.id == null) return;
                    const blockId = String(block.id);
                    sections.push({key: 'block:' + blockId, blockId, type: block.type, label: config.getBlockName(block.type), color: colors[block.type] || '#4285ed'});
                    (block.children || []).forEach(visit);
                };
                (config.getLayout()?.rows || []).forEach(row => (row.columns || []).forEach(column => (column.blocks || []).forEach(visit)));
                const counts = new Map();
                sections.forEach(section => counts.set(section.label, (counts.get(section.label) || 0) + 1));
                const positions = new Map();
                sections.forEach(section => {
                    const label = section.label;
                    positions.set(label, (positions.get(label) || 0) + 1);
                    if (counts.get(label) > 1) section.label += ' ' + positions.get(label);
                });
                return sections;
            };
            const renderSections = () => {
                list.replaceChildren();
                const add = section => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 've-section' + (section.key === selectedKey ? ' is-selected' : '');
                    button.dataset.sectionKey = section.key;
                    button.style.setProperty('--ve-color', section.color || '#25ad68');
                    const dot = document.createElement('span'); dot.className = 've-dot'; dot.setAttribute('aria-hidden', 'true');
                    const text = document.createElement('span'); text.className = 've-section-label'; text.textContent = section.label;
                    const detail = document.createElement('small'); detail.textContent = section.blockId ? '#' + section.blockId : section.url ? 'Shared across pages' : 'ยังไม่มีหน้าจัดการ'; text.append(detail);
                    const arrow = document.createElement('span'); arrow.textContent = '›'; arrow.setAttribute('aria-hidden', 'true');
                    button.append(dot, text, arrow);
                    button.addEventListener('click', () => openSection(section.key));
                    list.append(button);
                };
                sections.forEach(add);
                const heading = document.createElement('p'); heading.className = 've-shared-title'; heading.textContent = 'Shared page sections'; list.append(heading);
                config.sharedSections.forEach(add);
            };
            const setView = preview => {
                root.dataset.mode = preview ? 'preview' : 'form';
                workspace.hidden = !preview;
                canvasCard.hidden = preview;
                back.hidden = !enabled || preview;
                refresh.hidden = !enabled || !preview;
                sectionsToggle.hidden = !enabled || !preview;
                document.getElementById('ve-shell-label').hidden = !enabled || !preview;
            };
            const openSection = key => {
                const section = sections.find(item => item.key === key) || config.sharedSections.find(item => item.key === key);
                if (!section) return;
                if (!section.blockId) {
                    if (!section.url) { setStatus('Navigation ยังไม่มีหน้าจัดการในระบบ'); return; }
                    window.open(section.url, '_blank', 'noopener');
                    setStatus('เปิดหน้าจัดการในแท็บใหม่แล้ว ข้อมูลที่กำลังแก้ยังอยู่ในแท็บนี้');
                    return;
                }
                const target = document.querySelector(`.content-block[data-block-id="${CSS.escape(section.blockId)}"]`);
                if (!target) { setStatus('ไม่พบบล็อกนี้ใน editor กรุณา Refresh Preview'); return; }
                selectedKey = key;
                setView(false);
                let block = target;
                while (block) {
                    block.classList.remove('is-collapsed');
                    config.collapsedIds.delete(String(block.dataset.blockId));
                    block.querySelector(':scope > .content-block-header .content-block-toggle')?.setAttribute('aria-expanded', 'true');
                    block = block.parentElement?.closest('.content-block');
                }
                document.querySelectorAll('.ve-target').forEach(node => node.classList.remove('ve-target'));
                target.classList.add('ve-target');
                requestAnimationFrame(() => {
                    target.scrollIntoView({behavior: 'smooth', block: 'start'});
                    const field = [...target.querySelectorAll('.content-block-body input:not([type="hidden"]):not([disabled]), .content-block-body textarea:not([disabled]), .content-block-body select:not([disabled]), .content-block-body [contenteditable="true"]')].find(node => node.getClientRects().length);
                    field?.focus({preventScroll: true});
                });
                renderSections();
                setStatus('Editing ' + section.label + ' · #' + section.blockId);
                window.setTimeout(() => target.classList.remove('ve-target'), 3000);
            };
            const loadPreview = async () => {
                if (loading) return;
                if (!config.getLayout()) { setStatus('กำลังโหลด Content Editor กรุณาลองอีกครั้ง'); return; }
                loading = true; refresh.disabled = true; back.disabled = true;
                setStatus('Loading preview…');
                collectSections(); renderSections();
                try {
                    const response = await fetch(config.previewUrl, {method: 'POST', credentials: 'same-origin', headers: {'Content-Type': 'application/json', 'Accept': 'text/html', 'X-CSRF-TOKEN': config.csrf}, body: JSON.stringify({blocks: config.collectContent()})});
                    if (!response.ok) throw new Error('Preview failed (' + response.status + ')');
                    const html = await response.text();
                    if (!enabled) return;
                    frame.srcdoc = html;
                    setView(true);
                    setStatus('Preview จากข้อมูลที่กำลังแก้ · ยังไม่ได้บันทึก');
                } catch (error) { setStatus(error.message + ' — กด Refresh Preview เพื่อลองใหม่'); }
                finally { loading = false; refresh.disabled = false; back.disabled = false; }
            };
            frame.addEventListener('load', () => {
                if (!enabled || !frame.contentWindow) return;
                configureFrame();
            });
            window.addEventListener('message', event => {
                if (!enabled || event.origin !== window.location.origin || event.source !== frame.contentWindow || !event.data || typeof event.data !== 'object') return;
                if (event.data.type === 'visual-editor:ready') {
                    configureFrame();
                    setStatus('Preview พร้อมแล้ว · ยังไม่ได้บันทึก');
                }
                if (event.data.type === 'visual-editor:edit-section' && typeof event.data.key === 'string') openSection(event.data.key);
            });
            toggle.addEventListener('click', () => {
                if (!config.getLayout()) { setStatus('กำลังโหลด Content Editor กรุณาลองอีกครั้ง'); return; }
                enabled = !enabled;
                root.classList.toggle('is-enabled', enabled);
                toggle.setAttribute('aria-pressed', String(enabled));
                document.getElementById('ve-mode-label').textContent = enabled ? 'ON' : 'OFF';
                if (enabled) { baseline ??= snapshot(); setView(true); loadPreview(); }
                else { setView(false); setStatus(''); }
            });
            refresh.addEventListener('click', loadPreview);
            back.addEventListener('click', () => { setView(true); loadPreview(); root.scrollIntoView({behavior: 'smooth', block: 'start'}); });
            const showSidebar = show => { sidebar.hidden = !show; workspace.classList.toggle('ve-sidebar-closed', !show); sectionsToggle.setAttribute('aria-expanded', String(show)); };
            sectionsToggle.addEventListener('click', () => showSidebar(sidebar.hidden));
            document.getElementById('ve-close-sections').addEventListener('click', () => showSidebar(false));
            showSidebar(window.innerWidth > 900);
            const resizePreview = () => {
                if (frame.parentElement.clientWidth <= 0) return;
                const width = shellCheckbox.checked ? 1200 : 1000;
                const scale = Math.min(1, frame.parentElement.clientWidth / width);
                const height = Math.max(480, window.innerHeight * .78);
                frame.style.width = width + 'px';
                frame.style.height = height / scale + 'px';
                frame.style.transform = `scale(${scale})`;
                frame.parentElement.style.height = height + 'px';
            };
            new ResizeObserver(resizePreview).observe(frame.parentElement);
            window.addEventListener('resize', resizePreview);
            shellCheckbox.addEventListener('change', () => { configureFrame(); resizePreview(); });
            // Keep the baseline aligned with successful saves without changing the existing save flow.
            const saveStatus = document.getElementById('save-status');
            new MutationObserver(() => { if (saveStatus.textContent.includes('Draft saved')) baseline = snapshot(); }).observe(saveStatus, {childList: true, subtree: true, characterData: true});
            window.addEventListener('beforeunload', event => { if (baseline !== null && snapshot() !== baseline) { event.preventDefault(); event.returnValue = ''; } });
        }
    };
})();
