import IntegrationsList from "./List";
import GlobalHeader from "@components/GlobalHeader";
import { __ } from '@wordpress/i18n';
import "./integrations.scss";

export default function Integrations() {
  return (
	<>
      	<GlobalHeader menuKey='integrations'/>

		<div className="content-restriction__integrations container">

			<div className="content-restriction__integrations__header">
				<h1 className="content-restriction__integrations__header__title">{__( 'Numerous Integrations, New Possibilities.', 'content-restriction' )}</h1>
				<p>{__( 'Boost your web-creation process with Integrations, plugins, and more tools specially selected to unleash your creativity, increase productivity, and enhance your WordPress-powered website.*', 'content-restriction' )}</p>
			</div>

			<IntegrationsList/>

		</div>
	</>
  );
}