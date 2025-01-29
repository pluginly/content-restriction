import IntegrationsList from "./List";
import GlobalHeader from "@components/GlobalHeader";
import { __ } from '@wordpress/i18n';
import "./Style.scss";

export default function Integrations() {
  return (
	<>
      	<GlobalHeader menuKey='integrations'/>

		<div className="content-restriction__integrations container">

			<div className="content-restriction__integrations__header">
				<h1 className="content-restriction__integrations__header__title">{__( 'Integrations', 'content-restriction' )}</h1>
				<p>{__( 'Seamlessly integrate with other plugins to enhance your website’s content visibility and control functionality. Use advanced conditional rules to create a more personalized user experience.', 'content-restriction' )}</p>
			</div>

			<IntegrationsList/>

		</div>
	</>
  );
}