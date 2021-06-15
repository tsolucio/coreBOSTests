

describe('vtlib.js', function () {
	it('vtlib_vtiger_imageurl', function () {
		expect(vtlib_vtiger_imageurl(1)).toBe('themes/1/images');
		expect(vtlib_vtiger_imageurl('ddd')).toBe('themes/ddd/images');
		expect(vtlib_vtiger_imageurl('softed')).toBe('themes/softed/images');
		expect(vtlib_vtiger_imageurl()).toBe('themes/undefined/images');
	});
});
