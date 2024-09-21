import { dispatch, select, subscribe } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import { Input, Select, Slider } from 'antd';
import 'react-tabs/style/react-tabs.css';
import store from '@store/index';
import transformString from '@helpers/transformString';
import transformOptionsForSelect from '@helpers/transformOptionsForSelect';
import { __ } from '@wordpress/i18n';

const { TextArea } = Input;

const RulesSidebar = () => {
    const [selectedType, setSelectedType] = useState(false);
    const [actionTitle, setActionTitle] = useState('Action');
    const [selectedAction, setSelectedAction] = useState();
    const [sidebarVisible, setSidebarVisible] = useState(false);
    const [conditionValue, setConditionValue] = useState(false);

    const [selectedKey, setSelectedKey] = useState(null);
    const [nestedOptions, setNestedOptions] = useState([]);
    const [selectedNestedKeys, setSelectedNestedKeys] = useState(null);
    const [selectedData, setSelectedData] = useState({});
    const [whatContentKey, setWhatContentKey] = useState('');

    useEffect(() => {
        const state = select('content-restriction-stores');
        setSidebarVisible(state.getSidebar());

        // Subscribe to changes in the store's data
        const storeUpdate = subscribe(() => {
            const sidebarVisible = state.getSidebar();
            const ruleType = state.getRuleType();
            const ruleData = state.getRuleData();
            const whoCanSee = state.getWhoCanSee();
            const whatContent = state.getWhatContent();
            const restrictView = state.getRestrictView();

            setSidebarVisible(sidebarVisible);
            setSelectedType(ruleType);
            setSelectedData(ruleData);

            if (ruleType === 'who-can-see') {
                setSelectedAction(whoCanSee);
                setActionTitle(whoCanSee.name);
            } else if (ruleType === 'what-content') {
                setSelectedAction(whatContent);
                setActionTitle(whatContent.name);
            } else if (ruleType === 'restrict-view') {
                setSelectedAction(restrictView);
                setActionTitle(restrictView.name);
            }
        });

        // Unsubscribe when the component is unmounted
        return () => storeUpdate();
    });

    const closeSidebar = () => {
        dispatch(store).setSidebarVisible(false);
    };

    const changeAction = (e) => {
        e.stopPropagation();
        dispatch(store).setSidebarVisible(false);
        dispatch(store).setModalVisible(true);
    };

    const handleMainSelectChange = (value) => {
        const selectedOptionTest = selectedAction.options[value];

        setSelectedKey(value);
        setSelectedNestedKeys([]);

        if (
            selectedOptionTest &&
            typeof selectedOptionTest === 'object' &&
            selectedOptionTest.type === 'multi-select'
        ) {
            const nestedOpts = Object.entries(selectedOptionTest.options || {}).map(([nestedKey, nestedValue]) => ({
                value: nestedKey,
                label: nestedValue,
            }));
            setNestedOptions(nestedOpts);
            setSelectedData((prevData) => ({
                ...prevData,
                [selectedType]: {
                    [selectedAction.key]: {
                        [value]: [],
                    },
                },
            }));
        } else if (selectedOptionTest) {
            setNestedOptions([]);
            setSelectedData((prevData) => ({
                ...prevData,
                [selectedType]: {
                    [selectedAction.key]: value,
                },
            }));
        } else {
            // Handle case when selectedOptionTest is undefined
            setNestedOptions([]);
        }
    };

    const handleNestedSelectChange = (values) => {
        setSelectedNestedKeys(values);
        setSelectedData((prevData) => ({
            ...prevData,
            [selectedType]: {
                [selectedAction.key]: {
                    [selectedKey]: values,
                },
            },
        }));
    };

    // Handle input changes
    const handleInputChange = (key, value) => {
        setSelectedData((prevData) => ({
            ...prevData,
            [selectedType]: {
                [selectedAction.key]: {
                    ...prevData[selectedType]?.[selectedAction.key],
                    [key]: value,
                },
            },
        }));
    };

    useEffect(() => {
        const whatContentData = selectedData && selectedData['what-content'];
        if (whatContentData && typeof whatContentData === 'object') {
            // Iterating over the keys and values in "what-content"
            for (const [key, value] of Object.entries(whatContentData)) {
                setWhatContentKey(key);
            }
        } else {
            setWhatContentKey(whatContentData);
        }

        dispatch(store).setRule(selectedData);
    }, [selectedData]);

    useEffect(() => {
        setSelectedKey(null);
        setNestedOptions(null);
        setSelectedNestedKeys(null);

        // Set default values based on defaultData when selectedAction changes
        if (selectedAction && !selectedAction?.options) {
            setSelectedData((prevData) => ({
                ...prevData,
                [selectedType]: selectedAction?.key,
            }));
        } else {
            if (selectedAction && selectedType && selectedData && selectedData[selectedType]?.[selectedAction.key]) {
                const actionData = selectedData[selectedType][selectedAction.key];
                if (typeof actionData === 'string' || typeof actionData === 'number') {
                    setSelectedKey(actionData);
                    setNestedOptions([]);
                    setSelectedNestedKeys([]);
                } else if (typeof actionData === 'object') {
                    const firstKey = Object.keys(actionData)[0];
                    setSelectedKey(firstKey);

                    if (Array.isArray(actionData[firstKey])) {
                        setSelectedNestedKeys(actionData[firstKey]);
                        const selectedOptionTest = selectedAction.options[firstKey];
                        if (selectedOptionTest && selectedOptionTest.type === 'multi-select') {
                            const nestedOpts = Object.entries(selectedOptionTest.options || {}).map(
                                ([nestedKey, nestedValue]) => ({
                                    value: nestedKey,
                                    label: nestedValue,
                                })
                            );
                            setNestedOptions(nestedOpts);
                        }
                    } else {
                        setNestedOptions([]);
                        setSelectedNestedKeys([]);
                    }
                }
            } else {
                setSelectedData((prevData) => ({
                    ...prevData,
                    [selectedType]: selectedAction?.key,
                }));
            }
        }
    }, [selectedAction]);

    return (
        <div
            className={`content-restriction__sidebar ${
                sidebarVisible ? 'content-restriction__sidebar--visible' : ''
            }`}
        >
            {selectedAction ? (
                <div className="content-restriction__sidebar__content">
                    <div className="content-restriction__sidebar__content__header">
                        <h2 className="content-restriction__sidebar__content__title">
                            {actionTitle}
                        </h2>
                        <button
                            className="content-restriction__sidebar__content__btn"
                            onClick={(e) => changeAction(e)}
                        >
                           {__( 'Change', 'content-restriction' )}
                        </button>
                        <button
                            className="content-restriction__sidebar__content__close-btn"
                            onClick={closeSidebar}
                        >
                            x
                        </button>
                    </div>
                    <div className="content-restriction__sidebar__content__body">
                        <div className="content-restriction__sidebar__tab">
                            <div
                                className="tab-content content-restriction__sidebar__tab__content"
                                id="nav-tabContent"
                            >
                                <div className="content-restriction__sidebar__tab__content__event">
                                    <div className="content-restriction__sidebar__tab__content__event__wrapper">
                                        { selectedAction?.type === 'select' ? (
                                            <>
                                                <h3 className="content-restriction__sidebar__tab__content__event__title">
                                                {__( 'Select ', 'content-restriction' )} {selectedAction?.name}   {__( '(required) ', 'content-restriction' )}
                                                </h3>
                                                <Select
                                                    allowClear
                                                    style={{ width: '100%', marginBottom: '10px' }}
                                                    placeholder={__( 'Please select an option', 'content-restriction' )}
                                                    onChange={handleMainSelectChange}
                                                    options={transformOptionsForSelect(
                                                        selectedAction?.options
                                                    )}
                                                    value={selectedKey}
                                                />
                                                {selectedKey && nestedOptions.length > 0 && (
                                                    <>
                                                        <h3 className="content-restriction__sidebar__tab__content__event__title">
                                                            {' '}
                                                            {__( 'Choose', 'content-restriction' )} {transformString(selectedKey)}
                                                        </h3>
                                                        <Select
                                                            mode="multiple"
                                                            allowClear
                                                            style={{ width: '100%' }}
                                                            placeholder={`Select ${selectedKey} option`}
                                                            onChange={handleNestedSelectChange}
                                                            options={nestedOptions}
                                                            value={selectedNestedKeys}
                                                        />
                                                    </>
                                                )}
                                            </>
                                        ) : selectedAction?.type === 'section' ? (
                                            <>
                                                {selectedAction.options &&
                                                Object.entries(selectedAction.options).length > 0 ? (
                                                    Object.entries(selectedAction.options).map(
                                                        ([key, option]) => {
                                                            if (
                                                                option.type === 'text' ||
                                                                option.type === 'url'
                                                            ) {
                                                                return (
                                                                    <div
                                                                        className="content-restriction__sidebar__tab__content__event__section-wrapper"
                                                                        key={key}
                                                                    >
                                                                        <h3 className="content-restriction__sidebar__tab__content__event__title">
                                                                            {option.title}
                                                                        </h3>
                                                                        <Input
                                                                            id={`content-restriction__${key}`}
                                                                            placeholder={`Type ${option.title}`}
                                                                            value={
                                                                                (selectedData &&
                                                                                    selectedData[
                                                                                        selectedType
                                                                                    ]?.[
                                                                                        selectedAction
                                                                                            .key
                                                                                    ]?.[key]) ||
                                                                                ''
                                                                            }
                                                                            onChange={(e) =>
                                                                                handleInputChange(
                                                                                    key,
                                                                                    e.target.value
                                                                                )
                                                                            }
                                                                        />
                                                                    </div>
                                                                );
                                                            } else if (option.type === 'textarea') {
                                                                return (
                                                                    <div
                                                                        className="content-restriction__sidebar__tab__content__event__section-wrapper"
                                                                        key={key}
                                                                    >
                                                                        <h3 className="content-restriction__sidebar__tab__content__event__title">
                                                                            {option.title}
                                                                        </h3>
                                                                        <TextArea
                                                                            id={`content-restriction__${key}`}
                                                                            rows={4}
                                                                            placeholder={`Type ${option.title}`}
                                                                            value={
                                                                                (selectedData &&
                                                                                    selectedData[
                                                                                        selectedType
                                                                                    ]?.[
                                                                                        selectedAction
                                                                                            .key
                                                                                    ]?.[key]) ||
                                                                                ''
                                                                            }
                                                                            onChange={(e) =>
                                                                                handleInputChange(
                                                                                    key,
                                                                                    e.target.value
                                                                                )
                                                                            }
                                                                        />
                                                                    </div>
                                                                );
                                                            } else if (option.type === 'range') {
                                                                return (
                                                                    <div
                                                                        className="content-restriction__sidebar__tab__content__event__section-wrapper"
                                                                        key={key}
                                                                    >
                                                                        <h3 className="content-restriction__sidebar__tab__content__event__title">
                                                                            {option.title}
                                                                        </h3>
                                                                        <Slider
                                                                            defaultValue={
                                                                                option.default
                                                                            }
                                                                            value={
                                                                                (selectedData &&
                                                                                    selectedData[
                                                                                        selectedType
                                                                                    ]?.[
                                                                                        selectedAction
                                                                                            .key
                                                                                    ]?.[key]) ||
                                                                                option.default
                                                                            }
                                                                            onChange={(value) =>
                                                                                handleInputChange(
                                                                                    key,
                                                                                    value
                                                                                )
                                                                            }
                                                                        />
                                                                    </div>
                                                                );
                                                            } else if (
                                                                option.type === 'multi-select'
                                                            ) {
                                                                return (
                                                                    <div
                                                                        className="content-restriction__sidebar__tab__content__event__section-wrapper"
                                                                        key={key}
                                                                    >
                                                                        <h3 className="content-restriction__sidebar__tab__content__event__title">
                                                                            {option.title}
                                                                        </h3>
                                                                        <Select
                                                                            mode="multiple"
                                                                            allowClear
                                                                            style={{ width: '100%' }}
                                                                            placeholder={__( "Please select", 'content-restriction' )}
                                                                            onChange={(values) =>
                                                                                handleInputChange(
                                                                                    key,
                                                                                    values
                                                                                )
                                                                            }
                                                                            options={transformOptionsForSelect(
                                                                                option.options
                                                                            )}
                                                                            value={
                                                                                (selectedData &&
                                                                                    selectedData[
                                                                                        selectedType
                                                                                    ]?.[
                                                                                        selectedAction
                                                                                            .key
                                                                                    ]?.[key]) ||
                                                                                []
                                                                            }
                                                                        />
                                                                    </div>
                                                                );
                                                            }
                                                            return null;
                                                        }
                                                    )
                                                ) : (
                                                    <div>{__( 'No options available', 'content-restriction' )}</div>
                                                )}
                                            </>
                                        ) : (
                                            <>
                                                <p className="content-restriction__sidebar__tab__content__event__desc">
                                                    {selectedAction?.desc}
                                                </p>
                                            </>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ) : null}
        </div>
    );
};

export default RulesSidebar;