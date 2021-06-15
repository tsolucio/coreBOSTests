exports.getUrlFromConfigFile = () => {
	const fs = require('fs')
	const configLines = fs.readFileSync('../../config.inc.php').toString().split("\n");
	var url = false;
	configLines.forEach(line => {
		let r = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[\-;:&=\+\$,\w]+@)?[A-Za-z0-9\.\-]+|(?:www\.|[\-;:&=\+\$,\w]+@)[A-Za-z0-9\.\-]+)((?:\/[\+~%\/\.\w\-_]*)?\??(?:[\-\+=&;%@\.\w_]*)#?(?:[\.\!\/\\\w]*))?)/;
		if (line.match(r) !== null) {
			url = line.match(r)[0];
		}
	});
	if (!url) {
		throw new Error('URL could not be determined from config file');
	}
	return url;
}