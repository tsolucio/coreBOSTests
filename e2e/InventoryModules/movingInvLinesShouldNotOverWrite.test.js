const { test, expect } = require('@playwright/test');
const getUrlFromConfigFile = require('../../utils.js').getUrlFromConfigFile;
const coreBOSurl = getUrlFromConfigFile();

test('Moving inventorylines should not overwrite each other', async ({ page }) => {
	await page.goto(coreBOSurl);
	await page.fill('input#username', 'admin');
	await page.fill('input#password', 'admin');
	await page.click('input#Login');
	await page.goto(coreBOSurl + '/index.php?module=SalesOrder&action=DetailView&record=10720');
	await page.click('input[name=Edit]');
	await page.waitForSelector('#row4');
	await page.click('tr#row2 > td > img');
	await page.click('tr#row3 > td > img');
	await page.click('tr#row1 > td > a');
	const firstRowServiceName = await page.$eval('#productName1', el => el.value);
	await expect(firstRowServiceName).toBe('Manufacturing Japan Movt Stainless Steel Back For Men Bracelet Brand Watch Wrist Wtach Quartz');
});