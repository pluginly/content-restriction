import apiFetch from '@wordpress/api-fetch';

export default async function postData( path, data, config ) {
	config = config ? config : {};
	data = data ? data : {};

	const headers = [
		['X-WP-Nonce', content_restriction_admin.rest_args.nonce]
	];

	return await apiFetch( { 
		path: path, 
		method: 'POST', 
		data,
		headers,
		...config 
	} )
	.then( ( res ) => res )
	.catch( ( error ) => {
		throw error;
	} );
}
