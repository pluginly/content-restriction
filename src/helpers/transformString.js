export default function transformString( str ) {
	if (typeof str !== 'string') {
		return ''; // Return an empty string if input is not a string
	}

	// Replace special characters with spaces, then split by spaces and underscores
	const words = str.replace(/[^a-zA-Z0-9]/g, ' ').split(/[\s_]+/);

	// Capitalize the first letter of each word and join them with spaces
	const capitalizedWords = words
		.map((word) => word.charAt(0).toUpperCase() + word.slice(1))
		.join(' ');

	return capitalizedWords;
}
