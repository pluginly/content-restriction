import { useEffect, useState } from '@wordpress/element';
import postData from '@helpers/postData';
import openNotificationWithIcon from '@helpers/openNotificationWithIcon';
import transformString from '@helpers/transformString';
import { __ } from '@wordpress/i18n';

export default function List() {
  const [integrations, setIntegrations] = useState( [] );
  useEffect( () => {
    postData( 'content-restriction/settings/integrations' )
      .then( ( res ) => {
          setIntegrations(res);
      } )
      .catch( ( error ) => {
        openNotificationWithIcon('error', __( "Something wen't wrong!", 'content-restriction' ))
      });
  }, []);


  return (
    <div class="content-restriction__integrations__list">
      {
        integrations.map((integration, index) => {
          return(
            <div class="content-restriction__integrations__list__item">
              <div class="content-restriction__integrations__list__item__header">
                <img src={integration.icon} alt={integration.title} />
                <div class="badges">
                  {integration.badges.map((badge, index) => {
                    return (
                      <span class="badge">
                        {transformString(badge)}
                      </span>
                    );
                  })}
                </div>
              </div>
              <h3 class="content-restriction__integrations__list__item__title">{integration.title}</h3>
              <div class="content-restriction__integrations__list__item__desc">
                <p>{integration.details}</p>
              </div>
              <p class="content-restriction__integrations__list__item__actions">
                <a href="#" class="learn-more">{__( 'Learn more', 'content-restriction' )}</a>
                <a href="#" class="action">{__( 'Settings', 'content-restriction' )}</a>
              </p>
            </div>
          )
        })
      }
    </div>
  );
}