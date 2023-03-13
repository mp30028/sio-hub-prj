import React from 'react';
import Login from './components/Login';
import { useNavigate } from 'react-router-dom';




function Data(props){

	const navigate = useNavigate();

	const onSubmitOfCredentials = (event) =>{
		console.log("event =", event);
		console.log("credentials=",event.credentials);
		const state = {username:event.credentials.username};
		navigate("/chats", {replace: true, state});
	}
	
	
	return(
		<div style={{width: "100%"}}>
			<Login onSubmit={onSubmitOfCredentials}  />
		</div>
	);
};

export default Data;