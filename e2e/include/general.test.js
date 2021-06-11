const puppeteer = require('puppeteer')
const getUrlFromConfigFile = require('../../utils.js').getUrlFromConfigFile

test('splitDateVal', async () => {
	jest.setTimeout(30000);
	const url = getUrlFromConfigFile();
	if (!!url) {
		// Uncomment this section to actually see the test happening
		const browser = await puppeteer.launch({
			// headless: false,
			slowMo: 80,
			// args: ['--window-size=1920,1080'],
			defaultViewport: null
		})

		const page = await browser.newPage()
		await page.goto(url)
		await page.type('input#username', 'admin')
		await page.type('input#password', 'admin')
		await page.click('input#Login')
		await page.waitForSelector('#global-header');
		let sdv1 = await page.evaluate(() => splitDateVal())
		await expect(sdv1).toEqual(new Array(null, null, null))
		//////////////
		let usrDF = await page.evaluate(() => userDateFormat)
		await expect(usrDF).toBe('yyyy-mm-dd')
		sdv1 = await page.evaluate(() => splitDateVal('2020-02-01'))
		await expect(sdv1).toEqual(new Array('01', '02', '2020'))
		sdv1 = await page.evaluate(() => splitDateVal('2020.02.01'))
		await expect(sdv1).toEqual(new Array('01', '02', '2020'))
		sdv1 = await page.evaluate(() => splitDateVal('2020/02/01'))
		await expect(sdv1).toEqual(new Array('01', '02', '2020'))
		//////////////
		await page.goto(url+'/index.php?module=Users&action=Logout')
		await page.waitForSelector('#username');
		await page.type('input#username', 'testdmy')
		await page.type('input#password', 'testdmy')
		await page.click('input#Login')
		await page.waitForSelector('#global-header');
		usrDF = await page.evaluate(() => userDateFormat)
		await expect(usrDF).toBe('dd-mm-yyyy')
		sdv1 = await page.evaluate(() => splitDateVal('01-02-2020'))
		await expect(sdv1).toEqual(new Array('01', '02', '2020'))
		//////////////
		await page.goto(url+'/index.php?module=Users&action=Logout')
		await page.waitForSelector('#username');
		await page.type('input#username', 'testmdy')
		await page.type('input#password', 'testmdy')
		await page.click('input#Login')
		await page.waitForSelector('#global-header');
		usrDF = await page.evaluate(() => userDateFormat)
		await expect(usrDF).toBe('mm-dd-yyyy')
		sdv1 = await page.evaluate(() => splitDateVal('02-01-2020'))
		await expect(sdv1).toEqual(new Array('01', '02', '2020'))
		//////////////
		await page.close();
		await browser.close()
	} else {
		throw new Error('URL could not be determined from config file');
	}
})