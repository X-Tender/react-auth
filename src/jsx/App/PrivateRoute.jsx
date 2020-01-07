import React from 'react';
import PropTypes from 'prop-types';
import { Route, Redirect } from 'react-router-dom';
import { useAuth } from './context/auth';

function PrivateRoute({ component: Component, ...rest }) {
	const { authData } = useAuth();

	return (
		<Route
			{...rest}
			render={props =>
				authData ? (
					<Component {...props} />
				) : (
					<Redirect to={{ pathname: '/auth', state: { referer: props.location } }} />
				)
			}
		/>
	);
}

PrivateRoute.propTypes = {
	component: PropTypes.func.isRequired,
	location: PropTypes.string,
};

PrivateRoute.defaultProps = {
	location: null,
};

export default PrivateRoute;
