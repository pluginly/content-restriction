import { __ } from '@wordpress/i18n';

export default function getErrorMessage( code ) {
	let errorMessage = '';
	switch ( code ) {
		case 404:
			errorMessage = __( 'Resource not found', 'content-restriction' );
			break;
		case 400:
			errorMessage = __( 'Invalid Request', 'content-restriction' );
			break;
		case 422:
			errorMessage = __( 'Invalid data', 'content-restriction' );
			break;
		case 500:
			errorMessage = __( 'Internal server error', 'content-restriction' );
			break;
		default:
			errorMessage = __( 'Technical error', 'content-restriction' );
			break;
	}
	return errorMessage;
}