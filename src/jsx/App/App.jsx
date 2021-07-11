import React, { useState } from 'react';
import { BrowserRouter as Router, Link, Route, Switch } from 'react-router-dom';
import { Provider } from 'react-redux';
import store from './redux/store';

import Home from './pages/Home';
import Admin from './pages/Admin';
import Login from './pages/Login';
import Logout from './pages/Logout';
import Projects from './pages/Projects';
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
		<Provider store={store}>
			<AuthContext.Provider value={{ authData, setAuth }}>
				<Router>
					<RootAuth>
						<UserInfo />
						<ul>
							<li>
								<Link to="/">Home Page</Link>
							</li>
							<li>
								{authData ? <Link to="/logout">Logout</Link> : <Link to="/login">Login</Link>}
							</li>
							<li>
								<Link to="/admin">Admin Page</Link>
							</li>
							<li>
								<Link to="/projects">Projects</Link>
							</li>
						</ul>
					</RootAuth>
					<Switch>
						<Route component={Home} exact path="/" />
						<Route component={Login} exact path="/login" />
						<Route component={Auth} exact path="/auth" />
						<Route component={Logout} exact path="/logout" />
						<Route component={Projects} path="/projects" />
						<PrivateRoute component={Admin} path="/admin" />
					</Switch>
				</Router>
				<p>
					<a
						href="https://github.com/X-Tender/react-auth"
						target="_blank"
						rel="noopener noreferrer"
					>
						GitHub repo
					</a>
				</p>
			</AuthContext.Provider>
		</Provider>
	);
}

export default App;
