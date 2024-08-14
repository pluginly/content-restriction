import { ArrowLeftOutlined, EditOutlined } from "@ant-design/icons";
import { dispatch, select, subscribe } from '@wordpress/data';
import { useEffect, useRef, useState } from '@wordpress/element';
import { Switch } from "antd";
import { useNavigate } from 'react-router-dom';
import store from '@store/index';
import postData from '@helpers/postData';
import logo from '@icons/logo.svg';
import openNotificationWithIcon from '@helpers/openNotificationWithIcon';
import showDeleteConfirm from "@helpers/showDeleteConfirm";
import { __ } from '@wordpress/i18n';

export default function Header({ }) {
	const [ contentRule, setContentRule ] = useState( {} );
	const [ ruleID, setRuleID ] = useState( '' );
	const [ ruleTitle, setRuleTitle ] = useState( 'Untitled Rule' );
	const [ editableTitle, setEditableTitle ] = useState( false );
  const [ status, setStatus ] = useState(false);
  const [ openDropDown, setOpenDropDown ] = useState(false);
  
  const history = useNavigate();
  const state = select('content-restriction-stores');
  
  const handleCreateRule = () => {
    const contentRuleCompleted = contentRule && contentRule.hasOwnProperty('who-can-see') && contentRule.hasOwnProperty('what-content') && contentRule.hasOwnProperty('restrict-view');

    if(contentRuleCompleted) {
      postData( 
        'content-restriction/rules/create', { data:{status, title: ruleTitle, rule: contentRule} } )
        .then( ( res ) => {
          openNotificationWithIcon('success', __( 'Successfully Created!', 'content-restriction' ))
          setRuleID(res);
          history(`/rule/${res}`);
          window.location.reload();
        } )
        .catch( ( error ) => {
          openNotificationWithIcon('error', __( 'Rules create error', 'content-restriction' ))
        });
    } else {
      openNotificationWithIcon('warning', __( 'Please complete the setup', 'content-restriction' ));
    }
  }

  const handleUpdateRule = (uid) => { 
    const contentRuleCompleted = contentRule &&
      contentRule.hasOwnProperty('who-can-see') &&
      contentRule.hasOwnProperty('what-content') &&
      contentRule.hasOwnProperty('restrict-view') 

    if(contentRuleCompleted) {
      postData( 'content-restriction/rules/update', { rule_id: uid, data:{status, title: ruleTitle, rule: contentRule} } )
        .then( ( res ) => {
          openNotificationWithIcon('success', __( 'Successfully Updated!', 'content-restriction' ));
        } )
        .catch( ( error ) => {
          openNotificationWithIcon('error', __( 'Rules update error', 'content-restriction' ))
        });
    } else {
      openNotificationWithIcon('warning', __( 'Please complete the setup', 'content-restriction' ))
    }
  }

  // Handler function to be called when the switch is toggled
  const handleChange = (checked) => {
    setStatus(checked);
    dispatch(store).setRulePublished(checked);
  };

  const dropdownRef = useRef(null);

  const handleDropdown = () => {
    setOpenDropDown(!openDropDown);
  }

  const handleClickOutside = (event) => {
    if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
      setOpenDropDown(false);
    }
  }

  useEffect(() => {
    document.addEventListener('mousedown', handleClickOutside);
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, []);


  useEffect( () => {
    // Subscribe to changes in the store's data
    const storeUpdate = subscribe( () => {
        const rule = state.getRuleData();
        const uid = state.getRuleID();
        const title = state.getRuleTitle();
        const publishedStatus = state.getRulePublished();

        setRuleID(uid);
        setRuleTitle(title || ruleTitle);
        setContentRule(rule);
        setStatus(publishedStatus);
    } );

    // storeUpdate when the component is unmounted
    return () => storeUpdate();
  });

  const inputRef = useRef(null);

  // Add click listener to document when editable mode is enabled
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (editableTitle) {
        const isClickInside = inputRef.current?.contains(event.target);
        const isEditIcon = event.target.classList.contains("anticon-edit");

        // If click is outside of the input or not on the edit icon, disable editable mode
        if (!isClickInside && !isEditIcon) {
          setEditableTitle(false);
        }
      }
    };

    document.addEventListener("click", handleClickOutside);

    // Cleanup on component unmount or when editableTitle changes
    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
  }, [editableTitle]);

  const publishButtonClickHandler = ruleID ? () => handleUpdateRule(ruleID) : handleCreateRule;
  
  return (
    <>
      <div className="content-restriction__header">
        <div className="content-restriction__header__action content-restriction__header__action--left">
          <a href={content_restriction_admin.plugin_admin_url} class="content-restriction__btn content-restriction__btn--sm content-restriction__btn--back">
            <ArrowLeftOutlined />
          </a>
          <img src={logo} alt="CR" />
          <div className="content-restriction__header__action__input">
            { 
              editableTitle ?
              <input
                type="text"
                ref={inputRef}
                value={ruleTitle}
                onChange={(e) => dispatch(store).setRuleTitle(e.target.value)}
              /> :
              <h2 className="content-restriction__header__title">{ruleTitle}</h2>
            }
            
            <p className="content-restriction__header__action__edit">
              {
                editableTitle ?
                <ArrowLeftOutlined
                  onClick={(e) => {
                    e.stopPropagation(); 
                    setEditableTitle(false); 
                  }}
                /> :
                <EditOutlined
                  onClick={(e) => {
                    e.stopPropagation(); // Prevent the click from propagating
                    setEditableTitle(true); // Enable editing mode when clicking on Tooltip
                  }}
                />
              }
            </p>
          </div>
        </div>
       
        <div className="content-restriction__header__action content-restriction__header__action--right">
          <Switch
            checked={status}
            onChange={handleChange}
            checkedChildren=""
            unCheckedChildren=""
          />

          <button 
            className="content-restriction__btn content-restriction__btn--create"
            onClick={publishButtonClickHandler}
          >
            {ruleID ? __( 'Update', 'content-restriction' ): __( 'Publish', 'content-restriction' )}
          </button>
          {
            ruleID &&
            <>
              <button 
                className="content-restriction__btn content-restriction__btn--delete"
                onClick={handleDropdown}
                ref={dropdownRef}
              >
                ...
              </button>
              <ul className={`content-restriction__single__btn__dropdown ${openDropDown ? 'active' : ''}`}>
                    <li className="content-restriction__single__btn__dropdown__item">
                        <button
                            className="content-restriction__single__btn__dropdown__btn content-restriction__single__btn__dropdown__btn--delete"
                            onClick={() => showDeleteConfirm(ruleID)}
                        >
                          {__( 'Delete', 'content-restriction' )}
                        </button>
                    </li>
              </ul>
            </>
          }
        </div>
      </div>
    </>
  );
}