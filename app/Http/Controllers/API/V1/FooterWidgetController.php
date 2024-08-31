<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Page;
use App\Models\FooterWidget;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageDetailResource;
use App\Http\Resources\FooterWidgetResource;

class FooterWidgetController extends Controller
{
    public function widgets()
    {
        $widgets = FooterWidget::with(['pages'=>function($query){
            $query->where('user_id',getDesignerID())->where('active_status',1);
        }])->where('active_status',1)->orderBy('serial','ASC')->get();
        return sendResponse('Footer Widget list', FooterWidgetResource::collection($widgets)->resource);
    }
    // pageDetails
    public function pageDetails($slug)
    {
        $page = Page::where('slug',$slug)->where('user_id',getDesignerID())->where('active_status',1)->first();


        if($page){
            return sendResponse('Page Details', new PageDetailResource($page));
        }else{
            return sendError('Page not found');
        }

    }
}
