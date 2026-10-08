const { chromium } = require('playwright');

(async () => {
  const url = 'http://new-hotmobily.test/products/rubberstrap/';
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1440, height: 1000 } });
  const page = await context.newPage();
  const consoleMessages = [];
  const pageErrors = [];
  const requests = [];
  const responses = [];
  page.on('console', message => consoleMessages.push({ type: message.type(), text: message.text() }));
  page.on('pageerror', error => pageErrors.push(String(error)));
  page.on('request', request => requests.push({ method: request.method(), url: request.url() }));
  page.on('response', response => {
    if (response.status() >= 400) responses.push({ status: response.status(), url: response.url() });
  });

  let navigationError = null;
  let response = null;
  try {
    response = await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 30000 });
    await page.waitForLoadState('networkidle', { timeout: 15000 }).catch(() => {});
  } catch (error) {
    navigationError = String(error && error.stack || error);
  }

  const pageData = await page.evaluate(() => {
    const clean = value => String(value || '').replace(/\s+/g, ' ').trim();
    const attrs = element => ({
      tag: element.tagName.toLowerCase(),
      text: clean(element.innerText || element.textContent),
      id: element.id || null,
      name: element.getAttribute('name'),
      type: element.getAttribute('type'),
      href: element.getAttribute('href'),
      action: element.getAttribute('action'),
      method: element.getAttribute('method'),
      aria: element.getAttribute('aria-label'),
      className: clean(element.className),
    });
    const orderKeywords = /order|cart|basket|checkout|สั่งซื้อ|ตะกร้า|ชำระ|จำนวน|quantity|add to/i;
    const candidates = [...document.querySelectorAll('button, a, input, select, textarea, form, [role="button"]')]
      .map(attrs)
      .filter(item => orderKeywords.test([item.text, item.id, item.name, item.type, item.href, item.action, item.aria, item.className].filter(Boolean).join(' ')));
    return {
      title: document.title,
      url: location.href,
      bodyText: clean(document.body.innerText).slice(0, 20000),
      forms: [...document.forms].map(attrs),
      orderCandidates: candidates,
      buttons: [...document.querySelectorAll('button')].map(attrs),
      inputs: [...document.querySelectorAll('input, select, textarea')].map(attrs),
    };
  });

  console.log(JSON.stringify({
    navigation: { url, finalUrl: page.url(), status: response && response.status(), navigationError },
    pageData,
    consoleMessages,
    pageErrors,
    failedResponses: responses,
    requestCount: requests.length,
    requests: requests.slice(-40),
  }, null, 2));
  await browser.close();
})().catch(error => {
  console.error(error && error.stack || error);
  process.exitCode = 1;
});
