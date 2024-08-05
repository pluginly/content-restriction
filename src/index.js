import { createRoot, lazy, Suspense } from '@wordpress/element';
import Preloader from './components/Preloader';
const App = lazy( () => import( './boot/App' ) );

import "./scss/global.scss";
import "./scss/components.scss";
import "./scss/rules.scss";
import "./scss/integrations.scss";

function initializeApp( container ) {
	if ( createRoot ) {
		const root = createRoot( container );

		root.render(
			<div class="content-restriction">
				<Suspense fallback={ <Preloader /> }>
					<App />
				</Suspense>
			</div>
		);
	} else {
		render(
			<div class="content-restriction">
				<Suspense fallback={ <Preloader /> }>
					<App />
				</Suspense>
			</div>,
			container
		);
	}
}

document.addEventListener( 'DOMContentLoaded', function () {
	const container = document.getElementById("content-restriction-admin-dashboard-app");

	if ( ! container ) {
		return;
	}

	initializeApp( container );
} );