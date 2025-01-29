import dashboardList from "./List";
import GlobalHeader from "@components/GlobalHeader";
import { __ } from '@wordpress/i18n';
import "./Style.scss";

export default function dashboard() {
  return (
	<>
      	<GlobalHeader menuKey='dashboard'/>

		<div className="content-restriction__dashboard container">

			<div className="content-restriction__dashboard__header">
				<h1 className="content-restriction__dashboard__header__title">{__( 'Numerous dashboard, New Possibilities.', 'content-restriction' )}</h1>
				<p>{__( 'Boost your web-creation process with dashboard, plugins, and more tools specially selected to unleash your creativity, increase productivity, and enhance your WordPress-powered website.*', 'content-restriction' )}</p>
			</div>

		

		</div>
	</>
  );
}