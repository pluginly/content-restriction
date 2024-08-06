import { __ } from '@wordpress/i18n';
import { Menu } from 'antd';
import { Link } from 'react-router-dom';

const items = [
  {
    key: 'rules',
    label: (
      <Link to="/" className="content-restriction__menu__single">{__( 'Rules', 'content-restriction' )}</Link>
    ),
  }
];

export default function Menus({ }) {
  return (
    <Menu 
    mode="horizontal" 
    items={items} 
    lineWidth="0"
    style={{
      width: "100%",
    }}
    />
  );
}