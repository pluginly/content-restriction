const selectors = {
	getRuleData(state) {
		return state.contentRule.ruleData;
	},
	getRulePublished(state) {
		return state.contentRule.isPublished;
	},
	getRuleID(state) {
		return state.contentRule.ruleID;
	},
	getRuleTitle(state) {
		return state.contentRule.ruleTitle;
	},
	getWhoCanSee(state) {
		return state.contentRule.whoCanSee;
	},
	getWhatContent(state) {
		return state.contentRule.whatContent;
	},
	getRestrictView(state) {
		return state.contentRule.restrictView;
	},
	getRule(state) {
		return state.contentRule;
	},
	getRuleType(state) {
		return state.ruleType;
	},
	getModal(state) {
		return state.modalVisible;
	},
	getSidebar(state) {
		return state.sidebarVisible;
	},
};

export default selectors;
