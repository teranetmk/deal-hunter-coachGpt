<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use App\Models\ListsPropertiesAssoc;
use App\Models\ListsTagsAssoc;
use App\Models\MotivationTags;
use App\Models\Properties;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\DB;

class ListsController extends Controller
{
    public function singleList($id) {

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        // get all lists for the user
        // get all tags for the user
        $user = Auth::user();
        $allTags = (new MotivationTagsController)->getAllAvailableTagsForUser($user->id);
        $listToSend = $this->getListRowsForDisplay($user->id);

        return Inertia::render('Clients/PropertyLists', ['allMotivationTags' => $allTags, 'allLists' => $listToSend]);
    }

    public function getListRowsForDisplay($userId)
    {
        $allLists = DB::select(
            "SELECT l.id as listid, l.filename as filename, l.properties_count as properties_count, l.created_at as import_time, mt.tag_name as tag_name
FROM `lists` l
    right join lists_tags_assocs lta on l.id=lta.list_id
    left join motivation_tags mt on lta.tag_id=mt.id
where l.userid=?", [$userId]);

        $listCondensed = [];
        //$allLists = Lists::where('userid', $user->id)->get();
        foreach ($allLists as $list) {
            $listId = $list->listid;
            if (isset($listCondensed[$listId])) {
                $listCondensed[$listId]['tags'][] = $list->tag_name;
            } else {
                $listCondensed[$listId] = ['listId'           => $list->listid,
                                           'fileName'         => $list->filename,
                                           'properties_count' => $list->properties_count,
                                           'import_time'      => date_format(date_create($list->import_time), 'm/d/y'),
                                           'tags'             => [$list->tag_name]];
            }
        }

        // remove indexes
        $listToSend = [];
        foreach ($listCondensed as $lRow) {
            $listToSend[] = $lRow;
        }

        return $listToSend;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Lists $lists
     * @return \Illuminate\Http\Response
     */
    public function show(Lists $lists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Lists $lists
     * @return \Illuminate\Http\Response
     */
    public function edit(Lists $lists)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lists $lists
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lists $lists)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Lists $lists
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lists $lists)
    {
        //
    }

    public function uploadListsFile(Request $request)
    {
        //check what happens if the same list is uploaded twice -> overlooked as per client request confirmed on order chat

        if (empty($request->motivation_tags) || count($request->motivation_tags) < 0) {
            return ["status" => "error", "message" => "Please provide at least one tag for the file."];
        }

        if (empty($request->import_file) || count($request->import_file) < 1) {
            return ["status" => "error", "message" => "List File not found."];
        }

        $user = Auth::user();

        // create excelReader instance
        $fileData = $request->import_file[0];
        //todo an uploaded file is saved in this directory $_FILES["file"]["tmp_name"] and is deleted after script terminates
        // so if there is a timeout this will cause problems
        // test with a file that has a million rows
        // $extension = $fileData->extension();

        $extension = $fileData->getClientOriginalExtension();


        if(strtolower($extension) !== 'csv' && strtolower($extension) !== 'xlsx' & strtolower($extension) !== 'ods'){
            return ["status" => "error", "message" => "Only csv, xlsx and ods files are supported"];
        }
        $excelReader = SimpleExcelReader::create($fileData->path(), $extension);

        // get the header row and verify if it is expected
        $excelFileHeaders = array ('Property Address', 'Property City', 'Property State', 'Property Zip Code',
            'Owner Name', 'Owner Email Address', 'Owner Phone Number', 'Mailing Address', 'Mailing City',
            'Mailing State', 'Mailing Zip Code', 'Date Added To List');
        $headers = $excelReader->getHeaders();

        if (count(array_diff($excelFileHeaders, $headers)) > 1) {
            return ["status" => "error", "message" => 'Excel Column Names do not match. Please download the template an retry'];
        }
        // todo get row count and ensure it is within limits


        // Insert list to db
        $listCreated = Lists::create([
            'userid'           => $user->id,
            'filename'         => $fileData->getClientOriginalName(),
            'properties_count' => -1
        ]);

        if (!isset($listCreated->id)) {
            return ["status" => "error", "message" => 'There was an error while uploading the list file'];
        }
        $listId = $listCreated->id;


        // add motivation associations
        foreach ($request->motivation_tags as $tagRow) {
            ListsTagsAssoc::create(['list_id' => $listId, 'tag_id' => $tagRow['id']]);
        }

        $rejectedRows = [];
        $insertedRowCount = 0;
        $postFilterRejects = 0;

        $excelToColMapping = [
            'Property Address'    => 'PropertyAddress',
            'Property City'       => 'PropertyCity',
            'Property State'      => 'PropertyState',
            'Property Zip Code'   => 'PropertyZipCode',
            'Owner Name'          => 'OwnerName',
            'Owner Email Address' => 'OwnerEmailAddress',
            'Owner Phone Number'  => 'OwnerPhoneNumber',
            'Mailing Address'     => 'MailingAddress',
            'Mailing City'        => 'MailingCity',
            'Mailing State'       => 'MailingState',
            'Mailing Zip Code'    => 'MailingZipCode',
            'Date Added To List'  => 'DateAddedToList',

        ];


        // insert file into db
        $excelReader->getRows()
            ->filter(function (array $excelRow) use (&$rejectedRows) {
                if (
                    empty($excelRow['Property Address']) || strlen($excelRow['Property Address']) <= 0 ||
                    empty($excelRow['Property City']) || strlen($excelRow['Property City']) <= 0 ||
                    empty($excelRow['Property State']) || strlen($excelRow['Property State']) <= 0 ||
                    empty($excelRow['Property Zip Code']) || strlen($excelRow['Property Zip Code']) <= 0
                ) {
                    $rejectedRows[] = $excelRow;
                    return false;
                } else {
                    return true;
                }
            })
            ->each(function (array $excelRow) use ($user, $listId, &$insertedRowCount, &$postFilterRejects) {
                // check if property already exists
                //todo test
                $existingProperty = Properties::where('userid', $user->id)
                    ->where('PropertyAddress', $excelRow['Property Address'])
                    ->where('PropertyZipCode', $excelRow['Property Zip Code']."not")
                    ->get();
                $propertyId = 0;
                if (empty($existingProperty) || count($existingProperty) === 0) {
                    $addedProperty = Properties::create([
                        'userid'            => $user->id,
                        'PropertyAddress'   => $excelRow['Property Address'],
                        'PropertyCity'      => $excelRow['Property City'],
                        'PropertyState'     => $excelRow['Property State'],
                        'PropertyZipCode'   => $excelRow['Property Zip Code'],
                        'OwnerName'         => $excelRow['Owner Name'],
                        'OwnerEmailAddress' => $excelRow['Owner Email Address'],
                        'OwnerPhoneNumber'  => $excelRow['Owner Phone Number'],
                        'MailingAddress'    => $excelRow['Mailing Address'],
                        'MailingCity'       => $excelRow['Mailing City'],
                        'MailingState'      => $excelRow['Mailing State'],
                        'MailingZipCode'    => $excelRow['Mailing Zip Code'],
                        'DateAddedToList'   => $excelRow['Date Added To List']
                    ]);
                    // $addedProperty = new Properties;
                    // $addedProperty->userid = $user->id;
                    // $addedProperty->PropertyAddress = $excelRow['Property Address'];
                    // $addedProperty->PropertyCity = $excelRow['Property City'];
                    // $addedProperty->PropertyState = $excelRow['Property State'];
                    // $addedProperty->PropertyZipCode = $excelRow['Property Zip Code'];
                    // $addedProperty->OwnerName = $excelRow['Owner Name'];
                    // $addedProperty->OwnerEmailAddress = $excelRow['Owner Email Address'];
                    // $addedProperty->OwnerPhoneNumber = $excelRow['Owner Phone Number'];
                    // $addedProperty->MailingAddress = $excelRow['Mailing Address'];
                    // $addedProperty->MailingCity = $excelRow['Mailing City'];
                    // $addedProperty->MailingState = $excelRow['Mailing State'];
                    // $addedProperty->MailingZipCode = $excelRow['Mailing Zip Code'];
                    // $addedProperty->DateAddedToList = $excelRow['Date Added To List'];
                    // $addedProperty->save();
                    if (isset($addedProperty->id)) {
                        $propertyId = $addedProperty->id;
                    }
                } else {
                    // property already exists
                    $propertyId = $existingProperty[0]->id;
                }
                if ($propertyId === 0) {
                    $postFilterRejects = $postFilterRejects + 1;
                } else {
                    // insert property to list associations
                    $dupCheck = ListsPropertiesAssoc::where('list_id', $listId)->where('property_id', $propertyId)->get();
                    if (!$dupCheck || count($dupCheck) < 1) {
                        ListsPropertiesAssoc::create(['list_id' => $listId, 'property_id' => $propertyId]);
                        $insertedRowCount = $insertedRowCount + 1;
                    }
                }

            });

        $propertyCountRes = DB::select('select count(*) as c from lists_properties_assocs where list_id=?', [$listId]);
        if (empty($propertyCountRes) || count($propertyCountRes) <= 0) {
            // if no property was inserted rollback list insertion
            // rollback not required as user will have the option to delete a list
        } else {
            $propertyCount = $propertyCountRes[0]->c;
            Lists::where('id', $listId)->update(['properties_count' => $propertyCount]);

            $allLists = $this->getListRowsForDisplay(Auth::user()->id);
            return ['status'              => 'success',
                    'insertedRowCount'    => $insertedRowCount,
                    'rejectedCount'       => count($rejectedRows),
                    'post_filter_rejects' => $postFilterRejects,
                    'listId'              => $listId,
                    'allLists'            => $allLists
            ];
        }

    }

    public function editName(Request $request)
    {
        $request->validate([
            'listId'   => 'required|integer|min:1',
            'fileName' => 'required|string|max:255',
        ]);
        Lists::where('id', $request->listId)->update(['filename' => $request->fileName]);
        $updatedRow = Lists::where('id', $request->listId)->first();
        return ['status' => 'success', 'message' => 'Saved!', 'newName' => $updatedRow['filename']];
    }

    public function editTags(Request $request)
    {

        if (empty($request->tagRows) || count($request->tagRows) <= 0) {
            return ['status' => 'error', 'message' => 'At least one tag is required'];
        }

        if (empty($request->listId) || $request->listId <= 0) {
            return ['status' => 'error', 'message' => 'List not found'];
        }

        ListsTagsAssoc::where('list_id', $request->listId)->delete();
        foreach ($request->tagRows as $tagRow) {
            ListsTagsAssoc::create(['list_id' => $request->listId, 'tag_id' => $tagRow['id']]);
        }

        $newTagRes = DB::select("select mt.tag_name from lists_tags_assocs lta
    left join motivation_tags mt on lta.tag_id = mt.id where list_id=?", [$request->listId]);

        $newTags = array_map(function ($tg) {
            return $tg->tag_name;
        }, $newTagRes);

        return ['status' => 'success', 'message' => 'Tags Updated!', 'newTags' => $newTags];

    }

    public function deleteList(Request $request)
    {
        if (empty($request->listId) || $request->listId <= 0) {
            return ['status' => 'error', 'message' => 'List not found'];
        }


        $numberOfPropertiesDeleted = 0;


        // No two users can have the same property even if they are the same (check uploading lists)

        // get property associations
        // $propertiesInList = ListsPropertiesAssoc::where('list_id', $request->listId)->get();
        // foreach ($propertiesInList as $propertyListAssoc) {

        //     // check property is not in any other list
        //     $samePropertyInOtherLists = ListsPropertiesAssoc::where('property_id', $propertyListAssoc->property_id)
        //         ->where('list_id', '<>', $request->listId)->get();

        //     if (empty($samePropertyInOtherLists) || count($samePropertyInOtherLists) <= 0) {
        //         // these properties have to be deleted
        //         DB::delete('delete from properties where id=?', [$propertyListAssoc->property_id]);
        //         $numberOfPropertiesDeleted++;
        //     }

        //     // delete property association regardless of whether property was deleted or not
        //     DB::delete('delete from lists_properties_assocs where property_id=? and list_id=?', [$propertyListAssoc->property_id, $request->listId]);
        // }

        $ids = DB::table('lists_properties_assocs')->where('list_id', $request->listId)->pluck('property_id');

        DB::table('lists_properties_assocs')->where('list_id', $request->listId)->delete();
        DB::table('properties')->whereIn('id', $ids)->delete();
        DB::table('lists_tags_assocs')->where('list_id', $request->listId)->delete();

        // return $ids;

        // DB::delete('delete from lists_properties_assocs where property_id=? and list_id=?', [$propertyListAssoc->property_id, $request->listId]);

        // DB::delete('delete from properties where id=?', [$propertyListAssoc->property_id]);
        // delete tag Associations
        // DB::delete('delete from lists_tags_assocs where list_id=?', [$request->listId]);

        // delete list
        DB::delete('delete from lists where id=?', [$request->listId]);


        return ['status' => 'success', 'message' => 'List deleted successfully', 'lists' => $listToSend = $this->getListRowsForDisplay(auth()->user()->id)];

    }
}
