const puppeteer = require('puppeteer');
(async () => {
  if (!process || !process?.argv || process.argv.length < 3) {
    return false;
  }
  const url = process.argv[2];
  const fileName = process.argv[3];
  const browser = await puppeteer.launch({
    args: ['--window-size=1920,1080', "--no-sandbox", "--disabled-setupid-sandbox"],
    headless: 'new',
    defaultViewport: null
  });
  const page = await browser.newPage();
  await page.goto(url);
  await page.screenshot({ path: `/storage/app/public/${fileName}.png` });

  await browser.close();
})();