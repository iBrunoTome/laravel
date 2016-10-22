<?php

	namespace CodeProject\Transformers;

	use CodeProject\Entities\Project;
	use League\Fractal\TransformerAbstract;

	class ProjectTransformer extends TransformerAbstract {
		public function transform(Project $project) {
			return [
				'project_id'  => $project->id,
				'project'     => $project,
				'description' => $project->description,
				'progress'    => $project->project,
				'status'      => $project->status,
				'due_date'    => $project->due_date
			];
		}
	}