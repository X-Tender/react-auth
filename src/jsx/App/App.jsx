import React, { useState } from 'react';
import { BrowserRouter as Router, Link, Route } from 'react-router-dom';
import Home from './pages/Home';
import Admin from './pages/Admin';
import Login from './pages/Login';
import Logout from './pages/Logout';
import Auth from './pages/Auth';
import { AuthContext } from './context/auth';
import PrivateRoute from './PrivateRoute';
import RootAuth from './RootAuth';

function App() {
	const [authData, setAuthData] = useState();

	const setAuth = data => {
		setAuthData(data);
	};

	const UserInfo = () => {
		if (!authData) return null;
		return <p>Hallo {authData.email}</p>;
	};

	return (
		<AuthContext.Provider value={{ authData, setAuth }}>
			<Router>
				<RootAuth>
					<UserInfo />
					<ul>
						<li>
							<Link to="/">Home Page</Link>
						</li>
						<li>{authData ? <Link to="/logout">Logout</Link> : <Link to="/login">Login</Link>}</li>
						<li>
							<Link to="/admin">Admin Page</Link>
						</li>
					</ul>
				</RootAuth>

				<Route component={Home} exact path="/" />
				<Route component={Login} exact path="/login" />
				<Route component={Auth} exact path="/auth" />
				<Route component={Logout} exact path="/logout" />
				<PrivateRoute component={Admin} path="/admin" />
			</Router>
		</AuthContext.Provider>
	);
}

export default App;
