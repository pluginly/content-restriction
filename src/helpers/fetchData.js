import apiFetch from '@wordpress/api-fetch';

export default async function fetchData( path, config ) {
	return await apiFetch( { path: path, ...config } )
		.then( ( res ) => {
			return res;
		} )
		.catch( ( error ) => {
			throw error;
		} );
}
