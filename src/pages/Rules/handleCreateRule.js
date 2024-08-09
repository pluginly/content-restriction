import postData from '@helpers/postData';
import openNotificationWithIcon from '@helpers/openNotificationWithIcon';
import { __ } from '@wordpress/i18n';

export default function handleCreateRule( contentRule, ruleTitle, isPublished, history ) {
	const contentRuleCompleted = contentRule 
      && contentRule.hasOwnProperty('who-can-see') 
      && contentRule.hasOwnProperty('what-content') 
      && contentRule.hasOwnProperty('restrict-view');

    if(contentRuleCompleted) {
      postData( 
        'content-restriction/rules/create', { data:{isPublished, title: ruleTitle, rule: contentRule} } )
        .then( ( res ) => {
          openNotificationWithIcon('success', __( 'Successfully Created!', 'content-restriction' ))
        //   setRuleID(res);
		console.log('res : ', res );
          history(`/rule/${res}`);
        } )
        .catch( ( error ) => {
			console.log('error : ', error );
          openNotificationWithIcon('error', __( 'Rules create error', 'content-restriction' ))
        });
    } else {
      openNotificationWithIcon('warning', __( 'Please complete the setup', 'content-restriction' ));
    }
};