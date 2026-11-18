(() => {
    const descriptions = {
        heading: 'A heading for a section of the page.',
        head_section: 'A main section heading with its description.',
        head_sub_section: 'A smaller heading inside a section.',
        guide_main: 'Cards linking to your guide pages.',
        rich_text: 'Formatted text with paragraphs, lists and links.',
        image: 'An image with an optional caption.',
        step_information: 'An image and instructions for one step.',
        multi_photo: 'Multiple photos displayed together with a caption.',
        youtube: 'A video thumbnail that opens the YouTube player.',
        related_blogs: 'Article images, titles and links.',
        button: 'A button linking to a page or action.',
        template_button: 'A button for downloading a template file.',
        text_link: 'A text link or a downloadable file.',
        custom_table: 'A table with editable cells, widths and merged rows.',
        info_card: 'An image, heading, description and optional link.',
        accordion: 'A section visitors can expand or collapse.',
        usage_examples: 'Image cards showing how a product is used.',
        product_anatomy: 'Product images with descriptive callouts, connector lines and editable points.',
        gallery_showcase: 'Selected Gallery images with titles, tag filters and image zoom.',
        product_catalog: 'Product cards filtered by category buttons.',
        custom_faq: 'Icon links to FAQ categories or other pages.',
        x_posts: 'Embedded public X posts arranged in columns.',
        attachment_gallery: 'Attachment images with prices and enlarged details.',
        option_card_grid: 'Tabs containing product options or information cards.',
        product_header: 'The product title and introductory text.',
        product_gallery: 'Product images displayed as a gallery.',
        product_details: 'Pricing, shipping estimates and product highlights.',
        faq: 'Frequently asked questions for the product.',
        review: 'Customer ratings and reviews.',
        price_matrix: 'A price table that changes with selected options.',
        price_accordion: 'An expandable section with product prices.',
        shipping_schedule: 'Estimated shipping dates for your delivery options.',
        production_schedule: 'Production information and delivery timing.',
        divider: 'A horizontal line separating sections.',
        spacer: 'An adjustable empty space between components.',
    };
    window.ComponentPalettePreview = {
        init({render}) {
            const buttons = [...document.querySelectorAll('.builder-sidebar .component-button[data-type]')];
            if (!buttons.length || document.getElementById('component-palette-preview')) return;
            const popup = document.createElement('div');
            popup.id = 'component-palette-preview'; popup.className = 'component-palette-preview';
            popup.setAttribute('role', 'tooltip'); popup.hidden = true;
            popup.innerHTML = '<div class="component-palette-preview-header"><small>Component preview</small><strong class="component-palette-preview-title"></strong><p class="component-palette-preview-description"></p></div><div class="component-palette-preview-viewport"><div class="component-palette-preview-sample" inert aria-hidden="true"></div></div><div class="component-palette-preview-footer">Example appearance. Configure the content after adding the component.</div>';
            document.body.append(popup);
            let active = null, showTimer = null, hideTimer = null, dragging = false;
            function position(button) {
                const rect = button.getBoundingClientRect(), width = popup.offsetWidth, height = popup.offsetHeight;
                const right = rect.right + 12, left = rect.left - width - 12;
                const x = right + width <= window.innerWidth - 12 ? right : left >= 12 ? left : Math.max(12, (window.innerWidth - width) / 2);
                let y = rect.top;
                if (right + width > window.innerWidth - 12 && left < 12) y = rect.bottom + 8;
                popup.style.left = x + 'px';
                popup.style.top = Math.max(12, Math.min(y, window.innerHeight - height - 12)) + 'px';
            }
            function hide() {
                clearTimeout(showTimer); clearTimeout(hideTimer);
                if (active) {
                    const ids = (active.getAttribute('aria-describedby') || '').split(/\s+/).filter(id => id && id !== popup.id);
                    if (ids.length) active.setAttribute('aria-describedby', ids.join(' '));
                    else active.removeAttribute('aria-describedby');
                }
                active = null; popup.hidden = true;
                popup.querySelector('.component-palette-preview-sample').replaceChildren();
            }
            function show(button) {
                clearTimeout(showTimer); clearTimeout(hideTimer);
                if (dragging || document.body.classList.contains('modal-open') || document.querySelector('.sortable-drag, .sortable-ghost')) return;
                hide(); active = button;
                const label = button.cloneNode(true); label.querySelectorAll('span').forEach(el => el.remove());
                popup.querySelector('.component-palette-preview-title').textContent = label.textContent.trim().replace(/\s+/g, ' ');
                popup.querySelector('.component-palette-preview-description').textContent = descriptions[button.dataset.type] || 'A configurable page component.';
                const sample = popup.querySelector('.component-palette-preview-sample');
                sample.innerHTML = render(button.dataset.type);
                sample.querySelectorAll('[id]').forEach(el => el.removeAttribute('id'));
                sample.querySelectorAll('input, select, textarea, button').forEach(el => el.disabled = true);
                const ids = new Set((button.getAttribute('aria-describedby') || '').split(/\s+/).filter(Boolean));
                ids.add(popup.id); button.setAttribute('aria-describedby', [...ids].join(' '));
                popup.hidden = false;
                popup.style.width = Math.min(420, window.innerWidth - 24) + 'px';
                popup.querySelector('.component-palette-preview-viewport').scrollTop = 0;
                position(button);
            }
            const laterHide = () => {clearTimeout(showTimer); clearTimeout(hideTimer); hideTimer = setTimeout(hide, 120);};
            buttons.forEach(button => {
                button.addEventListener('pointerenter', event => {
                    if (event.pointerType === 'touch') return;
                    hide(); showTimer = setTimeout(() => show(button), 180);
                });
                button.addEventListener('pointerleave', laterHide);
                button.addEventListener('focus', () => requestAnimationFrame(() => {if (document.activeElement === button) show(button);}));
                button.addEventListener('blur', laterHide);
                button.addEventListener('click', hide, {capture:true});
            });
            popup.addEventListener('pointerenter', () => clearTimeout(hideTimer));
            popup.addEventListener('pointerleave', laterHide);
            document.addEventListener('keydown', event => {if (event.key === 'Escape') hide();});
            document.addEventListener('pointerdown', event => {if (!popup.contains(event.target)) hide();});
            document.addEventListener('dragstart', () => {dragging = true; hide();}, true);
            document.addEventListener('dragend', () => {dragging = false;}, true);
            document.addEventListener('drop', () => {dragging = false; hide();}, true);
            window.addEventListener('resize', hide);
            window.addEventListener('scroll', event => {if (!popup.hidden && !popup.contains(event.target)) hide();}, true);
            if (window.ResizeObserver) new ResizeObserver(() => {if (active && !popup.hidden) position(active);}).observe(popup);
        },
    };
})();
