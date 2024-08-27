import GlobalHeader from "@components/GlobalHeader";
import { __ } from '@wordpress/i18n';
import "./Settings.scss";
import Panel from "./Panel";

export default function Settings() {
  return (
	<>
      	<GlobalHeader menuKey='settings'/>

		<div className="content-restriction__settings container">
			
			<Panel />

		</div>
	</>
  );
}