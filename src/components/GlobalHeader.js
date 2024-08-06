import logo from '@icons/logo.svg';
import Menus from './Menus';
import { __ } from '@wordpress/i18n';

export default function GlobalHeader({ }) {
  return (
    <>
      <div className="content-restriction__header">
        <div className="content-restriction__header__action content-restriction__header__action--left">
          <img src={logo} alt="{__( 'Content Restriction', 'content-restriction' )}" /><span>{__( 'Content Restriction', 'content-restriction' )}</span>
        </div>
       
        <div className="content-restriction__header__action content-restriction__header__action--right">
          <Menus />
        </div>
      </div>
    </>
  );
}