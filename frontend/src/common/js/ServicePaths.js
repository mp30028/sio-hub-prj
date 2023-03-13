const apiBaseUrl = process.env.REACT_APP_API_BASE_URL;
const usersPath = process.env.REACT_APP_USERS_API_PATH;
//const eventsSubPath = process.env.REACT_APP_EVENTS_SUB_PATH;
const websocketUrl = process.env.REACT_APP_WEBSOCKET_URL;

export const getApiUrl = (api) => {
	switch(api){
		case "USERS":
			return apiBaseUrl + usersPath;
		default:
			return "Invalid API specified.Can only be USERS";
	}
};

export const getEventsUrl = () => {
	console.log("FROM ServicePaths:", "websocketUrl=", websocketUrl);
	return websocketUrl;
}