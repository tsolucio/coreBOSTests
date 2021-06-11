const puppeteer = require('puppeteer')
const getUrlFromConfigFile = require('../../utils.js').getUrlFromConfigFile

test('Adding inventorylines should not set deleted lines to deleted = 0', async () => {
	jest.setTimeout(30000);
	const url = getUrlFromConfigFile();
	if (!!url) {
		// Uncomment this section to actually see the test happening
		const browser = await puppeteer.launch({
			// headless: false,
			// slowMo: 80,
			// args: ['--window-size=1920,1080'],
			defaultViewport: null
		})

		const page = await browser.newPage()
		await page.goto(url)
		await page.type('input#username', 'admin')
		await page.type('input#password', 'admin')
		await page.click('input#Login')
		await page.goto(
			url + '/index.php?module=SalesOrder&action=DetailView&record=10616'
		)
		await page.click('button[name=Edit]')
		await page.waitForSelector('#row10');
		await page.click('tr#row10 > td > img')
		await page.click('tr#row9 > td > img')
		await page.click('.create:first-child');
		const lastRowDeleteStatus = await page.$eval('#deleted10', el => el.value);
		await expect(lastRowDeleteStatus).toBe('1');
		await page.close();
		await browser.close();
	} else {
		throw new Error('URL could not be determined from config file');
	}
})