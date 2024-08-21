import GlobalHeader from "@components/GlobalHeader";
import { Button, Input, Space } from 'antd';
import { __ } from '@wordpress/i18n';
import "./license.scss";

export default function License() {
  return (
	<>
      	<GlobalHeader menuKey='license'/>

		<div className="content-restriction__license container">

			<div className="content-restriction__license__header">
				<h1 className="content-restriction__license__header__title">{__( 'Activate License', 'content-restriction' )}</h1>
				<p>{__( 'Thanks for buying, please activate your license below', 'content-restriction' )}</p>
			</div>
			<div className="content-restriction__license__form">
				<Space.Compact
					style={{
						width: '100%',
					}}
					>
					<Input defaultValue={__( 'Enter you license here', 'content-restriction' )} />
					<Button type="primary">{__( 'Activate', 'content-restriction' )}</Button>
				</Space.Compact>
				<p>{__( "If you don't have a valid license, please purchase one from the ", 'content-restriction' )}  <a target="__blank" href='https://contentrestriction.com/pricing/'>official website</a></p>
			</div>
		</div>
	</>
  );
}