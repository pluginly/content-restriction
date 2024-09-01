import { dispatch, select, subscribe } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import store from '@store/index';
import postData from '@helpers/postData';
import defaultIcon from '@icons/default.svg';
import RulesModalSkeleton from './Skeletons/RulesModalSkeleton';
import { __ } from '@wordpress/i18n';

const RulesModal = () => {
    const state = select('content-restriction-stores');
    
	const [ selectedType, setSelectedType ] = useState( state.getRuleType() || 'who-can-see');
	const [ rulesType, setRulesType ] = useState( [] );
	const [ rulesTypeLoaded, setRulesTypeLoaded ] = useState( false );
	const [ modalVisible, setModalVisible ] = useState( state.getModal() || false );
	const [ modalTitle, setModalTitle ] = useState( '-' );
	const [ modalSubTitle, setModalSubTitle ] = useState( '-' );

    useEffect( () => {
        setModalVisible(state.getModal());

        // Subscribe to changes in the store's data
        const storeUpdate = subscribe( () => {
            const modalVisible = state.getModal();
            const ruleType = state.getRuleType();

            setModalVisible( modalVisible );
            setSelectedType( ruleType );
            
            if( 'restrict-view' === selectedType ) {
                setModalTitle(__( 'How should the content be protected?', 'content-restriction' ));
                setModalSubTitle(__( 'When user does not have access permission, the following options help control their experience.', 'content-restriction' ));
            } 

            if( 'what-content' === selectedType ) {
                setModalTitle(__( 'What content will be unlocked?', 'content-restriction' ));
                setModalSubTitle(__( 'When user have access permission, the following content will be available.', 'content-restriction' ));
            }

            if( 'who-can-see' === selectedType ) {
                setModalTitle(__( 'Who can see the content?', 'content-restriction' ));
                setModalSubTitle(__( 'Which user type should be allowed to see the content.', 'content-restriction' ));
            }
        } );

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
                            {
                                rulesType.length > 0 ?
                                <>
                                    <ul className="content-restriction__type">

                                        { ! rulesTypeLoaded ?
                                            <RulesModalSkeleton/>
                                        :
                                            rulesType?.map((item, index) => {
                                                return (
                                                    <>
                                                    { item.is_pro && ! content_restriction_admin.pro_available ? 
                                                    <li className="content-restriction__type__item pro-item" key={index}>
                                                        <button 
                                                            className="content-restriction__type__btn"
                                                        >
                                                            <span class="pro-badge">{__( 'Upcoming', 'content-restriction' )}</span>
                                                            <img src={item?.icon || defaultIcon} alt={item.name} />
                                                            <h3>{item.name}</h3>
                                                            <span>{item.desc}</span>
                                                        </button>
                                                    </li>
                                                    :
                                                    <li className="content-restriction__type__item" key={index}>
                                                        <button 
                                                            className="content-restriction__type__btn"
                                                            onClick={ () => selectAction(selectedType, item)}
                                                        >
                                                            <img src={item?.icon || defaultIcon} alt={item.name} />
                                                            <h3>{item.name}</h3>
                                                            <span>{item.desc}</span>
                                                        </button>
                                                    </li>
                                                    }
                                                    </>
                                                   
                                                )
                                            })
                                        }
                                    </ul>
                                </>
                                : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default RulesModal;