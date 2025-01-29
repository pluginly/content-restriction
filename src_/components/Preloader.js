import { __ } from '@wordpress/i18n';

const Preloader = () => {
	return (
		<div className="content-restriction__preloader">
			{__( 'Content Restriction Dashboard Loading...', 'content-restriction' )}
		</div>
	);
};

export default Preloader;