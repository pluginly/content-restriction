import apiFetch from '@wordpress/api-fetch';

export default async function updateData( path, data ) {
	return await apiFetch( { path: path, method: 'PATCH', data } ).then(
		( res ) => res
	);
}
