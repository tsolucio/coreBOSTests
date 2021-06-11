const puppeteer = require('puppeteer')
const getUrlFromConfigFile = require('../../utils.js').getUrlFromConfigFile

test('Admin login', async () => {
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
		//await page.click('input#Login').then(() => page.waitForNavigation({waitUntil: 'load'}));
		//page.waitForNavigation({ waitUntil: 'load' })
		await page.waitForSelector('#global-header');
		const ptitle = await page.title()
		await expect(ptitle).toBe('Administrator - Home - coreBOS')
		const btn = await page.$eval('button[title="CRM Settings"]', el => el)
		await expect(btn).toBeTruthy()
		await page.close();
		await browser.close()
	} else {
		throw 'URL could not be determined from config file'
	}
})

test('Non Admin login', async () => {
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
		await page.type('input#username', 'testdmy')
		await page.type('input#password', 'testdmy')
		await page.click('input#Login')
		//await page.click('input#Login').then(() => page.waitForNavigation({waitUntil: 'load'}));
		//page.waitForNavigation({ waitUntil: 'load' })
		await page.waitForSelector('#global-header');
		const ptitle = await page.title()
		await expect(ptitle).toBe('cbTest testdmy - Home - coreBOS');
		const h1Handle = await page.$('button[title="CRM Settings"]');
		await expect(h1Handle).toBeNull() // it doesn't exist
		await page.close();
		await browser.close()
	} else {
		throw 'URL could not be determined from config file'
	}
})

test('Inactive user login', async () => {
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
		await page.type('input#username', 'testinactive')
		await page.type('input#password', 'testinactive')
		await page.click('input#Login')
		await page.waitForSelector('div.errorMessage');
		const divcnt = await page.$eval('div.errorMessage', el => el.innerHTML)
		await page.close();
		await browser.close()
		await expect(divcnt).toBe('You must specify a valid username and password.')
	} else {
		throw new Error('URL could not be determined from config file');
	}
})
