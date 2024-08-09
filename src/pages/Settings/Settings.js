import GlobalHeader from "@components/GlobalHeader";
import { __ } from '@wordpress/i18n';

export default function Settings() {
  return (
	<>
      	<GlobalHeader menuKey='settings'/>

		<div className="content-restriction__settings container">

			<div className="content-restriction__settings__header">
				<h1 className="content-restriction__settings__header__title">{__( 'Settings', 'content-restriction' )}</h1>
				<p>{__( 'Boost your web-creation process with settings, plugins, and more tools specially selected to unleash your creativity, increase productivity, and enhance your WordPress-powered website.*', 'content-restriction' )}</p>
			</div>

		</div>
	</>
  );
}