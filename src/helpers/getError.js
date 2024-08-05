export default function getErrorMessage( code ) {
	let errorMessage = '';
	switch ( code ) {
		case 404:
			errorMessage = 'Resource not found';
			break;
		case 400:
			errorMessage = 'Invalid Request';
			break;
		case 422:
			errorMessage = 'Invalid data';
			break;
		case 500:
			errorMessage = 'Internal server error';
			break;
		default:
			errorMessage = 'Technical error';
			break;
	}
	return errorMessage;
}
