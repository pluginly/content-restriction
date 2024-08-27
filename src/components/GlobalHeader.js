import logo from '@icons/logo.svg';
import Menus from './Menus';
import { __ } from '@wordpress/i18n';
import { Link } from 'react-router-dom';

export default function GlobalHeader({menuKey}) {
  return (
    <>
      <div className="content-restriction__header">
        <div className="content-restriction__header__action content-restriction__header__action--left">
          <Link to="/" className="content-restriction__menu__single">
            <img src={logo} alt="{__( 'Content Restriction', 'content-restriction' )}" />
            </Link> 
            <span>{__( 'Content Restriction', 'content-restriction' )}</span>
        </div>
       
        <div className="content-restriction__header__action content-restriction__header__action--right">
          <Menus menuKey={menuKey}/>
        </div>
      </div>
    </>
  );
}