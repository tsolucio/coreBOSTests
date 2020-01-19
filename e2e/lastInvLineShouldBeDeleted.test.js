const puppeteer = require('puppeteer')
const fs = require('fs')

test('Adding inventorylines should not set deleted lines to deleted = 0', async () => {
	jest.setTimeout(30000);
	const configLines = fs.readFileSync('../../config.inc.php').toString().split("\n");
	var url = false;
	configLines.forEach(line => {
		let r = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[\-;:&=\+\$,\w]+@)?[A-Za-z0-9\.\-]+|(?:www\.|[\-;:&=\+\$,\w]+@)[A-Za-z0-9\.\-]+)((?:\/[\+~%\/\.\w\-_]*)?\??(?:[\-\+=&;%@\.\w_]*)#?(?:[\.\!\/\\\w]*))?)/;
		if (line.match(r) !== null) {
			url = line.match(r)[0];
		}
	})
	if (!!url) {
		// Uncomment this section to actually see the test happening
		const browser = await puppeteer.launch({
			headless: false,
			slowMo: 80,
			args: ['--window-size=1920,1080'],
			defaultViewport: null
		})

		// Comment this line when you want to see what's happening
		// const browser = await puppeteer.launch({headless: true})
		const page = await browser.newPage()
		await page.goto(url)
		await page.type('input#username', 'admin')
		await page.type('input#password', 'admin')
		await page.click('input#Login')
		await page.goto(
			url + '/index.php?module=SalesOrder&parenttab=ptab&action=DetailView&record=10616'
		)
		await page.click('input[name=Edit]')
		await page.click('tr#row10 > td > img')
		await page.click('tr#row9 > td > img')
		await page.click('.create:first-child')
		const lastRowDeleteStatus = await page.$eval('#deleted10', el => el.value)
		expect(lastRowDeleteStatus).toBe('1')
	} else {
		throw 'URL could not be determined from config file'
	}
})