import { useEffect, useState } from '@wordpress/element';
import postData from '@helpers/postData';
import openNotificationWithIcon from '@helpers/openNotificationWithIcon';
import transformString from '@helpers/transformString';
import { __ } from '@wordpress/i18n';
import upgradeToPro from '@helpers/upgradeToPro';
import SingleSkeleton from './Skeletons/SingleSkeleton';

export default function List() {
  const [integrations, setIntegrations] = useState( [] );
  const [ integrationItemsLoaded, setIntegrationItemsLoaded ] = useState( false );

  useEffect( () => {
    postData( 'content-restriction/settings/integrations' )
      .then( ( res ) => {
          setIntegrations(res);
          setIntegrationItemsLoaded(true);
      } )
      .catch( ( error ) => {
        openNotificationWithIcon('error', __( "Something wen't wrong!", 'content-restriction' ))
      });
  }, []);

  return (
    <div class="content-restriction__integrations__list">
      { ! integrationItemsLoaded ? 
        <>
          <SingleSkeleton/>
          <SingleSkeleton/>
          <SingleSkeleton/>
          <SingleSkeleton/>
          <SingleSkeleton/>
          <SingleSkeleton/>
          <SingleSkeleton/>
          <SingleSkeleton/>
        </>
      :
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
                {
                  integration.link
                    ? <a href={integration.link} class="learn-more">{__( 'Learn more', 'content-restriction' )}</a>
                    : <span></span>
                }
                {
                  integration.action &&
                  integration.action === 'upgrade' 
                    ? <a href={upgradeToPro()} class="action upgrade-to-pro" target='__blank'>{__( "Let's go", 'content-restriction' )}</a>
                    : ''
                }
              </p>
            </div>
          )
        })
      }
    </div>
  );
}