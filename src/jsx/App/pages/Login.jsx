import React, { useState } from 'react';
import { Redirect } from 'react-router-dom';
import axios from 'axios';
import { Card, Form, Input, Button, Error } from '../components/AuthForms';
import { useAuth } from '../context/auth';

function Login(props) {
	const [isError, setIsError] = useState(false);
	const [email, setEmail] = useState('');
	const [password, setPassword] = useState('');
	const { authData, setAuth } = useAuth();

	const referer = props?.location?.state?.referer || '/';

	function login() {
		axios
			.post('/api/login', {
				email,
				password,
			})
			.then(result => {
				if (result.status === 200) {
					if (result.data.error === 0 && result.data.authData) {
						setAuth(result.data.authData);
					} else {
						setIsError(true);
					}
				} else {
					setIsError(true);
				}
			})
			.catch(e => {
				setIsError(true);
			});
	}

	if (authData) {
		return <Redirect to={referer} />;
	}

	return (
		<Card>
			<Form>
				<Input
					onChange={e => {
						setEmail(e.target.value);
					}}
					placeholder="email"
					type="email"
					value={email}
				/>
				<Input
					onChange={e => {
						setPassword(e.target.value);
					}}
					placeholder="Password"
					type="password"
					value={password}
				/>
				<Button onClick={login} type="button">
					Log In
				</Button>
			</Form>
			{isError && <Error>Email or password are incorrect.</Error>}
		</Card>
	);
}

export default Login;
