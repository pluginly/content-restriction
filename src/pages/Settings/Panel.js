import React, { useState } from 'react';
import { Layout, Menu, Form, Input, Button, Select, Space, } from 'antd';
import { SettingOutlined, AppstoreOutlined, UserOutlined, SecurityScanOutlined, KeyOutlined } from '@ant-design/icons';
import { __ } from '@wordpress/i18n';
import renderFormContent from './renderFormContent';
import handleSettingsUpdate from './handleSettingsUpdate';

const { Sider, Content } = Layout;
const { TextArea } = Input;


export default function Panel() {
  const [selectedMenuKey, setSelectedMenuKey] = useState('general');
  const [form] = Form.useForm();

  const menuItems = [
    { key: 'general', icon: <SettingOutlined />, label: __('General', 'content-restriction') },
    { key: 'appearance', icon: <AppstoreOutlined />, label: __('Appearance', 'content-restriction') },
    { key: 'security', icon: <SecurityScanOutlined />, label: __('Security', 'content-restriction') },
    { key: 'license', icon: <KeyOutlined />, label: __('License', 'content-restriction') },
    { key: 'profile', icon: <UserOutlined />, label: __('Profile', 'content-restriction') },
  ];

  return (
    <>
      <Layout className="content-restriction__settings">
        
        <Sider width={300} className="site-layout-background">
          <Menu
            mode="inline"
            selectedKeys={[selectedMenuKey]}
            onClick={(e) => setSelectedMenuKey(e.key)}
            style={{ height: '100%', borderRight: 0, paddingLeft: 35 }}
            items={menuItems}
          />
        </Sider>

        <Layout style={{ padding: '0 24px 24px' }}>
          <Content
            style={{
              padding: 24,
              margin: 0,
              minHeight: 300,
            }}
          >
            <Form
              form={form}
              layout="vertical"
              onFinish={handleSettingsUpdate}
            >
              {renderFormContent(selectedMenuKey)}

              <Form.Item  className='settings-save-button'>
                <Space>
                  <Button type="primary" htmlType="submit">
                    {__('Save Settings', 'content-restriction')}
                  </Button>
                </Space>
              </Form.Item>

            </Form>
          </Content>
        </Layout>
      </Layout>
    </>
  );
}