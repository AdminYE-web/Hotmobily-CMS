// Pointer dragging keeps wheel events available while reusing the form's reorder handlers.
(() => {
    document.addEventListener('DOMContentLoaded', () => {
        const scope = document.querySelector('.product-options-manager');
        if (!scope) return;
        const handles = '.option-group-handle, .option-row-handle, .summary-row-handle';
        let drag = null, frame = 0, target = null, label = null, wheelUntil = 0;

        function dispatch(element, type) {
            element.dispatchEvent(new DragEvent(type, {bubbles:true, cancelable:true, clientX:drag.x, clientY:drag.y}));
        }
        function updateTarget() {
            if (!drag?.active) return;
            const under = document.elementFromPoint(drag.x, drag.y);
            let next = under?.closest(drag.selector);
            if (!next || next.parentElement !== drag.parent || next === drag.source) next = null;
            if (target !== next) {
                target?.classList.remove('option-order-drop-target');
                target = next;
                target?.classList.add('option-order-drop-target');
            }
            if (target) dispatch(target, 'dragover');
            if (label) {
                label.style.left = Math.max(4, Math.min(drag.x + 14, innerWidth - label.offsetWidth - 4)) + 'px';
                label.style.top = Math.max(4, Math.min(drag.y + 14, innerHeight - label.offsetHeight - 4)) + 'px';
            }
        }
        function scrollContainers() {
            const containers = [];
            let element = document.elementFromPoint(drag.x, drag.y);
            while (element && element !== document.documentElement) {
                const css = getComputedStyle(element);
                if (/(auto|scroll)/.test(css.overflowY) && element.scrollHeight > element.clientHeight) containers.push(element);
                element = element.parentElement;
            }
            if (document.scrollingElement && !containers.includes(document.scrollingElement)) containers.push(document.scrollingElement);
            return containers;
        }
        function scroll(dx, dy) {
            for (const element of scrollContainers()) {
                const before = element.scrollTop, beforeX = element.scrollLeft;
                element.scrollBy({top:dy, left:dx, behavior:'instant'});
                if (element.scrollTop !== before || element.scrollLeft !== beforeX) return true;
            }
            return false;
        }
        function tick() {
            if (!drag?.active) return;
            if (!drag.source.isConnected) {finish(false); return;}
            if (performance.now() > wheelUntil) {
                const container = scrollContainers()[0];
                if (container) {
                    const box = container === document.scrollingElement ? {top:0, bottom:innerHeight} : container.getBoundingClientRect();
                    const edge = Math.min(90, (box.bottom - box.top) / 3);
                    const top = Math.max(0, Math.min(1, (box.top + edge - drag.y) / edge));
                    const bottom = Math.max(0, Math.min(1, (drag.y - box.bottom + edge) / edge));
                    const dy = Math.round((bottom - top) * 18);
                    if (dy) scroll(0, dy);
                }
            }
            updateTarget();
            frame = requestAnimationFrame(tick);
        }
        function finish(drop) {
            if (!drag) return;
            const current = drag;
            try {
                if (current.active && drop) {
                    updateTarget();
                    if (target?.isConnected) dispatch(target, 'drop');
                }
            } finally {
                if (current.active) dispatch(current.source, 'dragend');
                if (current.handle.hasPointerCapture?.(current.pointerId)) current.handle.releasePointerCapture(current.pointerId);
                current.source.classList.remove('is-dragging');
                target?.classList.remove('option-order-drop-target');
                target = null;
                label?.remove(); label = null;
                document.body.classList.remove('option-order-dragging');
                cancelAnimationFrame(frame); frame = 0;
                drag = null;
            }
        }
        scope.addEventListener('pointerdown', event => {
            const handle = event.target.closest(handles);
            if (!handle || event.button !== 0) return;
            const source = handle.closest('[draggable="true"]');
            if (!source) return;
            finish(false);
            event.preventDefault();
            drag = {handle, source, parent:source.parentElement, pointerId:event.pointerId, x:event.clientX, y:event.clientY, startX:event.clientX, startY:event.clientY, active:false,
                selector:source.matches('.option-group-card') ? '.option-group-card' : source.matches('.option-row') ? '.option-row' : '.summary-row'};
            handle.setPointerCapture?.(event.pointerId);
        });
        document.addEventListener('pointermove', event => {
            if (!drag || event.pointerId !== drag.pointerId) return;
            drag.x = event.clientX; drag.y = event.clientY;
            if (!drag.active && Math.hypot(drag.x - drag.startX, drag.y - drag.startY) >= 5) {
                drag.active = true;
                dispatch(drag.source, 'dragstart');
                document.body.classList.add('option-order-dragging');
                label = document.createElement('div');
                label.className = 'option-order-drag-label';
                label.setAttribute('aria-hidden', 'true');
                label.textContent = drag.source.querySelector('.option-group-title strong, .summary-row-name strong, strong')?.textContent || 'Reordering';
                document.body.appendChild(label);
                wheelUntil = 0;
                frame = requestAnimationFrame(tick);
            }
            if (drag.active) {event.preventDefault(); updateTarget();}
        }, {passive:false});
        document.addEventListener('wheel', event => {
            if (!drag?.active) return;
            event.preventDefault();
            const scale = event.deltaMode === 1 ? 16 : event.deltaMode === 2 ? innerHeight : 1;
            scroll(event.deltaX * scale, event.deltaY * scale);
            wheelUntil = performance.now() + 250;
            updateTarget();
        }, {capture:true, passive:false});
        document.addEventListener('pointerup', event => {if (drag?.pointerId === event.pointerId) finish(true);});
        document.addEventListener('pointercancel', () => finish(false));
        document.addEventListener('keydown', event => {if (event.key === 'Escape' && drag) {event.preventDefault(); finish(false);}});
        window.addEventListener('blur', () => finish(false));
        // Disable native browser dragging; the handle supplies pointer-based dragging instead.
        scope.addEventListener('dragstart', event => {
            if (event.isTrusted) {event.preventDefault(); event.stopImmediatePropagation();}
        }, true);
    });
})();
