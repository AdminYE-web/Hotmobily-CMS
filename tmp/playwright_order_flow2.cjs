const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1440, height: 1000 } });
  const page = await context.newPage();
  const nonGetRequests = [];
  const errors = { console: [], page: [], responses: [] };
  page.on('request', request => {
    if (request.method() !== 'GET') nonGetRequests.push({ method: request.method(), url: request.url(), postData: request.postData() });
  });
  page.on('console', message => { if (message.type() === 'error') errors.console.push(message.text()); });
  page.on('pageerror', error => errors.page.push(String(error)));
  page.on('response', response => { if (response.status() >= 400) errors.responses.push({ status: response.status(), url: response.url() }); });
  await page.goto('http://new-hotmobily.test/products/rubberstrap/', { waitUntil: 'networkidle', timeout: 30000 });

  const buttonState = async () => await page.locator('#configured-order-form button').evaluateAll(buttons => buttons.map(button => ({
    text: (button.innerText || '').replace(/\s+/g, ' ').trim(),
    visible: !!(button.offsetWidth || button.offsetHeight || button.getClientRects().length),
    disabled: button.disabled,
  })));
  const selected = async () => await page.locator('#configured-order-form input:checked').evaluateAll(elements => elements.map(element => ({ id: element.id || null, name: element.name, value: element.value })));
  const summary = async () => {
    const body = await page.locator('body').innerText();
    const start = body.indexOf('【ラバーストラップ】');
    return start >= 0 ? body.slice(start, start + 550) : null;
  };
  const visibleInputs = async () => await page.locator('#configured-order-form input, #configured-order-form select, #configured-order-form textarea').evaluateAll(elements => elements.filter(element => !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length)).map(element => ({ id: element.id || null, name: element.name, type: element.type, value: element.value, checked: 'checked' in element ? element.checked : undefined, disabled: element.disabled })));

  const before = { buttons: await buttonState(), selected: await selected(), summary: await summary() };

  const choices = [
    '#configured-option-1-2',
    '#configured-option-2-4',
    '#configured-option-7-18',
    '#configured-option-8-20',
    '#configured-option-9-22',
    '#configured-option-10-25',
    '#configured-option-11-27',
  ];
  for (const selector of choices) await page.locator(selector).evaluate(element => element.click());
  await page.locator('#configured-quantity-4').fill('100');
  await page.waitForTimeout(250);
  const configured = { selected: await selected(), summary: await summary(), invalid: await page.locator('#configured-order-form :invalid').evaluateAll(elements => elements.map(element => ({ id: element.id, name: element.name, message: element.validationMessage }))) };

  const step2Button = page.locator('#configured-order-form button').filter({ hasText: 'アタッチメント・台紙等へ' }).first();
  const step2Visible = await step2Button.isVisible();
  if (step2Visible) await step2Button.click();
  await page.waitForTimeout(350);
  const afterStep2 = { url: page.url(), buttons: await buttonState(), selected: await selected(), visibleInputs: await visibleInputs(), summary: await summary(), invalid: await page.locator('#configured-order-form :invalid').evaluateAll(elements => elements.map(element => ({ id: element.id, name: element.name, message: element.validationMessage }))) };

  const step3Button = page.locator('#configured-order-form button').filter({ hasText: '製品仕様・製作料金' }).first();
  const step3Visible = await step3Button.isVisible().catch(() => false);
  if (step3Visible) await step3Button.click();
  await page.waitForTimeout(350);
  const afterStep3 = { url: page.url(), buttons: await buttonState(), visibleInputs: await visibleInputs(), summary: await summary(), invalid: await page.locator('#configured-order-form :invalid').evaluateAll(elements => elements.map(element => ({ id: element.id, name: element.name, message: element.validationMessage }))) };

  console.log(JSON.stringify({ before, configured, step2Visible, afterStep2, step3Visible, afterStep3, nonGetRequests, errors }, null, 2));
  await browser.close();
})().catch(error => { console.error(error && error.stack || error); process.exitCode = 1; });
