
describe('general.js', function () {
	it('splitDateVal', function () {
		let sdv1 = splitDateVal();
		expect(sdv1).toEqual(new Array(undefined, undefined, undefined));
		//////////////
		userDateFormat = 'yyyy-mm-dd';
		sdv1 = splitDateVal('2020-02-01');
		expect(sdv1).toEqual(new Array('01', '02', '2020'));
		sdv1 = splitDateVal('2020.02.01');
		expect(sdv1).toEqual(new Array('01', '02', '2020'));
		sdv1 = splitDateVal('2020/02/01');
		expect(sdv1).toEqual(new Array('01', '02', '2020'));
		//////////////
		userDateFormat = 'dd-mm-yyyy';
		sdv1 = splitDateVal('01-02-2020');
		expect(sdv1).toEqual(new Array('01', '02', '2020'));
		//////////////
		userDateFormat = 'mm-dd-yyyy';
		sdv1 = splitDateVal('02-01-2020');
		expect(sdv1).toEqual(new Array('01', '02', '2020'));
		userDateFormat = 'yyyy-mm-dd';
	});
});
