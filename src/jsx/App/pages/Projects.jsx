import React, { useEffect } from 'react';
import { Switch, Link, Route, useRouteMatch } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import Project from './Project';
import { getProjects } from 'App/redux/reducers/projects';

function ProjectPage() {
	const { projects } = useSelector(state => state.projects);
	return (
		<div>
			<h1>Projects</h1>
			<ul>
				{projects.map(project => (
					<li key={project.id}>
						<Link to={`/projects/project/${project.id}`}>{project.name}</Link>
					</li>
				))}
			</ul>
		</div>
	);
}

function Projects() {
	let { path } = useRouteMatch();
	const dispatch = useDispatch();
	const { projects } = useSelector(state => state.projects);

	useEffect(() => {
		dispatch(getProjects());
	}, []);

	if (projects == null) return <h1>LOADING</h1>;

	return (
		<div>
			<Switch>
				<Route component={ProjectPage} exact path={`${path}`} />
				<Route component={Project} path={`${path}/project/:id`} />
			</Switch>
		</div>
	);
}

export default Projects;
