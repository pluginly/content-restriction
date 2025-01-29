import postData from '@helpers/postData';
import defaultIcon from '@icons/default.svg';
import store from '@store/index';
import { dispatch, select, subscribe } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import RulesModalSkeleton from './Skeletons/RulesModalSkeleton';

const RulesModal = () => {
    const state = select('content-restriction-stores');
    
	const [ selectedType, setSelectedType ] = useState( state.getRuleType() || 'who-can-see');
	const [ rulesType, setRulesType ] = useState( [] );
	const [ rulesGroup, setRulesGroup ] = useState( [] );
	const [ selectedRulesGroup, setSelectedRulesGroup ] = useState( '' );
	const [ rulesTypeLoaded, setRulesTypeLoaded ] = useState( false );
	const [ modalVisible, setModalVisible ] = useState( state.getModal() || false );
	const [ modalTitle, setModalTitle ] = useState( '-' );
	const [ modalSubTitle, setModalSubTitle ] = useState( '-' );

    // Subscribe to changes in the store's data
    const storeUpdate = subscribe( () => {
        const modalVisible = state.getModal();
        const ruleType = state.getRuleType();

        setModalVisible( modalVisible );
        setSelectedType( ruleType );

        if( 'restrict-view' === ruleType ) {
            setModalTitle(__( 'How should the content be protected?', 'content-restriction' ));
            setModalSubTitle(__( 'When user does not have access permission, the following options help control their experience.', 'content-restriction' ));
        } 

        if( 'what-content' === ruleType ) {
            setModalTitle(__( 'What content will be unlocked?', 'content-restriction' ));
            setModalSubTitle(__( 'When user have access permission, the following content will be available.', 'content-restriction' ));
        }

        if( 'who-can-see' === ruleType ) {
            setModalTitle(__( 'Who can see the content?', 'content-restriction' ));
            setModalSubTitle(__( 'Which user type should be allowed to see the content.', 'content-restriction' ));
        }
    } );

    useEffect( () => {
        setModalVisible(state.getModal());

        // storeUpdate when the component is unmounted
        return () => storeUpdate();
	});

    const initModal = () => {
        setModalVisible(state.getModal());

        const whatContentAction = state.getWhatContent();
        const whoCanSeeAction = state.getWhoCanSee();
        const restrictViewAction = state.getRestrictView();

        selectedType && postData( `content-restriction/modules/${selectedType}`, {
            what_content : whatContentAction?.key,
            who_can_see : whoCanSeeAction?.key,
            restrict_view : restrictViewAction?.key,
        } )
            .then( ( res ) => {
                setRulesType(res);
                setRulesTypeLoaded(true);
            } )
    }

    useEffect( () => {
        initModal();
        setRulesTypeLoaded(false);

	}, [selectedType]);

    useEffect( () => {
        // Dynamically group by 'group' and handle undefined groups
        const categorizedData = rulesType.reduce((result, item) => {
            const group = item.group || "others"; // Default to 'others' if group is not defined
            if (!result[group]) {
                result[group] = []; // Create the group if it doesn't exist
            }
            result[group].push(item);
            return result;
        }, {});

        // Get the group names (keys) from the categorized data
        const groupKeys = Object.keys(categorizedData);
        setRulesGroup(groupKeys);

	}, [rulesType]);
    
    useEffect( () => {
        initModal();
	}, []);

    const closeModal = () => {
        dispatch( store ).setModalVisible(false);
    }

    const selectAction = (type, action) => {
        dispatch( store ).setModalVisible(false);
        dispatch( store ).setSidebarVisible(true);
        dispatch( store ).setRuleType( type );

        const ruleData = state.getRuleData(); // Get the current state from the store
        const updateData = {...ruleData, [type]: action.key};

        dispatch(store).setRule(updateData);
        
        if (type === 'who-can-see') {
            dispatch( store ).setWhoCanSee( action );
        } else if (type === 'what-content') {
            dispatch( store ).setWhatContent( action );
        } else if (type === 'restrict-view') {
            dispatch( store ).setRestrictView( action );
        } 
    }

    function capitalizeWords(str) {
        return str.split(' ')
                  .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                  .join(' ');
    }
    

    return (
        <div className={`content-restriction__modal ${modalVisible ? 'content-restriction__modal--visible' : ''}`}>
            <div className="content-restriction__modal__overlay" onClick={closeModal}></div>
            <div className="content-restriction__modal__content">
                <div className="content-restriction__modal__content__header">
                    <div className="content-restriction__modal__content__header__info">
                        <div class="info-text">
                            <h2 class="content-restriction__modal__content__title">{modalTitle}</h2>
                            <p class="content-restriction__modal__content__desc">{modalSubTitle}</p>
                        </div>
                    </div>
                    <div className="content-restriction__modal__content__header__action">
                        <button 
                            className="content-restriction__modal__content__close-btn"
                            onClick={closeModal}
                        >
                            x
                        </button>
                    </div>
                </div>
                <div className="content-restriction__modal__content__body">
                    <div className="content-restriction__modal__content__wrapper">
                        <div className="content-restriction__module">
                            {rulesType.length > 0 ? (
                                <>
                                    {rulesGroup.length > 0 && selectedType === "what-content" && (
                                        <ul className="content-restriction__group">
                                            <li key="all" className="content-restriction__group__item">
                                                <button
                                                className={`content-restriction__group__btn ${!selectedRulesGroup ? 'active' : ''}`}
                                                onClick={() => setSelectedRulesGroup('')}
                                                >
                                                All
                                                </button>
                                            </li>
                                            {rulesGroup.map((group) => (
                                                <li key={group} className="content-restriction__group__item">
                                                    <button
                                                        className={`content-restriction__group__btn ${selectedRulesGroup === group ? 'active' : ''}`}
                                                        onClick={() => setSelectedRulesGroup(group)}
                                                    >
                                                        { capitalizeWords(group) }
                                                    </button>
                                                </li>
                                            ))}
                                        </ul>
                                    )}
                                    <ul className="content-restriction__type">
                                        {!rulesTypeLoaded ? (
                                            <RulesModalSkeleton />
                                        ) : (
                                        rulesType
                                            .filter((item) => {
                                                if (!selectedRulesGroup) {
                                                    // Return all items when selectedRulesGroup is not set (falsy)
                                                    return true;
                                                }
                                                if (selectedRulesGroup === "others") {
                                                    // Show items with no group when "others" is selected
                                                    return !item.group;
                                                }
                                                // Show items matching the selected group
                                                return item.group === selectedRulesGroup;
                                            })
                                            .map((item, index) => (
                                                <li
                                                    className={`content-restriction__type__item ${item.upcoming || (item.is_pro && !content_restriction_admin.pro_available) ? 'pro-item' : ''}`}
                                                    key={index}
                                                >
                                                    <button
                                                        className="content-restriction__type__btn"
                                                        onClick={
                                                            item.upcoming || (item.is_pro && !content_restriction_admin.pro_available)
                                                            ? undefined
                                                            : () => selectAction(selectedType, item)
                                                        }
                                                        title={
                                                            item.is_pro
                                                            ? __('Upgrade Now', 'content-restriction')
                                                            : item.upcoming
                                                            ? __('Upcoming', 'content-restriction')
                                                            : ''
                                                        }
                                                    >
                                                    {item.upcoming && <span className="upcoming-badge">{__('Upcoming', 'content-restriction')}</span>}
                                                    {item.is_pro && (
                                                        <span className="pro-badge">
                                                            <svg
                                                                width="20"
                                                                height="20"
                                                                viewBox="0 0 12 12"
                                                                fill="none"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                            >
                                                                <g clipPath="url(#clip0_457_540)">
                                                                <path
                                                                    d="M12 3.06766C12 2.40317 11.4594 1.86264 10.795 1.86264C10.1305 1.86264 9.58997 2.40317 9.58997 3.06766C9.58997 3.61594 9.61278 4.33792 9.16941 4.66046L8.70365 4.9993C8.219 5.35188 7.53519 5.20188 7.24262 4.67881L7.01772 4.27675C6.7391 3.77861 7.00523 3.12326 7.14059 2.56878C7.16295 2.47719 7.1748 2.38153 7.1748 2.28314C7.1748 1.61865 6.63428 1.07812 5.96979 1.07812C5.3053 1.07812 4.76477 1.61865 4.76477 2.28314C4.76477 2.39417 4.77986 2.50174 4.80809 2.6039C4.95811 3.1467 5.23419 3.78222 4.97543 4.2824L4.80172 4.61819C4.51816 5.16632 3.81066 5.32929 3.31588 4.96046L2.82316 4.59317C2.37951 4.26245 2.41013 3.53404 2.41013 2.98068C2.41013 2.31619 1.8696 1.77567 1.20511 1.77567C0.540527 1.77567 0 2.31619 0 2.98068C0 3.33173 0.150933 3.64809 0.391293 3.86846C0.666239 4.12054 0.977007 4.37886 1.06625 4.74104L2.29778 9.73924C2.40786 10.186 2.80861 10.5 3.26874 10.5H8.80645C9.26982 10.5 9.6725 10.1817 9.77945 9.73081L10.9414 4.83229C11.028 4.46732 11.3394 4.20557 11.6143 3.95037C11.8514 3.73024 12 3.41603 12 3.06766Z"
                                                                    fill="#F17D0E"
                                                                ></path>
                                                                </g>
                                                                <defs>
                                                                <clipPath id="clip0_457_540">
                                                                    <rect width="12" height="12" fill="white"></rect>
                                                                </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </span>
                                                    )}
                                                        <img src={item?.icon || defaultIcon} alt={item.name} />
                                                        <h3>{item.name}</h3>
                                                        <span>{item.desc}</span>
                                                        {item.group && <span className="group">{item.group}</span>}
                                                    </button>
                                                </li>
                                            ))
                                        )}
                                    </ul>
                                </>
                            ) : (
                                ''
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default RulesModal;