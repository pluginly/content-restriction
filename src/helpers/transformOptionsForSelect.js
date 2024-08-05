export default function transformOptionsForSelect( opts ) {
	return Object.entries(opts || {}).map(([key, value]) => ({
		value: key,
		label: typeof value === 'string' ? value : value.title,
	}));
};