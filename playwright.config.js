module.exports = {
	testDir: "e2e",
	use: {
		// Browser options
		// headless: false,
		// slowMo: 80,

		// Context options
		viewport: { width: 1280, height: 720 },
		ignoreHTTPSErrors: true,

		// Artifacts
		// screenshot: 'only-on-failure',
		// video: 'retry-with-video',
	},
};