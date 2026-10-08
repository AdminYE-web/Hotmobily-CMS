const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1440, height: 1000 } });
  const page = await context.newPage();
  const nonGetRequests = [];
  const events = [];
  const errors = { console: [], page: [], responses: [] };
  page.on('request', request => { if (request.method() !== 'GET') nonGetRequests.push({ method: request.method(), url: request.url(), postData: request.postData() }); });
  page.on('console', message => { if (message.type() === 'error') errors.console.push(message.text()); });
  page.on('pageerror', error => errors.page.push(String(error)));
  page.on('response', response => { if (response.status() >= 400) errors.responses.push({ status: response.status(), url: response.url() }); });
  context.on('page', popup => events.push({ type: 'new-page', url: popup.url() }));
  await page.goto('http://new-hotmobily.test/products/rubberstrap/', { waitUntil: 'networkidle', timeout: 30000 });

  const clickInput = async selector => page.locator(selector).evaluate(element => element.click());
  const summary = async () => {
    const body = await page.locator('body').innerText();
    const index = body.lastIndexOf('ご注文・見積書作成');
    return body.slice(index, index + 1300);
  };
  const configure = async () => {
    for (const selector of [
      '#configured-option-1-2', '#configured-option-2-4', '#configured-option-7-18',
      '#configured-option-8-20', '#configured-option-9-22', '#configured-option-10-25', '#configured-option-11-27',
    ]) await clickInput(selector);
    await page.locator('#configured-quantity-4').fill('100');
    await page.locator('#configured-order-form button').filter({ hasText: 'アタッチメント・台紙等へ' }).first().click();
    await clickInput('#configured-option-3-8');
    await page.locator('#configured-order-form button').filter({ hasText: '製品仕様・製作料金へ' }).first().click();
    await page.waitForTimeout(250);
  };

  const marketing = await page.locator('body').innerText();
  await configure();
  const beforeFinal = await page.locator('#configured-order-form button').filter({ hasText: 'ご注文情報入力へ' }).first().evaluate(button => ({
    outerHTML: button.outerHTML,
    type: button.type,
    disabled: button.disabled,
    visible: !!(button.offsetWidth || button.offsetHeight || button.getClientRects().length),
    formAction: button.form?.getAttribute('action'),
    formMethod: button.form?.getAttribute('method'),
    formValid: button.form?.checkValidity(),
  }));
  await page.evaluate(() => {
    window.__orderEvents = [];
    const form = document.querySelector('#configured-order-form');
    const button = [...form.querySelectorAll('button')].find(element => element.innerText.includes('ご注文情報入力へ'));
    document.addEventListener('click', event => { if (event.target.closest('#configured-order-form')) window.__orderEvents.push({ type: 'click', target: event.target.closest('button')?.innerText || event.target.tagName }); }, true);
    form.addEventListener('submit', event => window.__orderEvents.push({ type: 'submit', defaultPrevented: event.defaultPrevented }), true);
    window.__orderButton = button;
  });
  const priceAt = async quantity => {
    await page.locator('#configured-quantity-4').fill(String(quantity));
    await page.waitForTimeout(150);
    return { quantity: await page.locator('#configured-quantity-4').inputValue(), summary: await summary() };
  };
  const prices = [await priceAt(100), await priceAt(200), await priceAt(300)];

  await page.locator('#configured-order-form button').filter({ hasText: 'ご注文情報入力へ' }).first().click();
  await page.waitForTimeout(800);
  const finalBody = await page.locator('body').innerText();
  const orderInfoTerms = ['ご注文情報', 'お名前', '会社名', 'メールアドレス', '電話番号', '見積'];
  const afterFinal = {
    url: page.url(),
    pages: context.pages().map(currentPage => currentPage.url()),
    events: await page.evaluate(() => window.__orderEvents),
    visibleButtons: await page.locator('#configured-order-form button').evaluateAll(elements => elements.filter(element => !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length)).map(element => ({ text: (element.innerText || '').replace(/\s+/g, ' ').trim(), type: element.type, disabled: element.disabled }))),
    visibleCustomerFields: await page.locator('input[name^="estimate_customer"], textarea[name^="estimate_customer"], select[name^="estimate_customer"]').evaluateAll(elements => elements.filter(element => !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length)).map(element => ({ name: element.name, type: element.type, value: element.value, required: element.required }))),
    currentStepText: orderInfoTerms.map(term => ({ term, present: finalBody.includes(term) })).filter(item => item.present),
    orderInfoSnippet: (() => { const indexes = orderInfoTerms.map(term => finalBody.indexOf(term)).filter(index => index >= 0); const start = indexes.length ? Math.min(...indexes) : Math.max(0, finalBody.length - 2500); return finalBody.slice(start, start + 3000); })(),
  };

  console.log(JSON.stringify({
    marketingSnippet: marketing.slice(marketing.indexOf('参考単価'), marketing.indexOf('業界最速・最安級')),
    beforeFinal,
    prices,
    afterFinal,
    nonGetRequests,
    errors,
  }, null, 2));
  await browser.close();
})().catch(error => { console.error(error && error.stack || error); process.exitCode = 1; });
