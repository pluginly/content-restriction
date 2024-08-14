import { ArrowLeftOutlined, EditOutlined } from "@ant-design/icons";
import { dispatch, select, subscribe } from '@wordpress/data';
import { useEffect, useRef, useState } from '@wordpress/element';
import { Switch } from "antd";
import { useNavigate } from 'react-router-dom';
import store from '@store/index';
import showDeleteConfirm from "@helpers/showDeleteConfirm";
import { __ } from '@wordpress/i18n';
import { Link } from 'react-router-dom';
import handleCreateRule from "./handleCreateRule";
import handleUpdateRule from "./handleUpdateRule";

export default function Header({ }) {
	const [ contentRule, setContentRule ] = useState( {} );
	const [ id, setId ] = useState( '' );
	const [ ruleTitle, setRuleTitle ] = useState( 'Untitled Rule' );
	const [ editableTitle, setEditableTitle ] = useState( false );
  const [ status, setStatus ] = useState(false);
  const [ openDropDown, setOpenDropDown ] = useState(false);
  
  const history = useNavigate();
  const state = select('content-restriction-stores');

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
        const id = state.getId();
        const rule = state.getRuleData();
        const title = state.getRuleTitle();
        const status =  state.getRuleStatus();

        setId(id);
        setRuleTitle(title || ruleTitle);
        setContentRule(rule);
        setStatus(status);
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

  const publishButtonClickHandler = id
    ? () => handleUpdateRule(id, contentRule, ruleTitle, status)
    : () => handleCreateRule(contentRule, ruleTitle, status, history);

  return (
    <>
      <div className="content-restriction__header">
        <div className="content-restriction__header__action content-restriction__header__action--left">

          <Link to="/" class="content-restriction__btn content-restriction__btn--sm content-restriction__btn--back">
            <ArrowLeftOutlined /> 
            {__( 'Back', 'content-restriction' )}
          </Link>
          
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
            {id ? __( 'Update', 'content-restriction' ): __( 'Publish', 'content-restriction' )}
          </button>
          {
            id &&
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
                            onClick={() => showDeleteConfirm(id, history)}
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