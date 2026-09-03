/**
 * Editor.js Standalone Package
 * Version: 1.0.0
 * 
 * A reusable Editor.js setup with all tools configured
 * Copy this folder to any project and include the files
 * 
 * Features included:
 * - Header (H1-H6)
 * - List (ordered/unordered with nesting)
 * - Checklist
 * - Quote
 * - Code
 * - Image (with upload support)
 * - Embed (YouTube, Vimeo, etc.)
 * - Table
 * - Delimiter
 * - Warning
 * - Raw HTML
 * - Inline tools: Bold, Italic, Link, Marker, Inline Code, Underline
 */

// Global Editor instance
let editorInstance = null;

/**
 * Initialize Editor.js
 * @param {Object} options - Configuration options
 * @param {string} options.holderId - ID of the container element (default: 'editorjs')
 * @param {string} options.uploadUrl - URL for image uploads (required for image tool)
 * @param {Object} options.data - Existing data to load into editor
 * @param {Function} options.onReady - Callback when editor is ready
 * @param {Function} options.onChange - Callback when content changes
 * @returns {EditorJS} Editor instance
 */
function initEditorJS(options = {}) {
    const holderId = options.holderId || 'editorjs';
    const uploadUrl = options.uploadUrl || '';
    const existingData = options.data || null;
    const onReady = options.onReady || function () { };
    const onChange = options.onChange || function () { };

    // Editor.js configuration
    const editorConfig = {
        holder: holderId,
        placeholder: options.placeholder || '書き始める...',

        tools: {
            // Paragraph Alignment Tune
            paragraphAlignment: {
                class: class ParagraphAlignmentTune {
                    static get isTune() {
                        return true;
                    }

                    constructor({ api, data, config, block }) {
                        this.api = api;
                        this.data = data || { alignment: 'left' };
                        this.block = block;
                        this.alignments = ['left', 'center', 'right'];
                    }

                    wrap(blockContent) {
                        // Apply saved alignment when block is rendered
                        setTimeout(() => {
                            const blockElement = this.block.holder;
                            if (blockElement && this.data.alignment) {
                                blockElement.dataset.alignment = this.data.alignment;

                                // Apply alignment to paragraph element
                                const paragraph = blockElement.querySelector('.ce-paragraph');
                                if (paragraph) {
                                    paragraph.style.textAlign = this.data.alignment;
                                }
                            }
                        }, 100);
                        return blockContent;
                    }

                    render() {
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('paragraph-alignment-tune');

                        this.alignments.forEach(alignment => {
                            const button = document.createElement('button');
                            button.type = 'button';
                            button.classList.add('cdx-settings-button');
                            button.dataset.alignment = alignment;

                            if (this.data.alignment === alignment) {
                                button.classList.add('cdx-settings-button--active');
                            }

                            button.innerHTML = this.getAlignmentIcon(alignment);
                            button.title = this.getAlignmentTitle(alignment);

                            button.addEventListener('click', () => {
                                this.data.alignment = alignment;
                                wrapper.querySelectorAll('.cdx-settings-button').forEach(btn => {
                                    btn.classList.remove('cdx-settings-button--active');
                                });
                                button.classList.add('cdx-settings-button--active');

                                // Apply alignment to block
                                const blockElement = this.block.holder;
                                blockElement.dataset.alignment = alignment;

                                // Apply alignment to paragraph element
                                const paragraph = blockElement.querySelector('.ce-paragraph');
                                if (paragraph) {
                                    paragraph.style.textAlign = alignment;
                                }
                            });

                            wrapper.appendChild(button);
                        });

                        return wrapper;
                    }

                    getAlignmentIcon(alignment) {
                        const icons = {
                            left: '<svg width="16" height="11" viewBox="0 0 16 11"><path d="M0 0h10v2H0zM0 4h16v2H0zM0 8h10v2H0z"/></svg>',
                            center: '<svg width="16" height="11" viewBox="0 0 16 11"><path d="M3 0h10v2H3zM0 4h16v2H0zM3 8h10v2H3z"/></svg>',
                            right: '<svg width="16" height="11" viewBox="0 0 16 11"><path d="M6 0h10v2H6zM0 4h16v2H0zM6 8h10v2H6z"/></svg>'
                        };
                        return icons[alignment];
                    }

                    getAlignmentTitle(alignment) {
                        const titles = {
                            left: 'Align Left',
                            center: 'Align Center',
                            right: 'Align Right'
                        };
                        return titles[alignment];
                    }

                    save() {
                        return this.data;
                    }
                }
            },

            // Paragraph Tool with Alignment Tune
            paragraph: {
                class: typeof Paragraph !== 'undefined' ? Paragraph : undefined,
                inlineToolbar: true,
                toolbox: {
                    title: 'Text / 文章'
                },
                config: {
                    placeholder: '書き始める ...',
                    preserveBlank: true
                },
                tunes: ['paragraphAlignment']
            },

            // Header Tool with Alignment Tune
            header: {
                class: Header,
                inlineToolbar: true,
                toolbox: {
                    title: 'Heading / 見出し'
                },
                config: {
                    placeholder: '見出しを入力...',
                    levels: [1, 2, 3, 4, 5, 6],
                    defaultLevel: 2
                },
                tunes: ['paragraphAlignment']
            },

            // List Tool (v2.0+ uses EditorjsList)
            list: {
                class: typeof EditorjsList !== 'undefined' ? EditorjsList : (typeof List !== 'undefined' ? List : NestedList),
                inlineToolbar: true,
                toolbox: {
                    title: 'List / リスト'
                },
                config: {
                    defaultStyle: 'unordered'
                }
            },

            // Checklist Tool
            checklist: {
                class: Checklist,
                inlineToolbar: true,
                toolbox: {
                    title: 'Checklist / チェックリスト'
                }
            },

            // Quote Tool
            quote: {
                class: Quote,
                inlineToolbar: true,
                toolbox: {
                    title: 'Quote / 引用'
                },
                config: {
                    quotePlaceholder: '引用文を入力...',
                    captionPlaceholder: '引用元'
                }
            },

            // Code Tool
            code: {
                class: CodeTool,
                toolbox: {
                    title: 'Code / コード'
                },
                config: {
                    placeholder: 'コードを入力...'
                }
            },

            // Image Tool with resize and alignment options (only if upload URL provided)
            ...(uploadUrl ? {
                image: {
                    class: ImageTool,
                    toolbox: {
                        title: 'Image / 画像'
                    },
                    config: {
                        endpoints: {
                            byFile: uploadUrl
                        },
                        field: 'image',
                        types: 'image/*',
                        captionPlaceholder: 'キャプションを入力...',
                        buttonContent: '画像を選択',
                        actions: [
                            {
                                name: 'size-small',
                                icon: '<svg width="17" height="10" viewBox="0 0 17 10"><rect width="6" height="10" rx="1"/></svg>',
                                title: 'Small (25%)',
                                toggle: true,
                                action: (name) => {
                                    return {
                                        size: 'small'
                                    };
                                }
                            },
                            {
                                name: 'size-medium',
                                icon: '<svg width="17" height="10" viewBox="0 0 17 10"><rect width="10" height="10" rx="1"/></svg>',
                                title: 'Medium (50%)',
                                toggle: true,
                                action: (name) => {
                                    return {
                                        size: 'medium'
                                    };
                                }
                            },
                            {
                                name: 'size-large',
                                icon: '<svg width="17" height="10" viewBox="0 0 17 10"><rect width="14" height="10" rx="1"/></svg>',
                                title: 'Large (75%)',
                                toggle: true,
                                action: (name) => {
                                    return {
                                        size: 'large'
                                    };
                                }
                            }
                        ]
                    },
                    tunes: ['imageAlignment', 'imageSize']
                }
            } : {}),

            // Image Alignment Tune
            imageAlignment: {
                class: class ImageAlignmentTune {
                    static get isTune() {
                        return true;
                    }

                    constructor({ api, data, config, block }) {
                        this.api = api;
                        this.data = data || { alignment: 'center' };
                        this.block = block;
                        this.alignments = ['left', 'center', 'right'];
                    }

                    wrap(blockContent) {
                        // Apply saved alignment when block is rendered
                        setTimeout(() => {
                            const blockElement = this.block.holder;
                            if (blockElement && this.data.alignment) {
                                blockElement.dataset.alignment = this.data.alignment;
                            }
                        }, 100);
                        return blockContent;
                    }

                    render() {
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('image-alignment-tune');

                        this.alignments.forEach(alignment => {
                            const button = document.createElement('button');
                            button.type = 'button';
                            button.classList.add('cdx-settings-button');
                            button.dataset.alignment = alignment;

                            if (this.data.alignment === alignment) {
                                button.classList.add('cdx-settings-button--active');
                            }

                            button.innerHTML = this.getAlignmentIcon(alignment);
                            button.title = alignment.charAt(0).toUpperCase() + alignment.slice(1);

                            button.addEventListener('click', () => {
                                this.data.alignment = alignment;
                                wrapper.querySelectorAll('.cdx-settings-button').forEach(btn => {
                                    btn.classList.remove('cdx-settings-button--active');
                                });
                                button.classList.add('cdx-settings-button--active');

                                // Apply alignment to block
                                const blockElement = this.block.holder;
                                blockElement.dataset.alignment = alignment;
                            });

                            wrapper.appendChild(button);
                        });

                        return wrapper;
                    }

                    getAlignmentIcon(alignment) {
                        const icons = {
                            left: '<svg width="16" height="11" viewBox="0 0 16 11"><path d="M0 0h10v2H0zM0 4h16v2H0zM0 8h10v2H0z"/></svg>',
                            center: '<svg width="16" height="11" viewBox="0 0 16 11"><path d="M3 0h10v2H3zM0 4h16v2H0zM3 8h10v2H3z"/></svg>',
                            right: '<svg width="16" height="11" viewBox="0 0 16 11"><path d="M6 0h10v2H6zM0 4h16v2H0zM6 8h10v2H6z"/></svg>'
                        };
                        return icons[alignment];
                    }

                    save() {
                        return this.data;
                    }
                }
            },

            // Image Size Tune
            imageSize: {
                class: class ImageSizeTune {
                    static get isTune() {
                        return true;
                    }

                    constructor({ api, data, config, block }) {
                        this.api = api;
                        this.data = data || { size: 'full' };
                        this.block = block;
                        this.sizes = [
                            { name: 'small', label: '25%', width: '25%' },
                            { name: 'medium', label: '50%', width: '50%' },
                            { name: 'large', label: '75%', width: '75%' },
                            { name: 'full', label: '100%', width: '100%' }
                        ];
                    }

                    wrap(blockContent) {
                        // Apply saved size when block is rendered
                        setTimeout(() => {
                            const blockElement = this.block.holder;
                            if (blockElement && this.data.size) {
                                blockElement.dataset.size = this.data.size;

                                // Find the size config and apply width
                                const sizeConfig = this.sizes.find(s => s.name === this.data.size);
                                if (sizeConfig) {
                                    const img = blockElement.querySelector('img');
                                    if (img) {
                                        img.style.width = sizeConfig.width;
                                    }
                                }
                            }
                        }, 100);
                        return blockContent;
                    }

                    render() {
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('image-size-tune');

                        this.sizes.forEach(size => {
                            const button = document.createElement('button');
                            button.type = 'button';
                            button.classList.add('cdx-settings-button');
                            button.dataset.size = size.name;
                            button.textContent = size.label;
                            button.title = `Set image width to ${size.label}`;

                            if (this.data.size === size.name) {
                                button.classList.add('cdx-settings-button--active');
                            }

                            button.addEventListener('click', () => {
                                this.data.size = size.name;
                                wrapper.querySelectorAll('.cdx-settings-button').forEach(btn => {
                                    btn.classList.remove('cdx-settings-button--active');
                                });
                                button.classList.add('cdx-settings-button--active');

                                // Apply size to block
                                const blockElement = this.block.holder;
                                blockElement.dataset.size = size.name;

                                // Update image width
                                const img = blockElement.querySelector('img');
                                if (img) {
                                    img.style.width = size.width;
                                }
                            });

                            wrapper.appendChild(button);
                        });

                        return wrapper;
                    }

                    save() {
                        return this.data;
                    }
                }
            },

            // Embed Tool (YouTube, Vimeo, etc.)
            embed: {
                class: Embed,
                toolbox: {
                    title: 'Embed / 埋め込み'
                },
                config: {
                    services: {
                        youtube: true,
                        vimeo: true,
                        coub: true,
                        codepen: true,
                        twitter: true,
                        instagram: true
                    }
                }
            },

            // Table Tool
            table: {
                class: Table,
                inlineToolbar: true,
                toolbox: {
                    title: 'Table / テーブル'
                },
                config: {
                    rows: 2,
                    cols: 3
                }
            },

            // Delimiter Tool
            delimiter: {
                class: Delimiter,
                toolbox: {
                    title: 'Delimiter / 区切り線'
                }
            },

            // Warning Tool
            warning: {
                class: Warning,
                inlineToolbar: true,
                toolbox: {
                    title: 'Warning / 警告'
                },
                config: {
                    titlePlaceholder: 'タイトル',
                    messagePlaceholder: 'メッセージ'
                }
            },

            // Raw HTML Tool
            raw: {
                class: RawTool,
                toolbox: {
                    title: 'Raw HTML / HTMLコード'
                },
                config: {
                    placeholder: 'HTMLコードを入力...'
                }
            },

            // Register your custom tool here
            box: {
                class: SimpleBox,
                inlineToolbar: true,
                toolbox: {
                    title: 'Box / ボックス'
                }
            },

            button: {
                class: ButtonTool,
                inlineToolbar: true,
                toolbox: {
                    title: 'Button / ボタン'
                },
                tunes: ['paragraphAlignment']
            },

            anchor: {
                class: AnchorTool,
                toolbox: {
                    title: 'Anchor / アンカー'
                }
            },

            spacer: {
                class: SpacerTool,
                toolbox: {
                    title: 'Spacer / 空白'
                }
            },

            // Inline Tools
            inlineCode: {
                class: InlineCode
            },

            marker: {
                class: Marker
            },

            underline: {
                class: Underline
            }
        },

        // Load existing data if provided
        data: existingData && existingData.blocks ? existingData : undefined,

        // Events
        onReady: function () {
            console.log('Editor.js is ready!');
            onReady();
        },

        onChange: function (api, event) {
            onChange(api, event);
        }
    };

    // Create editor instance
    editorInstance = new EditorJS(editorConfig);
    return editorInstance;
}

