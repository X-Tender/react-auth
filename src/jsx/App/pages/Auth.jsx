import React, { useEffect } from 'react';
import { Redirect } from 'react-router-dom';
import axios from 'axios';
import Delay from 'react-delay';
import { useAuth } from '../context/auth';

function Auth(props) {
	const { authData, setAuth } = useAuth();

	useEffect(() => {
		const cancelToken = axios.CancelToken.source();

		axios
			.post('/api/ping', null, { cancelToken: cancelToken.token })
			.then(result => {
				if (result.status === 200) {
					if (result.data.error === 0) {
						setAuth(result.data.authData);
					} else {
						setAuth(null);
					}
				} else {
					setAuth(null);
				}
			})
			.catch(e => {
				if (!axios.isCancel(e)) {
					setAuth(null);
				}
			});
		return () => {
			cancelToken.cancel();
		};
	}, [setAuth]);

	const referer = props?.location?.state?.referer || '/';

	if (authData) {
		return <Redirect to={referer.pathname} />;
	}

	if (authData === null) {
		return <Redirect to={{ pathname: '/login', state: { referer } }} />;
	}

	return (
		<Delay wait={200}>
			<h1>Logging in...</h1>
		</Delay>
	);
}

export default Auth;
