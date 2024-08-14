import postData from '@helpers/postData';
import openNotificationWithIcon from '@helpers/openNotificationWithIcon';
import { __ } from '@wordpress/i18n';

export default function handleCreateRule( id, contentRule, ruleTitle, status ) {
	const contentRuleCompleted = contentRule 
      && contentRule.hasOwnProperty('who-can-see') 
      && contentRule.hasOwnProperty('what-content') 
      && contentRule.hasOwnProperty('restrict-view') 

    if(contentRuleCompleted) {
      postData( 'content-restriction/rules/update', { id: id, data:{status, title: ruleTitle, rule: contentRule} } )
        .then( ( res ) => {
          openNotificationWithIcon('success', __( 'Successfully Updated!', 'content-restriction' ));
        } )
        .catch( ( error ) => {
          openNotificationWithIcon('error', __( 'Rules update error', 'content-restriction' ))
        });
    } else {
      openNotificationWithIcon('warning', __( 'Please complete the setup', 'content-restriction' ))
    }
};