/**
 * Get current editor data
 * @returns {Promise<Object>} Editor data in JSON format
 */
async function getEditorData() {
    if (!editorInstance) {
        console.warn('Editor not initialized');
        return { blocks: [] };
    }

    try {
        const data = await editorInstance.save();
        return data;
    } catch (error) {
        console.error('Error saving editor data:', error);
        return { blocks: [] };
    }
}

/**
 * Clear editor content
 */
async function clearEditor() {
    if (editorInstance) {
        await editorInstance.clear();
    }
}

/**
 * Destroy editor instance
 */
function destroyEditor() {
    if (editorInstance) {
        editorInstance.destroy();
        editorInstance = null;
    }
}

/**
 * Render Editor.js data to HTML
 * @param {Object|string} data - Editor.js JSON data
 * @returns {string} HTML string
 */
function renderEditorData(data) {
    const parsedData = typeof data === 'string' ? JSON.parse(data) : data;

    if (!parsedData || !parsedData.blocks || parsedData.blocks.length === 0) {
        return '<p>No content available.</p>';
    }

    let html = '';

    parsedData.blocks.forEach(block => {
        html += renderBlock(block);
    });

    return html;
}

/**
 * Render a single block to HTML
 * @param {Object} block - Block data
 * @returns {string} HTML string
 */
