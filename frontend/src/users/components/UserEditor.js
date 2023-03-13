import React, { useEffect, useState } from 'react';
import * as DataService from "../services/DataServices";

export function UserEditor(props) {
	const emptyUser = {id: "", firstname: "", lastname: "", email: "", username: "", password: ""};
		
	const [user, setUser] = useState(emptyUser);
	const [saveButtonValue, setSaveButtonValue] = useState("SAVE_NEW");
	
	useEffect(() => {	
		setUser(props.user);
		setSaveButtonValue("SAVE_UPDATE");
	}, [props]);
		
	const handleChange = (event) => {
//		console.log("event=", event);
		event.preventDefault();		
		const {name, value} = event.target;
		const userCopy = { ...user };
		userCopy[name] = value;
		setUser(userCopy);
	}
	
	const handleSubmit = (event) =>{
		event.preventDefault();	
		const {name, value} = event.target;
		console.log("FROM UserEditor.handleSubmit: button name=", name, ", value=", value);
		if (value === "SAVE_UPDATE" ){
			DataService.doUpdate(user);
			setUser(emptyUser);
		}else if (value === "SAVE_NEW" ){
			DataService.doCreate(user);
			setUser(emptyUser);
		}else if (value === "DELETE" ){
			DataService.doDelete(user);
			setUser(emptyUser);
		}else if (value === "CREATE" ){
			setUser(emptyUser);
			setSaveButtonValue("SAVE_NEW");			
		}		
	}
	
	return (
		<form style={{width:"100%" }}>
			<table  className="zsft-table" style={{width:"100%" }}>
				<tbody>
					<tr>
						<th>ID</th>
						<td>
							<input type="text" name="userId" id="userId" value={user.id} readOnly style={{width:"90%" }} />
						</td>
					</tr>
					<tr>
						<th>Firstname</th>
						<td><input type="text" name="firstname" id="firstname" value={user.firstname} onChange={handleChange} style={{width:"90%" }}/></td>
					</tr>
					<tr>
						<th>Lastname</th>
						<td><input type="text" name="lastname" id="lastname" value={user.lastname} onChange={handleChange} style={{width:"90%" }}/></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><input type="text" name="email" id="email" value={user.email} onChange={handleChange} style={{width:"90%" }}/></td>
					</tr>
					<tr>
						<th>Username</th>
						<td><input type="text" name="username" id="username" value={user.username} onChange={handleChange} style={{width:"90%" }}/></td>
					</tr>
					<tr>
						<th>Password</th>
						<td><input type="text" name="password" id="password" value={user.password} onChange={handleChange} style={{width:"90%" }}/></td>
					</tr>
					<tr>
						<td colSpan="2" style={{textAlign:"right"}}>
							<button type="submit" onClick={handleSubmit} name="submit" value="CREATE">Add New</button>
							<button type="submit" onClick={handleSubmit} name="submit" value="DELETE">Delete</button>
							<button type="submit" onClick={handleSubmit} name="submit" value={saveButtonValue}>Save</button>					
							<button type="submit" onClick={handleSubmit} name="submit" value="CANCEL">Cancel</button>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	);
}

export default UserEditor;