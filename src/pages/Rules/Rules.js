import { Link } from "react-router-dom";
import GlobalHeader from '@components/GlobalHeader';
import List from "./List";
import { __ } from '@wordpress/i18n';

export default function Rules() {
  return (
    <div className="content-restriction__rules container">

      <GlobalHeader/>

      <div className="content-restriction__rules__header">

        <h1 className="content-restriction__rules__header__title">Rules</h1>

        <Link to="/rule" className="content-restriction__btn content-restriction__btn--create">
            <svg width="15" height="15" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.2031 0.4375C15.5761 0.4375 15.9338 0.585658 16.1975 0.849381C16.4612 1.1131 16.6094 1.47079 16.6094 1.84375V12.3906H27.1562C27.5292 12.3906 27.8869 12.5388 28.1506 12.8025C28.4143 13.0662 28.5625 13.4239 28.5625 13.7969V15.2031C28.5625 15.5761 28.4143 15.9338 28.1506 16.1975C27.8869 16.4612 27.5292 16.6094 27.1562 16.6094H16.6094V27.1562C16.6094 27.5292 16.4612 27.8869 16.1975 28.1506C15.9338 28.4143 15.5761 28.5625 15.2031 28.5625H13.7969C13.4239 28.5625 13.0662 28.4143 12.8025 28.1506C12.5388 27.8869 12.3906 27.5292 12.3906 27.1562V16.6094H1.84375C1.47079 16.6094 1.1131 16.4612 0.849381 16.1975C0.585658 15.9338 0.4375 15.5761 0.4375 15.2031V13.7969C0.4375 13.4239 0.585658 13.0662 0.849381 12.8025C1.1131 12.5388 1.47079 12.3906 1.84375 12.3906H12.3906V1.84375C12.3906 1.47079 12.5388 1.1131 12.8025 0.849381C13.0662 0.585658 13.4239 0.4375 13.7969 0.4375H15.2031Z" fill="white"/>
            </svg>
            <span>{__( 'Create Rule', 'content-restriction' )}</span>
        </Link>

      </div>

      <List/>

    </div>
  );
}