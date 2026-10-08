const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1440, height: 1000 } });
  const page = await context.newPage();
  const nonGetRequests = [];
  const consoleErrors = [];
  const pageErrors = [];
  const responseErrors = [];
  page.on('request', request => {
    if (request.method() !== 'GET') nonGetRequests.push({ method: request.method(), url: request.url(), postData: request.postData() });
  });
  page.on('console', message => { if (message.type() === 'error') consoleErrors.push(message.text()); });
  page.on('pageerror', error => pageErrors.push(String(error)));
  page.on('response', response => { if (response.status() >= 400) responseErrors.push({ status: response.status(), url: response.url() }); });
  await page.goto('http://new-hotmobily.test/products/rubberstrap/', { waitUntil: 'networkidle', timeout: 30000 });

  const clickInput = async selector => await page.locator(selector).evaluate(element => element.click());
  const selected = async () => await page.locator('#configured-order-form input:checked').evaluateAll(elements => elements.map(element => ({ id: element.id || null, name: element.name, value: element.value })));
  const bodySnippet = async (needle, length = 900) => {
    const body = await page.locator('body').innerText();
    const index = body.indexOf(needle);
    return index >= 0 ? body.slice(index, index + length) : null;
  };
  const buttons = async () => await page.locator('#configured-order-form button').evaluateAll(elements => elements.map(element => ({ text: (element.innerText || '').replace(/\s+/g, ' ').trim(), visible: !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length), disabled: element.disabled })));
  const invalid = async () => await page.locator('#configured-order-form :invalid').evaluateAll(elements => elements.map(element => ({ id: element.id || null, name: element.name, message: element.validationMessage })));

  for (const selector of [
    '#configured-option-1-2',
    '#configured-option-2-4',
    '#configured-option-7-18',
    '#configured-option-8-20',
    '#configured-option-9-22',
    '#configured-option-10-25',
    '#configured-option-11-27',
  ]) await clickInput(selector);
  await page.locator('#configured-quantity-4').fill('100');
  await page.locator('#configured-order-form button').filter({ hasText: 'アタッチメント・台紙等へ' }).first().click();
  await page.waitForTimeout(250);
  const afterStep2 = { selected: await selected(), buttons: await buttons(), invalid: await invalid(), snippet: await bodySnippet('アタッチメント必須') };

  const attachmentInfo = await page.locator('#configured-order-form input[name="product_options[3]"]').evaluateAll(elements => elements.map(element => ({
    id: element.id,
    value: element.value,
    checked: element.checked,
    visible: !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length),
    label: element.labels?.[0]?.outerHTML.slice(0, 1000) || null,
  })));
  await clickInput('#configured-option-3-8');
  const afterAttachment = { selected: await selected(), invalid: await invalid(), snippet: await bodySnippet('アタッチメント必須') };

  const step3 = page.locator('#configured-order-form button').filter({ hasText: '製品仕様・製作料金へ' }).first();
  const step3Visible = await step3.isVisible();
  if (step3Visible) await step3.click();
  await page.waitForTimeout(350);
  const afterStep3 = { url: page.url(), selected: await selected(), buttons: await buttons(), invalid: await invalid(), snippet: await bodySnippet('製品仕様・製作料金', 1800) };

  const finalButton = page.locator('#configured-order-form button').filter({ hasText: 'ご注文情報入力へ' }).first();
  const finalVisible = await finalButton.isVisible().catch(() => false);
  if (finalVisible) await finalButton.click();
  await page.waitForTimeout(500);
  const afterFinal = { url: page.url(), title: await page.title(), selected: await selected().catch(() => []), body: (await page.locator('body').innerText()).slice(-7000), invalid: await page.locator('form :invalid').evaluateAll(elements => elements.map(element => ({ id: element.id || null, name: element.name, message: element.validationMessage }))).catch(() => []) };

  console.log(JSON.stringify({ afterStep2, attachmentInfo, afterAttachment, step3Visible, afterStep3, finalVisible, afterFinal, nonGetRequests, consoleErrors, pageErrors, responseErrors }, null, 2));
  await browser.close();
})().catch(error => { console.error(error && error.stack || error); process.exitCode = 1; });
