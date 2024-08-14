import { createReduxStore, register } from '@wordpress/data';
import actions from './actions';
import selectors from './selectors';

const DEFAULT_STATE = {
	modalVisible: false,
	sidebarVisible: false,
	ruleType: '',
	contentRule: {
		status: false,
		ruleID: '',
		ruleTitle: '',
		whoCanSee: { },
		whatContent: { },
		restrictView: { },
		ruleData: { }
	}
};

// A helper function to get state from localStorage
const getInitialState = () => {
	return DEFAULT_STATE;
};

const store = createReduxStore('content-restriction-stores', {
	reducer(state = getInitialState(), action) {
		let newState;
		switch (action.type) {
			case 'SET_WHO_CAN_SEE':
				newState = {
					...state,
					contentRule: {
						...state.contentRule,
						whoCanSee: {
							// ...state.contentRule.whoCanSee, // Preserve previous data
							...action.whoCanSee, // Add or update with new data
						},
					},
				};
				break;

			case 'SET_WHAT_CONTENT':
				newState = {
					...state,
					contentRule: {
						...state.contentRule,
						whatContent: {
							// ...state.contentRule.whatContent, // Preserve previous data
							...action.whatContent, // Add or update with new data
						},
					},
				};
				break;

			case 'SET_RESTRICT_VIEW':
				newState = {
					...state,
					contentRule: {
						...state.contentRule,
						restrictView: {
							// ...state.contentRule.restrictView, // Preserve previous data
							...action.restrictView, // Add or update with new data
						},
					},
				};
				break;

			case 'SET_RULE':
				newState = {
					...state,
					contentRule: {
						...state.contentRule,
						ruleData: action.rule,
					},
				};
				break;
			

			case 'SET_RULE_PUBLISHED':
				newState = {
					...state,
					contentRule: {
						...state.contentRule,
						status: action.status,
					},
				};
				break;
					
			case 'SET_RULE_ID':
				newState = {
					...state,
					contentRule: {
						...state.contentRule,
						ruleID: action.ruleID,
					},
				};
				break;

			case 'SET_RULE_TITLE':
				newState = {
					...state,
					contentRule: {
						...state.contentRule,
						ruleTitle: action.ruleTitle,
					},
				};
				break;

			case 'SET_RULE_TYPE':
				newState = {
					...state,
					ruleType: action.ruleType,
				};
				break;

			case 'SET_MODAL_VISIBLE':
				newState = {
					...state,
					modalVisible: action.modalVisible,
				};
				break;

			case 'SET_SIDEBAR_VISIBLE':
				newState = {
					...state,
					sidebarVisible: action.sidebarVisible,
				};
				break;

			default:
				newState = state;
		}

		// Save the entire state to localStorage whenever it changes
		localStorage.setItem('content-restriction-stores', JSON.stringify(newState));

		return newState;
	},

	actions,

	selectors,
});

register(store);

export default store;