<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class PipelineController extends Controller
{
    public function index(): \Inertia\Response
    {
       $variables = $this->getVariables();

        return Inertia::render('Clients/Pipeline/Pipeline', $variables);
    }

    public function update(Request $request)
    {
        $pipelines = $request->input('pipelines');

        DB::beginTransaction();
        try {
            $existing_pipelines = $this->pipelines();

            // check if existing pipeline id not exist in request pipeline id
            $existing_pipelines->each(function ($pipeline) use ($pipelines) {
                if (!collect($pipelines)->contains('id', $pipeline->id)) {
                    $pipeline->properties()->detach();
                    $pipeline->delete();
                }
            });

            foreach ($pipelines as $key => $pipeline) {

                if (array_key_exists('id', $pipeline)){
                    $pipelineModel = \App\Models\Pipeline::find($pipeline['id']);
                } else {
                    $pipelineModel = new \App\Models\Pipeline();
                }
                $pipelineModel->name = $pipeline['name'];
                $pipelineModel->userid = auth()->user()->id;
                $pipelineModel->sort_order = $key;
                $pipelineModel->save();
            }

            // return inertia response
            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Pipeline updated successfully',
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function importLead(Request $request): array
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'pipeline_id' => 'required',
                'list_id' => 'required',
            ]);

            $pipeline_id = $request->input('pipeline_id');
            $list_id = $request->input('list_id');

            $pipeline = \App\Models\Pipeline::find($pipeline_id);
            $list = \App\Models\Lists::find($list_id);

            if ($list->added_to_pipeline) {
                return [
                    'status' => 'error',
                    'message' => 'Lead already imported',
                    'pipelines' => $this->pipelines(),
                    'lists' => $this->lists(),
                ];
            }

            if (!$pipeline || !$list) {
                return [
                    'status' => 'error',
                    'message' => 'Pipeline or list not found',
                    'pipelines' => $this->pipelines(),
                    'lists' => $this->lists(),
                ];
            }

            // get all list properties
            $list_properties = $list->properties()->get();

            // now attach all list properties to pipeline with sort order
            $list_properties->each(function ($property) use ($pipeline) {
                // check if property already exist in any pipeline
                // if exist then skip
                $pipelines = \App\Models\Pipeline::whereHas('properties', function ($q) use ($property) {
                    $q->where('property_id', $property->id);
                })->get();

                if ($pipelines->count() > 0) {
                    return;
                }

                $order = $pipeline->properties()->count();
                $pipeline->properties()->attach($property->id, ['sort_order' => $order]);
            });

            $list->added_to_pipeline = true;
            $list->save();

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Lead imported successfully',
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        }
    }


    public function orderUpdate(Request $request)
    {
        $pipelines = $request->input('pipelines');

        DB::beginTransaction();

        try {
            foreach ($pipelines as $key => $pipeline) {


                $pipelineModel = \App\Models\Pipeline::find($pipeline['id']);
                $pipelineModel->sort_order = $key;
                $pipelineModel->save();

                // detach all properties
                $pipelineModel->properties()->detach();

                $properties = $pipeline['properties'];


                foreach ($properties as $inner_key => $property) {
                    $pipelineModel->properties()->attach($property['id'], ['sort_order' => $inner_key]);
                }
            }

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Pipeline order updated successfully',
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        }

    }

    public function removeProperty(Request $request)
    {
        $properties = $request->input('properties');

        DB::beginTransaction();
        try {
            foreach ($properties as $property) {
                $pipeline = \App\Models\Pipeline::find($property['pivot']['pipeline_id']);

                $pipeline->properties()->detach($property['id']);
            }

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Property removed successfully',
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        }
    }

    public function propertyStageSwitch(Request $request)
    {
        $request->validate([
            'pipeline_id' => 'required',
            'properties' => 'required',
        ]);

        $pipeline_id = $request->input('pipeline_id');
        $properties = $request->input('properties');

        $pipeline = \App\Models\Pipeline::find($pipeline_id);

        if (!$pipeline) {
            return [
                'status' => 'error',
                'message' => 'Pipeline not found',
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        }

        DB::beginTransaction();
        try{
            foreach ($properties as $property) {
                $property = \App\Models\Properties::find($property['id']);
                $property->pipeline()->detach();
                // count total properties in pipeline
                $sort_order = $pipeline->properties()->count();

                $property->pipeline()->attach($pipeline_id, ['sort_order' => $sort_order]);
            }

            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Stage switched successfully',
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'pipelines' => $this->pipelines(),
                'lists' => $this->lists(),
            ];
        }
    }

    public function lists(): \Illuminate\Database\Eloquent\Collection|array
    {
        return \App\Models\Lists::where('userid', auth()->user()->id)
            ->where('added_to_pipeline', false)
            ->get();
    }

    public function pipelines(): \Illuminate\Database\Eloquent\Collection|array
    {
        return \App\Models\Pipeline::with('properties:id,OwnerName,PropertyAddress,OwnerEmailAddress,OwnerPhoneNumber')
            ->where('userid', auth()->user()->id)
            ->orderBy('sort_order')
            ->select('id', 'name', 'sort_order')
            ->get();
    }

    public function getVariables(): array
    {
        $lists = $this->lists();

        $pipelines = $this->pipelines();

        return [
            'lists' => $lists,
            'pipelines' => $pipelines,
        ];
    }

}
