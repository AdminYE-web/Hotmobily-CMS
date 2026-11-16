(() => {
    function parse(text, {priceHeaders = ['unit price']} = {}) {
        text = String(text).replace(/^\uFEFF/, '');
        const rows = [];
        let row = [], field = '', quoted = false, closed = false;
        const finishField = () => {row.push(field.trim()); field = ''; closed = false;};
        const finishRow = () => {finishField(); if (row.some(value => value !== '')) rows.push(row); row = [];};
        for (let index = 0; index < text.length; index++) {
            const character = text[index];
            if (quoted) {
                if (character === '"' && text[index + 1] === '"') {field += '"'; index++;}
                else if (character === '"') {quoted = false; closed = true;}
                else field += character;
            } else if (character === '"') {
                if (field.trim() || closed) throw Error('Invalid quotation marks in CSV.');
                field = ''; quoted = true;
            } else if (character === ',') finishField();
            else if (character === '\r' || character === '\n') {
                finishRow();
                if (character === '\r' && text[index + 1] === '\n') index++;
            } else {
                if (closed && character.trim()) throw Error('Unexpected text after a quoted CSV value.');
                field += character;
            }
        }
        if (quoted) throw Error('A quoted CSV value was not closed.');
        finishRow();
        const headers = rows.shift()?.map(value => value.toLowerCase().replace(/[_-]/g, ' ').replace(/\s+/g, ' '));
        const priceHeader = headers?.find(header => priceHeaders.includes(header));
        if (!headers || headers.length !== 2 || !headers.includes('quantity') || !priceHeader) throw Error(priceHeaders.includes('additional price') ? 'Expected CSV headers: Quantity,Additional Price (or Unit Price).' : 'Expected CSV headers: Quantity,Unit Price.');
        if (!rows.length) throw Error('The CSV contains no price tiers.');
        if (rows.length > 1000) throw Error('Import no more than 1,000 price tiers at a time.');
        const quantityIndex = headers.indexOf('quantity'), priceIndex = headers.indexOf(priceHeader);
        const quantities = new Set();
        const numeric = value => /^(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d{1,2})?$/.test(value);
        return rows.map((cells, index) => {
            if (cells.length !== 2) throw Error(`CSV row ${index + 2}: expected 2 columns.`);
            const quantityText = cells[quantityIndex], priceText = cells[priceIndex];
            const quantity = Number(quantityText.replace(/,/g, ''));
            const price = Number(priceText.replace(/,/g, ''));
            if (!numeric(quantityText) || !Number.isSafeInteger(quantity) || quantity < 1) throw Error(`CSV row ${index + 2}: Quantity must be a positive whole number.`);
            if (!numeric(priceText) || !Number.isFinite(price) || price < 0) throw Error(`CSV row ${index + 2}: Unit Price must be a non-negative number with no more than 2 decimal places.`);
            if (quantities.has(quantity)) throw Error(`CSV row ${index + 2}: duplicate Quantity ${quantity}.`);
            quantities.add(quantity);
            return {quantity:String(quantity), unit_price:price.toFixed(2), unit_price_with_tax:'', unit_price_with_tax_manual:false};
        });
    }
    window.PriceTierCsv = {parse};
})();
