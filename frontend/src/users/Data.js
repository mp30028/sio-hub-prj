import React, {useState } from 'react';
import UserList from "./components/UserList";
import UserEditor from "./components/UserEditor";

function Data(){
	const emptyUser = {id: "", firstname: "", lastname: "", email: "", username: "", password: ""};	
	const [currentUser, setCurrentUser] = useState(emptyUser);
	
	const selectionHandler = (selectedUser) =>{
		setCurrentUser(selectedUser);		
	} 
	
	return(
		<table style={{width: "100%"}}>
			<tbody>
				<tr>
					<td style={{width: "70%", verticalAlign: "top", borderWidth: "0"}} >
						<UserList selectionHandler={selectionHandler} />
					</td>
					<td style={{width: "30%",verticalAlign: "top", borderWidth: "0"}}>
						<UserEditor user={(currentUser ? currentUser : emptyUser)} />
					</td>
				</tr>							
			</tbody>
		</table>
	);
};

export default Data;