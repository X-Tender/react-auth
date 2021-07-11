import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { getProject } from 'App/redux/reducers/projects';

function ProjectsDropdown() {
	const { id } = useParams();
	const { projects } = useSelector(state => state.projects);

	return (
		<select defaultValue={id}>
			{projects.map(project => {
				return (
					<option key={project.id} value={project.id}>
						{project.name}
					</option>
				);
			})}
		</select>
	);
}

function ProjectDetails() {
	const { id } = useParams();
	const dispatch = useDispatch();
	const { projectDetails } = useSelector(state => state.projects);

	useEffect(() => {
		dispatch(getProject(id));
	}, [id]);

	if (!projectDetails[id]) return <h1>Loading project: {id}</h1>;

	const details = projectDetails[id];
	return (
		<div>
			<h1>{details.name}</h1>
			<p>{details.description}</p>
		</div>
	);
}

function Project() {
	return (
		<div>
			<ProjectsDropdown />
			<ProjectDetails />
		</div>
	);
}

export default Project;
