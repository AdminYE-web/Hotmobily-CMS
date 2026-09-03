class SpacerTool {
    static get toolbox() {
        return {
            title: 'Spacer / スペーサー',
            icon: '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M10 2l-4 4h3v8H6l4 4 4-4h-3V6h3l-4-4z"/></svg>'
        };
    }

    constructor({ data, api, config }) {
        this.api = api;
        this.data = {
            height: data.height || 30
        };
        this.nodes = {
            wrapper: null,
            input: null,
            preview: null
        };
        this.presets = [15, 30, 60, 100];
    }

    render() {
        this.nodes.wrapper = document.createElement('div');
        this.nodes.wrapper.classList.add('editorjs-spacer-tool');

        const label = document.createElement('div');
        label.classList.add('editorjs-spacer-tool__label');
        label.innerHTML = '↕ Spacer Height (px)';

        const inputWrapper = document.createElement('div');
        inputWrapper.classList.add('editorjs-spacer-tool__input-wrapper');

        this.nodes.input = document.createElement('input');
        this.nodes.input.type = 'number';
        this.nodes.input.value = this.data.height;
        this.nodes.input.min = 0;
        this.nodes.input.max = 500;
        this.nodes.input.classList.add('editorjs-spacer-tool__input');

        const presetsWrapper = document.createElement('div');
        presetsWrapper.classList.add('editorjs-spacer-tool__presets');

        this.presets.forEach(height => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = height + 'px';
            btn.classList.add('editorjs-spacer-tool__preset-btn');
            btn.addEventListener('click', () => {
                this.nodes.input.value = height;
                this.data.height = height;
                this._updatePreview();
            });
            presetsWrapper.appendChild(btn);
        });

        this.nodes.input.addEventListener('input', () => {
            this.data.height = parseInt(this.nodes.input.value) || 0;
            this._updatePreview();
        });

        this.nodes.preview = document.createElement('div');
        this.nodes.preview.classList.add('editorjs-spacer-tool__preview');
        this._updatePreview();

        inputWrapper.appendChild(this.nodes.input);
        inputWrapper.appendChild(presetsWrapper);

        this.nodes.wrapper.appendChild(label);
        this.nodes.wrapper.appendChild(inputWrapper);
        this.nodes.wrapper.appendChild(this.nodes.preview);

        return this.nodes.wrapper;
    }

    _updatePreview() {
        if (this.nodes.preview) {
            this.nodes.preview.style.height = this.data.height + 'px';
        }
    }

    save(blockContent) {
        return {
            height: parseInt(this.nodes.input.value) || 30
        };
    }

    static get isTune() {
        return false;
    }
}
