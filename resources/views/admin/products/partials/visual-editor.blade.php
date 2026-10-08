<div id="visual-editor" class="ve" data-mode="form">
    <div class="ve-toolbar">
        <button type="button" id="ve-toggle" class="btn btn-primary" aria-pressed="false">Visual Editor <span id="ve-mode-label">OFF</span></button>
        <button type="button" id="ve-back" class="btn btn-outline-primary" hidden>Back to Preview</button>
        <button type="button" id="ve-refresh" class="btn btn-outline-secondary" hidden>Refresh Preview</button>
        <button type="button" id="ve-sections-toggle" class="btn btn-outline-secondary" aria-expanded="true" hidden>Page Sections</button>
        <label id="ve-shell-label" class="mb-0 small" hidden><input type="checkbox" id="ve-show-shell"> Show site header and sidebar</label>
        <span id="ve-status" class="text-muted small" role="status" aria-live="polite"></span>
    </div>
    <div id="ve-workspace" class="ve-workspace" hidden>
        <div class="ve-preview">
            <iframe id="ve-frame" title="Product visual editor preview" sandbox="allow-scripts allow-same-origin"></iframe>
        </div>
        <aside id="ve-sidebar" class="ve-sidebar" aria-label="Page Sections">
            <div class="ve-sidebar-header"><strong>Visual Editor Mode</strong><span class="ve-on">ON</span><button type="button" id="ve-close-sections" aria-label="Close Page Sections">×</button></div>
            <p class="ve-hint">กด Edit บนหน้า หรือเลือกส่วนด้านล่างเพื่อแก้ไข</p>
            <h2>Page Sections</h2>
            <div id="ve-section-list"></div>
        </aside>
    </div>
</div>
