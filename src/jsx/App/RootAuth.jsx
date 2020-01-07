import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import axios from 'axios';
import { useAuth } from './context/auth';

function RootAuth({ children }) {
	const [initAuthTest, setAuthTest] = useState(false);
	const { setAuth } = useAuth();

	useEffect(() => {
		if (!initAuthTest) {
			axios
				.post('/api/ping')
				.then(result => {
					if (result.status === 200) {
						setAuth(result.data.authData);
					} else {
						setAuth(null);
					}
				})
				.catch(e => {
					if (!axios.isCancel(e)) {
						setAuth(null);
					}
				})
				.finally(() => {
					setAuthTest(true);
				});
		}
	}, [initAuthTest, setAuth]);

	return <>{initAuthTest ? children : null}</>;
}

RootAuth.propTypes = {
	children: PropTypes.array,
};

RootAuth.defaultProps = {
	children: [],
};

export default RootAuth;
