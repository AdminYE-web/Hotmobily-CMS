(() => {
    'use strict';
    // srcdoc reports location.origin as "null" even though it inherits the parent's origin.
    const origin = window.parent.location.origin;
    document.body.classList.add('ve-product-only');
    const blocks = [...document.querySelectorAll('[data-editor-block-id]')];
    let sections = new Map();
    const sendEdit = key => { if (sections.has(key)) window.parent.postMessage({type: 'visual-editor:edit-section', key}, origin); };
    blocks.forEach(block => {
        const key = 'block:' + block.dataset.editorBlockId;
        const button = document.createElement('button'); button.type = 'button'; button.className = 've-edit-button'; button.textContent = '✎ Edit';
        button.addEventListener('click', event => { event.preventDefault(); event.stopPropagation(); sendEdit(key); });
        block.prepend(button);
    });
    document.addEventListener('click', event => {
        const block = event.target.closest('[data-editor-block-id]');
        if (block) { event.preventDefault(); event.stopImmediatePropagation(); sendEdit('block:' + block.dataset.editorBlockId); }
        else if (event.target.closest('a, button, input[type="submit"]')) { event.preventDefault(); event.stopImmediatePropagation(); }
    }, true);
    document.addEventListener('submit', event => { event.preventDefault(); event.stopImmediatePropagation(); }, true);
    window.addEventListener('message', event => {
        if (event.origin !== origin || event.source !== window.parent || event.data?.type !== 'visual-editor:configure' || !Array.isArray(event.data.sections)) return;
        sections = new Map(event.data.sections.filter(section => section && typeof section.key === 'string').map(section => [section.key, section]));
        document.body.classList.toggle('ve-product-only', !event.data.showShell);
        blocks.forEach(block => {
            const key = 'block:' + block.dataset.editorBlockId;
            const section = sections.get(key);
            const button = block.querySelector(':scope > .ve-edit-button');
            if (section) { button.textContent = '✎ Edit ' + section.label; block.style.setProperty('--ve-color', section.color); }
            block.classList.toggle('ve-preview-selected', key === event.data.selectedKey);
        });
        const selected = blocks.find(block => 'block:' + block.dataset.editorBlockId === event.data.selectedKey);
        if (selected) selected.scrollIntoView({behavior: 'instant', block: 'center'});
    });
    window.parent.postMessage({type: 'visual-editor:ready'}, origin);
})();
