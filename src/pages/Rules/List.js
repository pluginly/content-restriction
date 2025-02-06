import ModifiedTime from '@helpers/ModifiedTime';
import openNotificationWithIcon from '@helpers/openNotificationWithIcon';
import postData from '@helpers/postData';
import showDeleteConfirm from '@helpers/showDeleteConfirm';
import store from '@store/index';
import { dispatch } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { Switch, Tooltip } from "antd";
import { Link, useNavigate } from "react-router-dom";
import RulesSkeleton from './Skeletons/RulesSkeleton';

export default function List() {
  const history = useNavigate();
  const [rules, setRules] = useState( [] );
  const [publishedStatus, setPublishedStatus] = useState({});
  const [ rulesLoaded, setRulesLoadedLoaded ] = useState( false );

  // Initialize state with the published status for each rule
  useEffect(() => {
    const initialStatus = rules.reduce((acc, rule) => {
      acc[rule.id] = rule.status;
      return acc;
    }, {});
    setPublishedStatus(initialStatus);
  }, [rules]);

  const handleChange = (checked, id, title, rule) => {
    setPublishedStatus({
      ...publishedStatus,
      [id]: checked,
    });
    
    postData( 'content-restriction/rules/update', { id: id, data:{status: checked, title: title, rule: rule} }  )
      .then( ( res ) => {
        openNotificationWithIcon('success', __( 'Successfully updated!', 'content-restriction' ))
      } )
      .catch( ( error ) => {
        openNotificationWithIcon('error', __( 'Status update error', 'content-restriction' ))
      });
  }

  useEffect( () => {
    postData( 'content-restriction/rules/list' )
      .then( ( res ) => {
          setRules(res);
          setRulesLoadedLoaded(true);
      } )
      .catch( ( error ) => {
        openNotificationWithIcon('error', __( "Something wen't wrong!", 'content-restriction' ))
      });

      dispatch(store).setSidebarVisible(false);
  }, []);

  return (
    <div class="content-restriction__rules relative">
      <table class="content-restriction__rules__list">
        <thead class="content-restriction__rules__list__header">
          <tr>
            <th scope="col" width="5%">
              {__( 'Status', 'content-restriction' )}
            </th>
            <th scope="col">
              {__( 'Name', 'content-restriction' )}
            </th>
            <th scope="col">
              {__( 'Last edit', 'content-restriction' )}
            </th>
            <th scope="col" width="5%" className='text-center'>
              {__( 'Actions', 'content-restriction' )}
            </th>
          </tr>
        </thead>
        <tbody class="content-restriction__rules__body">
          {
            rules.length > 0 ? 
            rules.map((rule, index) => {
              return(
                <tr key={index}>
                  <td>
                    <Switch
                      checked={publishedStatus[rule.id]}
                      onChange={(checked) => handleChange(checked, rule.id, rule.title, rule.rule)}
                      checkedChildren=""
                      unCheckedChildren=""
                    />
                  </td>
                  <td>
                    <Link to={`/rule/${rule.id}`}>
                      {rule.title}
                    </Link>
                  </td>
                  <td>
                    <ModifiedTime timestamp={rule.modified} />
                  </td>
                  <td className="content-restriction__rules__action">
                    <Tooltip title={__( 'Delete', 'content-restriction' )}>
                      <a href='#' className="delete-btn">
                        <svg
                          onClick={() => showDeleteConfirm(rule.id, history)}
                          width="13"
                          height="18"
                          viewBox="0 0 304 384"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill="#CA0B00"
                            d="M21 341V85h256v256q0 18-12.5 30.5T235 384H64q-18 0-30.5-12.5T21 341M299 21v43H0V21h75L96 0h107l21 21z"
                          />
                        </svg>
                      </a>
                    </Tooltip>
                    <Tooltip title="Edit">
                      <Link to={`/rule/${rule.id}`}>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24" name="actionEdit"><path fill="#2D2E2E" d="m16.92 5 3.51 3.52 1.42-1.42-4.93-4.93L3 16.09V21h4.91L19.02 9.9 17.6 8.48 7.09 19H5v-2.09L16.92 5Z"></path></svg>
                      </Link>
                    </Tooltip>
                  </td>
                </tr>
              )
            }) :
            ! rulesLoaded ? 
              <>
                <RulesSkeleton/>
                <RulesSkeleton/>
                <RulesSkeleton/>
              </>
              :
              <tr>
                <td colSpan="4" className="text-center">{__( 'No rules was found! Create new rule', 'content-restriction' )}</td>
              </tr>        
          }
        </tbody>
      </table>
    </div>
  );
}