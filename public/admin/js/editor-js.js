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
        placeholder: options.placeholder || 'Start writing...',

        tools: {
            // Header Tool
            header: {
                class: Header,
                inlineToolbar: true,
                config: {
                    placeholder: 'Enter a header',
                    levels: [1, 2, 3, 4, 5, 6],
                    defaultLevel: 2
                }
            },

            // List Tool (v2.0+ uses EditorjsList)
            list: {
                class: typeof EditorjsList !== 'undefined' ? EditorjsList : (typeof List !== 'undefined' ? List : NestedList),
                inlineToolbar: true,
                config: {
                    defaultStyle: 'unordered'
                }
            },

            // Checklist Tool
            checklist: {
                class: Checklist,
                inlineToolbar: true
            },

            // Quote Tool
            quote: {
                class: Quote,
                inlineToolbar: true,
                config: {
                    quotePlaceholder: 'Enter a quote',
                    captionPlaceholder: 'Quote author'
                }
            },

            // Code Tool
            code: {
                class: CodeTool,
                config: {
                    placeholder: 'Enter code here...'
                }
            },

            // Image Tool (only if upload URL provided)
            ...(uploadUrl ? {
                image: {
                    class: ImageTool,
                    config: {
                        endpoints: {
                            byFile: uploadUrl
                        },
                        field: 'image',
                        types: 'image/*',
                        captionPlaceholder: 'Image caption',
                        buttonContent: 'Select an image'
                    }
                }
            } : {}),

            // Embed Tool (YouTube, Vimeo, etc.)
            embed: {
                class: Embed,
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
                config: {
                    rows: 2,
                    cols: 3
                }
            },

            // Delimiter Tool
            delimiter: Delimiter,

            // Warning Tool
            warning: {
                class: Warning,
                inlineToolbar: true,
                config: {
                    titlePlaceholder: 'Title',
                    messagePlaceholder: 'Message'
                }
            },

            // Raw HTML Tool
            raw: {
                class: RawTool,
                config: {
                    placeholder: 'Enter HTML code here...'
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
            return `<p>${data.text || ''}</p>`;

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
            return renderImage(data);

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

function renderImage(data) {
    const url = data.file?.url || '';
    const caption = data.caption || '';
    const classes = ['image-block'];

    if (data.withBorder) classes.push('with-border');
    if (data.stretched) classes.push('stretched');
    if (data.withBackground) classes.push('with-background');

    let html = `<figure class="${classes.join(' ')}">`;
    html += `<img src="${url}" alt="${caption}">`;
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
