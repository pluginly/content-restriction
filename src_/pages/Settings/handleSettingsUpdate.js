import postData from '@helpers/postData';
import openNotificationWithIcon from '@helpers/openNotificationWithIcon';
import { __ } from '@wordpress/i18n';


export default function handleSettingsUpdate( values ) {
  console.log(' values : ',  values );


  postData( 
    'content-restriction/settings/update', values )
    .then( ( res ) => {
      openNotificationWithIcon('success', __( 'Successfully Updated!', 'content-restriction' ))
    } )
    .catch( ( error ) => {
      openNotificationWithIcon('error', __( 'Settings update error', 'content-restriction' ))
    });
};