const { test, expect } = require('@playwright/test');
const getUrlFromConfigFile = require('../../utils.js').getUrlFromConfigFile;
const coreBOSurl = getUrlFromConfigFile();

test('Admin login', async ({ page }) => {
	await page.goto(coreBOSurl);
	await page.fill('input#username', 'admin');
	await page.fill('input#password', 'admin');
	await page.click('input#Login');
	await page.waitForSelector('#global-header');
	const ptitle = await page.title();
	expect(ptitle).toBe('Administrator - Home - coreBOS');
	const windowHandle = await page.evaluateHandle(() => window);
	const prop = await windowHandle.getProperty('gVTUserID');
	expect(await prop.jsonValue()).toBe('1');
	//const btn = await page.$$('button[title="CRM Settings"]');
	const visible = await page.isVisible('button[title="CRM Settings"]');
	expect(visible).toBeTruthy();
});

test('Non Admin login', async ({ page }) => {
	await page.goto(coreBOSurl);
	await page.fill('input#username', 'testdmy');
	await page.fill('input#password', 'testdmy');
	await page.click('input#Login');
	await page.waitForSelector('#global-header');
	const ptitle = await page.title()
	expect(ptitle).toBe('cbTest testdmy - Users - coreBOS');
	const windowHandle = await page.evaluateHandle(() => window);
	const prop = await windowHandle.getProperty('gVTUserID');
	expect(await prop.jsonValue()).toBe('5');
	const visible = await page.isVisible('button[title="CRM Settings"]');
	expect(visible).toBeFalsy();
});

test('Inactive user login', async ({ page }) => {
	await page.goto(coreBOSurl);
	await page.fill('input#username', 'testinactive');
	await page.fill('input#password', 'testinactive');
	await page.click('input#Login');
	await page.waitForSelector('div.errorMessage');
	const divcnt = await page.$eval('div.errorMessage', el => el.innerHTML)
	expect(divcnt).toBe('You must specify a valid username and password.')
});
