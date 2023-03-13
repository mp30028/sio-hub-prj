import React, { useEffect, useState, useRef } from 'react';
import * as DataServices from "../services/DataServices";
import * as ListenerService from "../services/ListenerService";
import * as DataHandler from "../services/DataHandler";

function List(props){
	const usersRef = useRef([]);
	const [users, setUsers]= useState([]);
	const [selectedRecord, setSelectedRecord]= useState(null);
				
	useEffect(() => {
		const onmessageHandler = (event) =>{
			var eventData = JSON.parse(event.data);
			var updatedData = null;
			console.log("eventData=",eventData);
			if(eventData.eventType === "UPDATE"){
				updatedData = DataHandler.doUpdate(usersRef.current, eventData.data);
			}else if(eventData.eventType === "DELETE"){
				updatedData = DataHandler.doDelete(usersRef.current, eventData.data);
			}else if(eventData.eventType === "CREATE"){
				updatedData = DataHandler.doCreate(usersRef.current, eventData.data);
			};
			setUsers(updatedData);
		};		
		DataServices.fetchAll().then((data) => setUsers(data));
		ListenerService.setupEventSource(onmessageHandler);
	}, [setUsers]);

	useEffect(() => {
		if (props.selectionHandler) props.selectionHandler(selectedRecord);
	}, [selectedRecord, props]);

	useEffect(() => {
		usersRef.current = users;
	},[users]);	
	
	const selectById = (id) =>{
		return users.find(u => u.id === id);	
	}
	
	const selectRecord = (event) => {
		const targetRecord = selectById(parseInt(event.target.value)) ;
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
						<td>{u.email}</td>
						<td style={{ width: "10%" }}>{u.username}</td>
						<td style={{ width: "15%" }}>{u.password}</td>
						<td style={{ width: "51pt", textAlign:"center"}}>						
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