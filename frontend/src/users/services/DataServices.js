import * as ServicePaths  from "../../common/js/ServicePaths";

export const fetchAll = async () => {
	const apiEndpoint = ServicePaths.getApiUrl("USERS");
	console.log(apiEndpoint);
	const response = await fetch(
		apiEndpoint, {
		method: 'GET'
	});
	return await response.json();
}