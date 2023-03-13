import React, { useState } from 'react';


function Login(props){
	const emptyCredentials = {username: "", password:""};
	const [credentials, setCredentials] = useState(emptyCredentials);
	
	const handleChange = (event) => {
		event.preventDefault();
		const {name, value} = event.target;
		const creds = {...credentials};
		creds[name]=value;
		setCredentials(creds); 
	}
	
	const handleSubmit = (event) =>{
		event.preventDefault();
		const newEvent = {...event, credentials};
		console.log(newEvent)
		if(props.onSubmit){
			props.onSubmit(newEvent);	
		}
	}	
	

	return(
		<form>
			<table style={{width: "100%", height: "300px"}}>
				<tbody>
					<tr>
						<td  style={{width: "100px", textAlign:"center", borderStyle:"none"}}>
							<b>Username</b>
						</td>
						<td style={{borderStyle:"none"}}>
							<input type="text" name={"username"} id={"username"} value={credentials.username} onChange={handleChange} style={{width: "300px", height:"20pt", borderStyle:"solid"}} />
						</td>
					</tr>
					<tr>
						<td style={{width: "100px", textAlign:"center", borderStyle:"none"}}>
							<b>Password</b>
						</td>
						<td style={{borderStyle:"none"}}>
							<input type="password" name={"password"} id={"password"} value={credentials.password} onChange={handleChange} style={{width: "300px", height:"20pt", borderStyle:"solid"}} />
						</td>
					</tr>
					<tr>
						<td style={{borderStyle:"none"}}>
						</td>
						<td style={{borderStyle:"none"}}>
							<button type="submit" name="login" id="login" value="LOGIN" onClick={handleSubmit} style={{width: "306px", height:"30pt"}}>Login</button>
						</td>
					</tr>
					<tr>
						<td colSpan={2}><pre>{JSON.stringify(credentials, null, 2)}</pre></td>
					</tr>
				</tbody>
			</table>
		</form>
	);
};

export default Login;