<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileUploadTrait;
use App\Models\SpecialSection;
use App\Models\SpecialSectionDetail;
use App\Models\SpecialSectionDetailItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class SpecialSectionDetailController extends Controller
{

    use FileUploadTrait;
    public function create($section_id)
    {
        $section = SpecialSection::with('details.items')->find($section_id);

        $view = 'section.portfolio.details';
        if ($section->type == 2) {
            $view = 'section.inspiration.details';
        }
        return view($view, compact('section'));
    }

    public function store(Request $request, $section_id)
    {
        try {

            DB::beginTransaction();
            $existing_ids = SpecialSectionDetail::where('special_section_id', $section_id)->pluck('id')->toArray();
            $updated_ids = [];

            foreach ($request->section as $key => $sectionItem) {
                $section = new SpecialSectionDetail();
                $section->special_section_id = $section_id;
                $section->created_by = Auth::user()->id;
                if ($sectionItem['name'] == 'description') {
                    if ($sectionItem['id'] && $sectionItem['id'] != null && $sectionItem['id'] != 'null') {
                        $section = SpecialSectionDetail::find($sectionItem['id']);
                        array_push($updated_ids, $section->id);
                    }
                    $section->section_type = 'description';
                    $section->save();

                    $item = new SpecialSectionDetailItem();

                    if ($sectionItem['id'] && $sectionItem['id'] != null && $sectionItem['id'] != 'null') {
                        $item = SpecialSectionDetailItem::where('special_section_detail_id', $section->id)->first();
                    }

                    $item->special_section_detail_id = $section->id;
                    $item->description = $sectionItem['description'];
                    $item->save();
                }
                if ($sectionItem['name'] == 'banner_image') {

                    if ($sectionItem['id'] && $sectionItem['id'] != null && $sectionItem['id'] != 'null') {
                        $section = SpecialSectionDetail::find($sectionItem['id']);
                        array_push($updated_ids, $section->id);
                    }

                    $section->section_type = 'banner_image';
                    $section->save();

                    $item = new SpecialSectionDetailItem();
                    if ($sectionItem['id'] && $sectionItem['id'] != null && $sectionItem['id'] != 'null') {
                        $item = SpecialSectionDetailItem::where('special_section_detail_id', $section->id)->first();
                    }
                    $item->special_section_detail_id = $section->id;
                    if ($request['section'][$key]['image'] != 'undefined' && $request['section'][$key]['image'] && $request['section'][$key]['image'] != null && $request['section'][$key]['image'] != 'null') {
                        $this->deleteFile($item->image);
                        $path = $this->uploadFile($request['section'][$key]['image'], 'specialSection');
                        $item->image = $path;
                    }
                    $item->save();
                }
                if ($sectionItem['name'] == 'image_gallary') {
                    if ($sectionItem['sectionID'] && $sectionItem['sectionID'] != null && $sectionItem['sectionID'] != 'null') {
                        $section = SpecialSectionDetail::find($sectionItem['sectionID']);
                        array_push($updated_ids, $section->id);
                    }
                    $section->section_type = 'image_gallary';
                    $section->save();
                    $exiting_item_ids = SpecialSectionDetailItem::where('special_section_detail_id', $section->id)->pluck('id')->toArray();
                    $updated_item_ids = [];
                    foreach ($sectionItem['image'] as $index => $image) {
                        $item = new SpecialSectionDetailItem();
                        if ($sectionItem['id'][$index] && $sectionItem['id'][$index] != null && $sectionItem['id'][$index] != 'null') {
                            $item = SpecialSectionDetailItem::find($sectionItem['id'][$index]);
                            array_push($updated_item_ids, $item->id);
                        }
                        $item->special_section_detail_id = $section->id;
                        if ($request['section'][$key]['image'][$index] != 'undefined' && $request['section'][$key]['image'][$index] && $request['section'][$key]['image'][$index] != 'null') {
                            $this->deleteFile($item->image);
                            $path = $this->uploadFile($request['section'][$key]['image'][$index], 'specialSection');
                            $item->image = $path;
                        }
                        $item->save();
                    }
                    $result = array_diff($exiting_item_ids, $updated_item_ids);
                    $itemsToDelete = SpecialSectionDetailItem::findMany($result);

                    foreach ($itemsToDelete as $item) {
                        if ($item->image) {
                            $this->deleteFile($item->image);
                        }
                        $item->delete();
                    }
                }
                if ($sectionItem['name'] == 'image_gallary_with_details') {
                    if ($sectionItem['id'] && $sectionItem['id'] != null && $sectionItem['id'] != 'null') {
                        $section = SpecialSectionDetail::find($sectionItem['id']);
                        array_push($updated_ids, $section->id);
                    }
                    $section->section_type = 'image_gallary_with_details';
                    $section->save();
                    $exiting_item_ids = SpecialSectionDetailItem::where('special_section_detail_id', $section->id)->pluck('id')->toArray();
                    $updated_item_ids = [];
                    foreach ($sectionItem['cards'] as $index => $card) {
                        $item = new SpecialSectionDetailItem();
                        if ($card['id'] && $card['id'] != null && $card['id'] != 'null') {
                            $item = SpecialSectionDetailItem::find($card['id']);
                            array_push($updated_item_ids, $item->id);
                        }
                        $item->special_section_detail_id = $section->id;
                        $item->title = $card['title'];
                        $item->description = $card['description'];
                        if ($request['section'][$key]['cards'][$index]['image'] != 'undefined' && $request['section'][$key]['cards'][$index]['image']) {
                            $this->deleteFile($item->image);
                            $path = $this->uploadFile($request['section'][$key]['cards'][$index]['image'], 'specialSection');
                            $item->image = $path;
                        }
                        $item->save();
                    }
                    $result = array_diff($exiting_item_ids, $updated_item_ids);
                    $itemsToDelete = SpecialSectionDetailItem::findMany($result);

                    foreach ($itemsToDelete as $item) {
                        if ($item->image) {
                            $this->deleteFile($item->image);
                        }
                        $item->delete();
                    }
                }
            }
            $result = array_diff($existing_ids, $updated_ids);
            $sectionToDelete = SpecialSectionDetail::with('items')->findMany($result);

            foreach ($sectionToDelete as $section) {
                foreach ($section->items as $item) {
                    if ($item->image) {
                        $this->deleteFile($item->image);
                    }
                    $item->delete();
                }
                $section->delete();
            }
            DB::commit();

            Toastr::success('Page design Updated');

            return response()->json(['message' => 'Page Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => "Something went wrong"], 500);
        }
    }
}
