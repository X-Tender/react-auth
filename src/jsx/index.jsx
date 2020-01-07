import { setConfig } from 'react-hot-loader';

import 'core-js/stable';
import 'regenerator-runtime/runtime';
import React from 'react';
import ReactDOM from 'react-dom';

import App from './App/App';

setConfig({
	reloadHooks: false,
});

if (module.hot) {
	module.hot.accept();
}

const targetDOM = document.getElementById('app-root');
if (targetDOM) ReactDOM.render(<App />, targetDOM);
