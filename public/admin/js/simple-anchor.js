class AnchorTool {
    static get toolbox() {
        return {
            title: 'Anchor / アンカー',
            icon: '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M10 2c-.6 0-1 .4-1 1v2.1c-1.7.2-3 1.7-3 3.4v1.5c-1.1 0-2 .9-2 2s.9 2 2 2v2.5c0 .6.4 1 1 1s1-.4 1-1V12h4v2.5c0 .6.4 1 1 1s1-.4 1-1V12c1.1 0 2-.9 2-2s-.9-2-2-2v-1.5c0-1.7-1.3-3.2-3-3.4V3c0-.6-.4-1-1-1zm0 5c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/></svg>'
        };
    }

    constructor({ data, api, config }) {
        this.api = api;
        this.data = {
            anchor: data.anchor || ''
        };
        this.nodes = {
            wrapper: null,
            input: null
        };
    }

    render() {
        this.nodes.wrapper = document.createElement('div');
        this.nodes.wrapper.classList.add('editorjs-anchor-tool');

        const label = document.createElement('div');
        label.classList.add('editorjs-anchor-tool__label');
        label.innerHTML = '⚓ Anchor ID (Jump Link)';

        this.nodes.input = document.createElement('input');
        this.nodes.input.type = 'text';
        this.nodes.input.placeholder = 'e.g. section-1';
        this.nodes.input.value = this.data.anchor;
        this.nodes.input.classList.add('editorjs-anchor-tool__input');

        this.nodes.wrapper.appendChild(label);
        this.nodes.wrapper.appendChild(this.nodes.input);

        return this.nodes.wrapper;
    }

    save(blockContent) {
        return {
            anchor: this.nodes.input.value.trim().replace(/\s+/g, '-').toLowerCase()
        };
    }

    static get isTune() {
        return false;
    }
}
