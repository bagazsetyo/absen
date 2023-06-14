<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): mixed
    {
        if(request()->ajax()){
            $data = Permission::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="float-end">';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.angkatan.edit', $row->id).'"
                                data-title="Ubah Group"
                                data-bs-toggle="modal"
                                data-bs-target="#modal"
                                class="btn btn-primary btn-sm"
                                style="margin-right: 3px;">Edit</a>';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.angkatan.destroy', $row->id).'"
                                data-title="Hapus Group"
                                data-table="group"
                                data-bs-toggle="modal"
                                data-bs-target="#danger"
                                class="btn btn-danger btn-sm hapus"
                                style="margin-right: 3px;">Hapus</a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('permissions', function($data) {
                    return $data->permissions->pluck('name')->implode(', ');
                })
                ->rawColumns(['action', 'permissions'])
                ->make(true);
        }
        return view('pages.admin.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permission = Permission::select('name')->get()->pluck('name')->toArray();
        $routeCollection = Route::getRoutes();
        $routeList = [];
        foreach ($routeCollection as $route) {
            $actionName = $route->getActionName();
            if (strpos($actionName, 'App\Http\Controllers') !== false && strpos($actionName, 'App\Http\Controllers\Auth') !== 0) {
                list($controller, $action) = explode('@', $actionName);
                $controllerName = strtolower(str_replace(['App\Http\Controllers\\', 'Controller'], '', $controller));
                $controllerName = str_replace('\\', '.', $controllerName);
                $uniqueCode = $controllerName . '.' . $action;
                $controllerAction = str_replace(['App\Http\Controllers\\', '\\'], ['', '.'], $actionName);
        
                $routeList[$controllerName][$uniqueCode] = [
                    'name' => $route->getName(),
                    'method' => $route->methods[0],
                    'controller' => $controller,
                    'fullcontroller' => $actionName,
                    'controller_action' => $controllerAction,
                    'uniqueCode' => $uniqueCode,
                    'action' => $action,
                    'uri' => $route->uri,
                ];
            }
        }
        
        return view('pages.admin.permission.create')->with([
            'routeList' => $routeList,
            'permission' => $permission,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $permissions = $request->permissions;
        $data = [];
        foreach ($permissions as $permission) {
            $data[] = [
                'name' => $permission,
                'guard_name' => 'web',
            ];
        }
        Permission::insert($data);

        return redirect()->route('admin.permission.index')->with('success', 'Permission berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
