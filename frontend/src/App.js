import * as React from 'react';
import { Routes, Route, NavLink, Outlet } from 'react-router-dom';
import AppHome from "./Home";
import UsersLayout from "./users/Layout";
const App = () => {	return (
		<>
		    <h1>SIO-Hub-UI</h1>
		    
			<nav>
				<NavLink to="/" >Home</NavLink><br/>
				<NavLink to="/users">User Management</NavLink><br />
			</nav>

			<Routes>
				<Route path="/" element={<AppHome />} />
				<Route index element={<AppHome />} />
				<Route path="users" element={<UsersLayout />} />
				<Route path="*" element={<p>There's nothing here: 404!</p>} />
			</Routes>
			
			<main>
				<Outlet />
			</main>
		</>
	);
};

export default App;