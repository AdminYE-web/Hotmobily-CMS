class SimpleBox {
    static get enableLineBreaks() {
        return true;
    }

    static get toolbox() {
        return {
            title: 'Box / ボックス',
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>'
        };
    }

    constructor({ data }) {
        this.data = data || {};
        this.wrapper = undefined;
        this.titleInput = undefined;
        this.contentInput = undefined;
    }

    render() {
        this.wrapper = document.createElement('div');
        this.wrapper.classList.add('simple-box');

        // Title input (single line)
        const titleWrapper = document.createElement('div');
        titleWrapper.classList.add('simple-box__title-wrapper');
        
        this.titleInput = document.createElement('input');
        this.titleInput.type = 'text';
        this.titleInput.classList.add('simple-box__title');
        this.titleInput.placeholder = 'セクション...';
        this.titleInput.style.width = '30%';
        if (this.data.title) {
            this.titleInput.value = this.data.title;
        }
        titleWrapper.appendChild(this.titleInput);

        // Content input (multi-line textarea)
        this.contentInput = document.createElement('textarea');
        this.contentInput.classList.add('simple-box__content');
        this.contentInput.placeholder = '内容を入力...';
        this.contentInput.rows = 3;
        this.contentInput.style.width = '30%';
        if (this.data.content) {
            this.contentInput.value = this.data.content;
        }

        // Auto-resize textarea
        this.contentInput.addEventListener('input', () => {
            this.contentInput.style.height = 'auto';
            this.contentInput.style.height = this.contentInput.scrollHeight + 'px';
        });

        // Move to content on Enter in title
        this.titleInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.contentInput.focus();
            }
        });

        this.wrapper.appendChild(titleWrapper);
        this.wrapper.appendChild(this.contentInput);

        // Trigger auto-resize if there's existing content
        if (this.data.content) {
            setTimeout(() => {
                this.contentInput.style.height = 'auto';
                this.contentInput.style.height = this.contentInput.scrollHeight + 'px';
            }, 0);
        }

        return this.wrapper;
    }

    save() {
        return {
            title: this.titleInput ? this.titleInput.value : '',
            content: this.contentInput ? this.contentInput.value : ''
        };
    }
}