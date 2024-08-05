import logo from '@icons/logo.svg';
import { Menu } from 'antd';
import { Link } from 'react-router-dom';

const items = [
  {
    key: 'rules',
    label: (
      <Link to="/" className="content-restriction__menu__single">Rules</Link>
    ),
  },
  {
    key: 'integrations',
    label: (
      <Link to="/integrations" className="content-restriction__menu__single">Integrations</Link>
    ),
  },
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