const actions = {

	setWhoCanSee( whoCanSee ) {
		return {
			type: 'SET_WHO_CAN_SEE',
			whoCanSee,
		};
	},

	setWhatContent( whatContent ) {
		return {
			type: 'SET_WHAT_CONTENT',
			whatContent,
		};
	},

	setRestrictView( restrictView ) {
		return {
			type: 'SET_RESTRICT_VIEW',
			restrictView,
		};
	},

	setRule( rule ) {
		return {
			type: 'SET_RULE',
			rule,
		};
	},

	setRulePublished( status ) {
		return {
			type: 'SET_RULE_STATUS',
			status,
		};
	},

	setId( id ) {
		return {
			type: 'SET_ID',
			id,
		};
	},

	setRuleTitle( ruleTitle ) {
		return {
			type: 'SET_RULE_TITLE',
			ruleTitle,
		};
	},

	setRuleType( ruleType ) {
		return {
			type: 'SET_RULE_TYPE',
			ruleType,
		};
	},

	setModalVisible( modalVisible ) {
		return {
			type: 'SET_MODAL_VISIBLE',
			modalVisible,
		};
	},

	setSidebarVisible( sidebarVisible ) {
		return {
			type: 'SET_SIDEBAR_VISIBLE',
			sidebarVisible,
		};
	},
};

export default actions;