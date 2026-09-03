class ButtonTool {
    static get toolbox() {
        return {
            title: 'Button / ボタン',
            icon: '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M15.8 4.3H4.2c-1.1 0-2 .9-2 2v7.4c0 1.1.9 2 2 2h11.6c1.1 0 2-.9 2-2V6.3c0-1.1-.9-2-2-2zm.8 9.4c0 .4-.4.8-.8.8H4.2c-.4 0-.8-.4-.8-.8V6.3c0-.4.4-.8.8-.8h11.6c.4 0 .8.4.8.8v7.4z"/><rect x="5.2" y="9.2" width="9.6" height="1.6" rx=".8"/></svg>'
        };
    }

    constructor({ data, api, config }) {
        this.api = api;
        this.data = {
            text: data.text || '',
            link: data.link || '',
            color: data.color || '#007bff',
            alignment: data.alignment || 'center'
        };
        this.nodes = {
            wrapper: null,
            textInput: null,
            linkInput: null,
            colorInput: null,
            alignmentButtons: []
        };
        this.alignments = [
            { name: 'left', icon: '<svg width="16" height="11" viewBox="0 0 16 11"><path d="M0 0h10v2H0zM0 4h16v2H0zM0 8h10v2H0z"/></svg>' },
            { name: 'center', icon: '<svg width="16" height="11" viewBox="0 0 16 11"><path d="M3 0h10v2H3zM0 4h16v2H0zM3 8h10v2H3z"/></svg>' },
            { name: 'right', icon: '<svg width="16" height="11" viewBox="0 0 16 11"><path d="M6 0h10v2H6zM0 4h16v2H0zM6 8h10v2H6z"/></svg>' }
        ];
    }

    render() {
        this.nodes.wrapper = document.createElement('div');
        this.nodes.wrapper.classList.add('editorjs-button-tool');

        // Text Input
        const textWrapper = document.createElement('div');
        textWrapper.classList.add('editorjs-button-tool__input-wrapper');
        const textLabel = document.createElement('label');
        textLabel.textContent = 'Button Text';
        this.nodes.textInput = document.createElement('input');
        this.nodes.textInput.type = 'text';
        this.nodes.textInput.placeholder = 'Enter button text...';
        this.nodes.textInput.value = this.data.text;
        textWrapper.appendChild(textLabel);
        textWrapper.appendChild(this.nodes.textInput);

        // Link Input
        const linkWrapper = document.createElement('div');
        linkWrapper.classList.add('editorjs-button-tool__input-wrapper');
        const linkLabel = document.createElement('label');
        linkLabel.textContent = 'Link URL';
        this.nodes.linkInput = document.createElement('input');
        this.nodes.linkInput.type = 'text';
        this.nodes.linkInput.placeholder = 'https://...';
        this.nodes.linkInput.value = this.data.link;
        linkWrapper.appendChild(linkLabel);
        linkWrapper.appendChild(this.nodes.linkInput);

        // Color & Alignment Wrapper
        const settingsRow = document.createElement('div');
        settingsRow.style.display = 'flex';
        settingsRow.style.gap = '20px';
        settingsRow.style.alignItems = 'flex-end';

        // Color Input
        const colorWrapper = document.createElement('div');
        colorWrapper.classList.add('editorjs-button-tool__input-wrapper');
        colorWrapper.style.marginBottom = '0';
        const colorLabel = document.createElement('label');
        colorLabel.textContent = 'Button Color';
        this.nodes.colorInput = document.createElement('input');
        this.nodes.colorInput.type = 'color';
        this.nodes.colorInput.value = this.data.color;
        colorWrapper.appendChild(colorLabel);
        colorWrapper.appendChild(this.nodes.colorInput);

        // Alignment Buttons
        const alignWrapper = document.createElement('div');
        alignWrapper.classList.add('editorjs-button-tool__input-wrapper');
        alignWrapper.style.marginBottom = '0';
        const alignLabel = document.createElement('label');
        alignLabel.textContent = 'Alignment';
        const alignButtons = document.createElement('div');
        alignButtons.classList.add('editorjs-button-tool__align-wrapper');

        this.alignments.forEach(align => {
            const button = document.createElement('button');
            button.type = 'button';
            button.classList.add('editorjs-button-tool__align-button');
            if (this.data.alignment === align.name) {
                button.classList.add('active');
            }
            button.innerHTML = align.icon;
            button.title = align.name.charAt(0).toUpperCase() + align.name.slice(1);
            button.addEventListener('click', () => {
                this.data.alignment = align.name;
                this.nodes.alignmentButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
            this.nodes.alignmentButtons.push(button);
            alignButtons.appendChild(button);
        });

        alignWrapper.appendChild(alignLabel);
        alignWrapper.appendChild(alignButtons);

        settingsRow.appendChild(colorWrapper);
        settingsRow.appendChild(alignWrapper);

        this.nodes.wrapper.appendChild(textWrapper);
        this.nodes.wrapper.appendChild(linkWrapper);
        this.nodes.wrapper.appendChild(settingsRow);

        return this.nodes.wrapper;
    }

    save(blockContent) {
        return {
            text: this.nodes.textInput.value,
            link: this.nodes.linkInput.value,
            color: this.nodes.colorInput.value,
            alignment: this.data.alignment
        };
    }

    static get isTune() {
        return false;
    }
}
