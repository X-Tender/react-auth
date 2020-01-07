import React from 'react';
import { useHistory } from 'react-router-dom';

import { Button } from '../components/AuthForms';

function Admin() {
	const history = useHistory();

	function logOut() {
		history.push('/logout');
	}

	return (
		<div>
			<div>Admin Page</div>
			<Button onClick={logOut}>Log out</Button>
		</div>
	);
}

export default Admin;
