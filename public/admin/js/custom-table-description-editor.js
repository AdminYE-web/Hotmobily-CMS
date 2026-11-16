(() => {
    'use strict';
    const instances = new Map();
    function destroy(textarea, state) {
        state.editor?.destroy();
        instances.delete(textarea);
    }
    window.CustomTableDescriptionEditor = {
        bind() {
            for (const [textarea, state] of instances) if (!textarea.isConnected) destroy(textarea, state);
            if (!window.ClassicEditor) return;
            document.querySelectorAll('.flex-table-description').forEach(textarea => {
                if (instances.has(textarea)) return;
                const state = {};
                instances.set(textarea, state);
                ClassicEditor.create(textarea, {
                    toolbar:['heading','|','bold','italic','link','|','bulletedList','numberedList','|','undo','redo'],
                    link:{defaultProtocol:'https://',addTargetToExternalLinks:true},
                }).then(editor => {
                    if (!textarea.isConnected || instances.get(textarea) !== state) { editor.destroy(); return; }
                    state.editor = editor;
                    editor.model.document.on('change:data', () => {
                        textarea.value = editor.getData();
                        textarea.dispatchEvent(new Event('input', {bubbles:true}));
                    });
                }).catch(() => { instances.delete(textarea); });
            });
        },
    };
})();