function renderBlock(block) {
    const type = block.type || '';
    const data = block.data || {};

    switch (type) {
        case 'paragraph':
            const pAlignment = data.alignment || 'left';
            return `<p style="text-align: ${pAlignment};">${data.text || ''}</p>`;

        case 'header':
            const level = Math.min(6, Math.max(1, data.level || 2));
            return `<h${level}>${data.text || ''}</h${level}>`;

        case 'list':
            return renderList(data);

        case 'checklist':
            return renderChecklist(data);

        case 'quote':
            let quoteHtml = `<blockquote><p>${data.text || ''}</p>`;
            if (data.caption) {
                quoteHtml += `<cite>— ${data.caption}</cite>`;
            }
            quoteHtml += '</blockquote>';
            return quoteHtml;

        case 'code':
            const escapedCode = (data.code || '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return `<pre><code>${escapedCode}</code></pre>`;

        case 'image':
            return renderImage(data, block.tunes || {});

        case 'embed':
            return `<div class="embed-block"><iframe src="${data.embed || ''}" width="${data.width || 580}" height="${data.height || 320}" frameborder="0" allowfullscreen></iframe></div>`;

        case 'table':
            return renderTable(data);

        case 'delimiter':
            return '<div class="delimiter">***</div>';

        case 'warning':
            return `<div class="warning-block"><div class="warning-title">${data.title || ''}</div><div class="warning-message">${data.message || ''}</div></div>`;

        case 'raw':
            return data.html || '';

        case 'box':
            return data.html || '';

        case 'button':
            return renderButton(data, block.tunes || {});

        case 'anchor':
            return renderAnchor(data);

        case 'spacer':
            return renderSpacer(data);

        default:
            return '';
    }
}

function renderList(data) {
    const items = data.items || [];
    const tag = data.style === 'ordered' ? 'ol' : 'ul';

    let html = `<${tag}>`;
    items.forEach(item => {
        if (typeof item === 'object') {
            html += `<li>${item.content || ''}`;
            if (item.items && item.items.length > 0) {
                html += renderList({ items: item.items, style: data.style });
            }
            html += '</li>';
        } else {
            html += `<li>${item}</li>`;
        }
    });
    html += `</${tag}>`;

    return html;
}

function renderChecklist(data) {
    const items = data.items || [];
    let html = '<ul class="checklist">';

    items.forEach(item => {
        const checkedClass = item.checked ? 'checked' : '';
        html += `<li><span class="checkbox ${checkedClass}"></span><span>${item.text || ''}</span></li>`;
    });

    html += '</ul>';
    return html;
}

function renderImage(data, tunes = {}) {
    const url = data.file?.url || '';
    const caption = data.caption || '';
    const classes = ['image-block'];
    const styles = [];

    if (data.withBorder) classes.push('with-border');
    if (data.stretched) classes.push('stretched');
    if (data.withBackground) classes.push('with-background');

    // Handle alignment from tunes
    const alignment = tunes.imageAlignment?.alignment || data.alignment || 'center';
    classes.push(`align-${alignment}`);

    // Handle size from tunes
    const size = tunes.imageSize?.size || data.size || 'full';
    classes.push(`size-${size}`);

    // Set width based on size
    const sizeWidths = {
        'small': '25%',
        'medium': '50%',
        'large': '75%',
        'full': '100%'
    };
    const imgWidth = sizeWidths[size] || '100%';

    let html = `<figure class="${classes.join(' ')}">`;
    html += `<img src="${url}" alt="${caption}" style="width: ${imgWidth};">`;
    if (caption) {
        html += `<figcaption>${caption}</figcaption>`;
    }
    html += '</figure>';

    return html;
}

function renderTable(data) {
    const content = data.content || [];
    const withHeadings = data.withHeadings || false;

    if (content.length === 0) return '';

    let html = '<table>';
    content.forEach((row, index) => {
        html += '<tr>';
        const cellTag = (withHeadings && index === 0) ? 'th' : 'td';
        row.forEach(cell => {
            html += `<${cellTag}>${cell}</${cellTag}>`;
        });
        html += '</tr>';
    });
    html += '</table>';

    return html;
}

function renderButton(data, tunes = {}) {
    const text = data.text || '';
    const link = data.link || '#';
    const color = data.color || '#007bff';
    const alignment = data.alignment || tunes.paragraphAlignment?.alignment || 'center';

    return `
        <div class="button-block" style="text-align: ${alignment}; margin: 20px 0;">
            <a href="${link}" class="custom-button" style="background-color: ${color}; color: white; padding: 10px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                ${text}
            </a>
        </div>
    `;
}

function renderAnchor(data) {
    const anchor = data.anchor || '';
    if (!anchor) return '';
    return `<div id="${anchor}" class="blog-anchor" style="padding-top: 20px; margin-top: -20px;"></div>`;
}

function renderSpacer(data) {
    const height = data.height || 30;
    return `<div class="blog-spacer" style="height: ${height}px;"></div>`;
}

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initEditorJS,
        getEditorData,
        clearEditor,
        destroyEditor,
        renderEditorData
    };
}
