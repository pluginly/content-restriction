import { __ } from '@wordpress/i18n';
import { Menu } from 'antd';
import { Link } from 'react-router-dom';

const items = [
  {
    key: 'rules',
    label: (
      <Link to="/rules" className="content-restriction__menu__single">{__( 'Rules', 'content-restriction' )}</Link>
    ),
  },
  {
    key: 'integrations',
    label: (
      <Link to="/integrations" className="content-restriction__menu__single">{__( 'Integrations', 'content-restriction' )}</Link>
    ),
  },
];

export default function Menus({menuKey}) {
  return (
    <Menu 
    selectedKeys={[menuKey]}
    mode="horizontal" 
    items={items} 
    lineWidth="0"
    style={{
      width: "100%",
      lineHeight: "70px"
    }}
    />
  );
}