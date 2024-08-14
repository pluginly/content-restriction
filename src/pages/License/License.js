import GlobalHeader from "@components/GlobalHeader";
import { __ } from '@wordpress/i18n';

export default function License() {
  return (
	<>
      	<GlobalHeader menuKey='license'/>

		<div className="content-restriction__license container">

			<div className="content-restriction__license__header">
				<h1 className="content-restriction__license__header__title">{__( 'Activate License', 'content-restriction' )}</h1>
				<p>{__( 'Thanks for buying, please activate your license below', 'content-restriction' )}</p>
			</div>

		</div>
	</>
  );
}