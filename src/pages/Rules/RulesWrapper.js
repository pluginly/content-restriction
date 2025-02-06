import DropDownContent from '@components/DropDownContent';
import postData from '@helpers/postData';
import transformString from '@helpers/transformString';
import defaultIcon from '@icons/default.svg';
import store from '@store/index';
import { dispatch, select, subscribe } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import RulesModal from './RulesModal';
import RulesSidebar from './RulesSidebar';
import ModuleSelectSkeleton from './Skeletons/ModuleSelectSkeleton';

export default function RulesWrapper() {
    const [id, setRuleId] = useState(null);
    const [rules, setRules] = useState( [] );
    const [selectedWhoCanSee, setWhoCanSee] = useState('');
    const [selectedWhatContent, setWhatContent] = useState('');
    const [selectedRestrictView, setRestrictView] = useState('');
    const [openKey, setOpenKey] = useState(null);
	const [ rulesSelectedLoaded, setRulesSelectedLoaded ] = useState( false );

    const [whoCanSeeIcon, setWhoCanSeeIcon] = useState(defaultIcon);
    const [whatContentIcon, setWhatContentIcon] = useState(defaultIcon);
    const [restrictViewIcon, setRestrictViewIcon] = useState(defaultIcon);

    const resetValues = { name: '', key: '', type: '', options: '' }

    useEffect(() => {
        const urlParts = window.location.href.split('/');
        const lastUrlPart = urlParts[urlParts.length - 1];

        if ( 'rule' === lastUrlPart ) {
            setRulesSelectedLoaded(true);

            dispatch(store).setWhoCanSee(resetValues);
            dispatch(store).setWhatContent(resetValues);
            dispatch(store).setRestrictView(resetValues);

            dispatch(store).setRuleTitle('');
            dispatch(store).setRulePublished('');
            dispatch(store).setId('');
            dispatch(store).setRule('');

            return;
        }

        setRuleId(urlParts[6])
        
        postData( 'content-restriction/rules/list' )
            .then( ( res ) => {
                setRules(res);

                const activeRule = res.length > 0 && res.find(rule => rule.id === lastUrlPart);
               
                dispatch(store).setId(activeRule?.id);
                dispatch(store).setRule(activeRule?.rule);
                dispatch(store).setRulePublished(activeRule?.status);
                dispatch(store).setRuleTitle(activeRule?.title);

                // Extract initial values from defaultData
                const initialWhoCanSee = activeRule && activeRule?.rule["who-can-see"] ? 
                    typeof(activeRule?.rule["who-can-see"]) === 'object' ? 
                        Object.keys(activeRule?.rule["who-can-see"])[0] :  
                        typeof(activeRule?.rule["who-can-see"]) === 'string' ?
                            activeRule?.rule["who-can-see"] : 
                            '' : '';
                const initialWhatContent = activeRule && activeRule?.rule["what-content"] ?
                    typeof(activeRule?.rule["what-content"]) === 'object' ?
                        Object.keys(activeRule?.rule["what-content"])[0] :  
                        typeof(activeRule?.rule["what-content"]) === 'string' ?
                            activeRule?.rule["what-content"] : 
                            '' : '';
                const initialRestrictView = activeRule && activeRule?.rule["restrict-view"] ? 
                    typeof(activeRule?.rule["restrict-view"]) === 'object' ? 
                        Object.keys(activeRule?.rule["restrict-view"])[0] : 
                            typeof(activeRule?.rule["restrict-view"]) === 'string' ?
                                activeRule?.rule["restrict-view"] : 
                                '' : '';

                setWhoCanSee(transformString(initialWhoCanSee));
                setWhatContent(transformString(initialWhatContent));
                setRestrictView(transformString(initialRestrictView));

                const fetchData = async (defaultType, defaultAction) => {
                    try {
                        const res = defaultType && await postData( `content-restriction/modules/${defaultType}`, {
                            what_content : initialWhatContent,
                            who_can_see : initialWhoCanSee,
                            restrict_view : initialRestrictView,
                        } )
                
                        // Filter the result and access the first element
                        const action = res.find(item => item.key === defaultAction);
                
                        if (action) { // Check if action is not empty
                            if (defaultType === 'who-can-see') {
                                dispatch(store).setWhoCanSee(action);
                            } else if (defaultType === 'what-content') {
                                dispatch(store).setWhatContent(action);
                            } else if (defaultType === 'restrict-view') {
                                dispatch(store).setRestrictView(action);
                            }
                        } else {
                        }
                    } catch (error) {
                        // console.log('Wrapper - Rules Data Error', error);
                    }
                };
                
                fetchData('who-can-see', initialWhoCanSee);
                fetchData('what-content', initialWhatContent);
                fetchData('restrict-view', initialRestrictView);  

                setRulesSelectedLoaded(true);
            } )
            .catch( ( error ) => {
                // console.log('Rules List Error', error);
            });
    }, [])

    useEffect(() => {
        const state = select('content-restriction-stores');

        // Subscribe to changes in the store's data
        const storeUpdate = subscribe(() => {
            const whoCanSeeAction = state.getWhoCanSee();
            const whatContentAction = state.getWhatContent();
            const restrictViewAction = state.getRestrictView();

            setWhoCanSee(whoCanSeeAction.name);
            setWhatContent(whatContentAction.name);
            setRestrictView(restrictViewAction.name);

            setWhoCanSeeIcon(whoCanSeeAction.icon ?? whoCanSeeIcon);
            setWhatContentIcon(whatContentAction.icon ?? whatContentIcon);
            setRestrictViewIcon(restrictViewAction.icon ?? restrictViewIcon);
        });

        // Unsubscribe when the component is unmounted
        return () => storeUpdate();
    }, [rules]);

    const selectRuleType = (e, type) => {
        e.stopPropagation();

        dispatch(store).setRuleType(type);

        if (type === 'who-can-see') {
            selectedWhoCanSee ? openSidebar() : showModal();
        } else if (type === 'what-content') {
            selectedWhatContent ? openSidebar() : showModal();
        } else if (type === 'restrict-view') {
            selectedRestrictView ? openSidebar() : showModal();
        }
    };

    const showModal = () => {
        setOpenKey(null);

        dispatch(store).setModalVisible(true);
    };

    const openSidebar = () => {
        setOpenKey(null);

        dispatch(store).setSidebarVisible(true);
    };

    const resetType = (e, type) => {
        e.stopPropagation();

        dispatch(store).setModalVisible(false);
        dispatch(store).setSidebarVisible(false);
        if (type === 'who-can-see') {
            setWhoCanSee('');
            dispatch(store).setWhoCanSee(resetValues);
        } else if (type === 'what-content') {
            setWhatContent('');
            dispatch(store).setWhatContent(resetValues);
        } else if (type === 'restrict-view') {
            setRestrictView('');
            dispatch(store).setRestrictView(resetValues);
        }
    };

    const changeAction = (e, type) => {
        e.stopPropagation();
        setOpenKey(null);

        dispatch(store).setRuleType(type);
        dispatch(store).setModalVisible(true);
    };

    return (
        <>
            <section className="content-restriction__create-rules">

                { ! rulesSelectedLoaded ?
                <>
                    <ModuleSelectSkeleton/>
                    <ModuleSelectSkeleton/>
                    <ModuleSelectSkeleton/>
                </>
                :
                <>
                    <div className="content-restriction__single">         
                        <div
                            className="content-restriction__single__btn"
                            onClick={(e) => selectRuleType(e, 'who-can-see')}
                        >
                            <img src={whoCanSeeIcon} />
                            {selectedWhoCanSee ? (
                                <>
                                    <h3 className="content-restriction__single__btn__title">{selectedWhoCanSee}</h3>
                                    <DropDownContent
                                        id={id}
                                        type="who-can-see"
                                        openKey={openKey}
                                        setOpenKey={setOpenKey}
                                        changeAction={changeAction}
                                        resetType={resetType}
                                    />
                                </>
                            ) : <h3 className="content-restriction__single__btn__title">{__( 'Who can see the content?', 'content-restriction' )}</h3>}
                        </div>
                    </div>
                    <div className="content-restriction__single">
                        <div
                            className={`content-restriction__single__btn ${!selectedWhoCanSee ? 'disabled' : ''}`}
                            onClick={(e) => selectRuleType(e, 'what-content')}
                        >
                            <img src={whatContentIcon} />
                            {selectedWhatContent ? (
                                <>
                                    <h3 className="content-restriction__single__btn__title">{selectedWhatContent}</h3>
                                    <DropDownContent
                                        id={id}
                                        type="what-content"
                                        openKey={openKey}
                                        setOpenKey={setOpenKey}
                                        changeAction={changeAction}
                                        resetType={resetType}
                                    />
                                </>
                            ) : <h3 className="content-restriction__single__btn__title">{__( 'What content will be unlocked?', 'content-restriction' )}</h3>}
                        </div>
                    </div>
                    <div className="content-restriction__single">
                        <div
                            className={`content-restriction__single__btn ${!selectedWhoCanSee || !selectedWhatContent ? 'disabled' : ''}`}
                            onClick={(e) => selectRuleType(e, 'restrict-view')}
                        >
                            <img src={restrictViewIcon} />
                            {selectedRestrictView ? (
                                <>  
                                    <h3 className="content-restriction__single__btn__title">{selectedRestrictView}</h3>
                                    <DropDownContent
                                        id={id}
                                        type="restrict-view"
                                        openKey={openKey}
                                        setOpenKey={setOpenKey}
                                        changeAction={changeAction}
                                        resetType={resetType}
                                    />
                                </>
                            ) : <h3 className="content-restriction__single__btn__title">{__( 'How should the content be protected?', 'content-restriction' )}</h3>}
                        </div>
                    </div>
                 </>
                }
            </section>

            <RulesModal />

            <RulesSidebar />
        </>
    );
}
