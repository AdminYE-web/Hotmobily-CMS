const { chromium } = require('playwright');

(async () => {
  const url = 'http://new-hotmobily.test/products/rubberstrap/';
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1440, height: 1000 } });
  const page = await context.newPage();
  const requestLog = [];
  const responseErrors = [];
  const consoleErrors = [];
  const pageErrors = [];
  page.on('request', request => {
    if (request.method() !== 'GET') requestLog.push({ method: request.method(), url: request.url(), postData: request.postData() });
  });
  page.on('response', response => {
    if (response.status() >= 400) responseErrors.push({ status: response.status(), url: response.url() });
  });
  page.on('console', message => {
    if (message.type() === 'error') consoleErrors.push(message.text());
  });
  page.on('pageerror', error => pageErrors.push(String(error)));
  await page.goto(url, { waitUntil: 'networkidle', timeout: 30000 });

  const initial = await page.locator('#configured-order-form').evaluate(form => {
    const clean = value => String(value || '').replace(/\s+/g, ' ').trim();
    const elements = [...form.querySelectorAll('input, select, textarea, button')];
    return {
      action: form.getAttribute('action'),
      method: form.getAttribute('method'),
      buttons: [...form.querySelectorAll('button, input[type="submit"]')].map(element => ({
        text: clean(element.innerText || element.value),
        type: element.getAttribute('type'),
        name: element.getAttribute('name'),
        id: element.id || null,
        disabled: element.disabled,
      })),
      fields: elements.filter(element => element.tagName.toLowerCase() !== 'button').map(element => ({
        tag: element.tagName.toLowerCase(),
        id: element.id || null,
        name: element.getAttribute('name'),
        type: element.getAttribute('type'),
        value: element.value,
        checked: 'checked' in element ? element.checked : undefined,
        required: element.required,
        disabled: element.disabled,
        labels: [...element.labels || []].map(label => clean(label.innerText)),
      })),
    };
  });

  const anchor = await page.locator('a, button').filter({ hasText: 'この商品を見積・注文する' }).first().evaluate(element => ({
    tag: element.tagName.toLowerCase(),
    text: element.innerText.trim(),
    href: element.getAttribute('href'),
    type: element.getAttribute('type'),
  })).catch(() => null);

  const priceBefore = await page.locator('body').innerText();
  const priceAt = text => {
    const index = text.indexOf('【ラバーストラップ】');
    return index >= 0 ? text.slice(index, index + 220) : null;
  };

  const quantity = page.locator('#configured-quantity-4');
  const quantityBefore = await quantity.inputValue();
  const selectedBefore = await page.locator('#configured-order-form input[type="radio"]:checked, #configured-order-form input[type="checkbox"]:checked').evaluateAll(elements => elements.map(element => ({ id: element.id, name: element.name, value: element.value })));

  const nonGetBefore = requestLog.length;
  await quantity.fill('200');
  await quantity.dispatchEvent('change');
  await page.waitForTimeout(250);
  const afterQuantity = {
    value: await quantity.inputValue(),
    snippet: priceAt(await page.locator('body').innerText()),
  };

  const nextButton = page.locator('#configured-order-form button').filter({ hasText: 'ご注文情報入力へ' }).first();
  const nextVisible = await nextButton.isVisible().catch(() => false);
  let nextError = null;
  let afterNext = null;
  if (nextVisible) {
    await nextButton.click();
    await page.waitForTimeout(400);
    afterNext = {
      url: page.url(),
      snippet: (await page.locator('body').innerText()).slice(-5000),
      activeElement: await page.evaluate(() => ({ tag: document.activeElement?.tagName, id: document.activeElement?.id, name: document.activeElement?.getAttribute('name') })),
      invalidFields: await page.locator('#configured-order-form :invalid').evaluateAll(elements => elements.map(element => ({ id: element.id, name: element.name, validationMessage: element.validationMessage }))),
    };
  } else {
    nextError = 'Next-step button not visible';
  }

  console.log(JSON.stringify({
    initial,
    anchor,
    quantityBefore,
    selectedBefore,
    afterQuantity,
    next: { visible: nextVisible, error: nextError, after: afterNext },
    requestsAfterInteractions: requestLog.slice(nonGetBefore),
    allNonGetRequests: requestLog,
    responseErrors,
    consoleErrors,
    pageErrors,
  }, null, 2));
  await browser.close();
})().catch(error => {
  console.error(error && error.stack || error);
  process.exitCode = 1;
});
