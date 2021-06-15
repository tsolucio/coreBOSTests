const { test, expect } = require('@playwright/test');
const getUrlFromConfigFile = require('../../utils.js').getUrlFromConfigFile;
const coreBOSurl = getUrlFromConfigFile();

test('Adding inventorylines should not set deleted lines to deleted = 0', async ({ page }) => {
	await page.goto(coreBOSurl);
	await page.fill('input#username', 'admin');
	await page.fill('input#password', 'admin');
	await page.click('input#Login');
	await page.goto(coreBOSurl + '/index.php?module=SalesOrder&action=DetailView&record=10616');
	await page.click('button[name=Edit]');
	await page.waitForSelector('#row10');
	await page.click('tr#row10 > td > img');
	await page.click('tr#row9 > td > img');
	await page.click('.create:first-child');
	const lastRowDeleteStatus = await page.$eval('#deleted10', el => el.value);
	expect(lastRowDeleteStatus).toBe('1');
});