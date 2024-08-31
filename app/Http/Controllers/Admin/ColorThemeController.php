<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorThemeStoreRequest;
use App\Models\ColorTheme;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class ColorThemeController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ColorTheme::select('*')->with('createdBy', 'updatedBy');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {
                    $type = '';
                    if ($row->type == 0) {
                        $type = '<span class="badge bg-label-success">Frontend</span>';
                    } else if ($row->type == 1) {
                        $type = '<span class="badge bg-label-primary">Admin Panel</span>';
                    }

                    if ($row->theme_status == 1) {
                        $themeStatus = '<span class="badge bg-label-success mt-2">Custom Define</span>';
                    } else {
                        $themeStatus = '<span class="badge bg-label-danger mt-2">Admin Define</span>';
                    }

                    return $type . ' ' . $themeStatus;
                })

                ->addColumn('status', function ($row) {
                    if ($row->active_status == 1) {
                        return '<span class="badge bg-label-success">Enabled</span>';
                    } else {
                        return '<span class="badge bg-label-danger">Disabled</span>';
                    }
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('active_status', $request->get('status'));
                    }
                    if ($request->get('type') != '') {
                        $instance->where('type', $request->get('type'));
                    }
                }, true)
                ->addColumn('info', function ($row) {
                    return dataInfo($row);
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';

                    // Show the "Apply" button if the theme is not default
                    if (hasPermission('color_themes_apply')) {
                        if ($row->active_status != 1) {
                            $buttons .= '<a href="javascript:0;" class="dropdown-item theme_apply_button" data-id="' . $row->id . '"><i class="ti ti-color-picker"></i> Apply</a>';
                        }
                    }

                    // Show the "Edit" button if the theme status is not 0 (Admin)
                    if (hasPermission('color_themes_update')) {
                        if ($row->theme_status != 0) {
                            $buttons .= '<a href="javascript:0;" class="dropdown-item theme_edit_button" data-bs-toggle="modal" data-bs-target="#editColorThemeModal" data-id="' . $row->id . '"><i class="ti ti-edit"></i> Edit</a>';
                        }
                    }

                    // Show the "Delete" button if the theme status is not 0 (Admin) and the theme is not default
                    if (hasPermission('color_themes_delete')) {
                        if ($row->theme_status != 0 && $row->active_status != 1) {
                            $buttons .= '<a href="javascript:0;" class="dropdown-item theme_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>';
                        }
                    }

                    if ($buttons) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">' .
                            $buttons .
                            '</div>' .
                            '</div>';
                    } else {
                        $btn = '';
                    }

                    return $btn;
                })

                ->rawColumns(['action', 'image', 'status', 'type', 'info'])
                ->make(true);
        }
        return view('setting.color-themes');
    }

    public function store(ColorThemeStoreRequest $request)
    {
        try {
            $colorTheme = new ColorTheme();
            $this->setOrUpdateColorTheme($request, $colorTheme);
            $colorTheme->theme_status = 1;
            $colorTheme->active_status = 0;
            $colorTheme->created_by = auth()->id();
            $colorTheme->save();
            Toastr::success('Color Theme Created Successfully!');
        } catch (Exception $e) {
            Toastr::error('Something Went Wrong!');
        }
        return back();
    }

    public function edit($id)
    {
        $colorTheme = ColorTheme::find($id);
        if ($colorTheme) {
            return response()->json(['data' => $colorTheme, 'status' => 200], 200);
        }
        return response()->json(['message' => "Color Theme not found"], 404);
    }

    public function update(ColorThemeStoreRequest $request)
    {
        try {
            $colorTheme = ColorTheme::find($request->themeId);
            $this->setOrUpdateColorTheme($request, $colorTheme);
            $colorTheme->updated_by = auth()->id();
            $colorTheme->update();
            Toastr::success('Color Theme Update Successfully!');
        } catch (Exception $e) {
            Toastr::error('Something Went Wrong!');
        }

        return back();
    }


    private function setOrUpdateColorTheme(ColorThemeStoreRequest $request, $colorTheme): void
    {
        $colorTheme->name                   = $request->theme_name;
        $colorTheme->type                   = $request->type;
        $colorTheme->primary_color          = $request->primary_color;
        $colorTheme->secondary_color        = $request->secondary_color;
        $colorTheme->background_color       = $request->background_color;
        $colorTheme->button_bg_color        = $request->btn_background_color;
        $colorTheme->button_text_color      = $request->btn_text_color;
        $colorTheme->hover_color            = $request->hover_color;
        $colorTheme->border_color           = $request->border_color;
        $colorTheme->text_color             = $request->text_color;
        $colorTheme->secondary_text_color   = $request->secondary_text_color;
        $colorTheme->shadow_color           = $request->shadow_color;
        $colorTheme->sidebar_bg             = $request->sidebar_background;
        $colorTheme->sidebar_hover          = $request->sidebar_hover;
    }


    public function delete(Request $request)
    {
        try {
            $colorTheme = ColorTheme::find($request->id);
            if ($colorTheme) {
                $colorTheme->delete();
            }
        } catch (Exception $e) {
            Toastr::error('Something Went Wrong!');
        }
    }

    public function applyTheme(Request $request)
    {
        $colorTheme = ColorTheme::find($request->id);
        try {
            if ($colorTheme) {
                $colorThemeType = $colorTheme->type;

                $colorThemesCollection = ColorTheme::where('type', $colorThemeType)->get();
                foreach ($colorThemesCollection as $theme) {
                    $theme->active_status = 0;
                    $theme->save();
                }

                $colorTheme->active_status = 1;
                $colorTheme->save();

                try {
                    Process::run('npm run build');
                } catch (\Throwable $th) {
                    Log::error($th);
                }

                return response()->json(['message' => 'Default Applied Successfully', 'status' => 200], 200);
            } else {
                return response()->json(['message' => 'Color Theme Not Found!', 'status' => 404], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => "Something went wrong"], 500);
        }
    }
}
