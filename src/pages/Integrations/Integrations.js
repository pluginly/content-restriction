import IntegrationsList from "./List";
import GlobalHeader from "@components/GlobalHeader";
import { __ } from '@wordpress/i18n';

export default function Integrations() {
  return (
	<>
      	<GlobalHeader/>

		<div className="content-restriction__integrations container">

			<div className="content-restriction__integrations__header">
				<h1 className="content-restriction__integrations__header__title">{__( 'Popular Add-ons, New Possibilities.', 'content-restriction' )}</h1>
				<p>{__( 'Boost your web-creation process with add-ons, plugins, and more tools specially selected to unleash your creativity, increase productivity, and enhance your WordPress-powered website.*', 'content-restriction' )}</p>
			</div>

			<IntegrationsList/>

		</div>
	</>
  );
}