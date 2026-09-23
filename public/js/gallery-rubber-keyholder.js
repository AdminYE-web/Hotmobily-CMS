(function () {
    'use strict';

    const root = document.querySelector('[data-rubber-keyholder-gallery]');

    if (!root) {
        return;
    }

    const items = Array.from(root.querySelectorAll('[data-gallery-item]'));
    const tagButtons = Array.from(root.querySelectorAll('[data-gallery-tag]'));
    const pageContainers = Array.from(root.querySelectorAll('[data-gallery-pages]'));
    const pageCounts = Array.from(root.querySelectorAll('[data-gallery-page-count]'));
    const previousButtons = Array.from(root.querySelectorAll('[data-gallery-previous]'));
    const nextButtons = Array.from(root.querySelectorAll('[data-gallery-next]'));
    const filterEmpty = root.querySelector('[data-gallery-filter-empty]');
    let activeTag = '';
    let page = 0;
    let itemsPerPage = window.innerWidth < 768 ? 10 : 40;
    let resizeTimer = null;

    function itemTags(item) {
        return (item.dataset.tags || '')
            .split(/[,、，]/)
            .map((tag) => tag.trim())
            .filter(Boolean);
    }

    function activeItems() {
        if (!activeTag) {
            return items;
        }

        return items.filter((item) => itemTags(item).includes(activeTag));
    }

    function pageNumbers(totalPages) {
        const current = page + 1;

        if (totalPages <= 7) {
            return Array.from({ length: totalPages }, (_, index) => index + 1);
        }

        const numbers = [1];
        let start = Math.max(2, current - 1);
        let end = Math.min(totalPages - 1, current + 1);

        if (current <= 4) {
            start = 2;
            end = 5;
        }

        if (current >= totalPages - 3) {
            start = totalPages - 4;
            end = totalPages - 1;
        }

        if (start > 2) {
            numbers.push('ellipsis-left');
        }

        for (let number = start; number <= end; number += 1) {
            numbers.push(number);
        }

        if (end < totalPages - 1) {
            numbers.push('ellipsis-right');
        }

        numbers.push(totalPages);

        return numbers;
    }

    function renderPager(totalPages) {
        const numbers = pageNumbers(totalPages);

        pageContainers.forEach((container) => {
            container.innerHTML = '';

            numbers.forEach((number) => {
                if (typeof number === 'string') {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'page-ellipsis';
                    ellipsis.textContent = '…';
                    container.appendChild(ellipsis);
                    return;
                }

                const button = document.createElement('button');
                button.type = 'button';
                button.className = `page-btn${number === page + 1 ? ' active' : ''}`;
                button.dataset.page = String(number - 1);
                button.textContent = String(number);
                button.setAttribute('aria-label', `ページ ${number}`);
                if (number === page + 1) {
                    button.setAttribute('aria-current', 'page');
                }
                container.appendChild(button);
            });
        });
    }

    function render(scrollToTop) {
        const filteredItems = activeItems();
        const totalPages = Math.max(1, Math.ceil(filteredItems.length / itemsPerPage));

        page = Math.max(0, Math.min(page, totalPages - 1));

        items.forEach((item) => {
            item.hidden = true;
        });

        filteredItems
            .slice(page * itemsPerPage, (page + 1) * itemsPerPage)
            .forEach((item) => {
                item.hidden = false;
            });

        renderPager(totalPages);

        pageCounts.forEach((count) => {
            count.textContent = `${page + 1}/${totalPages}ページ`;
        });

        previousButtons.forEach((button) => {
            button.disabled = page === 0;
            button.classList.toggle('is-disabled', page === 0);
        });

        nextButtons.forEach((button) => {
            button.disabled = page >= totalPages - 1;
            button.classList.toggle('is-disabled', page >= totalPages - 1);
        });

        if (filterEmpty) {
            filterEmpty.hidden = items.length === 0 || filteredItems.length !== 0;
        }

        if (scrollToTop) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    function truncateComments() {
        root.querySelectorAll('[data-gallery-comment]').forEach((cell) => {
            const textContent = (cell.textContent || '').trim();
            const maxLength = 40;

            if (textContent.length <= maxLength) {
                return;
            }

            cell.textContent = textContent.slice(0, maxLength);

            const readMore = document.createElement('a');
            readMore.href = 'javascript:void(0)';
            readMore.className = 'read';
            readMore.textContent = '詳しくはこちら...';

            const moreText = document.createElement('span');
            moreText.className = 'more-text';
            moreText.textContent = textContent.slice(maxLength);

            cell.append(readMore, moreText);
        });
    }

    function activateThumbnail(thumbnail) {
        const card = thumbnail.closest('[data-gallery-item]');
        const imageId = thumbnail.id || '';

        if (!card || !imageId) {
            return;
        }

        let activePanel = null;

        card.querySelectorAll('.preview-top .rubber').forEach((panel) => {
            const isActive = panel.id === imageId;
            panel.classList.toggle('is-active', isActive);
            panel.style.display = isActive ? '' : 'none';
            if (isActive) {
                activePanel = panel;
            }
        });

        card.querySelectorAll('[data-gallery-thumbnail]').forEach((image) => {
            image.classList.toggle('is-active', image === thumbnail);
        });

        const activeLink = activePanel
            ? activePanel.querySelector('[data-gallery-main-link]')
            : null;
        const activeImage = activePanel
            ? activePanel.querySelector('[data-gallery-main-image]')
            : null;
        const zoomUrl = activeImage ? activeImage.dataset.zoomImage : '';

        if (activeLink && zoomUrl) {
            activeLink.href = zoomUrl;
        }
    }

    root.addEventListener('click', (event) => {
        const readMore = event.target.closest('.read');
        if (readMore) {
            const moreText = readMore.nextElementSibling;
            if (moreText && moreText.classList.contains('more-text')) {
                moreText.replaceWith(document.createTextNode(moreText.textContent || ''));
            }
            readMore.remove();
            return;
        }

        const tagButton = event.target.closest('[data-gallery-tag]');
        if (tagButton) {
            const selectedTag = tagButton.dataset.galleryTag || '';
            activeTag = activeTag === selectedTag ? '' : selectedTag;
            tagButtons.forEach((button) => {
                button.classList.toggle('active', button.dataset.galleryTag === activeTag);
            });
            page = 0;
            render(false);
            return;
        }

        const pageButton = event.target.closest('[data-page]');
        if (pageButton) {
            page = Number.parseInt(pageButton.dataset.page || '0', 10) || 0;
            render(true);
            return;
        }

        if (event.target.closest('[data-gallery-next]')) {
            page += 1;
            render(true);
            return;
        }

        if (event.target.closest('[data-gallery-previous]')) {
            page -= 1;
            render(true);
            return;
        }

        const thumbnail = event.target.closest('[data-gallery-thumbnail]');
        if (thumbnail) {
            activateThumbnail(thumbnail);
        }
    });

    root.querySelectorAll('[data-gallery-thumbnail]').forEach((thumbnail) => {
        thumbnail.addEventListener('click', () => activateThumbnail(thumbnail));
        thumbnail.addEventListener('mouseenter', () => activateThumbnail(thumbnail));
    });

    window.addEventListener('resize', () => {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(() => {
            const newItemsPerPage = window.innerWidth < 768 ? 10 : 40;
            if (newItemsPerPage !== itemsPerPage) {
                itemsPerPage = newItemsPerPage;
                page = 0;
                render(false);
            }
        }, 120);
    });

    const initialTag = new URLSearchParams(window.location.search).get('tag') || '';
    if (tagButtons.some((button) => button.dataset.galleryTag === initialTag)) {
        activeTag = initialTag;
        tagButtons.forEach((button) => {
            button.classList.toggle('active', button.dataset.galleryTag === activeTag);
        });
    }

    if (window.lightbox && typeof window.lightbox.option === 'function') {
        window.lightbox.option({
            maxWidth: 800,
            maxHeight: 600,
            alwaysShowNavOnTouchDevices: true,
        });
    }

    if (window.innerWidth < 768 && typeof window.initPhotoSwipeFromDOM === 'function') {
        window.initPhotoSwipeFromDOM('.my-gallery');
        root.querySelectorAll('a[data-lightbox]').forEach((link) => {
            link.removeAttribute('data-lightbox');
        });
    }

    truncateComments();
    render(false);
}());
