const { test, expect } = require('@playwright/test');
const getUrlFromConfigFile = require('../../utils.js').getUrlFromConfigFile;
const coreBOSurl = getUrlFromConfigFile();

test('test', async ({ page }) => {
	await page.goto(coreBOSurl);
	await page.fill('input[name="user_name"]', 'admin');
	await page.fill('input[name="user_password"]', 'admin');
	// Press Enter
	await page.press('input[name="user_password"]', 'Enter');
	expect(page.url()).toBe(coreBOSurl+'/index.php?action=index&module=Home');
	await page.goto(coreBOSurl+'/index.php?action=index&module=Invoice&action=DetailView&record=2816');

	const grandtotal = await page.getAttribute('[data-qagrandtotal]', 'data-qagrandtotal');
	expect(grandtotal).toBe('1890.930000');

	// Click button:has-text("Edit")
	await page.click('button:has-text("Edit")');
	expect(page.url()).toBe(coreBOSurl+'/index.php');

	// Click text=Save
	await Promise.all([
		page.waitForNavigation(/*{ url: 'http://localhost/coreBOSTest/index.php?module=Invoice&action=DetailView&viewname=0&start=&record=2816&' }*/),
		page.click('text=Save')
	]);

	const grandtotalafter = await page.getAttribute('[data-qagrandtotal]', 'data-qagrandtotal');
	expect(grandtotalafter).toBe('1890.930000');
});