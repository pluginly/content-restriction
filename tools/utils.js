const path = require( 'path' );
const fs = require( 'fs' ).promises;
const normalizePath = require( 'normalize-path' );

const pluginRootFile = 'content-restriction';
const rootDir = path.dirname( __dirname );
const dist = normalizePath( path.join( rootDir, '__build' ) );

const getPluginInfo = async () => {
	try {
		const fileDir = path.join( rootDir, `${ pluginRootFile }.php` );
		const content = await fs.readFile( fileDir, 'utf8' );

		const versionRegex = /Version:\s+([\w.-]+)/;
		const textDomainRegex = /Text Domain:\s+\s*([\w-]+)/;

		const versionMatch = content.match( versionRegex );
		const textDomainMatch = content.match( textDomainRegex );

		const version = versionMatch ? versionMatch[ 1 ] : '';
		const textDomain = textDomainMatch ? textDomainMatch[ 1 ] : '';

		return { version, textDomain };
	} catch ( error ) {
		console.error( 'Error reading file:', error );
		return {};
	}
};

const transformBuildPaths = ( file_path ) => {
	if ( Array.isArray( file_path ) && file_path.length === 2 ) {
		return {
			source: file_path[ 0 ],
			destination: `${ dist }/zip/${ pluginRootFile }/${ file_path[ 1 ] }`,
		};
	}

	return {
		source: file_path,
		destination: `${ dist }/zip/${ pluginRootFile }/${ file_path }`,
	};
};

const buildFiles = [
	'app',
	'assets',
	'languages',
	'vendor',
	'composer.json',
	'config.php',
	'readme.txt',
	`${ pluginRootFile }.php`,
].map( transformBuildPaths );

const buildIgnoreFiles = [
	'**/Gruntfile.js',
	'**/.gitignore',
	'vendor/vendor-src/bin',
	'**/dev-*/**',
	'**/*-test/**',
	'**/*-beta/**',
	'**/scss/**',
	'**/sass/**',
	'**/.*',
	'**/build/*.txt',
	'**/*.map',
	'**/*.config',
	'**/*.config.js',
	'**/package.json',
	'**/package-lock.json',
	'**/tsconfig.json',
	'**/mix-manifest.json',
	'**/phpcs.xml',
	'**/composer.lock',
	'**/*.md',
	'**/*.mix.js',
	'**/none',
	'**/artisan',
	'**/phpcs-report.xml',
	'**/LICENSE',
	'**/Installable',
	'**/tests',
	'config.dev.php',
].map( ( file_path ) => `${ dist }/zip/${ pluginRootFile }/${ file_path }` );

module.exports = {
	pluginRootFile,
	getPluginInfo,
	buildFiles,
	buildIgnoreFiles,
};
