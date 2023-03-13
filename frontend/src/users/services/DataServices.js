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

export const doUpdate = async (user) => {
	const jsonString = JSON.stringify(user);
	fetch(
		ServicePaths.getApiUrl("USERS") + "/" + user.id ,
		{method: 'PUT', body: jsonString}
	);
};

export const doDelete = async (user) => {
	fetch(
		ServicePaths.getApiUrl("USERS") + "/" + user.id ,
		{method: 'DELETE'}
	);
};

export const doCreate = async (user) => {
	const jsonString = JSON.stringify(user);
	fetch(
		ServicePaths.getApiUrl("USERS") + "/" + user.id ,
		{method: 'POST', body: jsonString}
	);
};


//export const update = async (user) => {
//	const jsonString = JSON.stringify(user);
//	await fetch(
//		ServicePaths.getApiUrl("USERS") + "/" + user.id ,
//		{
//			method: 'PUT',
//			headers: {
//				'Content-Type': 'application/json;charset=UTF-8',
//				'Accept': 'application/json, text/plain'
//			},
//			body: jsonString
//		}
//	);
//}