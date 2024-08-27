import { __ } from '@wordpress/i18n';
import { Form, Input, Select, InputNumber, Checkbox, Switch, Card } from 'antd';

const { TextArea } = Input;
const { Option } = Select;

export default function renderFormContent( selectedMenuKey ) {
	switch (selectedMenuKey) {
		case 'general':
		  return (
			<Card title={__('General Settings', 'content-restriction')} bordered={false}>
			  
			  <Form.Item
				label={__('Site Name', 'content-restriction')}
				name="site_name"
				rules={[{ message: __('Please input Site Name!', 'content-restriction') }]}
			  >
				<Input placeholder={__('Enter your site name', 'content-restriction')} />
			  </Form.Item>
  
			  <Form.Item
				label={__('Site Description', 'content-restriction')}
				name="site_description"
			  >
				<TextArea placeholder={__('Enter your site description', 'content-restriction')} />
			  </Form.Item>
  
			  <Form.Item
				label={__('Default Language', 'content-restriction')}
				name="default_language"
			  >
				<Select placeholder={__('Select language', 'content-restriction')}>
				  <Option value="en">English</Option>
				  <Option value="fr">French</Option>
				  <Option value="es">Spanish</Option>
				  <Option value="de">German</Option>
				</Select>
			  </Form.Item>
  
			</Card>
		  );
  
		case 'appearance':
		  return (
			<Card title={__('Appearance Settings', 'content-restriction')} bordered={false}>
			  <Form.Item
				label={__('Theme Color', 'content-restriction')}
				name="theme_color"
			  >
				<Input type="color" />
			  </Form.Item>
  
			  <Form.Item
				label={__('Custom CSS', 'content-restriction')}
				name="custom_css"
			  >
				<TextArea placeholder={__('Enter custom CSS', 'content-restriction')} rows={4} />
			  </Form.Item>
  
			  <Form.Item
				label={__('Font Size', 'content-restriction')}
				name="font_size"
			  >
				<InputNumber min={10} max={36} />
			  </Form.Item>
			</Card>
		  );
  
		case 'security':
		  return (
			<Card title={__('Security Settings', 'content-restriction')} bordered={false}>
			  <Form.Item
				label={__('Enable 2FA', 'content-restriction')}
				name="enable_2fa"
				valuePropName="checked"
			  >
				<Switch />
			  </Form.Item>
  
			  <Form.Item
				label={__('Password Complexity', 'content-restriction')}
				name="password_complexity"
			  >
				<Checkbox.Group>
				  <Checkbox value="uppercase">{__('Uppercase Letters', 'content-restriction')}</Checkbox>
				  <Checkbox value="numbers">{__('Numbers', 'content-restriction')}</Checkbox>
				  <Checkbox value="symbols">{__('Symbols', 'content-restriction')}</Checkbox>
				</Checkbox.Group>
			  </Form.Item>
			</Card>
		  );
  
		case 'profile':
		  return (
			<Card title={__('Profile Settings', 'content-restriction')} bordered={false}>
			  <Form.Item
				label={__('Username', 'content-restriction')}
				name="username"
			  >
				<Input placeholder={__('Enter your username', 'content-restriction')} />
			  </Form.Item>
  
			  <Form.Item
				label={__('Bio', 'content-restriction')}
				name="bio"
			  >
				<TextArea placeholder={__('Tell us about yourself', 'content-restriction')} rows={4} />
			  </Form.Item>
  
			  <Form.Item
				label={__('Preferred Language', 'content-restriction')}
				name="preferred_language"
			  >
				<Select mode="multiple" placeholder={__('Select your preferred languages', 'content-restriction')}>
				  <Option value="en">English</Option>
				  <Option value="fr">French</Option>
				  <Option value="es">Spanish</Option>
				  <Option value="de">German</Option>
				</Select>
			  </Form.Item>
			</Card>
		  );
  
		case 'license':
		  return (
			<Card title={__('License Settings', 'content-restriction')} bordered={false}>
				<Form.Item
					label={__('License Key', 'content-restriction')}
					name="license_key"
				>
					<Input placeholder={__('Please enter you license key here', 'content-restriction')} />
				</Form.Item>
					<p>{__( "If you don't have a valid license, please purchase one from the ", 'content-restriction' )}  <a target="__blank" href='https://contentrestriction.com/pricing/'>official website</a></p>
			</Card>
		);
		case 'tools':
		  return (
			<Card title={__('Tools Settings', 'content-restriction')} bordered={false}>
				<Form.Item
					label={__('License Key', 'content-restriction')}
					name="license_key"
				>
					<Input placeholder={__('Please enter you license key here', 'content-restriction')} />
				</Form.Item>
					<p>{__( "If you don't have a valid license, please purchase one from the ", 'content-restriction' )}  <a target="__blank" href='https://contentrestriction.com/pricing/'>official website</a></p>
			</Card>
		);

		default:
		  return null;
	  }
}
