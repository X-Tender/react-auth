export const GET_PROJECTS_COMPLETE = 'projects/GET_PROJECTS_COMPLETE';
export const GET_PROJECT_COMPLETE = 'projects/GET_PROJECT_COMPLETE';

const initialState = {
	loaded: false,
	projects: null,
	projectDetails: {},
};

/* ACTION */

export const getProjects = () => dispatch => {
	fetch('api/projects')
		.then(response => response.json())
		.then(response => {
			dispatch({
				type: GET_PROJECTS_COMPLETE,
				payload: response,
			});
		});
};

export const getProject = id => dispatch => {
	fetch(`api/project/${id}`)
		.then(response => response.json())
		.then(response => {
			dispatch({
				type: GET_PROJECT_COMPLETE,
				payload: response,
			});
		});
};

/* REDUCERS */

const reduceProjects = (state, payload) => {
	return {
		...state,
		projects: payload,
		loaded: true,
	};
};

const reduceProject = (state, payload) => {
	return {
		...state,
		projectDetails: { ...state.projectDetails, [payload.id]: payload },
		loaded: true,
	};
};

export default (state = initialState, action) => {
	const { type, payload } = action;

	switch (type) {
		case GET_PROJECTS_COMPLETE:
			return reduceProjects(state, payload);
		case GET_PROJECT_COMPLETE:
			return reduceProject(state, payload);
		default:
			return state;
	}
};
