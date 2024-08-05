import logo from '@icons/logo.svg';
import Menus from './Menus';
export default function GlobalHeader({ }) {
  return (
    <>
      <div className="content-restriction__header">
        <div className="content-restriction__header__action content-restriction__header__action--left">
          <img src={logo} alt="CR" /><span>Content Restriction</span>
        </div>
       
        <div className="content-restriction__header__action content-restriction__header__action--right">
          <Menus />
        </div>
      </div>
    </>
  );
}