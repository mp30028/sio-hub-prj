import React from 'react';

export function UserEditor(props) {
	
	const handleChange = (event) => {
		event.preventDefault();
		const {name, value} = event.target;
		props.onChange({event:event, name:name, value: value});
	}
	
	const handleSubmit = (event) =>{
		const {name, value} = event.target;
		props.onSubmit({event, name, value});
	}
	
	return (
		<form style={{width:"100%" }}>
			<table  className="zsft-table" style={{width:"100%" }}>
				<tbody>
					<tr>
						<th>ID</th>
						<td>
							<input type="text" name="userId" id={props.user.id} value={props.user.id} readOnly style={{width:"90%" }} />
						</td>
					</tr>
					<tr>
						<th>Firstname</th>
						<td><input type="text" name="firstname" id={props.user.id} value={props.user.firstname} onChange={handleChange} /></td>
					</tr>
					<tr>
						<th>Lastname</th>
						<td><input type="text" name="lastname" id={props.user.id} value={props.user.lastname} onChange={handleChange} /></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><input type="text" name="lastname" id={props.user.id} value={props.user.email} onChange={handleChange} /></td>
					</tr>
					<tr>
						<th>Username</th>
						<td><input type="text" name="lastname" id={props.user.id} value={props.user.username} onChange={handleChange} /></td>
					</tr>
					<tr>
						<th>Password</th>
						<td><input type="text" name="lastname" id={props.user.id} value={props.user.password} onChange={handleChange} /></td>
					</tr>
					<tr>
						<td colSpan="2" style={{textAlign:"right"}}>
							<button type="submit" onClick={handleSubmit} name="submit" value="CREATE">Add New</button>
							<button type="submit" onClick={handleSubmit} name="submit" value="DELETE">Delete</button>
							<button type="submit" onClick={handleSubmit} name="submit" value="UPDATE">Save</button>					
							<button type="submit" onClick={handleSubmit} name="submit" value="CANCEL">Cancel</button>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	);
}

export default UserEditor;