import React, { useEffect, useState } from 'react';
import * as DataServices from "../services/DataServices";

function List(props){
	const [users, setUsers]= useState([]);
	const [selectedRecord, setSelectedRecord]= useState(null);
	
	useEffect(() => {	
		DataServices.fetchAll().then((data) => setUsers(data));		
	}, [setUsers]);
	
	useEffect(() => {	
		if (props.selectionHandler) props.selectionHandler(selectedRecord);		
	}, [selectedRecord, props]);	
	
	const findById = (id) =>{
		return users.find(u => u.id === id);	
	}
	
	const selectRecord = (event) => {
		const targetRecord = findById(parseInt(event.target.value)) ;
		if (targetRecord){
			setSelectedRecord(targetRecord);	
		}else{
			setSelectedRecord(null);
		}		  
	}
	
	const isChecked = (targetId) =>{
		return ( selectedRecord ? selectedRecord.id === targetId : false);
	}	
	
	return(
		<table className="zsft-table" style={{width: "100%"}}>
			<thead>
				<tr>
					<th>ID</th>
					<th>Firstname</th>
					<th>Lastname</th>
					<th>Email</th>
					<th>Username</th>
					<th>Password</th>
					<th>.</th>
				</tr>
			</thead>
			<tbody>
				{users.map(u =>
					<tr key={u.id}>
						<td style={{ width: "8%" }}>{u.id}</td>
						<td style={{ width: "10%" }}>{u.firstname}</td>
						<td style={{ width: "10%" }}>{u.lastname}</td>
						<td style={{ width: "10%" }}>{u.email}</td>
						<td style={{ width: "10%" }}>{u.username}</td>
						<td style={{ width: "10%" }}>{u.password}</td>
						<td style={{width: "7%", textAlign:"center"}}>
							<input 
								type="radio" 
								name={"selectRecord_" + u.id} 
								id={"selectRecord_" + u.id} 
								value={u.id} 
								onChange={selectRecord} 
								checked={isChecked(u.id)} 
							/>
							<label htmlFor={"selectRecord_" + u.id} className="ellipses">. . .</label>
						</td>
					</tr>
				)}
			</tbody>
		</table>
	);
};

export default List;