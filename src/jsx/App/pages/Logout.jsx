import React, { useEffect } from 'react';
import { Redirect } from 'react-router-dom';
import axios from 'axios';
import { useAuth } from '../context/auth';

function Logout() {
	const { authed, setAuth } = useAuth();

	useEffect(() => {
		axios
			.post('/api/logout')
			.then(() => setAuth())
			.catch(e => setAuth());
	}, [setAuth]);

	if (!authed) {
		return <Redirect to="/" />;
	}

	return null;
}

export default Logout;
